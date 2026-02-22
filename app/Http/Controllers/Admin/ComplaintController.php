<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ComplaintStatusUpdated;
use App\Models\Complaint;
use App\Models\ComplaintHistory;
use App\Models\ComplaintService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    /**
     * Display complaints dashboard & list
     */
    public function index(Request $request)
    {
        // Statistics
        $stats = [
            'total' => Complaint::count(),
            'submitted' => Complaint::where('status', 'submitted')->count(),
            'verified' => Complaint::where('status', 'verified')->count(),
            'in_progress' => Complaint::where('status', 'in_progress')->count(),
            'resolved' => Complaint::where('status', 'resolved')->count(),
            'closed' => Complaint::where('status', 'closed')->count(),
            'rejected' => Complaint::where('status', 'rejected')->count(),
            'avg_rating' => Complaint::whereNotNull('satisfaction_rating')->avg('satisfaction_rating'),
        ];

        // Query builder
        $query = Complaint::with(['service', 'histories'])
            ->orderBy('created_at', 'desc');

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('service')) {
            $query->where('complaint_service_id', $request->service);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('reporter_name', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('reporter_phone', 'like', "%{$search}%");
            });
        }

        $complaints = $query->paginate(15);
        $services = ComplaintService::all();

        return view('admin.complaints.index', compact('complaints', 'stats', 'services'));
    }

    /**
     * Show complaint detail
     */
    public function show($id)
    {
        $complaint = Complaint::with(['service', 'histories'])
            ->findOrFail($id);

        return view('admin.complaints.show', compact('complaint'));
    }

    /**
     * Update complaint status
     */
    public function updateStatus(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);
        $oldStatus = $complaint->status;

        $validated = $request->validate([
            'status' => 'required|in:submitted,verified,in_progress,resolved,closed,rejected',
            'admin_notes' => 'nullable|string',
            'response' => 'nullable|string',
            'response_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'assigned_to' => 'nullable|string|max:255',
        ]);

        // Handle response file upload
        if ($request->hasFile('response_file')) {
            // Delete old file if exists
            if ($complaint->response_file) {
                Storage::disk('public')->delete($complaint->response_file);
            }
            
            $validated['response_file'] = $request->file('response_file')
                ->store('complaint-responses', 'public');
        }

        // Set timestamps based on status
        if ($validated['status'] === 'verified' && !$complaint->verified_at) {
            $validated['verified_at'] = now();
        }

        if ($validated['status'] === 'resolved' && !$complaint->resolved_at) {
            $validated['resolved_at'] = now();
        }

        if ($validated['status'] === 'closed' && !$complaint->closed_at) {
            $validated['closed_at'] = now();
        }

        // Update complaint
        $complaint->update($validated);

        // Create history
        $statusLabels = [
            'submitted' => 'Diajukan',
            'verified' => 'Diverifikasi',
            'in_progress' => 'Sedang Diproses',
            'resolved' => 'Diselesaikan',
            'closed' => 'Ditutup',
            'rejected' => 'Ditolak'
        ];

        $description = 'Status diubah dari "' . $statusLabels[$oldStatus] . '" ke "' . $statusLabels[$validated['status']] . '"';
        
        if (!empty($validated['response'])) {
            $description .= '. Tanggapan: ' . substr($validated['response'], 0, 100);
        }

        ComplaintHistory::create([
            'complaint_id' => $complaint->id,
            'status' => $validated['status'],
            'description' => $description,
            'updated_by' => auth()->user()->name ?? 'Admin'
        ]);

        // Send email notification
        if ($complaint->reporter_email) {
            try {
                Mail::to($complaint->reporter_email)
                    ->send(new ComplaintStatusUpdated($complaint, $oldStatus));
                
                Log::info('Status update email sent to: ' . $complaint->reporter_email);
            } catch (\Exception $e) {
                Log::error('Email notification failed: ' . $e->getMessage());
            }
        }

        return redirect()->back()
            ->with('success', 'Status pengaduan berhasil diupdate!');
    }

    /**
     * Quick status update
     */
    public function quickStatus(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);
        $oldStatus = $complaint->status;

        $validated = $request->validate([
            'status' => 'required|in:submitted,verified,in_progress,resolved,closed,rejected'
        ]);

        $complaint->update(['status' => $validated['status']]);

        // Create history
        ComplaintHistory::create([
            'complaint_id' => $complaint->id,
            'status' => $validated['status'],
            'description' => 'Status diubah ke ' . $complaint->status_label,
            'updated_by' => auth()->user()->name ?? 'Admin'
        ]);

        return redirect()->back()
            ->with('success', 'Status berhasil diupdate!');
    }

    /**
     * Delete complaint
     */
    public function destroy($id)
    {
        $complaint = Complaint::findOrFail($id);

        // Delete files
        if ($complaint->evidence_file) {
            Storage::disk('public')->delete($complaint->evidence_file);
        }

        if ($complaint->response_file) {
            Storage::disk('public')->delete($complaint->response_file);
        }

        // Delete complaint (histories will cascade)
        $complaint->delete();

        return redirect()->route('admin.complaints.index')
            ->with('success', 'Pengaduan berhasil dihapus!');
    }

    /**
     * Export complaints to Excel
     */
    public function export(Request $request)
    {
        // You can use Laravel Excel package here
        // For now, return CSV
        
        $query = Complaint::with('service');

        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('service')) {
            $query->where('complaint_service_id', $request->service);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $complaints = $query->get();

        $filename = 'complaints_export_' . date('YmdHis') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($complaints) {
            $file = fopen('php://output', 'w');

            // Header
            fputcsv($file, [
                'Nomor Tiket',
                'Tanggal',
                'Layanan',
                'Nama Pelapor',
                'No HP',
                'Email',
                'Subjek',
                'Status',
                'Prioritas',
                'Rating'
            ]);

            // Data
            foreach ($complaints as $complaint) {
                fputcsv($file, [
                    $complaint->ticket_number,
                    $complaint->created_at->format('Y-m-d H:i'),
                    $complaint->service->name,
                    $complaint->reporter_name,
                    $complaint->reporter_phone,
                    $complaint->reporter_email,
                    $complaint->subject,
                    $complaint->status_label,
                    $complaint->priority_label,
                    $complaint->satisfaction_rating ?? '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Dashboard statistics
     */
    public function dashboard()
    {
        $stats = [
            'total' => Complaint::count(),
            'today' => Complaint::whereDate('created_at', today())->count(),
            'this_week' => Complaint::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month' => Complaint::whereMonth('created_at', now()->month)->count(),
            
            'by_status' => Complaint::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status'),
            
            'by_priority' => Complaint::selectRaw('priority, COUNT(*) as count')
                ->groupBy('priority')
                ->pluck('count', 'priority'),
            
            'by_service' => Complaint::with('service')
                ->selectRaw('complaint_service_id, COUNT(*) as count')
                ->groupBy('complaint_service_id')
                ->get(),
            
            'avg_resolution_days' => Complaint::whereNotNull('resolved_at')
                ->selectRaw('AVG(DATEDIFF(resolved_at, created_at)) as avg_days')
                ->value('avg_days'),
            
            'satisfaction_rate' => Complaint::whereNotNull('satisfaction_rating')
                ->avg('satisfaction_rating'),
            
            'recent_complaints' => Complaint::with('service')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get(),
        ];

        return view('admin.complaints.dashboard', compact('stats'));
    }
}