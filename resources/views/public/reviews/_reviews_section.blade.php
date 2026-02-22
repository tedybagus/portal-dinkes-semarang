
<div class="rating-stats-box">
    {{-- Overall Rating --}}
    <div class="overall-rating">
        <div class="rating-number">{{ number_format($averageRating ?? 0, 1) }}</div>
        <div class="rating-stars">
            @for($i = 5; $i >= 1; $i--)
                @if($i <= floor($averageRating ?? 0))
                    <i class="fas fa-star"></i>
                @elseif($i - 0.5 <= ($averageRating ?? 0))
                    <i class="fas fa-star-half-alt"></i>
                @else
                    <i class="far fa-star"></i>
                @endif
            @endfor
        </div>
        <div class="rating-count">{{ $totalReviews ?? 0 }} review</div>
    </div>

    {{-- Rating Distribution --}}
    {{-- <div class="rating-breakdown">
        @php
            $distribution = $ratingDistribution ?? [5=>0, 4=>0, 3=>0, 2=>0, 1=>0];
            $percentages = $ratingPercentages ?? [5=>0, 4=>0, 3=>0, 2=>0, 1=>0];
        @endphp
        
        @foreach($distribution as $star => $count)
        <div class="rating-row">
            <span class="rating-label">{{ $star }} <i class="fas fa-star"></i></span>
            <div class="rating-bar">
                <div class="rating-bar-fill" 
                     style="width: {{ $percentages[$star] ?? 0 }}%; 
                            background: {{ $star >= 4 ? '#10b981' : ($star >= 3 ? '#f59e0b' : '#ef4444') }}">
                </div>
            </div>
            <span class="rating-value">{{ $count }}</span>
        </div>
        @endforeach
    </div> --}}
<div class="rating-breakdown">
    @foreach($ratingDistribution as $star => $count)
        {{-- ✅ SAFETY: Skip jika star bukan 1-5 --}}
        @if($star >= 1 && $star <= 5)
        <div class="rating-row">
            <span class="rating-label">{{ $star }} <i class="fas fa-star"></i></span>
            <div class="rating-bar">
                <div class="rating-bar-fill" 
                     style="width: {{ $ratingPercentages[$star] ?? 0 }}%; 
                            background: {{ $star >= 4 ? '#10b981' : ($star >= 3 ? '#f59e0b' : '#ef4444') }}">
                </div>
            </div>
            <span class="rating-value">{{ $count }}</span>
        </div>
        @endif
    @endforeach
</div>
</div>

<style>
.rating-stats-box {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 2px 8px rgba(0,0,0,.08);
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 2.5rem;
    margin-bottom: 2rem;
}

.overall-rating {
    text-align: center;
    padding: 1.25rem;
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    border-radius: 12px;
}

.rating-number {
    font-size: 4rem;
    font-weight: 900;
    color: #92400e;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.rating-stars {
    font-size: 1.5rem;
    color: #f59e0b;
    margin-bottom: 0.75rem;
}

.rating-stars i {
    margin: 0 0.125rem;
}

.rating-count {
    font-size: 1rem;
    color: #78350f;
    font-weight: 600;
}

.rating-breakdown {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    padding: 0.5rem 0;
}

.rating-row {
    display: grid;
    grid-template-columns: 70px 1fr 70px;
    align-items: center;
    gap: 1rem;
}

.rating-label {
    font-size: 0.9375rem;
    font-weight: 700;
    color: #374151;
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.rating-label i {
    color: #f59e0b;
    font-size: 0.875rem;
}

.rating-bar {
    height: 14px;
    background: #f1f5f9;
    border-radius: 20px;
    overflow: hidden;
    position: relative;
}

.rating-bar-fill {
    height: 100%;
    border-radius: 20px;
    transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.rating-value {
    text-align: right;
    font-weight: 800;
    color: #1e293b;
    font-size: 1rem;
}

@media (max-width: 1024px) {
    .rating-stats-box {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .overall-rating {
        max-width: 280px;
        margin: 0 auto;
    }
}

@media (max-width: 768px) {
    .rating-stats-box {
        padding: 1.5rem;
    }
    
    .rating-number {
        font-size: 3rem;
    }
    
    .rating-row {
        grid-template-columns: 60px 1fr 50px;
        gap: 0.75rem;
    }
}
</style>