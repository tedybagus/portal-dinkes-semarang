<?php

namespace App\Http\Controllers;

use App\Models\Fasyankes;
use App\Models\Klinik;
use Illuminate\Http\Request;

class PublicFasyankesController extends Controller
{
    /**
     * Tampilkan halaman publik fasyankes dengan filter dan search
     */
    public function index(Request $request)
    {
        // Query dasar
        $query = Fasyankes::with('kategori');

        // Filter berdasarkan search (nama atau alamat)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('klinik_id', $request->kategori);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        // Default: hanya tampilkan yang aktif (optional, bisa dihapus jika ingin tampilkan semua)
        // Uncomment baris di bawah jika hanya ingin tampilkan yang aktif by default
        // if (!$request->filled('status')) {
        //     $query->where('is_active', true);
        // }

        // Urutkan berdasarkan nama
        $query->orderBy('nama', 'asc');

        // Pagination
        $fasyankes = $query->paginate(9)->withQueryString();

        // Ambil semua kategori dengan jumlah fasyankes
        $kategoris = Klinik::withCount('fasyankes')
            ->orderBy('nama', 'asc')
            ->get();

        // Total semua fasyankes
        $totalFasyankes = Fasyankes::count();

        return view('fasyankes.public', compact('fasyankes', 'kategoris', 'totalFasyankes'));
    }

    /**
     * Tampilkan detail fasyankes untuk publik
     */
    public function show($id)
    {
        $fasyankes = Fasyankes::with('kategori')->findOrFail($id);
        
        return view('fasyankes.detail', compact('fasyankes'));
    }
     public function maps()
    {
        // Ambil semua fasyankes dengan koordinat
        $fasyankes = Fasyankes::with('kategori')
                             ->whereNotNull('latitude')
                             ->whereNotNull('longitude')
                             ->get();
        
        // Hitung total per kategori
        $totalKlinik = Fasyankes::whereHas('kategori', function ($q) {
        $q->where('nama', 'klinik');
        })->count();
        
        $totalPuskesmas = Fasyankes::whereHas('kategori', function ($q) {
        $q->where('nama', 'puskesmas');
        })->count();

        $totalRsud = Fasyankes::whereHas('kategori', function ($q) {
            $q->where('nama', 'rumah sakit');
        })->count();
        $totallab = Fasyankes::whereHas('kategori', function ($q) {
            $q->where('nama', 'Laboratorium');
        })->count();
        $totalapotek = Fasyankes::whereHas('kategori', function ($q) {
            $q->where('nama', 'Apotek');
        })->count();
        
        return view('fasyankes.map', compact('fasyankes', 'totalKlinik', 'totalPuskesmas', 'totalRsud','totallab','totalapotek'));
    }
}