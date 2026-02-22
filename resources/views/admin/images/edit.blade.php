@extends('layouts.app')

@section('title', isset($image) ? 'Edit Gambar' : 'Upload Gambar')

@push('styles')
<style>
    body {
        background-color: #f9fafb;
    }
    
    .filament-page {
        padding: 1.5rem;
    }
    
    .filament-header {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
    }
    
    .filament-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }
    
    .filament-subtitle {
        color: #6b7280;
        margin: 0;
        font-size: 0.875rem;
    }
    
    .filament-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .filament-card-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .filament-card-title {
        font-size: 1.125rem;
        font-weight: 600;
        margin: 0;
    }
    
    .filament-card-body {
        padding: 1.5rem;
    }
    
    .filament-form-label {
        font-weight: 600;
        color: #374151;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
        display: block;
    }
    
    .required-field::after {
        content: ' *';
        color: #ef4444;
    }
    
    .filament-input, .filament-select, .filament-textarea {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 0.625rem 1rem;
        font-size: 0.875rem;
        transition: all 0.2s;
        width: 100%;
    }
    
    .filament-input:focus, .filament-select:focus, .filament-textarea:focus {
        background: white;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }
    
    .filament-input.is-invalid, .filament-select.is-invalid, .filament-textarea.is-invalid {
        border-color: #ef4444;
    }
    
    .filament-help-text {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }
    
    .filament-textarea {
        min-height: 100px;
        resize: vertical;
    }
    
    .filament-checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .filament-checkbox {
        width: 1.125rem;
        height: 1.125rem;
        cursor: pointer;
        accent-color: #667eea;
    }
    
    .filament-button {
        padding: 0.625rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }
    
    .filament-button-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .filament-button-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }
    
    .filament-button-secondary {
        background: #f3f4f6;
        color: #374151;
    }
    
    .filament-button-secondary:hover {
        background: #e5e7eb;
        color: #374151;
    }
    
    .filament-card-footer {
        padding: 1.5rem;
        border-top: 1px solid #e5e7eb;
        background: #f9fafb;
        display: flex;
        gap: 0.75rem;
    }
    
    /* File Upload Dropzone */
    .file-upload-wrapper {
        border: 2px dashed #e5e7eb;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s;
        background: #f9fafb;
        cursor: pointer;
        position: relative;
    }
    
    .file-upload-wrapper:hover {
        border-color: #667eea;
        background: white;
    }
    
    .file-upload-wrapper.dragover {
        border-color: #667eea;
        background: #eff6ff;
    }
    
    .file-upload-icon {
        font-size: 3rem;
        color: #9ca3af;
        margin-bottom: 1rem;
    }
    
    .file-upload-text {
        font-size: 0.875rem;
        color: #6b7280;
        margin-bottom: 0.5rem;
    }
    
    .file-upload-hint {
        font-size: 0.75rem;
        color: #9ca3af;
    }
    
    .file-upload-input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
    
    .image-preview-wrapper {
        margin-top: 1rem;
        display: none;
    }
    
    .image-preview-wrapper.show {
        display: block;
    }
    
    .image-preview {
        max-width: 100%;
        max-height: 400px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    .image-info {
        margin-top: 0.5rem;
        padding: 0.75rem;
        background: #f9fafb;
        border-radius: 8px;
        font-size: 0.75rem;
        color: #6b7280;
    }
    
    .image-info-item {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        margin-right: 1rem;
    }
</style>
@endpush

@section('content')
<div class="filament-page">
    <div class="container-fluid">
        {{-- Back Button --}}
        <div class="mb-3">
            <a href="{{ route('admin.images.index') }}" class="filament-button filament-button-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        {{-- Header --}}
        <div class="filament-header">
            <div>
                <h1 class="filament-title">{{ isset($image) ? 'Edit Gambar' : 'Upload Gambar' }}</h1>
                <p class="filament-subtitle">{{ isset($image) ? 'Ubah informasi gambar' : 'Upload gambar baru untuk galeri, hero, atau banner' }}</p>
            </div>
        </div>

        {{-- Error Alert --}}
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; border-left: 4px solid #ef4444;">
            <strong><i class="fas fa-exclamation-triangle mr-2"></i> Terjadi Kesalahan!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
        @endif

        {{-- Form Card --}}
        <div class="filament-card">
            <div class="filament-card-header">
                <h3 class="filament-card-title">
                    <i class="fas fa-image mr-2"></i> {{ isset($image) ? 'Form Edit Gambar' : 'Form Upload Gambar' }}
                </h3>
            </div>

            <form action="{{ isset($image) ? route('admin.images.update', $image->id) : route('admin.images.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  id="imageForm">
                @csrf
                @if(isset($image))
                    @method('PUT')
                @endif
                
                <div class="filament-card-body">
                    <div class="row">
                        {{-- Image Upload --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="filament-form-label {{ isset($image) ? '' : 'required-field' }}">
                                    Gambar {{ isset($image) ? '(kosongkan jika tidak diubah)' : '' }}
                                </label>
                                
                                <div class="file-upload-wrapper" id="fileUploadWrapper">
                                    <input type="file" 
                                           name="image" 
                                           id="imageInput"
                                           class="file-upload-input @error('image') is-invalid @enderror" 
                                           accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
                                           {{ isset($image) ? '' : 'required' }}>
                                    <div class="file-upload-icon">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                    </div>
                                    <div class="file-upload-text">
                                        <strong>Klik atau drag & drop gambar di sini</strong>
                                    </div>
                                    <div class="file-upload-hint">
                                        Format: JPEG, PNG, GIF, WEBP | Maksimal: 5MB
                                    </div>
                                </div>

                                @error('image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror

                                <div class="image-preview-wrapper" id="imagePreviewWrapper">
                                    <img id="imagePreview" src="" alt="Preview" class="image-preview">
                                    <div class="image-info">
                                        <span class="image-info-item">
                                            <i class="fas fa-file"></i>
                                            <span id="imageName"></span>
                                        </span>
                                        <span class="image-info-item">
                                            <i class="fas fa-weight"></i>
                                            <span id="imageSize"></span>
                                        </span>
                                        <span class="image-info-item">
                                            <i class="fas fa-ruler-combined"></i>
                                            <span id="imageDimensions"></span>
                                        </span>
                                    </div>
                                </div>

                                @if(isset($image))
                                <div class="mt-3">
                                    <p class="filament-form-label">Gambar Saat Ini:</p>
                                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                                         alt="{{ $image->title }}" 
                                         style="max-width: 300px; border-radius: 8px; border: 1px solid #e5e7eb;">
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Title --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="filament-form-label required-field">Judul Gambar</label>
                                <input type="text" 
                                       name="title" 
                                       class="filament-input @error('title') is-invalid @enderror" 
                                       value="{{ old('title', $image->title ?? '') }}"
                                       placeholder="Masukkan judul gambar"
                                       required>
                                @error('title')
                                    <small class="text-danger">{{ $message }}</small>
                                @else
                                    <small class="filament-help-text">
                                        <i class="fas fa-info-circle"></i> Judul gambar untuk ditampilkan
                                    </small>
                                @enderror
                            </div>
                        </div>

                        {{-- Alt Text --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="filament-form-label">Alt Text</label>
                                <input type="text" 
                                       name="alt_text" 
                                       class="filament-input @error('alt_text') is-invalid @enderror" 
                                       value="{{ old('alt_text', $image->alt_text ?? '') }}"
                                       placeholder="Teks alternatif untuk SEO">
                                @error('alt_text')
                                    <small class="text-danger">{{ $message }}</small>
                                @else
                                    <small class="filament-help-text">
                                        <i class="fas fa-search"></i> Untuk SEO dan aksesibilitas (opsional)
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        <label class="filament-form-label">Deskripsi</label>
                        <textarea name="description" 
                                  class="filament-textarea @error('description') is-invalid @enderror" 
                                  placeholder="Deskripsi gambar (opsional)">{{ old('description', $image->description ?? '') }}</textarea>
                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="row">
                        {{-- Type --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="filament-form-label required-field">Tipe Gambar</label>
                                <select name="type" class="filament-select @error('type') is-invalid @enderror" required>
                                    <option value="">-- Pilih Tipe --</option>
                                    <option value="gallery" {{ old('type', $image->type ?? '') == 'gallery' ? 'selected' : '' }}>
                                        Gallery (Galeri Website)
                                    </option>
                                    <option value="hero" {{ old('type', $image->type ?? '') == 'hero' ? 'selected' : '' }}>
                                        Hero (Header Utama)
                                    </option>
                                    <option value="banner" {{ old('type', $image->type ?? '') == 'banner' ? 'selected' : '' }}>
                                        Banner (Banner Website)
                                    </option>
                                </select>
                                @error('type')
                                    <small class="text-danger">{{ $message }}</small>
                                @else
                                    <small class="filament-help-text">
                                        <i class="fas fa-layer-group"></i> Tentukan di mana gambar akan ditampilkan
                                    </small>
                                @enderror
                            </div>
                        </div>

                        {{-- Order --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="filament-form-label">Urutan</label>
                                <input type="number" 
                                       name="order" 
                                       class="filament-input @error('order') is-invalid @enderror" 
                                       value="{{ old('order', $image->order ?? 0) }}"
                                       min="0"
                                       placeholder="0">
                                @error('order')
                                    <small class="text-danger">{{ $message }}</small>
                                @else
                                    <small class="filament-help-text">
                                        <i class="fas fa-sort-numeric-up"></i> Urutan tampilan (semakin kecil semakin awal)
                                    </small>
                                @enderror
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="filament-form-label">Status</label>
                                <div class="filament-checkbox-wrapper" style="margin-top: 0.625rem;">
                                    <input type="checkbox" 
                                           name="is_active" 
                                           id="is_active"
                                           class="filament-checkbox" 
                                           value="1"
                                           {{ old('is_active', $image->is_active ?? true) ? 'checked' : '' }}>
                                    <label for="is_active" class="filament-form-label mb-0">
                                        Gambar Aktif
                                    </label>
                                </div>
                                <small class="filament-help-text">
                                    <i class="fas fa-eye"></i> Gambar tidak aktif tidak akan ditampilkan
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="filament-card-footer">
                    <button type="submit" class="filament-button filament-button-primary">
                        <i class="fas fa-save"></i> {{ isset($image) ? 'Update Gambar' : 'Upload Gambar' }}
                    </button>
                    <a href="{{ route('admin.images.index') }}" class="filament-button filament-button-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// File upload preview
const imageInput = document.getElementById('imageInput');
const fileUploadWrapper = document.getElementById('fileUploadWrapper');
const imagePreviewWrapper = document.getElementById('imagePreviewWrapper');
const imagePreview = document.getElementById('imagePreview');
const imageName = document.getElementById('imageName');
const imageSize = document.getElementById('imageSize');
const imageDimensions = document.getElementById('imageDimensions');

// File input change
imageInput.addEventListener('change', handleFile);

// Drag and drop
fileUploadWrapper.addEventListener('dragover', (e) => {
    e.preventDefault();
    fileUploadWrapper.classList.add('dragover');
});

fileUploadWrapper.addEventListener('dragleave', () => {
    fileUploadWrapper.classList.remove('dragover');
});

fileUploadWrapper.addEventListener('drop', (e) => {
    e.preventDefault();
    fileUploadWrapper.classList.remove('dragover');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        imageInput.files = files;
        handleFile();
    }
});

function handleFile() {
    const file = imageInput.files[0];
    
    if (!file) {
        imagePreviewWrapper.classList.remove('show');
        return;
    }
    
    // Validate file size (5MB)
    const maxSize = 5 * 1024 * 1024; // 5MB in bytes
    if (file.size > maxSize) {
        alert('Ukuran file terlalu besar! Maksimal 5MB');
        imageInput.value = '';
        return;
    }
    
    // Validate file type
    const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
    if (!validTypes.includes(file.type)) {
        alert('Format file tidak didukung! Gunakan JPEG, PNG, GIF, atau WEBP');
        imageInput.value = '';
        return;
    }
    
    // Show preview
    const reader = new FileReader();
    reader.onload = function(e) {
        imagePreview.src = e.target.result;
        imagePreviewWrapper.classList.add('show');
        
        // Show file info
        imageName.textContent = file.name;
        imageSize.textContent = formatFileSize(file.size);
        
        // Get image dimensions
        const img = new Image();
        img.onload = function() {
            imageDimensions.textContent = `${this.width} x ${this.height} px`;
        };
        img.src = e.target.result;
    };
    reader.readAsDataURL(file);
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
}
</script>
@endpush
@endsection