<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PpidCategory;
use App\Models\PpidDownloadLog;
use App\Models\PpidInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class PpidPublicController extends Controller
{
    /**
     * Icon mapping for categories
     */
    private function getCategoryIcon($slug)
    {
        $icons = [
            'berkala' => 'fa-calendar-alt',
            'serta-merta' => 'fa-exclamation-triangle',
            'setiap-saat' => 'fa-clock',
            'dikecualikan' => 'fa-lock'
        ];

        return $icons[$slug] ?? 'fa-folder-open';
    }

    /**
     * Halaman daftar informasi publik
     */
    public function index(Request $request)
    {
        $query = PpidInformation::with('category')->public()->latest();

        // Filter by category
        if ($request->has('category') && $request->category != 'all') {
            $categorySlug = $request->category;
            $query->whereHas('category', function($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // Filter by year
        if ($request->has('year') && $request->year != 'all') {
            $query->where('year', $request->year);
        }

        // Search
        if ($request->has('search') && !empty($request->search)) {
            $query->search($request->search);
        }

        $informations = $query->paginate(15);
        
        $categories = PpidCategory::active()->ordered()->withCount(['informations' => function($q) {
            $q->where('is_public', true);
        }])->get();

        // Add icon to each category
        foreach ($categories as $category) {
            $category->icon = $this->getCategoryIcon($category->slug);
        }

        $years = PpidInformation::public()->distinct()->orderBy('year', 'desc')->pluck('year');

        return view('ppid.index', compact('informations', 'categories', 'years'));
    }

    /**
     * Detail informasi publik
     */
    public function show($id)
    {
        $information = PpidInformation::with('category')->public()->findOrFail($id);
        
        // Add icon to category
        $information->category->icon = $this->getCategoryIcon($information->category->slug);
        
        // Increment view count
        $information->incrementViewCount();

        // Get related informations
        $relatedInformations = PpidInformation::public()
            ->where('ppid_category_id', $information->ppid_category_id)
            ->where('id', '!=', $information->id)
            ->latest()
            ->take(5)
            ->get();

        return view('ppid.show', compact('information', 'relatedInformations'));
    }

    /**
     * Download file informasi
     */
    public function download($id)
    {
        $information = PpidInformation::public()->findOrFail($id);

        // Check if file exists
        if (!$information->file_path) {
            return redirect()->back()->with('error', 'File tidak tersedia untuk informasi ini.');
        }

        // Check if file exists in storage
        if (!Storage::disk('public')->exists($information->file_path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan di server. Silakan hubungi administrator.');
        }

        try {
            // Log download
            PpidDownloadLog::create([
                'ppid_information_id' => $information->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);

            // Increment download count
            $information->incrementDownloadCount();

            // Get file path
            $filePath = Storage::disk('public')->path($information->file_path);
            
            // Get original filename with extension
            $extension = pathinfo($information->file_path, PATHINFO_EXTENSION);
            $fileName = Str::slug($information->title) . '.' . $extension;

            // Download file
            return response()->download($filePath, $fileName, [
                'Content-Type' => Storage::disk('public')->mimeType($information->file_path),
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
            ]);

        } catch (\Exception $e) {
            Log::error('PPID Download Error: ' . $e->getMessage(), [
                'information_id' => $id,
                'file_path' => $information->file_path
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat download file. Silakan coba lagi.');
        }
    }

    /**
     * Halaman by category
     */
    public function byCategory($slug)
    {
        $category = PpidCategory::where('slug', $slug)->active()->firstOrFail();
        
        // Add icon to category
        $category->icon = $this->getCategoryIcon($category->slug);
        
        $query = PpidInformation::with('category')
            ->public()
            ->where('ppid_category_id', $category->id)
            ->latest();

        // Filter by year if provided
        if (request()->has('year') && !empty(request('year'))) {
            $query->where('year', request('year'));
        }

        $informations = $query->paginate(15);

        $categories = PpidCategory::active()->ordered()->withCount(['informations' => function($q) {
            $q->where('is_public', true);
        }])->get();

        // Add icon to each category
        foreach ($categories as $cat) {
            $cat->icon = $this->getCategoryIcon($cat->slug);
        }

        return view('ppid.by-category', compact('category', 'informations', 'categories'));
    }
}