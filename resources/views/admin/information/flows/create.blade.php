@extends('layouts.app')

@section('title', isset($flow) ? 'Edit Alur Permohonan' : 'Tambah Alur Permohonan')

@section('content')
<div class="page-header">
    <h1>{{ isset($flow) ? 'Edit' : 'Tambah' }} Alur Permohonan</h1>
    <a href="{{ route('admin.information-flows.index') }}" class="btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="form-card">
    <form action="{{ isset($flow) ? route('admin.information-flows.update', $flow->id) : route('admin.information-flows.store') }}" method="POST">
        @csrf
        @if(isset($flow))
            @method('PUT')
        @endif

        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="title" class="form-label required">Judul Langkah</label>
                    <input 
                        type="text" 
                        name="title" 
                        id="title" 
                        class="form-control @error('title') is-invalid @enderror" 
                        value="{{ old('title', $flow->title ?? '') }}"
                        placeholder="Contoh: Pengajuan Permohonan"
                        required
                    >
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description" class="form-label required">Deskripsi</label>
                    <textarea 
                        name="description" 
                        id="description" 
                        class="form-control @error('description') is-invalid @enderror"
                        rows="5"
                        placeholder="Jelaskan detail langkah ini..."
                        required
                    >{{ old('description', $flow->description ?? '') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="step_number" class="form-label required">Nomor Urut</label>
                    <input 
                        type="number" 
                        name="step_number" 
                        id="step_number" 
                        class="form-control @error('step_number') is-invalid @enderror" 
                        value="{{ old('step_number', $flow->step_number ?? '') }}"
                        min="1"
                        required
                    >
                    @error('step_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text">Urutan langkah (1, 2, 3, ...)</small>
                </div>

                <div class="form-group">
                    <label for="icon" class="form-label">Icon (Font Awesome)</label>
                    <input 
                        type="text" 
                        name="icon" 
                        id="icon" 
                        class="form-control @error('icon') is-invalid @enderror" 
                        value="{{ old('icon', $flow->icon ?? '') }}"
                        placeholder="fa-file-alt"
                    >
                    @error('icon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text">Contoh: fa-file-alt, fa-check-circle</small>
                </div>

                <div class="form-group">
                    <label for="duration_days" class="form-label">Estimasi Durasi (Hari)</label>
                    <input 
                        type="number" 
                        name="duration_days" 
                        id="duration_days" 
                        class="form-control @error('duration_days') is-invalid @enderror" 
                        value="{{ old('duration_days', $flow->duration_days ?? '') }}"
                        min="1"
                    >
                    @error('duration_days')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Status</label>
                    <div class="form-check">
                        <input 
                            type="checkbox" 
                            name="is_active" 
                            id="is_active" 
                            class="form-check-input" 
                            value="1"
                            {{ old('is_active', $flow->is_active ?? true) ? 'checked' : '' }}
                        >
                        <label for="is_active" class="form-check-label">
                            Aktif (tampilkan di halaman publik)
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> {{ isset($flow) ? 'Update' : 'Simpan' }}
            </button>
            <a href="{{ route('admin.information-flows.index') }}" class="btn-secondary">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>

<div class="help-card">
    <h4><i class="fas fa-info-circle"></i> Panduan Pengisian</h4>
    <ul>
        <li><strong>Nomor Urut:</strong> Tentukan urutan langkah (1 untuk langkah pertama, 2 untuk kedua, dst)</li>
        <li><strong>Icon:</strong> Gunakan class Font Awesome tanpa "fas" (contoh: fa-file-alt)</li>
        <li><strong>Durasi:</strong> Estimasi waktu dalam hari kerja untuk menyelesaikan langkah ini</li>
    </ul>
</div>

<style>
.row {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
}

.help-card {
    background: #eff6ff;
    border-left: 4px solid #3b82f6;
    padding: 1.5rem;
    border-radius: 8px;
    margin-top: 2rem;
}

.help-card h4 {
    color: #1e40af;
    margin-bottom: 1rem;
}

.help-card ul {
    margin: 0;
    padding-left: 1.5rem;
}

.help-card li {
    color: #1e40af;
    margin-bottom: 0.5rem;
}

@media (max-width: 768px) {
    .row {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection