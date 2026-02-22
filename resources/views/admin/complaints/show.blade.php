@extends('layouts.app')

@section('title', 'Detail Pengaduan')

@section('content')
<div class="complaint-detail-page">
    <!-- Header -->
    <div class="page-header">
        <a href="{{ route('admin.complaints.index') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <div class="header-actions">
            <button onclick="window.print()" class="btn btn-secondary">
                <i class="fas fa-print"></i> Print
            </button>
            <button onclick="deleteComplaint({{ $complaint->id }})" class="btn btn-danger">
                <i class="fas fa-trash"></i> Hapus
            </button>
        </div>
    </div>

    <div class="detail-grid">
        <!-- Left Column -->
        <div class="left-column">
            <!-- Complaint Info Card -->
            <div class="info-card">
                <div class="card-header">
                    <h2>Informasi Pengaduan</h2>
                    <span class="ticket-badge">{{ $complaint->ticket_number }}</span>
                </div>

                <div class="info-section">
                    <h3><i class="fas fa-list"></i> Detail</h3>
                    <table class="info-table">
                        <tr>
                            <td>Layanan</td>
                            <td>
                                <span class="service-badge" style="background: {{ $complaint->service->color }}20; color: {{ $complaint->service->color }};">
                                    <i class="fas {{ $complaint->service->icon }}"></i>
                                    {{ $complaint->service->name }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>
                                <span class="status-badge status-{{ $complaint->status }}">
                                    {{ $complaint->status_label }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Prioritas</td>
                            <td>
                                <span class="priority-badge priority-{{ $complaint->priority }}">
                                    {{ $complaint->priority_label }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal Diajukan</td>
                            <td><strong>{{ $complaint->created_at->format('d M Y, H:i') }}</strong></td>
                        </tr>
                        @if($complaint->verified_at)
                        <tr>
                            <td>Tanggal Diverifikasi</td>
                            <td>{{ $complaint->verified_at->format('d M Y, H:i') }}</td>
                        </tr>
                        @endif
                        @if($complaint->resolved_at)
                        <tr>
                            <td>Tanggal Diselesaikan</td>
                            <td>{{ $complaint->resolved_at->format('d M Y, H:i') }}</td>
                        </tr>
                        @endif
                        @if($complaint->assigned_to)
                        <tr>
                            <td>Ditugaskan Ke</td>
                            <td>{{ $complaint->assigned_to }}</td>
                        </tr>
                        @endif
                    </table>
                </div>

                <div class="info-section">
                    <h3><i class="fas fa-user"></i> Data Pelapor</h3>
                    <table class="info-table">
                        <tr>
                            <td>Nama</td>
                            <td><strong>{{ $complaint->reporter_name }}</strong></td>
                        </tr>
                        @if($complaint->reporter_nik)
                        <tr>
                            <td>NIK</td>
                            <td>{{ $complaint->reporter_nik }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td>No. HP</td>
                            <td>{{ $complaint->reporter_phone }}</td>
                        </tr>
                        @if($complaint->reporter_email)
                        <tr>
                            <td>Email</td>
                            <td>{{ $complaint->reporter_email }}</td>
                        </tr>
                        @endif
                        @if($complaint->reporter_address)
                        <tr>
                            <td>Alamat</td>
                            <td>{{ $complaint->reporter_address }}</td>
                        </tr>
                        @endif
                    </table>
                </div>

                <div class="info-section">
                    <h3><i class="fas fa-exclamation-circle"></i> Isi Pengaduan</h3>
                    <div class="subject-box">
                        <strong>{{ $complaint->subject }}</strong>
                    </div>
                    <div class="description-box">
                        {{ $complaint->description }}
                    </div>
                    @if($complaint->location)
                    <div class="meta-info">
                        <i class="fas fa-map-marker-alt"></i> Lokasi: {{ $complaint->location }}
                    </div>
                    @endif
                    @if($complaint->incident_date)
                    <div class="meta-info">
                        <i class="fas fa-calendar"></i> Tanggal Kejadian: {{ \Carbon\Carbon::parse($complaint->incident_date)->format('d M Y') }}
                    </div>
                    @endif
                </div>

                @if($complaint->evidence_file)
                <div class="info-section">
                    <h3><i class="fas fa-paperclip"></i> File Bukti</h3>
                    <a href="{{ route('public.complaints.download-evidence', $complaint->ticket_number) }}" class="download-btn" target="_blank">
                        <i class="fas fa-download"></i> Download Bukti ({{ $complaint->evidence_file_size }})
                    </a>
                </div>
                @endif

                @if($complaint->response)
                <div class="info-section response-section">
                    <h3><i class="fas fa-comment"></i> Tanggapan</h3>
                    <div class="response-box">
                        {{ $complaint->response }}
                    </div>
                    @if($complaint->response_file)
                    <a href="{{ route('public.complaints.download-response', $complaint->ticket_number) }}" class="download-btn" target="_blank">
                        <i class="fas fa-download"></i> Download File Tanggapan
                    </a>
                    @endif
                </div>
                @endif

                @if($complaint->satisfaction_rating)
                <div class="info-section rating-section">
                    <h3><i class="fas fa-star"></i> Feedback & Rating</h3>
                    <div class="rating-display">
                        @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= $complaint->satisfaction_rating ? 'filled' : '' }}"></i>
                        @endfor
                        <span class="rating-value">{{ $complaint->satisfaction_rating }}/5</span>
                    </div>
                    @if($complaint->feedback)
                    <div class="feedback-box">
                        {{ $complaint->feedback }}
                    </div>
                    @endif
                </div>
                @endif
            </div>

            <!-- Timeline -->
            <div class="timeline-card">
                <h2><i class="fas fa-history"></i> Timeline Pengaduan</h2>
                <div class="timeline">
                    @foreach($complaint->histories->reverse() as $index => $history)
                    <div class="timeline-item {{ $index === 0 ? 'current' : '' }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="timeline-status">{{ $history->status }}</div>
                            <p class="timeline-desc">{{ $history->description }}</p>
                            <div class="timeline-meta">
                                <span><i class="fas fa-clock"></i> {{ $history->created_at->format('d M Y, H:i') }}</span>
                                <span><i class="fas fa-user"></i> {{ $history->updated_by }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="right-column">
            <!-- Update Status Form -->
            <div class="form-card">
                <h2><i class="fas fa-edit"></i> Update Status & Tanggapan</h2>
                
                <form action="{{ route('admin.complaints.update-status', $complaint->id) }}" method="POST" enctype="multipart/form-data" id="updateForm">
                    @csrf
                    
                    <div class="form-group">
                        <label class="required">Status Baru</label>
                        <select name="status" class="form-control" required>
                            <option value="submitted" {{ $complaint->status == 'submitted' ? 'selected' : '' }}>Diajukan</option>
                            <option value="verified" {{ $complaint->status == 'verified' ? 'selected' : '' }}>Diverifikasi</option>
                            <option value="in_progress" {{ $complaint->status == 'in_progress' ? 'selected' : '' }}>Sedang Diproses</option>
                            <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>Diselesaikan</option>
                            <option value="rejected" {{ $complaint->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Catatan Admin (Internal)</label>
                        <textarea name="admin_notes" 
                                  class="form-control" 
                                  rows="3" 
                                  placeholder="Catatan internal untuk tim...">{{ old('admin_notes', $complaint->admin_notes) }}</textarea>
                        <small>Catatan ini tidak akan dikirim ke pelapor</small>
                    </div>

                    <div class="form-group">
                        <label>Tanggapan (Publik)</label>
                        <textarea name="response" 
                                  class="form-control" 
                                  rows="5" 
                                  placeholder="Tanggapan yang akan dikirim ke pelapor...">{{ old('response', $complaint->response) }}</textarea>
                        <small>Tanggapan ini akan dikirim via email ke pelapor</small>
                    </div>

                    <div class="form-group">
                        <label>Upload File Tanggapan</label>
                        <input type="file" 
                               name="response_file" 
                               class="form-control" 
                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <small>Format: PDF, DOC, DOCX, JPG, PNG (Max 10MB)</small>
                        @if($complaint->response_file)
                        <div class="current-file">
                            <i class="fas fa-file"></i> File saat ini: {{ basename($complaint->response_file) }}
                        </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Ditugaskan Ke</label>
                        <input type="text" 
                               name="assigned_to" 
                               class="form-control" 
                               placeholder="Nama staff yang menangani..."
                               value="{{ old('assigned_to', $complaint->assigned_to) }}">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-paper-plane"></i> Update & Kirim Notifikasi
                    </button>
                </form>
            </div>

            <!-- Quick Actions -->
            <div class="actions-card">
                <h3>Quick Actions</h3>
                <div class="quick-actions">
                    @if($complaint->evidence_file)
                    <a href="{{ route('public.complaints.download-evidence', $complaint->ticket_number) }}" class="quick-btn" target="_blank">
                        <i class="fas fa-download"></i> Download Bukti
                    </a>
                    @endif
                    
                    @if($complaint->response_file)
                    <a href="{{ route('public.complaints.download-response', $complaint->ticket_number) }}" class="quick-btn" target="_blank">
                        <i class="fas fa-download"></i> Download Tanggapan
                    </a>
                    @endif
                    
                    <a href="{{ route('public.complaints.show', $complaint->ticket_number) }}" class="quick-btn" target="_blank">
                        <i class="fas fa-external-link-alt"></i> Lihat Halaman Public
                    </a>
                    
                    @if($complaint->reporter_email)
                    <a href="mailto:{{ $complaint->reporter_email }}" class="quick-btn">
                        <i class="fas fa-envelope"></i> Email Pelapor
                    </a>
                    @endif
                    
                    <a href="tel:{{ $complaint->reporter_phone }}" class="quick-btn">
                        <i class="fas fa-phone"></i> Call Pelapor
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Form (Hidden) -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<style>
.complaint-detail-page {
    padding: 2rem;
    background: #f8fafc;
    min-height: 100vh;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #475569;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
}

.back-btn:hover {
    color: #3b82f6;
    transform: translateX(-4px);
}

.header-actions {
    display: flex;
    gap: 1rem;
}

.btn {
    padding: 0.625rem 1.25rem;
    border-radius: 8px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9375rem;
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
    background: #f1f5f9;
    color: #475569;
}

.btn-secondary:hover {
    background: #e2e8f0;
}

.btn-danger {
    background: #fee2e2;
    color: #991b1b;
}

.btn-danger:hover {
    background: #ef4444;
    color: white;
}

.btn-block {
    width: 100%;
    justify-content: center;
}

.detail-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
}

/* Cards */
.info-card,
.timeline-card,
.form-card,
.actions-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f1f5f9;
}

.card-header h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}

.ticket-badge {
    background: #dbeafe;
    color: #1e40af;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 700;
    font-family: 'Courier New', monospace;
}

.info-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #f1f5f9;
}

.info-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.info-section h3 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #475569;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-table {
    width: 100%;
}

.info-table td {
    padding: 0.75rem 0;
    border-bottom: 1px solid #f8fafc;
}

.info-table td:first-child {
    font-weight: 600;
    color: #64748b;
    width: 180px;
}

.info-table td:last-child {
    color: #1e293b;
}

.service-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 600;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.875rem;
    display: inline-block;
}

.status-badge.status-submitted { background: #fef3c7; color: #92400e; }
.status-badge.status-verified { background: #dbeafe; color: #1e40af; }
.status-badge.status-in_progress { background: #e9d5ff; color: #6b21a8; }
.status-badge.status-resolved { background: #d1fae5; color: #065f46; }
.status-badge.status-closed { background: #f1f5f9; color: #475569; }
.status-badge.status-rejected { background: #fee2e2; color: #991b1b; }

.priority-badge {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.875rem;
    display: inline-block;
}

.priority-badge.priority-low { background: #d1fae5; color: #065f46; }
.priority-badge.priority-medium { background: #fef3c7; color: #92400e; }
.priority-badge.priority-high { background: #fee2e2; color: #991b1b; }
.priority-badge.priority-urgent { background: #fecaca; color: #7f1d1d; }

.subject-box {
    background: #f8fafc;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
    font-size: 1.125rem;
    color: #1e293b;
}

.description-box {
    background: #fff;
    padding: 1.25rem;
    border: 2px solid #f1f5f9;
    border-radius: 8px;
    line-height: 1.8;
    color: #475569;
    white-space: pre-wrap;
    margin-bottom: 1rem;
}

.meta-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #64748b;
    font-size: 0.9375rem;
    margin-bottom: 0.5rem;
}

.download-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
    font-size: 0.9375rem;
}

.download-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
}

.response-section {
    background: #eff6ff;
    border: 2px solid #3b82f6;
    border-radius: 12px;
    padding: 1.5rem;
}

.response-box {
    background: white;
    padding: 1.25rem;
    border-radius: 8px;
    line-height: 1.8;
    color: #1e293b;
    white-space: pre-wrap;
    margin-bottom: 1rem;
}

.rating-section {
    background: #fef3c7;
    border: 2px solid #f59e0b;
    border-radius: 12px;
    padding: 1.5rem;
}

.rating-display {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

.rating-display i.filled {
    color: #f59e0b;
}

.rating-display i:not(.filled) {
    color: #d1d5db;
}

.rating-value {
    font-size: 1.125rem;
    font-weight: 700;
    color: #92400e;
    margin-left: 0.5rem;
}

.feedback-box {
    background: white;
    padding: 1rem;
    border-radius: 8px;
    color: #92400e;
    line-height: 1.7;
}

/* Timeline */
.timeline-card h2 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline-item {
    position: relative;
    padding-bottom: 2rem;
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
    background: #e2e8f0;
    border: 3px solid white;
    box-shadow: 0 0 0 2px #e2e8f0;
}

.timeline-item.current .timeline-marker {
    background: #3b82f6;
    box-shadow: 0 0 0 2px #3b82f6, 0 0 0 4px #dbeafe;
}

.timeline-status {
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
    font-size: 1rem;
}

.timeline-desc {
    color: #64748b;
    margin-bottom: 0.75rem;
    line-height: 1.6;
}

.timeline-meta {
    display: flex;
    gap: 1.5rem;
    font-size: 0.8125rem;
    color: #94a3b8;
}

.timeline-meta i {
    margin-right: 0.25rem;
}

/* Form */
.form-card h2 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    font-weight: 600;
    color: #334155;
    margin-bottom: 0.5rem;
    font-size: 0.9375rem;
}

.form-group label.required::after {
    content: '*';
    color: #ef4444;
    margin-left: 0.25rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.9375rem;
    transition: all 0.3s;
}

.form-control:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

textarea.form-control {
    resize: vertical;
    font-family: inherit;
}

.form-group small {
    display: block;
    color: #94a3b8;
    font-size: 0.8125rem;
    margin-top: 0.375rem;
}

.current-file {
    margin-top: 0.75rem;
    padding: 0.75rem;
    background: #f8fafc;
    border-radius: 6px;
    color: #475569;
    font-size: 0.875rem;
}

/* Actions Card */
.actions-card h3 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1rem;
}

.quick-actions {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.quick-btn {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.875rem 1rem;
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    color: #475569;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
    font-size: 0.9375rem;
}

.quick-btn:hover {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
    transform: translateX(4px);
}

@media print {
    .page-header,
    .form-card,
    .actions-card {
        display: none !important;
    }
    
    .detail-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 1024px) {
    .detail-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .complaint-detail-page {
        padding: 1rem;
    }
    
    .page-header {
        flex-direction: column;
        gap: 1rem;
    }
    
    .header-actions {
        width: 100%;
    }
}
</style>

<script>
function deleteComplaint(id) {
    if (confirm('Yakin ingin menghapus pengaduan ini? Tindakan ini tidak dapat dibatalkan!')) {
        const form = document.getElementById('deleteForm');
        form.action = `/admin/complaints/${id}`;
        form.submit();
    }
}

// Form validation
document.getElementById('updateForm').addEventListener('submit', function(e) {
    const status = this.querySelector('[name="status"]').value;
    const response = this.querySelector('[name="response"]').value;
    
    if (status === 'resolved' && !response) {
        if (!confirm('Anda akan menyelesaikan pengaduan tanpa tanggapan. Lanjutkan?')) {
            e.preventDefault();
        }
    }
});
</script>

@if(session('success'))
<script>
    alert('{{ session('success') }}');
</script>
@endif

@if(session('error'))
<script>
    alert('{{ session('error') }}');
</script>
@endif

@endsection