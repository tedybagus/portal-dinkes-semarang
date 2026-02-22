@extends('layouts.public.app')

@section('title', $complaint->subject)

@section('content')
<div class="complaint-detail-page">
    <!-- Header Section -->
    <section class="detail-hero">
        <div class="container">
            <div class="hero-content">
                <a href="{{ route('public.complaints.track') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i> Kembali ke Tracking
                </a>
                <h1>{{ $complaint->subject }}</h1>
                <div class="hero-meta">
                    <span class="ticket-badge">
                        <i class="fas fa-ticket-alt"></i>
                        {{ $complaint->ticket_number }}
                    </span>
                    <span class="status-badge status-{{ $complaint->status }}">
                        {{ $complaint->status_label }}
                    </span>
                    <span class="priority-badge priority-{{ $complaint->priority }}">
                        <i class="fas fa-flag"></i>
                        {{ $complaint->priority_label }}
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="detail-content">
        <div class="container">
            <div class="content-grid">
                <!-- Left Column -->
                <div class="left-column">
                    <!-- Service Info -->
                    <div class="info-card service-card">
                        <div class="card-icon" style="background: {{ $complaint->service->color }}20; color: {{ $complaint->service->color }};">
                            <i class="fas {{ $complaint->service->icon }}"></i>
                        </div>
                        <div class="card-content">
                            <span class="card-label">Kategori Layanan</span>
                            <h3>{{ $complaint->service->name }}</h3>
                        </div>
                    </div>

                    <!-- Reporter Info -->
                    <div class="detail-card">
                        <div class="card-header">
                            <h2><i class="fas fa-user-circle"></i> Data Pelapor</h2>
                        </div>
                        <div class="card-body">
                            <div class="info-row">
                                <div class="info-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="info-content">
                                    <span class="info-label">Nama Lengkap</span>
                                    <span class="info-value">{{ $complaint->reporter_name }}</span>
                                </div>
                            </div>

                            @if($complaint->reporter_nik)
                            <div class="info-row">
                                <div class="info-icon">
                                    <i class="fas fa-id-card"></i>
                                </div>
                                <div class="info-content">
                                    <span class="info-label">NIK</span>
                                    <span class="info-value">{{ $complaint->reporter_nik }}</span>
                                </div>
                            </div>
                            @endif

                            <div class="info-row">
                                <div class="info-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="info-content">
                                    <span class="info-label">No. Handphone</span>
                                    <span class="info-value">{{ $complaint->reporter_phone }}</span>
                                </div>
                            </div>

                            @if($complaint->reporter_email)
                            <div class="info-row">
                                <div class="info-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="info-content">
                                    <span class="info-label">Email</span>
                                    <span class="info-value">{{ $complaint->reporter_email }}</span>
                                </div>
                            </div>
                            @endif

                            @if($complaint->reporter_address)
                            <div class="info-row">
                                <div class="info-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="info-content">
                                    <span class="info-label">Alamat</span>
                                    <span class="info-value">{{ $complaint->reporter_address }}</span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Complaint Detail -->
                    <div class="detail-card">
                        <div class="card-header">
                            <h2><i class="fas fa-file-alt"></i> Detail Pengaduan</h2>
                        </div>
                        <div class="card-body">
                            <div class="detail-section">
                                <h3>Isi Pengaduan</h3>
                                <div class="description-box">
                                    {{ $complaint->description }}
                                </div>
                            </div>

                            <div class="meta-grid">
                                <div class="meta-item">
                                    <i class="fas fa-calendar-check"></i>
                                    <div>
                                        <span class="meta-label">Tanggal Diajukan</span>
                                        <span class="meta-value">{{ $complaint->created_at->format('d M Y, H:i') }}</span>
                                    </div>
                                </div>

                                @if($complaint->location)
                                <div class="meta-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <div>
                                        <span class="meta-label">Lokasi Kejadian</span>
                                        <span class="meta-value">{{ $complaint->location }}</span>
                                    </div>
                                </div>
                                @endif

                                @if($complaint->incident_date)
                                <div class="meta-item">
                                    <i class="fas fa-calendar"></i>
                                    <div>
                                        <span class="meta-label">Tanggal Kejadian</span>
                                        <span class="meta-value">{{ \Carbon\Carbon::parse($complaint->incident_date)->format('d M Y') }}</span>
                                    </div>
                                </div>
                                @endif

                                <div class="meta-item">
                                    <i class="fas fa-flag"></i>
                                    <div>
                                        <span class="meta-label">Prioritas</span>
                                        <span class="meta-value">
                                            <span class="priority-badge priority-{{ $complaint->priority }}">
                                                {{ $complaint->priority_label }}
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            @if($complaint->evidence_file)
                            <div class="detail-section">
                                <h3>File Bukti</h3>
                                <a href="{{ route('public.complaints.download-evidence', $complaint->ticket_number) }}" class="download-btn" target="_blank">
                                    <i class="fas fa-download"></i>
                                    <div>
                                        <strong>Download Bukti Pendukung</strong>
                                        <span>{{ $complaint->evidence_file_size ?? 'File tersedia' }}</span>
                                    </div>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Response (if any) -->
                    @if($complaint->response)
                    <div class="detail-card response-card">
                        <div class="card-header">
                            <h2><i class="fas fa-comment-dots"></i> Tanggapan dari Admin</h2>
                        </div>
                        <div class="card-body">
                            <div class="response-box">
                                <div class="response-icon">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div class="response-content">
                                    <p>{{ $complaint->response }}</p>
                                    @if($complaint->resolved_at)
                                    <span class="response-time">
                                        <i class="fas fa-clock"></i>
                                        {{ $complaint->resolved_at->format('d M Y, H:i') }}
                                    </span>
                                    @endif
                                </div>
                            </div>

                            @if($complaint->response_file)
                            <a href="{{ route('public.complaints.download-response', $complaint->ticket_number) }}" class="download-btn secondary" target="_blank">
                                <i class="fas fa-file-download"></i>
                                <div>
                                    <strong>Download File Tanggapan</strong>
                                    <span>File pendukung dari admin</span>
                                </div>
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Feedback Form (if resolved and no rating yet) -->
                    @if($complaint->status === 'resolved' && !$complaint->satisfaction_rating)
                    <div class="detail-card feedback-card">
                        <div class="card-header">
                            <h2><i class="fas fa-star"></i> Berikan Penilaian Anda</h2>
                        </div>
                        <div class="card-body">
                            <p class="feedback-intro">
                                Pengaduan Anda telah diselesaikan. Berikan penilaian untuk membantu kami meningkatkan layanan.
                            </p>
                            
                            <form action="{{ route('public.complaints.submit-feedback', $complaint->ticket_number) }}" method="POST" id="feedbackForm">
                                @csrf
                                
                                <div class="form-group">
                                    <label>Rating Kepuasan</label>
                                    <div class="star-rating">
                                        <input type="radio" name="satisfaction_rating" value="5" id="star5" required>
                                        <label for="star5"><i class="fas fa-star"></i></label>
                                        
                                        <input type="radio" name="satisfaction_rating" value="4" id="star4">
                                        <label for="star4"><i class="fas fa-star"></i></label>
                                        
                                        <input type="radio" name="satisfaction_rating" value="3" id="star3">
                                        <label for="star3"><i class="fas fa-star"></i></label>
                                        
                                        <input type="radio" name="satisfaction_rating" value="2" id="star2">
                                        <label for="star2"><i class="fas fa-star"></i></label>
                                        
                                        <input type="radio" name="satisfaction_rating" value="1" id="star1">
                                        <label for="star1"><i class="fas fa-star"></i></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Komentar / Saran (Opsional)</label>
                                    <textarea name="feedback" rows="4" class="form-control" placeholder="Bagikan pengalaman Anda..."></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-paper-plane"></i> Kirim Penilaian
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif

                    <!-- Rating Display (if closed with rating) -->
                    @if($complaint->satisfaction_rating)
                    <div class="detail-card rating-card">
                        <div class="card-header">
                            <h2><i class="fas fa-star"></i> Penilaian Anda</h2>
                        </div>
                        <div class="card-body">
                            <div class="rating-display">
                                @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $complaint->satisfaction_rating ? 'filled' : '' }}"></i>
                                @endfor
                                <span class="rating-value">{{ $complaint->satisfaction_rating }}/5</span>
                            </div>
                            @if($complaint->feedback)
                            <div class="feedback-text">
                                <p>{{ $complaint->feedback }}</p>
                            </div>
                            @endif
                            <div class="thank-you-note">
                                <i class="fas fa-heart"></i>
                                Terima kasih atas feedback Anda!
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Right Column -->
                <div class="right-column">
                    <!-- Status Progress -->
                    <div class="progress-card">
                        <h3><i class="fas fa-tasks"></i> Status Pengaduan</h3>
                        <div class="status-current">
                            <div class="status-icon status-{{ $complaint->status }}">
                                @if($complaint->status === 'submitted')
                                <i class="fas fa-inbox"></i>
                                @elseif($complaint->status === 'verified')
                                <i class="fas fa-check-circle"></i>
                                @elseif($complaint->status === 'in_progress')
                                <i class="fas fa-cog fa-spin"></i>
                                @elseif($complaint->status === 'resolved')
                                <i class="fas fa-check-double"></i>
                                @elseif($complaint->status === 'closed')
                                <i class="fas fa-times-circle"></i>
                                @elseif($complaint->status === 'rejected')
                                <i class="fas fa-ban"></i>
                                @endif
                            </div>
                            <div>
                                <span class="status-label">{{ $complaint->status_label }}</span>
                                <span class="status-desc">
                                    @if($complaint->status === 'submitted')
                                    Pengaduan Anda sedang menunggu verifikasi
                                    @elseif($complaint->status === 'verified')
                                    Pengaduan telah diverifikasi dan menunggu tindak lanjut
                                    @elseif($complaint->status === 'in_progress')
                                    Tim sedang menindaklanjuti pengaduan Anda
                                    @elseif($complaint->status === 'resolved')
                                    Pengaduan telah diselesaikan
                                    @elseif($complaint->status === 'closed')
                                    Pengaduan telah ditutup
                                    @elseif($complaint->status === 'rejected')
                                    Pengaduan ditolak
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Flow Progress (optional) -->
                        @if($flows->count() > 0)
                        <div class="flow-steps">
                            @foreach($flows as $index => $flow)
                            @php
                            $isComplete = false;
                            if ($complaint->status === 'closed' || $complaint->status === 'resolved') {
                                $isComplete = true;
                            } elseif ($complaint->status === 'in_progress' && $index < 2) {
                                $isComplete = true;
                            } elseif ($complaint->status === 'verified' && $index < 1) {
                                $isComplete = true;
                            }
                            @endphp
                            <div class="flow-step {{ $isComplete ? 'complete' : '' }}">
                                <div class="flow-icon">
                                    <i class="fas {{ $flow->icon }}"></i>
                                </div>
                                <div class="flow-content">
                                    <strong>{{ $flow->title }}</strong>
                                    <small>{{ $flow->duration_days }} hari</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <!-- Timeline -->
                    <div class="timeline-card">
                        <h3><i class="fas fa-history"></i> Timeline Pengaduan</h3>
                        <div class="timeline">
                            @foreach($complaint->histories->reverse() as $index => $history)
                            <div class="timeline-item {{ $index === 0 ? 'current' : '' }}">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <div class="timeline-status">{{ $history->status }}</div>
                                    <p class="timeline-desc">{{ $history->description }}</p>
                                    <div class="timeline-meta">
                                        <span><i class="fas fa-clock"></i> {{ $history->created_at->diffForHumans() }}</span>
                                        <span><i class="fas fa-user"></i> {{ $history->updated_by }}</span>
                                    </div>
                                    <small class="timeline-date">{{ $history->created_at->format('d M Y, H:i') }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="actions-card">
                        <h3>Tindakan Cepat</h3>
                        <div class="quick-actions">
                            <button onclick="window.print()" class="action-btn">
                                <i class="fas fa-print"></i>
                                <span>Print Halaman</span>
                            </button>
                            <button onclick="shareComplaint()" class="action-btn">
                                <i class="fas fa-share-alt"></i>
                                <span>Bagikan</span>
                            </button>
                            @if($complaint->evidence_file)
                            <a href="{{ route('public.complaints.download-evidence', $complaint->ticket_number) }}" class="action-btn" target="_blank">
                                <i class="fas fa-download"></i>
                                <span>Download Bukti</span>
                            </a>
                            @endif
                        </div>
                    </div>

                    <!-- Help Card -->
                    <div class="help-card">
                        <i class="fas fa-question-circle"></i>
                        <h4>Butuh Bantuan?</h4>
                        <p>Hubungi kami jika ada pertanyaan terkait pengaduan Anda.</p>
                        <div class="contact-list">
                            <a href="tel:0241234567">
                                <i class="fas fa-phone"></i> (024) 6923955
                            </a>
                            <a href="mailto:pengaduan@dinkes.go.id">
                                <i class="fas fa-envelope"></i> dinkeskabsemarang@gmail.com
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
.complaint-detail-page {
    background: #f8fafc;
    min-height: 100vh;
    
}

/* Hero Section */
.detail-hero {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    padding: 3rem 0 4rem;
    position: relative;
    overflow: hidden;
}

.detail-hero::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 50%;
    height: 100%;
    background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="40" fill="rgba(255,255,255,0.05)"/></svg>');
    background-size: 100px;
    opacity: 0.3;
}

.hero-content {
    position: relative;
    z-index: 1;
}

.back-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: rgba(255,255,255,0.9);
    text-decoration: none;
    margin-bottom: 1.5rem;
    font-weight: 600;
    transition: all 0.3s;
}

.back-link:hover {
    color: white;
    transform: translateX(-4px);
}

.detail-hero h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    line-height: 1.2;
}

.hero-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    align-items: center;
}

.ticket-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    background: rgba(255,255,255,0.2);
    border-radius: 8px;
    font-weight: 700;
    font-family: 'Courier New', monospace;
    font-size: 1.125rem;
}

.status-badge, .priority-badge {
    padding: 0.75rem 1.25rem;
    border-radius: 8px;
    font-weight: 700;
    font-size: 0.9375rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.status-badge.status-submitted { background: #fef3c7; color: #92400e; }
.status-badge.status-verified { background: #dbeafe; color: #1e40af; }
.status-badge.status-in_progress { background: #e9d5ff; color: #6b21a8; }
.status-badge.status-resolved { background: #d1fae5; color: #065f46; }
.status-badge.status-closed { background: #f1f5f9; color: #475569; }
.status-badge.status-rejected { background: #fee2e2; color: #991b1b; }

.priority-badge.priority-low { background: #d1fae5; color: #065f46; }
.priority-badge.priority-medium { background: #fef3c7; color: #92400e; }
.priority-badge.priority-high { background: #fee2e2; color: #991b1b; }
.priority-badge.priority-urgent { background: #fecaca; color: #7f1d1d; }

/* Main Content */
.detail-content {
    padding: 0 0 4rem;
    margin-top: -2rem;
    position: relative;
    z-index: 2;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

.content-grid {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 2rem;
}

/* Service Card */
.info-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    display: flex;
    align-items: center;
    gap: 1.25rem;
    margin-bottom: 2rem;
}

.card-icon {
    width: 70px;
    height: 70px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    flex-shrink: 0;
}

.card-content {
    flex: 1;
}

.card-label {
    display: block;
    font-size: 0.875rem;
    color: #64748b;
    margin-bottom: 0.25rem;
}

.card-content h3 {
    font-size: 1.375rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}

/* Detail Cards */
.detail-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
    overflow: hidden;
}

.card-header {
    padding: 1.5rem;
    background: #f8fafc;
    border-bottom: 2px solid #e2e8f0;
}

.card-header h2 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.card-body {
    padding: 1.5rem;
}

/* Info Rows */
.info-row {
    display: flex;
    align-items: start;
    gap: 1rem;
    padding: 1rem 0;
    border-bottom: 1px solid #f8fafc;
}

.info-row:last-child {
    border-bottom: none;
}

.info-icon {
    width: 45px;
    height: 45px;
    border-radius: 10px;
    background: #eff6ff;
    color: #3b82f6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.info-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.info-label {
    font-size: 0.875rem;
    color: #64748b;
}

.info-value {
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
}

/* Detail Section */
.detail-section {
    margin-bottom: 2rem;
}

.detail-section:last-child {
    margin-bottom: 0;
}

.detail-section h3 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1rem;
}

.description-box {
    background: #f8fafc;
    padding: 1.5rem;
    border-radius: 10px;
    border-left: 4px solid #3b82f6;
    line-height: 1.8;
    color: #475569;
    white-space: pre-wrap;
}

.meta-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.25rem;
    margin-top: 1.5rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 8px;
}

.meta-item i {
    font-size: 1.5rem;
    color: #3b82f6;
}

.meta-label {
    display: block;
    font-size: 0.8125rem;
    color: #64748b;
    margin-bottom: 0.25rem;
}

.meta-value {
    display: block;
    font-size: 0.9375rem;
    font-weight: 600;
    color: #1e293b;
}

/* Download Button */
.download-btn {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.3s;
}

.download-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(59, 130, 246, 0.3);
}

.download-btn i {
    font-size: 2rem;
}

.download-btn.secondary {
    background: #f1f5f9;
    color: #475569;
}

.download-btn.secondary:hover {
    background: #e2e8f0;
}

.download-btn strong {
    display: block;
    margin-bottom: 0.25rem;
    font-size: 1rem;
}

.download-btn span {
    display: block;
    font-size: 0.875rem;
    opacity: 0.9;
}

/* Response Card */
.response-card .card-header {
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    border-bottom-color: #3b82f6;
}

.response-box {
    display: flex;
    gap: 1.25rem;
    padding: 1.5rem;
    background: #eff6ff;
    border-radius: 10px;
    margin-bottom: 1.5rem;
}

.response-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #3b82f6;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.response-content p {
    color: #1e293b;
    line-height: 1.8;
    margin-bottom: 0.75rem;
}

.response-time {
    font-size: 0.875rem;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Feedback Form */
.feedback-card .card-header {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    border-bottom-color: #f59e0b;
}

.feedback-intro {
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    font-weight: 600;
    color: #334155;
    margin-bottom: 0.75rem;
}

.star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: center;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
}

.star-rating input {
    display: none;
}

.star-rating label {
    font-size: 3rem;
    color: #cbd5e1;
    cursor: pointer;
    transition: all 0.3s;
}

.star-rating label:hover,
.star-rating label:hover ~ label,
.star-rating input:checked ~ label {
    color: #f59e0b;
    transform: scale(1.1);
}

.form-control {
    width: 100%;
    padding: 0.875rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.9375rem;
    transition: all 0.3s;
    font-family: inherit;
    resize: vertical;
}

.form-control:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.btn {
    padding: 1rem 2rem;
    border-radius: 8px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    font-size: 1rem;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
}

.btn-block {
    width: 100%;
}

/* Rating Display */
.rating-card .card-header {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    border-bottom-color: #f59e0b;
}

.rating-display {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    font-size: 2.5rem;
    margin-bottom: 1.5rem;
}

.rating-display i.filled {
    color: #f59e0b;
}

.rating-display i:not(.filled) {
    color: #d1d5db;
}

.rating-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #92400e;
    margin-left: 0.5rem;
}

.feedback-text {
    background: #fef3c7;
    padding: 1.25rem;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.feedback-text p {
    color: #92400e;
    line-height: 1.7;
    margin: 0;
}

.thank-you-note {
    text-align: center;
    color: #059669;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.thank-you-note i {
    color: #ef4444;
}

/* Right Column */
.progress-card,
.timeline-card,
.actions-card,
.help-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.progress-card h3,
.timeline-card h3,
.actions-card h3 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Status Current */
.status-current {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    padding: 1.25rem;
    background: #f8fafc;
    border-radius: 10px;
    margin-bottom: 1.5rem;
}

.status-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    color: white;
    flex-shrink: 0;
}

.status-icon.status-submitted { background: #f59e0b; }
.status-icon.status-verified { background: #3b82f6; }
.status-icon.status-in_progress { background: #8b5cf6; }
.status-icon.status-resolved { background: #10b981; }
.status-icon.status-closed { background: #6b7280; }
.status-icon.status-rejected { background: #ef4444; }

.status-label {
    display: block;
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.status-desc {
    display: block;
    font-size: 0.875rem;
    color: #64748b;
    line-height: 1.5;
}

/* Flow Steps */
.flow-steps {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.flow-step {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.875rem;
    background: #f8fafc;
    border-radius: 8px;
    opacity: 0.5;
    transition: all 0.3s;
}

.flow-step.complete {
    opacity: 1;
    background: #d1fae5;
}

.flow-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: white;
    color: #3b82f6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.125rem;
}

.flow-step.complete .flow-icon {
    background: #10b981;
    color: white;
}

.flow-content strong {
    display: block;
    color: #1e293b;
    font-size: 0.9375rem;
    margin-bottom: 0.125rem;
}

.flow-content small {
    color: #64748b;
    font-size: 0.8125rem;
}

/* Timeline */
.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline-item {
    position: relative;
    padding-bottom: 1.5rem;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -2rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e2e8f0;
}

.timeline-item:last-child::before {
    display: none;
}

.timeline-marker {
    position: absolute;
    left: -2.5rem;
    top: 0;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: #cbd5e1;
    border: 3px solid white;
    box-shadow: 0 0 0 2px #cbd5e1;
}

.timeline-item.current .timeline-marker {
    background: #3b82f6;
    box-shadow: 0 0 0 2px #3b82f6, 0 0 0 4px #dbeafe;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { box-shadow: 0 0 0 2px #3b82f6, 0 0 0 4px #dbeafe; }
    50% { box-shadow: 0 0 0 2px #3b82f6, 0 0 0 8px rgba(59, 130, 246, 0.3); }
}

.timeline-status {
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.timeline-desc {
    color: #64748b;
    margin-bottom: 0.5rem;
    line-height: 1.6;
}

.timeline-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    font-size: 0.8125rem;
    color: #94a3b8;
    margin-bottom: 0.25rem;
}

.timeline-meta i {
    margin-right: 0.25rem;
}

.timeline-date {
    font-size: 0.75rem;
    color: #cbd5e1;
}

/* Quick Actions */
.quick-actions {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.action-btn {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.875rem 1.125rem;
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    color: #475569;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
    cursor: pointer;
}

.action-btn:hover {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
    transform: translateX(4px);
}

.action-btn i {
    font-size: 1.125rem;
}

/* Help Card */
.help-card {
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    border: 2px solid #3b82f6;
    text-align: center;
}

.help-card i {
    font-size: 3rem;
    color: #3b82f6;
    margin-bottom: 1rem;
}

.help-card h4 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.help-card p {
    color: #64748b;
    margin-bottom: 1.5rem;
}

.contact-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.contact-list a {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.875rem;
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    color: #3b82f6;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
}

.contact-list a:hover {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

@media (max-width: 1024px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .detail-hero h1 {
        font-size: 1.75rem;
    }

    .hero-meta {
        flex-direction: column;
        align-items: start;
    }

    .meta-grid {
        grid-template-columns: 1fr;
    }
}

@media print {
    .back-link,
    .quick-actions,
    .help-card,
    .feedback-card {
        display: none !important;
    }
}
</style>

<script>
function shareComplaint() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $complaint->subject }}',
            text: 'Pengaduan saya: {{ $complaint->ticket_number }}',
            url: window.location.href
        }).catch(() => {});
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(window.location.href);
        alert('Link telah dicopy ke clipboard!');
    }
}
</script>

@if(session('success'))
<script>
    alert('{{ session('success') }}');
</script>
@endif

@endsection