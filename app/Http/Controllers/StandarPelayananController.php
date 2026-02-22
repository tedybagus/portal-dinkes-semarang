<?php

namespace App\Http\Controllers;

use App\Models\StandarPelayanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StandarPelayananController extends Controller
{
    public function index(Request $request)
    {
        $kategoris = StandarPelayanan::active()->distinct()->orderBy('kategori')->pluck('kategori');

        $query = StandarPelayanan::active()->ordered();
        if ($request->filled('kategori')) $query->where('kategori', $request->kategori);
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(fn($s) => $s->where('nama','like',"%$q%")->orWhere('deskripsi','like',"%$q%"));
        }

        $items      = $query->get();
        $activeKat  = $request->kategori;
        $searchQuery= $request->q;

        return view('public.standar_pelayanan.index', compact('items','kategoris','activeKat','searchQuery'));
    }

    public function show(StandarPelayanan $standarPelayanan)
    {
        abort_if(!$standarPelayanan->is_active, 404);
        $standarPelayanan->incrementView();
        $related = StandarPelayanan::active()
            ->where('kategori', $standarPelayanan->kategori)
            ->where('id','!=',$standarPelayanan->id)
            ->ordered()->limit(4)->get();
        return view('public.standar_pelayanan.show', compact('standarPelayanan','related'));
    }
}

