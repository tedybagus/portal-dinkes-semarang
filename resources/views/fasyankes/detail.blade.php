<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $fasyankes->nama }} - {{ config('app.name') }}</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Leaflet CSS for Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --navy-deep: #1e3a8a;
            --navy: #1e40af;
            --navy-light: #3b82f6;
            --gold: #fbbf24;
            --gold-light: #fcd34d;
            --white: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --green: #10b981;
            --red: #ef4444;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--gray-50);
            color: var(--gray-800);
        }

        /* Top Bar */
        .top-bar {
            background: var(--navy-deep);
            color: white;
            padding: 0.75rem 0;
        }

        .top-bar-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding: 0.5rem 1.25rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(-2px);
        }

        /* Navbar */
        .navbar {
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .nav-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
        }

        .nav-logo {
            width: 50px;
            height: 50px;
        }

        .nav-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--navy);
        }

        /* Main Content */
        .main-content {
            max-width: 1280px;
            margin: 2rem auto;
            padding: 0 2rem 4rem;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }

        /* Left Column */
        .detail-main {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .detail-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        }

        /* Image Section */
        .detail-image-wrapper {
            position: relative;
            width: 100%;
            height: 400px;
            overflow: hidden;
        }

        .detail-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .status-badge {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 700;
            background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .status-badge.aktif {
            color: var(--green);
        }

        .status-badge.tidak-aktif {
            color: var(--red);
        }

        .category-badge {
            position: absolute;
            top: 1.5rem;
            left: 1.5rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 700;
            color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .category-badge.klinik { background: #3b82f6; }
        .category-badge.rumah-sakit { background: #ef4444; }
        .category-badge.puskesmas { background: #10b981; }
        .category-badge.apotek { background: #f59e0b; }
        .category-badge.laboratorium { background: #8b5cf6; }

        /* Info Section */
        .detail-info {
            padding: 2rem;
        }

        .detail-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--gray-800);
            margin-bottom: 1.5rem;
        }

        .info-grid {
            display: grid;
            gap: 1.25rem;
        }

        .info-row {
            display: grid;
            grid-template-columns: 160px 1fr;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid var(--gray-200);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: var(--gray-600);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-label i {
            color: var(--navy);
            width: 20px;
        }

        .info-value {
            color: var(--gray-800);
            font-weight: 500;
        }

        /* Map Section */
        .map-section {
            padding: 2rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-title i {
            color: var(--navy);
        }

        #map {
            width: 100%;
            height: 400px;
            border-radius: 8px;
            overflow: hidden;
        }

        .map-actions {
            margin-top: 1rem;
            display: flex;
            gap: 0.75rem;
        }

        .btn-map {
            padding: 0.75rem 1.5rem;
            background: var(--green);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
        }

        .btn-map:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        /* Right Sidebar */
        .detail-sidebar {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .sidebar-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        }

        .sidebar-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sidebar-title i {
            color: var(--navy);
        }

        /* Contact Buttons */
        .contact-grid {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .btn-contact {
            padding: 0.875rem 1.25rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s;
            border: 2px solid;
        }

        .btn-phone {
            background: var(--green);
            color: white;
            border-color: var(--green);
        }

        .btn-phone:hover {
            background: #059669;
            transform: translateY(-2px);
        }

        .btn-email {
            background: var(--navy);
            color: white;
            border-color: var(--navy);
        }

        .btn-email:hover {
            background: var(--navy-deep);
            transform: translateY(-2px);
        }

        .btn-website {
            background: var(--gold);
            color: var(--gray-800);
            border-color: var(--gold);
        }

        .btn-website:hover {
            background: var(--gold-light);
            transform: translateY(-2px);
        }

        /* Quick Info */
        .quick-info {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .quick-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: var(--gray-50);
            border-radius: 8px;
        }

        .quick-icon {
            width: 40px;
            height: 40px;
            background: var(--navy);
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .quick-content {
            flex: 1;
        }

        .quick-label {
            font-size: 0.75rem;
            color: var(--gray-600);
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 0.25rem;
        }

        .quick-value {
            font-size: 0.9375rem;
            color: var(--gray-800);
            font-weight: 600;
        }

        /* Share Section */
        .share-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-share {
            flex: 1;
            padding: 0.75rem;
            border: 2px solid var(--gray-200);
            background: white;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            color: var(--gray-600);
            text-align: center;
        }

        .btn-share:hover {
            border-color: var(--navy);
            color: var(--navy);
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .detail-grid {
                grid-template-columns: 1fr;
            }

            .detail-sidebar {
                order: -1;
            }
        }

        @media (max-width: 768px) {
            .detail-title {
                font-size: 1.5rem;
            }

            .info-row {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }

            .detail-image-wrapper {
                height: 250px;
            }

            .map-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="top-bar-container">
            <a href="{{ route('fasyankes.public') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Daftar
            </a>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="nav-brand">
                <div class="nav-brand-logo"><i class="fas fa-hospital"></i></div>
                 <span class="nav-title">DINAS KESEHATAN</span><br>
                <p>KABUPATEN SEMARANG</p>
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="detail-grid">
            <!-- Left Column -->
            <div class="detail-main">
                <!-- Info Card -->
                <div class="detail-card">
                    <div class="detail-info">
                        <h1 class="detail-title">{{ $fasyankes->nama }}</h1>

                        <div class="info-grid">
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fas fa-folder"></i>
                                    Kategori
                                </div>
                                <div class="info-value">{{ $fasyankes->kategori->nama ?? '-' }}</div>
                            </div>

                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Alamat
                                </div>
                                <div class="info-value">{{ $fasyankes->alamat }}</div>
                            </div>

                            @if($fasyankes->telepon)
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fas fa-phone"></i>
                                    Telepon
                                </div>
                                <div class="info-value">{{ $fasyankes->telepon }}</div>
                            </div>
                            @endif

                            @if($fasyankes->email)
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fas fa-envelope"></i>
                                    Email
                                </div>
                                <div class="info-value">{{ $fasyankes->email }}</div>
                            </div>
                            @endif

                            @if($fasyankes->website)
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fas fa-globe"></i>
                                    Website
                                </div>
                                <div class="info-value">
                                    <a href="{{ $fasyankes->website }}" target="_blank" style="color: var(--navy); text-decoration: underline;">
                                        {{ $fasyankes->website }}
                                    </a>
                                </div>
                            </div>
                            @endif

                            @if($fasyankes->deskripsi)
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fas fa-info-circle"></i>
                                    Deskripsi
                                </div>
                                <div class="info-value">{{ $fasyankes->deskripsi }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Map Card -->
                @if($fasyankes->latitude && $fasyankes->longitude)
                <div class="detail-card">
                    <div class="map-section">
                        <h2 class="section-title">
                            <i class="fas fa-map-marked-alt"></i>
                            Lokasi
                        </h2>
                        <div id="map"></div>
                        <div class="map-actions">
                            <a href="https://www.google.com/maps?q={{ $fasyankes->latitude }},{{ $fasyankes->longitude }}" 
                               target="_blank" 
                               class="btn-map">
                                <i class="fas fa-directions"></i>
                                Lihat di Google Maps
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Sidebar -->
            <div class="detail-sidebar">
                <!-- Contact Card -->
                @if($fasyankes->telepon || $fasyankes->email || $fasyankes->website)
                <div class="sidebar-card">
                    <h3 class="sidebar-title">
                        <i class="fas fa-phone-volume"></i>
                        Hubungi Kami
                    </h3>
                    <div class="contact-grid">
                        @if($fasyankes->telepon)
                        <a href="tel:{{ $fasyankes->telepon }}" class="btn-contact btn-phone">
                            <i class="fas fa-phone"></i>
                            <span>Telepon</span>
                        </a>
                        @endif

                        @if($fasyankes->email)
                        <a href="mailto:{{ $fasyankes->email }}" class="btn-contact btn-email">
                            <i class="fas fa-envelope"></i>
                            <span>Email</span>
                        </a>
                        @endif

                        @if($fasyankes->website)
                        <a href="{{ $fasyankes->website }}" target="_blank" class="btn-contact btn-website">
                            <i class="fas fa-globe"></i>
                            <span>Website</span>
                        </a>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Quick Info -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">
                        <i class="fas fa-info-circle"></i>
                        Info Singkat
                    </h3>
                    <div class="quick-info">
                        <div class="quick-item">
                            <div class="quick-icon">
                                <i class="fas fa-folder"></i>
                            </div>
                            <div class="quick-content">
                                <div class="quick-label">Jenis</div>
                                <div class="quick-value">{{ $fasyankes->kategori->nama ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="quick-item">
                            <div class="quick-icon">
                                <i class="fas fa-toggle-on"></i>
                            </div>
                            <div class="quick-content">
                                <div class="quick-label">Status</div>
                                <div class="quick-value" style="color: {{ $fasyankes->kode ? 'var(--green)' : 'var(--red)' }}">
                                    {{ $fasyankes->kode ? 'Aktif' : 'Tidak Aktif' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Share -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">
                        <i class="fas fa-share-alt"></i>
                        Bagikan
                    </h3>
                    <div class="share-buttons">
                        <button class="btn-share" onclick="shareToFacebook()" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </button>
                        <button class="btn-share" onclick="shareToTwitter()" title="Twitter">
                            <i class="fab fa-twitter"></i>
                        </button>
                        <button class="btn-share" onclick="shareToWhatsApp()" title="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </button>
                        <button class="btn-share" onclick="copyLink()" title="Salin Link">
                            <i class="fas fa-link"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Initialize Map
        @if($fasyankes->latitude && $fasyankes->longitude)
        const map = L.map('map').setView([{{ $fasyankes->latitude }}, {{ $fasyankes->longitude }}], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        const marker = L.marker([{{ $fasyankes->latitude }}, {{ $fasyankes->longitude }}]).addTo(map);
        marker.bindPopup('<b>{{ $fasyankes->nama }}</b><br>{{ $fasyankes->alamat }}').openPopup();
        @endif

        // Share Functions
        function shareToFacebook() {
            window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href), '_blank');
        }

        function shareToTwitter() {
            window.open('https://twitter.com/intent/tweet?url=' + encodeURIComponent(window.location.href) + '&text=' + encodeURIComponent('{{ $fasyankes->nama }}'), '_blank');
        }

        function shareToWhatsApp() {
            window.open('https://api.whatsapp.com/send?text=' + encodeURIComponent('{{ $fasyankes->nama }} - ' + window.location.href), '_blank');
        }

        function copyLink() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Link berhasil disalin!');
            });
        }
    </script>
</body>
</html>