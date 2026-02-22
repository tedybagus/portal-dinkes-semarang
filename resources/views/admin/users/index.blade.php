@extends('layouts.app')

@section('title', 'Kelola User')

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
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .filament-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }
    
    .filament-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .filament-card-body {
        padding: 1.5rem;
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
        color: white;
    }
    
    .filament-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .filament-table thead th {
        background: #f9fafb;
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #6b7280;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .filament-table tbody tr {
        border-bottom: 1px solid #f3f4f6;
        transition: background-color 0.2s;
    }
    
    .filament-table tbody tr:hover {
        background-color: #f9fafb;
    }
    
    .filament-table tbody td {
        padding: 1rem;
        font-size: 0.875rem;
    }
    
    .filament-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.375rem 0.875rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .filament-badge-success {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .filament-badge-danger {
        background-color: #fee2e2;
        color: #991b1b;
    }
    
    .filament-action-button {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.875rem;
        margin-right: 1rem;
        transition: color 0.2s;
    }
    
    .filament-action-button:hover {
        color: #764ba2;
    }
    
    .filament-action-button-delete {
        color: #ef4444;
        background: none;
        border: none;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.875rem;
        padding: 0;
        transition: color 0.2s;
    }
    
    .filament-action-button-delete:hover {
        color: #dc2626;
    }
</style>
@endpush

@section('content')
<div class="filament-page">
    <div class="container-fluid">
        {{-- Header --}}
        <div class="filament-header">
            <h1 class="filament-title">Kelola User</h1>
            <a href="{{ route('admin.users.create') }}" class="filament-button filament-button-primary">
                <i class="fas fa-plus"></i> Tambah User
            </a>
        </div>

        {{-- Alert Success --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border-left: 4px solid #10b981;">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
        @endif

        {{-- Table Card --}}
        <div class="filament-card">
            <div class="filament-card-body">
                <div class="table-responsive">
                    <table class="filament-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Bidang</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td>
                                    <div style="font-weight: 600; color: #111827;">{{ $user->name }}</div>
                                </td>
                                <td>
                                    <div style="color: #6b7280;">{{ $user->email }}</div>
                                </td>
                                <td>
                                    <div style="color: #374151;">{{ $user->role->name ?? '-' }}</div>
                                </td>
                                <td>
                                    <div style="color: #374151;">{{ $user->department->name ?? '-' }}</div>
                                </td>
                                <td>
                                    <span class="filament-badge {{ $user->is_active ? 'filament-badge-success' : 'filament-badge-danger' }}">
                                        {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="filament-action-button">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    
                                    @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="filament-action-button-delete" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus user {{ $user->name }}?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 3rem; color: #6b7280;">
                                    <i class="fas fa-users" style="font-size: 3rem; color: #d1d5db; margin-bottom: 1rem;"></i>
                                    <div style="font-weight: 600; margin-bottom: 0.5rem;">Tidak ada user</div>
                                    <div style="font-size: 0.875rem;">Mulai dengan menambahkan user pertama</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($users->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $users->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection