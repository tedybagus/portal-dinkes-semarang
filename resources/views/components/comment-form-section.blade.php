<style>
/* Comment Section */
.comment-section {
     max-width: 1280px; 
  
  /* Pastikan margin kiri/kanan tetap auto agar tetap di tengah */
  margin-left: auto;
  margin-right: auto;

  /* Samakan padding agar konten di dalamnya sejajar secara vertikal */
  padding-left: 2rem;
  padding-right: 2rem;
  
  /* Opsional: Sesuaikan margin-top agar konsisten dengan spacing antar section */
  margin-top: 2rem; 
}

.comment-form-container{
    max-width: 826px;
    background: white;
    border-radius: 12px;
    padding-left: 32px;
    padding-right: 32px;
    padding-top: 32px;
    padding-bottom: 32px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    margin-bottom: 2rem;
}
.comments-list-container {
   max-width: 826px;
    background: white;
    border-radius: 12px;
    padding-left: 32px;
    padding-right: 32px;
    padding-top: 32px;
    padding-bottom: 32px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    margin-bottom: 2rem;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.section-title i {
    color: #1e40af;
}

/* Alert */
.alert {
    padding: 1rem 1.25rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.alert-success {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #10b981;
}

.alert-error {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #ef4444;
}

/* Form */
.comment-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-label {
    font-weight: 600;
    color: #374151;
    font-size: 0.9375rem;
}

.required {
    color: #ef4444;
}

.form-input,
.form-textarea {
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.9375rem;
    font-family: 'Inter', sans-serif;
    transition: all 0.3s;
}

.form-input:focus,
.form-textarea:focus {
    outline: none;
    border-color: #1e40af;
    box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
}

.form-input.is-invalid,
.form-textarea.is-invalid {
    border-color: #ef4444;
}

.form-textarea {
    resize: vertical;
    min-height: 120px;
}

.char-counter {
    font-size: 0.875rem;
    color: #6b7280;
    text-align: right;
}

.error-text {
    color: #ef4444;
    font-size: 0.875rem;
}

/* Rating Input */
.rating-input {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    gap: 0.25rem;
}

.rating-input input[type="radio"] {
    display: none;
}

.rating-input label {
    cursor: pointer;
    font-size: 2rem;
    color: #d1d5db;
    transition: all 0.2s;
}

.rating-input label:hover,
.rating-input label:hover ~ label {
    color: #fbbf24;
}

.rating-input input[type="radio"]:checked ~ label {
    color: #fbbf24;
}

.rating-text {
    font-size: 0.875rem;
    color: #6b7280;
    margin-top: -0.5rem;
}

/* Form Info */
.form-info {
    background: #eff6ff;
    padding: 0.875rem 1rem;
    border-radius: 8px;
    font-size: 0.875rem;
    color: #1e40af;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Submit Button */
.btn-submit {
    padding: 0.875rem 2rem;
    background: #1e40af;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    align-self: flex-start;
}

.btn-submit:hover {
    background: #1e3a8a;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
}

/* Comments List */
.comments-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.comment-item {
    padding: 1.5rem;
    background: #f9fafb;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
}

.comment-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.comment-author {
    display: flex;
    gap: 0.75rem;
}

.author-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #1e40af;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.125rem;
}

.author-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.author-name {
    font-weight: 600;
    color: #1f2937;
}

.comment-date {
    font-size: 0.875rem;
    color: #6b7280;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.comment-rating {
    display: flex;
    gap: 0.25rem;
}

.star-filled {
    color: #fbbf24;
    font-size: 0.875rem;
}

.star-empty {
    color: #d1d5db;
    font-size: 0.875rem;
}

.comment-body p {
    color: #374151;
    line-height: 1.7;
    margin: 0;
}

/* No Comments */
.no-comments {
    text-align: center;
    padding: 3rem 2rem;
    color: #6b7280;
}

/* Responsive */
@media (max-width: 768px) {
    .comment-section {
        padding: 0 1rem;
    }

    .comment-form-container,
    .comments-list-container {
        padding: 1.5rem;
    }

    .section-title {
        font-size: 1.25rem;
    }

    .comment-header {
        flex-direction: column;
        gap: 0.75rem;
    }

    .rating-input label {
        font-size: 1.75rem;
    }
}
</style>
<!-- Comment Form Section -->
<div class="comment-section">
    <div class="comment-form-container">
        <h3 class="section-title">
            <i class="fas fa-comments"></i>
            Berikan Komentar & Rating
        </h3>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('articles.comments.store', $article->id) }}" method="POST" class="comment-form">
            @csrf
            
            <!-- Rating -->
            <div class="form-group">
                <label class="form-label">Rating Artikel <span class="required">*</span></label>
                <div class="rating-input">
                    <input type="radio" name="rating" value="5" id="star5" {{ old('rating') == 5 ? 'checked' : '' }} required>
                    <label for="star5" title="5 bintang"><i class="fas fa-star"></i></label>
                    
                    <input type="radio" name="rating" value="4" id="star4" {{ old('rating') == 4 ? 'checked' : '' }}>
                    <label for="star4" title="4 bintang"><i class="fas fa-star"></i></label>
                    
                    <input type="radio" name="rating" value="3" id="star3" {{ old('rating') == 3 ? 'checked' : '' }}>
                    <label for="star3" title="3 bintang"><i class="fas fa-star"></i></label>
                    
                    <input type="radio" name="rating" value="2" id="star2" {{ old('rating') == 2 ? 'checked' : '' }}>
                    <label for="star2" title="2 bintang"><i class="fas fa-star"></i></label>
                    
                    <input type="radio" name="rating" value="1" id="star1" {{ old('rating') == 1 ? 'checked' : '' }}>
                    <label for="star1" title="1 bintang"><i class="fas fa-star"></i></label>
                </div>
                <span class="rating-text">Pilih rating Anda</span>
                @error('rating')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Nama -->
            <div class="form-group">
                <label for="name" class="form-label">Nama Anda <span class="required">*</span></label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-input @error('name') is-invalid @enderror" 
                    placeholder="Masukkan nama Anda"
                    value="{{ old('name') }}"
                    maxlength="100"
                    required
                >
                @error('name')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Komentar -->
            <div class="form-group">
                <label for="comment" class="form-label">Komentar Anda <span class="required">*</span></label>
                <textarea 
                    id="comment" 
                    name="comment" 
                    class="form-textarea @error('comment') is-invalid @enderror" 
                    rows="5" 
                    placeholder="Tulis komentar Anda tentang artikel ini (minimal 10 karakter)"
                    maxlength="1000"
                    required
                >{{ old('comment') }}</textarea>
                <div class="char-counter">
                    <span id="char-count">0</span> / 1000 karakter
                </div>
                @error('comment')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Info -->
            <div class="form-info">
                <i class="fas fa-info-circle"></i>
                Komentar Anda akan ditinjau terlebih dahulu sebelum dipublikasikan.
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-submit">
                <i class="fas fa-paper-plane"></i>
                Kirim Komentar
            </button>
        </form>
    </div>

    <!-- Approved Comments List -->
    <div class="comments-list-container">
        <h3 class="section-title">
            <i class="fas fa-comment-dots"></i>
            Komentar Pembaca ({{ $approvedComments->count() }})
        </h3>

        @if($approvedComments->count() > 0)
            <div class="comments-list">
                @foreach($approvedComments as $comment)
                    <div class="comment-item">
                        <div class="comment-header">
                            <div class="comment-author">
                                <div class="author-avatar">
                                    {{ strtoupper(substr($comment->name, 0, 1)) }}
                                </div>
                                <div class="author-info">
                                    <span class="author-name">{{ $comment->name }}</span>
                                    <span class="comment-date">
                                        <i class="fas fa-clock"></i>
                                        {{ $comment->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            <div class="comment-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $comment->rating)
                                        <i class="fas fa-star star-filled"></i>
                                    @else
                                        <i class="fas fa-star star-empty"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <div class="comment-body">
                            <p>{{ $comment->comment }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-comments">
                <i class="fas fa-comments" style="font-size: 3rem; color: #d1d5db; margin-bottom: 1rem;"></i>
                <p>Belum ada komentar. Jadilah yang pertama berkomentar!</p>
            </div>
        @endif
    </div>
</div>
<script>
// Character counter
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('comment');
    const charCount = document.getElementById('char-count');
    
    if (textarea && charCount) {
        textarea.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });
        
        // Set initial count
        charCount.textContent = textarea.value.length;
    }
});
</script>