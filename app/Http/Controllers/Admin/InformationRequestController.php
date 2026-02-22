<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\InformationRequest;
use App\Models\InformationFollowup;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class InformationRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = InformationRequest::with('followups')->latest();

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search')) {
            $query->search($request->search);
        }

        $requests = $query->paginate(20);
        
        $stats = [
            'submitted' => InformationRequest::where('status', 'submitted')->count(),
            'verified' => InformationRequest::where('status', 'verified')->count(),
            'processed' => InformationRequest::where('status', 'processed')->count(),
            'completed' => InformationRequest::where('status', 'completed')->count(),
            'rejected' => InformationRequest::where('status', 'rejected')->count(),
        ];

        return view('admin.information.requests.index', compact('requests', 'stats'));
    }

    public function show($id)
    {
        $request = InformationRequest::with('followups')->findOrFail($id);
        return view('admin.information.requests.show', compact('request'));
    }

    public function updateStatus(Request $request, $id)
{
    $informationRequest = InformationRequest::findOrFail($id);

    $validated = $request->validate([
        'status' => 'required|in:submitted,verified,processed,ready,completed,rejected',
        'description' => 'required|string',
        'rejection_reason' => 'nullable|required_if:status,rejected|string',
        'admin_notes' => 'nullable|string'
    ]);

    // Update status
    $informationRequest->update([
        'status' => $validated['status'],
        'rejection_reason' => $validated['rejection_reason'] ?? null,
        'admin_notes' => $validated['admin_notes'] ?? null,
        'processed_at' => in_array($validated['status'], ['processed', 'ready', 'completed']) && !$informationRequest->processed_at 
            ? now() 
            : $informationRequest->processed_at,
        'completed_at' => $validated['status'] == 'completed' 
            ? now() 
            : null
    ]);

    // Create followup - GUNAKAN RELASI (Lebih Aman)
    try {
        $informationRequest->followups()->create([
            'status' => $validated['status'],
            'description' => $validated['description'],
            'updated_by' => auth()->user()->name ?? 'System'
        ]);
    } catch (\Exception $e) {
        // Jika gagal, log error tapi tetap lanjut
        Log::error('Failed to create followup: ' . $e->getMessage());
    }

    return redirect()->route('admin.information-requests.show', $id)
        ->with('success', 'Status permohonan berhasil diupdate');
}

    public function uploadResult(Request $request, $id)
    {
        $informationRequest = InformationRequest::findOrFail($id);

        $request->validate([
            'result_file' => 'required|file|mimes:pdf,doc,docx,zip|max:10240'
        ]);

        // Delete old file if exists
        if ($informationRequest->result_file && Storage::disk('public')->exists($informationRequest->result_file)) {
            Storage::disk('public')->delete($informationRequest->result_file);
        }

        // Upload new file
        $path = $request->file('result_file')->store('information-results', 'public');

        $informationRequest->update([
            'result_file' => $path,
            'status' => 'ready'
        ]);

        // Create followup - FIXED: Added information_request_id
        InformationFollowup::create([
            'information_request_id' => $informationRequest->id,  // FIX: Menambahkan ID permohonan
            'status' => 'ready',
            'description' => 'File hasil permohonan informasi telah diupload dan siap diambil',
            'updated_by' => auth()->user()->name
        ]);

        return redirect()->route('admin.information-requests.show', $id)
            ->with('success', 'File hasil berhasil diupload');
    }

    public function destroy($id)
    {
        $informationRequest = InformationRequest::findOrFail($id);

        // Delete files
        if ($informationRequest->id_card_file && Storage::disk('public')->exists($informationRequest->id_card_file)) {
            Storage::disk('public')->delete($informationRequest->id_card_file);
        }
        if ($informationRequest->result_file && Storage::disk('public')->exists($informationRequest->result_file)) {
            Storage::disk('public')->delete($informationRequest->result_file);
        }

        $informationRequest->delete();

        return redirect()->route('admin.information-requests.index')
            ->with('success', 'Permohonan informasi berhasil dihapus');
    }

    public function export(Request $request)
    {
        // Export to Excel/CSV functionality
        // You can use Laravel Excel package here
        
        return back()->with('info', 'Fitur export sedang dalam pengembangan');
    }
}