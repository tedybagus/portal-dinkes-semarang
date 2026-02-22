<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Portal Dinas Kesehatan') - {{ config('app.name') }}</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    @stack('styles')
    
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
            --purple: #8b5cf6;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--gray-50);
            color: var(--gray-800);
            line-height: 1.6;
        }

       /* Top Bar */
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

        .top-bar-item a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: color 0.3s;
        }

        .top-bar-item a:hover {
            color: white;
        }

        .btn-login-admin {
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

        .btn-login-admin:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
        }
        .btn-read {
            padding: 0.625rem 1.25rem;
            background: var(--navy);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-read:hover {
            background: var(--navy-deep);
            transform: translateX(2px);
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

        .nav-menu {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-link {
            color: var(--gray-700);
            text-decoration: none;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            transition: all 0.3s;
            position: relative;
        }

        .nav-link:hover {
            color: var(--navy);
            background: var(--gray-50);
        }

        .nav-link.active {
            color: var(--navy);
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -0.5rem;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 3px;
            background: var(--gold);
            border-radius: 3px;
        }

        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--navy);
            cursor: pointer;
        }

        /* Breadcrumb */
        .breadcrumb-section {
            background: white;
            border-bottom: 1px solid var(--gray-200);
        }

        .breadcrumb-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 1rem 2rem;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--gray-600);
            flex-wrap: wrap;
        }

        .breadcrumb-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .breadcrumb-item a {
            color: var(--navy);
            text-decoration: none;
            transition: color 0.3s;
        }

        .breadcrumb-item a:hover {
            color: var(--navy-deep);
            text-decoration: underline;
        }

        .breadcrumb-item.active {
            color: var(--gray-700);
            font-weight: 600;
        }

        .breadcrumb-separator {
            color: var(--gray-400);
            font-size: 0.75rem;
        }

        /* Main Content */
        .main-content {
            min-height: calc(100vh - 350px);
        }

     /* Page Header */
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

        /* Filter & Search */
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
            grid-template-columns: 1fr 1fr auto;
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

        /* Category Tabs */
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

        /* Results Header */
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

        /* Articles Container */
        .articles-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem 4rem;
        }

        .articles-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        /* Article Card */
        .article-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
            border: 2px solid transparent;
            display: flex;
            flex-direction: column;
        }

        .article-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
            border-color: var(--navy);
        }

        .card-image-wrapper {
            position: relative;
            width: 100%;
            height: 220px;
            overflow: hidden;
            background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
        }

        .card-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .article-card:hover .card-image {
            transform: scale(1.1);
        }

        .status-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .status-badge.published {
            color: var(--green);
        }

        .status-badge.draft {
            color: var(--gray-600);
        }

        .category-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 700;
            color: white;
            font-size: 0.75rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .category-badge.kesehatan { background: #10b981; }
        .category-badge.p2p { background: #f59e0b; }
        .category-badge.umum { background: #3b82f6; }
        .category-badge.pengumuman { background: #8b5cf6; }

        /* Card Body */
        .card-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .card-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .meta-item i {
            color: var(--navy);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 0.75rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-excerpt {
            font-size: 0.9375rem;
            color: var(--gray-600);
            line-height: 1.6;
            margin-bottom: 1.25rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex: 1;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid var(--gray-200);
        }

        .author-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .author-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--navy);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
        }

        .author-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-700);
        }

        .btn-read {
            padding: 0.625rem 1.25rem;
            background: var(--navy);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-read:hover {
            background: var(--navy-deep);
            transform: translateX(2px);
        }

        /* Featured Article (Large Card) */
        .featured-section {
            max-width: 1280px;
            margin: 0 auto 3rem;
            padding: 0 2rem;
        }

        .featured-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .featured-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .featured-content {
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .featured-label {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--gold);
            font-weight: 700;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .featured-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--gray-800);
            margin-bottom: 1rem;
            line-height: 1.3;
        }

        .featured-excerpt {
            font-size: 1.0625rem;
            color: var(--gray-600);
            line-height: 1.7;
            margin-bottom: 1.5rem;
        }

        /* Empty State */
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

        /* Pagination */
      
        /* ============================================
   FOOTER - COMPACT VERSION
   ============================================ */

            .footer {
                background: #1f2937;
                color: white;
                padding: 2rem 0 1rem; /* Dikurangi dari 3rem jadi 2rem */
                margin-top: 4rem;
            }

            .footer-container {
                max-width: 1280px;
                margin: 0 auto;
                padding: 0 2rem;
            }

            /* Footer Grid - Lebih Compact */
            .footer-grid {
                display: grid;
                grid-template-columns: 2fr 1fr 1fr 1fr;
                gap: 2rem; /* Dikurangi dari 3rem jadi 2rem */
                margin-bottom: 1.5rem; /* Dikurangi dari 2rem jadi 1.5rem */
            }

            .footer-section h3 {
                color: white;
                font-size: 1rem; /* Dikurangi dari 1.125rem */
                font-weight: 700;
                margin-bottom: 0.75rem; /* Dikurangi dari 1rem */
            }

            .footer-section p {
                color: rgba(255, 255, 255, 0.8);
                font-size: 0.875rem; /* Dikurangi dari 0.9375rem */
                line-height: 1.6; /* Dikurangi dari 1.7 */
                margin-bottom: 0; /* Hilangkan margin bottom */
            }

            .footer-links {
                display: flex;
                flex-direction: column;
                gap: 0.5rem; /* Dikurangi dari 0.75rem */
            }

            .footer-link {
                color: rgba(255, 255, 255, 0.8);
                text-decoration: none;
                transition: all 0.3s;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                font-size: 0.875rem; /* Dikurangi dari 0.9375rem */
            }

            .footer-link:hover {
                color: #fbbf24;
                padding-left: 0.5rem;
            }

            .footer-link i {
                font-size: 0.75rem;
            }

            /* Footer Bottom - Social Media di Tengah */
            .footer-bottom {
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                padding-top: 1rem; /* Dikurangi dari 1.5rem */
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 0.75rem;
            }

            .footer-social {
                display: flex;
                gap: 0.75rem; /* Dikurangi dari 1rem */
                justify-content: center;
                order: 1; /* Social media di atas */
            }

            .social-link {
                width: 36px; /* Dikurangi dari 40px */
                height: 36px;
                background: rgba(255, 255, 255, 0.1);
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                text-decoration: none;
                transition: all 0.3s;
                font-size: 0.875rem; /* Ukuran icon */
            }

            .social-link:hover {
                background: #fbbf24;
                transform: translateY(-3px);
                box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);
            }

            .footer-text {
                color: rgba(255, 255, 255, 0.7);
                font-size: 0.8125rem; /* Dikurangi dari 0.875rem */
                margin: 0;
                order: 2; /* Copyright di bawah */
                text-align: center;
            }
  
        /* Responsive */
        @media (max-width: 1024px) {
            .articles-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .featured-card {
                grid-template-columns: 1fr;
            }

            .filter-grid {
                grid-template-columns: 1fr 1fr;
            }
         .footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }

            .articles-grid {
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

            .featured-title {
                font-size: 1.5rem;
            }

            .featured-image {
                height: 250px;
            }
             .footer {
                padding: 1.5rem 0 1rem;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
                margin-bottom: 1rem;
            }

            .footer-section h3 {
                font-size: 0.9375rem;
            }

            .footer-social {
                gap: 0.5rem;
            }

            .social-link {
                width: 32px;
                height: 32px;
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

            .card-image-wrapper {
                height: 180px;
            }
             .footer {
                margin-top: 2rem;
            }
        }
        
    </style>
</head>
<body>
    <!-- Top Bar -->
    @include('layouts.public.topbar')

    <!-- Navbar -->
    {{-- @include('layouts.public.navbar') --}}

    <!-- Breadcrumb -->
    @if(isset($breadcrumbs) && count($breadcrumbs) > 0)
        @include('layouts.public.breadcrumb', ['breadcrumbs' => $breadcrumbs])
    @endif

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.public.footer')

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        const mobileToggle = document.getElementById('mobile-menu-toggle');
        const navMenu = document.getElementById('nav-menu');
        
        if (mobileToggle) {
            mobileToggle.addEventListener('click', () => {
                navMenu.classList.toggle('active');
            });
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (navMenu && !navMenu.contains(e.target) && !mobileToggle.contains(e.target)) {
                navMenu.classList.remove('active');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>