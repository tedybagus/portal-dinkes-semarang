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
        font-size: 0.875rem;
        font-weight: 600;
        gap: 0.5rem;
    }
    
    .filament-badge-success {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .filament-badge-warning {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .filament-badge-danger {
        background-color: #fee2e2;
        color: #991b1b;
    }
    
    .filament-badge-info {
        background-color: #dbeafe;
        color: #1e40af;
    }
    
    .filament-action-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 2rem;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        margin: 0 0.125rem;
    }
    
    .filament-action-button-view {
        background-color: #dbeafe;
        color: #1e40af;
    }
    
    .filament-action-button-view:hover {
        background-color: #bfdbfe;
    }
    
    .filament-action-button-edit {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .filament-action-button-edit:hover {
        background-color: #fde68a;
    }
    
    .filament-action-button-delete {
        background-color: #fee2e2;
        color: #991b1b;
    }
    
    .filament-action-button-delete:hover {
        background-color: #fecaca;
    }
    
    .filament-stats {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #6b7280;
        font-size: 0.875rem;
        margin-bottom: 1rem;
    }
    
    /* Modal Styles */
    .filament-modal-overlay {
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
    }
    
    .filament-modal-overlay.active {
        display: flex;
    }
    
    .filament-modal {
        background: white;
        border-radius: 12px;
        width: 90%;
        max-width: 500px;
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
    
    .filament-modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .filament-modal-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #111827;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .filament-modal-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        background-color: #fee2e2;
        color: #dc2626;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    
    .filament-modal-body {
        padding: 1.5rem;
    }
    
    .filament-modal-message {
        color: #6b7280;
        font-size: 0.875rem;
        line-height: 1.5;
    }
    
    .filament-modal-footer {
        padding: 1.5rem;
        border-top: 1px solid #e5e7eb;
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
    }
    
    .filament-button-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }
    
    .filament-button-danger:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
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
    <div class="filament-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="filament-title">Kelola Artikel</h1>
                    <p class="filament-subtitle">Kelola semua artikel berita</p>
                </div>
                <div>
                    <a href="{{ route('author.articles.create') }}" class="filament-button filament-button-primary">
                        <i class="fas fa-plus"></i> Tambah Artikel
                    </a>
                </div>
            </div>
        </div>

    <div class="space-y-6">
        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
            <div class="flex">
                <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
</svg>
<p class="ml-3 text-sm text-green-700">{{ session('success') }}</p>
</div>
</div>
@endif
@if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
        <div class="flex">
            <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <p class="ml-3 text-sm text-red-700">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <!-- Articles Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reviewer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($articles as $article)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($article->image)
                                    <img src="{{ Storage::url($article->image) }}" alt="" class="h-12 w-12 rounded object-cover mr-3">
                                    @endif
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ Str::limit($article->title, 50) }}</p>
                                        @if($article->status === 'rejected' && $article->rejection_reason)
                                        <p class="text-xs text-red-600 mt-1 bg-red-50 px-2 py-1 rounded">
                                            <i class="fas fa-exclamation-circle"></i> {{ Str::limit($article->rejection_reason, 60) }}
                                        </p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                    {{ $article->category->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                    @if($article->status === 'published') bg-green-100 text-green-800
                                    @elseif($article->status === 'approved') bg-blue-100 text-blue-800
                                    @elseif($article->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    @if($article->status === 'published')
                                        <i class="fas fa-globe"></i> Published
                                    @elseif($article->status === 'approved')
                                        <i class="fas fa-check"></i> Approved
                                    @elseif($article->status === 'pending')
                                        <i class="fas fa-clock"></i> Pending
                                    @else
                                        <i class="fas fa-times"></i> Rejected
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $article->reviewer ? $article->reviewer->name : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $article->article_date->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                @if(in_array($article->status, ['pending', 'rejected']))
                                <a href="{{ route('author.articles.edit', $article) }}" class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                
                                <form action="{{ route('author.articles.destroy', $article) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Hapus artikel ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                                @else
                                <span class="text-gray-400 text-xs">
                                    <i class="fas fa-lock"></i> Tidak dapat diedit
                                </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                        <i class="fas fa-pen text-gray-400 text-2xl"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">Belum ada artikel</p>
                                    <p class="text-sm text-gray-400 mt-1">Mulai tulis artikel pertama Anda!</p>
                                    <a href="{{ route('author.articles.create') }}" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                        <i class="fas fa-plus mr-2"></i> Tulis Artikel
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
</div>
@endsection