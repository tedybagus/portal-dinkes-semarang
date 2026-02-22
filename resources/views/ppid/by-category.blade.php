@extends('layouts.public.app')

@section('title', $category->name . ' - Informasi Publik')

@section('content')
<!-- Hero Section -->
<section class="category-hero" style="background: linear-gradient(135deg, {{ $category->color }}dd 0%, {{ $category->color }} 100%);">
    <div class="container">
        <div class="hero-content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ppid.index') }}">Informasi Publik</a></li>
                    <li class="breadcrumb-item active">{{ $category->name }}</li>
                </ol>
            </nav>
            
            <div class="category-header">
                <div class="category-icon" style="background: rgba(255,255,255,0.2);">
                    <i class="fas {{ $category->icon ?? 'fa-folder-open' }}"></i>
                </div>
                <div>
                    <h1 class="hero-title">{{ $category->name }}</h1>
                    <p class="hero-description">{{ $category->description }}</p>
                </div>
            </div>

            <div class="category-stats">
                <div class="stat-item">
                    <div class="stat-number">{{ $informations->total() }}</div>
                    <div class="stat-label">Total Informasi</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $informations->where('year', date('Y'))->count() }}</div>
                    <div class="stat-label">Tahun Ini</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $informations->sum('download_count') }}</div>
                    <div class="stat-label">Total Download</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="category-content">
    <div class="container">
        <div class="content-wrapper">
            <!-- Sidebar Filter -->
            <aside class="filter-sidebar">
                <div class="filter-card">
                    <div class="filter-header">
                        <h3><i class="fas fa-filter"></i> Filter</h3>
                        @if(request()->has('year'))
                        <a href="{{ route('ppid.by-category', $category->slug) }}" class="btn-reset">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                        @endif
                    </div>

                    <div class="filter-body">
                        <label>Filter by Tahun:</label>
                        <div class="year-buttons">
                            <a href="{{ route('ppid.by-category', $category->slug) }}" 
                               class="year-btn {{ !request('year') ? 'active' : '' }}">
                                Semua
                            </a>
                            @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                            <a href="{{ route('ppid.by-category', ['slug' => $category->slug, 'year' => $y]) }}" 
                               class="year-btn {{ request('year') == $y ? 'active' : '' }}">
                                {{ $y }}
                            </a>
                            @endfor
                        </div>
                    </div>
                </div>

                <div class="filter-card">
                    <a href="{{ route('ppid.index') }}" class="btn-all-categories">
                        <i class="fas fa-th"></i> Lihat Semua Kategori
                    </a>
                </div>

                <div class="filter-card">
                    <h4>Kategori Lainnya:</h4>
                    <div class="other-categories">
                        @foreach($categories as $cat)
                            @if($cat->id != $category->id)
                            <a href="{{ route('ppid.by-category', $cat->slug) }}" 
                               class="cat-link"
                               style="border-left-color: {{ $cat->color }}">
                                <span>{{ $cat->name }}</span>
                                <span class="count">{{ $cat->informations_count }}</span>
                            </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </aside>

            <!-- Information List -->
            <div class="info-main">
                @if($informations->total() > 0)
                <div class="list-header">
                    <h2>
                        Menampilkan {{ $informations->count() }} dari {{ $informations->total() }} Informasi
                        @if(request('year'))
                        <span style="color: {{ $category->color }}">Tahun {{ request('year') }}</span>
                        @endif
                    </h2>
                </div>

                <div class="info-list">
                    @foreach($informations as $info)
                    <div class="info-item" data-aos="fade-up">
                        <div class="item-header">
                            <span class="year-badge">{{ $info->year }}</span>
                        </div>

                        <div class="item-body">
                            <h3 class="item-title">{{ $info->title }}</h3>
                            
                            @if($info->information_number)
                            <p class="item-number">
                                <i class="fas fa-hashtag"></i> {{ $info->information_number }}
                            </p>
                            @endif

                            @if($info->description)
                            <p class="item-description">{{ Str::limit($info->description, 200) }}</p>
                            @endif

                            @if($info->published_date)
                            <p class="item-date">
                                <i class="fas fa-calendar"></i> Dipublikasikan: {{ $info->published_date->format('d M Y') }}
                            </p>
                            @endif
                        </div>

                        <div class="item-footer">
                            <div class="item-meta">
                                <span><i class="fas fa-eye"></i> {{ $info->view_count }}</span>
                                <span><i class="fas fa-download"></i> {{ $info->download_count }}</span>
                            </div>
                            
                            <div class="item-actions">
                                @if($info->file_path)
                                <a href="{{ route('ppid.download', $info->id) }}" 
                                   class="btn-download"
                                   title="Download {{ $info->file_size ?? 'file' }}">
                                    <i class="fas fa-download"></i> Download
                                    @if($info->file_size)
                                    <small>({{ $info->file_size }})</small>
                                    @endif
                                </a>
                                @endif

                                @if($info->external_link)
                                <a href="{{ $info->external_link }}" 
                                   target="_blank" 
                                   class="btn-link"
                                   title="Kunjungi link eksternal">
                                    <i class="fas fa-external-link-alt"></i> Link
                                </a>
                                @endif

                                <a href="{{ route('ppid.show', $info->id) }}" class="btn-detail">
                                    Detail <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                @if($informations->hasPages())
                <div class="pagination-wrapper">
                    {{ $informations->appends(request()->query())->links() }}
                </div>
                @endif

                @else
                <div class="empty-state">
                    <i class="fas fa-inbox fa-4x"></i>
                    <h3>Tidak Ada Informasi</h3>
                    <p>
                        Belum ada informasi untuk kategori {{ $category->name }}
                        @if(request('year'))
                        tahun {{ request('year') }}
                        @endif
                    </p>
                    @if(request('year'))
                    <a href="{{ route('ppid.by-category', $category->slug) }}" class="btn btn-primary">
                        Lihat Semua Tahun
                    </a>
                    @else
                    <a href="{{ route('ppid.index') }}" class="btn btn-primary">
                        Lihat Kategori Lain
                    </a>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<style>
.category-hero {
    padding: 3rem 0 4rem;
    margin-bottom: 3rem;
}

.hero-content {
    color: white;
}

.breadcrumb {
    background: rgba(255,255,255,0.1);
    padding: 0.75rem 1.25rem;
    border-radius: 8px;
    display: inline-flex;
    margin-bottom: 2rem;
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
    padding: 0 0.5rem;
}

.category-header {
    display: flex;
    align-items: center;
    gap: 2rem;
    margin-bottom: 2rem;
}

.category-icon {
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 16px;
    font-size: 2.5rem;
}

.hero-title {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
}

.hero-description {
    font-size: 1.125rem;
    opacity: 0.95;
}

.category-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
}

.stat-item {
    text-align: center;
    padding: 1.5rem;
    background: rgba(255,255,255,0.1);
    border-radius: 12px;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.875rem;
    opacity: 0.9;
}

.category-content {
    padding: 0 0 4rem;
    background: #f8fafc;
}

.content-wrapper {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 2rem;
}

.filter-sidebar {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.filter-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.filter-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f1f5f9;
}

.filter-header h3 {
    font-size: 1rem;
    font-weight: 700;
    margin: 0;
}

.btn-reset {
    color: #3b82f6;
    font-size: 0.875rem;
    text-decoration: none;
}

.filter-body label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: #64748b;
    margin-bottom: 0.75rem;
}

.year-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.year-btn {
    padding: 0.5rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    color: #475569;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.3s;
}

.year-btn:hover,
.year-btn.active {
    border-color: #3b82f6;
    background: #3b82f6;
    color: white;
}

.btn-all-categories {
    display: block;
    width: 100%;
    padding: 0.875rem;
    background: #3b82f6;
    color: white;
    text-align: center;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-all-categories:hover {
    background: #2563eb;
}

.filter-card h4 {
    font-size: 0.875rem;
    font-weight: 600;
    color: #64748b;
    margin-bottom: 0.75rem;
}

.other-categories {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.cat-link {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem;
    border-left: 3px solid;
    background: #f8fafc;
    border-radius: 4px;
    text-decoration: none;
    color: #475569;
    transition: all 0.3s;
}

.cat-link:hover {
    background: #f1f5f9;
    transform: translateX(4px);
}

.cat-link .count {
    background: #e2e8f0;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.list-header h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 2rem;
}

.info-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.info-item {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s;
}

.info-item:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    transform: translateY(-2px);
}

.item-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #f1f5f9;
}

.year-badge {
    padding: 0.375rem 0.75rem;
    background: #f1f5f9;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 600;
    color: #475569;
}

.item-body {
    padding: 1.5rem;
}

.item-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.75rem;
    line-height: 1.4;
}

.item-number {
    font-size: 0.875rem;
    color: #64748b;
    margin-bottom: 0.75rem;
}

.item-description {
    color: #475569;
    line-height: 1.7;
    margin-bottom: 0.75rem;
}

.item-date {
    font-size: 0.875rem;
    color: #94a3b8;
}

.item-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem;
    border-top: 1px solid #f1f5f9;
    background: #f8fafc;
    border-radius: 0 0 12px 12px;
}

.item-meta {
    display: flex;
    gap: 1rem;
    font-size: 0.875rem;
    color: #64748b;
}

.item-actions {
    display: flex;
    gap: 0.75rem;
}

.btn-download,
.btn-link,
.btn-detail {
    padding: 0.625rem 1.25rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9375rem;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-download {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.btn-download:hover {
    background: linear-gradient(135deg, #059669, #047857);
    transform: translateY(-2px);
}

.btn-download small {
    opacity: 0.9;
    font-size: 0.75rem;
}

.btn-link {
    background: #06b6d4;
    color: white;
}

.btn-link:hover {
    background: #0891b2;
}

.btn-detail {
    background: #3b82f6;
    color: white;
}

.btn-detail:hover {
    background: #2563eb;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 12px;
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

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    display: inline-block;
}

.btn-primary {
    background: #3b82f6;
    color: white;
}

@media (max-width: 1024px) {
    .content-wrapper {
        grid-template-columns: 1fr;
    }

    .category-stats {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .category-header {
        flex-direction: column;
        text-align: center;
    }

    .hero-title {
        font-size: 2rem;
    }

    .item-footer {
        flex-direction: column;
        gap: 1rem;
    }

    .item-actions {
        width: 100%;
        flex-direction: column;
    }

    .btn-download,
    .btn-link,
    .btn-detail {
        width: 100%;
        justify-content: center;
    }
}
</style>

<link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({duration: 600, once: true});
</script>
@endsection