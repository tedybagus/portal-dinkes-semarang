<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ComplaintSubmitted;
use App\Models\Complaint;
use App\Models\ComplaintFlow;
use App\Models\ComplaintHistory;
use App\Models\ComplaintService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ComplaintPublicController extends Controller
{
    /**
     * Halaman layanan pengaduan
     */
    public function services()
    {
        $services = ComplaintService::active()
            ->ordered()
            ->withCount('complaints')
            ->get();
        
        return view('public.complaints.services', compact('services'));
    }

    /**
     * Enhanced tracking with multiple search options
     */
    public function track(Request $request, $ticketNumber = null)
    {
        $complaint = null;
        $complaints = collect();
        
        if ($ticketNumber) {
            $complaint = Complaint::with(['service', 'histories'])
                ->where('ticket_number', $ticketNumber)
                ->first();
            
            if ($complaint) {
                $complaints = collect([$complaint]);
            }
        }
        
        return view('public.complaints.track', compact('complaint', 'complaints'));
    }

    /**
     * Enhanced search with multiple methods
     */
    public function search(Request $request)
    {
        $searchType = $request->search_type ?? 'ticket';
        $complaints = collect();
        
        if ($searchType === 'ticket') {
            // Search by ticket number
            $request->validate([
                'ticket_number' => 'required|string'
            ]);

            $ticketNumber = strtoupper(trim($request->ticket_number));
            
            $complaint = Complaint::with(['service', 'histories'])
                ->where('ticket_number', $ticketNumber)
                ->first();
            
            if ($complaint) {
                $complaints = collect([$complaint]);
            }
            
        } elseif ($searchType === 'phone') {
            // Search by phone number
            $request->validate([
                'phone' => 'required|string'
            ]);
            
            $phone = trim($request->phone);
            
            $complaints = Complaint::with(['service', 'histories'])
                ->where('reporter_phone', 'like', '%' . $phone . '%')
                ->orderBy('created_at', 'desc')
                ->get();
                
        } elseif ($searchType === 'nik') {
            // Search by NIK
            $request->validate([
                'nik' => 'required|string|size:16'
            ]);
            
            $nik = trim($request->nik);
            
            $complaints = Complaint::with(['service', 'histories'])
                ->where('reporter_nik', $nik)
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        if ($complaints->isEmpty()) {
            $errorMessages = [
                'ticket' => 'Pengaduan dengan nomor tiket "' . ($request->ticket_number ?? '') . '" tidak ditemukan.',
                'phone' => 'Tidak ada pengaduan yang terdaftar dengan nomor HP tersebut.',
                'nik' => 'Tidak ada pengaduan yang terdaftar dengan NIK tersebut.'
            ];
            
            return redirect()->route('public.complaints.track')
                ->with('error', $errorMessages[$searchType]);
        }
        
        // If single result from ticket search, redirect to detail
        if ($searchType === 'ticket' && $complaints->count() === 1) {
            return redirect()->route('public.complaints.show', $complaints->first()->ticket_number);
        }
        
        return view('public.complaints.track', compact('complaints'));
    }

    /**
     * Form pengaduan
     */
    public function create($serviceSlug = null)
    {
        $services = ComplaintService::active()->ordered()->get();
        
        $selectedService = null;
        if ($serviceSlug) {
            $selectedService = ComplaintService::where('slug', $serviceSlug)->first();
        }
        
        $flows = ComplaintFlow::active()->ordered()->take(5)->get();
        
        return view('public.complaints.create', compact('services', 'selectedService', 'flows'));
    }

    /**
     * Submit pengaduan
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'complaint_service_id' => 'required|exists:complaint_services,id',
            'reporter_name' => 'required|string|max:255',
            'reporter_nik' => 'nullable|string|size:16',
            'reporter_address' => 'required|string',
            'reporter_phone' => 'required|string|max:20',
            'reporter_email' => 'nullable|email',
            'subject' => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'location' => 'required|string',
            'incident_date' => 'required|date|before_or_equal:today',
            'evidence_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
            'priority' => 'nullable|in:low,medium,high,urgent'
        ]);

        try {
            // Handle file upload
            if ($request->hasFile('evidence_file')) {
                $file = $request->file('evidence_file');
                $validated['evidence_file'] = $file->store('complaint-evidence', 'public');
                $validated['evidence_file_size'] = $this->formatBytes($file->getSize());
            }

            // Set default values
            $validated['status'] = 'submitted';
            $validated['priority'] = $validated['priority'] ?? 'medium';

            // Create complaint
            $complaint = Complaint::create($validated);

            // Load service relation
            $complaint->load('service');

            // Create history record
            ComplaintHistory::create([
                'complaint_id' => $complaint->id,
                'status' => 'submitted',
                'description' => 'Pengaduan baru diajukan oleh ' . $complaint->reporter_name,
                'updated_by' => 'System'
            ]);

            // Try to send email notification (optional in development)
            if ($complaint->reporter_email) {
                try {
                    Mail::to($complaint->reporter_email)
                        ->send(new ComplaintSubmitted($complaint));
                    
                    Log::info('Email sent successfully to: ' . $complaint->reporter_email);
                } catch (\Exception $e) {
                    Log::error('Email notification failed: ' . $e->getMessage());
                    // Continue without email
                }
            }

            return redirect()->route('public.complaints.success', $complaint->ticket_number)
                ->with('success', 'Pengaduan berhasil dikirim!');

        } catch (\Exception $e) {
            Log::error('Complaint submission error: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Success page after submit
     */
    public function success($ticketNumber)
    {
        $complaint = Complaint::with('service')
            ->where('ticket_number', $ticketNumber)
            ->firstOrFail();
        
        return view('public.complaints.success', compact('complaint'));
    }

    /**
     * Detail complaint
     */
    public function show($ticketNumber)
    {
        $complaint = Complaint::with(['service', 'histories'])
            ->where('ticket_number', $ticketNumber)
            ->firstOrFail();
        
        $flows = ComplaintFlow::active()->ordered()->get();
        
        // Increment view count
        $complaint->incrementViewCount();
        
        return view('public.complaints.show', compact('complaint', 'flows'));
    }

    /**
     * Download evidence file
     */
    public function downloadEvidence($ticketNumber)
    {
        $complaint = Complaint::where('ticket_number', $ticketNumber)->firstOrFail();

        if (!$complaint->evidence_file) {
            return redirect()->back()->with('error', 'File bukti tidak tersedia');
        }

        if (!Storage::disk('public')->exists($complaint->evidence_file)) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }

        // Increment download count
        $complaint->incrementDownloadCount();

        $filePath = Storage::disk('public')->path($complaint->evidence_file);
        $extension = pathinfo($complaint->evidence_file, PATHINFO_EXTENSION);
        $fileName = 'Bukti-' . $complaint->ticket_number . '.' . $extension;

        return response()->download($filePath, $fileName);
    }

    /**
     * Download response file
     */
    public function downloadResponse($ticketNumber)
    {
        $complaint = Complaint::where('ticket_number', $ticketNumber)->firstOrFail();

        if (!$complaint->response_file) {
            return redirect()->back()->with('error', 'File tanggapan tidak tersedia');
        }

        if (!Storage::disk('public')->exists($complaint->response_file)) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }

        $filePath = Storage::disk('public')->path($complaint->response_file);
        $extension = pathinfo($complaint->response_file, PATHINFO_EXTENSION);
        $fileName = 'Tanggapan-' . $complaint->ticket_number . '.' . $extension;

        return response()->download($filePath, $fileName);
    }

    /**
     * Submit feedback & rating
     */
    public function submitFeedback(Request $request, $ticketNumber)
    {
        $complaint = Complaint::where('ticket_number', $ticketNumber)->firstOrFail();

        // Only allow feedback for resolved complaints
        if ($complaint->status !== 'resolved') {
            return redirect()->back()->with('error', 'Feedback hanya dapat diberikan untuk pengaduan yang sudah diselesaikan');
        }

        $validated = $request->validate([
            'satisfaction_rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:1000'
        ]);

        $complaint->update([
            'satisfaction_rating' => $validated['satisfaction_rating'],
            'feedback' => $validated['feedback'],
            'status' => 'closed',
            'closed_at' => now()
        ]);

        // Create history
        ComplaintHistory::create([
            'complaint_id' => $complaint->id,
            'status' => 'closed',
            'description' => 'Pengaduan ditutup dengan rating ' . $validated['satisfaction_rating'] . ' bintang',
            'updated_by' => $complaint->reporter_name
        ]);

        return redirect()->route('public.complaints.show', $ticketNumber)
            ->with('success', 'Terima kasih atas feedback Anda!');
    }

    /**
     * Format bytes to human readable
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
