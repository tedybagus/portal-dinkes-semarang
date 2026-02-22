@extends('layouts.app')
@section('title', isset($produkHukum) ? 'Edit Produk Hukum' : 'Tambah Produk Hukum')

@section('content')
<div class="form-page">
    <div class="page-header">
        <div>
            <h1>{{ isset($produkHukum) ? 'Edit' : 'Tambah' }} Produk Hukum</h1>
            <nav class="breadcrumb">
                <a href="{{ route('admin.produkhukum.index') }}">Produk Hukum</a> /
                <span>{{ isset($produkHukum) ? 'Edit' : 'Tambah' }}</span>
            </nav>
        </div>
    </div>

    <form action="{{ isset($produkHukum) ? route('admin.produkhukum.update', $produkHukum) : route('admin.produkhukum.store') }}" 
          method="POST" 
          enctype="multipart/form-data"
          class="form-container">
        @csrf
        @if(isset($produkHukum))
            @method('PUT')
        @endif

        <div class="form-grid">
            {{-- Main Content --}}
            <div class="main-content">
                <div class="form-card">
                    <h3>Informasi Dokumen</h3>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label required">Nomor</label>
                            <input type="text" 
                                   name="nomor" 
                                   class="form-input @error('nomor') is-invalid @enderror"
                                   value="{{ old('nomor', $produkHukum->nomor ?? '') }}"
                                   placeholder="Contoh: 1"
                                   required>
                            @error('nomor')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Tahun</label>
                            <input type="number" 
                                   name="tahun" 
                                   class="form-input @error('tahun') is-invalid @enderror"
                                   value="{{ old('tahun', $produkHukum->tahun ?? date('Y')) }}"
                                   min="1900"
                                   max="{{ date('Y') + 10 }}"
                                   required>
                            @error('tahun')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Kategori</label>
                        <select name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $key => $label)
                                <option value="{{ $key }}" {{ old('kategori', $produkHukum->kategori ?? '') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Tentang</label>
                        <textarea name="tentang" 
                                  rows="4"
                                  class="form-textarea @error('tentang') is-invalid @enderror"
                                  placeholder="Contoh: Perubahan Atas Peraturan Daerah..."
                                  required>{{ old('tentang', $produkHukum->tentang ?? '') }}</textarea>
                        @error('tentang')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label required">Tanggal Penetapan</label>
                            <input type="date" 
                                   name="tanggal_penetapan" 
                                   class="form-input @error('tanggal_penetapan') is-invalid @enderror"
                                   value="{{ old('tanggal_penetapan', isset($produkHukum) && $produkHukum->tanggal_penetapan ? $produkHukum->tanggal_penetapan->format('Y-m-d') : '') }}"
                                   required>
                            @error('tanggal_penetapan')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tanggal Berlaku</label>
                            <input type="date" 
                                   name="tanggal_berlaku" 
                                   class="form-input @error('tanggal_berlaku') is-invalid @enderror"
                                   value="{{ old('tanggal_berlaku', isset($produkHukum) && $produkHukum->tanggal_berlaku ? $produkHukum->tanggal_berlaku->format('Y-m-d') : '') }}">
                            @error('tanggal_berlaku')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Keterangan Tambahan</label>
                        <textarea name="keterangan" 
                                  rows="3"
                                  class="form-textarea"
                                  placeholder="Keterangan tambahan (opsional)">{{ old('keterangan', $produkHukum->keterangan ?? '') }}</textarea>
                    </div>
                </div>

                <div class="form-card">
                    <h3>Upload Dokumen PDF</h3>
                    
                    <div class="upload-zone" id="uploadZone">
                        <input type="file" 
                               name="file" 
                               id="fileInput" 
                               accept=".pdf"
                               {{ isset($produkHukum) ? '' : 'required' }}
                               class="hidden-input">
                        <div class="upload-placeholder" id="placeholder">
                            <i class="fas fa-file-pdf"></i>
                            <p>Klik untuk upload file PDF</p>
                            <span>Maximum 20MB</span>
                        </div>
                        <div class="file-preview hidden" id="filePreview">
                            <i class="fas fa-file-pdf file-icon"></i>
                            <div class="file-info">
                                <div class="file-name" id="fileName"></div>
                                <div class="file-size" id="fileSize"></div>
                            </div>
                            <button type="button" class="btn-remove" id="removeFile">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    @if(isset($produkHukum) && $produkHukum->file_path)
                        <div class="current-file">
                            <i class="fas fa-file-pdf"></i>
                            <div>
                                <div class="file-name">{{ $produkHukum->file_name }}</div>
                                <div class="file-size">{{ $produkHukum->file_size_readable }}</div>
                            </div>
                            <a href="{{ Storage::url($produkHukum->file_path) }}" 
                               target="_blank" 
                               class="btn-view">
                                <i class="fas fa-eye"></i>
                                Lihat
                            </a>
                        </div>
                    @endif

                    @error('file')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="sidebar">
                <div class="form-card">
                    <h3>Status & Publikasi</h3>

                    <div class="form-group">
                        <label class="form-label required">Status Dokumen</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="berlaku" {{ old('status', $produkHukum->status ?? 'berlaku') == 'berlaku' ? 'selected' : '' }}>Berlaku</option>
                            <option value="tidak_berlaku" {{ old('status', $produkHukum->status ?? '') == 'tidak_berlaku' ? 'selected' : '' }}>Tidak Berlaku</option>
                            <option value="draft" {{ old('status', $produkHukum->status ?? '') == 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                        @error('status')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="toggle-label">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', $produkHukum->is_active ?? true) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                            <span>Aktifkan di Website</span>
                        </label>
                    </div>
                </div>

                @if(isset($produkHukum))
                <div class="form-card">
                    <h3>Informasi</h3>
                    <div class="info-item">
                        <span class="label">Dibuat:</span>
                        <span class="value">{{ $produkHukum->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="label">Diperbarui:</span>
                        <span class="value">{{ $produkHukum->updated_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="label">Download:</span>
                        <span class="value">{{ $produkHukum->download_count }}x</span>
                    </div>
                    @if($produkHukum->creator)
                    <div class="info-item">
                        <span class="label">Oleh:</span>
                        <span class="value">{{ $produkHukum->creator->name }}</span>
                    </div>
                    @endif
                </div>
                @endif

                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i>
                        {{ isset($produkHukum) ? 'Perbarui' : 'Simpan' }}
                    </button>
                    <a href="{{ route('admin.produkhukum.index') }}" class="btn-cancel">
                        <i class="fas fa-times"></i>
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
.form-page {
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
    grid-template-columns: 1fr 350px;
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
    margin-bottom: 1.25rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.form-group {
    margin-bottom: 1.25rem;
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
.form-select,
.form-textarea {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.9375rem;
    transition: border-color 0.2s;
}

.form-input:focus,
.form-select:focus,
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
    border-color: #ef4444;
    background: #fef2f2;
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
    color: #ef4444;
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

.file-preview {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 8px;
}

.file-icon {
    font-size: 2rem;
    color: #ef4444;
}

.file-info {
    flex: 1;
}

.file-name {
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.file-size {
    font-size: 0.875rem;
    color: #64748b;
}

.btn-remove {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #ef4444;
    color: white;
    border: none;
    cursor: pointer;
    transition: background 0.2s;
}

.btn-remove:hover {
    background: #dc2626;
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

.current-file i {
    font-size: 2rem;
    color: #ef4444;
}

.btn-view {
    padding: 0.5rem 1rem;
    background: #dbeafe;
    color: #1e40af;
    border-radius: 6px;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
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
}

.btn-submit,
.btn-cancel {
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

.btn-submit {
    background: #3b82f6;
    color: white;
}

.btn-submit:hover {
    background: #2563eb;
}

.btn-cancel {
    background: #e2e8f0;
    color: #475569;
}

.btn-cancel:hover {
    background: #cbd5e1;
}

.hidden {
    display: none !important;
}

@media (max-width: 1024px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('fileInput');
    const placeholder = document.getElementById('placeholder');
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const removeBtn = document.getElementById('removeFile');

    fileInput?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            placeholder.classList.add('hidden');
            filePreview.classList.remove('hidden');
        }
    });

    removeBtn?.addEventListener('click', function() {
        fileInput.value = '';
        placeholder.classList.remove('hidden');
        filePreview.classList.add('hidden');
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