@extends('layouts.public.app')
@section('title', 'Kritik dan Saran Masyarakat')

@section('content')
<div class="reviews-page">

    {{-- Hero Section --}}
    <section class="review-hero">
        <div class="hero-container">
            <div class="hero-icon">
                <i class="fas fa-star"></i>
            </div>
            <h1>Kritik dan Saran Masyarakat</h1>
            <p>Review dari masyarakat yang telah menggunakan layanan kami</p>
        </div>
    </section>

    <div class="review-container">

        {{-- ══════════════════════════════════════════════════════════
            STATISTICS BOX
            ══════════════════════════════════════════════════════════ --}}
        <div class="stats-overview">
            {{-- Overall Rating --}}
            <div class="overall-rating">
                <div class="rating-number">{{ number_format($averageRating, 1) }}</div>
                <div class="rating-stars">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($averageRating))
                            <i class="fas fa-star"></i>
                        @elseif($i - 0.5 <= $averageRating)
                            <i class="fas fa-star-half-alt"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                </div>
                <div class="rating-count">{{ $totalReviews }} review</div>
            </div>

            {{-- Rating Distribution - FIXED --}}
            <div class="rating-breakdown">
                @foreach([5, 4, 3, 2, 1] as $star)
                <div class="rating-row">
                    <span class="rating-label">{{ $star }} <i class="fas fa-star"></i></span>
                    <div class="rating-bar">
                        <div class="rating-bar-fill" 
                             style="width: {{ $ratingPercentages[$star] ?? 0 }}%; 
                                    background: {{ $star >= 4 ? '#10b981' : ($star >= 3 ? '#f59e0b' : '#ef4444') }}">
                        </div>
                    </div>
                    <span class="rating-value">{{ $ratingDistribution[$star] ?? 0 }}</span>
                </div>
                @endforeach
                
                {{-- DEBUG: Show raw data --}}
                
            </div>
        </div>

        {{-- Filter Bar --}}
        <div class="filter-bar">
            <form action="{{ route('public.reviews.index') }}" method="GET" class="filter-form">
                <select name="rating" onchange="this.form.submit()" class="filter-select">
                    <option value="">Semua Rating</option>
                    @for($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                        {{ $i }} Bintang
                    </option>
                    @endfor
                </select>

                <select name="service" onchange="this.form.submit()" class="filter-select">
                    <option value="">Semua Layanan</option>
                    @foreach($serviceTypes as $key => $label)
                    <option value="{{ $key }}" {{ request('service') == $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>

                @if(request()->hasAny(['rating', 'service']))
                <a href="{{ route('public.reviews.index') }}" class="btn-reset">
                    <i class="fas fa-times"></i> Reset
                </a>
                @endif
            </form>

            <a href="{{ route('public.reviews.create') }}" class="btn-write-review">
                <i class="fas fa-edit"></i> Tulis Review
            </a>
        </div>

        {{-- Reviews Grid --}}
        @if($reviews->count())
        <div class="reviews-grid">
            @foreach($reviews as $review)
            <div class="review-card">
                <div class="reviewer-info">
                    <div class="reviewer-avatar">
                        @if($review->foto)
                        <img src="{{ Storage::url($review->foto) }}" alt="{{ $review->nama }}">
                        @else
                        <div class="avatar-initials" style="background: {{ sprintf('#%06X', mt_rand(0, 0xFFFFFF)) }}">
                            {{ strtoupper(substr($review->nama, 0, 2)) }}
                        </div>
                        @endif
                    </div>
                    <div class="reviewer-details">
                        <h3>{{ $review->nama }}</h3>
                        <div class="review-meta">
                            <span class="review-date">
                                <i class="far fa-clock"></i>
                                {{ $review->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                    <div class="review-rating">
                        @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= $review->rating ? 'star-filled' : 'star-empty' }}"></i>
                        @endfor
                    </div>
                </div>

                <div class="review-services">
                    @foreach($review->reviewServices as $svc)
                    <span class="service-badge">
                        <i class="fas fa-check"></i>
                        {{ \App\Models\Review::LAYANAN_TYPES[$svc->service_type] ?? $svc->service_type }}
                    </span>
                    @endforeach
                </div>

                <div class="review-text">
                    {{ $review->review_text }}
                </div>
            </div>
            @endforeach
        </div>

        {{-- ══════════════════════════════════════════════════════════
            BEAUTIFUL PAGINATION
            ══════════════════════════════════════════════════════════ --}}
<div style="display:flex;justify-content:center;align-items:center;margin-top:1rem;">
    {{ $reviews->links('vendor.pagination') }}
</div>
        @else
        <div class="empty-reviews">
            <i class="fas fa-comment-slash"></i>
            <h3>Belum ada review</h3>
            <p>Jadilah yang pertama memberikan review untuk layanan kami!</p>
            <a href="{{ route('public.reviews.create') }}" class="btn-primary">
                <i class="fas fa-edit"></i> Tulis Review Pertama
            </a>
        </div>
        @endif

        {{-- CTA --}}
        <div class="review-cta">
            <div class="cta-content">
                <i class="fas fa-edit"></i>
                <div>
                    <h3>Bagikan Pengalaman Anda</h3>
                    <p>Bantu masyarakat lain dengan memberikan review jujur tentang layanan kami</p>
                </div>
            </div>
            <a href="{{ route('public.reviews.create') }}" class="btn-cta">
                <i class="fas fa-star"></i> Tulis Review
            </a>
        </div>
    </div>
</div>

<style>
/* ══════════════════════════════════════════════════════════
   BASE STYLES
   ══════════════════════════════════════════════════════════ */
* { box-sizing: border-box; margin: 0; padding: 0; }
.reviews-page { background: #f8fafc; min-height: 100vh; }

/* ══════════════════════════════════════════════════════════
   HERO
   ══════════════════════════════════════════════════════════ */
.review-hero {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 60%, #b45309 100%);
    padding: 4rem 1rem 5rem;
    text-align: center;
    position: relative;
}
.review-hero::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 60px;
    background: #f8fafc;
    clip-path: ellipse(55% 100% at 50% 100%);
}
.hero-container { max-width: 700px; margin: 0 auto; }
.hero-icon { font-size: 4rem; color: rgba(255,255,255,.85); margin-bottom: 1rem; }
.review-hero h1 { font-size: 2.5rem; font-weight: 800; color: white; margin-bottom: .75rem; }
.review-hero p { font-size: 1.125rem; color: rgba(255,255,255,.85); }

.review-container { max-width: 1200px; margin: 0 auto; padding: 2.5rem 1rem 5rem; }

/* ══════════════════════════════════════════════════════════
   STATISTICS OVERVIEW
   ══════════════════════════════════════════════════════════ */
.stats-overview {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 2px 8px rgba(0,0,0,.08);
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 3rem;
    margin-bottom: 2rem;
}

.overall-rating {
    text-align: center;
    padding: 1rem;
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    border-radius: 12px;
}

.rating-number {
    font-size: 4rem;
    font-weight: 900;
    color: #92400e;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.rating-stars {
    font-size: 1.5rem;
    color: #f59e0b;
    margin-bottom: 0.75rem;
}

.rating-count {
    font-size: 1rem;
    color: #78350f;
    font-weight: 600;
}

/* Rating Breakdown */
.rating-breakdown {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    padding: 0.5rem 0;
}

.rating-row {
    display: grid;
    grid-template-columns: 70px 1fr 70px;
    align-items: center;
    gap: 1rem;
}

.rating-label {
    font-size: 0.9375rem;
    font-weight: 700;
    color: #374151;
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.rating-label i {
    color: #f59e0b;
    font-size: 0.875rem;
}

.rating-bar {
    height: 14px;
    background: #f1f5f9;
    border-radius: 20px;
    overflow: hidden;
    position: relative;
}

.rating-bar-fill {
    height: 100%;
    border-radius: 20px;
    transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.rating-value {
    text-align: right;
    font-weight: 800;
    color: #1e293b;
    font-size: 1rem;
}

/* ══════════════════════════════════════════════════════════
   FILTER BAR
   ══════════════════════════════════════════════════════════ */
.filter-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.filter-form {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.filter-select {
    padding: 0.625rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.9375rem;
    background: white;
    cursor: pointer;
    transition: border-color 0.2s;
}

.filter-select:focus {
    outline: none;
    border-color: #f59e0b;
}

.btn-reset {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1rem;
    background: #fee2e2;
    color: #991b1b;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.2s;
}

.btn-reset:hover {
    background: #fecaca;
}

.btn-write-review {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.9375rem;
    transition: all 0.2s;
}

.btn-write-review:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
}

/* ══════════════════════════════════════════════════════════
   REVIEWS GRID
   ══════════════════════════════════════════════════════════ */
.reviews-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.review-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
    border: 2px solid transparent;
    transition: all 0.25s;
}

.review-card:hover {
    border-color: #fde68a;
    box-shadow: 0 8px 24px rgba(0,0,0,.1);
}

.reviewer-info {
    display: grid;
    grid-template-columns: 48px 1fr auto;
    gap: 1rem;
    margin-bottom: 1rem;
}

.reviewer-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    overflow: hidden;
}

.reviewer-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-initials {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 1.125rem;
}

.reviewer-details h3 {
    font-size: 1rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.review-meta {
    font-size: 0.8125rem;
    color: #64748b;
}

.review-rating {
    display: flex;
    gap: 0.25rem;
}

.review-rating i {
    font-size: 0.875rem;
}

.star-filled {
    color: #f59e0b;
}

.star-empty {
    color: #e2e8f0;
}

.review-services {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.service-badge {
    padding: 0.25rem 0.75rem;
    background: #eff6ff;
    color: #1e40af;
    border-radius: 20px;
    font-size: 0.8125rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
}

.service-badge i {
    font-size: 0.75rem;
}

.review-text {
    color: #475569;
    line-height: 1.7;
    font-size: 0.9375rem;
}

/* ══════════════════════════════════════════════════════════
   BEAUTIFUL PAGINATION
   ══════════════════════════════════════════════════════════ */
.pagination-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: white;
    padding: 1rem 1.5rem;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.pagination-info span {
    color: #64748b;
    font-size: 0.9375rem;
}

.pagination-info strong {
    color: #1e293b;
    font-weight: 700;
}

.pagination-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 1rem;
}

/* Pagination Navigation */
nav[role="navigation"] {
    width: 100%;
}

nav[role="navigation"] > div {
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Hide default "Showing X to Y" text */
nav[role="navigation"] p {
    display: none;
}

/* Pagination links container */
.pagination {
    display: flex !important;
    gap: 0.5rem !important;
    list-style: none !important;
    padding: 0 !important;
    margin: 0 !important;
    align-items: center !important;
}

.pagination li {
    margin: 0 !important;
}

/* All links and buttons */
.pagination a,
.pagination span {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    min-width: 42px !important;
    height: 42px !important;
    padding: 0 0.875rem !important;
    border-radius: 10px !important;
    font-size: 0.9375rem !important;
    font-weight: 700 !important;
    text-decoration: none !important;
    transition: all 0.2s ease !important;
    border: 2px solid transparent !important;
}

/* Regular page link */
.pagination a {
    background: white !important;
    color: #475569 !important;
    border-color: #e2e8f0 !important;
}

.pagination a:hover {
    background: #fef3c7 !important;
    border-color: #f59e0b !important;
    color: #f59e0b !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.2) !important;
}

/* Active page (current page) */
.pagination .active span {
    background: linear-gradient(135deg, #f59e0b, #d97706) !important;
    color: white !important;
    border-color: #f59e0b !important;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.35) !important;
}

/* Disabled state (prev on first page, next on last page) */
.pagination .disabled span {
    background: #f8fafc !important;
    color: #cbd5e1 !important;
    border-color: #f1f5f9 !important;
    cursor: not-allowed !important;
}

/* Dots (ellipsis) */
.pagination .dots span {
    background: transparent !important;
    border-color: transparent !important;
    color: #94a3b8 !important;
    cursor: default !important;
}

.pagination .dots span:hover {
    background: transparent !important;
    transform: none !important;
    box-shadow: none !important;
    border-color: transparent !important;
}

/* ══════════════════════════════════════════════════════════
   EMPTY STATE & CTA
   ══════════════════════════════════════════════════════════ */
.empty-reviews {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
}

.empty-reviews i {
    font-size: 4rem;
    color: #cbd5e1;
    margin-bottom: 1rem;
}

.empty-reviews h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.empty-reviews p {
    color: #64748b;
    margin-bottom: 1.5rem;
}

.review-cta {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 2rem;
    flex-wrap: wrap;
    border: 2px solid #fef3c7;
    margin-top: 3rem;
}

.cta-content {
    display: flex;
    align-items: center;
    gap: 1.25rem;
}

.cta-content > i {
    font-size: 2.5rem;
    color: #f59e0b;
}

.cta-content h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.cta-content p {
    color: #64748b;
}

.btn-cta {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem 1.75rem;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 700;
    font-size: 1rem;
    transition: all 0.2s;
}

.btn-cta:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
}

/* ══════════════════════════════════════════════════════════
   RESPONSIVE
   ══════════════════════════════════════════════════════════ */
@media (max-width: 1024px) {
    .stats-overview {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
}

@media (max-width: 768px) {
    .reviews-grid {
        grid-template-columns: 1fr;
    }
    
    .filter-bar {
        flex-direction: column;
        align-items: stretch;
    }
    
    .filter-form {
        width: 100%;
    }
    
    .filter-select {
        flex: 1;
    }
    
    .btn-write-review {
        width: 100%;
        justify-content: center;
    }
    
    .review-cta {
        flex-direction: column;
    }
    
    .btn-cta {
        width: 100%;
        justify-content: center;
    }
    
    .pagination {
        gap: 0.375rem;
    }
    
    .pagination a,
    .pagination span {
        min-width: 38px;
        height: 38px;
        padding: 0 0.625rem;
        font-size: 0.875rem;
    }
    
    .pagination-info {
        flex-direction: column;
        text-align: center;
    }
}

@media (max-width: 640px) {
    .review-hero h1 {
        font-size: 1.875rem;
    }
    
    .hero-icon {
        font-size: 3rem;
    }
    
    .rating-number {
        font-size: 3rem;
    }
    
    .rating-row {
        grid-template-columns: 60px 1fr 50px;
        gap: 0.75rem;
    }
    .pagination {
        gap: 0.375rem !important;
    }
    
    .pagination a,
    .pagination span {
        min-width: 38px !important;
        height: 38px !important;
        padding: 0 0.625rem !important;
        font-size: 0.875rem !important;
    }
}
</style>

@endsection