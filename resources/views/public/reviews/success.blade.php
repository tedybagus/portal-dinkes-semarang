@extends('layouts.public.app')

@section('title', 'Review Berhasil Dikirim')

@section('content')
<div class="success-page">
    <div class="container">
        <div class="success-content">
            <!-- Success Animation -->
            <div class="success-animation">
                <div class="checkmark-circle">
                    <div class="checkmark-icon">
                        <i class="fas fa-check"></i>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            <h1 class="success-title">Review Berhasil Dikirim!</h1>
            <p class="success-subtitle">
                Terima kasih telah membagikan pengalaman Anda dengan kami
            </p>

            <!-- Info Cards -->
            <div class="info-cards">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="info-content">
                        <h3>Menunggu Persetujuan</h3>
                        <p>Review Anda akan ditinjau oleh admin dalam 1-2 hari kerja</p>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="info-content">
                        <h3>Akan Ditampilkan</h3>
                        <p>Setelah disetujui, review Anda akan muncul di halaman utama</p>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="info-content">
                        <h3>Membantu Kami</h3>
                        <p>Feedback Anda membantu meningkatkan kualitas layanan</p>
                    </div>
                </div>
            </div>

            <!-- What Happens Next -->
            <div class="next-steps">
                <h2>Apa Yang Terjadi Selanjutnya?</h2>
                <div class="steps-timeline">
                    <div class="step active">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h4>Review Diterima</h4>
                            <p>Kami telah menerima review Anda</p>
                            <span class="step-status">✓ Selesai</span>
                        </div>
                    </div>

                    <div class="step-line"></div>

                    <div class="step">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <h4>Moderasi Admin</h4>
                            <p>Admin akan meninjau dan memverifikasi review</p>
                            <span class="step-status">⏳ 1-2 hari kerja</span>
                        </div>
                    </div>

                    <div class="step-line"></div>

                    <div class="step">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <h4>Publikasi</h4>
                            <p>Review disetujui dan ditampilkan di website</p>
                            <span class="step-status">⏰ Segera</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Privacy Notice -->
            <div class="privacy-notice">
                <i class="fas fa-shield-alt"></i>
                <div>
                    <strong>Privasi Terjaga</strong>
                    <p>Email dan nomor telepon Anda tidak akan ditampilkan secara publik. Hanya nama dan review Anda yang akan muncul.</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="/" class="btn btn-primary">
                    <i class="fas fa-home"></i>
                    Kembali ke Beranda
                </a>
                <a href="{{ route('public.reviews.create') }}" class="btn btn-secondary">
                    <i class="fas fa-plus"></i>
                    Tulis Review Lagi
                </a>
            </div>

            <!-- Social Share -->
            <div class="social-share">
                <p>Bagikan pengalaman Anda:</p>
                <div class="share-buttons">
                    <a href="#" class="share-btn facebook" onclick="shareToFacebook(); return false;">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="share-btn twitter" onclick="shareToTwitter(); return false;">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="share-btn whatsapp" onclick="shareToWhatsApp(); return false;">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>

            <!-- Contact Support -->
            <div class="support-box">
                <h3>Butuh Bantuan?</h3>
                <p>Jika ada pertanyaan atau kendala, jangan ragu menghubungi kami:</p>
                <div class="contact-options">
                    <a href="tel:0246923955" class="contact-link">
                        <i class="fas fa-phone"></i>
                        (024) 6923955
                    </a>
                    <a href="mailto:dinkeskabsemarang@gmail.com" class="contact-link">
                        <i class="fas fa-envelope"></i>
                        dinkeskabsemarang@gmail.com
                    </a>
                    <a href="https://wa.me/628123456789" class="contact-link" target="_blank">
                        <i class="fab fa-whatsapp"></i>
                        WhatsApp Support
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.success-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 4rem 1rem;
}

.container {
    max-width: 900px;
    margin: 0 auto;
}

.success-content {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
}

/* Success Animation */
.success-animation {
    display: flex;
    justify-content: center;
    margin-bottom: 2rem;
}

.checkmark-circle {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: linear-gradient(135deg, #10b981, #059669);
    display: flex;
    align-items: center;
    justify-content: center;
    animation: scaleIn 0.5s ease-out;
}

@keyframes scaleIn {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.checkmark-icon {
    font-size: 4rem;
    color: white;
    animation: checkmarkSlide 0.5s ease-out 0.3s both;
}

@keyframes checkmarkSlide {
    0% {
        transform: translateY(20px);
        opacity: 0;
    }
    100% {
        transform: translateY(0);
        opacity: 1;
    }
}

/* Success Title */
.success-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #1e293b;
    text-align: center;
    margin-bottom: 1rem;
}

.success-subtitle {
    font-size: 1.25rem;
    color: #64748b;
    text-align: center;
    margin-bottom: 3rem;
}

/* Info Cards */
.info-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.info-card {
    padding: 1.5rem;
    background: #f8fafc;
    border-radius: 12px;
    display: flex;
    gap: 1.25rem;
    transition: all 0.3s;
}

.info-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    background: #eff6ff;
}

.info-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.info-content h3 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.info-content p {
    font-size: 0.9375rem;
    color: #64748b;
    line-height: 1.6;
}

/* Next Steps */
.next-steps {
    background: #f8fafc;
    padding: 2rem;
    border-radius: 12px;
    margin-bottom: 2rem;
}

.next-steps h2 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1e293b;
    text-align: center;
    margin-bottom: 2rem;
}

.steps-timeline {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex: 1;
    position: relative;
}

.step-number {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #e2e8f0;
    color: #64748b;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    transition: all 0.3s;
}

.step.active .step-number {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
}

.step-content {
    text-align: center;
}

.step-content h4 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.step-content p {
    font-size: 0.875rem;
    color: #64748b;
    margin-bottom: 0.5rem;
    line-height: 1.5;
}

.step-status {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    background: white;
    color: #64748b;
    border-radius: 12px;
    font-size: 0.8125rem;
    font-weight: 600;
}

.step.active .step-status {
    background: #d1fae5;
    color: #065f46;
}

.step-line {
    width: 100%;
    height: 2px;
    background: #e2e8f0;
    margin: 0 1rem;
    position: relative;
    top: -30px;
}

/* Privacy Notice */
.privacy-notice {
    display: flex;
    align-items: start;
    gap: 1rem;
    padding: 1.25rem;
    background: #dbeafe;
    border-left: 4px solid #3b82f6;
    border-radius: 8px;
    margin-bottom: 2rem;
}

.privacy-notice i {
    font-size: 2rem;
    color: #3b82f6;
}

.privacy-notice strong {
    display: block;
    color: #1e293b;
    font-size: 1.125rem;
    margin-bottom: 0.5rem;
}

.privacy-notice p {
    color: #475569;
    line-height: 1.6;
    margin: 0;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-bottom: 2rem;
}

.btn {
    padding: 1rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1rem;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(59, 130, 246, 0.4);
}

.btn-secondary {
    background: #f1f5f9;
    color: #475569;
}

.btn-secondary:hover {
    background: #e2e8f0;
}

/* Social Share */
.social-share {
    text-align: center;
    padding: 2rem 0;
    border-top: 2px solid #f1f5f9;
    border-bottom: 2px solid #f1f5f9;
    margin-bottom: 2rem;
}

.social-share p {
    color: #64748b;
    margin-bottom: 1rem;
    font-weight: 600;
}

.share-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.share-btn {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    transition: all 0.3s;
    text-decoration: none;
}

.share-btn:hover {
    transform: scale(1.1);
}

.share-btn.facebook {
    background: #1877f2;
}

.share-btn.twitter {
    background: #1da1f2;
}

.share-btn.whatsapp {
    background: #25d366;
}

/* Support Box */
.support-box {
    background: #f8fafc;
    padding: 2rem;
    border-radius: 12px;
    text-align: center;
}

.support-box h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.75rem;
}

.support-box > p {
    color: #64748b;
    margin-bottom: 1.5rem;
}

.contact-options {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.contact-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    background: white;
    color: #3b82f6;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
    border: 2px solid #e2e8f0;
}

.contact-link:hover {
    border-color: #3b82f6;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(59, 130, 246, 0.2);
}

@media (max-width: 768px) {
    .success-page {
        padding: 2rem 1rem;
    }

    .success-content {
        padding: 2rem 1.5rem;
    }

    .success-title {
        font-size: 2rem;
    }

    .info-cards {
        grid-template-columns: 1fr;
    }

    .steps-timeline {
        flex-direction: column;
        gap: 2rem;
    }

    .step-line {
        display: none;
    }

    .action-buttons {
        flex-direction: column;
    }

    .btn {
        width: 100%;
        justify-content: center;
    }

    .contact-options {
        flex-direction: column;
    }

    .contact-link {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
function shareToFacebook() {
    const url = encodeURIComponent(window.location.origin);
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
}

function shareToTwitter() {
    const text = encodeURIComponent('Saya baru saja memberikan review untuk layanan kesehatan!');
    const url = encodeURIComponent(window.location.origin);
    window.open(`https://twitter.com/intent/tweet?text=${text}&url=${url}`, '_blank', 'width=600,height=400');
}

function shareToWhatsApp() {
    const text = encodeURIComponent('Saya baru saja memberikan review untuk layanan kesehatan! Check it out: ' + window.location.origin);
    window.open(`https://wa.me/?text=${text}`, '_blank');
}
</script>

@endsection