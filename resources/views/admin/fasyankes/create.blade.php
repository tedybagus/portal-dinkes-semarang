@extends('layouts.app')

@section('title', 'Tambah Fasyankes')

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
    
    .filament-input, .filament-textarea, .filament-select {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 0.625rem 1rem;
        font-size: 0.875rem;
        transition: all 0.2s;
        width: 100%;
    }
    
    .filament-input:focus, .filament-textarea:focus, .filament-select:focus {
        background: white;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }
    
    .filament-input.is-invalid, .filament-textarea.is-invalid, .filament-select.is-invalid {
        border-color: #ef4444;
    }
    
    .filament-textarea {
        resize: vertical;
        min-height: 100px;
    }
    
    .filament-help-text {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }
    
    .filament-input-group {
        display: flex;
        align-items: stretch;
    }
    
    .filament-input-group-prepend {
        background: #f3f4f6;
        border: 1px solid #e5e7eb;
        border-right: none;
        border-radius: 8px 0 0 8px;
        padding: 0.625rem 1rem;
        display: flex;
        align-items: center;
        color: #6b7280;
    }
    
    .filament-input-group input {
        border-radius: 0 8px 8px 0;
    }
    
    .filament-alert {
        padding: 1rem;
        border-radius: 8px;
        border-left: 4px solid;
        margin-bottom: 1rem;
    }
    
    .filament-alert-info {
        background: #eff6ff;
        border-color: #3b82f6;
        color: #1e40af;
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
    }
    
    .filament-button-warning {
        background: #fef3c7;
        color: #92400e;
    }
    
    .filament-button-warning:hover {
        background: #fde68a;
    }
    
    .filament-card-footer {
        padding: 1.5rem;
        border-top: 1px solid #e5e7eb;
        background: #f9fafb;
        display: flex;
        gap: 0.75rem;
    }
</style>
@endpush

@section('content')
<div class="filament-page">
    <div class="container-fluid">
        <div class="filament-header">
            <div>
                <h1 class="filament-title">Tambah Fasyankes</h1>
                <p class="filament-subtitle">Tambahkan fasilitas kesehatan baru</p>
            </div>
        </div>

        {{-- Success Alert --}}
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border-left: 4px solid #10b981;">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
        @endif

        {{-- Error Alert --}}
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; border-left: 4px solid #ef4444;">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
        @endif

        {{-- Validation Errors --}}
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
                    <i class="fas fa-plus-circle mr-2"></i> Form Tambah Fasyankes
                </h3>
            </div>

            <form action="{{ route('admin.fasyankes.store') }}" method="POST" id="fasyankesForm">
                @csrf
                
                <div class="filament-card-body">
                    <div class="row">
                        {{-- Kategori --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="filament-form-label required-field">Kategori Fasyankes</label>
                                <select name="klinik_id" 
                                        class="filament-select @error('klinik_id') is-invalid @enderror" 
                                        required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($kategoris as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('klinik_id', $fasyanke->klinik_id ?? '') == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('klinik_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @else
                                    <small class="filament-help-text">
                                        <i class="fas fa-info-circle"></i> Pilih jenis fasyankes (Klinik, Puskesmas, dll)
                                    </small>
                                @enderror
                            </div>
                        </div>

                        {{-- Kode --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="filament-form-label required-field">Kode</label>
                                <input type="text" 
                                       name="kode" 
                                       class="filament-input @error('kode') is-invalid @enderror" 
                                       value="{{ old('kode') }}"
                                       placeholder="Contoh: KLN-001"
                                       required>
                                @error('kode')
                                    <small class="text-danger">{{ $message }}</small>
                                @else
                                    <small class="filament-help-text">
                                        <i class="fas fa-info-circle"></i> Kode unik untuk identifikasi fasyankes
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Nama --}}
                    <div class="form-group">
                        <label class="filament-form-label required-field">Nama Fasyankes</label>
                        <input type="text" 
                               name="nama" 
                               class="filament-input @error('nama') is-invalid @enderror" 
                               value="{{ old('nama') }}"
                               placeholder="Contoh: Klinik Sehat Sentosa"
                               required>
                        @error('nama')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="form-group">
                        <label class="filament-form-label required-field">Alamat Lengkap</label>
                        <textarea name="alamat" 
                                  class="filament-textarea @error('alamat') is-invalid @enderror" 
                                  placeholder="Masukkan alamat lengkap fasyankes..."
                                  required>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="row">
                        {{-- Latitude --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="filament-form-label">
                                    Latitude <span class="text-muted">(opsional)</span>
                                </label>
                                <div class="filament-input-group">
                                    <div class="filament-input-group-prepend">
                                        <i class="fas fa-map-pin"></i>
                                    </div>
                                    <input type="text" 
                                           name="latitude" 
                                           class="filament-input @error('latitude') is-invalid @enderror" 
                                           value="{{ old('latitude') }}"
                                           placeholder="Contoh: -7.123456">
                                </div>
                                @error('latitude')
                                    <small class="text-danger">{{ $message }}</small>
                                @else
                                    <small class="filament-help-text">Format: desimal (contoh: -7.123456)</small>
                                @enderror
                            </div>
                        </div>

                        {{-- Longitude --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="filament-form-label">
                                    Longitude <span class="text-muted">(opsional)</span>
                                </label>
                                <div class="filament-input-group">
                                    <div class="filament-input-group-prepend">
                                        <i class="fas fa-map-pin"></i>
                                    </div>
                                    <input type="text" 
                                           name="longitude" 
                                           class="filament-input @error('longitude') is-invalid @enderror" 
                                           value="{{ old('longitude') }}"
                                           placeholder="Contoh: 110.123456">
                                </div>
                                @error('longitude')
                                    <small class="text-danger">{{ $message }}</small>
                                @else
                                    <small class="filament-help-text">Format: desimal (contoh: 110.123456)</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="filament-alert filament-alert-info">
                        <i class="fas fa-lightbulb mr-2"></i> 
                        <strong>Tips:</strong> Untuk mendapatkan koordinat, buka Google Maps → klik kanan pada lokasi → pilih koordinat yang muncul untuk menyalin.
                    </div>
                </div>

                <div class="filament-card-footer">
                    <button type="submit" class="filament-button filament-button-primary">
                        <i class="fas fa-save"></i> Simpan Data
                    </button>
                    <a href="{{ route('admin.fasyankes.index') }}" class="filament-button filament-button-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="reset" class="filament-button filament-button-warning">
                        <i class="fas fa-redo"></i> Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-generate kode based on kategori
    $('select[name="klinik_id"]').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var kategoriText = selectedOption.text().trim();
        
        if (kategoriText && kategoriText !== '-- Pilih Kategori --') {
            // Generate kode otomatis
            var prefix = '';
            if (kategoriText === 'Klinik') prefix = 'KLN';
            else if (kategoriText === 'Puskesmas') prefix = 'PKM';
            else if (kategoriText === 'Rumah Sakit') prefix = 'RS';
            else if (kategoriText === 'Apotek') prefix = 'APT';
            else prefix = kategoriText.substring(0, 3).toUpperCase();
            
            var randomNum = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
            $('input[name="kode"]').val(prefix + '-' + randomNum);
        }
    });

    // Validation
    $('#fasyankesForm').on('submit', function(e) {
        var latitude = $('input[name="latitude"]').val();
        var longitude = $('input[name="longitude"]').val();
        
        // Jika salah satu diisi, keduanya harus diisi
        if ((latitude && !longitude) || (!latitude && longitude)) {
            e.preventDefault();
            alert('Jika mengisi koordinat, harap isi latitude dan longitude');
            return false;
        }
    });
});
</script>
@endpush
@endsection