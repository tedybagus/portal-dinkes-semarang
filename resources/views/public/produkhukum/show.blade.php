@extends('layouts.public.app')
@section('title', $produkHukum->nomor_lengkap)

@section('content')
<div class="detail-page">
    <div class="container">
        {{-- Breadcrumb --}}
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('produkhukum.index') }}">Produk Hukum</a>
            <i class="fas fa-chevron-right"></i>
            <span>Detail</span>
        </nav>

        <div class="content-grid">
            {{-- Main Content --}}
            <article class="main-content">
                {{-- Header Card --}}
                <div class="header-card">
                    <div class="doc-kategori" style="background: {{ $produkHukum->status_color }}20; color: {{ $produkHukum->status_color }};">
                        <i class="fas fa-gavel"></i>
                        {{ $produkHukum->kategori_label }}
                    </div>
                    
                    <h1 class="doc-nomor">
                        {{ $produkHukum->kategori_label }} Nomor {{ $produkHukum->nomor }} Tahun {{ $produkHukum->tahun }}
                    </h1>

                    <div class="doc-tentang">
                        <h2>Tentang</h2>
                        <p>{{ $produkHukum->tentang }}</p>
                    </div>

                    <div class="doc-meta-grid">
                        <div class="meta-box">
                            <i class="far fa-calendar"></i>
                            <div>
                                <div class="meta-label">Tanggal Penetapan</div>
                                <div class="meta-value">{{ $produkHukum->tanggal_penetapan->format('d F Y') }}</div>
                            </div>
                        </div>

                        @if($produkHukum->tanggal_berlaku)
                        <div class="meta-box">
                            <i class="fas fa-calendar-check"></i>
                            <div>
                                <div class="meta-label">Tanggal Berlaku</div>
                                <div class="meta-value">{{ $produkHukum->tanggal_berlaku->format('d F Y') }}</div>
                            </div>
                        </div>
                        @endif

                        <div class="meta-box">
                            <i class="fas fa-download"></i>
                            <div>
                                <div class="meta-label">Total Download</div>
                                <div class="meta-value">{{ $produkHukum->download_count }}x</div>
                            </div>
                        </div>

                        <div class="meta-box">
                            <i class="fas fa-circle" style="color: {{ $produkHukum->status_color }};"></i>
                            <div>
                                <div class="meta-label">Status</div>
                                <div class="meta-value">{{ ucfirst($produkHukum->status) }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Keterangan --}}
                @if($produkHukum->keterangan)
                <div class="info-card">
                    <h3>
                        <i class="fas fa-info-circle"></i>
                        Keterangan Tambahan
                    </h3>
                    <p>{{ $produkHukum->keterangan }}</p>
                </div>
                @endif

                {{-- Download Section --}}
                <div class="download-card">
                    <div class="download-info">
                        <div class="pdf-icon">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div class="file-details">
                            <div class="file-name">{{ $produkHukum->file_name }}</div>
                            <div class="file-meta">
                                <span><i class="fas fa-hdd"></i> {{ $produkHukum->file_size_readable }}</span>
                                <span><i class="fas fa-download"></i> {{ $produkHukum->download_count }} downloads</span>
                            </div>
                        </div>
                    </div>
                    <div class="download-actions">
                        <a href="{{ route('produkhukum.download', $produkHukum) }}" 
                           class="btn-download-lg"
                           target="_blank">
                            <i class="fas fa-download"></i>
                            Download PDF
                        </a>
                        <button onclick="shareProduk()" class="btn-share">
                            <i class="fas fa-share-alt"></i>
                            Bagikan
                        </button>
                    </div>
                </div>

                {{-- Share Modal (hidden by default) --}}
                <div id="shareModal" class="share-modal hidden">
                    <div class="share-content">
                        <div class="share-header">
                            <h3>Bagikan Dokumen</h3>
                            <button onclick="closeShare()" class="btn-close">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="share-buttons">
                            <button onclick="shareWhatsApp()" class="share-btn whatsapp">
                                <i class="fab fa-whatsapp"></i>
                                WhatsApp
                            </button>
                            <button onclick="shareFacebook()" class="share-btn facebook">
                                <i class="fab fa-facebook-f"></i>
                                Facebook
                            </button>
                            <button onclick="shareTwitter()" class="share-btn twitter">
                                <i class="fab fa-twitter"></i>
                                Twitter
                            </button>
                            <button onclick="shareEmail()" class="share-btn email">
                                <i class="fas fa-envelope"></i>
                                Email
                            </button>
                        </div>
                        <div class="share-link">
                            <input type="text" 
                                   id="shareUrl" 
                                   value="{{ route('produkhukum.show', $produkHukum) }}" 
                                   readonly>
                            <button onclick="copyLink()" class="btn-copy">
                                <i class="fas fa-copy"></i>
                                Copy
                            </button>
                        </div>
                    </div>
                </div>
            </article>

            {{-- Sidebar --}}
            <aside class="sidebar">
                {{-- Quick Info --}}
                <div class="info-card">
                    <h3>Informasi Dokumen</h3>
                    <div class="info-list">
                        <div class="info-item">
                            <span class="label">Nomor:</span>
                            <span class="value">{{ $produkHukum->nomor }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Tahun:</span>
                            <span class="value">{{ $produkHukum->tahun }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Kategori:</span>
                            <span class="value">{{ $produkHukum->kategori_label }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Status:</span>
                            <span class="value" style="color: {{ $produkHukum->status_color }}; font-weight: 700;">
                                {{ ucfirst($produkHukum->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Related Documents --}}
                @if($relatedDokumen->count())
                <div class="related-card">
                    <h3>Dokumen Terkait</h3>
                    <div class="related-list">
                        @foreach($relatedDokumen as $related)
                        <a href="{{ route('produkhukum.show', $related) }}" class="related-item">
                            <div class="related-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="related-info">
                                <div class="related-nomor">Nomor {{ $related->nomor }}/{{ $related->tahun }}</div>
                                <div class="related-title">{{ Str::limit($related->tentang, 60) }}</div>
                                <div class="related-meta">
                                    <span>{{ $related->tanggal_penetapan->format('d M Y') }}</span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Back Button --}}
                <a href="{{ route('produkhukum.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Daftar
                </a>
            </aside>
        </div>
    </div>
</div>

<style>
.detail-page {
    background: #f8fafc;
    min-height: 100vh;
    padding: 2rem 0 4rem;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

/* Breadcrumb */
.breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.875rem;
    color: #64748b;
    margin-bottom: 2rem;
}

.breadcrumb a {
    color: #3b82f6;
    text-decoration: none;
}

.breadcrumb i {
    font-size: 0.75rem;
}

/* Grid */
.content-grid {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 2rem;
}

/* Main Content */
.main-content {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.header-card,
.info-card,
.download-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
}

.doc-kategori {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
}

.doc-nomor {
    font-size: 1.75rem;
    font-weight: 800;
    color: #1e293b;
    line-height: 1.3;
    margin-bottom: 1.5rem;
}

.doc-tentang {
    padding: 1.5rem;
    background: #f8fafc;
    border-radius: 12px;
    margin-bottom: 1.5rem;
}

.doc-tentang h2 {
    font-size: 0.875rem;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.75rem;
}

.doc-tentang p {
    font-size: 1.125rem;
    line-height: 1.7;
    color: #1e293b;
}

.doc-meta-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.meta-box {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 12px;
}

.meta-box i {
    font-size: 1.5rem;
    color: #ef4444;
}

.meta-label {
    font-size: 0.8125rem;
    color: #64748b;
    margin-bottom: 0.25rem;
}

.meta-value {
    font-size: 1rem;
    font-weight: 700;
    color: #1e293b;
}

/* Info Card */
.info-card h3 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-card h3 i {
    color: #ef4444;
}

.info-card p {
    font-size: 0.9375rem;
    line-height: 1.7;
    color: #475569;
}

/* Download Card */
.download-card {
    background: linear-gradient(135deg, #1e293b, #334155);
    color: white;
}

.download-info {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.pdf-icon {
    width: 80px;
    height: 80px;
    background: rgba(255,255,255,.1);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: #ef4444;
}

.file-details {
    flex: 1;
}

.file-name {
    font-size: 1.125rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.file-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    font-size: 0.875rem;
    color: rgba(255,255,255,.7);
}

.file-meta span {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.download-actions {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 1rem;
}

.btn-download-lg,
.btn-share {
    padding: 1rem 2rem;
    border-radius: 12px;
    font-weight: 700;
    font-size: 1rem;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    text-decoration: none;
}

.btn-download-lg {
    background: #ef4444;
    color: white;
}

.btn-download-lg:hover {
    background: #dc2626;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
}

.btn-share {
    background: rgba(255,255,255,.1);
    color: white;
}

.btn-share:hover {
    background: rgba(255,255,255,.2);
}

/* Share Modal */
.share-modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,.7);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.share-modal.hidden {
    display: none;
}

.share-content {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    max-width: 500px;
    width: 90%;
}

.share-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.share-header h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
}

.btn-close {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #f1f5f9;
    border: none;
    cursor: pointer;
    color: #64748b;
}

.share-buttons {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.share-btn {
    padding: 1rem;
    border-radius: 12px;
    border: none;
    color: white;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    transition: all 0.2s;
}

.share-btn:hover {
    transform: translateY(-2px);
}

.share-btn.whatsapp { background: #25d366; }
.share-btn.facebook { background: #1877f2; }
.share-btn.twitter { background: #1da1f2; }
.share-btn.email { background: #64748b; }

.share-link {
    display: flex;
    gap: 0.5rem;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 12px;
}

.share-link input {
    flex: 1;
    border: none;
    background: none;
    font-size: 0.875rem;
    color: #475569;
}

.btn-copy {
    padding: 0.5rem 1rem;
    background: #ef4444;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
}

/* Sidebar */
.sidebar {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.info-list {
    display: flex;
    flex-direction: column;
}

.info-item {
    display: flex;
    justify-content: space-between;
    padding: 0.875rem 0;
    border-bottom: 1px solid #e2e8f0;
}

.info-item:last-child {
    border-bottom: none;
}

.info-item .label {
    font-size: 0.875rem;
    color: #64748b;
}

.info-item .value {
    font-size: 0.875rem;
    font-weight: 600;
    color: #1e293b;
}

/* Related */
.related-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
}

.related-card h3 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1.25rem;
}

.related-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.related-item {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.2s;
}

.related-item:hover {
    background: #f1f5f9;
    transform: translateX(4px);
}

.related-icon {
    width: 48px;
    height: 48px;
    background: white;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ef4444;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.related-info {
    flex: 1;
    min-width: 0;
}

.related-nomor {
    font-size: 0.75rem;
    font-weight: 700;
    color: #ef4444;
    margin-bottom: 0.25rem;
}

.related-title {
    font-size: 0.9375rem;
    font-weight: 600;
    color: #1e293b;
    line-height: 1.4;
    margin-bottom: 0.25rem;
}

.related-meta {
    font-size: 0.8125rem;
    color: #64748b;
}

/* Back Button */
.btn-back {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.875rem;
    background: white;
    color: #475569;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.2s;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
}

.btn-back:hover {
    background: #f8fafc;
}

/* Responsive */
@media (max-width: 1024px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .doc-nomor {
        font-size: 1.25rem;
    }
    
    .doc-meta-grid {
        grid-template-columns: 1fr;
    }
    
    .download-actions {
        grid-template-columns: 1fr;
    }
    
    .share-buttons {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
function shareProduk() {
    document.getElementById('shareModal').classList.remove('hidden');
}

function closeShare() {
    document.getElementById('shareModal').classList.add('hidden');
}

function shareWhatsApp() {
    const text = "{{ $produkHukum->nomor_lengkap }} - {{ $produkHukum->tentang }}";
    const url = "{{ route('produkhukum.show', $produkHukum) }}";
    window.open(`https://wa.me/?text=${encodeURIComponent(text + ' ' + url)}`, '_blank');
}

function shareFacebook() {
    const url = "{{ route('produkhukum.show', $produkHukum) }}";
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`, '_blank');
}

function shareTwitter() {
    const text = "{{ $produkHukum->nomor_lengkap }}";
    const url = "{{ route('produkhukum.show', $produkHukum) }}";
    window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`, '_blank');
}

function shareEmail() {
    const subject = "{{ $produkHukum->nomor_lengkap }}";
    const body = "{{ $produkHukum->tentang }}\n\n{{ route('produkhukum.show', $produkHukum) }}";
    window.location.href = `mailto:?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
}

function copyLink() {
    const input = document.getElementById('shareUrl');
    input.select();
    document.execCommand('copy');
    alert('Link berhasil disalin!');
}

// Close modal on outside click
document.getElementById('shareModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeShare();
    }
});
</script>
@endsection