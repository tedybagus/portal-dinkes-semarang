<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tupoksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TupoksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tupoksi = Tupoksi::ordered()->paginate(10);
        return view('admin.profil.tupoksi.index', compact('tupoksi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('admin.profil.tupoksi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'tugas_pokok' => 'required|string',
            'fungsi' => 'required|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        Tupoksi::create($validated);
        return redirect()->route('admin.tupoksi.index')
            ->with('success', 'Tupoksi berhasil ditambahkan');
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
        $tupoksi = Tupoksi::findOrFail($id);
        return view('admin.profil.tupoksi.edit', compact('tupoksi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'tugas_pokok' => 'required|string',
            'fungsi' => 'required|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $tupoksi = Tupoksi::findOrFail($id);
        $tupoksi->update($validated);
        return redirect()->route('admin.tupoksi.index')
            ->with('success', 'Tupoksi berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Tupoksi::findOrFail($id)->delete();
        return redirect()->route('admin.tupoksi.index')
            ->with('success', 'Tupoksi berhasil dihapus');
    }
}
