@extends('layouts.public.app')

@section('title', 'Pejabat Struktural')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="header-container">
        <h1 class="page-title">Pejabat Struktural</h1>
        <p class="page-subtitle">Profil Pejabat Dinas Kesehatan Kabupaten Semarang</p>
    </div>
</div>

@if($pejabat->count() > 0)
    <div class="content-container">
        <div class="pejabat-grid">
            @foreach($pejabat as $item)
                <div class="pejabat-card">
                    <div class="pejabat-foto-wrapper">
                        @if($item->foto)
                            <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}" class="pejabat-foto">
                        @else
                            <div class="pejabat-foto-placeholder">
                                {{ strtoupper(substr($item->nama, 0, 1)) }}
                            </div>
                        @endif
                        <div class="pejabat-order-badge">{{ $item->order }}</div>
                    </div>
                    
                    <div class="pejabat-info">
                        <h3 class="pejabat-nama">{{ $item->nama }}</h3>
                        <p class="pejabat-jabatan">{{ $item->jabatan }}</p>
                        
                        @if($item->nip)
                            <div class="pejabat-detail">
                                <i class="fas fa-id-card"></i>
                                <span>NIP: {{ $item->nip }}</span>
                            </div>
                        @endif
                        
                        @if($item->pendidikan)
                            <div class="pejabat-detail">
                                <i class="fas fa-graduation-cap"></i>
                                <span>{{ $item->pendidikan }}</span>
                            </div>
                        @endif
                        
                        @if($item->riwayat_jabatan)
                            <details class="pejabat-riwayat">
                                <summary>Riwayat Jabatan</summary>
                                <p>{{ $item->riwayat_jabatan }}</p>
                            </details>
                        @endif
                        
                        <div class="pejabat-contact">
                            @if($item->email)
                                <a href="mailto:{{ $item->email }}" class="contact-btn" title="Email">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            @endif
                            
                            @if($item->phone)
                                <a href="tel:{{ $item->phone }}" class="contact-btn" title="Telepon">
                                    <i class="fas fa-phone"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@else
    <div class="empty-state">
        <i class="fas fa-users"></i>
        <h3>Data Belum Tersedia</h3>
        <p>Profil pejabat belum ditambahkan</p>
    </div>
@endif

<style>
/* Page Header */
.page-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
    color: white;
    padding: 4rem 0 3rem;
    margin-bottom: 3rem;
}

.header-container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 2rem;
    text-align: center;
}

.page-title {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 1rem;
}

.page-subtitle {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.9);
}

/* Content Container */
.content-container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 2rem 4rem;
}

/* Pejabat Grid */
.pejabat-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 2rem;
}

/* Pejabat Card */
.pejabat-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    transition: all 0.3s;
}

.pejabat-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

/* Foto */
.pejabat-foto-wrapper {
    position: relative;
    width: 100%;
    height: 350px;
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}

.pejabat-foto {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.pejabat-foto-placeholder {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background: #1e40af;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 4rem;
    font-weight: 700;
}

.pejabat-order-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 40px;
    height: 40px;
    background: #fbbf24;
    color: #1f2937;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.125rem;
    box-shadow: 0 4px 12px rgba(251, 191, 36, 0.5);
}

/* Info */
.pejabat-info {
    padding: 1.5rem;
}

.pejabat-nama {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.5rem;
    line-height: 1.4;
}

.pejabat-jabatan {
    font-size: 1rem;
    font-weight: 600;
    color: #1e40af;
    margin-bottom: 1rem;
    line-height: 1.5;
}

.pejabat-detail {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
    font-size: 0.9375rem;
    color: #6b7280;
}

.pejabat-detail i {
    color: #1e40af;
    width: 20px;
}

/* Riwayat */
.pejabat-riwayat {
    margin: 1rem 0;
    padding: 1rem;
    background: #f9fafb;
    border-radius: 8px;
}

.pejabat-riwayat summary {
    cursor: pointer;
    font-weight: 600;
    color: #374151;
    user-select: none;
}

.pejabat-riwayat summary:hover {
    color: #1e40af;
}

.pejabat-riwayat p {
    margin-top: 0.75rem;
    font-size: 0.9375rem;
    line-height: 1.6;
    color: #6b7280;
}

/* Contact */
.pejabat-contact {
    display: flex;
    gap: 0.75rem;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e5e7eb;
}

.contact-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #1e40af;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s;
}

.contact-btn:hover {
    background: #1e3a8a;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 6rem 2rem;
}

.empty-state i {
    font-size: 5rem;
    color: #d1d5db;
    margin-bottom: 1.5rem;
}

.empty-state h3 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #6b7280;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #9ca3af;
}

/* Responsive */
@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }

    .page-subtitle {
        font-size: 1rem;
    }

    .pejabat-grid {
        grid-template-columns: 1fr;
    }

    .pejabat-foto-wrapper {
        height: 300px;
    }
}
</style>
@endsection