@extends('layouts.app')

@section('title', 'Kelola Review')

@section('content')
<div class="admin-reviews-page">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1><i class="fas fa-star"></i> Kelola Review & Kritik Saran</h1>
            <p class="subtitle">Moderasi dan kelola semua review dari masyarakat</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('public.reviews.create') }}" class="btn btn-primary" target="_blank">
                <i class="fas fa-eye"></i> Lihat Form Public
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-container">
        <div class="stat-card stat-total">
            <div class="stat-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Total Review</span>
                <span class="stat-value">{{ $stats['total'] }}</span>
            </div>
        </div>

        <div class="stat-card stat-pending">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Menunggu Persetujuan</span>
                <span class="stat-value">{{ $stats['pending'] }}</span>
            </div>
        </div>

        <div class="stat-card stat-approved">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Disetujui</span>
                <span class="stat-value">{{ $stats['approved'] }}</span>
            </div>
        </div>

        <div class="stat-card stat-rejected">
            <div class="stat-icon">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Ditolak</span>
                <span class="stat-value">{{ $stats['rejected'] }}</span>
            </div>
        </div>

        <div class="stat-card stat-rating">
            <div class="stat-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Rating Rata-rata</span>
                <span class="stat-value">
                    {{ number_format($stats['average_rating'], 1) }}
                    <small>/5</small>
                </span>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="filters-card">
        <form action="{{ route('admin.reviews.index') }}" method="GET" id="filterForm">
            <div class="filters-row">
                <div class="filter-col">
                    <label>Status</label>
                    <select name="status" class="form-control" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                            Menunggu Persetujuan
                        </option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                            Disetujui
                        </option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                            Ditolak
                        </option>
                    </select>
                </div>

                <div class="filter-col">
                    <label>Rating</label>
                    <select name="rating" class="form-control" onchange="this.form.submit()">
                        <option value="">Semua Rating</option>
                        <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5)</option>
                        <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ (4)</option>
                        <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>⭐⭐⭐ (3)</option>
                        <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>⭐⭐ (2)</option>
                        <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>⭐ (1)</option>
                    </select>
                </div>

                <div class="filter-col filter-search">
                    <label>Cari Review</label>
                    <div class="search-group">
                        <input type="text" 
                               name="search" 
                               class="form-control" 
                               placeholder="Cari nama atau isi review..."
                               value="{{ request('search') }}">
                        <button type="submit" class="btn btn-search">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                @if(request()->hasAny(['status', 'rating', 'search']))
                <div class="filter-col">
                    <label>&nbsp;</label>
                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-clear">
                        <i class="fas fa-times"></i> Reset Filter
                    </a>
                </div>
                @endif
            </div>
        </form>

        <!-- Bulk Actions Bar -->
        <div class="bulk-actions-bar">
            <div class="bulk-select">
                <input type="checkbox" id="selectAll" onchange="toggleAllReviews(this)">
                <label for="selectAll">Pilih Semua</label>
            </div>
            
            <div class="bulk-buttons">
                <button type="button" onclick="bulkApprove()" class="btn btn-success" id="btnBulkApprove" disabled>
                    <i class="fas fa-check"></i> Setujui Terpilih
                </button>
                <button type="button" onclick="bulkDelete()" class="btn btn-danger" id="btnBulkDelete" disabled>
                    <i class="fas fa-trash"></i> Hapus Terpilih
                </button>
            </div>

            <span class="selected-info" id="selectedInfo">0 review dipilih</span>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="alert-close">&times;</button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <span>{{ session('error') }}</span>
        <button onclick="this.parentElement.remove()" class="alert-close">&times;</button>
    </div>
    @endif

    <!-- Reviews Grid -->
    @if($reviews->count() > 0)
    <div class="reviews-grid" id="reviewsGrid">
        @foreach($reviews as $review)
            @include('admin.reviews._review_card', ['review' => $review])
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="pagination-container">
        <div class="pagination-info">
            Menampilkan {{ $reviews->firstItem() }} - {{ $reviews->lastItem() }} dari {{ $reviews->total() }} review
        </div>
        <div class="pagination-links">
            {{ $reviews->appends(request()->query())->links() }}
        </div>
    </div>
    @else
    <!-- Empty State -->
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-inbox"></i>
        </div>
        <h3>Tidak Ada Review</h3>
        <p>
            @if(request()->hasAny(['status', 'rating', 'search']))
                Tidak ada review yang sesuai dengan filter Anda.<br>
                <a href="{{ route('admin.reviews.index') }}">Reset filter</a> untuk melihat semua review.
            @else
                Belum ada review yang masuk dari masyarakat.
            @endif
        </p>
    </div>
    @endif
</div>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.admin-reviews-page {
    padding: 2rem;
    background: #f8fafc;
    min-height: 100vh;
}

/* Page Header */
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
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.5rem;
}

.page-header h1 i {
    color: #fbbf24;
}

.subtitle {
    color: #64748b;
    font-size: 1rem;
}

.header-actions .btn {
    padding: 0.75rem 1.5rem;
}

/* Stats Container */
.stats-container {
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
    gap: 1.25rem;
    transition: all 0.3s;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    flex-shrink: 0;
}

.stat-total .stat-icon { background: #dbeafe; color: #3b82f6; }
.stat-pending .stat-icon { background: #fef3c7; color: #f59e0b; }
.stat-approved .stat-icon { background: #d1fae5; color: #10b981; }
.stat-rejected .stat-icon { background: #fee2e2; color: #ef4444; }
.stat-rating .stat-icon { 
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: white;
}

.stat-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.stat-label {
    font-size: 0.875rem;
    color: #64748b;
    font-weight: 500;
}

.stat-value {
    font-size: 2rem;
    font-weight: 800;
    color: #1e293b;
    line-height: 1;
}

.stat-value small {
    font-size: 1rem;
    font-weight: 600;
    color: #64748b;
}

/* Filters Card */
.filters-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
}

.filters-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.25rem;
    margin-bottom: 1.5rem;
}

.filter-col label {
    display: block;
    font-weight: 600;
    color: #334155;
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
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

.filter-search {
    grid-column: span 2;
}

.search-group {
    display: flex;
    gap: 0.5rem;
}

.btn {
    padding: 0.75rem 1.25rem;
    border-radius: 8px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9375rem;
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
}

.btn-search {
    padding: 0.75rem 1.5rem;
    background: #3b82f6;
    color: white;
}

.btn-search:hover {
    background: #2563eb;
}

.btn-clear {
    background: #f1f5f9;
    color: #475569;
    width: 100%;
    justify-content: center;
}

.btn-clear:hover {
    background: #e2e8f0;
}

.btn-success {
    background: #10b981;
    color: white;
}

.btn-success:hover:not(:disabled) {
    background: #059669;
}

.btn-danger {
    background: #ef4444;
    color: white;
}

.btn-danger:hover:not(:disabled) {
    background: #dc2626;
}

.btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Bulk Actions Bar */
.bulk-actions-bar {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding-top: 1.25rem;
    border-top: 2px solid #f1f5f9;
}

.bulk-select {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.bulk-select input[type="checkbox"] {
    width: 18px;
    height: 18px;
    cursor: pointer;
}

.bulk-select label {
    font-weight: 600;
    color: #334155;
    cursor: pointer;
    margin: 0;
}

.bulk-buttons {
    display: flex;
    gap: 0.75rem;
}

.selected-info {
    margin-left: auto;
    color: #64748b;
    font-weight: 600;
}

/* Alert */
.alert {
    padding: 1rem 1.25rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    position: relative;
}

.alert-success {
    background: #d1fae5;
    color: #065f46;
    border: 2px solid #10b981;
}

.alert-error {
    background: #fee2e2;
    color: #991b1b;
    border: 2px solid #ef4444;
}

.alert-close {
    margin-left: auto;
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: inherit;
    opacity: 0.7;
}

.alert-close:hover {
    opacity: 1;
}

/* Reviews Grid */
.reviews-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

/* Pagination */
.pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: white;
    padding: 1.25rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.pagination-info {
    color: #64748b;
    font-weight: 500;
}

.pagination-links {
    display: flex;
    gap: 0.5rem;
}

/* Empty State */
.empty-state {
    background: white;
    padding: 4rem 2rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    text-align: center;
}

.empty-icon {
    font-size: 5rem;
    color: #cbd5e1;
    margin-bottom: 1.5rem;
}

.empty-state h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.75rem;
}

.empty-state p {
    color: #64748b;
    line-height: 1.7;
}

.empty-state a {
    color: #3b82f6;
    font-weight: 600;
}

@media (max-width: 768px) {
    .admin-reviews-page {
        padding: 1rem;
    }

    .page-header {
        flex-direction: column;
        gap: 1rem;
    }

    .stats-container {
        grid-template-columns: 1fr;
    }

    .filters-row {
        grid-template-columns: 1fr;
    }

    .filter-search {
        grid-column: span 1;
    }

    .reviews-grid {
        grid-template-columns: 1fr;
    }

    .bulk-actions-bar {
        flex-wrap: wrap;
    }

    .pagination-container {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>

<script>
let selectedReviews = new Set();

function toggleAllReviews(checkbox) {
    const checkboxes = document.querySelectorAll('.review-select');
    checkboxes.forEach(cb => {
        cb.checked = checkbox.checked;
        if (checkbox.checked) {
            selectedReviews.add(parseInt(cb.dataset.reviewId));
        } else {
            selectedReviews.delete(parseInt(cb.dataset.reviewId));
        }
    });
    updateBulkActions();
}

function toggleReview(reviewId, checkbox) {
    if (checkbox.checked) {
        selectedReviews.add(reviewId);
    } else {
        selectedReviews.delete(reviewId);
    }
    updateBulkActions();
}

function updateBulkActions() {
    const count = selectedReviews.size;
    document.getElementById('selectedInfo').textContent = `${count} review dipilih`;
    document.getElementById('btnBulkApprove').disabled = count === 0;
    document.getElementById('btnBulkDelete').disabled = count === 0;
    
    // Update "select all" checkbox
    const totalCheckboxes = document.querySelectorAll('.review-select').length;
    const selectAllCheckbox = document.getElementById('selectAll');
    if (selectAllCheckbox) {
        selectAllCheckbox.checked = count === totalCheckboxes && count > 0;
    }
}

function bulkApprove() {
    if (selectedReviews.size === 0) return;
    
    if (!confirm(`Setujui ${selectedReviews.size} review terpilih?`)) return;
    
    submitBulkAction('{{ route("admin.reviews.bulk-approve") }}');
}

function bulkDelete() {
    if (selectedReviews.size === 0) return;
    
    if (!confirm(`Hapus ${selectedReviews.size} review terpilih? Tindakan ini tidak dapat dibatalkan!`)) return;
    
    submitBulkAction('{{ route("admin.reviews.bulk-delete") }}');
}

function submitBulkAction(url) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = url;
    
    const csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = '{{ csrf_token() }}';
    form.appendChild(csrf);
    
    selectedReviews.forEach(id => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'ids[]';
        input.value = id;
        form.appendChild(input);
    });
    
    document.body.appendChild(form);
    form.submit();
}

// Auto-hide alerts after 5 seconds
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(alert => {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    });
}, 5000);
</script>

@endsection