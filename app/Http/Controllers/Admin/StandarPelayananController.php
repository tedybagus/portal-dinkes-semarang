<?php

namespace App\Http\Controllers\Admin;

use App\Models\StandarPelayanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class StandarPelayananController extends Controller
{
    public function index(Request $request)
    {
        $query = StandarPelayanan::query();

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(fn($s) => $s->where('nama','like',"%$q%")->orWhere('deskripsi','like',"%$q%"));
        }
        if ($request->filled('kategori')) $query->where('kategori', $request->kategori);
        if ($request->filled('status'))   $query->where('is_active', $request->status === 'aktif');

        $items    = $query->ordered()->paginate(15)->appends($request->query());
        $kategoris= StandarPelayanan::distinct()->orderBy('kategori')->pluck('kategori');
        $stats    = [
            'total'   => StandarPelayanan::count(),
            'active'  => StandarPelayanan::active()->count(),
            'inactive'=> StandarPelayanan::where('is_active', false)->count(),
        ];

        return view('admin.standar-pelayanan.index', compact('items','kategoris','stats'));
    }

    public function create()
    {
        $kategoris = StandarPelayanan::distinct()->orderBy('kategori')->pluck('kategori');
        return view('admin.standar-pelayanan.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['persyaratan'] = $this->buildPersyaratan($request);
        $data['slug']        = Str::slug($data['nama']);
        StandarPelayanan::create($data);
        return redirect()->route('admin.standar-pelayanan.index')
            ->with('success', 'Standar Pelayanan berhasil ditambahkan!');
    }

    public function edit(StandarPelayanan $standarPelayanan)
    {
        $kategoris = StandarPelayanan::distinct()->orderBy('kategori')->pluck('kategori');
        return view('admin.standar-pelayanan.edit', compact('standarPelayanan','kategoris'));
    }

    public function update(Request $request, StandarPelayanan $standarPelayanan)
    {
        $data = $this->validateData($request, $standarPelayanan->id);
        $data['persyaratan'] = $this->buildPersyaratan($request);
        $standarPelayanan->update($data);
        return redirect()->route('admin.standar-pelayanan.index')
            ->with('success', 'Standar Pelayanan berhasil diperbarui!');
    }

    public function destroy(StandarPelayanan $standarPelayanan)
    {
        $standarPelayanan->delete();
        return redirect()->route('admin.standar-pelayanan.index')
            ->with('success', 'Standar Pelayanan berhasil dihapus!');
    }

    public function toggle(StandarPelayanan $standarPelayanan)
    {
        $standarPelayanan->update(['is_active' => !$standarPelayanan->is_active]);
        $status = $standarPelayanan->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Standar Pelayanan berhasil $status!");
    }

    public function bulkAction(Request $request)
    {
        $request->validate(['action'=>'required|in:activate,deactivate,delete','ids'=>'required|array']);
        $q = StandarPelayanan::whereIn('id', $request->ids);
        match($request->action){
            'activate'   => $q->update(['is_active'=>true]),
            'deactivate' => $q->update(['is_active'=>false]),
            'delete'     => $q->delete(),
        };
        $label = ['activate'=>'diaktifkan','deactivate'=>'dinonaktifkan','delete'=>'dihapus'];
        return back()->with('success', count($request->ids).' item berhasil '.$label[$request->action].'!');
    }

    /* ─── Private Helpers ─────────────────── */
    private function validateData(Request $r, $ignoreId = null): array
    {
        return $r->validate([
            'nama'      => 'required|string|max:255',
            'kategori'  => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'icon'      => 'nullable|string|max:50',
            'warna'     => 'nullable|string|max:20',
            'catatan'   => 'nullable|string',
            'urutan'    => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]) + ['is_active' => $r->boolean('is_active'), 'urutan' => $r->input('urutan', 0)];
    }

    private function buildPersyaratan(Request $r): array
    {
        $result  = [];
        $juduls  = $r->input('sek_judul', []);
        $itemsAll= $r->input('sek_items', []);
        foreach ($juduls as $i => $judul) {
            if (!trim($judul)) continue;
            $raw   = $itemsAll[$i] ?? '';
            $items = array_values(array_filter(
                array_map('trim', explode("\n", $raw))
            ));
            $result[] = ['judul' => trim($judul), 'items' => $items];
        }
        return $result;
    }
}