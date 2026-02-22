@extends('layouts.public.app')

@section('title', 'Lacak Permohonan Informasi')

@section('content')
<!-- Hero Section -->
<section class="page-hero-tracking">
    <div class="container">
        <div class="hero-content">
            <div class="breadcrumb-wrapper">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('information.flow') }}">Permohonan Informasi</a></li>
                        <li class="breadcrumb-item active">Lacak Permohonan</li>
                    </ol>
                </nav>
            </div>
            <h1 class="hero-title">
                <i class="fas fa-search"></i>
                Lacak Permohonan Informasi
            </h1>
            <p class="hero-description">
                Masukkan nomor registrasi untuk melihat status permohonan Anda
            </p>
        </div>
    </div>
</section>

<!-- Search Section -->
<section class="search-section">
    <div class="container">
        <div class="search-card">
            <div class="search-icon">
                <i class="fas fa-file-search"></i>
            </div>
            <h3>Masukkan Nomor Registrasi</h3>
            <p>Nomor registrasi diberikan saat Anda mengajukan permohonan</p>
            
            <form action="{{ route('information.search-tracking') }}" method="POST" class="search-form">
                @csrf
                <div class="search-input-group">
                    <i class="fas fa-hashtag"></i>
                    <input 
                        type="text" 
                        name="registration_number" 
                        class="search-input"
                        placeholder="Contoh: REG-2024-02-0001"
                        value="{{ request()->registration_number ?? '' }}"
                        required
                    >
                    <button type="submit" class="search-button">
                        <i class="fas fa-search"></i>
                        Cari
                    </button>
                </div>
            </form>

            @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
            @endif

            @if(!$informationRequest && request()->has('registration_number'))
            <div class="alert alert-warning">
                <i class="fas fa-info-circle"></i>
                Nomor registrasi tidak ditemukan. Mohon periksa kembali nomor yang Anda masukkan.
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Result Section -->
@if($informationRequest)
<section class="result-section">
    <div class="container">
        <!-- Status Card -->
        <div class="status-card">
            <div class="status-header">
                <div class="status-info">
                    <h3>
                        <i class="fas fa-file-alt"></i>
                        Permohonan Informasi
                    </h3>
                    <div class="registration-number">
                        <strong>No. Registrasi:</strong>
                        <span>{{ $informationRequest->registration_number }}</span>
                    </div>
                </div>
                <div class="status-badge-wrapper">
                    <span class="status-badge status-{{ $informationRequest->status }}">
                        {{ $informationRequest->status_label }}
                    </span>
                </div>
            </div>

            <div class="status-divider"></div>

            <div class="request-details">
                <div class="detail-grid">
                    <div class="detail-item">
                        <label><i class="fas fa-user"></i> Nama Pemohon</label>
                        <span>{{ $informationRequest->name }}</span>
                    </div>
                    <div class="detail-item">
                        <label><i class="fas fa-envelope"></i> Email</label>
                        <span>{{ $informationRequest->email }}</span>
                    </div>
                    <div class="detail-item">
                        <label><i class="fas fa-calendar"></i> Tanggal Pengajuan</label>
                        <span>{{ $informationRequest->submitted_at->format('d M Y, H:i') }} WIB</span>
                    </div>
                    <div class="detail-item">
                        <label><i class="fas fa-tag"></i> Jenis Pemohon</label>
                        <span>{{ $informationRequest->requester_type_label }}</span>
                    </div>
                </div>

                <div class="detail-full">
                    <label><i class="fas fa-info-circle"></i> Informasi yang Dimohonkan</label>
                    <p>{{ $informationRequest->information_needed }}</p>
                </div>

                <div class="detail-full">
                    <label><i class="fas fa-bullseye"></i> Tujuan Penggunaan</label>
                    <p>{{ $informationRequest->information_purpose }}</p>
                </div>

                <div class="detail-grid">
                    <div class="detail-item">
                        <label><i class="fas fa-file"></i> Format</label>
                        <span class="badge-info">{{ ucfirst($informationRequest->information_format) }}</span>
                    </div>
                    <div class="detail-item">
                        <label><i class="fas fa-truck"></i> Cara Pengambilan</label>
                        <span class="badge-info">{{ ucfirst($informationRequest->delivery_method) }}</span>
                    </div>
                </div>

                @if($informationRequest->admin_notes)
                <div class="detail-full">
                    <div class="admin-note">
                        <i class="fas fa-sticky-note"></i>
                        <div>
                            <strong>Catatan Admin:</strong>
                            <p>{{ $informationRequest->admin_notes }}</p>
                        </div>
                    </div>
                </div>
                @endif

                @if($informationRequest->status == 'rejected' && $informationRequest->rejection_reason)
                <div class="detail-full">
                    <div class="rejection-notice">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            <strong>Alasan Penolakan:</strong>
                            <p>{{ $informationRequest->rejection_reason }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Timeline -->
        <div class="timeline-card">
            <h3><i class="fas fa-history"></i> Riwayat Permohonan</h3>
            
            <div class="timeline">
                @foreach($informationRequest->followups as $followup)
                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <div class="timeline-header">
                            <span class="timeline-status">{{ $followup->status }}</span>
                            <span class="timeline-date">
                                {{ $followup->created_at->format('d M Y, H:i') }} WIB
                            </span>
                        </div>
                        <p class="timeline-description">{{ $followup->description }}</p>
                        @if($followup->updated_by)
                        <span class="timeline-author">oleh {{ $followup->updated_by }}</span>
                        @endif
                    </div>
                </div>
                @endforeach

                <!-- Initial submission -->
                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <div class="timeline-header">
                            <span class="timeline-status">submitted</span>
                            <span class="timeline-date">
                                {{ $informationRequest->submitted_at->format('d M Y, H:i') }} WIB
                            </span>
                        </div>
                        <p class="timeline-description">Permohonan informasi diajukan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Download Result -->
        @if($informationRequest->result_file && in_array($informationRequest->status, ['ready', 'completed']))
        <div class="download-card">
            <div class="download-icon">
                <i class="fas fa-file-download"></i>
            </div>
            <div class="download-info">
                <h4>File Hasil Permohonan Tersedia</h4>
                <p>Anda dapat mengunduh file hasil permohonan informasi Anda</p>
            </div>
            <a href="{{ route('information.download-result', $informationRequest->id) }}" class="download-button">
                <i class="fas fa-download"></i>
                Download Hasil
            </a>
        </div>
        @endif

        <!-- Help Box -->
        <div class="help-box">
            <i class="fas fa-question-circle"></i>
            <div>
                <h4>Butuh Bantuan?</h4>
                <p>Jika ada pertanyaan mengenai permohonan Anda, silakan hubungi kami di <strong>(024) 6923955</strong> atau email <strong>dinkeskabsemarang@gmail.com</strong></p>
            </div>
        </div>
    </div>
</section>
@endif

<style>
/* Hero */
.page-hero-tracking {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    padding: 3rem 0 4rem;
    margin-bottom: 5rem;
    
}

.hero-content {
    color: white;
    margin-left: 10em;
    margin-right: 10em;
}

.breadcrumb {
    background: rgba(255, 255, 255, 0.1);
    padding: 0.75rem 1.25rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    display: inline-flex;
}

.breadcrumb-item a {
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
}

.breadcrumb-item.active {
    color: white;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    color: rgba(255, 255, 255, 0.7);
    padding: 0 0.5rem;
}

.hero-title {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.hero-description {
    font-size: 1.125rem;
    opacity: 0.95;
}

/* Search Section */
.search-section {
    padding: 0 0 4rem;
    margin-top: -4rem;
}

.search-card {
    max-width: 700px;
    margin: 0 auto;
    background: white;
    padding: 3rem;
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    text-align: center;
}

.search-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #d97706;
    border-radius: 50%;
    font-size: 2.5rem;
}

.search-card h3 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.search-card > p {
    color: #64748b;
    margin-bottom: 2rem;
}

.search-form {
    margin-bottom: 1rem;
}

.search-input-group {
    position: relative;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.search-input-group > i {
    position: absolute;
    left: 1.25rem;
    color: #94a3b8;
    font-size: 1.125rem;
    z-index: 2;
}

.search-input {
    flex: 1;
    padding: 1rem 1rem 1rem 3rem;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s;
}

.search-input:focus {
    outline: none;
    border-color: #f59e0b;
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
}

.search-button {
    padding: 1rem 2rem;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s;
}

.search-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);
}

.alert {
    padding: 1rem 1.25rem;
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-top: 1.5rem;
}

.alert-error {
    background: #fee2e2;
    color: #991b1b;
    border-left: 4px solid #ef4444;
}

.alert-warning {
    background: #fef3c7;
    color: #92400e;
    border-left: 4px solid #f59e0b;
}

/* Result Section */
.result-section {
    padding: 3rem 0 4rem;
    background: #f8fafc;
}

.status-card {
    background: white;
    border-radius: 20px;
    padding: 2.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.status-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 2rem;
}

.status-info h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.registration-number {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1rem;
}

.registration-number strong {
    color: #64748b;
}

.registration-number span {
    padding: 0.375rem 0.875rem;
    background: #f1f5f9;
    border-radius: 8px;
    color: #1e293b;
    font-family: 'Courier New', monospace;
    font-weight: 600;
}

.status-badge-wrapper {
    flex-shrink: 0;
}

.status-badge {
    padding: 0.425rem 1rem;
    border-radius: 40px;
    font-size: 0.6375rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-submitted {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e;
}

.status-verified {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    color: #1e40af;
}

.status-processed {
    background: linear-gradient(135deg, #e0e7ff, #ffffff);
    color: #ff8a15;
}

.status-ready, .status-completed {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    color: #065f46;
}

.status-rejected {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    color: #991b1b;
}

.status-divider {
    height: 2px;
    background: linear-gradient(to right, #e2e8f0, transparent);
    margin-bottom: 2rem;
}

.request-details {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.detail-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.detail-item label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #64748b;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.detail-item span {
    color: #1e293b;
    font-size: 1rem;
}

.detail-full {
    background: #f8fafc;
    padding: 1.5rem;
    border-radius: 12px;
}

.detail-full label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #64748b;
    font-weight: 700;
    margin-bottom: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.detail-full p {
    color: #1e293b;
    line-height: 1.7;
    margin: 0;
}

.badge-info {
    padding: 0.375rem 0.875rem;
    background: #dbeafe;
    color: #1e40af;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
}

.admin-note {
    display: flex;
    gap: 1rem;
    padding: 1.5rem;
    background: #eff6ff;
    border-left: 4px solid #3b82f6;
    border-radius: 8px;
}

.admin-note i {
    color: #3b82f6;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.admin-note strong {
    color: #1e40af;
    display: block;
    margin-bottom: 0.5rem;
}

.admin-note p {
    color: #1e40af;
}

.rejection-notice {
    display: flex;
    gap: 1rem;
    padding: 1.5rem;
    background: #fef2f2;
    border-left: 4px solid #ef4444;
    border-radius: 8px;
}

.rejection-notice i {
    color: #ef4444;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.rejection-notice strong {
    color: #991b1b;
    display: block;
    margin-bottom: 0.5rem;
}

.rejection-notice p {
    color: #991b1b;
}

/* Timeline */
.timeline-card {
    background: white;
    border-radius: 20px;
    padding: 2.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.timeline-card h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 8px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, #3b82f6, #e2e8f0);
}

.timeline-item {
    position: relative;
    margin-bottom: 2rem;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -2rem;
    top: 0;
    width: 18px;
    height: 18px;
    background: white;
    border: 3px solid #3b82f6;
    border-radius: 50%;
    z-index: 2;
}

.timeline-content {
    background: #f8fafc;
    padding: 1.25rem;
    border-radius: 12px;
    border-left: 3px solid #3b82f6;
}

.timeline-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.75rem;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.timeline-status {
    padding: 0.25rem 0.75rem;
    background: #dbeafe;
    color: #1e40af;
    border-radius: 6px;
    font-size: 0.8125rem;
    font-weight: 700;
    text-transform: uppercase;
}

.timeline-date {
    font-size: 0.875rem;
    color: #64748b;
}

.timeline-description {
    color: #1e293b;
    line-height: 1.6;
    margin: 0 0 0.5rem 0;
}

.timeline-author {
    font-size: 0.8125rem;
    color: #94a3b8;
    font-style: italic;
}

/* Download Card */
.download-card {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    padding: 2rem;
    border-radius: 16px;
    border: 2px solid #10b981;
    margin-bottom: 2rem;
}

.download-icon {
    width: 70px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
    border-radius: 16px;
    color: #10b981;
    font-size: 2rem;
    flex-shrink: 0;
}

.download-info {
    flex: 1;
}

.download-info h4 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #065f46;
    margin-bottom: 0.25rem;
}

.download-info p {
    color: #047857;
    margin: 0;
}

.download-button {
    padding: 1rem 2rem;
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s;
}

.download-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
    color: white;
}

/* Help Box */
.help-box {
    display: flex;
    gap: 1.5rem;
    padding: 2rem;
    background: #fffbeb;
    border-left: 4px solid #f59e0b;
    border-radius: 12px;
}

.help-box > i {
    font-size: 2rem;
    color: #f59e0b;
    flex-shrink: 0;
}

.help-box h4 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #92400e;
    margin-bottom: 0.5rem;
}

.help-box p {
    color: #78350f;
    line-height: 1.7;
    margin: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2rem;
    }

    .search-card {
        padding: 2rem 1.5rem;
    }

    .search-input-group {
        flex-direction: column;
    }

    .search-button {
        width: 100%;
        justify-content: center;
    }

    .status-header {
        flex-direction: column;
        gap: 1rem;
    }

    .detail-grid {
        grid-template-columns: 1fr;
    }

    .download-card {
        flex-direction: column;
        text-align: center;
    }

    .download-button {
        width: 100%;
        justify-content: center;
    }

    .timeline {
        padding-left: 1.5rem;
    }
}
</style>
@endsection