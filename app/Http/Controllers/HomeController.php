<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Klinik;
use App\Models\Article;
use App\Models\Category;
use App\Models\Fasyankes;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         // Hero slideshow — ambil gambar bertipe "hero", aktif, urutan ascending
        $heroImages = Image::where('type', 'hero')
                      ->where('is_active', true)
                      ->orderBy('order')
                      ->get();
                    //   artikel berita
        $latestArticles = Article::with('category')
        ->where('status','published')
        ->orderBy('article_date', 'desc')
        ->limit(3)
        ->get();
        // Fasyankes untuk grid publik (12 per halaman)
        $fasyankes = Fasyankes::with('kategori')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->orderBy('nama')
            ->paginate(12);
         // Ambil semua kategori dengan jumlah fasyankes
        $kategoris = Klinik::withCount([
            'fasyankes' => function($query) {
                $query->where('is_active', true);
            }
        ])->get();

        // Ambil gallery yang aktif, urutkan berdasarkan order, ambil 12 teratas
         $galleries = Image::where('type', 'gallery')
                      ->where('is_active', true)
                      ->orderBy('order')
                      ->get();
        // Statistik untuk stats bar di bawah hero
        $stats = [
            'klinik'=> Fasyankes::whereHas('kategori', fn($q) => $q->where('nama', 'klinik'))->count(),
            'rumah sakit'=> Fasyankes::whereHas('kategori', fn($q) => $q->where('nama', 'rumah sakit'))->count(),
            'puskesmas' => Fasyankes::whereHas('kategori', fn($q) => $q->where('nama', 'puskesmas'))->count(),
            'apotek'    => Fasyankes::whereHas('kategori', fn($q) => $q->where('nama', 'Apotek'))->count(),
            'laboratorium' => Fasyankes::whereHas('kategori', fn($q) => $q->where('nama', 'laboratorium'))->count(),
            'tpmd'    => Fasyankes::whereHas('kategori', fn($q) => $q->where('nama', 'tpmd'))->count(),
            'tpmdg'    => Fasyankes::whereHas('kategori', fn($q) => $q->where('nama', 'tpmdg'))->count(),
            'tpmb'    => Fasyankes::whereHas('kategori', fn($q) => $q->where('nama', 'tpmb'))->count(),
            'tpmp'    => Fasyankes::whereHas('kategori', fn($q) => $q->where('nama', 'tpmp'))->count(),
            'penduduk'  => '1.6M', // ubah sesuai data nyata
        ];

        return view('home2', compact('heroImages', 'fasyankes', 'stats', 'kategoris','latestArticles','galleries'));
    }
 /**
     * Alternatif: Jika ingin lebih flexible dengan custom query
     */
    public function indexAlternative()
    {
        // Stats dengan query builder raw
        $stats = [
            'total_fasyankes' => Fasyankes::where('is_active', true)->count(),
            'total_kategori' => Klinik::count(),
            
            // Per kategori (lebih efisien dengan join)
            'klinik' => $this->countByKategori('Klinik'),
            'rs' => $this->countByKategori('Rumah Sakit'),
            'puskesmas' => $this->countByKategori('Puskesmas'),
            'apotek' => $this->countByKategori('Apotek'),
            'laboratorium' => $this->countByKategori('Laboratorium'),
        ];

        // Fasyankes featured (misalnya yang paling populer atau unggulan)
        $fasyankes = Fasyankes::with('kategori')
            ->where('is_active', true)
            ->latest()
            ->take(6)
            ->get();

        // Kategori dengan icon
        $kategoris = Klinik::all()->map(function($kategori) {
            // Tambahkan icon sesuai nama kategori
            $kategori->icon = $this->getKategoriIcon($kategori->nama);
            return $kategori;
        });

        return view('home2', compact('stats', 'fasyankes', 'kategoris'));
    }

    /**
     * Helper: Hitung fasyankes berdasarkan kategori
     */
    private function countByKategori($namaKategori)
    {
        return Fasyankes::whereHas('kategori', function($query) use ($namaKategori) {
            $query->where('nama', $namaKategori);
        })->where('is_active', true)->count();
    }

    /**
     * Helper: Dapatkan icon berdasarkan kategori
     */
    private function getKategoriIcon($namaKategori)
    {
        $icons = [
            'Klinik' => 'clinic-medical',
            'Rumah Sakit' => 'hospital',
            'Puskesmas' => 'house-medical',
            'Apotek' => 'pills',
            'Laboratorium' => 'flask',
        ];

        return $icons[$namaKategori] ?? 'hospital';
    }
    public function show($slug)
{
    $article = Article::with(['author','category'])
        ->where('slug', $slug)
        ->where('status', 'published')
        ->firstOrFail();

    return view('public.articles.show', compact('article'));
}
  
}
