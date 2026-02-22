@extends('layouts.public.app')

@section('title', 'Pengaduan Berhasil Dikirim')

@section('content')
<section class="success-page">
    <div class="container">
        <div class="success-content">
            <!-- Success Icon -->
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>

            <!-- Success Message -->
            <h1>Pengaduan Berhasil Dikirim!</h1>
            <p class="lead">Terima kasih telah menyampaikan pengaduan Anda. Tim kami akan segera memprosesnya.</p>

            <!-- Ticket Box dengan QR Code -->
            <div class="ticket-box">
                <div class="ticket-header">
                    <i class="fas fa-ticket-alt"></i>
                    <span>Nomor Tiket Anda</span>
                </div>
                
                <div class="ticket-main">
                    <div class="ticket-left">
                        <div class="ticket-number">{{ $complaint->ticket_number }}</div>
                        <div class="ticket-note">
                            <i class="fas fa-info-circle"></i>
                            <strong>PENTING:</strong> Simpan nomor tiket ini untuk tracking pengaduan
                        </div>
                    </div>
                    
                    <div class="ticket-right">
                        <!-- QR Code -->
                        <div class="qr-code">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ urlencode(route('public.complaints.show', $complaint->ticket_number)) }}" 
                                 alt="QR Code" 
                                 width="120" 
                                 height="120">
                            <small>Scan untuk tracking</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tracking Instructions -->
            <div class="tracking-instructions">
                <h2><i class="fas fa-search"></i> Cara Tracking Pengaduan Anda</h2>
                <p class="instruction-intro">
                    <strong>⚠️ Perhatian:</strong> Karena sistem masih dalam tahap pengembangan, 
                    notifikasi email/WhatsApp belum aktif. Gunakan cara berikut untuk tracking:
                </p>

                <div class="methods-grid">
                    <div class="method-card">
                        <div class="method-number">1</div>
                        <div class="method-icon"><i class="fas fa-ticket-alt"></i></div>
                        <h3>Tracking dengan Nomor Tiket</h3>
                        <p>Gunakan nomor tiket <strong>{{ $complaint->ticket_number }}</strong></p>
                        <a href="{{ route('public.complaints.track') }}" class="method-btn">
                            <i class="fas fa-search"></i> Tracking Sekarang
                        </a>
                    </div>

                    <div class="method-card">
                        <div class="method-number">2</div>
                        <div class="method-icon"><i class="fas fa-phone"></i></div>
                        <h3>Tracking dengan No. HP</h3>
                        <p>Gunakan nomor HP <strong>{{ $complaint->reporter_phone }}</strong></p>
                        <a href="{{ route('public.complaints.track') }}" class="method-btn">
                            <i class="fas fa-search"></i> Tracking Sekarang
                        </a>
                    </div>

                    @if($complaint->reporter_nik)
                    <div class="method-card">
                        <div class="method-number">3</div>
                        <div class="method-icon"><i class="fas fa-id-card"></i></div>
                        <h3>Tracking dengan NIK</h3>
                        <p>Gunakan NIK yang Anda daftarkan</p>
                        <a href="{{ route('public.complaints.track') }}" class="method-btn">
                            <i class="fas fa-search"></i> Tracking Sekarang
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Info Grid -->
            <div class="info-grid">
                <div class="info-item">
                    <i class="fas fa-list"></i>
                    <div>
                        <span class="info-label">Layanan</span>
                        <span class="info-value">{{ $complaint->service->name }}</span>
                    </div>
                </div>
                <div class="info-item">
                    <i class="fas fa-calendar"></i>
                    <div>
                        <span class="info-label">Tanggal Diajukan</span>
                        <span class="info-value">{{ $complaint->created_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
                <div class="info-item">
                    <i class="fas fa-hourglass-half"></i>
                    <div>
                        <span class="info-label">Status</span>
                        <span class="info-value">
                            <span class="status-badge status-submitted">Menunggu Verifikasi</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="success-actions">
                <a href="{{ route('public.complaints.show', $complaint->ticket_number) }}" class="btn btn-primary">
                    <i class="fas fa-eye"></i> Lihat Detail Pengaduan
                </a>
                <a href="{{ route('public.complaints.track') }}" class="btn btn-secondary">
                    <i class="fas fa-search"></i> Tracking Pengaduan
                </a>
                <button onclick="window.print()" class="btn btn-outline">
                    <i class="fas fa-print"></i> Cetak/Screenshot Halaman Ini
                </button>
            </div>

            <!-- Next Steps -->
            <div class="next-steps">
                <h3><i class="fas fa-arrow-right"></i> Langkah Selanjutnya</h3>
                <div class="steps-grid">
                    <div class="step-card">
                        <div class="step-number">1</div>
                        <h4>Simpan Nomor Tiket</h4>
                        <p>Screenshot halaman ini atau catat nomor tiket Anda dengan baik</p>
                    </div>
                    <div class="step-card">
                        <div class="step-number">2</div>
                        <h4>Tracking Berkala</h4>
                        <p>Cek status pengaduan Anda secara berkala melalui halaman tracking (1-2 hari kerja)</p>
                    </div>
                    <div class="step-card">
                        <div class="step-number">3</div>
                        <h4>Tunggu Proses</h4>
                        <p>Tim kami akan memverifikasi dan memproses pengaduan Anda (estimasi 3-7 hari kerja)</p>
                    </div>
                    <div class="step-card">
                        <div class="step-number">4</div>
                        <h4>Berikan Feedback</h4>
                        <p>Setelah selesai, berikan penilaian untuk pengaduan Anda</p>
                    </div>
                </div>
            </div>

            <!-- Important Notice -->
            <div class="important-notice">
                <i class="fas fa-exclamation-triangle"></i>
                <div>
                    <strong>Catatan Penting:</strong>
                    <ul>
                        <li>Sistem notifikasi otomatis (email/WhatsApp) masih dalam pengembangan</li>
                        <li>Silakan <strong>cek status secara manual</strong> melalui halaman tracking</li>
                        <li>Simpan nomor tiket, No. HP, atau NIK Anda untuk tracking</li>
                        <li>Jika ada pertanyaan, hubungi kami melalui kontak di bawah</li>
                    </ul>
                </div>
            </div>

            <!-- Contact -->
            <div class="contact-box">
                <h4>Butuh Bantuan?</h4>
                <p>Hubungi kami jika ada pertanyaan:</p>
                <div class="contact-grid">
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <span>(024) 6923955</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>dinkeskabsemarang@gmail.com</span>
                    </div>
                    <div class="contact-item">
                        <i class="fab fa-whatsapp"></i>
                        <span>(024) 6923955</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.success-page {
    padding: 4rem 0;
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    min-height: 100vh;
}

.success-content {
    max-width: 900px;
    margin: 0 auto;
    text-align: center;
}

.success-icon {
    font-size: 5rem;
    color: #10b981;
    margin-bottom: 2rem;
    animation: scaleIn 0.5s ease-out;
}

@keyframes scaleIn {
    0% { transform: scale(0); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

.success-content h1 {
    font-size: 2.5rem;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 1rem;
}

.lead {
    font-size: 1.25rem;
    color: #64748b;
    margin-bottom: 3rem;
}

.ticket-box {
    background: white;
    padding: 0;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    margin-bottom: 3rem;
    border: 3px solid #10b981;
    overflow: hidden;
}

.ticket-header {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    padding: 1.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    font-size: 1.125rem;
    font-weight: 700;
}

.ticket-main {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 2rem;
    padding: 2.5rem;
    align-items: center;
}

.ticket-number {
    font-size: 2.5rem;
    font-weight: 800;
    color: #3b82f6;
    margin-bottom: 1rem;
    letter-spacing: 2px;
    font-family: 'Courier New', monospace;
}

.ticket-note {
    display: inline-flex;
    align-items: start;
    gap: 0.5rem;
    background: #fef3c7;
    color: #92400e;
    padding: 1rem;
    border-radius: 8px;
    font-size: 0.9375rem;
    text-align: left;
    line-height: 1.6;
}

.qr-code {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 12px;
    border: 2px dashed #cbd5e1;
}

.qr-code small {
    color: #64748b;
    font-size: 0.8125rem;
}

/* Tracking Instructions */
.tracking-instructions {
    background: white;
    padding: 2.5rem;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 3rem;
    text-align: left;
}

.tracking-instructions h2 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.instruction-intro {
    background: #fef3c7;
    padding: 1.25rem;
    border-radius: 8px;
    border-left: 4px solid #f59e0b;
    color: #92400e;
    line-height: 1.7;
    margin-bottom: 2rem;
}

.methods-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.method-card {
    background: #f8fafc;
    padding: 2rem 1.5rem;
    border-radius: 12px;
    border: 2px solid #e2e8f0;
    position: relative;
    text-align: center;
    transition: all 0.3s;
}

.method-card:hover {
    border-color: #3b82f6;
    transform: translateY(-4px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
}

.method-number {
    position: absolute;
    top: -15px;
    left: 50%;
    transform: translateX(-50%);
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
}

.method-icon {
    font-size: 2.5rem;
    color: #3b82f6;
    margin: 1rem 0;
}

.method-card h3 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.75rem;
}

.method-card p {
    color: #64748b;
    margin-bottom: 1.25rem;
    line-height: 1.6;
}

.method-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
}

.method-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.info-item {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 1rem;
    text-align: left;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.info-item i {
    font-size: 2rem;
    color: #3b82f6;
}

.info-label {
    display: block;
    font-size: 0.875rem;
    color: #64748b;
    margin-bottom: 0.25rem;
}

.info-value {
    display: block;
    font-size: 1rem;
    font-weight: 700;
    color: #1e293b;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 600;
}

.status-submitted {
    background: #fef3c7;
    color: #92400e;
}

.success-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    justify-content: center;
    margin-bottom: 3rem;
}

.btn {
    padding: 0.875rem 2rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1rem;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
}

.btn-secondary {
    background: #f1f5f9;
    color: #475569;
}

.btn-secondary:hover {
    background: #e2e8f0;
}

.btn-outline {
    background: white;
    color: #475569;
    border: 2px solid #e2e8f0;
}

.btn-outline:hover {
    border-color: #3b82f6;
    color: #3b82f6;
}

.next-steps {
    background: white;
    padding: 2.5rem;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 3rem;
    text-align: left;
}

.next-steps h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.steps-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.step-card {
    text-align: center;
    position: relative;
    padding-top: 1rem;
}

.step-number {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0 auto 1rem;
}

.step-card h4 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.step-card p {
    color: #64748b;
    font-size: 0.9375rem;
    line-height: 1.6;
}

.important-notice {
    background: #fee2e2;
    border: 2px solid #ef4444;
    border-radius: 12px;
    padding: 1.5rem;
    display: flex;
    gap: 1rem;
    text-align: left;
    margin-bottom: 2rem;
}

.important-notice i {
    font-size: 2rem;
    color: #ef4444;
    flex-shrink: 0;
}

.important-notice strong {
    display: block;
    color: #991b1b;
    margin-bottom: 0.75rem;
    font-size: 1.125rem;
}

.important-notice ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.important-notice li {
    color: #991b1b;
    margin-bottom: 0.5rem;
    padding-left: 1.5rem;
    position: relative;
}

.important-notice li::before {
    content: "•";
    position: absolute;
    left: 0;
}

.contact-box {
    background: #f8fafc;
    padding: 2rem;
    border-radius: 12px;
    border: 2px solid #e2e8f0;
}

.contact-box h4 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.contact-box > p {
    color: #64748b;
    margin-bottom: 1.5rem;
}

.contact-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 2rem;
    justify-content: center;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #475569;
    font-weight: 600;
}

.contact-item i {
    color: #3b82f6;
    font-size: 1.25rem;
}

@media (max-width: 768px) {
    .success-content h1 {
        font-size: 2rem;
    }

    .ticket-main {
        grid-template-columns: 1fr;
        text-align: center;
    }

    .ticket-number {
        font-size: 1.75rem;
    }

    .success-actions {
        flex-direction: column;
    }

    .btn {
        width: 100%;
        justify-content: center;
    }

    .steps-grid {
        grid-template-columns: 1fr;
    }

    .methods-grid {
        grid-template-columns: 1fr;
    }
}

@media print {
    .success-actions,
    .next-steps,
    .contact-box {
        display: none !important;
    }

    .success-page {
        background: white;
    }

    .ticket-box {
        border: 2px solid #000;
    }
}
</style>

@endsection