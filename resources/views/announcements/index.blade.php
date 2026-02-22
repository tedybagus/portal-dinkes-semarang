@extends('layouts.public.app')
@section('title', 'Pengumuman')

@section('content')
<div class="announcements-page">
    {{-- Hero Section --}}
    <section class="announcements-hero">
        <div class="hero-container">
            <div class="hero-icon">
                <i class="fas fa-megaphone"></i>
            </div>
            <h1>Pengumuman Terbaru</h1>
            <p>Informasi dan pengumuman penting dari Dinas Kesehatan Kabupaten Semarang</p>
        </div>
    </section>

    <div class="container">
        {{-- Pinned Announcements --}}
        @if($pinnedAnnouncements->count())
        <section class="pinned-section">
            <h2 class="section-title">
                <i class="fas fa-thumbtack"></i>
                Pengumuman Penting
            </h2>
            <div class="pinned-grid">
                @foreach($pinnedAnnouncements as $announcement)
                <div class="pinned-card">
                    <div class="pin-badge">
                        <i class="fas fa-thumbtack"></i>
                        Penting
                    </div>
                    @if($announcement->image)
                    <div class="card-image">
                        <img src="{{ Storage::url($announcement->image) }}" alt="{{ $announcement->title }}">
                    </div>
                    @endif
                    <div class="card-content">
                        <h3 class="card-title">{{ $announcement->title }}</h3>
                        <p class="card-excerpt">{{ $announcement->excerpt }}</p>
                        <div class="card-meta">
                            <span><i class="far fa-calendar"></i> {{ $announcement->start_date?->format('d M Y') ?? $announcement->created_at->format('d M Y') }}</span>
                            <span><i class="far fa-eye"></i> {{ $announcement->view_count }}</span>
                        </div>
                        <a href="{{ route('announcements.show', $announcement) }}" class="btn-read-more">
                            Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        {{-- All Announcements --}}
        <section class="announcements-section">
            <h2 class="section-title">
                <i class="fas fa-list"></i>
                Semua Pengumuman
            </h2>

            @if($announcements->count())
            <div class="announcements-grid">
                @foreach($announcements as $announcement)
                <div class="announcement-card">
                    @if($announcement->image)
                    <div class="card-image">
                        <img src="{{ Storage::url($announcement->image) }}" alt="{{ $announcement->title }}">
                        @if($announcement->is_pinned)
                        <div class="pin-badge-small">
                            <i class="fas fa-thumbtack"></i>
                        </div>
                        @endif
                    </div>
                    @endif
                    <div class="card-content">
                        <div class="card-date">
                            <i class="far fa-calendar"></i>
                            {{ $announcement->start_date?->format('d M Y') ?? $announcement->created_at->format('d M Y') }}
                        </div>
                        <h3 class="card-title">{{ $announcement->title }}</h3>
                        <p class="card-excerpt">{{ $announcement->excerpt }}</p>
                        
                        @if($announcement->hasFile())
                        <div class="file-badge">
                            <i class="fas {{ $announcement->file_icon }}"></i>
                            File Terlampir
                        </div>
                        @endif

                        <div class="card-footer">
                            <span class="view-count">
                                <i class="far fa-eye"></i>
                                {{ $announcement->view_count }}x dilihat
                            </span>
                            <a href="{{ route('announcements.show', $announcement) }}" class="btn-read">
                                Baca <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($announcements->hasPages())
            <div class="pagination-wrapper">
                {{ $announcements->links() }}
            </div>
            @endif
            @else
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h3>Belum Ada Pengumuman</h3>
                <p>Belum ada pengumuman yang dipublikasikan saat ini.</p>
            </div>
            @endif
        </section>
    </div>
</div>

<style>
/* Base */
.announcements-page {
    background: #f8fafc;
    min-height: 100vh;
}

/* Hero */
.announcements-hero {
    background:linear-gradient(#000428,#004e92);
    padding: 4rem 1rem 5rem;
    text-align: center;
    position: relative;
}

.announcements-hero::after {
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

.announcements-hero h1 {
    font-size: 2.5rem;
    font-weight: 800;
    color: white;
    margin-bottom: 0.75rem;
}

.announcements-hero p {
    font-size: 1.125rem;
    color: rgba(255,255,255,.85);
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2.5rem 1rem 5rem;
}

/* Section Title */
.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.section-title i {
    color: #dc2626;
}

/* Pinned Section */
.pinned-section {
    margin-bottom: 3rem;
}

.pinned-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 1.5rem;
}

.pinned-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,.08);
    border: 2px solid #fef3c7;
    position: relative;
    transition: all 0.3s;
}

.pinned-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,.12);
}

.pin-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    z-index: 10;
    box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
}

.pin-badge-small {
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
    background: #f59e0b;
    color: white;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0,0,0,.2);
}

.card-image {
    position: relative;
    width: 100%;
    height: 200px;
    overflow: hidden;
}

.card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.pinned-card:hover .card-image img,
.announcement-card:hover .card-image img {
    transform: scale(1.05);
}

.card-content {
    padding: 1.5rem;
}

.card-date {
    font-size: 0.875rem;
    color: #64748b;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.card-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.75rem;
    line-height: 1.4;
}

.card-excerpt {
    font-size: 0.9375rem;
    color: #475569;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.card-meta {
    display: flex;
    gap: 1.5rem;
    font-size: 0.875rem;
    color: #64748b;
    margin-bottom: 1.25rem;
}

.card-meta span {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-read-more {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    color: white;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9375rem;
    transition: all 0.2s;
}

.btn-read-more:hover {
    transform: translateX(4px);
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
}

/* Announcements Grid */
.announcements-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.announcement-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
    border: 2px solid transparent;
    transition: all 0.3s;
}

.announcement-card:hover {
    border-color: #fecaca;
    box-shadow: 0 8px 24px rgba(0,0,0,.1);
}

.file-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: #eff6ff;
    color: #1e40af;
    border-radius: 20px;
    font-size: 0.8125rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1rem;
    border-top: 1px solid #e2e8f0;
}

.view-count {
    font-size: 0.875rem;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-read {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    color: white;
    font-weight: 600;
    font-size: 0.9375rem;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-read:hover {
    gap: 0.625rem;
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
    .announcements-hero h1 {
        font-size: 1.875rem;
    }
    
    .hero-icon {
        font-size: 3rem;
    }
    
    .pinned-grid,
    .announcements-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection