@extends('layouts.app')

@section('title', isset($pejabat) ? 'Edit Pejabat' : 'Tambah Pejabat')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/filament-style.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('content')
<div class="page-content">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <h1>
                <i class="fas fa-user-edit"></i>
                {{ isset($pejabat) ? 'Edit Pejabat Struktural' : 'Tambah Pejabat Struktural' }}
            </h1>
            <p>Formulir profil pejabat struktural</p>
        </div>
    </div>

    <!-- Back Button -->
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('admin.pejabat.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Show Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <strong>Terjadi Kesalahan:</strong>
                <ul style="margin: 0.5rem 0 0 0; padding-left: 1.25rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Form Card -->
    <div class="card">
        <div class="card-body">
            <!-- FORM TANPA KONFIRMASI (NO save-form/update-form class) -->
            <form action="{{ isset($pejabat) ? route('admin.pejabat.update', $pejabat->id) : route('admin.pejabat.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  id="pejabat-form">
                @csrf
                @if(isset($pejabat))
                    @method('PUT')
                @endif

                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
                    <!-- Left Column -->
                    <div>
                        <!-- Nama -->
                        <div class="form-group">
                            <label for="nama" class="form-label required">Nama Lengkap</label>
                            <input 
                                type="text" 
                                name="nama" 
                                id="nama" 
                                class="form-control @error('nama') is-invalid @enderror" 
                                placeholder="Contoh: Dr. Budi Santoso, M.Kes"
                                value="{{ old('nama', $pejabat->nama ?? '') }}"
                                maxlength="150"
                                required
                            >
                            @error('nama')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Jabatan -->
                        <div class="form-group">
                            <label for="jabatan" class="form-label required">Jabatan</label>
                            <input 
                                type="text" 
                                name="jabatan" 
                                id="jabatan" 
                                class="form-control @error('jabatan') is-invalid @enderror" 
                                placeholder="Contoh: Kepala Dinas Kesehatan"
                                value="{{ old('jabatan', $pejabat->jabatan ?? '') }}"
                                maxlength="150"
                                required
                            >
                            @error('jabatan')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- NIP & Pendidikan -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label for="nip" class="form-label">NIP</label>
                                <input 
                                    type="text" 
                                    name="nip" 
                                    id="nip" 
                                    class="form-control @error('nip') is-invalid @enderror" 
                                    placeholder="197001011990031001"
                                    value="{{ old('nip', $pejabat->nip ?? '') }}"
                                    maxlength="50"
                                >
                                @error('nip')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="pendidikan" class="form-label">Pendidikan Terakhir</label>
                                <input 
                                    type="text" 
                                    name="pendidikan" 
                                    id="pendidikan" 
                                    class="form-control @error('pendidikan') is-invalid @enderror" 
                                    placeholder="S2 Kesehatan Masyarakat"
                                    value="{{ old('pendidikan', $pejabat->pendidikan ?? '') }}"
                                    maxlength="100"
                                >
                                @error('pendidikan')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Riwayat Jabatan -->
                        <div class="form-group">
                            <label for="riwayat_jabatan" class="form-label">Riwayat Jabatan</label>
                            <textarea 
                                name="riwayat_jabatan" 
                                id="riwayat_jabatan" 
                                rows="4" 
                                class="form-control @error('riwayat_jabatan') is-invalid @enderror" 
                                placeholder="Kepala Puskesmas (2010-2015), Kabid P2P (2015-2020), dll..."
                            >{{ old('riwayat_jabatan', $pejabat->riwayat_jabatan ?? '') }}</textarea>
                            @error('riwayat_jabatan')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Email & Phone -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    placeholder="nama@dinkes.go.id"
                                    value="{{ old('email', $pejabat->email ?? '') }}"
                                    maxlength="100"
                                >
                                @error('email')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="phone" class="form-label">No. Telepon</label>
                                <input 
                                    type="text" 
                                    name="phone" 
                                    id="phone" 
                                    class="form-control @error('phone') is-invalid @enderror" 
                                    placeholder="081234567890"
                                    value="{{ old('phone', $pejabat->phone ?? '') }}"
                                    maxlength="20"
                                >
                                @error('phone')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Order & Status -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label for="order" class="form-label">Urutan Tampilan</label>
                                <input 
                                    type="number" 
                                    name="order" 
                                    id="order" 
                                    class="form-control @error('order') is-invalid @enderror" 
                                    placeholder="1, 2, 3, ..."
                                    value="{{ old('order', $pejabat->order ?? 0) }}"
                                    min="0"
                                >
                                @error('order')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text">
                                    <i class="fas fa-info-circle"></i> Urutan 1 = paling atas (biasanya Kepala Dinas)
                                </small>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background: #f9fafb; border-radius: 0.5rem; margin-top: 0.5rem;">
                                    <input 
                                        type="checkbox" 
                                        name="is_active" 
                                        id="is_active" 
                                        value="1"
                                        {{ old('is_active', $pejabat->is_active ?? true) ? 'checked' : '' }}
                                        style="width: 20px; height: 20px; cursor: pointer;"
                                    >
                                    <label for="is_active" style="cursor: pointer; font-weight: 500; margin: 0;">
                                        Aktif (tampilkan di halaman publik)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Photo Upload -->
                    <div>
                        <div class="form-group">
                            <label for="foto" class="form-label {{ !isset($pejabat) ? 'required' : '' }}">Foto Pejabat</label>
                            
                            <div style="border: 2px dashed #d1d5db; border-radius: 0.75rem; padding: 1.5rem; text-align: center; background: #f9fafb;">
                                @if(isset($pejabat) && $pejabat->foto)
                                    <img id="foto-preview" 
                                         src="{{ asset('storage/' . $pejabat->foto) }}" 
                                         alt="Preview"
                                         style="max-width: 100%; height: auto; border-radius: 0.5rem; max-height: 300px; margin-bottom: 1rem;">
                                @else
                                    <div id="foto-preview" style="color: #9ca3af; padding: 3rem 1rem;">
                                        <i class="fas fa-user" style="font-size: 4rem; margin-bottom: 0.5rem;"></i>
                                        <p style="margin: 0;">Belum ada foto</p>
                                    </div>
                                @endif
                            </div>

                            <input 
                                type="file" 
                                name="foto" 
                                id="foto" 
                                class="form-control @error('foto') is-invalid @enderror" 
                                accept="image/jpeg,image/png,image/jpg"
                                {{ !isset($pejabat) ? 'required' : '' }}
                                style="margin-top: 1rem;"
                            >
                            @error('foto')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                            <small class="form-text">
                                <strong>Format:</strong> JPG, PNG (Max 1MB)<br>
                                <strong>Ukuran rekomendasi:</strong> 400x400 px
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb; display: flex; gap: 1rem; align-items: center;">
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary" id="submit-btn">
                        <i class="fas fa-save"></i>
                        {{ isset($pejabat) ? 'Update Data' : 'Simpan Data' }}
                    </button>
                    
                    <!-- Cancel Button -->
                    <a href="{{ route('admin.pejabat.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    
                    <!-- Debug Info -->
                    <div style="margin-left: auto; font-size: 0.75rem; color: #6b7280;">
                        <span id="form-status">Ready</span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
console.log('Form script loaded');

// Image preview
document.getElementById('foto').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('foto-preview');
    
    if (file) {
        // Validate file size (1MB)
        if (file.size > 1048576) {
            Swal.fire({
                icon: 'error',
                title: 'File Terlalu Besar',
                text: 'Ukuran file maksimal 1MB',
                confirmButtonColor: '#3b82f6'
            });
            this.value = '';
            return;
        }
        
        // Validate file type
        if (!file.type.match('image/(jpeg|jpg|png)')) {
            Swal.fire({
                icon: 'error',
                title: 'Format File Tidak Valid',
                text: 'Hanya file JPG, JPEG, dan PNG yang diperbolehkan',
                confirmButtonColor: '#3b82f6'
            });
            this.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            if (preview.tagName === 'IMG') {
                preview.src = e.target.result;
            } else {
                const img = document.createElement('img');
                img.id = 'foto-preview';
                img.src = e.target.result;
                img.style.maxWidth = '100%';
                img.style.borderRadius = '0.5rem';
                img.style.maxHeight = '300px';
                img.style.marginBottom = '1rem';
                preview.parentNode.replaceChild(img, preview);
            }
        }
        reader.readAsDataURL(file);
    }
});

// Form submit handler with debug
const form = document.getElementById('pejabat-form');
const submitBtn = document.getElementById('submit-btn');
const statusEl = document.getElementById('form-status');

form.addEventListener('submit', function(e) {
    console.log('Form submit event triggered');
    statusEl.textContent = 'Submitting...';
    statusEl.style.color = '#3b82f6';
    
    // Disable submit button to prevent double submission
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
    
    // Let the form submit normally (no e.preventDefault())
    return true;
});

// Check for validation errors on page load
window.addEventListener('load', function() {
    const hasErrors = {{ $errors->any() ? 'true' : 'false' }};
    if (hasErrors) {
        console.log('Form has validation errors');
        statusEl.textContent = 'Validation errors';
        statusEl.style.color = '#ef4444';
        
        // Scroll to first error
        const firstError = document.querySelector('.is-invalid');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstError.focus();
        }
    }
});

// Debug: Log when scripts are ready
console.log('All scripts loaded successfully');
console.log('SweetAlert2 available:', typeof Swal !== 'undefined');
console.log('Form element:', form);
console.log('Submit button:', submitBtn);
</script>
@endpush