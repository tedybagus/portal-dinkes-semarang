<?php

namespace App\Http\Controllers\Admin;

use App\Models\VisiMisi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VisiMisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $visiMisi = VisiMisi::latest()->paginate(10);
        return view('admin.profil.visi-misi.index', compact('visiMisi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.profil.visi-misi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validated = $request->validate([
            'visi' => 'required|string',
            'misi' => 'required|string',
            'motto' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        VisiMisi::create($validated);
        return redirect()->route('admin.visi-misi.index')
            ->with('success', 'Visi Misi berhasil ditambahkan');
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
        $visiMisi = VisiMisi::findOrFail($id);
        return view('admin.profil.visi-misi.edit', compact('visiMisi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $validated = $request->validate([
            'visi' => 'required|string',
            'misi' => 'required|string',
            'motto' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $visiMisi = VisiMisi::findOrFail($id);
        $visiMisi->update($validated);
        return redirect()->route('admin.visi-misi.index')
            ->with('success', 'Visi Misi berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        VisiMisi::findOrFail($id)->delete();
        return redirect()->route('admin.visi-misi.index')
            ->with('success', 'Visi Misi berhasil dihapus');
    }
}
