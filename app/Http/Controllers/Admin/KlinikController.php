<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Klinik;
use Illuminate\Http\Request;

class KlinikController extends Controller
{
    public function index()
    {
        $kliniks = Klinik::orderBy('nama')->paginate(10);
        return view('admin.kliniks.index', compact('kliniks'));
    }

    public function create()
    {
        return view('admin.kliniks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'string|max:10|unique:kliniks',
            'icon' => 'nullable|string',
            'color' => 'nullable|string',
            'deskripsi' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Klinik::create($validated);
        return redirect()->route('admin.kliniks.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(Klinik $klinik)
    {
        return view('admin.kliniks.show', compact('klinik'));
    }

    public function edit(Klinik $klinik)
    {
        return view('admin.kliniks.edit', compact('klinik'));
    }

    public function update(Request $request, Klinik $klinik)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'string|max:10|unique:kliniks,kode'.$klinik->id,
            'icon' => 'nullable|string',
            'color' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $klinik->update($validated);

        return redirect()->route('admin.kliniks.index')
            ->with('success', 'Klinik berhasil diperbarui.');
    }

    public function destroy(Klinik $klinik)
    {
        $klinik->delete();

        return redirect()->route('admin.kliniks.index')
            ->with('success', 'Klinik berhasil dihapus.');
    }
}