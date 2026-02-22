<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\PejabatStruktural;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PejabatStrukturalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $pejabat = PejabatStruktural::ordered()->paginate(20);
        return view('admin.profil.pejabat.index', compact('pejabat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.profil.pejabat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          // Debug
    Log::info('Store method called', $request->all());
        $validated = $request->validate([
            'nama' => 'required|string|max:150',
            'jabatan' => 'required|string|max:150',
            'nip' => 'nullable|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'pendidikan' => 'nullable|string|max:100',
            'riwayat_jabatan' => 'nullable|string',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:20',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        // Upload foto
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('pejabat', 'public');
        }

        PejabatStruktural::create($validated);
        return redirect()->route('admin.pejabat.index')
            ->with('success', 'Profil Pejabat berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $pejabat = PejabatStruktural::findOrFail($id);
        return view('admin.profil.pejabat.edit', compact('pejabat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       $validated = $request->validate([
            'nama' => 'required|string|max:150',
            'jabatan' => 'required|string|max:150',
            'nip' => 'nullable|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'pendidikan' => 'nullable|string|max:100',
            'riwayat_jabatan' => 'nullable|string',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:20',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $pejabat = PejabatStruktural::findOrFail($id);

        // Upload new foto
        if ($request->hasFile('foto')) {
            if ($pejabat->foto) {
                Storage::disk('public')->delete($pejabat->foto);
            }
            $validated['foto'] = $request->file('foto')->store('pejabat', 'public');
        }

        $pejabat->update($validated);
        return redirect()->route('admin.pejabat.index')
            ->with('success', 'Profil Pejabat berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pejabat = PejabatStruktural::findOrFail($id);
        
        if ($pejabat->foto) {
            Storage::disk('public')->delete($pejabat->foto);
        }
        
        $pejabat->delete();
        return redirect()->route('admin.pejabat.index')
            ->with('success', 'Profil Pejabat berhasil dihapus');
    }
    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|string',
            ]);

            $ids = explode(',', $request->ids);
            $count = PejabatStruktural::whereIn('id', $ids)->count();

            if ($count === 0) {
                return redirect()->route('admin.pejabat.index')
                    ->with('error', 'Tidak ada data yang dipilih');
            }

            PejabatStruktural::whereIn('id', $ids)->delete();

            return redirect()->route('admin.pejabat.index')
                ->with('success', "Berhasil menghapus {$count} data fasyankes");

        } catch (\Exception $e) {
            return redirect()->route('admin.pejabat.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
