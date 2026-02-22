@extends('layouts.app')

@section('title', 'Kelola Pengaduan')

@section('content')
<div class="complaints-page">
    <!-- Header -->
    <div class="page-header">
        <div class="header-left">
            <h1><i class="fas fa-inbox"></i> Kelola Pengaduan</h1>
            <p class="subtitle">Manage dan respon semua pengaduan masyarakat</p>
        </div>
        <div class="header-right">
            <a href="{{ route('admin.complaints.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <button type="button" onclick="exportComplaints()" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Export
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-icon">
                <i class="fas fa-inbox"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Total Pengaduan</span>
                <span class="stat-value">{{ number_format($stats['total']) }}</span>
            </div>
        </div>

        <div class="stat-card submitted">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Menunggu Verifikasi</span>
                <span class="stat-value">{{ number_format($stats['submitted']) }}</span>
            </div>
        </div>

        <div class="stat-card in-progress">
            <div class="stat-icon">
                <i class="fas fa-cog"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Sedang Diproses</span>
                <span class="stat-value">{{ number_format($stats['in_progress']) }}</span>
            </div>
        </div>

        <div class="stat-card resolved">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Selesai</span>
                <span class="stat-value">{{ number_format($stats['resolved']) }}</span>
            </div>
        </div>

        <div class="stat-card rating">
            <div class="stat-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Rata-rata Rating</span>
                <span class="stat-value">{{ number_format($stats['avg_rating'] ?? 0, 1) }}</span>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-card">
        <div class="filter-header" onclick="toggleFilters()">
            <h3><i class="fas fa-filter"></i> Filter & Pencarian</h3>
            <i class="fas fa-chevron-down toggle-icon"></i>
        </div>
        
        <form method="GET" action="{{ route('admin.complaints.index') }}" id="filterForm" class="filter-content">
            <div class="filter-grid">
                <!-- Status Filter -->
                <div class="filter-item">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Diajukan</option>
                        <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Diverifikasi</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Sedang Diproses</option>
                        <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Diselesaikan</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Ditutup</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <!-- Priority Filter -->
                <div class="filter-item">
                    <label>Prioritas</label>
                    <select name="priority" class="form-control">
                        <option value="">Semua Prioritas</option>
                        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Sedang</option>
                        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                        <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Mendesak</option>
                    </select>
                </div>

                <!-- Service Filter -->
                <div class="filter-item">
                    <label>Layanan</label>
                    <select name="service" class="form-control">
                        <option value="">Semua Layanan</option>
                        @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ request('service') == $service->id ? 'selected' : '' }}>
                            {{ $service->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date From -->
                <div class="filter-item">
                    <label>Dari Tanggal</label>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>

                <!-- Date To -->
                <div class="filter-item">
                    <label>Sampai Tanggal</label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>

                <!-- Search -->
                <div class="filter-item filter-search">
                    <label>Cari</label>
                    <input type="text" name="search" class="form-control" placeholder="Ticket, Nama, Phone..." value="{{ request('search') }}">
                </div>
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Filter
                </button>
                <a href="{{ route('admin.complaints.index') }}" class="btn btn-secondary">
                    <i class="fas fa-redo"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Complaints Table -->
    <div class="table-card">
        <div class="table-header">
            <h3>Daftar Pengaduan</h3>
            <span class="badge badge-info">{{ $complaints->total() }} pengaduan</span>
        </div>

        <div class="table-responsive">
            <table class="complaints-table">
                <thead>
                    <tr>
                        <th width="120">Nomor Tiket</th>
                        <th width="100">Tanggal</th>
                        <th>Pelapor</th>
                        <th>Layanan</th>
                        <th>Subjek</th>
                        <th width="120">Status</th>
                        <th width="100">Prioritas</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($complaints as $complaint)
                    <tr>
                        <td>
                            <span class="ticket-number">{{ $complaint->ticket_number }}</span>
                        </td>
                        <td>
                            <span class="date">{{ $complaint->created_at->format('d/m/Y') }}</span>
                            <small class="time">{{ $complaint->created_at->format('H:i') }}</small>
                        </td>
                        <td>
                            <div class="reporter-info">
                                <strong>{{ $complaint->reporter_name }}</strong>
                                <small>{{ $complaint->reporter_phone }}</small>
                            </div>
                        </td>
                        <td>
                            <span class="service-badge" style="background: {{ $complaint->service->color }}20; color: {{ $complaint->service->color }};">
                                <i class="fas {{ $complaint->service->icon }}"></i>
                                {{ $complaint->service->name }}
                            </span>
                        </td>
                        <td>
                            <div class="subject-cell">
                                {{ Str::limit($complaint->subject, 50) }}
                            </div>
                        </td>
                        <td>
                            <select class="status-select status-{{ $complaint->status }}" 
                                    onchange="quickUpdateStatus({{ $complaint->id }}, this.value)"
                                    data-original="{{ $complaint->status }}">
                                <option value="submitted" {{ $complaint->status == 'submitted' ? 'selected' : '' }}>Diajukan</option>
                                <option value="verified" {{ $complaint->status == 'verified' ? 'selected' : '' }}>Diverifikasi</option>
                                <option value="in_progress" {{ $complaint->status == 'in_progress' ? 'selected' : '' }}>Sedang Diproses</option>
                                <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>Diselesaikan</option>
                                <option value="rejected" {{ $complaint->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </td>
                        <td>
                            <span class="priority-badge priority-{{ $complaint->priority }}">
                                {{ $complaint->priority_label }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.complaints.show', $complaint->id) }}" 
                                   class="btn-action btn-view" 
                                   title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button type="button" 
                                        class="btn-action btn-delete" 
                                        onclick="deleteComplaint({{ $complaint->id }})"
                                        title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>Tidak ada pengaduan ditemukan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($complaints->hasPages())
        <div class="table-footer">
            <div class="pagination-info">
                Menampilkan {{ $complaints->firstItem() }} - {{ $complaints->lastItem() }} dari {{ $complaints->total() }}
            </div>
            <div class="pagination-links">
                {{ $complaints->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Delete Form (Hidden) -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<style>
.complaints-page {
    padding: 2rem;
    background: #f8fafc;
    min-height: 100vh;
}

/* Header */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 2rem;
}

.page-header h1 {
    font-size: 2rem;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.subtitle {
    color: #64748b;
    font-size: 0.9375rem;
}

.header-right {
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
    text-decoration: none;
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

.btn-success {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s;
    border-left: 4px solid;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.12);
}

.stat-card.total { border-left-color: #3b82f6; }
.stat-card.submitted { border-left-color: #f59e0b; }
.stat-card.in-progress { border-left-color: #8b5cf6; }
.stat-card.resolved { border-left-color: #10b981; }
.stat-card.rating { border-left-color: #f59e0b; }

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
}

.stat-card.total .stat-icon { background: #dbeafe; color: #3b82f6; }
.stat-card.submitted .stat-icon { background: #fef3c7; color: #f59e0b; }
.stat-card.in-progress .stat-icon { background: #e9d5ff; color: #8b5cf6; }
.stat-card.resolved .stat-icon { background: #d1fae5; color: #10b981; }
.stat-card.rating .stat-icon { background: #fef3c7; color: #f59e0b; }

.stat-info {
    display: flex;
    flex-direction: column;
}

.stat-label {
    font-size: 0.875rem;
    color: #64748b;
    margin-bottom: 0.25rem;
}

.stat-value {
    font-size: 1.875rem;
    font-weight: 800;
    color: #1e293b;
}

/* Filter Card */
.filter-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
    overflow: hidden;
}

.filter-header {
    padding: 1.25rem 1.5rem;
    background: #f8fafc;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    user-select: none;
}

.filter-header h3 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0;
}

.toggle-icon {
    transition: transform 0.3s;
    color: #64748b;
}

.filter-card.collapsed .toggle-icon {
    transform: rotate(-90deg);
}

.filter-content {
    padding: 1.5rem;
    display: block;
}

.filter-card.collapsed .filter-content {
    display: none;
}

.filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.25rem;
    margin-bottom: 1.5rem;
}

.filter-item.filter-search {
    grid-column: span 2;
}

.filter-item label {
    display: block;
    font-weight: 600;
    color: #334155;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.form-control {
    width: 100%;
    padding: 0.625rem 0.875rem;
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

.filter-actions {
    display: flex;
    gap: 1rem;
}

/* Table Card */
.table-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    overflow: hidden;
}

.table-header {
    padding: 1.25rem 1.5rem;
    background: #f8fafc;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #e2e8f0;
}

.table-header h3 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}

.badge {
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-size: 0.8125rem;
    font-weight: 600;
}

.badge-info {
    background: #dbeafe;
    color: #1e40af;
}

.table-responsive {
    overflow-x: auto;
}

.complaints-table {
    width: 100%;
    border-collapse: collapse;
}

.complaints-table thead {
    background: #f8fafc;
}

.complaints-table th {
    padding: 1rem 1.25rem;
    text-align: left;
    font-weight: 700;
    color: #475569;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.complaints-table td {
    padding: 1rem 1.25rem;
    border-top: 1px solid #f1f5f9;
    vertical-align: middle;
}

.complaints-table tbody tr:hover {
    background: #f8fafc;
}

.ticket-number {
    font-family: 'Courier New', monospace;
    font-weight: 700;
    color: #3b82f6;
    font-size: 0.875rem;
}

.date {
    display: block;
    font-weight: 600;
    color: #1e293b;
}

.time {
    display: block;
    color: #94a3b8;
    font-size: 0.8125rem;
    margin-top: 0.125rem;
}

.reporter-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.reporter-info strong {
    color: #1e293b;
    font-size: 0.9375rem;
}

.reporter-info small {
    color: #64748b;
    font-size: 0.8125rem;
}

.service-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-size: 0.8125rem;
    font-weight: 600;
}

.subject-cell {
    max-width: 300px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    color: #475569;
}

.status-select {
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
    border: 2px solid;
    font-weight: 600;
    font-size: 0.8125rem;
    cursor: pointer;
    transition: all 0.3s;
}

.status-select.status-submitted {
    background: #fef3c7;
    color: #92400e;
    border-color: #fbbf24;
}

.status-select.status-verified {
    background: #dbeafe;
    color: #1e40af;
    border-color: #3b82f6;
}

.status-select.status-in_progress {
    background: #e9d5ff;
    color: #6b21a8;
    border-color: #8b5cf6;
}

.status-select.status-resolved {
    background: #d1fae5;
    color: #065f46;
    border-color: #10b981;
}

.status-select.status-rejected {
    background: #fee2e2;
    color: #991b1b;
    border-color: #ef4444;
}

.priority-badge {
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-size: 0.8125rem;
    font-weight: 600;
    display: inline-block;
}

.priority-badge.priority-low {
    background: #d1fae5;
    color: #065f46;
}

.priority-badge.priority-medium {
    background: #fef3c7;
    color: #92400e;
}

.priority-badge.priority-high {
    background: #fee2e2;
    color: #991b1b;
}

.priority-badge.priority-urgent {
    background: #fecaca;
    color: #7f1d1d;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn-action {
    width: 36px;
    height: 36px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
    text-decoration: none;
}

.btn-view {
    background: #dbeafe;
    color: #1e40af;
}

.btn-view:hover {
    background: #3b82f6;
    color: white;
}

.btn-delete {
    background: #fee2e2;
    color: #991b1b;
}

.btn-delete:hover {
    background: #ef4444;
    color: white;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem !important;
    color: #94a3b8;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state p {
    font-size: 1.125rem;
    margin: 0;
}

.table-footer {
    padding: 1.25rem 1.5rem;
    background: #f8fafc;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid #e2e8f0;
}

.pagination-info {
    color: #64748b;
    font-size: 0.875rem;
}

@media (max-width: 1024px) {
    .filter-grid {
        grid-template-columns: 1fr 1fr;
    }
    
    .filter-item.filter-search {
        grid-column: span 2;
    }
}

@media (max-width: 768px) {
    .complaints-page {
        padding: 1rem;
    }
    
    .page-header {
        flex-direction: column;
        gap: 1rem;
    }
    
    .header-right {
        width: 100%;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .filter-grid {
        grid-template-columns: 1fr;
    }
    
    .filter-item.filter-search {
        grid-column: span 1;
    }
}
</style>

<script>
// Toggle filters
function toggleFilters() {
    const filterCard = document.querySelector('.filter-card');
    filterCard.classList.toggle('collapsed');
}

// Quick status update
function quickUpdateStatus(id, newStatus) {
    const select = event.target;
    const originalStatus = select.dataset.original;
    
    if (confirm('Update status pengaduan ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/complaints/${id}/quick-status`;
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        
        const statusInput = document.createElement('input');
        statusInput.type = 'hidden';
        statusInput.name = 'status';
        statusInput.value = newStatus;
        
        form.appendChild(csrfInput);
        form.appendChild(statusInput);
        document.body.appendChild(form);
        form.submit();
    } else {
        select.value = originalStatus;
    }
}

// Delete complaint
function deleteComplaint(id) {
    if (confirm('Yakin ingin menghapus pengaduan ini? Tindakan ini tidak dapat dibatalkan!')) {
        const form = document.getElementById('deleteForm');
        form.action = `/admin/complaints/${id}`;
        form.submit();
    }
}

// Export complaints
function exportComplaints() {
    const params = new URLSearchParams(window.location.search);
    const url = '{{ route("admin.complaints.export") }}?' + params.toString();
    
    const btn = event.target.closest('.btn-success');
    const originalText = btn.innerHTML;
    
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Exporting...';
    btn.disabled = true;
    
    window.location.href = url;
    
    setTimeout(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
    }, 2000);
}

// Auto-collapse filters on mobile
window.addEventListener('resize', function() {
    if (window.innerWidth < 768) {
        document.querySelector('.filter-card').classList.add('collapsed');
    }
});

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Auto-collapse on mobile
    if (window.innerWidth < 768) {
        document.querySelector('.filter-card').classList.add('collapsed');
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