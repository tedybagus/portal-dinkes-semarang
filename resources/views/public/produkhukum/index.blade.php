@extends('layouts.public.app')
@section('title', 'Produk Hukum')

@section('content')
<div class="produk-hukum-page">
    {{-- Hero Section --}}
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-icon">
                <i class="fas fa-gavel"></i>
            </div>
            <h1>Produk Hukum Daerah</h1>
            <p>Dokumentasi peraturan dan produk hukum Kabupaten Semarang</p>
            <div class="hero-stats">
                <div class="stat-item">
                    <i class="fas fa-file-alt"></i>
                    <span>{{ $totalDokumen }} Dokumen</span>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        {{-- Search & Filter Section --}}
        <div class="search-section">
            <form method="GET" class="search-form">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" 
                           name="search" 
                           class="search-input" 
                           placeholder="Cari nomor atau tentang..."
                           value="{{ request('search') }}">
                    <button type="submit" class="btn-search">Cari</button>
                </div>
                
                <div class="filter-row">
                    <select name="tahun" class="filter-select" onchange="this.form.submit()">
                        <option value="">Semua Tahun</option>
                        @foreach($tahuns as $tahun)
                            <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                        @endforeach
                    </select>

                    @if(request()->hasAny(['search', 'kategori', 'tahun']))
                        <a href="{{ route('produkhukum.index') }}" class="btn-reset-filter">
                            <i class="fas fa-times"></i>
                            Reset Filter
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Kategori Tabs --}}
        <div class="kategori-tabs">
            <a href="{{ route('produkhukum.index') }}" 
               class="tab-item {{ !request('kategori') ? 'active' : '' }}">
                <span>Semua</span>
                <span class="count">{{ $totalDokumen }}</span>
            </a>
            @foreach(\App\Models\ProdukHukum::KATEGORI as $key => $label)
                @if(isset($kategoriCounts[$key]) && $kategoriCounts[$key] > 0)
                <a href="{{ route('produkhukum.index', ['kategori' => $key]) }}" 
                   class="tab-item {{ request('kategori') == $key ? 'active' : '' }}">
                    <span>{{ $label }}</span>
                    <span class="count">{{ $kategoriCounts[$key] }}</span>
                </a>
                @endif
            @endforeach
        </div>

        {{-- Results --}}
        @if(request()->hasAny(['search', 'kategori', 'tahun']))
        <div class="result-info">
            <span>Menampilkan {{ $Produkhukum->total() }} dokumen</span>
            @if(request('search'))
                <span class="search-query">untuk "{{ request('search') }}"</span>
            @endif
        </div>
        @endif

        {{-- Documents Grid --}}
        @if($Produkhukum->count())
        <div class="documents-grid">
            @foreach($Produkhukum as $ph)
            <div class="doc-card">
                <div class="doc-header">
                    <div class="kategori-badge" style="background: {{ $ph->status_color }}20; color: {{ $ph->status_color }};">
                        {{ $ph->kategori_label }}
                    </div>
                    <div class="doc-year">{{ $ph->tahun }}</div>
                </div>

                <div class="doc-body">
                    <div class="doc-nomor">
                        <i class="fas fa-file-alt"></i>
                        Nomor {{ $ph->nomor }}/{{ $ph->tahun }}
                    </div>
                    
                    <h3 class="doc-title">{{ $ph->tentang }}</h3>

                    <div class="doc-meta">
                        <span class="meta-item">
                            <i class="far fa-calendar"></i>
                            {{ $ph->tanggal_penetapan->format('d M Y') }}
                        </span>
                        <span class="meta-item">
                            <i class="fas fa-download"></i>
                            {{ $ph->download_count }}x
                        </span>
                        <span class="meta-item">
                            <i class="fas fa-file-pdf"></i>
                            {{ $ph->file_size_readable }}
                        </span>
                    </div>
                </div>

                <div class="doc-footer">
                    <a href="{{ route('produkhukum.show', $ph) }}" class="btn-detail">
                        <i class="fas fa-eye"></i>
                        Lihat Detail
                    </a>
                    <a href="{{ route('produkhukum.download', $ph) }}" 
                       class="btn-download"
                       target="_blank">
                        <i class="fas fa-download"></i>
                        Download
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($Produkhukum->hasPages())
        <div class="pagination-wrapper">
            {{ $Produkhukum->links() }}
        </div>
        @endif
        @else
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h3>Tidak ada dokumen</h3>
            <p>{{ request()->hasAny(['search', 'kategori', 'tahun']) ? 'Tidak ada dokumen yang sesuai dengan pencarian' : 'Belum ada produk hukum yang dipublikasikan' }}</p>
        </div>
        @endif
    </div>
</div>

<style>
/* Base */
.produk-hukum-page {
    background: #f8fafc;
    min-height: 100vh;
}

/* Hero */
.hero-section {
    background: linear-gradient(135deg, #1e293b 0%, #334155 60%, #475569 100%);
    padding: 4rem 1rem 5rem;
    text-align: center;
    position: relative;
}

.hero-section::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 60px;
    background: #f8fafc;
    clip-path: ellipse(55% 100% at 50% 100%);
}

.hero-container {
    max-width: 700px;
    margin: 0 auto;
}

.hero-icon {
    font-size: 4rem;
    color: rgba(255,255,255,.85);
    margin-bottom: 1rem;
}

.hero-section h1 {
    font-size: 2.5rem;
    font-weight: 800;
    color: white;
    margin-bottom: 0.75rem;
}

.hero-section p {
    font-size: 1.125rem;
    color: rgba(255,255,255,.85);
    margin-bottom: 2rem;
}

.hero-stats {
    display: flex;
    justify-content: center;
    gap: 2rem;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.875rem 1.75rem;
    background: rgba(255,255,255,.1);
    border-radius: 12px;
    color: white;
    font-weight: 600;
    font-size: 1.125rem;
    backdrop-filter: blur(10px);
}

.stat-item i {
    font-size: 1.5rem;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2.5rem 1rem 5rem;
}

/* Search Section */
.search-section {
    background: white;
    padding: 2rem;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,.08);
    margin-bottom: 2rem;
}

.search-form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.search-box {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.5rem;
    background: #f8fafc;
    border-radius: 12px;
    border: 2px solid #e2e8f0;
    transition: border-color 0.2s;
}

.search-box:focus-within {
    border-color: #1e293b;
}

.search-box i {
    font-size: 1.25rem;
    color: #64748b;
}

.search-input {
    flex: 1;
    border: none;
    background: none;
    font-size: 1rem;
    color: #1e293b;
    outline: none;
}

.search-input::placeholder {
    color: #94a3b8;
}

.btn-search {
    padding: 0.75rem 2rem;
    background: linear-gradient(135deg, #1e293b, #334155);
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-search:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(30, 41, 59, 0.3);
}

.filter-row {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.filter-select {
    padding: 0.75rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.9375rem;
    cursor: pointer;
}

.btn-reset-filter {
    padding: 0.75rem 1.5rem;
    background: #fee2e2;
    color: #991b1b;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: background 0.2s;
}

.btn-reset-filter:hover {
    background: #fecaca;
}

/* Kategori Tabs */
.kategori-tabs {
    display: flex;
    gap: 0.75rem;
    margin-bottom: 2rem;
    overflow-x: auto;
    padding-bottom: 0.5rem;
}

.tab-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.875rem 1.5rem;
    background: white;
    border-radius: 12px;
    text-decoration: none;
    color: #64748b;
    font-weight: 600;
    transition: all 0.2s;
    white-space: nowrap;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
}

.tab-item:hover {
    color: #1e293b;
    transform: translateY(-2px);
}

.tab-item.active {
    background: linear-gradient(135deg, #1e293b, #334155);
    color: white;
    box-shadow: 0 4px 12px rgba(30, 41, 59, 0.3);
}

.tab-item .count {
    padding: 0.25rem 0.75rem;
    background: rgba(255,255,255,.2);
    border-radius: 20px;
    font-size: 0.875rem;
}

.tab-item.active .count {
    background: rgba(255,255,255,.2);
}

/* Result Info */
.result-info {
    padding: 1rem 1.5rem;
    background: white;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    font-size: 0.9375rem;
    color: #64748b;
    box-shadow: 0 1px 3px rgba(0,0,0,.06);
}

.search-query {
    font-weight: 700;
    color: #1e293b;
}

/* Documents Grid */
.documents-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.doc-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
    transition: all 0.3s;
    border: 2px solid transparent;
}

.doc-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,.12);
    border-color: #e2e8f0;
}

.doc-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem 1.5rem;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
}

.kategori-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8125rem;
    font-weight: 700;
}

.doc-year {
    font-size: 1.25rem;
    font-weight: 800;
    color: #1e293b;
}

.doc-body {
    padding: 1.5rem;
}

.doc-nomor {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: #64748b;
    margin-bottom: 1rem;
}

.doc-nomor i {
    color: #ef4444;
}

.doc-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    line-height: 1.5;
    margin-bottom: 1rem;
}

.doc-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1.25rem;
    padding-top: 1rem;
    border-top: 1px solid #e2e8f0;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #64748b;
}

.meta-item i {
    color: #94a3b8;
}

.doc-footer {
    display: grid;
    grid-template-columns: 1fr 1fr;
    border-top: 1px solid #e2e8f0;
}

.btn-detail,
.btn-download {
    padding: 1rem;
    text-align: center;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9375rem;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-detail {
    background: #f8fafc;
    color: #475569;
    border-right: 1px solid #e2e8f0;
}

.btn-detail:hover {
    background: #f1f5f9;
    color: #1e293b;
}

.btn-download {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.btn-download:hover {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
}

.empty-state i {
    font-size: 4rem;
    color: #cbd5e1;
    margin-bottom: 1rem;
}

.empty-state h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #64748b;
}

/* Pagination */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}

/* Responsive */
@media (max-width: 768px) {
    .hero-section h1 {
        font-size: 1.875rem;
    }
    
    .hero-icon {
        font-size: 3rem;
    }
    
    .documents-grid {
        grid-template-columns: 1fr;
    }
    
    .kategori-tabs {
        overflow-x: scroll;
    }
    
    .search-box {
        flex-direction: column;
        align-items: stretch;
    }
    
    .btn-search {
        width: 100%;
    }
}
</style>
@endsection