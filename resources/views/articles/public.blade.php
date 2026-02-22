@extends('layouts.public.app')

@section('title', 'Berita Terkini')

@push('styles')
<style>
    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, var(--navy-deep) 0%, var(--navy) 100%);
        color: white;
        padding: 3rem 0 2rem;
        margin-bottom: 3rem;
    }

    .header-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .page-subtitle {
        font-size: 1.125rem;
        color: rgba(255, 255, 255, 0.9);
    }

    /* Articles Grid */
    .articles-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 2rem 4rem;
    }

    .articles-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }

    /* Article Card */
    .article-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s;
        border: 2px solid transparent;
    }

    .article-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
        border-color: var(--navy);
    }

    .card-image-wrapper {
        position: relative;
        width: 100%;
        height: 220px;
        overflow: hidden;
        background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
    }

    .card-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .article-card:hover .card-image {
        transform: scale(1.1);
    }

    .card-body {
        padding: 1.5rem;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--gray-800);
        margin-bottom: 0.75rem;
        line-height: 1.4;
    }
    .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid var(--gray-200);
        }

    .card-title a {
        color: var(--gray-800);
        text-decoration: none;
    }

    .card-title a:hover {
        color: var(--navy);
    }

    .card-excerpt {
        font-size: 0.9375rem;
        color: var(--gray-600);
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .card-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 0.875rem;
        color: var(--gray-600);
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }

    .meta-item i {
        color: var(--navy);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .articles-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }

        .articles-grid {
            grid-template-columns: 1fr;
        }
    }
    .btn-read {
            padding: 0.625rem 1.25rem;
            background: var(--navy);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-read:hover {
            background: var(--navy-deep);
            transform: translateX(2px);
        }
    .btn-back {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding: 0.5rem 1.25rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(-2px);
        }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="header-container">
        <h1 class="page-title">Berita Terkini</h1>
        <p class="page-subtitle">Informasi dan berita kesehatan terbaru untuk Anda</p>
    </div>
</div>
 <!-- Filter & Search -->
    <div class="filter-section">
        <div class="filter-card">
            <form action="{{ route('articles.public') }}" method="GET">
                <div class="filter-grid">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-search"></i> Cari Artikel
                        </label>
                        <input 
                            type="text" 
                            name="search" 
                            class="form-input" 
                            placeholder="Judul artikel atau konten..."
                            value="{{ request('search') }}"
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-folder"></i> Kategori
                        </label>
                        <select name="category" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn-filter">
                            <i class="fas fa-filter"></i>
                            Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Category Tabs -->
    <div class="category-tabs">
        <a href="{{ route('articles.public') }}" class="tab-item {{ !request('category') ? 'active' : '' }}">
            <i class="fas fa-th"></i>
            Semua
            <span class="tab-badge">{{ $totalArticles }}</span>
        </a>
        @foreach($categories as $category)
            <a href="{{ route('articles.public', ['category' => $category->id]) }}" 
               class="tab-item {{ request('category') == $category->id ? 'active' : '' }}">
                <i class="fas fa-newspaper"></i>
                {{ $category->name }}
                <span class="tab-badge">{{ $category->articles_count }}</span>
            </a>
        @endforeach
    </div>

    <!-- Featured Article -->
    @if(isset($featuredArticle) && $featuredArticle)
        <div class="featured-section">
            <div class="featured-card">
                <img 
                    src="{{ $featuredArticle->image ? asset('storage/' . $featuredArticle->image) : 'https://via.placeholder.com/600x400/1e40af/ffffff?text=Featured+Article' }}" 
                    alt="{{ $featuredArticle->title }}" 
                    class="featured-image"
                >
                <div class="featured-content">
                    <div class="featured-label">
                        <i class="fas fa-star"></i>
                        Artikel Unggulan
                    </div>
                    <h2 class="featured-title">{{ $featuredArticle->title }}</h2>
                    <p class="featured-excerpt">{{ Str::limit(strip_tags($featuredArticle->content), 200) }}</p>
                    <div class="card-meta">
                        <div class="meta-item">
                            <i class="fas fa-user"></i>
                            <span>{{ $featuredArticle->author->name ?? 'Admin' }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-calendar"></i>
                            <span>{{ $featuredArticle->article_date ? $featuredArticle->article_date->format('d M Y') : '-' }}</span>
                        </div>
                    </div>
                    <a href="{{ route('articles.show', $featuredArticle->id) }}" class="btn-read">
                        Baca Selengkapnya
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Results Header -->
    <div class="results-header">
        <div class="results-count">
            Menampilkan <strong>{{ $articles->count() }}</strong> dari <strong>{{ $articles->total() }}</strong> artikel
        </div>
    </div>
<!-- Articles Grid -->
<div class="articles-container">
    @if($articles->count() > 0)
        <div class="articles-grid">
            @foreach($articles as $article)
                <article class="article-card">
                    <div class="card-image-wrapper">
                        <img 
                            src="{{ $article->image ? asset('storage/' . $article->image) : 'https://via.placeholder.com/400x220/1e40af/ffffff?text=News' }}" 
                            alt="{{ $article->title }}" 
                            class="card-image"
                        >
                    </div>
                    
                    <div class="card-body">
                        <h3 class="card-title">
                            <a href="{{ route('articles.show', $article->id) }}">
                                {{ $article->title }}
                            </a>
                        </h3>
                        
                        <p class="card-excerpt">
                            {{ Str::limit(strip_tags($article->content), 120) }}
                        </p>
                        <div class="card-footer">
                                <div class="author-info">
                                    <div class="author-avatar">
                                        {{ strtoupper(substr($article->penulis ?? 'A', 0, 1)) }}
                                    </div>
                                    <span class="author-name">{{ $article->penulis ?? 'Admin' }}</span>
                                </div>
                                
                                <a href="{{ route('articles.show', $article->id) }}" class="btn-read">
                                    Baca
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>

                        <div class="card-meta">
                            <div class="meta-item">
                                <i class="fas fa-calendar"></i>
                                <span>{{ $article->article_date ? $article->article_date->format('d M Y') : '-' }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-eye"></i>
                                <span>{{ $article->views ?? 0 }} views</span>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($articles->hasPages())
            <div style="margin-top: 2rem; display: flex; justify-content: center;">
                {{ $articles->links() }}
            </div>
        @endif
    @else
        <div style="text-align: center; padding: 4rem 2rem;">
            <i class="fas fa-newspaper" style="font-size: 4rem; color: var(--gray-300); margin-bottom: 1rem;"></i>
            <h3 style="font-size: 1.5rem; color: var(--gray-700); margin-bottom: 0.5rem;">Belum Ada Artikel</h3>
            <p style="color: var(--gray-600);">Maaf, belum ada artikel yang dipublikasikan saat ini.</p>
        </div>
    @endif
</div>
@endsection