@extends('layouts.app')

@section('title', 'Tambah Kategori Berita')
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
<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Tambah Kategori Berita</h1>
        <p class="text-gray-500 text-sm">Tambahkan kategori baru untuk pengelompokan artikel</p>
    </div>

    {{-- Card --}}
    <div class="filament-card">
        <div class="filament-card-header">
                <h3 class="filament-card-title">
                    <i class="fas fa-plus-circle mr-2"></i> Form Tambah Kategori
                </h3>
            </div>

        <form action="{{ route('admin.categories.store') }}" method="POST" class="p-6 space-y-5">
            @csrf

            {{-- Nama Kategori --}}
            <div class="col-md-6">
                            <div class="form-group">
                                <label class="filament-form-label required-field">Nama Kategori</label>
                                <input type="text" 
                                       name="name" 
                                       class="filament-input @error('kode') is-invalid @enderror" 
                                       value="{{ old('name') }}"
                                       placeholder="Contoh: Kesehatan"
                                       required>
                                @error('kode')
                                    <small class="text-danger">{{ $message }}</small>
                                @else
                                    <small class="filament-help-text">
                                        <i class="fas fa-info-circle"></i> Kategori ini digunakan untuk berita
                                    </small>
                                @enderror
                            </div>
                        </div>

            {{-- Status --}}
            <div class="col-md-6">
                            <div class="form-group">
                                <label class="filament-form-label required-field">Status</label>
                                <select name="status" 
                                        class="filament-select @error('status') is-invalid @enderror" 
                                        required>
                                    <option value="1">Aktif</option>
                                    <option value="0">Nonaktif</option>
                                </select>
                                @error('status')
                                    <small class="text-danger">{{ $message }}</small>
                                @else
                                    <small class="filament-help-text">
                                        <i class="fas fa-info-circle"></i> Aktif dan Tidak Aktif
                                    </small>
                                @enderror
                            </div>
                        </div>

            {{-- Action --}}
            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('admin.categories.index') }}"
                   class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-100">
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
