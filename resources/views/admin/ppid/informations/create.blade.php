@extends('layouts.app')

@section('title', 'Tambah Informasi Publik')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-plus"></i> Tambah Informasi Publik</h1>
    <a href="{{ route('admin.ppid-informations.index') }}" class="btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<form action="{{ route('admin.ppid-informations.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="form-container">
        <!-- Main Form -->
        <div class="form-main">
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-file-alt"></i> Informasi Dasar</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="ppid_category_id" class="form-label required">Kategori Informasi</label>
                        <select name="ppid_category_id" id="ppid_category_id" class="form-control @error('ppid_category_id') is-invalid @enderror" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('ppid_category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('ppid_category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="title" class="form-label required">Judul Informasi</label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Masukkan judul informasi" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="Jelaskan detail informasi...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="information_number" class="form-label">Nomor Informasi/SK</label>
                                <input type="text" name="information_number" id="information_number" class="form-control @error('information_number') is-invalid @enderror" value="{{ old('information_number') }}" placeholder="Contoh: 800/123/DINKES/2024">
                                @error('information_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type" class="form-label">Jenis Informasi</label>
                                <input type="text" name="type" id="type" class="form-control @error('type') is-invalid @enderror" value="{{ old('type') }}" placeholder="Contoh: Laporan, SK, Peraturan">
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="responsible_unit" class="form-label">Unit Penanggung Jawab</label>
                        <input type="text" name="responsible_unit" id="responsible_unit" class="form-control @error('responsible_unit') is-invalid @enderror" value="{{ old('responsible_unit') }}" placeholder="Contoh: Sekretariat Dinas Kesehatan">
                        @error('responsible_unit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-calendar"></i> Waktu & Format</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="year" class="form-label required">Tahun</label>
                                <select name="year" id="year" class="form-control @error('year') is-invalid @enderror" required>
                                    @for($y = date('Y') + 1; $y >= 2020; $y--)
                                    <option value="{{ $y }}" {{ old('year', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                                @error('year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="published_date" class="form-label">Tanggal Terbit</label>
                                <input type="date" name="published_date" id="published_date" class="form-control @error('published_date') is-invalid @enderror" value="{{ old('published_date') }}">
                                @error('published_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="validity_period" class="form-label">Masa Berlaku</label>
                                <input type="date" name="validity_period" id="validity_period" class="form-control @error('validity_period') is-invalid @enderror" value="{{ old('validity_period') }}">
                                @error('validity_period')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
                                <!-- Checkbox Berlaku Selamanya -->
                                <div class="mt-2">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="permanent_validity" {{ old('permanent_validity') ? 'checked' : '' }}>
                                        <span>Berlaku Selamanya (Tidak Ada Batas Waktu)</span>
                                    </label>
                                    <input type="hidden" name="permanent_validity" id="permanent_validity_hidden" value="{{ old('permanent_validity', '0') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Format Informasi</label>
                        <div class="radio-group">
                            <div class="radio-item">
                                <input type="radio" name="information_format" id="format_softcopy" value="softcopy" {{ old('information_format', 'softcopy') == 'softcopy' ? 'checked' : '' }}>
                                <label for="format_softcopy">
                                    <i class="fas fa-file-alt"></i>
                                    <span>Softcopy (Digital)</span>
                                </label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" name="information_format" id="format_hardcopy" value="hardcopy" {{ old('information_format') == 'hardcopy' ? 'checked' : '' }}>
                                <label for="format_hardcopy">
                                    <i class="fas fa-print"></i>
                                    <span>Hardcopy (Cetak)</span>
                                </label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" name="information_format" id="format_both" value="keduanya" {{ old('information_format') == 'keduanya' ? 'checked' : '' }}>
                                <label for="format_both">
                                    <i class="fas fa-copy"></i>
                                    <span>Keduanya</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-paperclip"></i> File & Link</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="file" class="form-label">Upload File Dokumen</label>
                        <input type="file" name="file" id="file" class="form-control-file @error('file') is-invalid @enderror" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip">
                        <small class="form-text">Format: PDF, DOC, DOCX, XLS, XLSX, ZIP (Max. 10MB)</small>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="external_link" class="form-label">Link Eksternal</label>
                        <input type="url" name="external_link" id="external_link" class="form-control @error('external_link') is-invalid @enderror" value="{{ old('external_link') }}" placeholder="https://example.com">
                        @error('external_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">Jika informasi tersedia di link lain</small>
                    </div>

                    <div class="form-group">
                        <label for="keywords" class="form-label">Kata Kunci</label>
                        <input type="text" name="keywords" id="keywords" class="form-control @error('keywords') is-invalid @enderror" value="{{ old('keywords') }}" placeholder="Contoh: laporan, kinerja, kesehatan">
                        <small class="form-text">Pisahkan dengan koma untuk memudahkan pencarian</small>
                        @error('keywords')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="notes" class="form-label">Catatan</label>
                        <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3" placeholder="Catatan tambahan (opsional)">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="form-sidebar">
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-cog"></i> Pengaturan</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="is_public" value="1" {{ old('is_public', true) ? 'checked' : '' }}>
                            <span>
                                <i class="fas fa-eye"></i>
                                <strong>Publikasikan</strong>
                                <small>Tampilkan di halaman publik</small>
                            </span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="card info-card">
                <div class="card-header">
                    <h3><i class="fas fa-info-circle"></i> Panduan</h3>
                </div>
                <div class="card-body">
                    <ul>
                        <li>Pastikan kategori sudah benar</li>
                        <li>Judul harus jelas dan deskriptif</li>
                        <li>Upload file jika tersedia</li>
                        <li>Gunakan kata kunci untuk SEO</li>
                        <li>Centang "Publikasikan" untuk menampilkan</li>
                        <li><strong>Centang "Berlaku Selamanya" jika tidak ada batas waktu</strong></li>
                    </ul>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-save"></i> Simpan Informasi
                </button>
                <a href="{{ route('admin.ppid-informations.index') }}" class="btn btn-secondary btn-block">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </div>
    </div>
</form>

<style>
.form-container {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 2rem;
    max-width: 1400px;
}

.card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
}

.card-header {
    padding: 1.5rem;
    border-bottom: 2px solid #f1f5f9;
}

.card-header h3 {
    margin: 0;
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.card-body {
    padding: 2rem;
}

.row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #334155;
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

.form-control.is-invalid {
    border-color: #ef4444;
}

.invalid-feedback {
    color: #ef4444;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    display: block;
}

.form-text {
    font-size: 0.8125rem;
    color: #94a3b8;
    margin-top: 0.25rem;
    display: block;
}

.form-control-file {
    display: block;
    width: 100%;
    padding: 0.5rem;
    border: 2px dashed #cbd5e1;
    border-radius: 8px;
    cursor: pointer;
}

/* Checkbox Inline for Permanent Validity */
.checkbox-inline {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem;
    background: #fef3c7;
    border: 2px solid #fbbf24;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s;
}

.checkbox-inline:hover {
    background: #fde68a;
}

.checkbox-inline input[type="checkbox"] {
    width: 18px;
    height: 18px;
    cursor: pointer;
}

.checkbox-inline span {
    font-size: 0.875rem;
    color: #92400e;
    font-weight: 600;
}

.radio-group {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
}

.radio-item {
    position: relative;
}

.radio-item input[type="radio"] {
    position: absolute;
    opacity: 0;
}

.radio-item label {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s;
    text-align: center;
}

.radio-item input:checked + label {
    border-color: #3b82f6;
    background: #eff6ff;
}

.radio-item label i {
    font-size: 1.5rem;
    color: #3b82f6;
}

.checkbox-label {
    display: flex;
    align-items: start;
    gap: 1rem;
    padding: 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    cursor: pointer;
}

.checkbox-label input {
    margin-top: 0.25rem;
    width: 18px;
    height: 18px;
}

.checkbox-label span {
    flex: 1;
}

.checkbox-label strong {
    display: block;
    margin-bottom: 0.25rem;
}

.checkbox-label small {
    color: #64748b;
}

.info-card .card-body {
    background: #f8fafc;
}

.info-card ul {
    margin: 0;
    padding-left: 1.5rem;
}

.info-card li {
    color: #475569;
    margin-bottom: 0.5rem;
}

.form-actions {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

@media (max-width: 1024px) {
    .form-container {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const permanentCheckbox = document.getElementById('permanent_validity');
    const validityPeriodInput = document.getElementById('validity_period');
    const permanentHidden = document.getElementById('permanent_validity_hidden');

    if (permanentCheckbox && validityPeriodInput) {
        // Function to toggle validity period
        function toggleValidityPeriod() {
            if (permanentCheckbox.checked) {
                validityPeriodInput.value = '';
                validityPeriodInput.disabled = true;
                validityPeriodInput.style.opacity = '0.5';
                validityPeriodInput.style.cursor = 'not-allowed';
                permanentHidden.value = '1';
            } else {
                validityPeriodInput.disabled = false;
                validityPeriodInput.style.opacity = '1';
                validityPeriodInput.style.cursor = 'text';
                permanentHidden.value = '0';
            }
        }

        // Event listener
        permanentCheckbox.addEventListener('change', toggleValidityPeriod);

        // Init on page load
        toggleValidityPeriod();
    }
});
</script>
@endsection