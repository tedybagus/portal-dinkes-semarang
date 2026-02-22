@extends('layouts.public.app')

@section('title', 'Struktur Organisasi')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="header-container">
        <h1 class="page-title">Struktur Organisasi</h1>
        <p class="page-subtitle">{{ $struktur->title ?? 'Struktur Organisasi Dinas Kesehatan Kabupaten Semarang' }}</p>
    </div>
</div>

@if($struktur)
    <div class="content-container">
        <!-- Description -->
        @if($struktur->description)
            <div class="description-card">
                <div class="description-icon">
                    <i class="fas fa-info-circle"></i>
                </div>
                <p class="description-text">{{ $struktur->description }}</p>
            </div>
        @endif

        <!-- Bagan Struktur Organisasi -->
        <div class="bagan-card">
            <div class="bagan-header">
                <h3 class="bagan-title">
                    <i class="fas fa-sitemap"></i>
                    Bagan Struktur Organisasi
                </h3>
                <div class="bagan-actions">
                    <button onclick="zoomBagan()" class="btn-action" title="Zoom Bagan">
                        <i class="fas fa-search-plus"></i> Zoom
                    </button>
                    <a href="{{ asset('storage/' . $struktur->image) }}" download class="btn-action" title="Download Bagan">
                        <i class="fas fa-download"></i> Download
                    </a>
                </div>
            </div>

            <div class="bagan-container" id="bagan-container">
                <img 
                    src="{{ asset('storage/' . $struktur->image) }}" 
                    alt="{{ $struktur->title }}" 
                    class="bagan-image"
                    id="bagan-image"
                >
            </div>

            <div class="bagan-footer">
                <p class="bagan-hint">
                    <i class="fas fa-hand-pointer"></i>
                    Klik tombol "Zoom" untuk memperbesar bagan atau scroll untuk zoom in/out
                </p>
            </div>
        </div>

        <!-- Content / Penjelasan Detail -->
        @if($struktur->content)
            <div class="content-card">
                <h3 class="content-title">
                    <i class="fas fa-file-alt"></i>
                    Penjelasan Struktur Organisasi
                </h3>
                <div class="content-body">
                    {!! $struktur->content !!}
                </div>
            </div>
        @endif
    </div>

    <!-- Modal Zoom -->
    <div id="zoom-modal" class="modal-zoom">
        <div class="modal-zoom-content">
            <div class="modal-zoom-header">
                <h3>Bagan Struktur Organisasi</h3>
                <button onclick="closeZoom()" class="btn-close-zoom">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-zoom-body">
                <div class="zoom-controls">
                    <button onclick="zoomIn()" class="zoom-btn" title="Zoom In">
                        <i class="fas fa-search-plus"></i>
                    </button>
                    <button onclick="zoomOut()" class="zoom-btn" title="Zoom Out">
                        <i class="fas fa-search-minus"></i>
                    </button>
                    <button onclick="resetZoom()" class="zoom-btn" title="Reset">
                        <i class="fas fa-redo"></i>
                    </button>
                </div>
                <div class="zoom-image-container" id="zoom-container">
                    <img 
                        src="{{ asset('storage/' . $struktur->image) }}" 
                        alt="{{ $struktur->title }}" 
                        id="zoom-image"
                        draggable="false"
                    >
                </div>
            </div>
        </div>
    </div>
@else
    <div class="empty-state">
        <i class="fas fa-sitemap"></i>
        <h3>Data Belum Tersedia</h3>
        <p>Struktur organisasi belum ditambahkan</p>
    </div>
@endif

<style>
/* Page Header */
.page-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
    color: white;
    padding: 4rem 0 3rem;
    margin-bottom: 3rem;
}

.header-container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 2rem;
    text-align: center;
}

.page-title {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 1rem;
}

.page-subtitle {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.9);
}

/* Content Container */
.content-container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 2rem 4rem;
}

/* Description Card */
.description-card {
    background: #eff6ff;
    border-left: 4px solid #1e40af;
    padding: 1.5rem 2rem;
    border-radius: 8px;
    margin-bottom: 2rem;
    display: flex;
    gap: 1.5rem;
    align-items: flex-start;
}

.description-icon {
    color: #1e40af;
    font-size: 2rem;
    flex-shrink: 0;
}

.description-text {
    font-size: 1.0625rem;
    line-height: 1.7;
    color: #1e40af;
    margin: 0;
    font-weight: 500;
}

/* Bagan Card */
.bagan-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    margin-bottom: 2rem;
}

.bagan-header {
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    padding: 1.5rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid #d1d5db;
}

.bagan-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.bagan-actions {
    display: flex;
    gap: 0.75rem;
}

.btn-action {
    padding: 0.625rem 1.25rem;
    background: #1e40af;
    color: white;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    font-size: 0.9375rem;
}

.btn-action:hover {
    background: #1e3a8a;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
}

.bagan-container {
    padding: 2rem;
    background: #f9fafb;
    text-align: center;
}

.bagan-image {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    cursor: zoom-in;
    transition: transform 0.3s;
}

.bagan-image:hover {
    transform: scale(1.02);
}

.bagan-footer {
    padding: 1rem 2rem;
    background: #f3f4f6;
    border-top: 1px solid #e5e7eb;
}

.bagan-hint {
    margin: 0;
    font-size: 0.875rem;
    color: #6b7280;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

/* Content Card */
.content-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    padding: 2rem;
}

.content-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e5e7eb;
}

.content-body {
    font-size: 1rem;
    line-height: 1.8;
    color: #374151;
}

.content-body h1,
.content-body h2,
.content-body h3,
.content-body h4 {
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
    color: #1f2937;
}

.content-body ul,
.content-body ol {
    margin-left: 1.5rem;
    margin-bottom: 1rem;
}

.content-body li {
    margin-bottom: 0.5rem;
}

/* Modal Zoom */
.modal-zoom {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.95);
    z-index: 9999;
    overflow: hidden;
}

.modal-zoom.active {
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-zoom-content {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.modal-zoom-header {
    background: rgba(31, 41, 55, 0.9);
    padding: 1.5rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-zoom-header h3 {
    color: white;
    margin: 0;
    font-size: 1.25rem;
}

.btn-close-zoom {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.1);
    color: white;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    transition: all 0.3s;
}

.btn-close-zoom:hover {
    background: #ef4444;
}

.modal-zoom-body {
    flex: 1;
    position: relative;
    overflow: auto;
}

.zoom-controls {
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
    display: flex;
    gap: 0.5rem;
    z-index: 10;
}

.zoom-btn {
    width: 45px;
    height: 45px;
    background: rgba(30, 64, 175, 0.9);
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.125rem;
    transition: all 0.3s;
}

.zoom-btn:hover {
    background: #1e40af;
    transform: scale(1.1);
}

.zoom-image-container {
    padding: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100%;
}

#zoom-image {
    max-width: 100%;
    height: auto;
    cursor: move;
    transition: transform 0.3s;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 6rem 2rem;
}

.empty-state i {
    font-size: 5rem;
    color: #d1d5db;
    margin-bottom: 1.5rem;
}

.empty-state h3 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #6b7280;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #9ca3af;
}

/* Responsive */
@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }

    .page-subtitle {
        font-size: 1rem;
    }

    .bagan-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }

    .bagan-title {
        font-size: 1.25rem;
    }

    .bagan-actions {
        width: 100%;
    }

    .btn-action {
        flex: 1;
        justify-content: center;
    }

    .bagan-container {
        padding: 1rem;
    }

    .content-card {
        padding: 1.5rem;
    }

    .zoom-controls {
        top: 1rem;
        right: 1rem;
    }

    .zoom-btn {
        width: 40px;
        height: 40px;
    }
}
</style>

<script>
let zoomLevel = 1;
let isDragging = false;
let startX, startY, translateX = 0, translateY = 0;

// Open zoom modal
function zoomBagan() {
    document.getElementById('zoom-modal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

// Close zoom modal
function closeZoom() {
    document.getElementById('zoom-modal').classList.remove('active');
    document.body.style.overflow = '';
    resetZoom();
}

// Zoom in
function zoomIn() {
    zoomLevel = Math.min(zoomLevel + 0.2, 3);
    updateZoom();
}

// Zoom out
function zoomOut() {
    zoomLevel = Math.max(zoomLevel - 0.2, 0.5);
    updateZoom();
}

// Reset zoom
function resetZoom() {
    zoomLevel = 1;
    translateX = 0;
    translateY = 0;
    updateZoom();
}

// Update zoom transform
function updateZoom() {
    const img = document.getElementById('zoom-image');
    img.style.transform = `scale(${zoomLevel}) translate(${translateX}px, ${translateY}px)`;
}

// Dragging functionality
const zoomContainer = document.getElementById('zoom-container');
const zoomImage = document.getElementById('zoom-image');

if (zoomImage) {
    zoomImage.addEventListener('mousedown', function(e) {
        if (zoomLevel > 1) {
            isDragging = true;
            startX = e.clientX - translateX;
            startY = e.clientY - translateY;
            zoomImage.style.cursor = 'grabbing';
        }
    });

    document.addEventListener('mousemove', function(e) {
        if (isDragging) {
            translateX = e.clientX - startX;
            translateY = e.clientY - startY;
            updateZoom();
        }
    });

    document.addEventListener('mouseup', function() {
        isDragging = false;
        zoomImage.style.cursor = 'move';
    });
}

// Wheel zoom
if (zoomContainer) {
    zoomContainer.addEventListener('wheel', function(e) {
        e.preventDefault();
        if (e.deltaY < 0) {
            zoomIn();
        } else {
            zoomOut();
        }
    });
}

// Close on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeZoom();
    }
});

// Click on bagan image to zoom
const baganImage = document.getElementById('bagan-image');
if (baganImage) {
    baganImage.addEventListener('click', zoomBagan);
}
</script>
@endsection