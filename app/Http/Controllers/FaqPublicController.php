<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqPublicController extends Controller
{
    public function index(Request $request)
    {
        $kategoris = Faq::active()
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        $query = Faq::active()->ordered();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($s) use ($q) {
                $s->where('pertanyaan', 'like', "%$q%")
                  ->orWhere('jawaban',    'like', "%$q%");
            });
        }

        $faqs       = $query->get();
        $activeKat  = $request->kategori;
        $searchQuery = $request->q;

        return view('faqs.index', compact('faqs', 'kategoris', 'activeKat', 'searchQuery'));
    }
}
