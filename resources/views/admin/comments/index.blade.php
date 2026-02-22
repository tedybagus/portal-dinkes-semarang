@extends('layouts.app')

@section('title', 'Kelola Komentar Artikel')
@push('styles')
<style>
.filament-page {
    background: #f8fafc;
    min-height: 100vh;
    padding: 2rem;
    font-family: Inter, system-ui, -apple-system, sans-serif;
}
.filament-header {
    margin-bottom: 2rem;
}

.filament-header h1 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #0f172a;
}

.filament-header p {
    margin-top: 0.25rem;
    color: #64748b;
    font-size: 0.95rem;
}
.filament-table {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    overflow: hidden;
}


.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: #ffffff;
    padding: 1.25rem;
    border-radius: 14px;
    display: flex;
    gap: 1rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    border: 1px solid #e5e7eb;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.stat-info {
    display: flex;
    flex-direction: column;
}

.stat-label {
    font-size: 0.875rem;
    color: #6b7280;
}

.stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: #020617;
}

.filter-card {
    background: #ffffff;
    padding: 1.25rem;
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    margin-bottom: 1.5rem;
}
.filter-card input,
.filter-card select {
    width: 100%;
    padding: 0.55rem 0.75rem;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    background: #f8fafc;
    font-size: 0.875rem;
}

.filter-card label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #475569;
    margin-bottom: 0.25rem;
    display: block;
}
/* button filter */
.btn-filter,
.btn-reset {
    padding: 0.55rem 1rem;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
}

.btn-filter {
    background: #2563eb;
    color: white;
}

.btn-reset {
    background: #f1f5f9;
    color: #334155;
}


.filter-form {
    display: grid;
    grid-template-columns: 2fr 1fr auto auto;
    gap: 1rem;
    align-items: end;
}

.bulk-actions {
    margin-bottom: 1rem;
    display: flex;
    gap: 0.75rem;
}

.btn-approve {
    background: #10b981;
    color: white;
    padding: 0.625rem 1.25rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
}

.btn-reject {
    background: #ef4444;
    color: white;
    padding: 0.625rem 1.25rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
}
/* button aksi */
.btn-icon {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    cursor: pointer;
}

.btn-success { background: #dcfce7; color: #166534; }
.btn-warning { background: #fef3c7; color: #92400e; }
.btn-info    { background: #e0f2fe; color: #075985; }
.btn-danger  { background: #fee2e2; color: #991b1b; }


.comment-preview {
    font-size: 0.875rem;
    color: #6b7280;
    line-height: 1.5;
}

.rating-display {
    display: flex;
    gap: 0.125rem;
}

.star-filled {
    color: #fbbf24;
    font-size: 0.875rem;
}

.star-empty {
    color: #d1d5db;
    font-size: 0.875rem;
}
/* table */
.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead {
    background: #f8fafc;
}

.data-table th {
    text-align: left;
    font-size: 0.75rem;
    font-weight: 700;
    color: #475569;
    padding: 0.75rem;
    text-transform: uppercase;
}

.data-table td {
    padding: 0.75rem;
    border-top: 1px solid #e5e7eb;
    vertical-align: top;
    font-size: 0.875rem;
    color: #0f172a;
}
.data-table tbody tr:hover {
    background: #f8fafc;
}

.badge {
    padding: 0.25rem 0.6rem;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 600;
}

.badge-warning {
    background: #fef3c7;
    color: #d97706;
}

.badge-success {
    background: #d1fae5;
    color: #10b981;
}

.badge-danger {
    background: #fee2e2;
    color: #ef4444;
}

.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    z-index: 9999;
    align-items: center;
    justify-content: center;
}

.modal.active {
    display: flex;
}

.modal-content {
    background: white;
    border-radius: 12px;
    width: 90%;
    max-width: 500px;
}

.modal-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    padding: 1.5rem;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
}
</style>
@endpush
@section('content')
<div class="filament-page">
<div class="filament-header">
    <h1>Kelola Komentar Artikel</h1>
    <p>Moderasi komentar dari pembaca artikel</p>
</div>

<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: #dbeafe;">
            <i class="fas fa-comments" style="color: #1e40af;"></i>
        </div>
        <div class="stat-info">
            <span class="stat-label">Total Komentar</span>
            <span class="stat-value">{{ $stats['total'] }}</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: #fef3c7;">
            <i class="fas fa-clock" style="color: #d97706;"></i>
        </div>
        <div class="stat-info">
            <span class="stat-label">Menunggu Moderasi</span>
            <span class="stat-value">{{ $stats['pending'] }}</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: #d1fae5;">
            <i class="fas fa-check-circle" style="color: #10b981;"></i>
        </div>
        <div class="stat-info">
            <span class="stat-label">Disetujui</span>
            <span class="stat-value">{{ $stats['approved'] }}</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: #fee2e2;">
            <i class="fas fa-times-circle" style="color: #ef4444;"></i>
        </div>
        <div class="stat-info">
            <span class="stat-label">Ditolak</span>
            <span class="stat-value">{{ $stats['rejected'] }}</span>
        </div>
    </div>
</div>

<!-- Filter -->
<div class="filter-card">
    <form action="{{ route('admin.comments.index') }}" method="GET" class="filter-form">
        <div class="form-group">
            <label>Cari</label>
            <input type="text" name="search" placeholder="Nama atau komentar..." value="{{ request('search') }}">
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>

        <button type="submit" class="btn-filter">
            <i class="fas fa-search"></i> Filter
        </button>

        <a href="{{ route('admin.comments.index') }}" class="btn-reset">
            <i class="fas fa-redo"></i> Reset
        </a>
    </form>
</div>

<!-- Bulk Actions -->
@if($comments->count() > 0)
<div class="bulk-actions">
    <form id="bulk-form" method="POST">
        @csrf
        <button type="button" onclick="bulkAction('approve')" class="btn-approve">
            <i class="fas fa-check"></i> Setujui Terpilih
        </button>
        <button type="button" onclick="bulkAction('reject')" class="btn-reject">
            <i class="fas fa-times"></i> Tolak Terpilih
        </button>
    </form>
</div>
@endif

<!-- Comments Table -->
<div>
<div class="filament-table">
    @if($comments->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th width="40">
                        <input type="checkbox" id="select-all">
                    </th>
                    <th>Artikel</th>
                    <th>Nama</th>
                    <th>Komentar</th>
                    <th width="100">Rating</th>
                    <th width="120">Status</th>
                    <th width="150">Tanggal</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($comments as $comment)
                    <tr>
                        <td>
                            <input type="checkbox" class="comment-checkbox" value="{{ $comment->id }}">
                        </td>
                        <td>
                            <a href="{{ route('articles.show', $comment->article_id) }}" target="_blank" class="article-link">
                                {{ Str::limit($comment->article->title, 50) }}
                            </a>
                        </td>
                        <td>
                            <strong>{{ $comment->name }}</strong>
                        </td>
                        <td>
                            <div class="comment-preview">
                                {{ Str::limit($comment->comment, 100) }}
                            </div>
                        </td>
                        <td>
                            <div class="rating-display">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $comment->rating)
                                        <i class="fas fa-star star-filled"></i>
                                    @else
                                        <i class="fas fa-star star-empty"></i>
                                    @endif
                                @endfor
                            </div>
                        </td>
                        <td>
                            @if($comment->status == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif($comment->status == 'approved')
                                <span class="badge badge-success">Approved</span>
                            @else
                                <span class="badge badge-danger">Rejected</span>
                            @endif
                        </td>
                        <td>{{ $comment->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <div class="action-buttons">
                                @if($comment->status != 'approved')
                                    <form action="{{ route('admin.comments.approve', $comment->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn-icon btn-success" title="Setujui">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif

                                @if($comment->status != 'rejected')
                                    <button type="button" class="btn-icon btn-warning" onclick="openRejectModal({{ $comment->id }})" title="Tolak">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @endif

                                <button type="button" class="btn-icon btn-info" onclick="viewComment({{ $comment->id }})" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus komentar ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination-wrapper">
            {{ $comments->links() }}
        </div>
    @else
        <div class="stat-card">
            <i class="fas fa-comments"></i>
            <h3>Belum Ada Komentar</h3>
            <p>Komentar dari pembaca akan muncul di sini</p>
        </div>
    @endif
</div>

<!-- Modal Reject -->
<div id="rejectModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Tolak Komentar</h3>
            <button type="button" class="close-modal" onclick="closeRejectModal()">&times;</button>
        </div>
        <form id="rejectForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label>Alasan Penolakan (Opsional)</label>
                    <textarea name="rejection_reason" rows="4" placeholder="Masukkan alasan penolakan..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeRejectModal()">Batal</button>
                <button type="submit" class="btn-danger">Tolak Komentar</button>
            </div>
        </form>
    </div>
</div>
@push('scripts')
  

<script>
// Select All
document.getElementById('select-all')?.addEventListener('change', function() {
    document.querySelectorAll('.comment-checkbox').forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Bulk Action
function bulkAction(action) {
    const checkedIds = Array.from(document.querySelectorAll('.comment-checkbox:checked'))
        .map(cb => cb.value);
    
    if (checkedIds.length === 0) {
        alert('Pilih minimal 1 komentar');
        return;
    }
    
    const form = document.getElementById('bulk-form');
    form.action = action === 'approve' 
        ? '{{ route("admin.comments.bulk-approve") }}'
        : '{{ route("admin.comments.bulk-reject") }}';
    
    // Add hidden inputs
    form.innerHTML = '@csrf';
    checkedIds.forEach(id => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'comment_ids[]';
        input.value = id;
        form.appendChild(input);
    });
    
    form.submit();
}

// Reject Modal
function openRejectModal(id) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    form.action = `/admin/comments/${id}/reject`;
    modal.classList.add('active');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.remove('active');
}
</script>
@endpush
</div>
@endsection