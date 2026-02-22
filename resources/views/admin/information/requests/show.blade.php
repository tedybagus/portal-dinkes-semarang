@extends('layouts.app')

@section('title', 'Detail Permohonan')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-file-alt"></i> Detail Permohonan Informasi</h1>
    <div class="header-actions">
        <a href="{{ route('admin.information-requests.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <button onclick="window.print()" class="btn-primary">
            <i class="fas fa-print"></i> Print
        </button>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
</div>
@endif

<div class="detail-grid">
    <!-- Left Column -->
    <div class="detail-main">
        <!-- Request Info Card -->
        <div class="card">
            <div class="card-header">
                <div>
                    <h3><i class="fas fa-info-circle"></i> Informasi Permohonan</h3>
                    <code class="reg-number">{{ $request->registration_number }}</code>
                </div>
                <span class="status-badge status-{{ $request->status }}">
                    {{ $request->status_label }}
                </span>
            </div>
            <div class="card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <label><i class="fas fa-user"></i> Nama Pemohon</label>
                        <span>{{ $request->name }}</span>
                    </div>
                    <div class="info-item">
                        <label><i class="fas fa-id-card"></i> NIK</label>
                        <span>{{ $request->id_card_number }}</span>
                    </div>
                    <div class="info-item">
                        <label><i class="fas fa-envelope"></i> Email</label>
                        <span>{{ $request->email }}</span>
                    </div>
                    <div class="info-item">
                        <label><i class="fas fa-phone"></i> Telepon</label>
                        <span>{{ $request->phone }}</span>
                    </div>
                    <div class="info-item full">
                        <label><i class="fas fa-map-marker-alt"></i> Alamat</label>
                        <span>{{ $request->address }}</span>
                    </div>
                    <div class="info-item">
                        <label><i class="fas fa-users"></i> Jenis Pemohon</label>
                        <span>{{ $request->requester_type_label }}</span>
                    </div>
                    <div class="info-item">
                        <label><i class="fas fa-calendar"></i> Tanggal Pengajuan</label>
                        <span>{{ $request->submitted_at->format('d M Y, H:i') }} WIB</span>
                    </div>
                </div>

                @if($request->id_card_file)
                <div class="file-section">
                    <label><i class="fas fa-paperclip"></i> File KTP</label>
                    <a href="{{ asset('storage/' . $request->id_card_file) }}" target="_blank" class="btn btn-sm btn-info">
                        <i class="fas fa-download"></i> Lihat KTP
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Information Details -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-file-alt"></i> Detail Informasi yang Dimohonkan</h3>
            </div>
            <div class="card-body">
                <div class="detail-section">
                    <label><i class="fas fa-info-circle"></i> Informasi yang Dibutuhkan:</label>
                    <p>{{ $request->information_needed }}</p>
                </div>

                <div class="detail-section">
                    <label><i class="fas fa-bullseye"></i> Tujuan Penggunaan Informasi:</label>
                    <p>{{ $request->information_purpose }}</p>
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <label><i class="fas fa-file"></i> Format Informasi</label>
                        <span class="badge badge-primary">{{ ucfirst($request->information_format) }}</span>
                    </div>
                    <div class="info-item">
                        <label><i class="fas fa-truck"></i> Cara Pengambilan</label>
                        <span class="badge badge-info">{{ ucfirst($request->delivery_method) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-history"></i> Riwayat Tindak Lanjut</h3>
            </div>
            <div class="card-body">
                <div class="timeline">
                    @foreach($request->followups as $followup)
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="timeline-header">
                                <span class="timeline-status">{{ $followup->status }}</span>
                                <span class="timeline-date">{{ $followup->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            <p>{{ $followup->description }}</p>
                            @if($followup->updated_by)
                            <small class="text-muted">oleh: {{ $followup->updated_by }}</small>
                            @endif
                        </div>
                    </div>
                    @endforeach

                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="timeline-header">
                                <span class="timeline-status">submitted</span>
                                <span class="timeline-date">{{ $request->submitted_at->format('d M Y, H:i') }}</span>
                            </div>
                            <p>Permohonan informasi diajukan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="detail-sidebar">
        <!-- Update Status -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-edit"></i> Update Status</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.information-requests.update-status', $request->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="status" class="form-label required">Status Baru</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="">Pilih Status</option>
                            <option value="submitted" {{ $request->status == 'submitted' ? 'selected' : '' }}>Diajukan</option>
                            <option value="verified" {{ $request->status == 'verified' ? 'selected' : '' }}>Diverifikasi</option>
                            <option value="processed" {{ $request->status == 'processed' ? 'selected' : '' }}>Sedang Diproses</option>
                            <option value="ready" {{ $request->status == 'ready' ? 'selected' : '' }}>Siap Diambil</option>
                            <option value="completed" {{ $request->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="rejected" {{ $request->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label required">Keterangan</label>
                        <textarea name="description" id="description" class="form-control" rows="3" required placeholder="Jelaskan update status..."></textarea>
                    </div>

                    <div class="form-group" id="rejection_reason_group" style="display: none;">
                        <label for="rejection_reason" class="form-label">Alasan Penolakan</label>
                        <textarea name="rejection_reason" id="rejection_reason" class="form-control" rows="3" placeholder="Jelaskan alasan penolakan..."></textarea>
                    </div>

                    <div class="form-group">
                        <label for="admin_notes" class="form-label">Catatan Admin</label>
                        <textarea name="admin_notes" id="admin_notes" class="form-control" rows="2" placeholder="Catatan internal (opsional)">{{ $request->admin_notes }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save"></i> Update Status
                    </button>
                </form>
            </div>
        </div>

        <!-- Upload Result -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-upload"></i> Upload File Hasil</h3>
            </div>
            <div class="card-body">
                @if($request->result_file)
                <div class="current-file">
                    <i class="fas fa-file-pdf"></i>
                    <div>
                        <strong>File Saat Ini:</strong>
                        <a href="{{ asset('storage/' . $request->result_file) }}" target="_blank">Lihat File</a>
                    </div>
                </div>
                <hr>
                @endif

                <form action="{{ route('admin.information-requests.upload-result', $request->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="result_file" class="form-label">File Hasil Informasi</label>
                        <input type="file" name="result_file" id="result_file" class="form-control-file" accept=".pdf,.doc,.docx,.zip" required>
                        <small class="form-text">Format: PDF, DOC, DOCX, ZIP (Max. 10MB)</small>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">
                        <i class="fas fa-upload"></i> Upload File
                    </button>
                </form>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-bolt"></i> Aksi Cepat</h3>
            </div>
            <div class="card-body">
                <div class="quick-actions">
                    <button onclick="if(confirm('Verifikasi permohonan ini?')) document.getElementById('quickVerify').submit()" class="quick-action-btn btn-info">
                        <i class="fas fa-check-circle"></i>
                        Verifikasi
                    </button>
                    <button onclick="if(confirm('Tandai sebagai selesai?')) document.getElementById('quickComplete').submit()" class="quick-action-btn btn-success">
                        <i class="fas fa-check-double"></i>
                        Selesai
                    </button>
                    <button onclick="if(confirm('Tolak permohonan ini?')) document.getElementById('rejectModal').style.display='block'" class="quick-action-btn btn-danger">
                        <i class="fas fa-times-circle"></i>
                        Tolak
                    </button>
                </div>

                <!-- Hidden Quick Forms -->
                <form id="quickVerify" action="{{ route('admin.information-requests.update-status', $request->id) }}" method="POST" style="display:none">
                    @csrf
                    <input type="hidden" name="status" value="verified">
                    <input type="hidden" name="description" value="Permohonan telah diverifikasi dan dinyatakan lengkap">
                </form>

                <form id="quickComplete" action="{{ route('admin.information-requests.update-status', $request->id) }}" method="POST" style="display:none">
                    @csrf
                    <input type="hidden" name="status" value="completed">
                    <input type="hidden" name="description" value="Permohonan informasi telah selesai diproses">
                </form>
            </div>
        </div>

        <!-- Delete -->
        <div class="card card-danger">
            <div class="card-header">
                <h3><i class="fas fa-trash"></i> Zona Berbahaya</h3>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">Hapus permohonan ini secara permanen</p>
                <form action="{{ route('admin.information-requests.destroy', $request->id) }}" method="POST" onsubmit="return confirm('PERINGATAN: Tindakan ini tidak dapat dibatalkan!\n\nYakin ingin menghapus permohonan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-block">
                        <i class="fas fa-trash-alt"></i> Hapus Permohonan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="modal" style="display:none">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Tolak Permohonan</h3>
            <button onclick="document.getElementById('rejectModal').style.display='none'" class="close-btn">&times;</button>
        </div>
        <form action="{{ route('admin.information-requests.update-status', $request->id) }}" method="POST">
            @csrf
            <input type="hidden" name="status" value="rejected">
            <div class="modal-body">
                <div class="form-group">
                    <label for="reject_reason" class="form-label required">Alasan Penolakan</label>
                    <textarea name="rejection_reason" id="reject_reason" class="form-control" rows="4" required placeholder="Jelaskan mengapa permohonan ditolak..."></textarea>
                </div>
                <div class="form-group">
                    <label for="reject_desc" class="form-label required">Keterangan</label>
                    <textarea name="description" id="reject_desc" class="form-control" rows="2" required>Permohonan informasi ditolak</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="document.getElementById('rejectModal').style.display='none'" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-danger">Tolak Permohonan</button>
            </div>
        </form>
    </div>
</div>

<style>
.detail-grid {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 2rem;
}

.card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 1.5rem;
}

.card-header {
    padding: 1.5rem;
    border-bottom: 2px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-header h3 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.card-body {
    padding: 1.5rem;
}

.reg-number {
    background: #f1f5f9;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-family: 'Courier New', monospace;
    font-size: 0.875rem;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 700;
    text-transform: uppercase;
}

.status-submitted { background: #fef3c7; color: #92400e; }
.status-verified { background: #dbeafe; color: #1e40af; }
.status-processed { background: #e0e7ff; color: #4338ca; }
.status-ready, .status-completed { background: #d1fae5; color: #065f46; }
.status-rejected { background: #fee2e2; color: #991b1b; }

.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.info-item.full {
    grid-column: 1 / -1;
}

.info-item label {
    font-size: 0.875rem;
    color: #64748b;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-item span {
    color: #1e293b;
    font-size: 1rem;
}

.file-section {
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 2px solid #f1f5f9;
}

.file-section label {
    display: block;
    font-size: 0.875rem;
    color: #64748b;
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.detail-section {
    margin-bottom: 1.5rem;
}

.detail-section label {
    display: block;
    font-size: 0.875rem;
    color: #64748b;
    font-weight: 700;
    margin-bottom: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.detail-section p {
    color: #1e293b;
    line-height: 1.7;
    background: #f8fafc;
    padding: 1rem;
    border-radius: 8px;
    margin: 0;
}

/* Timeline */
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
    margin-bottom: 1.5rem;
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
    padding: 1rem;
    border-radius: 8px;
    border-left: 3px solid #3b82f6;
}

.timeline-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.timeline-status {
    padding: 0.25rem 0.75rem;
    background: #dbeafe;
    color: #1e40af;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 700;
}

.timeline-date {
    font-size: 0.8125rem;
    color: #64748b;
}

.timeline-content p {
    margin: 0 0 0.5rem 0;
    color: #1e293b;
}

/* Forms */
.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #334155;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.form-label.required::after {
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
}

.form-control:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-control-file {
    display: block;
    width: 100%;
    padding: 0.5rem;
    border: 2px dashed #cbd5e1;
    border-radius: 8px;
}

.form-text {
    font-size: 0.8125rem;
    color: #94a3b8;
    margin-top: 0.25rem;
    display: block;
}

.btn-block {
    width: 100%;
    justify-content: center;
}

.current-file {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f1f5f9;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.current-file i {
    font-size: 2rem;
    color: #ef4444;
}

/* Quick Actions */
.quick-actions {
    display: grid;
    gap: 0.75rem;
}

.quick-action-btn {
    padding: 0.875rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s;
    color: white;
}

.quick-action-btn.btn-info {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
}

.quick-action-btn.btn-success {
    background: linear-gradient(135deg, #10b981, #059669);
}

.quick-action-btn.btn-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626);
}

.quick-action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.card-danger {
    border: 2px solid #fee2e2;
}

.card-danger .card-header {
    background: #fef2f2;
    color: #991b1b;
}

/* Modal */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.modal-content {
    background: white;
    border-radius: 16px;
    width: 90%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
}

.modal-header {
    padding: 1.5rem;
    border-bottom: 2px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 700;
}

.close-btn {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: #64748b;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    padding: 1.5rem;
    border-top: 2px solid #f1f5f9;
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

/* Print Styles */
@media print {
    .detail-sidebar, .page-header, .card-danger { display: none !important; }
    .detail-grid { grid-template-columns: 1fr; }
    .card { box-shadow: none; border: 1px solid #e2e8f0; }
}

/* Responsive */
@media (max-width: 1024px) {
    .detail-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .info-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
// Show/hide rejection reason field
document.getElementById('status').addEventListener('change', function() {
    const rejectionGroup = document.getElementById('rejection_reason_group');
    if (this.value === 'rejected') {
        rejectionGroup.style.display = 'block';
        document.getElementById('rejection_reason').required = true;
    } else {
        rejectionGroup.style.display = 'none';
        document.getElementById('rejection_reason').required = false;
    }
});

// Trigger on page load if already rejected
if (document.getElementById('status').value === 'rejected') {
    document.getElementById('rejection_reason_group').style.display = 'block';
}
</script>
@endsection