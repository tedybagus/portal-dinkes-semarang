@extends('layouts.app')

@section('title', isset($struktur) ? 'Edit Struktur Organisasi' : 'Tambah Struktur Organisasi')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <h1>
            <i class="fas fa-sitemap"></i>
            {{ isset($struktur) ? 'Edit Struktur Organisasi' : 'Tambah Struktur Organisasi' }}
        </h1>
        <p>Formulir struktur organisasi dan bagan</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.struktur-organisasi.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ isset($struktur) ? route('admin.struktur-organisasi.update', $struktur->id) : route('admin.struktur-organisasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($struktur))
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-8">
                    <!-- Title -->
                    <div class="form-group">
                        <label for="title" class="form-label required">Judul Struktur Organisasi</label>
                        <input 
                            type="text" 
                            name="title" 
                            id="title" 
                            class="form-control @error('title') is-invalid @enderror" 
                            placeholder="Contoh: Struktur Organisasi Dinas Kesehatan Kota Semarang"
                            value="{{ old('title', $struktur->title ?? '') }}"
                            maxlength="255"
                            required
                        >
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description" class="form-label">Deskripsi Singkat</label>
                        <textarea 
                            name="description" 
                            id="description" 
                            rows="4" 
                            class="form-control @error('description') is-invalid @enderror" 
                            placeholder="Deskripsi singkat tentang struktur organisasi..."
                        >{{ old('description', $struktur->description ?? '') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">Opsional. Penjelasan singkat tentang struktur organisasi</small>
                    </div>

                    <!-- Content (WYSIWYG) -->
                    <div class="form-group">
                        <label for="content" class="form-label">Konten / Penjelasan Detail</label>
                        <textarea 
                            name="content" 
                            id="content" 
                            class="form-control wysiwyg @error('content') is-invalid @enderror"
                        >{{ old('content', $struktur->content ?? '') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">Opsional. Penjelasan detail tentang struktur, tugas masing-masing bagian, dll</small>
                    </div>

                    <!-- Status Active -->
                    <div class="form-group">
                        <div class="form-check">
                            <input 
                                type="checkbox" 
                                name="is_active" 
                                id="is_active" 
                                class="form-check-input" 
                                value="1"
                                {{ old('is_active', $struktur->is_active ?? true) ? 'checked' : '' }}
                            >
                            <label for="is_active" class="form-check-label">
                                Aktif (tampilkan di halaman publik)
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Upload Bagan Struktur Organisasi -->
                    <div class="form-group">
                        <label for="image" class="form-label required">Bagan Struktur Organisasi</label>
                        
                        <div class="image-preview-container">
                            @if(isset($struktur) && $struktur->image)
                                <img id="image-preview" src="{{ asset('storage/' . $struktur->image) }}" alt="Preview">
                                <div class="image-overlay">
                                    <a href="{{ asset('storage/' . $struktur->image) }}" target="_blank" class="btn-preview">
                                        <i class="fas fa-search-plus"></i> Lihat Bagan
                                    </a>
                                </div>
                            @else
                                <div id="image-preview" class="image-placeholder">
                                    <i class="fas fa-sitemap"></i>
                                    <p>Belum ada bagan</p>
                                </div>
                            @endif
                        </div>

                        <input 
                            type="file" 
                            name="image" 
                            id="image" 
                            class="form-control @error('image') is-invalid @enderror" 
                            accept="image/jpeg,image/png,image/jpg"
                            {{ !isset($struktur) ? 'required' : '' }}
                        >
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">
                            <strong>Format:</strong> JPG, PNG (Max 2MB)<br>
                            <strong>Rekomendasi:</strong> 1200x800 px (landscape)<br>
                            <strong>Tips:</strong> Gunakan tools seperti Canva, draw.io, atau Lucidchart untuk membuat bagan
                        </small>
                    </div>

                    <!-- Info Box -->
                    <div class="info-box">
                        <div class="info-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="info-content">
                            <h4>Tips Membuat Bagan:</h4>
                            <ul>
                                <li>Gunakan warna yang konsisten</li>
                                <li>Pastikan text readable</li>
                                <li>Export dalam resolusi tinggi</li>
                                <li>Simpan sebagai PNG untuk kualitas terbaik</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    {{ isset($struktur) ? 'Update' : 'Simpan' }}
                </button>
                <a href="{{ route('admin.struktur-organisasi.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<style>
.row {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.9375rem;
}

.form-label.required::after {
    content: '*';
    color: #ef4444;
    margin-left: 0.25rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.9375rem;
    transition: all 0.3s;
    font-family: inherit;
}

.form-control:focus {
    outline: none;
    border-color: #1e40af;
    box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
}

.form-control.is-invalid {
    border-color: #ef4444;
}

.invalid-feedback {
    color: #ef4444;
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

.form-text {
    color: #6b7280;
    font-size: 0.875rem;
    margin-top: 0.5rem;
    display: block;
    line-height: 1.5;
}

.form-check {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.form-check-input {
    width: 20px;
    height: 20px;
    cursor: pointer;
}

.form-check-label {
    cursor: pointer;
    color: #374151;
}

textarea.form-control {
    resize: vertical;
    min-height: 100px;
}

/* Image Preview */
.image-preview-container {
    position: relative;
    margin-bottom: 1rem;
    border: 2px dashed #e5e7eb;
    border-radius: 12px;
    padding: 1rem;
    text-align: center;
    background: #f9fafb;
}

.image-preview-container img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    max-height: 400px;
}

.image-overlay {
    margin-top: 0.75rem;
}

.btn-preview {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: #1e40af;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-preview:hover {
    background: #1e3a8a;
}

.image-placeholder {
    padding: 3rem 1rem;
    color: #9ca3af;
}

.image-placeholder i {
    font-size: 4rem;
    margin-bottom: 0.5rem;
}

.image-placeholder p {
    margin: 0;
}

/* Info Box */
.info-box {
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-radius: 8px;
    padding: 1rem;
    margin-top: 1.5rem;
}

.info-icon {
    color: #1e40af;
    font-size: 1.25rem;
    margin-bottom: 0.5rem;
}

.info-content h4 {
    font-size: 0.9375rem;
    font-weight: 700;
    color: #1e40af;
    margin-bottom: 0.5rem;
}

.info-content ul {
    margin: 0;
    padding-left: 1.25rem;
    font-size: 0.875rem;
    color: #1e40af;
}

.info-content li {
    margin-bottom: 0.25rem;
}

.form-actions {
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 2px solid #e5e7eb;
    display: flex;
    gap: 1rem;
}

@media (max-width: 768px) {
    .row {
        grid-template-columns: 1fr;
    }
}
</style>

<!-- CKEditor for Content -->
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize CKEditor
    document.querySelectorAll('textarea.wysiwyg').forEach(function(element) {
        ClassicEditor
            .create(element, {
                toolbar: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'underline',
                    '|',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'link',
                    'blockQuote',
                    '|',
                    'undo',
                    'redo'
                ]
            })
            .then(editor => {
                editor.editing.view.change(writer => {
                    writer.setStyle('min-height', '200px', editor.editing.view.document.getRoot());
                });
            })
            .catch(error => {
                console.error(error);
            });
    });

    // Image preview
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('image-preview');
    
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    if (imagePreview.tagName === 'IMG') {
                        imagePreview.src = e.target.result;
                    } else {
                        const container = imagePreview.parentElement;
                        const newImg = document.createElement('img');
                        newImg.id = 'image-preview';
                        newImg.src = e.target.result;
                        newImg.style.maxWidth = '100%';
                        newImg.style.borderRadius = '8px';
                        newImg.style.maxHeight = '400px';
                        container.replaceChild(newImg, imagePreview);
                    }
                }
                
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endsection