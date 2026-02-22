@extends('layouts.public.app')

@section('title', 'Informasi Publik (PPID)')
@push('styles')
    <style>
        /* Input utama */
.form-control {
    width: 100%;
    padding: 12px 14px;
    font-size: 14px;
    border-radius: 10px;
    border: 1px solid #d1d5db;
    background-color: #f9fafb;
    transition: all 0.3s ease;
    outline: none;
}

/* Focus effect */
.form-control:focus {
    border-color: #2563eb;
    background-color: #ffffff;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
}

/* Hover */
.form-control:hover {
    border-color: #94a3b8;
}

/* Placeholder */
.form-control::placeholder {
    color: #94a3b8;
    font-style: italic;
}

/* Disabled */
.form-control:disabled {
    background-color: #e5e7eb;
    cursor: not-allowed;
    opacity: 0.7;
}

/* Error state */
.form-control.is-invalid {
    border-color: #dc2626;
    background-color: #fef2f2;
}

.form-control.is-invalid:focus {
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.15);
}

/* Success state */
.form-control.is-valid {
    border-color: #16a34a;
    background-color: #f0fdf4;
}

.form-control.is-valid:focus {
    box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.15);
}

/* Textarea khusus */
textarea.form-control {
    min-height: 120px;
    resize: vertical;
}
    </style>
@endpush
@section('content')
<!-- Hero Section -->
<section class="ppid-hero">
    <div class="container">
        <div class="hero-content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Informasi Publik</li>
                </ol>
            </nav>
            <h1 class="hero-title">
                <i class="fas fa-folder-open"></i>
                Daftar Informasi Publik
            </h1>
            <p class="hero-description">
                Akses informasi publik Dinas Kesehatan sesuai UU No. 14 Tahun 2008
            </p>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="ppid-content">
    <div class="container">
        <div class="content-grid">
            <!-- Sidebar -->
            <aside class="ppid-sidebar">
                <!-- Categories Filter -->
                <div class="filter-card">
                    <h3><i class="fas fa-filter"></i> Kategori</h3>
                    <div class="category-list">
                        <a href="{{ route('ppid.index') }}" class="category-item {{ !request('category') ? 'active' : '' }}">
                            <span class="cat-name">Semua Kategori</span>
                            <span class="cat-count">{{ $informations->total() }}</span>
                        </a>
                        @foreach($categories as $cat)
                        <a href="{{ route('ppid.index', ['category' => $cat->slug]) }}" 
                           class="category-item {{ request('category') == $cat->slug ? 'active' : '' }}"
                           style="border-left-color: {{ $cat->color }}">
                            <span class="cat-name">{{ $cat->name }}</span>
                            <span class="cat-count">{{ $cat->informations_count }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Year Filter -->
                <div class="filter-card">
                    <h3><i class="fas fa-calendar"></i> Tahun</h3>
                    <select class="form-control" onchange="window.location.href=this.value">
                        <option value="{{ route('ppid.index') }}">Semua Tahun</option>
                        @foreach($years as $year)
                        <option value="{{ route('ppid.index', array_merge(request()->all(), ['year' => $year])) }}" 
                                {{ request('year') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Search -->
                <div class="filter-card">
                    <h3><i class="fas fa-search"></i> Pencarian</h3>
                    <form method="GET">
                        <input type="hidden" name="category" value="{{ request('category') }}">
                        <input type="hidden" name="year" value="{{ request('year') }}">
                        <div class="search-box">
                            <input type="text" name="search" class="form-control" placeholder="Cari informasi..." value="{{ request('search') }}">
                            <button type="submit" class="btn-search"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </aside>

            <!-- Information List -->
            <div class="ppid-main">
                @if(request()->hasAny(['category', 'year', 'search']))
                <div class="filter-info">
                    <span>Menampilkan {{ $informations->total() }} hasil</span>
                    <a href="{{ route('ppid.index') }}" class="btn-reset">
                        <i class="fas fa-redo"></i> Reset Filter
                    </a>
                </div>
                @endif

                <div class="information-grid">
                    @forelse($informations as $info)
                    <div class="info-card" data-aos="fade-up">
                        <div class="card-header" style="border-top-color: {{ $info->category->color }}">
                            <span class="category-badge" style="background: {{ $info->category->color }}20; color: {{ $info->category->color }}">
                                {{ $info->category->name }}
                            </span>
                            <br>
                            <span class="year-badge">{{ $info->year }}</span>
                        </div>
                        <div class="card-body">
                            <h3 class="info-title">{{ $info->title }}</h3>
                            @if($info->information_number)
                            <p class="info-number">
                                <i class="fas fa-hashtag"></i> {{ $info->information_number }}
                            </p>
                            @endif
                            <p class="info-description">
                                {{ Str::limit($info->description, 120) }}
                            </p>
                        </div>
                        <div class="card-footer">
                            <div class="info-meta">
                                <span><i class="fas fa-eye"></i> {{ $info->view_count }}</span>
                                <span><i class="fas fa-download"></i> {{ $info->download_count }}</span>
                            </div>
                            <a href="{{ route('ppid.show', $info->id) }}" class="btn-detail">
                                Lihat Detail <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <i class="fas fa-inbox fa-4x"></i>
                        <h3>Tidak Ada Informasi</h3>
                        <p>Belum ada informasi publik yang tersedia untuk kategori atau tahun ini.</p>
                        <a href="{{ route('ppid.index') }}" class="btn btn-primary">Lihat Semua</a>
                    </div>
                    @endforelse
                </div>

                @if($informations->hasPages())
                <div class="pagination-wrapper">
                    {{ $informations->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<style>
.ppid-hero {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    padding: 3rem 0 4rem;
    margin-bottom: -2rem;
}

.hero-content {
    color: white;
}

.breadcrumb {
    background: rgba(255,255,255,0.1);
    padding: 0.75rem 1.25rem;
    border-radius: 8px;
    display: inline-flex;
    margin-bottom: 1.5rem;
    margin-left:2.5em;
}

.breadcrumb-item a {
    color: rgba(255,255,255,0.9);
    text-decoration: none;
}

.breadcrumb-item.active {
    color: white;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    color: rgba(255,255,255,0.7);
    padding: 0 0.5rem;
}

.hero-title {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 1rem;
    margin-left:1em;
}

.hero-description {
    font-size: 1.125rem;
    opacity: 0.95;
    margin-left:2.5em;
}

.ppid-content {
    padding: 4rem 0;
    background: #f8fafc;
    
}

.content-grid {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 2rem;
    margin-left:2em;
}

.filter-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 1.5rem;
}

.filter-card h3 {
    font-size: 1rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.category-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.category-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    border-left: 3px solid #e2e8f0;
    border-radius: 4px;
    text-decoration: none;
    color: #475569;
    transition: all 0.3s;
}

.category-item:hover,
.category-item.active {
    background: #f1f5f9;
    color: #1e293b;
}

.cat-count {
    background: #e2e8f0;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.8125rem;
    font-weight: 600;
}

.search-box {
    display: flex;
    gap: 0.5rem;
}

.btn-search {
    padding: 0.75rem 1.25rem;
    background: #3b82f6;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}

.filter-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem;
    background: white;
    border-radius: 8px;
    margin-bottom: 1.5rem;
}

.btn-reset {
    color: #3b82f6;
    text-decoration: none;
    font-weight: 600;
}

.information-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 1.5rem;
}

.info-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s;
}

.info-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}

.info-card .card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem;
    border-top: 4px solid;
    border-bottom: 1px solid #f1f5f9;
}

.category-badge {
    padding: 0.375rem 0.875rem;
    border-radius: 6px;
    font-size: 0.8125rem;
    font-weight: 600;
}

.year-badge {
    padding: 0.375rem 0.75rem;
    background: #f1f5f9;
    border-radius: 6px;
    font-size: 0.8125rem;
    font-weight: 600;
    color: #64748b;
}

.info-card .card-body {
    padding: 1.5rem;
}

.info-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
    line-height: 1.4;
}

.info-number {
    font-size: 0.8125rem;
    color: #64748b;
    margin-bottom: 0.75rem;
}

.info-description {
    color: #475569;
    font-size: 0.9375rem;
    line-height: 1.6;
}

.info-card .card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem;
    border-top: 1px solid #f1f5f9;
}

.info-meta {
    display: flex;
    gap: 1rem;
    font-size: 0.875rem;
    color: #64748b;
}

.btn-detail {
    color: #3b82f6;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9375rem;
}

.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 4rem 2rem;
}

.empty-state i {
    color: #cbd5e1;
    margin-bottom: 1.5rem;
}

.empty-state h3 {
    color: #64748b;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #94a3b8;
    margin-bottom: 1.5rem;
}

@media (max-width: 1024px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .information-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<!-- AOS Animation -->
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 600,
        once: true
    });
</script>
@endsection