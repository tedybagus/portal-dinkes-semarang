@extends('layouts.app')

@section('title', 'Upload File')

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
            <a href="{{ route('admin.health-profiles.index') }}" class="filament-button filament-button-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
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
        <div class="filament-card">
            <div class="filament-card-header">
                <h3 class="filament-card-title">
                    <i class="fas fa-image mr-2"></i> Form Upload Profil
                </h3>
            </div>
            <form action="{{ route('admin.health-profiles.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-5">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="filament-form-label required-field">Nama Profil Kesehatan</label>
                        <input type="text" class="filament-input @error('title') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                        @error('title')
                                    <small class="text-danger">{{ $message }}</small>
                                @else
                                    <small class="filament-help-text">
                                        <i class="fas fa-info-circle"></i> Nama File untuk ditampilkan
                                    </small>
                                @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="filament-form-label">Upload File</label>
                        <div class="file-upload-wrapper" onclick="document.getElementById('fileInput').click()">
                            <input type="file" name="file" id="fileInput" class="file-upload-input @error('file') is-invalid @enderror" 
                                           accept="application/pdf">
                                           <div class="file-upload-icon">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                    </div>
                                    <div class="file-upload-text">
                                        <strong>Klik atau drag & drop gambar di sini</strong>
                                    </div>
                                    <div class="file-upload-hint">
                                        Format: PDF
                                    </div>
                                    <p id="fileName" class="text-sm text-gray-600 mt-2 italic">
                                           Belum ada file yang dipilih! 
                                    </p>
                                @error('file')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                        </div>       
                    </div>
                </div>
            </div>
            <div class="filament-card-footer">
                    <button type="submit" class="filament-button filament-button-primary">
                        <i class="fas fa-save"></i> {{ isset($healthProfile) ? 'Update File' : 'Upload File' }}
                    </button>
                    <a href="{{ route('admin.health-profiles.index') }}" class="filament-button filament-button-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
        </form>
        </div>
    </div>
</div>
@push('scripts')
<script>
const validTypes = ['application/pdf'];

const fileInput = document.getElementById('fileInput');
const fileName = document.getElementById('fileName');
const dropzone = document.getElementById('dropzone');

fileInput.addEventListener('change', function () {
    const file = this.files[0];

    if (!file) {
        fileName.textContent = 'Belum ada file dipilih';
        return;
    }

    if (!validTypes.includes(file.type)) {
        alert('File harus PDF');
        this.value = '';
        fileName.textContent = 'Belum ada file dipilih';
        return;
    }

    // ✅ TAMPILKAN NAMA FILE
    fileName.textContent = 'File dipilih: ' + file.name;
});

// ✨ Efek drag & drop (bonus UX)
['dragenter', 'dragover'].forEach(event => {
    dropzone.addEventListener(event, e => {
        e.preventDefault();
        dropzone.classList.add('dragover');
    });
});

['dragleave', 'drop'].forEach(event => {
    dropzone.addEventListener(event, e => {
        e.preventDefault();
        dropzone.classList.remove('dragover');
    });
});
</script>

@endpush
@endsection
