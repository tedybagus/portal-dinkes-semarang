@extends('layouts.public.app')

@section('title', $information->title)

@section('content')
<!-- Breadcrumb -->
<section class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('ppid.index') }}">Informasi Publik</a></li>
                <li class="breadcrumb-item active">{{ Str::limit($information->title, 50) }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Main Content -->
<section class="detail-section">
    <div class="container">
        <div class="detail-grid">
            <!-- Main Content -->
            <div class="detail-main">
                <div class="detail-card">
                    <!-- Header -->
                    <div class="detail-header">
                        <span class="category-badge" style="background: {{ $information->category->color }}20; color: {{ $information->category->color }}; border-left: 4px solid {{ $information->category->color }}">
                            <i class="fas fa-folder"></i>
                            {{ $information->category->name }}
                        </span>
                        <span class="year-badge">Tahun {{ $information->year }}</span>
                    </div>

                    <!-- Title -->
                    <h1 class="detail-title">{{ $information->title }}</h1>

                    @if($information->information_number)
                    <p class="info-number">
                        <i class="fas fa-hashtag"></i> {{ $information->information_number }}
                    </p>
                    @endif

                    <!-- Metadata -->
                    <div class="metadata-grid">
                        @if($information->type)
                        <div class="meta-item">
                            <i class="fas fa-tag"></i>
                            <div>
                                <span class="meta-label">Jenis</span>
                                <span class="meta-value">{{ $information->type }}</span>
                            </div>
                        </div>
                        @endif

                        @if($information->responsible_unit)
                        <div class="meta-item">
                            <i class="fas fa-building"></i>
                            <div>
                                <span class="meta-label">Penanggung Jawab</span>
                                <span class="meta-value">{{ $information->responsible_unit }}</span>
                            </div>
                        </div>
                        @endif

                        <div class="meta-item">
                            <i class="fas fa-file"></i>
                            <div>
                                <span class="meta-label">Format</span>
                                <span class="meta-value">{{ ucfirst($information->information_format) }}</span>
                            </div>
                        </div>

                        @if($information->published_date)
                        <div class="meta-item">
                            <i class="fas fa-calendar"></i>
                            <div>
                                <span class="meta-label">Tanggal Terbit</span>
                                <span class="meta-value">{{ $information->published_date->format('d M Y') }}</span>
                            </div>
                        </div>
                        @endif

                        @if($information->permanent_validity)
                            <div class="meta-item">
                                <i class="fas fa-infinity"></i>
                                <div>
                                    <span class="meta-label">Masa Berlaku</span>
                                    <span class="meta-value">Berlaku Selamanya</span>
                                </div>
                            </div>
                        @elseif($information->validity_period)
                            <div class="meta-item">
                                <i class="fas fa-clock"></i>
                                <div>
                                    <span class="meta-label">Masa Berlaku</span>
                                    <span class="meta-value">{{ $information->validity_period->format('d M Y') }}</span>
                                </div>
                            </div>
                        @endif

                        <div class="meta-item">
                            <i class="fas fa-eye"></i>
                            <div>
                                <span class="meta-label">Dilihat</span>
                                <span class="meta-value">{{ $information->view_count }} kali</span>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($information->description)
                    <div class="description-section">
                        <h3>Deskripsi</h3>
                        <p>{{ $information->description }}</p>
                    </div>
                    @endif

                    <!-- Actions -->
                    <div class="action-buttons">
                        @if($information->file_path)
                        <a href="{{ route('ppid.download', $information->id) }}" class="btn btn-primary">
                            <i class="fas fa-download"></i> Download File ({{ $information->file_size }})
                        </a>
                        @endif

                        @if($information->external_link)
                        <a href="{{ $information->external_link }}" target="_blank" class="btn btn-info">
                            <i class="fas fa-external-link-alt"></i> Kunjungi Link
                        </a>
                        @endif

                        <a href="{{ route('ppid.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <!-- Keywords -->
                    @if($information->keywords)
                    <div class="keywords-section">
                        <strong>Kata Kunci:</strong>
                        @foreach(explode(',', $information->keywords) as $keyword)
                        <span class="keyword-badge">{{ trim($keyword) }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="detail-sidebar">
                <!-- Related Information -->
                @if($relatedInformations->count() > 0)
                <div class="sidebar-card">
                    <h3><i class="fas fa-list"></i> Informasi Terkait</h3>
                    <div class="related-list">
                        @foreach($relatedInformations as $related)
                        <a href="{{ route('ppid.show', $related->id) }}" class="related-item">
                            <span class="related-badge" style="background: {{ $related->category->color }}"></span>
                            <div class="related-info">
                                <strong>{{ $related->title }}</strong>
                                <small>{{ $related->year }}</small>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    <a href="{{ route('ppid.by-category', $information->category->slug) }}" class="btn-view-all">
                        Lihat Semua <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                @endif

                <!-- Category Info -->
                <div class="sidebar-card category-info" style="border-top-color: {{ $information->category->color }}">
                    <h3>{{ $information->category->name }}</h3>
                    <p>{{ $information->category->description }}</p>
                    <a href="{{ route('ppid.by-category', $information->category->slug) }}" class="btn btn-outline">
                        Lihat Kategori Ini
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.breadcrumb-section {
    background: #f8fafc;
    padding: 1.5rem 0;
}

.breadcrumb {
    background: white;
    padding: 0.75rem 1.25rem;
    border-radius: 8px;
    display: inline-flex;
}

.breadcrumb-item a {
    color: #3b82f6;
    text-decoration: none;
}

.breadcrumb-item.active {
    color: #64748b;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    color: #cbd5e1;
    padding: 0 0.5rem;
}

.detail-section {
    padding: 3rem 0;
    background: #f8fafc;
}

.detail-grid {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 2rem;
}

.detail-card {
    background: white;
    padding: 2.5rem;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.detail-header {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
}

.category-badge {
    position: relative;
    padding: 0.325rem 1.25rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9375rem;
 
}

.year-badge {
    padding: 0.625rem 1.25rem;
    background: #f1f5f9;
    border-radius: 8px;
    font-weight: 600;
    color: #475569;
    margin-left: 1em;
    margin-top: 1em;
}

.detail-title {
    font-size: 2rem;
    font-weight: 800;
    color: #1e293b;
    line-height: 1.3;
    margin-bottom: 1rem;
}

.info-number {
    color: #64748b;
    font-size: 0.9375rem;
    margin-bottom: 2rem;
}

.metadata-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
    padding: 2rem;
    background: #f8fafc;
    border-radius: 12px;
}

.meta-item {
    display: flex;
    gap: 1rem;
    align-items: start;
}

.meta-item i {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #dbeafe;
    color: #3b82f6;
    border-radius: 8px;
    font-size: 1.125rem;
}

.meta-label {
    display: block;
    font-size: 0.8125rem;
    color: #64748b;
    margin-bottom: 0.25rem;
}

.meta-value {
    display: block;
    font-weight: 600;
    color: #1e293b;
}

.description-section {
    margin: 2rem 0;
    padding: 2rem;
    background: #f8fafc;
    border-left: 4px solid #3b82f6;
    border-radius: 8px;
}

.description-section h3 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1rem;
}

.description-section p {
    color: #475569;
    line-height: 1.8;
    font-size: 1rem;
}

.action-buttons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    margin: 2rem 0;
}

.btn {
    padding: 0.875rem 1.75rem;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.btn-info {
    background: linear-gradient(135deg, #06b6d4, #0891b2);
    color: white;
}

.btn-secondary {
    background: #f1f5f9;
    color: #475569;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.keywords-section {
    padding-top: 2rem;
    border-top: 2px solid #f1f5f9;
}

.keyword-badge {
    display: inline-block;
    padding: 0.375rem 0.875rem;
    background: #eff6ff;
    color: #3b82f6;
    border-radius: 6px;
    font-size: 0.875rem;
    margin: 0.25rem;
}

.sidebar-card {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 1.5rem;
}

.sidebar-card h3 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1.5rem;
}

.related-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.related-item {
    display: flex;
    gap: 0.75rem;
    padding: 0.875rem;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s;
}

.related-item:hover {
    background: #f8fafc;
}

.related-badge {
    width: 4px;
    border-radius: 2px;
}

.related-info strong {
    display: block;
    color: #1e293b;
    font-size: 0.9375rem;
    margin-bottom: 0.25rem;
}

.related-info small {
    color: #64748b;
    font-size: 0.8125rem;
}

.btn-view-all {
    display: block;
    text-align: center;
    padding: 0.75rem;
    background: #f1f5f9;
    color: #3b82f6;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-view-all:hover {
    background: #3b82f6;
    color: white;
}

.category-info {
    border-top: 4px solid;
}

.category-info p {
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.btn-outline {
    border: 2px solid #3b82f6;
    color: #3b82f6;
    background: white;
}

.btn-outline:hover {
    background: #3b82f6;
    color: white;
}

@media (max-width: 1024px) {
    .detail-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .detail-title {
        font-size: 1.5rem;
    }
    
    .metadata-grid {
        grid-template-columns: 1fr;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection