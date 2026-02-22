@extends('layouts.public.app')
@section('title', $announcement->title)

@section('content')
<div class="announcement-detail-page">
    
    <div class="detail-container">
        {{-- Breadcrumb --}}
        <nav class="breadcrumb">
            <a href="{{ url('/') }}"><i class="fas fa-home"></i> Home</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('announcements.index') }}">Pengumuman</a>
            <i class="fas fa-chevron-right"></i>
            <span>{{ Str::limit($announcement->title, 50) }}</span>
        </nav>

        <div class="detail-grid">
            {{-- Main Content --}}
            <div class="main-content">
                {{-- Header --}}
                <div class="announcement-header">
                    @if($announcement->is_pinned)
                    <div class="pinned-badge">
                        <i class="fas fa-star"></i>
                        Pengumuman Penting
                    </div>
                    @endif

                    <h1>{{ $announcement->title }}</h1>

                    <div class="announcement-meta">
                        <div class="meta-item">
                            <i class="far fa-calendar"></i>
                            {{ $announcement->start_date ? $announcement->start_date->format('d F Y, H:i') : $announcement->created_at->format('d F Y, H:i') }}
                        </div>
                        <div class="meta-item">
                            <i class="far fa-eye"></i>
                            {{ $announcement->view_count }} kali dilihat
                        </div>
                        @if($announcement->creator)
                        <div class="meta-item">
                            <i class="far fa-user"></i>
                            {{ $announcement->creator->name }}
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Featured Image --}}
                @if($announcement->hasImage())
                <div class="featured-image">
                    <img src="{{ Storage::url($announcement->image) }}" alt="{{ $announcement->title }}">
                </div>
                @endif

                {{-- Content --}}
                <div class="announcement-content">
                    {!! nl2br(e($announcement->content)) !!}
                </div>

                {{-- File Download --}}
                @if($announcement->hasFile())
                <div class="file-download-box">
                    <div class="file-info">
                        <div class="file-icon">
                            <i class="fas {{ $announcement->file_icon }}"></i>
                        </div>
                        <div class="file-details">
                            <h4>Lampiran File</h4>
                            <p class="file-name">{{ $announcement->file_name }}</p>
                            <p class="file-size">{{ $announcement->file_size_readable }} · {{ strtoupper($announcement->file_type) }}</p>
                        </div>
                    </div>
                    <a href="{{ route('announcements.download', $announcement->id) }}" 
                       class="btn-download"
                       target="_blank">
                        <i class="fas fa-download"></i>
                        Download
                    </a>
                </div>
                @endif

                {{-- Actions --}}
                <div class="announcement-actions">
                    <button onclick="window.print()" class="btn-action">
                        <i class="fas fa-print"></i>
                        Cetak
                    </button>
                    <button onclick="shareAnnouncement()" class="btn-action">
                        <i class="fas fa-share-alt"></i>
                        Bagikan
                    </button>
                    <a href="{{ route('announcements.index') }}" class="btn-action">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </a>
                </div>

                {{-- Related Announcements --}}
                @if($relatedAnnouncements->count())
                <div class="related-section">
                    <h3><i class="fas fa-newspaper"></i> Pengumuman Lainnya</h3>
                    <div class="related-grid">
                        @foreach($relatedAnnouncements as $related)
                        <a href="{{ route('announcements.show', $related->id) }}" class="related-card">
                            @if($related->hasImage())
                            <div class="related-image">
                                <img src="{{ Storage::url($related->image) }}" alt="{{ $related->title }}">
                            </div>
                            @endif
                            <div class="related-content">
                                <h4>{{ $related->title }}</h4>
                                <p>{{ Str::limit($related->excerpt, 80) }}</p>
                                <div class="related-meta">
                                    <span><i class="far fa-calendar"></i> {{ $related->created_at->format('d M Y') }}</span>
                                    <span><i class="far fa-eye"></i> {{ $related->view_count }}</span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="sidebar">
                {{-- Info Box --}}
                <div class="info-box">
                    <h3><i class="fas fa-info-circle"></i> Informasi</h3>
                    <div class="info-item">
                        <span class="info-label">Tanggal Mulai:</span>
                        <span class="info-value">
                            {{ $announcement->start_date ? $announcement->start_date->format('d M Y') : 'Segera' }}
                        </span>
                    </div>
                    @if($announcement->end_date)
                    <div class="info-item">
                        <span class="info-label">Tanggal Selesai:</span>
                        <span class="info-value">{{ $announcement->end_date->format('d M Y') }}</span>
                    </div>
                    @endif
                    <div class="info-item">
                        <span class="info-label">Dilihat:</span>
                        <span class="info-value">{{ $announcement->view_count }}x</span>
                    </div>
                    @if($announcement->hasFile())
                    <div class="info-item">
                        <span class="info-label">Lampiran:</span>
                        <span class="info-value">{{ strtoupper($announcement->file_type) }}</span>
                    </div>
                    @endif
                </div>

                {{-- Contact Box --}}
                <div class="contact-box">
                    <h3><i class="fas fa-phone"></i> Kontak Kami</h3>
                    <p>Untuk informasi lebih lanjut, hubungi:</p>
                    <div class="contact-list">
                        <a href="https://dkk.semarangkab.go.id" target="_blank" class="contact-item">
                            <i class="fas fa-globe"></i>
                            dkk.semarangkab.go.id
                        </a>
                        <a href="tel:(024)6923955" class="contact-item">
                            <i class="fas fa-phone"></i>
                            (024) 6923955
                        </a>
                        <a href="https://instagram.com/dinkes_kabsemarang" target="_blank" class="contact-item">
                            <i class="fab fa-instagram"></i>
                            @dinkes_kabsemarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Base */
* { box-sizing: border-box; margin: 0; padding: 0; }
.announcement-detail-page { background: #f8fafc; min-height: 100vh; padding: 2rem 1rem; }
.detail-container { max-width: 1200px; margin: 0 auto; }

/* Breadcrumb */
.breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 2rem;
    font-size: 0.875rem;
}
.breadcrumb a {
    color: #64748b;
    text-decoration: none;
    transition: color 0.2s;
}
.breadcrumb a:hover {
    color: #be123c;
}
.breadcrumb i.fa-chevron-right {
    color: #cbd5e1;
    font-size: 0.75rem;
}
.breadcrumb span {
    color: #1e293b;
    font-weight: 600;
}

/* Grid Layout */
.detail-grid {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 2rem;
}

.main-content {
    background: white;
    border-radius: 16px;
    padding: 2.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
}

/* Header */
.announcement-header {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 2px solid #f1f5f9;
}

.pinned-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, #be123c, #e11d48);
    color: white;
    border-radius: 20px;
    font-weight: 700;
    font-size: 0.875rem;
    margin-bottom: 1rem;
}

.announcement-header h1 {
    font-size: 2rem;
    font-weight: 800;
    color: #1e293b;
    line-height: 1.3;
    margin-bottom: 1.5rem;
}

.announcement-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #64748b;
    font-size: 0.9375rem;
}

.meta-item i {
    color: #be123c;
}

/* Featured Image */
.featured-image {
    margin-bottom: 2rem;
    border-radius: 12px;
    overflow: hidden;
}

.featured-image img {
    width: 100%;
    height: auto;
    display: block;
}

/* Content */
.announcement-content {
    font-size: 1.0625rem;
    line-height: 1.8;
    color: #374151;
    margin-bottom: 2rem;
}

.announcement-content p {
    margin-bottom: 1rem;
}

/* File Download Box */
.file-download-box {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    border-radius: 12px;
    margin-bottom: 2rem;
}

.file-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.file-icon {
    width: 56px;
    height: 56px;
    background: white;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0,0,0,.1);
}

.file-icon i {
    font-size: 1.75rem;
    color: #be123c;
}

.file-details h4 {
    font-size: 0.875rem;
    color: #78350f;
    font-weight: 700;
    text-transform: uppercase;
    margin-bottom: 0.25rem;
}

.file-name {
    font-size: 1rem;
    font-weight: 700;
    color: #92400e;
    margin-bottom: 0.25rem;
}

.file-size {
    font-size: 0.875rem;
    color: #a16207;
}

.btn-download {
    padding: 0.875rem 1.75rem;
    background: linear-gradient(135deg, #be123c, #e11d48);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.625rem;
    transition: all 0.2s;
}

.btn-download:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(190, 18, 60, 0.4);
}

/* Actions */
.announcement-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    padding: 1.5rem 0;
    border-top: 2px solid #f1f5f9;
}

.btn-action {
    padding: 0.75rem 1.25rem;
    background: white;
    color: #475569;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
}

.btn-action:hover {
    background: #f8fafc;
    border-color: #be123c;
    color: #be123c;
}

/* Related Section */
.related-section {
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 2px solid #f1f5f9;
}

.related-section h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.625rem;
}

.related-section h3 i {
    color: #be123c;
}

.related-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
}

.related-card {
    background: white;
    border: 2px solid #f1f5f9;
    border-radius: 12px;
    overflow: hidden;
    text-decoration: none;
    transition: all 0.2s;
}

.related-card:hover {
    border-color: #fecdd3;
    box-shadow: 0 4px 12px rgba(0,0,0,.1);
}

.related-image {
    width: 100%;
    height: 150px;
    overflow: hidden;
}

.related-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.related-card:hover .related-image img {
    transform: scale(1.05);
}

.related-content {
    padding: 1.25rem;
}

.related-content h4 {
    font-size: 1rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
    line-height: 1.4;
}

.related-content p {
    font-size: 0.875rem;
    color: #64748b;
    margin-bottom: 0.75rem;
}

.related-meta {
    display: flex;
    gap: 1rem;
    font-size: 0.8125rem;
    color: #94a3b8;
}

.related-meta span {
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

/* Sidebar */
.sidebar {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.info-box,
.contact-box {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
}

.info-box h3,
.contact-box h3 {
    font-size: 1rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-box h3 i,
.contact-box h3 i {
    color: #be123c;
}

.info-item {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f1f5f9;
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    color: #64748b;
    font-size: 0.875rem;
}

.info-value {
    color: #1e293b;
    font-weight: 600;
    font-size: 0.875rem;
}

.contact-box p {
    color: #64748b;
    font-size: 0.9375rem;
    margin-bottom: 1rem;
}

.contact-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    background: #f8fafc;
    border-radius: 8px;
    color: #475569;
    text-decoration: none;
    transition: all 0.2s;
}

.contact-item:hover {
    background: #fef3c7;
    color: #92400e;
}

.contact-item i {
    color: #be123c;
    width: 20px;
    text-align: center;
}

/* Print Styles */
@media print {
    .breadcrumb,
    .announcement-actions,
    .related-section,
    .sidebar,
    .btn-download {
        display: none !important;
    }
    
    .detail-grid {
        grid-template-columns: 1fr;
    }
    
    .announcement-detail-page {
        padding: 0;
    }
}

/* Responsive */
@media (max-width: 1024px) {
    .detail-grid {
        grid-template-columns: 1fr;
    }
    
    .sidebar {
        order: 2;
    }
}

@media (max-width: 768px) {
    .main-content {
        padding: 1.5rem;
    }
    
    .announcement-header h1 {
        font-size: 1.5rem;
    }
    
    .file-download-box {
        flex-direction: column;
        gap: 1rem;
    }
    
    .btn-download {
        width: 100%;
        justify-content: center;
    }
    
    .related-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
function shareAnnouncement() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $announcement->title }}',
            text: '{{ $announcement->excerpt }}',
            url: window.location.href
        }).catch(err => {
            console.log('Error sharing:', err);
        });
    } else {
        // Fallback: Copy to clipboard
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('Link berhasil disalin ke clipboard!');
        });
    }
}
</script>

@endsection