<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fasilitas Pelayanan Kesehatan - {{ config('app.name') }}</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
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
            --gray-300: #d1d5db;
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

        /* ============================================
           TOP BAR
           ============================================ */
        .top-bar {
            background: var(--navy-deep);
            color: white;
            padding: 0.75rem 0;
            font-size: 0.875rem;
        }

        .top-bar-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-bar-left {
            display: flex;
            gap: 2rem;
        }

        .top-bar-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .top-bar-item i {
            color: var(--gold);
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

        /* ============================================
           NAVBAR
           ============================================ */
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
            color: var(--navy);
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

        /* ============================================
           PAGE HEADER
           ============================================ */
        .page-header {
            background: linear-gradient(135deg, var(--navy-deep) 0%, var(--navy) 100%);
            color: white;
            padding: 3rem 0 2rem;
            margin-bottom: 3rem;
        }

        .header-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            font-size: 1.125rem;
            color: rgba(255, 255, 255, 0.9);
        }

        /* ============================================
           FILTER & SEARCH SECTION
           ============================================ */
        .filter-section {
            max-width: 1280px;
            margin: -1rem auto 2rem;
            padding: 0 2rem;
        }

        .filter-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .filter-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr auto;
            gap: 1rem;
            align-items: end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--gray-700);
            font-size: 0.875rem;
        }

        .form-input,
        .form-select {
            padding: 0.75rem 1rem;
            border: 2px solid var(--gray-200);
            border-radius: 8px;
            font-size: 0.9375rem;
            transition: all 0.3s;
            font-family: 'Inter', sans-serif;
        }

        .form-input:focus,
        .form-select:focus {
            outline: none;
            border-color: var(--navy);
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .btn-filter {
            background: var(--navy);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
            height: fit-content;
        }

        .btn-filter:hover {
            background: var(--navy-deep);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
        }

        .btn-reset {
            background: var(--gray-200);
            color: var(--gray-700);
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-reset:hover {
            background: var(--gray-300);
        }

        /* ============================================
           CATEGORY TABS
           ============================================ */
        .category-tabs {
            max-width: 1280px;
            margin: 0 auto 2rem;
            padding: 0 2rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .tab-item {
            padding: 0.75rem 1.5rem;
            background: white;
            border: 2px solid var(--gray-200);
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            color: var(--gray-700);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .tab-item:hover {
            border-color: var(--navy);
            color: var(--navy);
        }

        .tab-item.active {
            background: var(--navy);
            color: white;
            border-color: var(--navy);
        }

        .tab-badge {
            background: rgba(0, 0, 0, 0.1);
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 0.75rem;
        }

        .tab-item.active .tab-badge {
            background: rgba(255, 255, 255, 0.2);
        }

        /* ============================================
           RESULTS HEADER
           ============================================ */
        .results-header {
            max-width: 1280px;
            margin: 0 auto 1.5rem;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .results-count {
            font-size: 1rem;
            color: var(--gray-600);
        }

        .results-count strong {
            color: var(--navy);
            font-weight: 700;
        }

        .view-toggle {
            display: flex;
            gap: 0.5rem;
        }

        .view-btn {
            padding: 0.5rem 0.75rem;
            background: white;
            border: 2px solid var(--gray-200);
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .view-btn:hover,
        .view-btn.active {
            background: var(--navy);
            color: white;
            border-color: var(--navy);
        }

        /* ============================================
           FASYANKES GRID
           ============================================ */
        .fasyankes-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem 4rem;
        }

        .fasyankes-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        /* ============================================
           FASYANKES CARD
           ============================================ */
        .fasyankes-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
            border: 2px solid transparent;
        }

        .fasyankes-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            border-color: var(--navy);
        }

        .card-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-category {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--navy);
            color: white;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .card-category.klinik {
            background: #3b82f6;
        }

        .card-category.rumah-sakit {
            background: #ef4444;
        }

        .card-category.puskesmas {
            background: #10b981;
        }

        .card-category.apotek {
            background: #f59e0b;
        }

        .card-category.laboratorium {
            background: #8b5cf6;
        }

        .card-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 0.75rem;
            line-height: 1.4;
        }

        .card-info {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .info-icon {
            color: var(--navy);
            width: 16px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .card-footer {
            display: flex;
            gap: 0.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--gray-200);
        }

        .btn-detail {
            flex: 1;
            padding: 0.625rem 1rem;
            background: var(--navy);
            color: white;
            text-decoration: none;
            text-align: center;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-detail:hover {
            background: var(--navy-deep);
            transform: translateY(-1px);
        }

        .btn-location {
            padding: 0.625rem 1rem;
            background: var(--green);
            color: white;
            text-decoration: none;
            text-align: center;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-location:hover {
            background: #059669;
        }

        /* ============================================
           STATUS BADGE
           ============================================ */
        .status-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .status-badge.aktif {
            color: var(--green);
        }

        .status-badge.tidak-aktif {
            color: var(--red);
        }

        .card-image-wrapper {
            position: relative;
        }

        /* ============================================
           EMPTY STATE
           ============================================ */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-icon {
            font-size: 4rem;
            color: var(--gray-300);
            margin-bottom: 1rem;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
        }

        .empty-text {
            color: var(--gray-600);
            margin-bottom: 1.5rem;
        }

        /* ============================================
           PAGINATION
           ============================================ */
        .pagination-wrapper {
            max-width: 1280px;
            margin: 2rem auto 0;
            padding: 0 2rem;
            display: flex;
            justify-content: center;
        }

        .pagination {
            display: flex;
            gap: 0.5rem;
            list-style: none;
        }

        .page-item {
            display: inline-flex;
        }

        .page-link {
            padding: 0.625rem 1rem;
            background: white;
            border: 2px solid var(--gray-200);
            border-radius: 6px;
            color: var(--gray-700);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .page-link:hover {
            background: var(--gray-100);
            border-color: var(--navy);
            color: var(--navy);
        }

        .page-item.active .page-link {
            background: var(--navy);
            color: white;
            border-color: var(--navy);
        }

        .page-item.disabled .page-link {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* ============================================
           FOOTER
           ============================================ */
        .footer {
            background: var(--gray-800);
            color: white;
            padding: 2rem 0 1rem;
            margin-top: 4rem;
        }

        .footer-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
            text-align: center;
        }

        .footer-text {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.875rem;
        }

        /* ============================================
           RESPONSIVE
           ============================================ */
        @media (max-width: 1024px) {
            .fasyankes-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .filter-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }

            .fasyankes-grid {
                grid-template-columns: 1fr;
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }

            .category-tabs {
                overflow-x: auto;
                flex-wrap: nowrap;
            }

            .top-bar-left {
                flex-direction: column;
                gap: 0.5rem;
            }

            .results-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
        }

        @media (max-width: 640px) {
            .nav-title {
                font-size: 1rem;
            }

            .nav-logo {
                width: 40px;
                height: 40px;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .page-subtitle {
                font-size: 1rem;
            }

            .card-image {
                height: 160px;
            }
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="top-bar-container">
            <div class="top-bar-left">
                <div class="top-bar-item">
                    <i class="fas fa-phone"></i>
                    <span>(024) 6923955</span>
                </div>
                <div class="top-bar-item">
                    <i class="fas fa-envelope"></i>
                    <span>dinkeskabsemarang@gmail.com</span>
                </div>
            </div>
            <a href="{{ route('home') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Beranda
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

    <!-- Page Header -->
    <div class="page-header">
        <div class="header-container">
            <h1 class="page-title">Fasilitas Pelayanan Kesehatan</h1>
            <p class="page-subtitle">Kabupaten Semarang</p>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="filter-section">
        <div class="filter-card">
            <form action="{{ route('fasyankes.public') }}" method="GET">
                <div class="filter-grid">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-search"></i> Cari Fasyankes
                        </label>
                        <input 
                            type="text" 
                            name="search" 
                            class="form-input" 
                            placeholder="Nama fasyankes atau alamat..."
                            value="{{ request('search') }}"
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-folder"></i> Kategori
                        </label>
                        <select name="kategori" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-toggle-on"></i> Status
                        </label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn-filter">
                            <i class="fas fa-filter"></i>
                            Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Category Tabs (Optional Quick Filter) -->
    <div class="category-tabs">
        <a href="{{ route('fasyankes.public') }}" class="tab-item {{ !request('kategori') ? 'active' : '' }}">
            <i class="fas fa-th"></i>
            Semua
            <span class="tab-badge">{{ $totalFasyankes }}</span>
        </a>
        @foreach($kategoris as $kategori)
            <a href="{{ route('fasyankes.public', ['kategori' => $kategori->id]) }}" 
               class="tab-item {{ request('kategori') == $kategori->id ? 'active' : '' }}">
                <i class="fas fa-{{ $kategori->icon ?? 'hospital' }}"></i>
                {{ $kategori->nama }}
                <span class="tab-badge">{{ $kategori->fasyankes_count }}</span>
            </a>
        @endforeach
    </div>

    <!-- Results Header -->
    <div class="results-header">
        <div class="results-count">
            Menampilkan <strong>{{ $fasyankes->count() }}</strong> dari <strong>{{ $fasyankes->total() }}</strong> fasilitas kesehatan
        </div>
    </div>

    <!-- Fasyankes Grid -->
    <div class="fasyankes-container">
        @if($fasyankes->count() > 0)
            <div class="fasyankes-grid">
                @foreach($fasyankes as $item)
                    <div class="fasyankes-card">
                        <div class="card-body">
                            <span class="card-category {{ Str::slug($item->kategori->nama ?? 'umum') }}">
                                <i class="fas fa-{{ $item->kategori->icon ?? 'hospital' }}"></i>
                                {{ $item->kategori->nama ?? 'Umum' }}
                            </span>

                            <h3 class="card-title">{{ $item->nama }}</h3>

                            <div class="card-info">
                                <div class="info-item">
                                    <i class="fas fa-map-marker-alt info-icon"></i>
                                    <span>{{ Str::limit($item->alamat, 60) }}</span>
                                </div>
                                
                                @if($item->telepon)
                                    <div class="info-item">
                                        <i class="fas fa-phone info-icon"></i>
                                        <span>{{ $item->telepon }}</span>
                                    </div>
                                @endif

                                @if($item->email)
                                    <div class="info-item">
                                        <i class="fas fa-envelope info-icon"></i>
                                        <span>{{ $item->email }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="card-footer">
                                <a href="{{ route('fasyankes.show', $item->id) }}" class="btn-detail">
                                    <i class="fas fa-info-circle"></i>
                                    Detail
                                </a>
                                @if($item->latitude && $item->longitude)
                                    <a href="https://www.google.com/maps?q={{ $item->latitude }},{{ $item->longitude }}" 
                                       target="_blank" 
                                       class="btn-location"
                                       title="Lihat di Google Maps">
                                        <i class="fas fa-map-marked-alt"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($fasyankes->hasPages())
                <div class="pagination-wrapper">
                    {{ $fasyankes->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3 class="empty-title">Tidak Ada Data Ditemukan</h3>
                <p class="empty-text">Maaf, tidak ada fasilitas kesehatan yang sesuai dengan pencarian Anda.</p>
                <a href="{{ route('fasyankes.public') }}" class="btn-reset">
                    <i class="fas fa-redo"></i>
                    Reset Filter
                </a>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <p class="footer-text">&copy; {{ date('Y') }} Dinas Kesehatan. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>