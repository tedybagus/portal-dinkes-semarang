@extends('layouts.app')
@section('title', 'Edit Informasi Publik')
@section('content')
<div class="page-header">
    <h1><i class="fas fa-edit"></i> Edit Informasi Publik</h1>
    <a href="{{ route('admin.ppid-informations.index') }}" class="btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<form action="{{ route('admin.ppid-informations.update', $information->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
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
                            <option value="{{ $category->id }}" {{ old('ppid_category_id', $information->ppid_category_id) == $category->id ? 'selected' : '' }}>
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
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $information->title) }}" placeholder="Masukkan judul informasi" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="Jelaskan detail informasi...">{{ old('description', $information->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="information_number" class="form-label">Nomor Informasi/SK</label>
                                <input type="text" name="information_number" id="information_number" class="form-control @error('information_number') is-invalid @enderror" value="{{ old('information_number', $information->information_number) }}" placeholder="Contoh: 800/123/DINKES/2024">
                                @error('information_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type" class="form-label">Jenis Informasi</label>
                                <input type="text" name="type" id="type" class="form-control @error('type') is-invalid @enderror" value="{{ old('type', $information->type) }}" placeholder="Contoh: Laporan, SK, Peraturan">
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="responsible_unit" class="form-label">Unit Penanggung Jawab</label>
                        <input type="text" name="responsible_unit" id="responsible_unit" class="form-control @error('responsible_unit') is-invalid @enderror" value="{{ old('responsible_unit', $information->responsible_unit) }}" placeholder="Contoh: Sekretariat Dinas Kesehatan">
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
                                    <option value="{{ $y }}" {{ old('year', $information->year) == $y ? 'selected' : '' }}>{{ $y }}</option>
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
                                <input type="date" name="published_date" id="published_date" class="form-control @error('published_date') is-invalid @enderror" value="{{ old('published_date', $information->published_date?->format('Y-m-d')) }}">
                                @error('published_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="validity_period" class="form-label">Masa Berlaku</label>
                                <input type="date" name="validity_period" id="validity_period" class="form-control @error('validity_period') is-invalid @enderror" value="{{ old('validity_period', $information->validity_period?->format('Y-m-d')) }}">
                                @error('validity_period')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="permanent_validity" {{ old('permanent_validity', $information->permanent_validity) ? 'checked' : '' }}>
                                    <span>Berlaku Selamanya (Tidak Ada Batas Waktu)</span>
                                </label>
                                <input type="hidden" name="permanent_validity" id="permanent_validity_hidden" value="{{ old('permanent_validity', $information->permanent_validity ? '1' : '0') }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Format Informasi</label>
                        <div class="radio-group">
                            <div class="radio-item">
                                <input type="radio" name="information_format" id="format_softcopy" value="softcopy" {{ old('information_format', $information->information_format) == 'softcopy' ? 'checked' : '' }}>
                                <label for="format_softcopy">
                                    <i class="fas fa-file-alt"></i>
                                    <span>Softcopy</span>
                                </label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" name="information_format" id="format_hardcopy" value="hardcopy" {{ old('information_format', $information->information_format) == 'hardcopy' ? 'checked' : '' }}>
                                <label for="format_hardcopy">
                                    <i class="fas fa-print"></i>
                                    <span>Hardcopy</span>
                                </label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" name="information_format" id="format_both" value="keduanya" {{ old('information_format', $information->information_format) == 'keduanya' ? 'checked' : '' }}>
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
                    @if($information->file_path)
                    <div class="current-file">
                        <i class="fas fa-file-pdf"></i>
                        <div>
                            <strong>File Saat Ini:</strong>
                            <p>{{ basename($information->file_path) }} ({{ $information->file_size }})</p>
                            <a href="{{ asset('storage/' . $information->file_path) }}" target="_blank" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> Lihat File
                            </a>
                        </div>
                    </div>
                    <hr>
                    @endif

                    <div class="form-group">
                        <label for="file" class="form-label">{{ $information->file_path ? 'Ganti' : 'Upload' }} File Dokumen</label>
                        <input type="file" name="file" id="file" class="form-control-file @error('file') is-invalid @enderror" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip">
                        <small class="form-text">Format: PDF, DOC, DOCX, XLS, XLSX, ZIP (Max. 10MB)</small>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="external_link" class="form-label">Link Eksternal</label>
                        <input type="url" name="external_link" id="external_link" class="form-control @error('external_link') is-invalid @enderror" value="{{ old('external_link', $information->external_link) }}" placeholder="https://example.com">
                        @error('external_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="keywords" class="form-label">Kata Kunci</label>
                        <input type="text" name="keywords" id="keywords" class="form-control @error('keywords') is-invalid @enderror" value="{{ old('keywords', $information->keywords) }}" placeholder="Contoh: laporan, kinerja, kesehatan">
                        @error('keywords')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="notes" class="form-label">Catatan</label>
                        <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3" placeholder="Catatan tambahan">{{ old('notes', $information->notes) }}</textarea>
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
                            <input type="checkbox" name="is_public" value="1" {{ old('is_public', $information->is_public) ? 'checked' : '' }}>
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
                    <h3><i class="fas fa-chart-line"></i> Statistik</h3>
                </div>
                <div class="card-body">
                    <div class="stat-item">
                        <i class="fas fa-eye"></i>
                        <div>
                            <strong>{{ $information->view_count }}</strong>
                            <span>Dilihat</span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-download"></i>
                        <div>
                            <strong>{{ $information->download_count }}</strong>
                            <span>Download</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-save"></i> Update Informasi
                </button>
                <a href="{{ route('admin.ppid-informations.index') }}" class="btn btn-secondary btn-block">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </div>
    </div>
</form>

<style>
/* Reuse styles from create.blade.php */
.form-container {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 2rem;
    max-width: 1400px;
}

.current-file {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    background: #f1f5f9;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.current-file i {
    font-size: 2rem;
    color: #ef4444;
}

.current-file strong {
    display: block;
    margin-bottom: 0.25rem;
}

.current-file p {
    color: #64748b;
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.stat-item:last-child {
    margin-bottom: 0;
}

.stat-item i {
    font-size: 1.5rem;
    color: #3b82f6;
    width: 40px;
    text-align: center;
}

.stat-item strong {
    display: block;
    font-size: 1.5rem;
    color: #1e293b;
}

.stat-item span {
    font-size: 0.875rem;
    color: #64748b;
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