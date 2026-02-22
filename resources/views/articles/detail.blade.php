<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article->title }} - {{ config('app.name') }}</title>
    
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
            --gold: #fbbf24;
            --white: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --green: #10b981;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--gray-50);
            color: var(--gray-800);
            line-height: 1.7;
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

        .content-grid {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 2.5rem;
        }

        /* Article Main */
        .article-main {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        }

        /* Article Header */
        .article-header {
            padding: 2.5rem 2.5rem 0;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--gray-600);
            margin-bottom: 1.5rem;
        }

        .breadcrumb a {
            color: var(--navy);
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .category-label {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--navy);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .article-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--gray-800);
            line-height: 1.3;
            margin-bottom: 1.5rem;
        }

        .article-meta {
            display: flex;
            align-items: center;
            gap: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid var(--gray-200);
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9375rem;
            color: var(--gray-600);
        }

        .meta-item i {
            color: var(--navy);
        }

        .author-meta {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .author-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--navy);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .author-info {
            display: flex;
            flex-direction: column;
        }

        .author-name {
            font-weight: 600;
            color: var(--gray-800);
        }

        .author-role {
            font-size: 0.8125rem;
            color: var(--gray-600);
        }

        /* Featured Image */
        .featured-image-wrapper {
            width: 100%;
            height: 500px;
            margin: 2rem 0;
        }

        .featured-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Article Content */
        .article-content {
            padding: 2.5rem;
            font-size: 1.0625rem;
            line-height: 1.8;
            color: var(--gray-700);
        }

        .article-content h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-800);
            margin: 2rem 0 1rem;
        }

        .article-content h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-800);
            margin: 1.5rem 0 1rem;
        }

        .article-content p {
            margin-bottom: 1.25rem;
        }

        .article-content ul,
        .article-content ol {
            margin: 1rem 0 1.5rem 1.5rem;
        }

        .article-content li {
            margin-bottom: 0.5rem;
        }

        .article-content blockquote {
            border-left: 4px solid var(--navy);
            padding-left: 1.5rem;
            margin: 1.5rem 0;
            font-style: italic;
            color: var(--gray-600);
        }

        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 1.5rem 0;
        }

        /* Article Footer */
        .article-footer {
            padding: 2rem 2.5rem;
            border-top: 2px solid var(--gray-200);
        }

        .share-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .share-title {
            font-weight: 600;
            color: var(--gray-700);
        }

        .share-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-share {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--gray-200);
            background: white;
            color: var(--gray-600);
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-share:hover {
            border-color: var(--navy);
            color: var(--navy);
            transform: translateY(-2px);
        }

        /* Sidebar */
        .article-sidebar {
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

        /* Related Articles */
        .related-item {
            display: flex;
            gap: 1rem;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .related-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .related-image {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .related-content {
            flex: 1;
        }

        .related-title {
            font-size: 0.9375rem;
            font-weight: 600;
            color: var(--gray-800);
            line-height: 1.4;
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .related-title a {
            color: var(--gray-800);
            text-decoration: none;
        }

        .related-title a:hover {
            color: var(--navy);
        }

        .related-date {
            font-size: 0.8125rem;
            color: var(--gray-600);
        }

        /* Popular Articles */
        .popular-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .popular-item:hover {
            background: var(--gray-50);
        }

        .popular-rank {
            width: 32px;
            height: 32px;
            background: var(--navy);
            color: white;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        .popular-title {
            font-size: 0.9375rem;
            font-weight: 600;
            color: var(--gray-800);
            line-height: 1.4;
        }

        .popular-title a {
            color: var(--gray-800);
            text-decoration: none;
        }

        .popular-title a:hover {
            color: var(--navy);
        }

        /* Categories List */
        .category-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.875rem;
            border-radius: 8px;
            text-decoration: none;
            color: var(--gray-700);
            transition: all 0.3s;
        }

        .category-item:hover {
            background: var(--gray-50);
            color: var(--navy);
        }

        .category-name {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
        }

        .category-count {
            background: var(--gray-200);
            color: var(--gray-700);
            padding: 0.25rem 0.625rem;
            border-radius: 12px;
            font-size: 0.8125rem;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr;
            }

            .article-sidebar {
                order: -1;
            }
        }

        @media (max-width: 768px) {
            .article-title {
                font-size: 1.75rem;
            }

            .article-content {
                padding: 1.5rem;
                font-size: 1rem;
            }

            .article-header {
                padding: 1.5rem 1.5rem 0;
            }

            .article-footer {
                padding: 1.5rem;
            }

            .featured-image-wrapper {
                height: 300px;
            }

            .article-meta {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="top-bar-container">
            <a href="{{ route('articles.public') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Daftar Artikel
            </a>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="nav-brand">
                <div class="nav-brand-logo"><i class="fas fa-hospital"></i></div>
                <span class="nav-title">DINAS KESEHATAN</span>
                <p>KABUPATEN SEMARANG</p>
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="content-grid">
            <!-- Article Main -->
            <article class="article-main">
                <!-- Article Header -->
                <div class="article-header">
                    <div class="breadcrumb">
                        <a href="{{ route('home') }}">Beranda</a>
                        <i class="fas fa-chevron-right" style="font-size: 0.75rem;"></i>
                        <a href="{{ route('articles.public') }}">Berita</a>
                        <i class="fas fa-chevron-right" style="font-size: 0.75rem;"></i>
                        <span>{{ Str::limit($article->title, 50) }}</span>
                    </div>

                    <span class="category-label">
                        <i class="fas fa-newspaper"></i>
                        {{ $article->category->name ?? 'Umum' }}
                    </span>

                    <h1 class="article-title">{{ $article->title }}</h1>

                    <div class="article-meta">
                        <div class="author-meta">
                            <div class="author-avatar">
                                {{ strtoupper(substr($article->author->name ?? 'A', 0, 1)) }}
                            </div>
                            <div class="author-info">
                                <span class="author-name">{{ $article->author->name ?? 'Admin' }}</span>
                                <span class="author-role">Penulis</span>
                            </div>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-calendar"></i>
                            <span>{{ $article->article_date ? $article->article_date->format('d F Y') : '-' }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-eye"></i>
                            <span>{{ $article->views ?? 0 }} views</span>
                        </div>
                        @php
                            $averageRating = $approvedComments->avg('rating');
                            $totalComments = $approvedComments->count();
                        @endphp

                        <div class="article-rating">
                            <div class="rating-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= round($averageRating) ? 'star-filled' : 'star-empty' }}"></i>
                                @endfor
                            </div>
                            <span class="rating-text">
                                {{ number_format($averageRating, 1) }} dari 5 ({{ $totalComments }} ulasan)
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                @if($article->image)
                <div class="featured-image-wrapper">
                    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="featured-image">
                </div>
                @endif

                <!-- Article Content -->
                <div class="article-content">
                    {!! $article->content !!}
                </div>

                <!-- Article Footer -->
                <div class="article-footer">
                    <div class="share-section">
                        <span class="share-title">Bagikan:</span>
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
            </article>

            <!-- Sidebar -->
            <aside class="article-sidebar">
                <!-- Related Articles -->
                @if(isset($relatedArticles) && $relatedArticles->count() > 0)
                <div class="sidebar-card">
                    <h3 class="sidebar-title">
                        <i class="fas fa-newspaper"></i>
                        Artikel Terkait
                    </h3>
                    @foreach($relatedArticles as $related)
                        <div class="related-item">
                            <img 
                                src="{{ $related->image ? asset('storage/' . $related->image) : 'https://via.placeholder.com/80x80/1e40af/ffffff' }}" 
                                alt="{{ $related->title }}" 
                                class="related-image"
                            >
                            <div class="related-content">
                                <h4 class="related-title">
                                    <a href="{{ route('articles.show', $related->id) }}">
                                        {{ $related->title }}
                                    </a>
                                </h4>
                                <div class="related-date">
                                    <i class="fas fa-calendar" style="font-size: 0.75rem;"></i>
                                    {{ $related->article_date ? $related->article_date->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif

                <!-- Popular Articles -->
                @if(isset($popularArticles) && $popularArticles->count() > 0)
                <div class="sidebar-card">
                    <h3 class="sidebar-title">
                        <i class="fas fa-fire"></i>
                        Artikel Populer
                    </h3>
                    @foreach($popularArticles as $index => $popular)
                        <div class="popular-item">
                            <div class="popular-rank">{{ $index + 1 }}</div>
                            <div class="popular-title">
                                <a href="{{ route('articles.show', $popular->id) }}">
                                    {{ $popular->title }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif

                <!-- Categories -->
                @if(isset($categories) && $categories->count() > 0)
                <div class="sidebar-card">
                    <h3 class="sidebar-title">
                        <i class="fas fa-folder"></i>
                        Kategori
                    </h3>
                    @foreach($categories as $category)
                        <a href="{{ route('articles.public', ['category' => $category->id]) }}" class="category-item">
                            <span class="category-name">
                                <i class="fas fa-folder"></i>
                                {{ $category->name }}
                            </span>
                            <span class="category-count">{{ $category->articles_count }}</span>
                        </a>
                    @endforeach
                </div>
                @endif
            </aside>
        </div>
    </div>

    <script>
        // Share Functions
        function shareToFacebook() {
            window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href), '_blank');
        }

        function shareToTwitter() {
            window.open('https://twitter.com/intent/tweet?url=' + encodeURIComponent(window.location.href) + '&text=' + encodeURIComponent('{{ $article->title }}'), '_blank');
        }

        function shareToWhatsApp() {
            window.open('https://api.whatsapp.com/send?text=' + encodeURIComponent('{{ $article->title }} - ' + window.location.href), '_blank');
        }

        function copyLink() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Link berhasil disalin!');
            });
        }

        // Update view count (optional)
        @if(isset($article))
        fetch('{{ route("articles.view", $article->id) }}', { 
            method: 'POST', 
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        });
        @endif
    </script>
    <!-- Comment Form & List -->
@include('components.comment-form-section')
</body>
</html>