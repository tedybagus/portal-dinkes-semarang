@extends('layouts.public.app')

@section('title', 'Alur Permohonan Informasi')

@section('content')
<!-- Hero Section -->
<section class="page-hero-info">
    <div class="container">
        <div class="hero-content">
            <div class="breadcrumb-wrapper">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Permohonan Informasi</li>
                    </ol>
                </nav>
            </div>
            <h1 class="hero-title">
                <i class="fas fa-file-alt"></i>
                Permohonan Informasi Publik
            </h1>
            <p class="hero-description">
                Layanan Keterbukaan Informasi Publik Dinas Kesehatan Kabupaten Semarang
            </p>
        </div>
    </div>
</section>

<!-- Quick Actions -->
<section class="quick-actions-section">
    <div class="container">
        <div class="quick-actions-grid">
            <a href="{{ route('information.create') }}" class="action-card primary">
                <div class="action-icon">
                    <i class="fas fa-file-upload"></i>
                </div>
                <h3>Ajukan Permohonan</h3>
                <p>Ajukan permohonan informasi publik</p>
                <span class="action-arrow"><i class="fas fa-arrow-right"></i></span>
            </a>

            <a href="{{ route('information.tracking') }}" class="action-card secondary">
                <div class="action-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3>Lacak Permohonan</h3>
                <p>Cek status permohonan Anda</p>
                <span class="action-arrow"><i class="fas fa-arrow-right"></i></span>
            </a>

            <a href="#faq" class="action-card tertiary">
                <div class="action-icon">
                    <i class="fas fa-question-circle"></i>
                </div>
                <h3>FAQ</h3>
                <p>Pertanyaan yang sering diajukan</p>
                <span class="action-arrow"><i class="fas fa-arrow-right"></i></span>
            </a>
        </div>
    </div>
</section>

<!-- Flow Steps -->
<section class="flow-section">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-badge">
                <i class="fas fa-route"></i>
                Alur Permohonan
            </span>
            <h2 class="section-title">Alur Permohonan Informasi</h2>
            <p class="section-description">
                Ikuti langkah-langkah berikut untuk mengajukan permohonan informasi publik:
            </p>
            
        </div>

        <div class="flow-timeline">
            @foreach($flows as $index => $flow)
            <div class="flow-step" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <div class="step-number">
                    <span>{{ $flow->step_number }}</span>
                </div>
                <div class="step-content">
                    <div class="step-icon">
                        <i class="fas {{ $flow->icon ?? 'fa-check' }}"></i>
                    </div>
                    <h3 class="step-title">{{ $flow->title }}</h3>
                    <p class="step-description">{{ $flow->description }}</p>
                    @if($flow->duration_days)
                    <div class="step-duration">
                        <i class="fas fa-clock"></i>
                        <span>Estimasi: {{ $flow->duration_days }} hari kerja</span>
                    </div>
                    @endif
                </div>
                @if(!$loop->last)
                <div class="step-connector"></div>
                @endif
            </div>
            @endforeach
        </div>

        <div class="flow-action text-center">
            <a href="{{ route('information.create') }}" class="btn-primary-large">
                <i class="fas fa-paper-plane"></i>
                Ajukan Permohonan Sekarang
            </a>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section" id="faq">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-badge">
                <i class="fas fa-question-circle"></i>
                FAQ
            </span>
            <h2 class="section-title">Pertanyaan yang Sering Diajukan</h2>
            <p class="section-description">
                Temukan jawaban untuk pertanyaan umum seputar permohonan informasi
            </p>
        </div>

        <div class="faq-container">
            @forelse($faqs as $faq)
            <div class="faq-item">
                <button class="faq-question" onclick="toggleFaq(this)">
                    <span>{{ $faq->question }}</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>{{ $faq->answer }}</p>
                </div>
            </div>
            @empty
            <div class="empty-faq">
                <i class="fas fa-inbox"></i>
                <p>Belum ada FAQ tersedia</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Info Alert -->
<section class="info-alert-section">
    <div class="container">
        <div class="info-alert-box">
            <div class="alert-icon">
                <i class="fas fa-info-circle"></i>
            </div>
            <div class="alert-content">
                <h4>Informasi Penting</h4>
                <ul>
                    <li>Setiap permohonan informasi akan mendapatkan nomor registrasi</li>
                    <li>Proses verifikasi dan pengolahan maksimal 14 hari kerja</li>
                    <li>Pastikan data yang Anda isi sudah benar dan lengkap</li>
                    <li>Simpan nomor registrasi untuk melacak status permohonan</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<style>
/* Hero Section */
.page-hero-info {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
    padding: 3rem 0 4rem;
    margin-bottom: -2rem;
}

.hero-content {
    color: white;
    margin-left: 10em;
    margin-right: 10em;
}

.breadcrumb {
    background: rgba(255, 255, 255, 0.1);
    padding: 0.75rem 1.25rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    display: inline-flex;
}

.breadcrumb-item a {
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
}

.breadcrumb-item.active {
    color: white;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    color: rgba(255, 255, 255, 0.7);
    padding: 0 0.5rem;
}

.hero-title {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.hero-description {
    font-size: 1.125rem;
    opacity: 0.95;
}

/* Quick Actions */
.quick-actions-section {
    padding: 4rem 0 3rem;
    margin-top: -2rem;
}

.quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-left: 10em;
    margin-right: 10em;
}

.action-card {
    position: relative;
    background: white;
    padding: 2rem;
    border-radius: 16px;
    text-decoration: none;
    color: inherit;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s;
    overflow: hidden;
}

.action-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #3b82f6, #2563eb);
}

.action-card.primary::before {
    background: linear-gradient(90deg, #10b981, #059669);
}

.action-card.secondary::before {
    background: linear-gradient(90deg, #f59e0b, #d97706);
}

.action-card.tertiary::before {
    background: linear-gradient(90deg, #8b5cf6, #7c3aed);
}

.action-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
}

.action-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    font-size: 1.75rem;
    color: white;
}

.action-card.primary .action-icon {
    background: linear-gradient(135deg, #10b981, #059669);
}

.action-card.secondary .action-icon {
    background: linear-gradient(135deg, #f59e0b, #d97706);
}

.action-card.tertiary .action-icon {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
}

.action-card h3 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: #1e293b;
}

.action-card p {
    color: #64748b;
    margin-bottom: 1rem;
}

.action-arrow {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background: #f1f5f9;
    border-radius: 50%;
    color: #3b82f6;
    transition: all 0.3s;
}

.action-card:hover .action-arrow {
    transform: translateX(4px);
}

/* Flow Section */
.flow-section {
    padding: 4rem 0;
    background: #f8fafc;
    margin-left: 10em;
    margin-right: 10em;
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
    margin-left: 0em;
    text-align: justify;
}

.flow-timeline {
    max-width: 900px;
    margin: 0 auto;
    padding: 2rem 0;
}

.flow-step {
    position: relative;
    display: grid;
    grid-template-columns: 80px 1fr;
    gap: 2rem;
    margin-bottom: 3rem;
}

.step-number {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border-radius: 50%;
    color: white;
    font-size: 1.5rem;
    font-weight: 800;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    z-index: 2;
}

.step-content {
    background: white;
    padding: 2rem;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.step-icon {
    width: 48px;
    height: 48px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    color: #1e40af;
    border-radius: 12px;
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

.step-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.75rem;
}

.step-description {
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.step-duration {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #10b981;
    font-size: 0.9375rem;
    font-weight: 600;
}

.step-connector {
    position: absolute;
    left: 30px;
    top: 60px;
    width: 2px;
    height: calc(100% + 3rem);
    background: linear-gradient(to bottom, #3b82f6, #dbeafe);
}

.flow-action {
    margin-top: 3rem;
}

.btn-primary-large {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1.25rem 2.5rem;
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 1.125rem;
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
    transition: all 0.3s;
}

.btn-primary-large:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(16, 185, 129, 0.4);
    color: white;
}

/* FAQ Section */
.faq-section {
    padding: 4rem 0;
    background: white;
    margin-left: 10em;
    margin-right: 10em;
}

.faq-container {
    max-width: 900px;
    margin: 0 auto;
}

.faq-item {
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    margin-bottom: 1rem;
    overflow: hidden;
    transition: all 0.3s;
}

.faq-item:hover {
    border-color: #3b82f6;
}

.faq-question {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    background: none;
    border: none;
    text-align: left;
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    cursor: pointer;
    transition: all 0.3s;
}

.faq-question i {
    transition: transform 0.3s;
    color: #3b82f6;
}

.faq-item.active .faq-question i {
    transform: rotate(180deg);
}

.faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease-out;
}

.faq-item.active .faq-answer {
    max-height: 500px;
}

.faq-answer p {
    padding: 0 1.5rem 1.5rem;
    color: #64748b;
    line-height: 1.8;
}

/* Info Alert */
.info-alert-section {
    padding: 3rem 0 4rem;
    background: #f8fafc;
    margin-left: 10em;
    margin-right: 10em;
}

.info-alert-box {
    display: flex;
    gap: 2rem;
    padding: 2rem;
    background: linear-gradient(135deg, #dbeafe, #eff6ff);
    border-left: 4px solid #3b82f6;
    border-radius: 12px;
}

.alert-icon {
    color: #3b82f6;
    font-size: 2.5rem;
}

.alert-content h4 {
    color: #1e40af;
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.alert-content ul {
    list-style: none;
    padding: 0;
}

.alert-content li {
    color: #1e40af;
    padding-left: 1.5rem;
    margin-bottom: 0.75rem;
    position: relative;
}

.alert-content li::before {
    content: '✓';
    position: absolute;
    left: 0;
    color: #10b981;
    font-weight: 700;
}

/* Responsive */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2rem;
    }

    .quick-actions-grid {
        grid-template-columns: 1fr;
    }

    .flow-step {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .step-number {
        margin: 0 auto;
    }

    .step-connector {
        display: none;
    }

    .info-alert-box {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>

<script>
function toggleFaq(button) {
    const faqItem = button.parentElement;
    const isActive = faqItem.classList.contains('active');
    
    // Close all
    document.querySelectorAll('.faq-item').forEach(item => {
        item.classList.remove('active');
    });
    
    // Open clicked if wasn't active
    if (!isActive) {
        faqItem.classList.add('active');
    }
}
</script>
@endsection