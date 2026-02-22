<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
     /* ─── INDEX ──────────────────────────────────────── */

    public function index(Request $request)
    {
        $query = Faq::query();

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($s) use ($q) {
                $s->where('pertanyaan', 'like', "%$q%")
                  ->orWhere('jawaban',    'like', "%$q%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'aktif');
        }

        $faqs     = $query->ordered()->paginate(15)->appends($request->query());
        $kategoris = Faq::distinct()->orderBy('kategori')->pluck('kategori');
        $stats    = [
            'total'   => Faq::count(),
            'active'  => Faq::active()->count(),
            'inactive'=> Faq::where('is_active', false)->count(),
        ];

        return view('admin.faqs.index', compact('faqs', 'kategoris', 'stats'));
    }

    /* ─── CREATE / STORE ─────────────────────────────── */

    public function create()
    {
        $kategoris = Faq::distinct()->orderBy('kategori')->pluck('kategori');
        return view('admin.faqs.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pertanyaan' => 'required|string|max:500',
            'jawaban'    => 'required|string',
            'kategori'   => 'required|string|max:100',
            'urutan'     => 'nullable|integer|min:0',
            'is_active'  => 'nullable|boolean',
        ]);

        // Handle kategori baru (dari input custom)
        if ($request->filled('kategori_baru')) {
            $data['kategori'] = $request->kategori_baru;
        }

        $data['is_active']  = $request->boolean('is_active');
        $data['urutan']     = $data['urutan'] ?? 0;

        Faq::create($data);

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ berhasil ditambahkan!');
    }

    /* ─── EDIT / UPDATE ──────────────────────────────── */

    public function edit(Faq $faq)
    {
        $kategoris = Faq::distinct()->orderBy('kategori')->pluck('kategori');
        return view('admin.faqs.edit', compact('faq', 'kategoris'));
    }

    public function update(Request $request, Faq $faq)
    {
        $data = $request->validate([
            'pertanyaan' => 'required|string|max:500',
            'jawaban'    => 'required|string',
            'kategori'   => 'required|string|max:100',
            'urutan'     => 'nullable|integer|min:0',
            'is_active'  => 'nullable|boolean',
        ]);

        if ($request->filled('kategori_baru')) {
            $data['kategori'] = $request->kategori_baru;
        }

        $data['is_active'] = $request->boolean('is_active');
        $data['urutan']    = $data['urutan'] ?? 0;

        $faq->update($data);

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ berhasil diperbarui!');
    }

    /* ─── DELETE ─────────────────────────────────────── */

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ berhasil dihapus!');
    }

    /* ─── TOGGLE ACTIVE ──────────────────────────────── */

    public function toggle(Faq $faq)
    {
        $faq->update(['is_active' => !$faq->is_active]);
        $status = $faq->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "FAQ berhasil $status!");
    }

    /* ─── BULK ACTIONS ───────────────────────────────── */

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'ids'    => 'required|array',
            'ids.*'  => 'exists:faqs,id',
        ]);

        $faqs = Faq::whereIn('id', $request->ids);

        match($request->action) {
            'activate'   => $faqs->update(['is_active' => true]),
            'deactivate' => $faqs->update(['is_active' => false]),
            'delete'     => $faqs->delete(),
        };

        $label = ['activate' => 'diaktifkan', 'deactivate' => 'dinonaktifkan', 'delete' => 'dihapus'];

        return back()->with('success', count($request->ids) . ' FAQ berhasil ' . $label[$request->action] . '!');
    }

    /* ─── UPDATE ORDER (drag & drop) ────────────────── */

    public function updateOrder(Request $request)
    {
        $request->validate(['orders' => 'required|array']);

        foreach ($request->orders as $item) {
            Faq::where('id', $item['id'])->update(['urutan' => $item['urutan']]);
        }

        return response()->json(['success' => true]);
    }
}
