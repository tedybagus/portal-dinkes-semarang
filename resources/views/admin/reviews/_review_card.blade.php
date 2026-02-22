{{--
    REUSABLE REVIEW CARD COMPONENT
    Usage: @include('admin.reviews._review_card', ['review' => $review])
--}}

<div class="review-card">
    <!-- Selection Checkbox -->
    <div class="card-checkbox">
        <input type="checkbox" 
               class="review-select" 
               data-review-id="{{ $review->id }}"
               onchange="toggleReview({{ $review->id }}, this)">
    </div>

    <!-- Card Header -->
    <div class="card-header">
        <div class="reviewer-profile">
            <div class="profile-avatar">
                @if($review->reviewer_photo)
                <img src="{{ $review->reviewer_photo_url }}" alt="{{ $review->reviewer_name }}">
                @else
                <span class="avatar-text">{{ $review->reviewer_initials }}</span>
                @endif
            </div>
            <div class="profile-info">
                <h3 class="reviewer-name">{{ $review->reviewer_name }}</h3>
                <div class="reviewer-contact">
                    @if($review->reviewer_email)
                    <span><i class="fas fa-envelope"></i> {{ $review->reviewer_email }}</span>
                    @endif
                    @if($review->reviewer_phone)
                    <span><i class="fas fa-phone"></i> {{ $review->reviewer_phone }}</span>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Status Badge -->
        <span class="status-badge status-{{ $review->status }}">
            @if($review->status === 'pending')
            <i class="fas fa-clock"></i> Menunggu
            @elseif($review->status === 'approved')
            <i class="fas fa-check-circle"></i> Disetujui
            @else
            <i class="fas fa-times-circle"></i> Ditolak
            @endif
        </span>
    </div>

    <!-- Rating Stars -->
    <div class="rating-display">
        @for($i = 1; $i <= 5; $i++)
        <i class="fas fa-star {{ $i <= $review->rating ? 'star-filled' : 'star-empty' }}"></i>
        @endfor
        <span class="rating-text">({{ $review->rating }}/5)</span>
    </div>

    <!-- Service Tag -->
    @if($review->service_type)
    <div class="service-badge">
        <i class="fas fa-tag"></i> {{ $review->service_type }}
    </div>
    @endif

    <!-- Review Content -->
    <div class="review-content">
        <p>{{ $review->review_text }}</p>
    </div>

    <!-- Review Meta -->
    <div class="review-meta">
        <span class="meta-item">
            <i class="fas fa-calendar"></i>
            {{ $review->created_at->format('d M Y') }}
        </span>
        <span class="meta-item">
            <i class="fas fa-clock"></i>
            {{ $review->time_ago }}
        </span>
        @if($review->ip_address)
        <span class="meta-item">
            <i class="fas fa-globe"></i>
            {{ $review->ip_address }}
        </span>
        @endif
    </div>

    <!-- Approval Info -->
    @if($review->status === 'approved' && $review->approved_at)
    <div class="approval-info">
        <i class="fas fa-user-check"></i>
        Disetujui oleh <strong>{{ $review->approved_by }}</strong> pada {{ $review->approved_at->format('d M Y, H:i') }}
    </div>
    @endif

    <!-- Action Buttons -->
    <div class="card-actions">
        @if($review->status === 'pending')
        <!-- Approve -->
        <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="action-btn btn-approve" onclick="return confirm('Setujui review ini?')">
                <i class="fas fa-check"></i> Setujui
            </button>
        </form>

        <!-- Reject -->
        <form action="{{ route('admin.reviews.reject', $review->id) }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="action-btn btn-reject" onclick="return confirm('Tolak review ini?')">
                <i class="fas fa-times"></i> Tolak
            </button>
        </form>
        @endif

        @if($review->status === 'rejected')
        <!-- Re-approve -->
        <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="action-btn btn-approve" onclick="return confirm('Setujui review ini?')">
                <i class="fas fa-check"></i> Setujui
            </button>
        </form>
        @endif

        @if($review->status === 'approved')
        <!-- Unapprove -->
        <form action="{{ route('admin.reviews.reject', $review->id) }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="action-btn btn-secondary" onclick="return confirm('Batalkan persetujuan?')">
                <i class="fas fa-undo"></i> Batalkan
            </button>
        </form>
        @endif

        <!-- Delete -->
        <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="action-btn btn-delete" onclick="return confirm('Hapus review ini secara permanen?\n\nTindakan ini tidak dapat dibatalkan!')">
                <i class="fas fa-trash"></i> Hapus
            </button>
        </form>
    </div>
</div>

<style>
.review-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s;
    border: 2px solid transparent;
    position: relative;
}

.review-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    border-color: #3b82f6;
}

/* Checkbox */
.card-checkbox {
    position: absolute;
    top: 1rem;
    left: 1rem;
}

.review-select {
    width: 20px;
    height: 20px;
    cursor: pointer;
    accent-color: #3b82f6;
}

/* Card Header */
.card-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 1.25rem;
    margin-left: 2rem;
}

.reviewer-profile {
    display: flex;
    gap: 1rem;
    flex: 1;
}

.profile-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
}

.profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-text {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.125rem;
    font-weight: 700;
}

.profile-info {
    flex: 1;
}

.reviewer-name {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.reviewer-contact {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    font-size: 0.8125rem;
    color: #64748b;
}

.reviewer-contact i {
    width: 16px;
}

/* Status Badge */
.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.875rem;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.status-pending {
    background: #fef3c7;
    color: #92400e;
}

.status-approved {
    background: #d1fae5;
    color: #065f46;
}

.status-rejected {
    background: #fee2e2;
    color: #991b1b;
}

/* Rating */
.rating-display {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    font-size: 1.25rem;
}

.star-filled {
    color: #fbbf24;
}

.star-empty {
    color: #e5e7eb;
}

.rating-text {
    font-size: 0.9375rem;
    font-weight: 600;
    color: #64748b;
    margin-left: 0.25rem;
}

/* Service Badge */
.service-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: #eff6ff;
    color: #3b82f6;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

/* Review Content */
.review-content {
    background: #f8fafc;
    padding: 1.25rem;
    border-radius: 8px;
    border-left: 4px solid #3b82f6;
    margin-bottom: 1rem;
}

.review-content p {
    color: #475569;
    line-height: 1.7;
    margin: 0;
}

/* Review Meta */
.review-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1.25rem;
    padding: 1rem 0;
    border-top: 1px solid #f1f5f9;
    border-bottom: 1px solid #f1f5f9;
    margin-bottom: 1rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8125rem;
    color: #64748b;
}

.meta-item i {
    color: #94a3b8;
}

/* Approval Info */
.approval-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    background: #d1fae5;
    color: #065f46;
    border-radius: 6px;
    font-size: 0.875rem;
    margin-bottom: 1rem;
}

.approval-info i {
    color: #10b981;
}

/* Action Buttons */
.card-actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.action-btn {
    padding: 0.625rem 1.25rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.875rem;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-approve {
    background: #10b981;
    color: white;
}

.btn-approve:hover {
    background: #059669;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
}

.btn-reject {
    background: #ef4444;
    color: white;
}

.btn-reject:hover {
    background: #dc2626;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3);
}

.btn-secondary {
    background: #f1f5f9;
    color: #475569;
}

.btn-secondary:hover {
    background: #e2e8f0;
}

.btn-delete {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

.btn-delete:hover {
    background: #fecaca;
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .card-header {
        flex-direction: column;
        gap: 1rem;
    }

    .status-badge {
        align-self: flex-start;
    }

    .card-actions {
        flex-direction: column;
    }

    .action-btn {
        width: 100%;
        justify-content: center;
    }
}
</style>