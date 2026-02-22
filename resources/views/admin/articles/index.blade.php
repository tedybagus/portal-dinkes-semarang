@extends('layouts.app')

@section('title', 'Kelola Artikel')

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
    
    .filament-badge-info {
        background-color: #dbeafe;
        color: #1e40af;
    }
    
    .filament-badge-warning {
        background-color: #fef3c7;
        color: #92400e;
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
        margin-right: 0.75rem;
        transition: color 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .filament-action-button:hover {
        color: #764ba2;
    }
    
    .filament-action-button-publish {
        color: #10b981;
    }
    
    .filament-action-button-publish:hover {
        color: #059669;
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
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .filament-action-button-delete:hover {
        color: #dc2626;
    }
    
    .filament-stats {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #6b7280;
        font-size: 0.875rem;
        margin-bottom: 1rem;
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
</style>
@endpush

@section('content')
<div class="filament-page">
    <div class="container-fluid">
        {{-- Header --}}
        <div class="filament-header">
            <div>
                <h1 class="filament-title">Kelola Artikel</h1>
                <p class="filament-subtitle">Manajemen artikel dan publikasi</p>
            </div>
            <a href="{{ route('admin.articles.create') }}" class="filament-button filament-button-primary">
                <i class="fas fa-plus"></i> Tambah Artikel
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

        {{-- Alert Error --}}
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; border-left: 4px solid #ef4444;">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
        @endif

        {{-- Table Card --}}
        <div class="filament-card">
            <div class="filament-card-header">
                <h3 class="filament-card-title">
                    <i class="fas fa-newspaper mr-2"></i> Daftar Artikel
                </h3>
            </div>

            <div class="filament-card-body">
                {{-- Search & Filter --}}
                <form action="{{ route('admin.articles.index') }}" method="GET">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="filament-search-wrapper">
                                <i class="fas fa-search filament-search-icon"></i>
                                <input type="text" 
                                       name="search" 
                                       placeholder="Cari judul artikel..." 
                                       value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="filament-select" name="status" onchange="this.form.submit()">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="filament-select" name="category" onchange="this.form.submit()">
                                <option value="">Semua Kategori</option>
                                @foreach($categories ?? [] as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            @if(request('search') || request('status') || request('category'))
                                <a href="{{ route('admin.articles.index') }}" class="filament-button filament-button-secondary w-100">
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
                <div class="filament-stats">
                    <i class="fas fa-info-circle"></i>
                    <span>Menampilkan <strong>{{ $articles->firstItem() ?? 0 }}</strong> - <strong>{{ $articles->lastItem() ?? 0 }}</strong> dari <strong>{{ $articles->total() }}</strong> artikel</span>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="filament-table">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Kategori</th>
                                <th>Bidang</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th style="width: 200px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($articles as $article)
                            <tr>
                                <td>
                                    <div style="font-weight: 600; color: #111827;">
                                        {{ Str::limit($article->title, 50) }}
                                    </div>
                                </td>
                                <td>
                                    <div style="color: #6b7280;">{{ $article->author->name ?? '-' }}</div>
                                </td>
                                <td>
                                    <div style="color: #374151;">{{ $article->category->name ?? '-' }}</div>
                                </td>
                                <td>
                                    <div style="color: #374151;">{{ $article->department->name ?? '-' }}</div>
                                </td>
                                <td>
                                    <span class="filament-badge 
                                        @if($article->status === 'published') filament-badge-success
                                        @elseif($article->status === 'approved') filament-badge-info
                                        @elseif($article->status === 'pending') filament-badge-warning
                                        @else filament-badge-danger
                                        @endif">
                                        {{ ucfirst($article->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div style="color: #6b7280;">
                                        {{ $article->article_date ? $article->article_date->format('d M Y') : '-' }}
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.articles.show', $article->id) }}" class="filament-action-button">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                    <a href="{{ route('admin.articles.edit', $article->id) }}" class="filament-action-button">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    
                                    @if($article->status === 'approved')
                                    <button 
                                        type="button"
                                        onclick="openPublishModal({{ $article->id }}, '{{ addslashes($article->title) }}')"
                                        class="filament-action-button filament-action-button-publish"
                                    >
                                        <i class="fas fa-paper-plane"></i> Publish
                                    </button>
                                    @endif

                                    <button 
                                        type="button"
                                        onclick="openDeleteModal({{ $article->id }}, '{{ addslashes($article->title) }}')"
                                        class="filament-action-button-delete"
                                    >
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">
                                    <div class="filament-empty-state">
                                        <div class="filament-empty-state-icon">
                                            <i class="fas fa-newspaper"></i>
                                        </div>
                                        <div class="filament-empty-state-title">
                                            @if(request('search') || request('status') || request('category'))
                                                Tidak ada artikel yang sesuai
                                            @else
                                                Belum ada artikel
                                            @endif
                                        </div>
                                        <div class="filament-empty-state-description">
                                            @if(request('search') || request('status') || request('category'))
                                                Coba ubah filter atau kata kunci pencarian
                                            @else
                                                Mulai dengan menambahkan artikel pertama
                                            @endif
                                        </div>
                                        @if(request('search') || request('status') || request('category'))
                                            <a href="{{ route('admin.articles.index') }}" class="filament-button filament-button-secondary">
                                                <i class="fas fa-redo"></i> Reset Filter
                                            </a>
                                        @else
                                            <a href="{{ route('admin.articles.create') }}" class="filament-button filament-button-primary">
                                                <i class="fas fa-plus"></i> Tambah Artikel Pertama
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($articles->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $articles->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Publish Modal --}}
<div id="publishModal" class="modal-overlay" style="display: none;">
    <div class="modal">
        <div class="modal-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 1.5rem; border-radius: 12px 12px 0 0;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 2.5rem; height: 2.5rem; border-radius: 50%; background: rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; margin: 0;">Publikasikan Artikel</h3>
                </div>
                <button type="button" onclick="closePublishModal()" style="background: none; border: none; color: white; cursor: pointer; font-size: 1.5rem;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <form id="publishForm" method="POST">
            @csrf
            
            <div style="padding: 1.5rem;">
                <div style="text-align: center; margin-bottom: 1rem;">
                    <div style="width: 4rem; height: 4rem; border-radius: 50%; background: #d1fae5; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                        <i class="fas fa-globe" style="font-size: 2rem; color: #10b981;"></i>
                    </div>
                    <p style="font-size: 1.125rem; font-weight: 600; color: #111827; margin-bottom: 0.5rem;">Publikasikan artikel ini?</p>
                    <p style="font-size: 0.875rem; color: #6b7280;" id="publishArticleTitle"></p>
                </div>
                
                <div style="background: #d1fae5; border: 1px solid #10b981; border-radius: 8px; padding: 1rem;">
                    <p style="font-size: 0.875rem; color: #065f46; margin-bottom: 0.5rem;">
                        <i class="fas fa-info-circle"></i> <strong>Perhatian:</strong>
                    </p>
                    <ul style="font-size: 0.875rem; color: #065f46; margin: 0; padding-left: 1.5rem;">
                        <li>Artikel akan langsung tayang ke publik</li>
                        <li>Pastikan konten sudah benar dan final</li>
                    </ul>
                </div>
            </div>

            <div style="padding: 1.5rem; border-top: 1px solid #e5e7eb; background: #f9fafb; border-radius: 0 0 12px 12px; display: flex; gap: 0.75rem; justify-content: flex-end;">
                <button type="button" onclick="closePublishModal()" class="filament-button filament-button-secondary">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" class="filament-button" style="background: #10b981; color: white;">
                    <i class="fas fa-check"></i> Ya, Publikasikan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Delete Modal --}}
<div id="deleteModal" class="modal-overlay" style="display: none;">
    <div class="modal">
        <div class="modal-header" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 1.5rem; border-radius: 12px 12px 0 0;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 2.5rem; height: 2.5rem; border-radius: 50%; background: rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-trash"></i>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; margin: 0;">Hapus Artikel</h3>
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
                    <p style="font-size: 1.125rem; font-weight: 600; color: #111827; margin-bottom: 0.5rem;">Hapus artikel ini?</p>
                    <p style="font-size: 0.875rem; color: #6b7280;" id="deleteArticleTitle"></p>
                </div>
                
                <div style="background: #fee2e2; border: 1px solid #ef4444; border-radius: 8px; padding: 1rem;">
                    <p style="font-size: 0.875rem; color: #991b1b; margin-bottom: 0.5rem;">
                        <i class="fas fa-exclamation-circle"></i> <strong>Peringatan:</strong>
                    </p>
                    <ul style="font-size: 0.875rem; color: #991b1b; margin: 0; padding-left: 1.5rem;">
                        <li>Data artikel akan dihapus permanen</li>
                        <li>Tindakan ini tidak dapat dibatalkan</li>
                    </ul>
                </div>
            </div>

            <div style="padding: 1.5rem; border-top: 1px solid #e5e7eb; background: #f9fafb; border-radius: 0 0 12px 12px; display: flex; gap: 0.75rem; justify-content: flex-end;">
                <button type="button" onclick="closeDeleteModal()" class="filament-button filament-button-secondary">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" class="filament-button" style="background: #ef4444; color: white;">
                    <i class="fas fa-trash"></i> Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .modal-overlay {
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
    
    .modal {
        background: white;
        border-radius: 12px;
        max-width: 500px;
        width: 100%;
        margin: 0 auto;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }
</style>

@push('scripts')
<script>
    function openPublishModal(articleId, articleTitle) {
        const modal = document.getElementById('publishModal');
        const form = document.getElementById('publishForm');
        const titleElement = document.getElementById('publishArticleTitle');
        
        form.action = `/admin/articles/${articleId}/publish`;
        titleElement.textContent = `"${articleTitle}"`;
        
        modal.style.display = 'flex';
    }

    function closePublishModal() {
        document.getElementById('publishModal').style.display = 'none';
    }

    function openDeleteModal(articleId, articleTitle) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        const titleElement = document.getElementById('deleteArticleTitle');
        
        form.action = `/admin/articles/${articleId}`;
        titleElement.textContent = `"${articleTitle}"`;
        
        modal.style.display = 'flex';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    // Close modal on Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closePublishModal();
            closeDeleteModal();
        }
    });

    // Close modal when clicking outside
    document.getElementById('publishModal')?.addEventListener('click', function(event) {
        if (event.target === this) {
            closePublishModal();
        }
    });

    document.getElementById('deleteModal')?.addEventListener('click', function(event) {
        if (event.target === this) {
            closeDeleteModal();
        }
    });
</script>
@endpush
@endsection