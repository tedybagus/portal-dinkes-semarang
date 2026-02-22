@extends('layouts.app')

@section('title', 'Galeri Images')

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
    
    /* Gallery Grid */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-top: 1rem;
    }
    
    .gallery-item {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        transition: all 0.3s;
        position: relative;
    }
    
    .gallery-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
    }
    
    .gallery-item-checkbox {
        position: absolute;
        top: 0.75rem;
        left: 0.75rem;
        width: 1.5rem;
        height: 1.5rem;
        cursor: pointer;
        accent-color: #667eea;
        z-index: 10;
    }
    
    .gallery-item.selected {
        ring: 3px solid #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.3);
    }
    
    .gallery-item-image {
        width: 100%;
        height: 220px;
        object-fit: cover;
        background: #f3f4f6;
    }
    
    .gallery-item-content {
        padding: 1rem;
    }
    
    .gallery-item-title {
        font-weight: 600;
        font-size: 0.875rem;
        color: #111827;
        margin-bottom: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .gallery-item-meta {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
        margin-bottom: 0.75rem;
    }
    
    .gallery-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.625rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .gallery-badge-gallery {
        background-color: #dbeafe;
        color: #1e40af;
    }
    
    .gallery-badge-hero {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .gallery-badge-banner {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .gallery-badge-active {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .gallery-badge-inactive {
        background-color: #fee2e2;
        color: #991b1b;
    }
    
    .gallery-item-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .gallery-action-btn {
        flex: 1;
        padding: 0.5rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.25rem;
        transition: all 0.2s;
        text-decoration: none;
    }
    
    .gallery-action-btn-edit {
        background: #fef3c7;
        color: #92400e;
    }
    
    .gallery-action-btn-edit:hover {
        background: #fde68a;
        color: #92400e;
    }
    
    .gallery-action-btn-delete {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .gallery-action-btn-delete:hover {
        background: #fecaca;
        color: #991b1b;
    }
    
    .filament-empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }
    
    .filament-empty-state-icon {
        font-size: 4rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }
    
    .filament-empty-state-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
    }
    
    .filament-empty-state-description {
        color: #6b7280;
        margin-bottom: 1.5rem;
    }
    
    /* Bulk Action Bar */
    .bulk-action-bar {
        position: fixed;
        bottom: 2rem;
        left: 50%;
        transform: translateX(-50%);
        background: white;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        display: none;
        align-items: center;
        gap: 1rem;
        z-index: 1000;
        animation: slideUp 0.3s ease-out;
    }
    
    .bulk-action-bar.active {
        display: flex;
    }
    
    @keyframes slideUp {
        from {
            transform: translateX(-50%) translateY(100%);
            opacity: 0;
        }
        to {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }
    }
    
    .bulk-action-bar-text {
        font-size: 0.875rem;
        font-weight: 600;
        color: #111827;
    }
    
    .bulk-action-bar-count {
        background: #667eea;
        color: white;
        padding: 0.25rem 0.625rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
    }
    
    /* Modal Styles */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }
    
    .modal-overlay.active {
        display: flex;
    }
    
    .modal {
        background: white;
        border-radius: 12px;
        max-width: 500px;
        width: 100%;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        animation: modalSlideIn 0.3s ease-out;
    }
    
    @keyframes modalSlideIn {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>
@endpush

@section('content')
<div class="filament-page">
    <div class="container-fluid">
        {{-- Header --}}
        <div class="filament-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="filament-title">Galeri Images</h1>
                    <p class="filament-subtitle">Kelola gambar untuk galeri, hero, dan banner website</p>
                </div>
                <a href="{{ route('admin.images.create') }}" class="filament-button filament-button-primary">
                    <i class="fas fa-plus"></i> Upload Gambar
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

        {{-- Gallery Card --}}
        <div class="filament-card">
            <div class="filament-card-header">
                <h3 class="filament-card-title">
                    <i class="fas fa-images mr-2"></i> Daftar Gambar
                </h3>
            </div>

            <div class="filament-card-body">
                {{-- Search & Filter --}}
                <form action="{{ route('admin.images.index') }}" method="GET">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="filament-search-wrapper">
                                <i class="fas fa-search filament-search-icon"></i>
                                <input type="text" 
                                       name="search" 
                                       placeholder="Cari judul gambar..." 
                                       value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="filament-select" name="type" onchange="this.form.submit()">
                                <option value="">Semua Tipe</option>
                                <option value="gallery" {{ request('type') == 'gallery' ? 'selected' : '' }}>Gallery</option>
                                <option value="hero" {{ request('type') == 'hero' ? 'selected' : '' }}>Hero</option>
                                <option value="banner" {{ request('type') == 'banner' ? 'selected' : '' }}>Banner</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="filament-select" name="status" onchange="this.form.submit()">
                                <option value="">Semua Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            @if(request('search') || request('type') || request('status'))
                                <a href="{{ route('admin.images.index') }}" class="filament-button filament-button-secondary w-100">
                                    <i class="fas fa-redo"></i> Reset
                                </a>
                            @else
                                <button type="submit" class="filament-button filament-button-primary w-100">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            @endif
                        </div>
                    </div>
                </form>

                {{-- Stats --}}
                <div style="display: flex; align-items: center; gap: 0.5rem; color: #6b7280; font-size: 0.875rem; margin-bottom: 1rem;">
                    <i class="fas fa-info-circle"></i>
                    <span>Menampilkan <strong>{{ $images->firstItem() ?? 0 }}</strong> - <strong>{{ $images->lastItem() ?? 0 }}</strong> dari <strong>{{ $images->total() }}</strong> gambar</span>
                </div>

                {{-- Gallery Grid --}}
                @if($images->count() > 0)
                <div class="gallery-grid">
                    @foreach($images as $image)
                    <div class="gallery-item" data-id="{{ $image->id }}">
                        <input type="checkbox" 
                               class="gallery-item-checkbox row-checkbox" 
                               name="selected_ids[]" 
                               value="{{ $image->id }}"
                               data-title="{{ $image->title }}">
                        
                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                             alt="{{ $image->alt_text ?? $image->title }}"
                             class="gallery-item-image">
                        
                        <div class="gallery-item-content">
                            <div class="gallery-item-title">{{ $image->title }}</div>
                            
                            <div class="gallery-item-meta">
                                <span class="gallery-badge gallery-badge-{{ $image->type }}">
                                    @if($image->type == 'gallery')
                                        <i class="fas fa-images"></i>
                                    @elseif($image->type == 'hero')
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="fas fa-flag"></i>
                                    @endif
                                    {{ ucfirst($image->type) }}
                                </span>
                                <span class="gallery-badge {{ $image->is_active ? 'gallery-badge-active' : 'gallery-badge-inactive' }}">
                                    {{ $image->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>
                            
                            <div class="gallery-item-actions">
                                <a href="{{ route('admin.images.edit', $image->id) }}" 
                                   class="gallery-action-btn gallery-action-btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button type="button"
                                        onclick="openDeleteModal({{ $image->id }}, '{{ addslashes($image->title) }}')"
                                        class="gallery-action-btn gallery-action-btn-delete">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="filament-empty-state">
                    <div class="filament-empty-state-icon">
                        <i class="fas fa-images"></i>
                    </div>
                    <div class="filament-empty-state-title">
                        @if(request('search') || request('type') || request('status'))
                            Tidak ada gambar yang sesuai
                        @else
                            Belum ada gambar
                        @endif
                    </div>
                    <div class="filament-empty-state-description">
                        @if(request('search') || request('type') || request('status'))
                            Coba ubah filter atau kata kunci pencarian
                        @else
                            Mulai dengan mengupload gambar pertama
                        @endif
                    </div>
                    @if(request('search') || request('type') || request('status'))
                        <a href="{{ route('admin.images.index') }}" class="filament-button filament-button-secondary">
                            <i class="fas fa-redo"></i> Reset Filter
                        </a>
                    @else
                        <a href="{{ route('admin.images.create') }}" class="filament-button filament-button-primary">
                            <i class="fas fa-plus"></i> Upload Gambar Pertama
                        </a>
                    @endif
                </div>
                @endif

                {{-- Pagination --}}
                @if($images->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $images->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Bulk Action Bar --}}
<div class="bulk-action-bar" id="bulkActionBar">
    <span class="bulk-action-bar-text">
        <span class="bulk-action-bar-count" id="selectedCount">0</span> gambar dipilih
    </span>
    <button type="button" class="filament-button filament-button-danger" onclick="showBulkDeleteModal()">
        <i class="fas fa-trash"></i> Hapus Semua
    </button>
    <button type="button" class="filament-button filament-button-secondary" onclick="clearSelection()">
        <i class="fas fa-times"></i> Batal
    </button>
</div>

{{-- Delete Modal --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <div style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 1.5rem; border-radius: 12px 12px 0 0;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 2.5rem; height: 2.5rem; border-radius: 50%; background: rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-trash"></i>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; margin: 0;">Hapus Gambar</h3>
                </div>
                <button type="button" onclick="closeDeleteModal()" style="background: none; border: none; color: white; cursor: pointer; font-size: 1.5rem;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            
            <div style="padding: 1.5rem;">
                <div style="text-align: center; margin-bottom: 1rem;">
                    <div style="width: 4rem; height: 4rem; border-radius: 50%; background: #fee2e2; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                        <i class="fas fa-exclamation-triangle" style="font-size: 2rem; color: #ef4444;"></i>
                    </div>
                    <p style="font-size: 1.125rem; font-weight: 600; color: #111827; margin-bottom: 0.5rem;">Hapus gambar ini?</p>
                    <p style="font-size: 0.875rem; color: #6b7280;" id="deleteImageTitle"></p>
                </div>
                
                <div style="background: #fee2e2; border: 1px solid #ef4444; border-radius: 8px; padding: 1rem;">
                    <p style="font-size: 0.875rem; color: #991b1b; margin-bottom: 0.5rem;">
                        <i class="fas fa-exclamation-circle"></i> <strong>Peringatan:</strong>
                    </p>
                    <ul style="font-size: 0.875rem; color: #991b1b; margin: 0; padding-left: 1.5rem;">
                        <li>File gambar akan dihapus permanen</li>
                        <li>Tindakan ini tidak dapat dibatalkan</li>
                    </ul>
                </div>
            </div>

            <div style="padding: 1.5rem; border-top: 1px solid #e5e7eb; background: #f9fafb; border-radius: 0 0 12px 12px; display: flex; gap: 0.75rem; justify-content: flex-end;">
                <button type="button" onclick="closeDeleteModal()" class="filament-button filament-button-secondary">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" class="filament-button filament-button-danger">
                    <i class="fas fa-trash"></i> Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Bulk Delete Modal --}}
<div class="modal-overlay" id="bulkDeleteModal">
    <div class="modal">
        <div style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 1.5rem; border-radius: 12px 12px 0 0;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 2.5rem; height: 2.5rem; border-radius: 50%; background: rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-trash"></i>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; margin: 0;">Hapus Massal</h3>
                </div>
                <button type="button" onclick="closeBulkDeleteModal()" style="background: none; border: none; color: white; cursor: pointer; font-size: 1.5rem;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <form action="{{ route('admin.images.bulk-delete') }}" method="POST">
            @csrf
            @method('DELETE')
            
            <div style="padding: 1.5rem;">
                <div style="background: #f3f4f6; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                    <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">
                        Anda akan menghapus <strong id="bulkDeleteCount">0</strong> gambar:
                    </p>
                    <ul id="bulkDeleteList" style="margin: 0; padding-left: 1.5rem; color: #111827; font-size: 0.875rem;">
                    </ul>
                </div>
                
                <div style="background: #fee2e2; border: 1px solid #ef4444; border-radius: 8px; padding: 1rem;">
                    <p style="font-size: 0.875rem; color: #991b1b; margin-bottom: 0.5rem;">
                        <i class="fas fa-exclamation-circle"></i> <strong>Peringatan:</strong>
                    </p>
                    <ul style="font-size: 0.875rem; color: #991b1b; margin: 0; padding-left: 1.5rem;">
                        <li>Semua file gambar akan dihapus permanen</li>
                        <li>Tindakan ini tidak dapat dibatalkan</li>
                    </ul>
                </div>
                <input type="hidden" name="ids" id="bulkDeleteIds">
            </div>

            <div style="padding: 1.5rem; border-top: 1px solid #e5e7eb; background: #f9fafb; border-radius: 0 0 12px 12px; display: flex; gap: 0.75rem; justify-content: flex-end;">
                <button type="button" onclick="closeBulkDeleteModal()" class="filament-button filament-button-secondary">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" class="filament-button filament-button-danger">
                    <i class="fas fa-trash"></i> Ya, Hapus Semua
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Single delete
function openDeleteModal(id, title) {
    document.getElementById('deleteImageTitle').textContent = `"${title}"`;
    document.getElementById('deleteForm').action = `{{ route("admin.images.destroy", ":id") }}`.replace(':id', id);
    document.getElementById('deleteModal').classList.add('active');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('active');
}

// Bulk selection
const checkboxes = document.querySelectorAll('.row-checkbox');
const bulkActionBar = document.getElementById('bulkActionBar');
const selectedCount = document.getElementById('selectedCount');

checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        if (this.checked) {
            this.closest('.gallery-item').classList.add('selected');
        } else {
            this.closest('.gallery-item').classList.remove('selected');
        }
        updateBulkActionBar();
    });
});

function updateBulkActionBar() {
    const selected = Array.from(checkboxes).filter(cb => cb.checked);
    selectedCount.textContent = selected.length;
    
    if (selected.length > 0) {
        bulkActionBar.classList.add('active');
    } else {
        bulkActionBar.classList.remove('active');
    }
}

function clearSelection() {
    checkboxes.forEach(cb => {
        cb.checked = false;
        cb.closest('.gallery-item').classList.remove('selected');
    });
    updateBulkActionBar();
}

function showBulkDeleteModal() {
    const selected = Array.from(checkboxes).filter(cb => cb.checked);
    const ids = selected.map(cb => cb.value);
    const titles = selected.map(cb => cb.dataset.title);
    
    document.getElementById('bulkDeleteCount').textContent = selected.length;
    document.getElementById('bulkDeleteIds').value = ids.join(',');
    
    const list = document.getElementById('bulkDeleteList');
    list.innerHTML = '';
    titles.forEach(title => {
        const li = document.createElement('li');
        li.textContent = title;
        list.appendChild(li);
    });
    
    document.getElementById('bulkDeleteModal').classList.add('active');
}

function closeBulkDeleteModal() {
    document.getElementById('bulkDeleteModal').classList.remove('active');
}

// Close modals on ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteModal();
        closeBulkDeleteModal();
    }
});

// Close modal on outside click
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.remove('active');
        }
    });
});
</script>
@endpush
@endsection