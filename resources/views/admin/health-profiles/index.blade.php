@extends('layouts.app')

@section('title', 'Profil Kesehatan')

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
    
    .filament-search-wrapper {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        display: flex;
        align-items: center;
        padding: 0.5rem 1rem;
        transition: all 0.2s;
    }
    
    .filament-search-wrapper:focus-within {
        background: white;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .filament-search-wrapper input {
        border: none;
        background: transparent;
        width: 100%;
        outline: none;
        font-size: 0.875rem;
    }
    
    .filament-search-icon {
        color: #9ca3af;
        margin-right: 0.5rem;
    }
    
    .filament-select {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 0.625rem 1rem;
        font-size: 0.875rem;
        transition: all 0.2s;
        width: 100%;
    }
    
    .filament-select:focus {
        background: white;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
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
    
    .filament-button-secondary {
        background: #f3f4f6;
        color: #374151;
    }
    
    .filament-button-secondary:hover {
        background: #e5e7eb;
        color: #374151;
    }
    
    .filament-button-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }
    
    .filament-button-danger:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        color: white;
    }
</style>
@endpush
@section('content')
<div class="filament-page">
    <div class="container-fluid">
        <div class="filament-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="filament-title">Profil Kesehatan</h1>
                    <p class="filament-subtitle">Profil Kesehatan Dinas Kesehatan Kabupaten Semarang</p>
                </div>
                <a href="{{ route('admin.health-profiles.create') }}" class="filament-button filament-button-primary">
                    <i class="fas fa-plus"></i> Upload File
                </a>
            </div>
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

        {{-- Alert Error --}}
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; border-left: 4px solid #ef4444;">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
        @endif
        <div class="filament-card-body">
                 <table class="w-full text-sm">
        <thead class="bg-gray-50">
        <tr>
            <th class="px-4 py-2">No</th>
            <th>Nama</th>
            <th>File</th>
            <th class="text-center">Aksi</th>
        </tr>
        </thead>
        <tbody>
        @foreach($profiles as $i => $profile)
            <tr class="border-t">
                <td class="px-4 py-2">{{ $i + 1 }}</td>
                <td>{{ $profile->name }}</td>
                <td>
                    @if(in_array($profile->file_type, ['jpg','jpeg','png']))
                        <img src="{{ asset('storage/'.$profile->file_path) }}"
                             class="h-12 rounded">
                    @else
                        <span class="text-red-600">PDF</span>
                    @endif
                </td>
                <td class="text-center space-x-2">
                 
        {{-- PREVIEW --}}
        <a href="{{ asset('storage/'.$profile->file_path) }}"
           target="_blank"
           class="text-blue-600 hover:text-blue-900">
           <i class="fas fa-eye"></i> Preview
        </a>

        {{-- EDIT --}}
         <a href="{{ route('admin.health-profiles.edit', $profile) }}" class="text-indigo-600 hover:text-indigo-900">
        <i class="fas fa-edit"></i> Edit</a>

        {{-- DOWNLOAD --}}
        <a href="{{ route('admin.health-profiles.download', $profile) }}"
           class="text-green-600 hover:text-green-900">
            <i class="fas fa-paper-plane"></i> Download
        </a>

        {{-- DELETE --}}
        <button
            onclick="openDeleteModal({{ $profile->id }}, '{{ $profile->name }}')"
            class="text-red-600 hover:text-red-900">
            <i class="fas fa-trash"></i> Hapus
        </button>
     
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
        <div id="deleteModal"
     class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

    <div class="bg-white rounded-2xl w-full max-w-md p-6 space-y-4">
        <h2 class="text-lg font-semibold text-gray-800">
            Hapus Data?
        </h2>

        <p class="text-sm text-gray-600">
            Anda yakin ingin menghapus
            <span id="deleteName" class="font-medium text-gray-800"></span>?
            Tindakan ini tidak dapat dibatalkan.
        </p>

        <form id="deleteForm" method="POST" class="flex justify-end gap-2">
            @csrf
            @method('DELETE')

            <button type="button"
                    onclick="closeDeleteModal()"
                    class="px-4 py-2 rounded-xl border">
                Batal
            </button>

            <button type="submit"
                    class="px-4 py-2 rounded-xl bg-red-600 text-white hover:bg-red-700">
                Ya, Hapus
            </button>
        </form>
    </div>
</div>

</div>
    </div>
</div>
 @push('scripts')
<script>
    function openDeleteModal(id, name) {
        document.getElementById('deleteName').innerText = name;
        document.getElementById('deleteForm').action =
            `/admin/health-profiles/${id}`;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.remove('flex');
    }
</script>
@endpush
@endsection