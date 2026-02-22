@extends('layouts.public.app')

@section('title', 'Berikan Review Anda')

@section('content')
<div class="review-form-page">
    <!-- Hero -->
    <section class="review-hero">
        <div class="container">
            <h1><i class="fas fa-star"></i> Berikan Review Anda</h1>
            <p>Bagikan pengalaman Anda dengan layanan kami</p>
        </div>
    </section>

    <!-- Form Section -->
    <section class="form-section">
        <div class="container">
            <div class="form-wrapper">
                <div class="form-card">
                    <h2>Kritik & Saran</h2>
                    <p class="form-intro">Review Anda akan membantu kami meningkatkan kualitas layanan</p>

                    @if($errors->any())
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            <strong>Terdapat kesalahan:</strong>
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    <form action="{{ route('public.reviews.store') }}" method="POST" enctype="multipart/form-data" id="reviewForm">
                        @csrf

                        <!-- Rating -->
                        <div class="form-group rating-group">
                            <label class="required">Berikan Rating Anda</label>
                            <div class="star-rating-input">
                                <input type="radio" name="rating" value="5" id="star5" required>
                                <label for="star5" title="5 bintang - Sangat Puas">
                                    <i class="fas fa-star"></i>
                                </label>
                                
                                <input type="radio" name="rating" value="4" id="star4">
                                <label for="star4" title="4 bintang - Puas">
                                    <i class="fas fa-star"></i>
                                </label>
                                
                                <input type="radio" name="rating" value="3" id="star3">
                                <label for="star3" title="3 bintang - Cukup">
                                    <i class="fas fa-star"></i>
                                </label>
                                
                                <input type="radio" name="rating" value="2" id="star2">
                                <label for="star2" title="2 bintang - Kurang">
                                    <i class="fas fa-star"></i>
                                </label>
                                
                                <input type="radio" name="rating" value="1" id="star1">
                                <label for="star1" title="1 bintang - Sangat Kurang">
                                    <i class="fas fa-star"></i>
                                </label>
                            </div>
                            <div class="rating-label" id="ratingLabel">Pilih rating Anda</div>
                        </div>

                        <!-- Review Text -->
                        <div class="form-group">
                            <label class="required">Ceritakan Pengalaman Anda</label>
                            <textarea name="review_text" 
                                      class="form-control" 
                                      rows="6" 
                                      placeholder="Bagikan pengalaman Anda dengan layanan kami. Apa yang Anda sukai atau yang perlu kami perbaiki?"
                                      required
                                      minlength="10"
                                      maxlength="1000">{{ old('review_text') }}</textarea>
                            <small class="char-counter">Minimal 10 karakter</small>
                        </div>

                        <!-- Nama -->
                        <div class="form-group">
                            <label class="required">Nama Lengkap</label>
                            <input type="text" 
                                   name="reviewer_name" 
                                   class="form-control" 
                                   placeholder="Nama Anda"
                                   required
                                   maxlength="255"
                                   value="{{ old('reviewer_name') }}">
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label>Email (Opsional)</label>
                            <input type="email" 
                                   name="reviewer_email" 
                                   class="form-control" 
                                   placeholder="email@example.com"
                                   value="{{ old('reviewer_email') }}">
                            <small>Email tidak akan ditampilkan di review</small>
                        </div>

                        <!-- Phone -->
                        <div class="form-group">
                            <label>No. Handphone (Opsional)</label>
                            <input type="tel" 
                                   name="reviewer_phone" 
                                   class="form-control" 
                                   placeholder="08123456789"
                                   value="{{ old('reviewer_phone') }}">
                        </div>

                        <!-- Service Type -->
                        <div class="form-group">
                            <label>Layanan yang Direview (Opsional)</label>
                            <select name="service_type" class="form-control">
                                <option value="">Pilih Layanan</option>
                                <option value="Layanan Kesehatan" {{ old('service_type') == 'Layanan Kesehatan' ? 'selected' : '' }}>Layanan Kesehatan</option>
                                <option value="Layanan Farmasi" {{ old('service_type') == 'Layanan Farmasi' ? 'selected' : '' }}>Layanan Farmasi</option>
                                <option value="Layanan Bidan" {{ old('service_type') == 'Layanan Bidan' ? 'selected' : '' }}>Layanan Bidan</option>
                                <option value="Layanan Gizi" {{ old('service_type') == 'Layanan Gizi' ? 'selected' : '' }}>Layanan Gizi</option>
                                <option value="Layanan Umum" {{ old('service_type') == 'Layanan Umum' ? 'selected' : '' }}>Layanan Umum</option>
                            </select>
                        </div>

                        <!-- Photo Upload -->
                        <div class="form-group">
                            <label>Foto Profil (Opsional)</label>
                            <div class="photo-upload">
                                <input type="file" 
                                       name="reviewer_photo" 
                                       id="photoInput" 
                                       accept="image/jpeg,image/png,image/jpg"
                                       class="file-input">
                                <label for="photoInput" class="file-label">
                                    <i class="fas fa-camera"></i>
                                    <span>Pilih Foto</span>
                                </label>
                                <div id="photoPreview" class="photo-preview"></div>
                            </div>
                            <small>Format: JPG, PNG (Max 2MB)</small>
                        </div>

                        <!-- Agreement -->
                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" required>
                                <span>Saya setuju bahwa review ini akan ditampilkan secara publik setelah disetujui oleh admin</span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-paper-plane"></i> Kirim Review
                        </button>
                    </form>
                </div>

                <!-- Info Sidebar -->
                <div class="info-sidebar">
                    <div class="info-card">
                        <i class="fas fa-info-circle"></i>
                        <h3>Panduan Review</h3>
                        <ul>
                            <li>Berikan rating yang jujur</li>
                            <li>Jelaskan pengalaman Anda secara detail</li>
                            <li>Gunakan bahasa yang sopan</li>
                            <li>Review akan ditampilkan setelah disetujui</li>
                        </ul>
                    </div>

                    <div class="info-card">
                        <i class="fas fa-shield-alt"></i>
                        <h3>Privasi Terjaga</h3>
                        <p>Email dan nomor HP Anda tidak akan ditampilkan di review publik.</p>
                    </div>

                    <div class="info-card">
                        <i class="fas fa-clock"></i>
                        <h3>Proses Persetujuan</h3>
                        <p>Review akan ditinjau dalam 1-2 hari kerja sebelum ditampilkan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
.review-form-page {
    background: #f8fafc;
    min-height: 100vh;
}

.review-hero {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    padding: 3rem 0;
    text-align: center;
}

.review-hero h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
}

.review-hero p {
    font-size: 1.125rem;
    opacity: 0.95;
}

.form-section {
    padding: 3rem 0 4rem;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

.form-wrapper {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
    margin-top: -2rem;
}

.form-card {
    background: white;
    padding: 2.5rem;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.form-card h2 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.form-intro {
    color: #64748b;
    margin-bottom: 2rem;
}

.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    display: flex;
    gap: 0.75rem;
}

.alert-error {
    background: #fee2e2;
    border: 2px solid #ef4444;
    color: #991b1b;
}

.alert ul {
    margin: 0.5rem 0 0 0;
    padding-left: 1.5rem;
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
    font-family: inherit;
}

.form-control:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

textarea.form-control {
    resize: vertical;
    min-height: 120px;
}

.form-group small {
    display: block;
    color: #94a3b8;
    font-size: 0.8125rem;
    margin-top: 0.375rem;
}

/* Star Rating Input */
.rating-group {
    text-align: center;
    padding: 1.5rem;
    background: #f8fafc;
    border-radius: 12px;
    margin-bottom: 2rem;
}

.star-rating-input {
    display: flex;
    flex-direction: row-reverse;
    justify-content: center;
    gap: 0.5rem;
    margin: 1rem 0;
}

.star-rating-input input {
    display: none;
}

.star-rating-input label {
    font-size: 3rem;
    color: #cbd5e1;
    cursor: pointer;
    transition: all 0.3s;
    margin: 0;
}

.star-rating-input label:hover,
.star-rating-input label:hover ~ label,
.star-rating-input input:checked ~ label {
    color: #fbbf24;
    transform: scale(1.1);
}

.rating-label {
    font-size: 1.125rem;
    font-weight: 600;
    color: #475569;
    margin-top: 0.75rem;
}

/* Photo Upload */
.photo-upload {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.file-input {
    display: none;
}

.file-label {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: #f1f5f9;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s;
    font-weight: 600;
    color: #475569;
}

.file-label:hover {
    background: #e2e8f0;
    border-color: #3b82f6;
}

.photo-preview {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    overflow: hidden;
    display: none;
}

.photo-preview.active {
    display: block;
}

.photo-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Checkbox */
.checkbox-label {
    display: flex;
    align-items: start;
    gap: 0.75rem;
    cursor: pointer;
    font-weight: 400 !important;
}

.checkbox-label input {
    margin-top: 0.25rem;
    width: 18px;
    height: 18px;
    cursor: pointer;
}

/* Button */
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

/* Info Sidebar */
.info-sidebar {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.info-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.info-card i {
    font-size: 2rem;
    color: #3b82f6;
    margin-bottom: 1rem;
}

.info-card h3 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.75rem;
}

.info-card ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.info-card li {
    padding: 0.5rem 0;
    color: #64748b;
    display: flex;
    gap: 0.5rem;
}

.info-card li::before {
    content: '✓';
    color: #10b981;
    font-weight: 700;
}

.info-card p {
    color: #64748b;
    line-height: 1.6;
    margin: 0;
}

@media (max-width: 1024px) {
    .form-wrapper {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .review-hero h1 {
        font-size: 2rem;
        flex-direction: column;
    }

    .form-card {
        padding: 1.5rem;
    }

    .star-rating-input label {
        font-size: 2.5rem;
    }
}
</style>

<script>
// Star rating label update
document.querySelectorAll('input[name="rating"]').forEach(input => {
    input.addEventListener('change', function() {
        const labels = {
            '5': '⭐⭐⭐⭐⭐ Sangat Puas',
            '4': '⭐⭐⭐⭐ Puas',
            '3': '⭐⭐⭐ Cukup',
            '2': '⭐⭐ Kurang',
            '1': '⭐ Sangat Kurang'
        };
        document.getElementById('ratingLabel').textContent = labels[this.value];
    });
});

// Photo preview
document.getElementById('photoInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('photoPreview');
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            preview.classList.add('active');
        };
        reader.readAsDataURL(file);
    }
});

// Character counter
const textarea = document.querySelector('textarea[name="review_text"]');
const counter = document.querySelector('.char-counter');

textarea.addEventListener('input', function() {
    const length = this.value.length;
    if (length < 10) {
        counter.textContent = `${length}/10 karakter (minimal)`;
        counter.style.color = '#ef4444';
    } else {
        counter.textContent = `${length}/1000 karakter`;
        counter.style.color = '#10b981';
    }
});
</script>

@endsection