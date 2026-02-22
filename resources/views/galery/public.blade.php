<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Gallery - Portal Dinas Kesehatan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8fafc;
        }

        /* Gallery Section */
        .gallery-section {
            padding: 5rem 2rem;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
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
            transition: all 0.3s;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .filter-button:hover {
            border-color: #3b82f6;
            color: #3b82f6;
            transform: translateY(-2px);
        }

        .filter-button.active {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border-color: #3b82f6;
            color: white;
        }

        /* Gallery Grid */
        .gallery-masonry {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
        }

        .gallery-card {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.4s;
        }

        .gallery-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .gallery-card.is-hero {
            grid-column: span 2;
            grid-row: span 2;
        }

        .gallery-image-wrapper {
            position: relative;
            padding-top: 75%;
            overflow: hidden;
            background: linear-gradient(135deg, #e0e7ff, #dbeafe);
        }

        .gallery-card.is-hero .gallery-image-wrapper {
            padding-top: 56.25%;
        }

        .gallery-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s;
        }

        .gallery-card:hover .gallery-image {
            transform: scale(1.1);
        }

        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.4) 50%, rgba(0,0,0,0.9) 100%);
            opacity: 0;
            transition: opacity 0.4s;
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
            margin-bottom: 0.75rem;
        }

        .gallery-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
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
        }

        .hero-badge {
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
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        /* Placeholder untuk demo */
        .img-placeholder {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: rgba(255, 255, 255, 0.5);
        }

        @media (max-width: 1024px) {
            .gallery-card.is-hero {
                grid-column: span 1;
                grid-row: span 1;
            }
        }

        @media (max-width: 768px) {
            .section-title {
                font-size: 2rem;
            }
            
            .gallery-masonry {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <section class="gallery-section">
        <div class="container">
            <!-- Section Header -->
            <div class="section-header">
                <span class="section-badge">
                    <i class="fas fa-images"></i>
                    Gallery
                </span>
                <h2 class="section-title">Galeri Kegiatan & Dokumentasi</h2>
                <p class="section-description">
                    Dokumentasi kegiatan dan fasilitas Dinas Kesehatan Kabupaten Semarang
                </p>
            </div>

            <!-- Category Filter -->
            <div class="gallery-filters">
                <button class="filter-button active">
                    <span>📋</span>
                    Semua
                </button>
                <button class="filter-button">
                    <span>🎯</span>
                    Kegiatan
                </button>
                <button class="filter-button">
                    <span>🏥</span>
                    Fasilitas
                </button>
                <button class="filter-button">
                    <span>📸</span>
                    Dokumentasi
                </button>
            </div>

            <!-- Gallery Grid -->
            <div class="gallery-masonry">
                <!-- Hero Gallery Item -->
                <div class="gallery-card is-hero">
                    <div class="gallery-image-wrapper">
                        <div class="img-placeholder">🏥</div>
                        <div class="gallery-overlay">
                            <div class="overlay-content">
                                <span class="category-tag">Kegiatan</span>
                                <h3 class="gallery-title">Gerakan Masyarakat Hidup Sehat 2025</h3>
                                <p class="gallery-description">Kampanye kesehatan masyarakat dengan tema hidup sehat dan aktif untuk mencegah penyakit tidak menular</p>
                                <button class="view-button">
                                    <i class="fas fa-search-plus"></i>
                                    Lihat Detail
                                </button>
                            </div>
                        </div>
                        <div class="hero-badge">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>

                <!-- Regular Gallery Items -->
                <div class="gallery-card">
                    <div class="gallery-image-wrapper">
                        <div class="img-placeholder">🏃</div>
                        <div class="gallery-overlay">
                            <div class="overlay-content">
                                <span class="category-tag">Kegiatan</span>
                                <h3 class="gallery-title">Senam Sehat Bersama</h3>
                                <p class="gallery-description">Kegiatan senam pagi bersama masyarakat</p>
                                <button class="view-button">
                                    <i class="fas fa-search-plus"></i>
                                    Lihat Detail
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="gallery-card">
                    <div class="gallery-image-wrapper">
                        <div class="img-placeholder">💉</div>
                        <div class="gallery-overlay">
                            <div class="overlay-content">
                                <span class="category-tag">Kegiatan</span>
                                <h3 class="gallery-title">Vaksinasi COVID-19</h3>
                                <p class="gallery-description">Program vaksinasi massal untuk masyarakat</p>
                                <button class="view-button">
                                    <i class="fas fa-search-plus"></i>
                                    Lihat Detail
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="gallery-card">
                    <div class="gallery-image-wrapper">
                        <div class="img-placeholder">👶</div>
                        <div class="gallery-overlay">
                            <div class="overlay-content">
                                <span class="category-tag">Fasilitas</span>
                                <h3 class="gallery-title">Posyandu Balita</h3>
                                <p class="gallery-description">Fasilitas posyandu untuk pemeriksaan balita</p>
                                <button class="view-button">
                                    <i class="fas fa-search-plus"></i>
                                    Lihat Detail
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="gallery-card">
                    <div class="gallery-image-wrapper">
                        <div class="img-placeholder">🏥</div>
                        <div class="gallery-overlay">
                            <div class="overlay-content">
                                <span class="category-tag">Fasilitas</span>
                                <h3 class="gallery-title">Ruang Laboratorium</h3>
                                <p class="gallery-description">Fasilitas laboratorium kesehatan modern</p>
                                <button class="view-button">
                                    <i class="fas fa-search-plus"></i>
                                    Lihat Detail
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="gallery-card">
                    <div class="gallery-image-wrapper">
                        <div class="img-placeholder">📋</div>
                        <div class="gallery-overlay">
                            <div class="overlay-content">
                                <span class="category-tag">Dokumentasi</span>
                                <h3 class="gallery-title">Rapat Koordinasi</h3>
                                <p class="gallery-description">Rapat koordinasi program kesehatan</p>
                                <button class="view-button">
                                    <i class="fas fa-search-plus"></i>
                                    Lihat Detail
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="gallery-card">
                    <div class="gallery-image-wrapper">
                        <div class="img-placeholder">🎓</div>
                        <div class="gallery-overlay">
                            <div class="overlay-content">
                                <span class="category-tag">Kegiatan</span>
                                <h3 class="gallery-title">Pelatihan Kader Kesehatan</h3>
                                <p class="gallery-description">Workshop untuk kader posyandu</p>
                                <button class="view-button">
                                    <i class="fas fa-search-plus"></i>
                                    Lihat Detail
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="gallery-card">
                    <div class="gallery-image-wrapper">
                        <div class="img-placeholder">🦷</div>
                        <div class="gallery-overlay">
                            <div class="overlay-content">
                                <span class="category-tag">Kegiatan</span>
                                <h3 class="gallery-title">Pemeriksaan Gigi Gratis</h3>
                                <p class="gallery-description">Program pemeriksaan kesehatan gigi</p>
                                <button class="view-button">
                                    <i class="fas fa-search-plus"></i>
                                    Lihat Detail
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>