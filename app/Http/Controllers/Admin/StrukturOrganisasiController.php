<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\StrukturOrganisasi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class StrukturOrganisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $struktur = StrukturOrganisasi::latest()->paginate(10);
        return view('admin.profil.struktur-organisasi.index', compact('struktur'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.profil.struktur-organisasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'content' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Upload image
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('struktur', 'public');
        }

        StrukturOrganisasi::create($validated);
        return redirect()->route('admin.struktur-organisasi.index')
            ->with('success', 'Struktur Organisasi berhasil ditambahkan');
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
        $struktur = StrukturOrganisasi::findOrFail($id);
        return view('admin.profil.struktur-organisasi.edit', compact('struktur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'content' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $struktur = StrukturOrganisasi::findOrFail($id);

        // Upload new image
        if ($request->hasFile('image')) {
            // Delete old image
            if ($struktur->image) {
                Storage::disk('public')->delete($struktur->image);
            }
            $validated['image'] = $request->file('image')->store('struktur', 'public');
        }

        $struktur->update($validated);
        return redirect()->route('admin.struktur-organisasi.index')
            ->with('success', 'Struktur Organisasi berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $struktur = StrukturOrganisasi::findOrFail($id);
        
        // Delete image
        if ($struktur->image) {
            Storage::disk('public')->delete($struktur->image);
        }
        
        $struktur->delete();
        return redirect()->route('admin.struktur-organisasi.index')
            ->with('success', 'Struktur Organisasi berhasil dihapus');
    }
}
