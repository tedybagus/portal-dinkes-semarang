<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produkhukum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukHukumAdminController extends Controller
{
   public function index(Request $request)
    {
        $query = Produkhukum::with('creator');

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by kategori
        if ($request->filled('kategori')) {
            $query->byKategori($request->kategori);
        }

        // Filter by tahun
        if ($request->filled('tahun')) {
            $query->byTahun($request->tahun);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $Produkhukum = $query->ordered()->paginate(15);

        // Stats
        $stats = [
            'total'         => Produkhukum::count(),
            'berlaku'       => Produkhukum::where('status', 'berlaku')->count(),
            'tidak_berlaku' => Produkhukum::where('status', 'tidak_berlaku')->count(),
            'tahun_ini'     => Produkhukum::where('tahun', date('Y'))->count(),
        ];

        // Filters data
        $kategoris = Produkhukum::KATEGORI;
        $tahuns = Produkhukum::getAvailableYears();

        return view('admin.produkhukum.index', compact('Produkhukum', 'stats', 'kategoris', 'tahuns'));
    }

    public function create()
    {
        $kategoris = Produkhukum::KATEGORI;
        return view('admin.produkhukum.form', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor'             => 'required|string|max:255',
            'tahun'             => 'required|integer|min:1900|max:' . (date('Y') + 10),
            'kategori'          => 'required|in:' . implode(',', array_keys(Produkhukum::KATEGORI)),
            'tentang'           => 'required|string',
            'tanggal_penetapan' => 'required|date',
            'tanggal_berlaku'   => 'nullable|date',
            'status'            => 'required|in:berlaku,tidak_berlaku,draft',
            'file'              => 'required|file|mimes:pdf|max:20480', // 20MB
            'keterangan'        => 'nullable|string',
            'is_active'         => 'boolean',
        ]);

        // Upload file
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('produk-hukum', 'public');
            
            $validated['file_path'] = $path;
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_size'] = $file->getSize();
        }

        $validated['created_by'] = auth()->id();

        Produkhukum::create($validated);

        return redirect()
            ->route('admin.produkhukum.index')
            ->with('success', 'Produk hukum berhasil ditambahkan!');
    }

    public function edit(Produkhukum $produkHukum)
    {
        $kategoris = Produkhukum::KATEGORI;
        return view('admin.produkhukum.form', compact('produkHukum', 'kategoris'));
    }

    public function update(Request $request, Produkhukum $produkHukum)
    {
        $validated = $request->validate([
            'nomor'             => 'required|string|max:255',
            'tahun'             => 'required|integer|min:1900|max:' . (date('Y') + 10),
            'kategori'          => 'required|in:' . implode(',', array_keys(Produkhukum::KATEGORI)),
            'tentang'           => 'required|string',
            'tanggal_penetapan' => 'required|date',
            'tanggal_berlaku'   => 'nullable|date',
            'status'            => 'required|in:berlaku,tidak_berlaku,draft',
            'file'              => 'nullable|file|mimes:pdf|max:20480',
            'keterangan'        => 'nullable|string',
            'is_active'         => 'boolean',
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file
            if ($produkHukum->file_path) {
                Storage::disk('public')->delete($produkHukum->file_path);
            }
            
            $file = $request->file('file');
            $path = $file->store('produk-hukum', 'public');
            
            $validated['file_path'] = $path;
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_size'] = $file->getSize();
        }

        $produkHukum->update($validated);

        return redirect()
            ->route('admin.produkhukum.index')
            ->with('success', 'Produk hukum berhasil diperbarui!');
    }

    public function destroy(Produkhukum $produkHukum)
    {
        // Delete file
        if ($produkHukum->file_path) {
            Storage::disk('public')->delete($produkHukum->file_path);
        }

        $produkHukum->delete();

        return redirect()
            ->route('admin.produkhukum.index')
            ->with('success', 'Produk hukum berhasil dihapus!');
    }

    public function toggle(Produkhukum $produkHukum)
    {
        $produkHukum->update(['is_active' => !$produkHukum->is_active]);

        return back()->with('success', 'Status berhasil diubah!');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        
        if (empty($ids)) {
            return back()->with('error', 'Tidak ada data yang dipilih!');
        }

        $produkHukums = Produkhukum::whereIn('id', $ids)->get();
        
        foreach ($produkHukums as $ph) {
            if ($ph->file_path) {
                Storage::disk('public')->delete($ph->file_path);
            }
            $ph->delete();
        }

        return back()->with('success', count($ids) . ' produk hukum berhasil dihapus!');
    }
}
