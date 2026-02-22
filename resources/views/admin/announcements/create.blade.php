@extends('layouts.app')
@section('title', isset($announcement) ? 'Edit Pengumuman' : 'Tambah Pengumuman')

@section('content')
<div class="announcement-form-page">
    <div class="page-header">
        <div>
            <h1>{{ isset($announcement) ? 'Edit Pengumuman' : 'Tambah Pengumuman' }}</h1>
            <nav class="breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a> /
                <a href="{{ route('admin.announcements.index') }}">Pengumuman</a> /
                <span>{{ isset($announcement) ? 'Edit' : 'Tambah' }}</span>
            </nav>
        </div>
    </div>

    <form action="{{ isset($announcement) ? route('admin.announcements.update', $announcement) : route('admin.announcements.store') }}" 
          method="POST" 
          enctype="multipart/form-data" 
          class="announcement-form">
        @csrf
        @if(isset($announcement))
            @method('PUT')
        @endif

        <div class="form-grid">
            {{-- Main Content --}}
            <div class="main-content">
                {{-- Title --}}
                <div class="form-card">
                    <label class="form-label required">Judul Pengumuman</label>
                    <input type="text" 
                           name="title" 
                           class="form-input @error('title') is-invalid @enderror" 
                           value="{{ old('title', $announcement->title ?? '') }}"
                           placeholder="Masukkan judul pengumuman..."
                           required>
                    @error('title')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Content --}}
                <div class="form-card">
                    <label class="form-label required">Isi Pengumuman</label>
                    <textarea name="content" 
                              rows="12"
                              class="form-textarea @error('content') is-invalid @enderror" 
                              placeholder="Tulis isi pengumuman di sini..."
                              required>{{ old('content', $announcement->content ?? '') }}</textarea>
                    @error('content')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Image Upload --}}
                <div class="form-card">
                    <label class="form-label">Gambar Ilustrasi</label>
                    <div class="upload-zone" id="imageUploadZone">
                        <input type="file" 
                               name="image" 
                               id="imageInput" 
                               accept="image/jpeg,image/png,image/jpg"
                               class="hidden-input">
                        <div class="upload-placeholder" id="imagePlaceholder">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Klik untuk upload gambar</p>
                            <span>JPG, PNG (Max 2MB)</span>
                        </div>
                        <div class="preview-container hidden" id="imagePreview">
                            <img src="" alt="Preview" id="previewImage">
                            <button type="button" class="btn-remove" id="removeImage">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    @if(isset($announcement) && $announcement->image)
                        <div class="current-file">
                            <img src="{{ Storage::url($announcement->image) }}" alt="Current" class="current-image">
                            <label class="checkbox-label">
                                <input type="checkbox" name="remove_image" value="1">
                                Hapus gambar saat ini
                            </label>
                        </div>
                    @endif
                    @error('image')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                {{-- File Upload --}}
                <div class="form-card">
                    <label class="form-label">File Lampiran</label>
                    <div class="upload-zone" id="fileUploadZone">
                        <input type="file" 
                               name="file" 
                               id="fileInput" 
                               class="hidden-input">
                        <div class="upload-placeholder" id="filePlaceholder">
                            <i class="fas fa-paperclip"></i>
                            <p>Klik untuk upload file</p>
                            <span>PDF, DOC, XLS, PPT, ZIP (Max 10MB)</span>
                        </div>
                        <div class="file-info hidden" id="fileInfo">
                            <i class="fas fa-file-alt"></i>
                            <div class="file-details">
                                <span class="file-name" id="fileName"></span>
                                <span class="file-size" id="fileSize"></span>
                            </div>
                            <button type="button" class="btn-remove" id="removeFile">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    @if(isset($announcement) && $announcement->hasFile())
                        <div class="current-file">
                            <i class="fas {{ $announcement->file_icon }}"></i>
                            <span>{{ $announcement->file_name }} ({{ $announcement->file_size_readable }})</span>
                            <label class="checkbox-label">
                                <input type="checkbox" name="remove_file" value="1">
                                Hapus file saat ini
                            </label>
                        </div>
                    @endif
                    @error('file')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="sidebar">
                {{-- Publish Settings --}}
                <div class="form-card">
                    <h3>Pengaturan Publikasi</h3>
                    
                    <div class="form-group">
                        <label class="form-label">Mulai Tampil</label>
                        <input type="datetime-local" 
                               name="start_date" 
                               class="form-input"
                               value="{{ old('start_date', isset($announcement) && $announcement->start_date ? $announcement->start_date->format('Y-m-d\TH:i') : '') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Selesai Tampil</label>
                        <input type="datetime-local" 
                               name="end_date" 
                               class="form-input"
                               value="{{ old('end_date', isset($announcement) && $announcement->end_date ? $announcement->end_date->format('Y-m-d\TH:i') : '') }}">
                    </div>

                    <div class="form-group">
                        <label class="toggle-label">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', $announcement->is_active ?? true) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                            <span>Aktifkan Pengumuman</span>
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="toggle-label">
                            <input type="checkbox" 
                                   name="is_pinned" 
                                   value="1"
                                   {{ old('is_pinned', $announcement->is_pinned ?? false) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                            <span>Pin di Atas</span>
                        </label>
                    </div>
                </div>

                {{-- Info --}}
                @if(isset($announcement))
                <div class="form-card">
                    <h3>Informasi</h3>
                    <div class="info-item">
                        <span class="label">Dibuat:</span>
                        <span class="value">{{ $announcement->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="label">Diperbarui:</span>
                        <span class="value">{{ $announcement->updated_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="label">Dilihat:</span>
                        <span class="value">{{ $announcement->view_count }}x</span>
                    </div>
                    @if($announcement->creator)
                    <div class="info-item">
                        <span class="label">Oleh:</span>
                        <span class="value">{{ $announcement->creator->name }}</span>
                    </div>
                    @endif
                </div>
                @endif

                {{-- Actions --}}
                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i>
                        {{ isset($announcement) ? 'Perbarui' : 'Simpan' }}
                    </button>
                    <a href="{{ route('admin.announcements.index') }}" class="btn-secondary">
                        <i class="fas fa-times"></i>
                        Batal
                    </a>
                </div>

                @if(isset($announcement))
                <form action="{{ route('admin.announcements.destroy', $announcement) }}" 
                      method="POST" 
                      onsubmit="return confirm('Yakin hapus pengumuman ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger full-width">
                        <i class="fas fa-trash"></i>
                        Hapus Pengumuman
                    </button>
                </form>
                @endif
            </div>
        </div>
    </form>
</div>

<style>
.announcement-form-page {
    padding: 2rem;
    max-width: 1400px;
    margin: 0 auto;
}

.page-header {
    margin-bottom: 2rem;
}

.page-header h1 {
    font-size: 1.875rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.breadcrumb {
    font-size: 0.875rem;
    color: #64748b;
}

.breadcrumb a {
    color: #3b82f6;
    text-decoration: none;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 2rem;
}

.form-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,.1);
    margin-bottom: 1.5rem;
}

.form-card h3 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1rem;
}

.form-label {
    display: block;
    font-size: 0.9375rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.form-label.required::after {
    content: ' *';
    color: #ef4444;
}

.form-input,
.form-textarea {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.9375rem;
    transition: border-color 0.2s;
}

.form-input:focus,
.form-textarea:focus {
    outline: none;
    border-color: #3b82f6;
}

.form-textarea {
    resize: vertical;
    font-family: inherit;
}

.is-invalid {
    border-color: #ef4444;
}

.error-message {
    display: block;
    font-size: 0.875rem;
    color: #ef4444;
    margin-top: 0.5rem;
}

/* Upload Zone */
.upload-zone {
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
    position: relative;
}

.upload-zone:hover {
    border-color: #3b82f6;
    background: #f8fafc;
}

.hidden-input {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    opacity: 0;
    cursor: pointer;
}

.upload-placeholder i {
    font-size: 3rem;
    color: #94a3b8;
    margin-bottom: 1rem;
}

.upload-placeholder p {
    font-size: 1rem;
    font-weight: 600;
    color: #475569;
    margin-bottom: 0.5rem;
}

.upload-placeholder span {
    font-size: 0.875rem;
    color: #94a3b8;
}

.preview-container {
    position: relative;
}

.preview-container img {
    max-width: 100%;
    max-height: 300px;
    border-radius: 8px;
}

.btn-remove {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    background: #ef4444;
    color: white;
    border: none;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    cursor: pointer;
    transition: background 0.2s;
}

.btn-remove:hover {
    background: #dc2626;
}

.file-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 8px;
}

.file-info i {
    font-size: 2rem;
    color: #3b82f6;
}

.file-details {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.file-name {
    font-weight: 600;
    color: #1e293b;
}

.file-size {
    font-size: 0.875rem;
    color: #64748b;
}

.current-file {
    margin-top: 1rem;
    padding: 1rem;
    background: #f1f5f9;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.current-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #64748b;
    cursor: pointer;
}

/* Toggle */
.toggle-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
}

.toggle-label input[type="checkbox"] {
    display: none;
}

.toggle-slider {
    position: relative;
    width: 44px;
    height: 24px;
    background: #cbd5e1;
    border-radius: 24px;
    transition: background 0.2s;
}

.toggle-slider::after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    background: white;
    border-radius: 50%;
    top: 2px;
    left: 2px;
    transition: transform 0.2s;
}

.toggle-label input[type="checkbox"]:checked + .toggle-slider {
    background: #10b981;
}

.toggle-label input[type="checkbox"]:checked + .toggle-slider::after {
    transform: translateX(20px);
}

/* Info */
.info-item {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid #e2e8f0;
}

.info-item:last-child {
    border-bottom: none;
}

.info-item .label {
    font-size: 0.875rem;
    color: #64748b;
}

.info-item .value {
    font-size: 0.875rem;
    font-weight: 600;
    color: #1e293b;
}

/* Buttons */
.form-actions {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.btn-primary,
.btn-secondary,
.btn-danger {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9375rem;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
}

.btn-primary {
    background: #3b82f6;
    color: white;
}

.btn-primary:hover {
    background: #2563eb;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.btn-secondary {
    background: #e2e8f0;
    color: #475569;
}

.btn-secondary:hover {
    background: #cbd5e1;
}

.btn-danger {
    background: #ef4444;
    color: white;
}

.btn-danger:hover {
    background: #dc2626;
}

.full-width {
    width: 100%;
}

.hidden {
    display: none !important;
}

@media (max-width: 1024px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image Upload
    const imageInput = document.getElementById('imageInput');
    const imagePlaceholder = document.getElementById('imagePlaceholder');
    const imagePreview = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImage');
    const removeImage = document.getElementById('removeImage');

    imageInput?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                imagePlaceholder.classList.add('hidden');
                imagePreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });

    removeImage?.addEventListener('click', function() {
        imageInput.value = '';
        imagePlaceholder.classList.remove('hidden');
        imagePreview.classList.add('hidden');
    });

    // File Upload
    const fileInput = document.getElementById('fileInput');
    const filePlaceholder = document.getElementById('filePlaceholder');
    const fileInfo = document.getElementById('fileInfo');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const removeFileBtn = document.getElementById('removeFile');

    fileInput?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            filePlaceholder.classList.add('hidden');
            fileInfo.classList.remove('hidden');
        }
    });

    removeFileBtn?.addEventListener('click', function() {
        fileInput.value = '';
        filePlaceholder.classList.remove('hidden');
        fileInfo.classList.add('hidden');
    });

    function formatFileSize(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1048576) return (bytes / 1024).toFixed(2) + ' KB';
        if (bytes < 1073741824) return (bytes / 1048576).toFixed(2) + ' MB';
        return (bytes / 1073741824).toFixed(2) + ' GB';
    }
});
</script>
@endsection