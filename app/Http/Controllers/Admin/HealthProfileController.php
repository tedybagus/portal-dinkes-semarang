<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\HealthProfile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class HealthProfileController extends Controller
{
    public function index()
    {
        $profiles = HealthProfile::latest()->get();
        return view('admin.health-profiles.index', compact('profiles'));
    }

    public function create()
    {
        return view('admin.health-profiles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|mimes:pdf|max:10000',
        ]);

        $path = $request->file('file')->store('health-profiles', 'public');

        HealthProfile::create([
            'name' => $request->name,
            'file_path' => $path,
            'file_type' => $request->file('file')->extension(),
        ]);

        return redirect()
            ->route('admin.health-profiles.index')
            ->with('success', 'Profil kesehatan berhasil diupload');
    }

    public function edit(HealthProfile $healthProfile)
    {
        return view('admin.health-profiles.edit', compact('healthProfile'));
    }

    public function update(Request $request, HealthProfile $healthProfile)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'nullable|mimes:pdf,jpg,jpeg,png|max:10000',
        ]);

        if ($request->hasFile('file')) {
            // hapus file lama
        if ($healthProfile->file_path && Storage::disk('public')->exists($healthProfile->file_path)) {
            Storage::disk('public')->delete($healthProfile->file_path);
        }
              // 💾 SIMPAN FILE BARU
        $data['file_path'] = $request->file('file')->store('health-profiles', 'public');
        }
      

        $healthProfile->update($data);

        return redirect()->route('admin.health-profiles.index')
            ->with('success', 'Profil kesehatan diperbarui');
    }

    public function destroy(HealthProfile $healthProfile)
    {
        Storage::disk('public')->delete($healthProfile->file_path);
        $healthProfile->delete();

        return back()->with('success', 'Profil kesehatan dihapus');
    }

    public function download(HealthProfile $healthProfile)
    {
        return Storage::disk('public')->download($healthProfile->file_path);
    }
}
