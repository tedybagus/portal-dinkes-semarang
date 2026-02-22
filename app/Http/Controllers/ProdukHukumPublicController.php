<?php

namespace App\Http\Controllers;

use App\Models\Produkhukum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukHukumPublicController extends Controller
{
    public function index(Request $request)
    {
        $query = Produkhukum::active()->berlaku();

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

        $Produkhukum = $query->ordered()->paginate(12);

        // Categories with count
    $kategoriCounts = Produkhukum::getKategoriWithCount();

        // Available years
        $tahuns = Produkhukum::getAvailableYears();

        // Stats
        $totalDokumen = Produkhukum::active()->berlaku()->count();

        return view('public.produkhukum.index', compact(
            'Produkhukum', 
            'kategoriCounts', 
            'tahuns',
            'totalDokumen'
        ));
    }

    public function show(produkHukum $produkHukum)
    {
        // Only show if active and berlaku
        if (!$produkHukum->is_active || $produkHukum->status !== 'berlaku') {
            abort(404);
        }

        // Related documents (same kategori)
        $relatedDokumen = Produkhukum::active()
            ->berlaku()
            ->where('id', '!=', $produkHukum->id)
            ->where('kategori', $produkHukum->kategori)
            ->ordered()
            ->take(5)
            ->get();

        return view('public.produkhukum.show', compact( 'produkHukum','relatedDokumen'));
    }

    public function download(produkHukum $produkHukum)
    {
        // Only allow download if active and berlaku
        if (!$produkHukum->is_active || $produkHukum->status !== 'berlaku') {
            abort(404);
        }

        // Increment download count
        $produkHukum->incrementDownload();

        // Download file
        return Storage::disk('public')->download(
            $produkHukum->file_path,
            $produkHukum->file_name
        );
    }
}
