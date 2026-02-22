<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Fasyankes;
use App\Models\Klinik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FasyankesController extends Controller
{
    /**
     * Dashboard overview
     */
 /**
     * Dashboard overview - FIXED for relational data
     */
    public function dashboard()
    {
        // Get all categories (kliniks)
        $categories = Klinik::all();
        
        // Build stats array
        $stats = [
            'total' => Fasyankes::count(),
            'with_coordinates' => Fasyankes::whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->count(),
            'added_this_month' => Fasyankes::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'updated_today' => Fasyankes::whereDate('updated_at', today())->count(),
        ];

        // Count per kategori using klinik_id
        foreach ($categories as $category) {
            // Normalize key (lowercase, replace space with underscore)
            $key = strtolower(str_replace(' ', '_', $category->nama));
            $stats[$key] = Fasyankes::where('klinik_id', $category->id)->count();
        }

        // Specific categories for compatibility
        $stats['puskesmas'] = $this->getCountByKategoriName('Puskesmas');
        $stats['rumah_sakit'] = $this->getCountByKategoriName('Rumah Sakit');
        $stats['apotek'] = $this->getCountByKategoriName('Apotek');
        $stats['klinik'] = $this->getCountByKategoriName('Klinik');
        $stats['laboratorium'] = $this->getCountByKategoriName('Laboratorium');

        // Get recent fasyankes with kategori relationship
        $recentFasyankes = Fasyankes::with('klinik')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get categories for frontend
        $kategoris = Klinik::withCount('fasyankes')
            ->orderBy('nama')
            ->get();

        return view('admin.fasyankes.dashboard', compact('stats', 'recentFasyankes', 'kategoris'));
    }

    /**
     * Helper: Get count by kategori name
     */
    private function getCountByKategoriName($name)
    {
        $klinik = Klinik::where('nama', $name)->first();
        
        if (!$klinik) {
            return 0;
        }

        return Fasyankes::where('klinik_id', $klinik->id)->count();
    }
    public function index(Request $request)
    {
        $query = Fasyankes::with('kategori');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('kode', 'LIKE', "%{$search}%")
                  ->orWhere('alamat', 'LIKE', "%{$search}%");
            });
        }

        // Filter by kategori
        if ($request->filled('kategori')) {
            $query->where('klinik_id', $request->kategori);
        }

        $fasyankes = $query->latest()->paginate(10)->withQueryString();
        
        return view('admin.fasyankes.index', compact('fasyankes'));
    }

    public function create()
    {
        $kategoris = Klinik::where('is_active', true)->orderBy('nama')->get();
        return view('admin.fasyankes.create', compact('kategoris'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
        'klinik_id' => 'required|exists:kliniks,id',  // ← HARUS ADA INI
        'nama' => 'required|string|max:255',
        'kode' => 'required|string|max:50|unique:fasyankes',
        'alamat' => 'required|string',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
    ]);

    Fasyankes::create($validated);  // ← Ini akan save semua termasuk klinik_id

    return redirect()->route('admin.fasyankes.index')
                    ->with('success', 'Fasyankes berhasil ditambahkan');
    }

    public function show(Fasyankes $fasyankes)
    {
        $fasyankes->load('kategori');
        return view('admin.fasyankes.show', compact('fasyankes'));
    }

    public function edit(Fasyankes $fasyanke)
    {
        // $kategoris = Klinik::where('is_active', true)->orderBy('nama')->get();
        $kategoris = Klinik::all();
        return view('admin.fasyankes.edit', compact('fasyanke','kategoris'));
    }

    public function update(Request $request, Fasyankes $fasyanke)
    {
        try {
            $validated = $request->validate([
                'klinik_id' => 'required|exists:kliniks,id',
                'nama' => 'required|string|max:255',
                'kode' => 'required|string|max:50|unique:fasyankes,kode,' . $fasyanke->id,
                'alamat' => 'required|string',
                'latitude' => 'nullable|numeric|between:-90,90',
                'longitude' => 'nullable|numeric|between:-180,180',
            ], [
                'klinik_id.required' => 'Kategori fasyankes harus dipilih',
                'klinik_id.exists' => 'Kategori tidak valid',
                'nama.required' => 'Nama fasyankes harus diisi',
                'nama.max' => 'Nama maksimal 255 karakter',
                'kode.required' => 'Kode fasyankes harus diisi',
                'kode.unique' => 'Kode sudah digunakan, gunakan kode lain',
                'kode.max' => 'Kode maksimal 50 karakter',
                'alamat.required' => 'Alamat harus diisi',
                'latitude.numeric' => 'Latitude harus berupa angka',
                'latitude.between' => 'Latitude harus antara -90 dan 90',
                'longitude.numeric' => 'Longitude harus berupa angka',
                'longitude.between' => 'Longitude harus antara -180 dan 180',
            ]);

            // Validate coordinates
            if (($request->latitude && !$request->longitude) || (!$request->latitude && $request->longitude)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Jika mengisi koordinat, harap isi latitude dan longitude');
            }

            $fasyanke->update($validated);

            return redirect()->route('admin.fasyankes.index')
                            ->with('success', 'Data fasyankes berhasil diupdate');
                            
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }
    }

    public function destroy(Fasyankes $fasyankes)
    {
        try {
            $fasyankes->delete();

            return redirect()->route('admin.fasyankes.index')
                            ->with('success', 'Data fasyankes berhasil dihapus');
                            
        } catch (\Exception $e) {
            return redirect()->route('admin.fasyankes.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|string',
            ]);

            $ids = explode(',', $request->ids);
            $count = Fasyankes::whereIn('id', $ids)->count();

            if ($count === 0) {
                return redirect()->route('admin.fasyankes.index')
                    ->with('error', 'Tidak ada data yang dipilih');
            }

            Fasyankes::whereIn('id', $ids)->delete();

            return redirect()->route('admin.fasyankes.index')
                ->with('success', "Berhasil menghapus {$count} data fasyankes");

        } catch (\Exception $e) {
            return redirect()->route('admin.fasyankes.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
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
        
        return view('admin.fasyankes.maps', compact('fasyankes', 'totalKlinik', 'totalPuskesmas', 'totalRsud','totallab','totalapotek'));
    }
     /**
     * Get statistics for API or AJAX
     */
    
    /**
     * Get statistics for API/AJAX
     */
    public function statistics()
    {
        $kategoris = Klinik::with('fasyankes')->get();
        
        $byCategory = [];
        foreach ($kategoris as $kategori) {
            $byCategory[$kategori->nama] = $kategori->fasyankes->count();
        }

        $stats = [
            'total' => Fasyankes::count(),
            'by_category' => $byCategory,
            'with_coordinates' => Fasyankes::whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->count(),
            'recent_count' => Fasyankes::where('created_at', '>=', now()->subDays(30))->count(),
        ];

        return response()->json($stats);
    }
}