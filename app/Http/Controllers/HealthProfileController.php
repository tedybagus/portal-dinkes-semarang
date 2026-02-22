<?php

namespace App\Http\Controllers;

use App\Models\HealthProfile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class HealthProfileController extends Controller
{
    /**
     * Display a listing of health profiles.
     */
    public function index()
    {
        $profiles = HealthProfile::where('is_active', true)
            ->orderBy('year', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('health-profiles.index', compact('profiles'));
    }

    /**
     * Download health profile file.
     */
    public function download($id)
    {
        $profile = HealthProfile::findOrFail($id);

        // Increment download count
        $profile->increment('download_count');

        // Check if file exists
        if (!Storage::disk('public')->exists($profile->file_path)) {
            return back()->with('error', 'File tidak ditemukan. Silakan hubungi administrator.');
        }

        // Get file path
        $filePath = Storage::disk('public')->path($profile->file_path);

        // Check if file is readable
        if (!file_exists($filePath) || !is_readable($filePath)) {
            return back()->with('error', 'File tidak dapat dibaca. Silakan hubungi administrator.');
        }

        // Generate safe filename
        $fileName = $this->sanitizeFilename($profile->name) . '.' . $profile->file_type;

        // Return file download response
        return response()->download($filePath, $fileName, [
            'Content-Type' => $this->getMimeType($profile->file_type),
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    /**
     * Sanitize filename for safe download.
     */
    private function sanitizeFilename($filename)
    {
        // Remove special characters and replace spaces with underscores
        $filename = preg_replace('/[^A-Za-z0-9\-\_\s]/', '', $filename);
        $filename = str_replace(' ', '_', $filename);
        $filename = preg_replace('/_+/', '_', $filename); // Remove multiple underscores
        
        return trim($filename, '_');
    }

    /**
     * Get MIME type based on file extension.
     */
    private function getMimeType($extension)
    {
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        ];

        return $mimeTypes[strtolower($extension)] ?? 'application/octet-stream';
    }
}