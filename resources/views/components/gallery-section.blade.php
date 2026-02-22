@if($galleries && $galleries->count() > 0)
<section class="gallery-section">
    <div class="container">
        <!-- Section Header -->
        <div class="section-header">
            <div class="header-content">
                <span class="section-badge">
                    <i class="fas fa-images"></i>
                    Gallery
                </span>
                <h2 class="section-title">Galeri Kegiatan & Dokumentasi</h2>
                <p class="section-description">
                    Dokumentasi kegiatan dan fasilitas Dinas Kesehatan Kabupaten Semarang
                </p>
            </div>
        </div>

        <!-- Category Filter -->
        <div class="gallery-filters">
            <button class="filter-button active" data-filter="all">
                <span class="filter-icon">📋</span>
                Semua
            </button>
            <button class="filter-button" data-filter="kegiatan">
                <span class="filter-icon">🎯</span>
                Kegiatan
            </button>
            <button class="filter-button" data-filter="fasilitas">
                <span class="filter-icon">🏥</span>
                Fasilitas
            </button>
            <button class="filter-button" data-filter="dokumentasi">
                <span class="filter-icon">📸</span>
                Dokumentasi
            </button>
        </div>
        <!-- View All Button -->
      
       
        <br>
        <!-- Gallery Grid -->
        <div class="gallery-masonry">
            @foreach($galleries as $index => $gallery)
            <div class="gallery-item" data-type="{{ $gallery->type }}" data-aos="fade-up" data-aos-delay="{{ ($index % 6) * 50 }}">
                <div class="gallery-card {{ $gallery->gallery ? 'gallery' : '' }}">
                    <div class="gallery-image-wrapper">
                        <img 
                            src="{{ $gallery->image_url }}" 
                            alt="{{ $gallery->title }}"
                            loading="lazy"
                            class="gallery-image"
                        >
                        <div class="gallery-overlay">
                            <div class="overlay-content">
                                <span class="category-tag">
                                    {{ ucfirst($gallery->type) }}
                                </span>
                                <h3 class="gallery-title">{{ $gallery->title }}</h3>
                                @if($gallery->description)
                                <p class="gallery-description">{{ Str::limit($gallery->description, 100) }}</p>
                                @endif
                                <button class="view-button" onclick="openLightbox({{ $index }})">
                                    <i class="fas fa-search-plus"></i>
                                    Lihat Detail
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
         <div class="header-content" style="padding: auto; margin: 0 35em;">
              @if($galleries->count() >= 2)
            <a href="{{ route('galery.public') }}" class="btn-view-all">
                Views Gallery
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        @endif

       
    </div>
</section>

<!-- Lightbox Modal -->
<div class="lightbox-modal" id="lightboxModal">
    <div class="lightbox-overlay" onclick="closeLightbox()"></div>
    <div class="lightbox-content">
        <button class="lightbox-close" onclick="closeLightbox()">
            <i class="fas fa-times"></i>
        </button>
        <button class="lightbox-prev" onclick="navigateLightbox(-1)">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="lightbox-next" onclick="navigateLightbox(1)">
            <i class="fas fa-chevron-right"></i>
        </button>
        <div class="lightbox-image-container">
            <img id="lightboxImage" src="" alt="">
        </div>
        <div class="lightbox-info">
            <div class="lightbox-category" id="lightboxCategory"></div>
            <h3 class="lightbox-title" id="lightboxTitle"></h3>
            <p class="lightbox-description" id="lightboxDescription"></p>
        </div>
    </div>
</div>

<style>
/* Gallery Section */
.gallery-section {
    padding: 5rem 0;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    position: relative;
    overflow: hidden;
}

.gallery-section::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
    border-radius: 50%;
}

.container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
}

/* Section Header */
.section-header {
    text-align: center;
    margin-bottom: 3rem;
}

.section-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1.25rem;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.section-description {
    font-size: 1.125rem;
    color: #64748b;
    max-width: 600px;
    margin: 0 auto;
}

/* Gallery Filters */
.gallery-filters {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 3rem;
}

.filter-button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 0.9375rem;
    font-weight: 600;
    color: #475569;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.filter-button:hover {
    border-color: #3b82f6;
    color: #3b82f6;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
}

.filter-button.active {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border-color: #3b82f6;
    color: white;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.filter-icon {
    font-size: 1.25rem;
}

/* Gallery Masonry Grid */
.gallery-masonry {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.gallery-item {
    animation: fadeInUp 0.6s ease-out;
}

.gallery-item[style*="display: none"] {
    display: none !important;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Gallery Card */
.gallery-card {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    background: white;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.gallery-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
}

/* .gallery-card.is-hero {
    grid-column: span 2;
    grid-row: span 2;
} */

.gallery-image-wrapper {
    position: relative;
    padding-top: 75%; /* 4:3 aspect ratio */
    overflow: hidden;
}

.gallery-card.is-hero .gallery-image-wrapper {
    padding-top: 56.25%; /* 16:9 for hero */
}

.gallery-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.gallery-card:hover .gallery-image {
    transform: scale(1.1);
}

/* Gallery Overlay */
.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(
        to bottom,
        rgba(0, 0, 0, 0) 0%,
        rgba(0, 0, 0, 0.4) 50%,
        rgba(0, 0, 0, 0.9) 100%
    );
    opacity: 0;
    transition: opacity 0.4s ease;
    display: flex;
    align-items: flex-end;
    padding: 2rem;
}

.gallery-card:hover .gallery-overlay {
    opacity: 1;
}

.overlay-content {
    width: 100%;
}

.category-tag {
    display: inline-block;
    padding: 0.375rem 0.875rem;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    color: white;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.75rem;
}

.gallery-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: white;
    margin-bottom: 0.5rem;
    line-height: 1.3;
}

.gallery-card.is-hero .gallery-title {
    font-size: 1.75rem;
}

.gallery-description {
    font-size: 0.9375rem;
    color: rgba(255, 255, 255, 0.9);
    line-height: 1.6;
    margin-bottom: 1rem;
}

.view-button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    background: white;
    border: none;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    color: #1e293b;
    cursor: pointer;
    transition: all 0.3s;
}

.view-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 255, 255, 0.3);
}

/* .hero-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    border-radius: 12px;
    color: white;
    font-size: 1.25rem;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
    animation: pulse 2s infinite; */
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

/* View All Button */
.btn-view-all {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 2rem;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    transition: all 0.3s;
}

.btn-view-all:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
}

/* Lightbox */
.lightbox-modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 2rem;
}

.lightbox-modal.active {
    display: flex;
}

.lightbox-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.95);
    backdrop-filter: blur(10px);
}

.lightbox-content {
    position: relative;
    max-width: 1200px;
    width: 100%;
    z-index: 1;
}

.lightbox-close,
.lightbox-prev,
.lightbox-next {
    position: absolute;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    color: white;
    font-size: 1.25rem;
    cursor: pointer;
    transition: all 0.3s;
    z-index: 2;
}

.lightbox-close {
    top: -60px;
    right: 0;
}

.lightbox-prev {
    left: -70px;
    top: 50%;
    transform: translateY(-50%);
}

.lightbox-next {
    right: -70px;
    top: 50%;
    transform: translateY(-50%);
}

.lightbox-close:hover,
.lightbox-prev:hover,
.lightbox-next:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: scale(1.1);
}

.lightbox-prev:hover {
    transform: translateY(-50%) scale(1.1);
}

.lightbox-next:hover {
    transform: translateY(-50%) scale(1.1);
}

.lightbox-image-container {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 1.5rem;
}

.lightbox-image-container img {
    width: 100%;
    height: auto;
    max-height: 70vh;
    object-fit: contain;
    display: block;
}

.lightbox-info {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    padding: 1.5rem;
    color: white;
}

.lightbox-category {
    display: inline-block;
    padding: 0.375rem 0.875rem;
    background: rgba(59, 130, 246, 0.8);
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    margin-bottom: 0.75rem;
}

.lightbox-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.lightbox-description {
    font-size: 1rem;
    opacity: 0.9;
    line-height: 1.6;
}

/* Responsive */
@media (max-width: 1024px) {
    .gallery-masonry {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    }
    
    /* .gallery-card.is-hero {
        grid-column: span 1;
        grid-row: span 1;
    } */
    
    .lightbox-prev,
    .lightbox-next {
        display: none;
    }
}

@media (max-width: 768px) {
    .section-title {
        font-size: 2rem;
    }
    
    .gallery-masonry {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .gallery-filters {
        gap: 0.5rem;
    }
    
    .filter-button {
        padding: 0.625rem 1rem;
        font-size: 0.875rem;
    }
    
    .lightbox-content {
        padding: 1rem;
    }
    
    .lightbox-close {
        top: -50px;
    }
}
</style>

<script>
// Gallery data for lightbox
const galleryData = [
    @foreach($galleries as $gallery)
    {
        image_url: "{{ $gallery->image_url }}",
        title: "{{ addslashes($gallery->title) }}",
        description: "{{ addslashes($gallery->description ?? '') }}",
        type: "{{ ucfirst($gallery->type) }}"
    }{{ !$loop->last ? ',' : '' }}
    @endforeach
];

let currentLightboxIndex = 0;

// Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-button');
    const galleryItems = document.querySelectorAll('.gallery-item');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.dataset.filter;
            
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Filter items
            galleryItems.forEach(item => {
                if (filter === 'all' || item.dataset.category === filter) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});

// Lightbox functions
function openLightbox(index) {
    currentLightboxIndex = index;
    updateLightbox();
    document.getElementById('lightboxModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightboxModal').classList.remove('active');
    document.body.style.overflow = '';
}

function navigateLightbox(direction) {
    currentLightboxIndex += direction;
    if (currentLightboxIndex < 0) currentLightboxIndex = galleryData.length - 1;
    if (currentLightboxIndex >= galleryData.length) currentLightboxIndex = 0;
    updateLightbox();
}

function updateLightbox() {
    const data = galleryData[currentLightboxIndex];
    document.getElementById('lightboxImage').src = data.image_url;
    document.getElementById('lightboxTitle').textContent = data.title;
    document.getElementById('lightboxDescription').textContent = data.description || '';
    document.getElementById('lightboxCategory').textContent = data.type;
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    const modal = document.getElementById('lightboxModal');
    if (modal.classList.contains('active')) {
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') navigateLightbox(-1);
        if (e.key === 'ArrowRight') navigateLightbox(1);
    }
});
</script>
@endif