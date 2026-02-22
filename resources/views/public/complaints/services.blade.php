@extends('layouts.public.app')

@section('title', 'Layanan Pengaduan')

@section('content')
<!-- Hero Section -->
<section class="services-hero">
    <div class="container">
        <h1><i class="fas fa-hands-helping"></i> Layanan Pengaduan</h1>
        <p>Pilih kategori layanan yang sesuai dengan pengaduan Anda</p>
    </div>
</section>

<!-- Services Grid -->
<section class="services-section">
    <div class="container">
        <div class="services-grid">
            @foreach($services as $service)
            <div class="service-card">
                <div class="service-icon" style="background: {{ $service->color }}20; color: {{ $service->color }};">
                    <i class="fas {{ $service->icon }}"></i>
                </div>
                <div class="service-content">
                    <h3>{{ $service->name }}</h3>
                    <p>{{ $service->description }}</p>
                    <div class="service-meta">
                        <span class="complaint-count">
                            <i class="fas fa-file-alt"></i>
                            {{ $service->complaints_count ?? 0 }} pengaduan
                        </span>
                    </div>
                </div>
                <a href="{{ route('public.complaints.create', $service->slug) }}" class="service-btn">
                    <span>Ajukan Pengaduan</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Info Section -->
<section class="info-section">
    <div class="container">
        <div class="info-grid">
            <div class="info-card">
                <i class="fas fa-clock"></i>
                <h3>Proses Cepat</h3>
                <p>Pengaduan Anda akan diproses dalam 3-7 hari kerja</p>
            </div>
            <div class="info-card">
                <i class="fas fa-shield-alt"></i>
                <h3>Aman & Terpercaya</h3>
                <p>Data Anda dijaga kerahasiaannya</p>
            </div>
            <div class="info-card">
                <i class="fas fa-bell"></i>
                <h3>Tracking Real-time</h3>
                <p>Pantau status pengaduan kapan saja</p>
            </div>
            <div class="info-card">
                <i class="fas fa-headset"></i>
                <h3>Dukungan 24/7</h3>
                <p>Tim kami siap membantu Anda</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-card">
            <h2>Tidak Menemukan Kategori yang Sesuai?</h2>
            <p>Hubungi kami untuk bantuan lebih lanjut</p>
            <div class="cta-buttons">
                <a href="tel:0241234567" class="btn btn-primary">
                    <i class="fas fa-phone"></i> Hubungi Kami
                </a>
                <a href="{{ route('public.complaints.track') }}" class="btn btn-secondary">
                    <i class="fas fa-search"></i> Tracking Pengaduan
                </a>
            </div>
        </div>
    </div>
</section>

<style>
.services-hero {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    padding: 4rem 0;
    text-align: center;
}

.services-hero h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
}

.services-hero p {
    font-size: 1.25rem;
    opacity: 0.95;
}

.services-section {
    padding: 4rem 0;
    background: #f8fafc;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 2rem;
}

.service-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s;
    display: flex;
    flex-direction: column;
    position: relative;
    overflow: hidden;
}

.service-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--service-color, #3b82f6), var(--service-color-dark, #2563eb));
}

.service-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.12);
}

.service-icon {
    width: 80px;
    height: 80px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    margin-bottom: 1.5rem;
}

.service-content {
    flex: 1;
}

.service-content h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.75rem;
}

.service-content p {
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.service-meta {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.complaint-count {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #64748b;
    background: #f8fafc;
    padding: 0.5rem 1rem;
    border-radius: 6px;
}

.service-btn {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.5rem;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
}

.service-btn:hover {
    transform: translateX(4px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
}

.info-section {
    padding: 4rem 0;
    background: white;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
}

.info-card {
    text-align: center;
    padding: 2rem;
}

.info-card i {
    font-size: 3rem;
    color: #3b82f6;
    margin-bottom: 1rem;
}

.info-card h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.75rem;
}

.info-card p {
    color: #64748b;
    line-height: 1.6;
}

.cta-section {
    padding: 4rem 0;
    background: #f8fafc;
}

.cta-card {
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    border: 2px solid #3b82f6;
    border-radius: 16px;
    padding: 3rem;
    text-align: center;
}

.cta-card h2 {
    font-size: 2rem;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 1rem;
}

.cta-card p {
    font-size: 1.125rem;
    color: #64748b;
    margin-bottom: 2rem;
}

.cta-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn {
    padding: 1rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
}

.btn-secondary {
    background: white;
    color: #3b82f6;
    border: 2px solid #3b82f6;
}

.btn-secondary:hover {
    background: #3b82f6;
    color: white;
}

@media (max-width: 768px) {
    .services-hero h1 {
        font-size: 2rem;
        flex-direction: column;
    }

    .services-grid {
        grid-template-columns: 1fr;
    }

    .cta-buttons {
        flex-direction: column;
    }

    .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection