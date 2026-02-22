@extends('layouts.public.app')

@section('title', 'Visi & Misi')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="header-container">
        <h1 class="page-title">Visi & Misi</h1>
        <p class="page-subtitle">Visi, Misi, dan Motto Dinas Kesehatan Kabupaten Semarang</p>
    </div>
</div>

@if($visiMisi)
    <div class="content-container">
        <!-- Motto Section (jika ada) -->
        @if($visiMisi->motto)
            <div class="motto-section">
                <div class="motto-icon">
                    <i class="fas fa-quote-left"></i>
                </div>
                <h2 class="motto-text">{{ $visiMisi->motto }}</h2>
                <div class="motto-icon">
                    <i class="fas fa-quote-right"></i>
                </div>
            </div>
        @endif

        <div class="vm-grid">
            <!-- Visi -->
            <div class="vm-card visi-card">
                <div class="vm-card-header">
                    <div class="vm-icon visi-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3 class="vm-title">Visi</h3>
                </div>
                <div class="vm-card-body">
                    <p class="visi-text">{!!$visiMisi->visi !!}</p>
                </div>
            </div>

            <!-- Misi -->
            <div class="vm-card misi-card">
                <div class="vm-card-header">
                    <div class="vm-icon misi-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3 class="vm-title">Misi</h3>
                </div>
                <div class="vm-card-body">
                    <div class="misi-content">
                        {!!$visiMisi->misi !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Description (jika ada) -->
        @if($visiMisi->description)
            <div class="description-section">
                <div class="description-icon">
                    <i class="fas fa-info-circle"></i>
                </div>
                <p class="description-text">{{ $visiMisi->description }}</p>
            </div>
        @endif
    </div>
@else
    <div class="empty-state">
        <i class="fas fa-bullseye"></i>
        <h3>Data Belum Tersedia</h3>
        <p>Visi dan Misi belum ditambahkan</p>
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

/* Motto Section */
.motto-section {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    padding: 3rem 2rem;
    border-radius: 16px;
    text-align: center;
    margin-bottom: 3rem;
    box-shadow: 0 10px 40px rgba(251, 191, 36, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 2rem;
}

.motto-icon {
    color: rgba(255, 255, 255, 0.8);
    font-size: 2rem;
}

.motto-text {
    font-size: 2.5rem;
    font-weight: 800;
    color: white;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* VM Grid */
.vm-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    margin-bottom: 3rem;
}

/* VM Card */
.vm-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    transition: all 0.3s;
}

.vm-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.vm-card-header {
    padding: 2rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.visi-card .vm-card-header {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
}

.misi-card .vm-card-header {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
}

.vm-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.visi-icon {
    background: #1e40af;
    color: white;
}

.misi-icon {
    background: #10b981;
    color: white;
}

.vm-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.vm-card-body {
    padding: 2rem;
}

.visi-text {
    font-size: 1.25rem;
    line-height: 1.8;
    color: #374151;
    font-weight: 500;
    margin: 0;
}

.misi-content {
    font-size: 1.125rem;
    line-height: 1.9;
    color: #374151;
}

/* Description Section */
.description-section {
    background: #f9fafb;
    padding: 2rem;
    border-radius: 12px;
    border-left: 4px solid #1e40af;
    display: flex;
    gap: 1.5rem;
    align-items: flex-start;
}

.description-icon {
    color: #1e40af;
    font-size: 2rem;
    flex-shrink: 0;
}

.description-text {
    font-size: 1.0625rem;
    line-height: 1.7;
    color: #4b5563;
    margin: 0;
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
@media (max-width: 1024px) {
    .vm-grid {
        grid-template-columns: 1fr;
    }

    .motto-section {
        flex-direction: column;
        gap: 1rem;
    }
}

@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }

    .page-subtitle {
        font-size: 1rem;
    }

    .motto-text {
        font-size: 1.75rem;
    }

    .vm-card-header {
        padding: 1.5rem;
    }

    .vm-card-body {
        padding: 1.5rem;
    }

    .vm-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }

    .vm-title {
        font-size: 1.5rem;
    }

    .visi-text {
        font-size: 1.0625rem;
    }

    .misi-content {
        font-size: 1rem;
    }
}
</style>
@endsection