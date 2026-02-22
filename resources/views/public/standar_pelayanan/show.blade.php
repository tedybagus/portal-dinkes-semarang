{{-- public/standar_pelayanan/show.blade.php --}}
@extends('layouts.public.app')
@section('title', $standarPelayanan->nama . ' – Dinas Kesehatan Kabupaten Semarang')

@section('content')
<div class="sp-detail">

    {{-- ── HEADER ── --}}
    <div class="detail-hero" style="border-bottom:5px solid {{ $standarPelayanan->warna }}">
        <div class="dh-inner">
            {{-- Breadcrumb --}}
            <nav class="sp-breadcrumb">
                <a href="/"><i class="fas fa-home"></i></a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('public.standar_pelayanan.index') }}">Standar Pelayanan</a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('public.standar_pelayanan.index', ['kategori' => $standarPelayanan->kategori]) }}">
                    {{ $standarPelayanan->kategori }}
                </a>
                <i class="fas fa-chevron-right"></i>
                <span>{{ Str::limit($standarPelayanan->nama, 50) }}</span>
            </nav>

            <div class="dh-content">
                <div class="dh-icon" style="background:{{ $standarPelayanan->warna }}18;color:{{ $standarPelayanan->warna }}">
                    <i class="fas {{ $standarPelayanan->icon }}"></i>
                </div>
                <div class="dh-text">
                    <span class="dh-kat">{{ $standarPelayanan->kategori }}</span>
                    <h1>{{ $standarPelayanan->nama }}</h1>
                    @if($standarPelayanan->deskripsi)
                    <p>{{ $standarPelayanan->deskripsi }}</p>
                    @endif
                    <div class="dh-meta">
                        <span class="free-badge">
                            <i class="fas fa-check-circle"></i> GRATIS
                        </span>
                        <span>
                            <i class="fas fa-list-ul"></i>
                            {{ $standarPelayanan->total_persyaratan }} persyaratan
                        </span>
                        <span>
                            <i class="fas fa-eye"></i>
                            {{ number_format($standarPelayanan->view_count) }} dilihat
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="detail-container">
        <div class="detail-layout">

            {{-- ── PERSYARATAN ── --}}
            <div class="detail-main">

                {{-- Section navigasi --}}
                @if(count($standarPelayanan->persyaratan) > 1)
                <div class="sek-nav">
                    @foreach($standarPelayanan->persyaratan as $i => $sek)
                    <a href="#sek-{{ $i }}" class="sek-nav-item">
                        <i class="fas fa-list-ul"></i>
                        {{ $sek['judul'] }}
                        <span>{{ count($sek['items'] ?? []) }}</span>
                    </a>
                    @endforeach
                </div>
                @endif

                {{-- Persyaratan blocks --}}
                @foreach($standarPelayanan->persyaratan as $i => $sek)
                <div class="req-block" id="sek-{{ $i }}"
                     style="--accent:{{ $standarPelayanan->warna }}">
                    <div class="rb-header" style="background:{{ $standarPelayanan->warna }}10;border-left:4px solid {{ $standarPelayanan->warna }}">
                        <h2>
                            <span class="rb-num" style="background:{{ $standarPelayanan->warna }};color:white">
                                {{ $i + 1 }}
                            </span>
                            {{ $sek['judul'] }}
                        </h2>
                        <span class="rb-count">{{ count($sek['items'] ?? []) }} item</span>
                    </div>

                    <ol class="req-list">
                        @foreach($sek['items'] ?? [] as $j => $item)
                        <li class="req-item">
                            <span class="ri-num" style="background:{{ $standarPelayanan->warna }}18;color:{{ $standarPelayanan->warna }}">
                                {{ str_pad($j + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            <span class="ri-text">{{ $item }}</span>
                        </li>
                        @endforeach
                    </ol>
                </div>
                @endforeach

                {{-- Catatan --}}
                @if($standarPelayanan->catatan)
                <div class="catatan-box">
                    <div class="cat-icon"><i class="fas fa-info-circle"></i></div>
                    <div>
                        <strong>Catatan Penting</strong>
                        <p>{{ $standarPelayanan->catatan }}</p>
                    </div>
                </div>
                @endif

                {{-- Action buttons --}}
                <div class="action-row">
                    <button onclick="window.print()" class="btn btn-outline">
                        <i class="fas fa-print"></i> Cetak
                    </button>
                    <button onclick="shareThis()" class="btn btn-outline">
                        <i class="fas fa-share-alt"></i> Bagikan
                    </button>
                    <a href="{{ route('public.standar_pelayanan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            {{-- ── SIDEBAR ── --}}
            <aside class="detail-aside">
                {{-- Info Box --}}
                <div class="aside-card info-box" style="border-top:4px solid {{ $standarPelayanan->warna }}">
                    <div class="ib-icon" style="background:{{ $standarPelayanan->warna }}18;color:{{ $standarPelayanan->warna }}">
                        <i class="fas {{ $standarPelayanan->icon }}"></i>
                    </div>
                    <h3>{{ $standarPelayanan->nama }}</h3>
                    <div class="ib-free">
                        <i class="fas fa-check-circle"></i>
                        SELURUH PELAYANAN GRATIS
                    </div>
                    <div class="ib-stat">
                        <span>Kategori</span>
                        <strong>{{ $standarPelayanan->kategori }}</strong>
                    </div>
                    <div class="ib-stat">
                        <span>Total Persyaratan</span>
                        <strong>{{ $standarPelayanan->total_persyaratan }} item</strong>
                    </div>
                </div>

                {{-- Kontak Dinas --}}
                <div class="aside-card">
                    <h4><i class="fas fa-building"></i> Dinas Kesehatan Kab. Semarang</h4>
                    <div class="contact-list">
                        <a href="https://dkk.semarangkab.go.id" target="_blank" class="ct-item">
                            <i class="fas fa-globe"></i>
                            <span>dkk.semarangkab.go.id</span>
                        </a>
                        <a href="tel:0246923955" class="ct-item">
                            <i class="fas fa-phone"></i>
                            <span>(024) 6923955</span>
                        </a>
                        <a href="https://instagram.com/dinkes_kabsemarang" target="_blank" class="ct-item">
                            <i class="fab fa-instagram"></i>
                            <span>@dinkes_kabsemarang</span>
                        </a>
                        <div class="ct-item ct-addr">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Jl. MT. Hariyono No.29, Kuncen, Ungaran, Kab. Semarang 50511</span>
                        </div>
                    </div>
                </div>

                {{-- Related --}}
                @if($related->count())
                <div class="aside-card">
                    <h4><i class="fas fa-layer-group"></i> Layanan Terkait</h4>
                    <div class="related-list">
                        @foreach($related as $r)
                        <a href="{{ route('public.standar_pelayanan.show', $r->slug) }}" class="rel-item">
                            <div class="rel-icon" style="background:{{ $r->warna }}18;color:{{ $r->warna }}">
                                <i class="fas {{ $r->icon }}"></i>
                            </div>
                            <div class="rel-text">
                                <strong>{{ Str::limit($r->nama, 55) }}</strong>
                                <span>{{ $r->total_persyaratan }} persyaratan</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </aside>
        </div>
    </div>
</div>

<style>
*{box-sizing:border-box;margin:0;padding:0}
.sp-detail{background:#f8fafc;min-height:100vh}

/* Hero Header */
.detail-hero{background:white;padding:1.5rem 0}
.dh-inner{max-width:1200px;margin:0 auto;padding:0 1.5rem}
.sp-breadcrumb{display:flex;align-items:center;gap:.5rem;color:#94a3b8;font-size:.875rem;margin-bottom:1.5rem;flex-wrap:wrap}
.sp-breadcrumb a{color:#64748b;text-decoration:none;transition:color .2s}
.sp-breadcrumb a:hover{color:#e11d48}
.sp-breadcrumb i.fa-chevron-right{font-size:.6875rem}
.sp-breadcrumb span{color:#1e293b;font-weight:600}
.dh-content{display:flex;align-items:start;gap:1.5rem}
.dh-icon{width:80px;height:80px;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:2.25rem;flex-shrink:0}
.dh-text{flex:1}
.dh-kat{display:inline-block;padding:.25rem .875rem;background:#fff1f2;color:#e11d48;border-radius:20px;font-size:.8125rem;font-weight:700;margin-bottom:.75rem}
.dh-text h1{font-size:1.875rem;font-weight:800;color:#1e293b;line-height:1.3;margin-bottom:.75rem}
.dh-text p{color:#64748b;font-size:1rem;line-height:1.7;margin-bottom:1rem}
.dh-meta{display:flex;align-items:center;gap:1.5rem;flex-wrap:wrap;font-size:.9rem;color:#64748b}
.dh-meta i{margin-right:.3rem}
.free-badge{display:inline-flex;align-items:center;gap:.375rem;background:#d1fae5;color:#065f46;padding:.375rem .875rem;border-radius:20px;font-weight:700;font-size:.875rem}

/* Layout */
.detail-container{max-width:1200px;margin:0 auto;padding:2rem 1.5rem 5rem}
.detail-layout{display:grid;grid-template-columns:1fr 320px;gap:2rem}

/* Sek Nav */
.sek-nav{display:flex;gap:.5rem;flex-wrap:wrap;margin-bottom:1.5rem;padding:1rem;background:white;border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,.06)}
.sek-nav-item{display:inline-flex;align-items:center;gap:.5rem;padding:.5rem .875rem;border-radius:20px;border:2px solid #e2e8f0;color:#64748b;text-decoration:none;font-size:.875rem;font-weight:600;transition:all .2s}
.sek-nav-item:hover{border-color:#e11d48;color:#e11d48}
.sek-nav-item span{background:#f1f5f9;color:#64748b;padding:.1rem .4rem;border-radius:10px;font-size:.75rem}

/* Req Blocks */
.req-block{background:white;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,.06);overflow:hidden;margin-bottom:1.5rem;scroll-margin-top:1rem}
.rb-header{display:flex;justify-content:space-between;align-items:center;padding:1.125rem 1.5rem;gap:1rem}
.rb-header h2{font-size:1.125rem;font-weight:700;color:#1e293b;display:flex;align-items:center;gap:.75rem;margin:0}
.rb-num{width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.875rem;font-weight:800;flex-shrink:0}
.rb-count{font-size:.8125rem;color:#94a3b8;white-space:nowrap;background:#f8fafc;padding:.25rem .75rem;border-radius:20px;font-weight:600}
.req-list{list-style:none;padding:1.25rem 1.5rem;display:flex;flex-direction:column;gap:.75rem}
.req-item{display:flex;align-items:start;gap:1rem;padding:.875rem 1rem;background:#f8fafc;border-radius:8px;transition:background .2s}
.req-item:hover{background:#f0f9ff}
.ri-num{flex-shrink:0;width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.8125rem;font-weight:800;margin-top:.1rem}
.ri-text{color:#374151;line-height:1.6;font-size:.9375rem;flex:1}

/* Catatan */
.catatan-box{background:#fffbeb;border:2px solid #fde68a;border-radius:12px;padding:1.25rem;display:flex;gap:1rem;margin-bottom:1.5rem}
.cat-icon{font-size:1.5rem;color:#f59e0b;flex-shrink:0;margin-top:.1rem}
.catatan-box strong{display:block;color:#92400e;font-size:1rem;margin-bottom:.375rem}
.catatan-box p{color:#78350f;line-height:1.6;margin:0}

/* Action Row */
.action-row{display:flex;gap:.75rem;flex-wrap:wrap;margin-top:1.5rem}
.btn{display:inline-flex;align-items:center;gap:.5rem;padding:.75rem 1.25rem;border-radius:8px;font-weight:600;font-size:.9375rem;text-decoration:none;transition:all .2s;cursor:pointer}
.btn-outline{background:white;color:#475569;border:2px solid #e2e8f0}
.btn-outline:hover{border-color:#e11d48;color:#e11d48}
.btn-secondary{background:#f1f5f9;color:#475569;border:none}
.btn-secondary:hover{background:#e2e8f0}

/* Aside */
.aside-card{background:white;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,.06);padding:1.25rem;margin-bottom:1.5rem}
.aside-card h4{font-size:1rem;font-weight:700;color:#1e293b;display:flex;align-items:center;gap:.5rem;margin:0 0 1rem}
.aside-card h4 i{color:#e11d48}
.info-box .ib-icon{width:60px;height:60px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.75rem;margin-bottom:1rem}
.info-box h3{font-size:1.0625rem;font-weight:700;color:#1e293b;margin-bottom:.75rem;line-height:1.4}
.ib-free{display:flex;align-items:center;gap:.5rem;background:#d1fae5;color:#065f46;padding:.5rem .875rem;border-radius:8px;font-weight:700;font-size:.875rem;margin-bottom:1rem}
.ib-stat{display:flex;justify-content:space-between;padding:.5rem 0;border-bottom:1px solid #f1f5f9;font-size:.875rem}
.ib-stat:last-child{border:none}
.ib-stat span{color:#64748b}
.contact-list{display:flex;flex-direction:column;gap:.5rem}
.ct-item{display:flex;align-items:start;gap:.75rem;padding:.5rem;border-radius:6px;color:#475569;text-decoration:none;font-size:.875rem;transition:background .2s}
.ct-item:hover{background:#f8fafc;color:#e11d48}
.ct-item i{color:#94a3b8;margin-top:.15rem;width:16px;flex-shrink:0}
.ct-addr{cursor:default}
.ct-addr:hover{color:#475569}
.related-list{display:flex;flex-direction:column;gap:.625rem}
.rel-item{display:flex;align-items:center;gap:.875rem;padding:.75rem;border-radius:8px;text-decoration:none;transition:background .2s;border:1px solid #f1f5f9}
.rel-item:hover{background:#f8fafc;border-color:#e2e8f0}
.rel-icon{width:40px;height:40px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.125rem;flex-shrink:0}
.rel-text strong{display:block;color:#1e293b;font-size:.875rem;font-weight:600;line-height:1.3;margin-bottom:.2rem}
.rel-text span{color:#94a3b8;font-size:.8125rem}

@media print{.detail-aside,.action-row,.sek-nav,.sp-breadcrumb{display:none}.detail-layout{grid-template-columns:1fr}.detail-hero{border:none}.req-item{background:#f8f8f8}}
@media(max-width:1024px){.detail-layout{grid-template-columns:1fr}}
@media(max-width:768px){.dh-content{flex-direction:column;gap:1rem}.dh-icon{width:60px;height:60px;font-size:1.75rem}.dh-text h1{font-size:1.375rem}.action-row{flex-direction:column}.btn{width:100%;justify-content:center}}
</style>

<script>
function shareThis(){
    if(navigator.share){
        navigator.share({
            title: '{{ $standarPelayanan->nama }}',
            text: 'Standar Pelayanan Dinas Kesehatan Kabupaten Semarang - {{ $standarPelayanan->nama }}',
            url: window.location.href
        });
    } else {
        navigator.clipboard.writeText(window.location.href)
            .then(()=>alert('Link berhasil disalin!'));
    }
}
// Smooth scroll for nav
document.querySelectorAll('.sek-nav-item').forEach(a=>{
    a.addEventListener('click',e=>{
        e.preventDefault();
        const target=document.querySelector(a.getAttribute('href'));
        if(target) target.scrollIntoView({behavior:'smooth',block:'start'});
    });
});
</script>
@endsection