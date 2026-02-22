{{-- ============================================================
     public/standar_pelayanan/index.blade.php
     ============================================================ --}}
@extends('layouts.public.app')
@section('title', 'Standar Pelayanan – Dinas Kesehatan Kabupaten Semarang')

@section('content')
<div class="sp-public">

    {{-- ── HERO ── --}}
    <section class="sp-hero">
        <div class="hero-inner">
            <div class="hero-badge">
                <i class="fas fa-shield-alt"></i> SELURUH PELAYANAN GRATIS
            </div>
            <h1>Standar Pelayanan</h1>
            <p>Dinas Kesehatan Kabupaten Semarang</p>
            <div class="hero-address">
                <i class="fas fa-map-marker-alt"></i>
                Jl. MT. Hariyono No.29, Kuncen, Ungaran, Kec. Ungaran Barat., Kabupaten Semarang, Jawa Tengah 50511
            </div>
            <div class="hero-contacts">
                <a href="https://dkk.semarangkab.go.id" target="_blank">
                    <i class="fas fa-globe"></i> dkk.semarangkab.go.id
                </a>
                <a href="https://instagram.com/dinkes_kabsemarang" target="_blank">
                    <i class="fab fa-instagram"></i> @dinkes_kabsemarang
                </a>
                <a href="tel:0246923955">
                    <i class="fas fa-phone"></i> (024) 6923955
                </a>
            </div>

            {{-- Search --}}
            <form action="{{ route('public.standar_pelayanan.index') }}" method="GET" class="hero-search">
                <div class="hs-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" name="q" placeholder="Cari jenis layanan..."
                           value="{{ $searchQuery ?? '' }}" autocomplete="off">
                    <button type="submit">Cari</button>
                </div>
                @if(request('kategori'))<input type="hidden" name="kategori" value="{{ request('kategori') }}">@endif
            </form>
        </div>
    </section>

    <div class="sp-container">

        {{-- ── KATEGORI TABS ── --}}
        @if($kategoris->count() > 1)
        <div class="kat-tabs">
            <a href="{{ route('public.standar_pelayanan.index', array_filter(['q'=>$searchQuery])) }}"
               class="kt {{ !$activeKat ? 'kt-active' : '' }}">
                <i class="fas fa-th"></i> Semua
                <span>{{ \App\Models\StandarPelayanan::active()->count() }}</span>
            </a>
            @foreach($kategoris as $kat)
            @php $icon = match($kat){
                'Perizinan Fasyankes' => 'fa-hospital',
                'Sanitasi & Higienitas' => 'fa-shield-alt',
                'Pangan & IRTP' => 'fa-utensils',
                'Perizinan Kesehatan Tradisional' => 'fa-leaf',
                'Jaminan Kesehatan' => 'fa-id-card',
                default => 'fa-folder'
            }; @endphp
            <a href="{{ route('public.standar_pelayanan.index', array_filter(['kategori'=>$kat,'q'=>$searchQuery])) }}"
               class="kt {{ $activeKat==$kat ? 'kt-active' : '' }}">
                <i class="fas {{ $icon }}"></i> {{ $kat }}
                <span>{{ \App\Models\StandarPelayanan::active()->where('kategori',$kat)->count() }}</span>
            </a>
            @endforeach
        </div>
        @endif

        @if($searchQuery)
        <div class="search-result-info">
            <i class="fas fa-search"></i>
            Hasil "<strong>{{ $searchQuery }}</strong>": {{ $items->count() }} layanan
            <a href="{{ route('public.standar_pelayanan.index') }}">Hapus pencarian</a>
        </div>
        @endif

        {{-- ── CARDS ── --}}
        @if($items->count())
        @php $grouped = $items->groupBy('kategori'); @endphp

        @foreach($grouped as $kat => $group)
        @if(!$activeKat)
        <div class="group-header">
            <div class="gh-line"></div>
            <span>{{ $kat }}</span>
            <div class="gh-line"></div>
        </div>
        @endif

        <div class="sp-cards">
            @foreach($group as $item)
            <a href="{{ route('public.standar_pelayanan.show', $item->slug) }}" class="sp-card">
                <div class="sc-bar" style="background:{{ $item->warna }}"></div>
                <div class="sc-body">
                    <div class="sc-icon" style="background:{{ $item->warna }}18;color:{{ $item->warna }}">
                        <i class="fas {{ $item->icon }}"></i>
                    </div>
                    <h3 class="sc-title">{{ $item->nama }}</h3>
                    @if($item->deskripsi)
                    <p class="sc-desc">{{ Str::limit($item->deskripsi, 90) }}</p>
                    @endif
                    <div class="sc-meta">
                        <span><i class="fas fa-list-ul"></i> {{ $item->total_persyaratan }} persyaratan</span>
                        <span class="sc-free"><i class="fas fa-check-circle"></i> GRATIS</span>
                    </div>
                </div>
                <div class="sc-footer" style="border-top:2px solid {{ $item->warna }}20">
                    <span>Lihat Detail</span>
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
            @endforeach
        </div>
        @endforeach

        @else
        <div class="sp-empty">
            <i class="fas fa-search"></i>
            <h3>@if($searchQuery) Tidak ada hasil untuk "{{ $searchQuery }}" @else Belum ada layanan @endif</h3>
            @if($searchQuery)<a href="{{ route('public.standar_pelayanan.index') }}">Lihat semua layanan</a>@endif
        </div>
        @endif

        {{-- CTA --}}
        <div class="sp-cta">
            <div class="cta-text">
                <i class="fas fa-headset"></i>
                <div>
                    <h3>Butuh Bantuan?</h3>
                    <p>Hubungi kami untuk informasi lebih lanjut</p>
                </div>
            </div>
            <div class="cta-btns">
                <a href="tel:0246923955" class="btn btn-primary">
                    <i class="fas fa-phone"></i> (024) 6923955
                </a>
                <a href="/pengaduan/ajukan" class="btn btn-secondary">
                    <i class="fas fa-comment-alt"></i> Ajukan Pertanyaan
                </a>
            </div>
        </div>
    </div>
</div>

<style>
*{box-sizing:border-box;margin:0;padding:0}
.sp-public{background:#f8fafc;min-height:100vh}

/* Hero */
.sp-hero{background:linear-gradient(135deg,#be123c 0%,#e11d48 50%,#fb7185 100%);padding:4rem 1rem 5.5rem;text-align:center;position:relative}
.sp-hero::after{content:'';position:absolute;bottom:0;left:0;right:0;height:60px;background:#f8fafc;clip-path:ellipse(55% 100% at 50% 100%)}
.hero-inner{max-width:750px;margin:0 auto}
.hero-badge{display:inline-flex;align-items:center;gap:.5rem;background:rgba(255,255,255,.2);color:white;padding:.4rem 1.125rem;border-radius:30px;font-size:.875rem;font-weight:700;margin-bottom:1.25rem;backdrop-filter:blur(10px)}
.sp-hero h1{font-size:3rem;font-weight:900;color:white;margin-bottom:.5rem;text-shadow:0 2px 8px rgba(0,0,0,.15)}
.sp-hero>div>p{font-size:1.25rem;color:rgba(255,255,255,.9);margin-bottom:1.25rem}
.hero-address{color:rgba(255,255,255,.85);font-size:.9375rem;margin-bottom:1rem;display:flex;align-items:center;justify-content:center;gap:.5rem;flex-wrap:wrap}
.hero-contacts{display:flex;justify-content:center;gap:1.25rem;flex-wrap:wrap;margin-bottom:2rem}
.hero-contacts a{display:flex;align-items:center;gap:.375rem;color:rgba(255,255,255,.9);text-decoration:none;font-size:.9rem;transition:color .2s}
.hero-contacts a:hover{color:white}

/* Search */
.hero-search{max-width:600px;margin:0 auto}
.hs-wrap{display:flex;align-items:center;background:white;border-radius:50px;padding:.375rem .375rem .375rem 1.25rem;box-shadow:0 8px 24px rgba(0,0,0,.2)}
.hs-wrap i{color:#94a3b8;font-size:1.125rem;margin-right:.75rem}
.hs-wrap input{flex:1;border:none;outline:none;font-size:1rem;color:#1e293b;background:transparent}
.hs-wrap button{background:linear-gradient(135deg,#e11d48,#be123c);color:white;border:none;padding:.75rem 1.5rem;border-radius:40px;font-weight:700;font-size:.9375rem;cursor:pointer;transition:all .2s}
.hs-wrap button:hover{transform:scale(1.04)}

/* Container */
.sp-container{max-width:1200px;margin:0 auto;padding:2.5rem 1rem 5rem}

/* Kategori tabs */
.kat-tabs{display:flex;gap:.5rem;flex-wrap:wrap;margin-bottom:2rem}
.kt{display:inline-flex;align-items:center;gap:.5rem;padding:.625rem 1.125rem;border-radius:30px;background:white;color:#64748b;text-decoration:none;font-weight:600;font-size:.875rem;border:2px solid #e2e8f0;transition:all .2s;white-space:nowrap}
.kt:hover{border-color:#e11d48;color:#e11d48}
.kt-active{background:#e11d48!important;color:white!important;border-color:#e11d48!important}
.kt span{padding:.125rem .5rem;border-radius:12px;font-size:.75rem}
.kt:not(.kt-active) span{background:#f1f5f9;color:#64748b}
.kt-active span{background:rgba(255,255,255,.3);color:white}

/* Search result */
.search-result-info{background:#fff7ed;color:#92400e;border:1px solid #fed7aa;padding:.75rem 1.25rem;border-radius:8px;margin-bottom:1.5rem;display:flex;align-items:center;gap:.5rem;flex-wrap:wrap}
.search-result-info a{margin-left:auto;color:#b45309;font-weight:600}

/* Group header */
.group-header{display:flex;align-items:center;gap:1rem;margin:2.5rem 0 1.25rem}
.gh-line{flex:1;height:2px;background:#e2e8f0}
.group-header span{font-size:.875rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;white-space:nowrap;padding:0 .25rem}

/* Cards */
.sp-cards{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.5rem;margin-bottom:2rem}
.sp-card{background:white;border-radius:14px;box-shadow:0 2px 8px rgba(0,0,0,.07);overflow:hidden;transition:all .25s;text-decoration:none;display:flex;flex-direction:column;border:2px solid transparent}
.sp-card:hover{transform:translateY(-4px);box-shadow:0 12px 32px rgba(0,0,0,.12);border-color:#fecdd3}
.sc-bar{height:5px;flex-shrink:0}
.sc-body{padding:1.5rem;flex:1}
.sc-icon{width:56px;height:56px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.625rem;margin-bottom:1rem}
.sc-title{font-size:1.0625rem;font-weight:700;color:#1e293b;line-height:1.4;margin-bottom:.625rem}
.sc-desc{font-size:.875rem;color:#64748b;line-height:1.6;margin-bottom:.875rem}
.sc-meta{display:flex;justify-content:space-between;align-items:center;font-size:.8125rem;color:#94a3b8}
.sc-free{color:#16a34a;font-weight:700;display:flex;align-items:center;gap:.3rem}
.sc-footer{display:flex;justify-content:space-between;align-items:center;padding:1rem 1.5rem;color:#64748b;font-weight:600;font-size:.9375rem;transition:all .25s}
.sp-card:hover .sc-footer{color:#e11d48}

/* Empty */
.sp-empty{text-align:center;padding:4rem 2rem}
.sp-empty i{font-size:4rem;color:#cbd5e1;display:block;margin-bottom:1rem}
.sp-empty h3{font-size:1.5rem;font-weight:700;color:#1e293b;margin-bottom:.5rem}
.sp-empty a{color:#e11d48;font-weight:600}

/* CTA */
.sp-cta{background:white;border-radius:16px;box-shadow:0 2px 8px rgba(0,0,0,.07);padding:2rem;display:flex;align-items:center;justify-content:space-between;gap:2rem;flex-wrap:wrap;border:2px solid #fee2e8;margin-top:3rem}
.cta-text{display:flex;align-items:center;gap:1.25rem}
.cta-text>i{font-size:2.5rem;color:#e11d48}
.cta-text h3{font-size:1.25rem;font-weight:700;color:#1e293b;margin-bottom:.25rem}
.cta-text p{color:#64748b}
.cta-btns{display:flex;gap:.75rem;flex-wrap:wrap}
.btn{display:inline-flex;align-items:center;gap:.5rem;padding:.75rem 1.5rem;border-radius:8px;font-weight:600;font-size:.9375rem;text-decoration:none;border:none;cursor:pointer;transition:all .2s}
.btn-primary{background:linear-gradient(135deg,#e11d48,#be123c);color:white}
.btn-primary:hover{transform:translateY(-2px);box-shadow:0 4px 12px rgba(225,29,72,.35)}
.btn-secondary{background:#f1f5f9;color:#475569}
.btn-secondary:hover{background:#e2e8f0}

@media(max-width:768px){
    .sp-hero h1{font-size:2rem}
    .sp-cards{grid-template-columns:1fr}
    .sp-cta{flex-direction:column}
    .cta-btns{width:100%}
    .cta-btns .btn{flex:1;justify-content:center}
    .kat-tabs{gap:.375rem}
    .kt{font-size:.8125rem;padding:.5rem .875rem}
}
</style>
@endsection