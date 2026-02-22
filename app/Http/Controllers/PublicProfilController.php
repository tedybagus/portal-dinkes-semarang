<?php

namespace App\Http\Controllers;

use App\Models\Tupoksi;
use App\Models\VisiMisi;
use Illuminate\Http\Request;
use App\Models\PejabatStruktural;
use App\Models\StrukturOrganisasi;

class PublicProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('profil.index');
    }

    public function visiMisi()
    {
        $visiMisi = VisiMisi::active()->latest()->first();
        
        $breadcrumbs = [
            ['title' => 'Profil', 'url' => route('profil.index')],
            ['title' => 'Visi & Misi', 'url' => '#']
        ];
        
        return view('profil.visi-misi', compact('visiMisi', 'breadcrumbs'));
    }

    public function strukturOrganisasi()
    {
        $struktur = StrukturOrganisasi::active()->latest()->first();
        
        $breadcrumbs = [
            ['title' => 'Profil', 'url' => route('profil.index')],
            ['title' => 'Struktur Organisasi', 'url' => '#']
        ];
        
        return view('profil.struktur-organisasi', compact('struktur', 'breadcrumbs'));
    }

    public function tupoksi()
    {
        $tupoksi = Tupoksi::active()->ordered()->get();
        
        $breadcrumbs = [
            ['title' => 'Profil', 'url' => route('profil.index')],
            ['title' => 'Tupoksi', 'url' => '#']
        ];
        
        return view('profil.tupoksi', compact('tupoksi', 'breadcrumbs'));
    }

    public function pejabat()
    {
        $pejabat = PejabatStruktural::active()->ordered()->get();
        
        $breadcrumbs = [
            ['title' => 'Profil', 'url' => route('profil.index')],
            ['title' => 'Pejabat Struktural', 'url' => '#']
        ];
        
        return view('profil.pejabat', compact('pejabat', 'breadcrumbs'));
    }
}
