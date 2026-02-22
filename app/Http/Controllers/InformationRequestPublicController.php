<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InformationFaq;
use App\Models\InformationFlow;
use App\Models\InformationRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Notifications\InformationRequestSubmitted;

class InformationRequestPublicController extends Controller
{
   /**
     * Halaman alur permohonan
     */
    public function flow()
    {
        $flows = InformationFlow::active()->ordered()->get();
        $faqs = InformationFaq::active()->ordered()->get();
        
        return view('information.flow', compact('flows', 'faqs'));
    }

    /**
     * Form permohonan informasi
     */
    public function create()
    {
        return view('information.create');
    }

    /**
     * Submit permohonan
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'id_card_number' => 'required|string|max:16',
            'id_card_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'requester_type' => 'required|in:perorangan,kelompok,organisasi',
            'information_needed' => 'required|string',
            'information_purpose' => 'required|string',
            'information_format' => 'required|in:softcopy,hardcopy,keduanya',
            'delivery_method' => 'required|in:langsung,pos,email,kurir'
        ]);

        // Handle file upload
        if ($request->hasFile('id_card_file')) {
            $validated['id_card_file'] = $request->file('id_card_file')->store('id-cards', 'public');
        }

        // Create request
        $informationRequest = InformationRequest::create($validated);
        // $informationRequest->notify(new InformationRequestSubmitted());

        // // Send notification email (optional)
        // Mail::to($validated['email'])->send(new InformationRequestSubmitted($informationRequest));

        return redirect()->route('information.tracking', $informationRequest->registration_number)
            ->with('success', 'Permohonan informasi berhasil diajukan. Nomor registrasi Anda: ' . $informationRequest->registration_number);
    }

    /**
     * Tracking permohonan
     */
    public function tracking(Request $request, $registrationNumber = null)
    {
        $informationRequest = null;

        if ($registrationNumber) {
            $informationRequest = InformationRequest::with('followups')
                ->where('registration_number', $registrationNumber)
                ->first();
        }

        return view('information.tracking', compact('informationRequest'));
    }

    /**
     * Search tracking
     */
    public function searchTracking(Request $request)
    {
        $request->validate([
            'registration_number' => 'required|string'
        ]);

        return redirect()->route('information.tracking', $request->registration_number);
    }

    /**
     * Download hasil
     */
    public function downloadResult($id)
    {
        $informationRequest = InformationRequest::findOrFail($id);

        if (!$informationRequest->result_file) {
            return back()->with('error', 'File hasil belum tersedia');
        }

        if (!Storage::disk('public')->exists($informationRequest->result_file)) {
            return back()->with('error', 'File tidak ditemukan');
        }

        $filePath = Storage::disk('public')->path($informationRequest->result_file);
        $fileName = 'Hasil_Permohonan_' . $informationRequest->registration_number . '.' . pathinfo($informationRequest->result_file, PATHINFO_EXTENSION);

        return response()->download($filePath, $fileName);
    }
}
