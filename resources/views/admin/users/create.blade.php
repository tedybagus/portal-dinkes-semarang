@extends('layouts.app')

@section('title', isset($user) ? 'Edit User' : 'Tambah User')

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
    
    .filament-input, .filament-select {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 0.625rem 1rem;
        font-size: 0.875rem;
        transition: all 0.2s;
        width: 100%;
    }
    
    .filament-input:focus, .filament-select:focus {
        background: white;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }
    
    .filament-input.is-invalid, .filament-select.is-invalid {
        border-color: #ef4444;
    }
    
    .filament-help-text {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 0.25rem;
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
</style>
@endpush

@section('content')
<div class="filament-page">
    <div class="container-fluid">
        {{-- Back Button --}}
        <div class="mb-3">
            <a href="{{ route('admin.users.index') }}" class="filament-button filament-button-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        {{-- Header --}}
        <div class="filament-header">
            <div>
                <h1 class="filament-title">{{ isset($user) ? 'Edit User' : 'Tambah User' }}</h1>
                <p class="filament-subtitle">{{ isset($user) ? 'Ubah data user' : 'Tambahkan user baru ke sistem' }}</p>
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
                    <i class="fas fa-user mr-2"></i> {{ isset($user) ? 'Form Edit User' : 'Form Tambah User' }}
                </h3>
            </div>

            <form action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}" method="POST">
                @csrf
                @if(isset($user))
                    @method('PUT')
                @endif
                
                <div class="filament-card-body">
                    <div class="row">
                        {{-- Name --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="filament-form-label required-field">Nama Lengkap</label>
                                <input type="text" 
                                       name="name" 
                                       class="filament-input @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $user->name ?? '') }}"
                                       placeholder="Masukkan nama lengkap"
                                       required>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="filament-form-label required-field">Email</label>
                                <input type="email" 
                                       name="email" 
                                       class="filament-input @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $user->email ?? '') }}"
                                       placeholder="user@example.com"
                                       required>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @else
                                    <small class="filament-help-text">
                                        <i class="fas fa-info-circle"></i> Email akan digunakan untuk login
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Password --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="filament-form-label {{ isset($user) ? '' : 'required-field' }}">
                                    Password {{ isset($user) ? '(kosongkan jika tidak diubah)' : '' }}
                                </label>
                                <input type="password" 
                                       name="password" 
                                       class="filament-input @error('password') is-invalid @enderror" 
                                       placeholder="Masukkan password"
                                       {{ isset($user) ? '' : 'required' }}>
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @else
                                    <small class="filament-help-text">
                                        <i class="fas fa-lock"></i> Minimal 8 karakter
                                    </small>
                                @enderror
                            </div>
                        </div>

                        {{-- Password Confirmation --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="filament-form-label {{ isset($user) ? '' : 'required-field' }}">Konfirmasi Password</label>
                                <input type="password" 
                                       name="password_confirmation" 
                                       class="filament-input" 
                                       placeholder="Ulangi password"
                                       {{ isset($user) ? '' : 'required' }}>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Role --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="filament-form-label required-field">Role</label>
                                <select name="role_id" class="filament-select @error('role_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Role --</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('role_id', $user->role_id ?? '') == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @else
                                    <small class="filament-help-text">
                                        <i class="fas fa-user-tag"></i> Tentukan hak akses user
                                    </small>
                                @enderror
                            </div>
                        </div>

                        {{-- Department --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="filament-form-label required-field">Bidang</label>
                                <select name="department_id" class="filament-select @error('department_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Bidang --</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}" {{ old('department_id', $user->department_id ?? '') == $dept->id ? 'selected' : '' }}>
                                            {{ $dept->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @else
                                    <small class="filament-help-text">
                                        <i class="fas fa-building"></i> Bidang/departemen user
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Is Active --}}
                    <div class="form-group">
                        <div class="filament-checkbox-wrapper">
                            <input type="checkbox" 
                                   name="is_active" 
                                   id="is_active"
                                   class="filament-checkbox" 
                                   value="1"
                                   {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}>
                            <label for="is_active" class="filament-form-label mb-0">
                                User Aktif
                            </label>
                        </div>
                        <small class="filament-help-text">
                            <i class="fas fa-info-circle"></i> User tidak aktif tidak bisa login ke sistem
                        </small>
                    </div>
                </div>

                <div class="filament-card-footer">
                    <button type="submit" class="filament-button filament-button-primary">
                        <i class="fas fa-save"></i> {{ isset($user) ? 'Update Data' : 'Simpan Data' }}
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="filament-button filament-button-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection