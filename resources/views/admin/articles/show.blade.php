@extends('layouts.app')

@section('title', 'Detail Artikel')

@push('styles')
<style>
    body { background-color: #f9fafb; }
    
    .article-container { max-width: 1200px; margin: 0 auto; padding: 1.5rem; }
    
    /* Hero */
    .article-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2.5rem;
        border-radius: 12px;
        color: white;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .article-hero-title { font-size: 2rem; font-weight: 700; margin-bottom: 1.5rem; line-height: 1.2; }
    
    .article-hero-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }
    
    .meta-item { display: flex; align-items: center; gap: 0.75rem; }
    
    .meta-icon {
        width: 2.5rem;
        height: 2.5rem;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .meta-label { font-size: 0.75rem; opacity: 0.9; margin-bottom: 0.125rem; }
    .meta-value { font-size: 0.875rem; font-weight: 600; }
    
    /* Content */
    .content-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    
    .content-card-body { padding: 1.5rem; }
    
    .article-image { width: 100%; max-height: 500px; object-fit: cover; border-radius: 8px; }
    
    .article-content {
        font-size: 1rem;
        line-height: 1.7;
        color: #374151;
    }
    
    .article-content table { width: 100%; border-collapse: collapse; margin: 1rem 0; }
    .article-content table th,
    .article-content table td { border: 1px solid #e5e7eb; padding: 0.75rem; }
    .article-content table th { background-color: #f9fafb; font-weight: 600; }
    
    .article-meta-footer {
        padding: 1rem 1.5rem;
        background: #f9fafb;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        font-size: 0.875rem;
        color: #6b7280;
    }
    
    /* Decision */
    .decision-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .decision-header { padding: 1.5rem; border-bottom: 1px solid #e5e7eb; }
    .decision-title { font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0; }
    .decision-subtitle { font-size: 0.875rem; color: #6b7280; margin-top: 0.25rem; }
    .decision-body { padding: 1.5rem; }
    
    .action-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
    }
    
    .action-box {
        border: 2px solid;
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.2s;
    }
    
    .action-box-publish { border-color: #d1fae5; }
    .action-box-publish:hover { border-color: #10b981; }
    .action-box-edit { border-color: #fef3c7; }
    .action-box-edit:hover { border-color: #f59e0b; }
    .action-box-unpublish { border-color: #fee2e2; }
    .action-box-unpublish:hover { border-color: #ef4444; }
    
    .action-header { display: flex; align-items: center; margin-bottom: 1rem; }
    
    .action-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: white;
    }
    
    .action-icon-publish { background: #10b981; }
    .action-icon-edit { background: #f59e0b; }
    .action-icon-unpublish { background: #ef4444; }
    
    .action-text { margin-left: 1rem; }
    .action-title { font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0; }
    .action-description { font-size: 0.875rem; color: #6b7280; margin: 0; }
    
    .action-button {
        width: 100%;
        padding: 0.875rem;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
    }
    
    .action-button-publish { background: #10b981; color: white; }
    .action-button-publish:hover { background: #059669; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4); }
    .action-button-edit { background: #f59e0b; color: white; }
    .action-button-edit:hover { background: #d97706; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4); color: white; }
    .action-button-unpublish { background: #ef4444; color: white; }
    .action-button-unpublish:hover { background: #dc2626; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4); }
    
    .action-info {
        margin-top: 1rem;
        padding: 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
    }
    
    .action-info-publish { background: #d1fae5; border: 1px solid #10b981; color: #065f46; }
    .action-info-edit { background: #fef3c7; border: 1px solid #f59e0b; color: #92400e; }
    .action-info-unpublish { background: #fee2e2; border: 1px solid #ef4444; color: #991b1b; }
    
    /* Modal */
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
    
    .modal-overlay.active { display: flex; }
    
    .modal {
        background: white;
        border-radius: 12px;
        max-width: 500px;
        width: 100%;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        animation: modalSlideIn 0.3s ease-out;
    }
    
    @keyframes modalSlideIn {
        from { transform: translateY(-20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    .modal-header { padding: 1.5rem; border-bottom: 1px solid #e5e7eb; }
    .modal-header-success { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border-radius: 12px 12px 0 0; }
    .modal-header-danger { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border-radius: 12px 12px 0 0; }
    
    .modal-title-wrapper { display: flex; align-items: center; justify-content: space-between; }
    .modal-title-content { display: flex; align-items: center; gap: 0.75rem; }
    
    .modal-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    
    .modal-title { font-size: 1.25rem; font-weight: 700; margin: 0; }
    .modal-subtitle { font-size: 0.875rem; margin: 0; opacity: 0.9; }
    .modal-close { background: none; border: none; color: white; cursor: pointer; padding: 0.5rem; font-size: 1.5rem; }
    .modal-body { padding: 1.5rem; }
    .modal-footer {
        padding: 1.5rem;
        border-top: 1px solid #e5e7eb;
        background: #f9fafb;
        border-radius: 0 0 12px 12px;
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
    }
    
    .btn-modal {
        padding: 0.625rem 1rem;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-cancel { background: #f3f4f6; color: #374151; }
    .btn-cancel:hover { background: #e5e7eb; }
    .btn-confirm-publish { background: #10b981; color: white; }
    .btn-confirm-publish:hover { background: #059669; }
    .btn-confirm-unpublish { background: #ef4444; color: white; }
    .btn-confirm-unpublish:hover { background: #dc2626; }
</style>
@endpush

@section('content')
<div class="article-container">
    {{-- Hero Header --}}
    <div class="article-hero">
        <h1 class="article-hero-title">{{ $article->title }}</h1>
        
        <div class="article-hero-meta">
            <div class="meta-item">
                <div class="meta-icon"><i class="fas fa-user"></i></div>
                <div>
                    <div class="meta-label">Penulis</div>
                    <div class="meta-value">{{ $article->user->name ?? 'Unknown' }}</div>
                </div>
            </div>
            
            <div class="meta-item">
                <div class="meta-icon"><i class="fas fa-folder"></i></div>
                <div>
                    <div class="meta-label">Kategori</div>
                    <div class="meta-value">{{ $article->category->name ?? '-' }}</div>
                </div>
            </div>
            
            <div class="meta-item">
                <div class="meta-icon"><i class="fas fa-building"></i></div>
                <div>
                    <div class="meta-label">Bidang</div>
                    <div class="meta-value">{{ $article->department->name ?? 'P2P' }}</div>
                </div>
            </div>
            
            <div class="meta-item">
                <div class="meta-icon"><i class="fas fa-calendar"></i></div>
                <div>
                    <div class="meta-label">Tanggal Artikel</div>
                    <div class="meta-value">{{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Article Content --}}
    <div class="content-card">
        @if($article->image)
        <div class="content-card-body">
            <img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}" class="article-image">
        </div>
        @endif

        <div class="content-card-body">
            <div class="article-content">{!! $article->content !!}</div>
        </div>

        <div class="article-meta-footer">
            <div><i class="far fa-clock"></i> Dibuat pada {{ $article->created_at->format('d M Y H:i') }}</div>
            <div><i class="fas fa-file-alt"></i> Slug: <code style="background: #f3f4f6; padding: 0.25rem 0.5rem; border-radius: 4px;">{{ $article->slug }}</code></div>
        </div>
    </div>

    {{-- Decision/Action Section --}}
    <div class="decision-card">
        <div class="decision-header">
            <h3 class="decision-title">Aksi Artikel</h3>
            <p class="decision-subtitle">Pilih salah satu: publish, edit, atau unpublish artikel ini</p>
        </div>

        <div class="decision-body">
            <div class="action-grid">
                {{-- Publish/Unpublish --}}
                @if($article->status == 'draft')
                <div class="action-box action-box-publish">
                    <div class="action-header">
                        <div class="action-icon action-icon-publish"><i class="fas fa-check"></i></div>
                        <div class="action-text">
                            <h4 class="action-title">Publish Artikel</h4>
                            <p class="action-description">Artikel memenuhi standar</p>
                        </div>
                    </div>
                    <button type="button" onclick="showPublishModal()" class="action-button action-button-publish">
                        <i class="fas fa-thumbs-up"></i><span>Publish Artikel</span>
                    </button>
                    <div class="action-info action-info-publish">
                        <i class="fas fa-info-circle"></i> Artikel akan dipublikasikan dan dapat dilihat oleh publik
                    </div>
                </div>
                @else
                <div class="action-box action-box-unpublish">
                    <div class="action-header">
                        <div class="action-icon action-icon-unpublish"><i class="fas fa-times"></i></div>
                        <div class="action-text">
                            <h4 class="action-title">Unpublish Artikel</h4>
                            <p class="action-description">Perlu perbaikan</p>
                        </div>
                    </div>
                    <button type="button" onclick="showUnpublishModal()" class="action-button action-button-unpublish">
                        <i class="fas fa-ban"></i><span>Unpublish Artikel</span>
                    </button>
                    <div class="action-info action-info-unpublish">
                        <i class="fas fa-exclamation-triangle"></i> Artikel akan dikembalikan ke draft
                    </div>
                </div>
                @endif

                {{-- Edit --}}
                <div class="action-box action-box-edit">
                    <div class="action-header">
                        <div class="action-icon action-icon-edit"><i class="fas fa-edit"></i></div>
                        <div class="action-text">
                            <h4 class="action-title">Edit Artikel</h4>
                            <p class="action-description">Ubah konten artikel</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.articles.edit', $article->id) }}" class="action-button action-button-edit">
                        <i class="fas fa-pen"></i><span>Edit Artikel</span>
                    </a>
                    <div class="action-info action-info-edit">
                        <i class="fas fa-lightbulb"></i> Ubah atau perbaiki konten artikel sesuai kebutuhan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Publish Modal --}}
<div id="publishModal" class="modal-overlay">
    <div class="modal">
        <div class="modal-header modal-header-success">
            <div class="modal-title-wrapper">
                <div class="modal-title-content">
                    <div class="modal-icon"><i class="fas fa-check-circle"></i></div>
                    <div>
                        <h3 class="modal-title">Konfirmasi Publish</h3>
                        <p class="modal-subtitle">Publikasikan artikel ini?</p>
                    </div>
                </div>
                <button type="button" onclick="hidePublishModal()" class="modal-close"><i class="fas fa-times"></i></button>
            </div>
        </div>
        <form action="{{ route('admin.articles.publish', $article->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="modal-body">
                <div style="background: #f3f4f6; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                    <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">Artikel yang akan dipublish:</p>
                    <p style="font-weight: 600; color: #111827; margin: 0;">{{ $article->title }}</p>
                </div>
                <p style="color: #6b7280; font-size: 0.875rem;">Artikel akan dapat dilihat oleh publik dan muncul di halaman website.</p>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="hidePublishModal()" class="btn-modal btn-cancel"><i class="fas fa-times"></i> Batal</button>
                <button type="submit" class="btn-modal btn-confirm-publish"><i class="fas fa-check-circle"></i> Ya, Publish</button>
            </div>
        </form>
    </div>
</div>

{{-- Unpublish Modal --}}
<div id="unpublishModal" class="modal-overlay">
    <div class="modal">
        <div class="modal-header modal-header-danger">
            <div class="modal-title-wrapper">
                <div class="modal-title-content">
                    <div class="modal-icon"><i class="fas fa-exclamation-triangle"></i></div>
                    <div>
                        <h3 class="modal-title">Konfirmasi Unpublish</h3>
                        <p class="modal-subtitle">Kembalikan ke draft?</p>
                    </div>
                </div>
                <button type="button" onclick="hideUnpublishModal()" class="modal-close"><i class="fas fa-times"></i></button>
            </div>
        </div>
        <form action="{{ route('admin.articles.unpublish', $article->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="modal-body">
                <div style="background: #f3f4f6; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                    <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">Artikel yang akan di-unpublish:</p>
                    <p style="font-weight: 600; color: #111827; margin: 0;">{{ $article->title }}</p>
                </div>
                <p style="color: #6b7280; font-size: 0.875rem;">Artikel akan dikembalikan ke status draft dan tidak dapat dilihat publik.</p>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="hideUnpublishModal()" class="btn-modal btn-cancel"><i class="fas fa-times"></i> Batal</button>
                <button type="submit" class="btn-modal btn-confirm-unpublish"><i class="fas fa-archive"></i> Ya, Unpublish</button>
            </div>
        </form>
    </div>
</div>

{{-- Result Modal --}}
@if(session('success') || session('error'))
<div id="resultModal" class="modal-overlay active">
    <div class="modal">
        <div class="modal-header {{ session('success') ? 'modal-header-success' : 'modal-header-danger' }}">
            <div class="modal-title-wrapper">
                <div class="modal-title-content">
                    <div class="modal-icon"><i class="fas fa-{{ session('success') ? 'check-circle' : 'times-circle' }}"></i></div>
                    <div>
                        <h3 class="modal-title">{{ session('success') ? 'Berhasil!' : 'Gagal!' }}</h3>
                        <p class="modal-subtitle">{{ session('success') ? 'Operasi berhasil' : 'Terjadi kesalahan' }}</p>
                    </div>
                </div>
                <button type="button" onclick="hideResultModal()" class="modal-close"><i class="fas fa-times"></i></button>
            </div>
        </div>
        <div class="modal-body">
            <p style="color: #374151; font-size: 0.875rem;">{{ session('success') ?? session('error') }}</p>
        </div>
        <div class="modal-footer">
            <button type="button" onclick="hideResultModal()" class="btn-modal {{ session('success') ? 'btn-confirm-publish' : 'btn-confirm-unpublish' }}">
                <i class="fas fa-check"></i> OK
            </button>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
function showPublishModal() { document.getElementById('publishModal').classList.add('active'); }
function hidePublishModal() { document.getElementById('publishModal').classList.remove('active'); }
function showUnpublishModal() { document.getElementById('unpublishModal').classList.add('active'); }
function hideUnpublishModal() { document.getElementById('unpublishModal').classList.remove('active'); }
function hideResultModal() { document.getElementById('resultModal').classList.remove('active'); }

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') { hidePublishModal(); hideUnpublishModal(); hideResultModal(); }
});

document.querySelectorAll('.modal-overlay').forEach(o => {
    o.addEventListener('click', function(e) { if (e.target === this) this.classList.remove('active'); });
});
</script>
@endpush
@endsection