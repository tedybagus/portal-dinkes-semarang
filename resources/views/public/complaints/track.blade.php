@extends('layouts.public.app')

@section('title', 'Tracking Pengaduan')

@section('content')
<!-- Hero Section -->
<section class="tracking-hero">
    <div class="container">
        <h1><i class="fas fa-search"></i> Lacak Status Pengaduan</h1>
        <p>Cek status pengaduan Anda kapan saja tanpa perlu login</p>
    </div>
</section>

<!-- Quick Access Info -->
<section class="info-banner">
    <div class="container">
        <div class="info-grid">
            <div class="info-item">
                <i class="fas fa-ticket-alt"></i>
                <div>
                    <strong>Simpan Nomor Tiket</strong>
                    <span>Catat atau screenshot nomor tiket Anda</span>
                </div>
            </div>
            <div class="info-item">
                <i class="fas fa-mobile-alt"></i>
                <div>
                    <strong>Tracking Mudah</strong>
                    <span>Gunakan nomor tiket atau No. HP untuk tracking</span>
                </div>
            </div>
            <div class="info-item">
                <i class="fas fa-clock"></i>
                <div>
                    <strong>Real-time Update</strong>
                    <span>Status diupdate langsung oleh admin</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Search Section -->
<section class="search-section">
    <div class="container">
        <div class="search-tabs">
            <button class="tab-btn active" onclick="switchTab('ticket')">
                <i class="fas fa-ticket-alt"></i> Tracking dengan Nomor Tiket
            </button>
            <button class="tab-btn" onclick="switchTab('phone')">
                <i class="fas fa-phone"></i> Tracking dengan No. HP
            </button>
            <button class="tab-btn" onclick="switchTab('nik')">
                <i class="fas fa-id-card"></i> Tracking dengan NIK
            </button>
        </div>

        <!-- Tab 1: Ticket Number -->
        <div class="search-card" id="tab-ticket">
            <h2>Masukkan Nomor Tiket</h2>
            <p>Contoh: ADU-20250214-ABCD</p>
            
            <form action="{{ route('public.complaints.search') }}" method="POST">
                @csrf
                <input type="hidden" name="search_type" value="ticket">
                <div class="search-box">
                    <i class="fas fa-ticket-alt"></i>
                    <input type="text" 
                           name="ticket_number" 
                           placeholder="ADU-YYYYMMDD-XXXX" 
                           required
                           pattern="ADU-[0-9]{8}-[A-Z0-9]{4}"
                           title="Format: ADU-YYYYMMDD-XXXX">
                    <button type="submit">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- Tab 2: Phone Number -->
        <div class="search-card" id="tab-phone" style="display: none;">
            <h2>Masukkan Nomor HP</h2>
            <p>Gunakan nomor HP yang Anda daftarkan saat mengajukan pengaduan</p>
            
            <form action="{{ route('public.complaints.search') }}" method="POST">
                @csrf
                <input type="hidden" name="search_type" value="phone">
                <div class="search-box">
                    <i class="fas fa-phone"></i>
                    <input type="tel" 
                           name="phone" 
                           placeholder="08123456789" 
                           required
                           pattern="[0-9]{10,13}"
                           title="Masukkan nomor HP 10-13 digit">
                    <button type="submit">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>

            <div class="help-text">
                <i class="fas fa-info-circle"></i>
                Jika Anda memiliki lebih dari 1 pengaduan, semua akan ditampilkan
            </div>
        </div>

        <!-- Tab 3: NIK -->
        <div class="search-card" id="tab-nik" style="display: none;">
            <h2>Masukkan NIK</h2>
            <p>Gunakan NIK yang Anda daftarkan saat mengajukan pengaduan</p>
            
            <form action="{{ route('public.complaints.search') }}" method="POST">
                @csrf
                <input type="hidden" name="search_type" value="nik">
                <div class="search-box">
                    <i class="fas fa-id-card"></i>
                    <input type="text" 
                           name="nik" 
                           placeholder="16 digit NIK" 
                           required
                           pattern="[0-9]{16}"
                           maxlength="16"
                           title="Masukkan NIK 16 digit">
                    <button type="submit">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>

        @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
        @endif
    </div>
</section>

@if(isset($complaints) && $complaints->count() > 0)
<!-- Results Section -->
<section class="results-section">
    <div class="container">
        <div class="results-header">
            <h2>Hasil Pencarian</h2>
            <span class="badge">{{ $complaints->count() }} pengaduan ditemukan</span>
        </div>

        <div class="complaints-grid">
            @foreach($complaints as $complaint)
            <div class="complaint-card">
                <div class="card-header">
                    <div class="ticket-info">
                        <span class="ticket-label">Nomor Tiket:</span>
                        <span class="ticket-number">{{ $complaint->ticket_number }}</span>
                    </div>
                    <span class="status-badge status-{{ $complaint->status }}">
                        {{ $complaint->status_label }}
                    </span>
                </div>

                <div class="card-body">
                    <h3>{{ $complaint->subject }}</h3>
                    <div class="meta-info">
                        <span><i class="fas fa-list"></i> {{ $complaint->service->name }}</span>
                        <span><i class="fas fa-calendar"></i> {{ $complaint->created_at->format('d M Y') }}</span>
                        <span><i class="fas fa-flag"></i> {{ $complaint->priority_label }}</span>
                    </div>
                </div>

                <!-- Mini Timeline -->
                <div class="mini-timeline">
                    @php
                    $latestHistory = $complaint->histories->first();
                    @endphp
                    @if($latestHistory)
                    <div class="timeline-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <strong>Update Terakhir:</strong>
                            <p>{{ $latestHistory->description }}</p>
                            <small>{{ $latestHistory->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="card-footer">
                    <a href="{{ route('public.complaints.show', $complaint->ticket_number) }}" class="btn btn-primary">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                    <button onclick="printTicket('{{ $complaint->ticket_number }}')" class="btn btn-secondary">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@elseif(isset($complaints))
<!-- No Results -->
<section class="no-result-section">
    <div class="container">
        <div class="no-result">
            <i class="fas fa-search"></i>
            <h3>Pengaduan Tidak Ditemukan</h3>
            <p>Data yang Anda masukkan tidak ditemukan di sistem kami.</p>
            <div class="help-box">
                <strong>Tips:</strong>
                <ul>
                    <li>Pastikan nomor tiket benar: <code>ADU-20250214-ABCD</code></li>
                    <li>Periksa nomor HP atau NIK yang Anda gunakan saat mengajukan</li>
                    <li>Hubungi kami jika masalah berlanjut</li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endif

<!-- How to Track Guide -->
<section class="guide-section">
    <div class="container">
        <h2>Cara Tracking Pengaduan</h2>
        <div class="guide-grid">
            <div class="guide-card">
                <div class="guide-number">1</div>
                <div class="guide-icon"><i class="fas fa-file-alt"></i></div>
                <h3>Ajukan Pengaduan</h3>
                <p>Isi formulir pengaduan dengan lengkap dan benar</p>
            </div>
            <div class="guide-card">
                <div class="guide-number">2</div>
                <div class="guide-icon"><i class="fas fa-save"></i></div>
                <h3>Simpan Nomor Tiket</h3>
                <p>Catat, screenshot, atau print halaman sukses dengan nomor tiket</p>
            </div>
            <div class="guide-card">
                <div class="guide-number">3</div>
                <div class="guide-icon"><i class="fas fa-search"></i></div>
                <h3>Tracking Kapan Saja</h3>
                <p>Gunakan nomor tiket, HP, atau NIK untuk tracking status</p>
            </div>
            <div class="guide-card">
                <div class="guide-number">4</div>
                <div class="guide-icon"><i class="fas fa-star"></i></div>
                <h3>Berikan Feedback</h3>
                <p>Setelah selesai, berikan penilaian untuk pengaduan Anda</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section">
    <div class="container">
        <div class="contact-card">
            <h3>Butuh Bantuan?</h3>
            <p>Jika Anda kesulitan tracking pengaduan atau ada pertanyaan lain:</p>
            <div class="contact-grid">
                <a href="tel:0246923955" class="contact-btn">
                    <i class="fas fa-phone"></i>
                    <div>
                        <strong>Telepon</strong>
                        <span>(024) 6923955</span>
                    </div>
                </a>
                <a href="mailto:dinkeskabsemarang@gmail.com" class="contact-btn">
                    <i class="fas fa-envelope"></i>
                    <div>
                        <strong>Email</strong>
                        <span>dinkeskabsemarang@gmail.com</span>
                    </div>
                </a>
                <a href="https://wa.me/628123456789" class="contact-btn" target="_blank">
                    <i class="fab fa-whatsapp"></i>
                    <div>
                        <strong>WhatsApp</strong>
                        <span>0812-3456-7890</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<style>
.tracking-hero {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    padding: 3rem 0;
    margin-bottom: 0;
    
}

.tracking-hero h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
    margin-left:2em;
}

.tracking-hero p {
    font-size: 1.125rem;
    opacity: 0.95;
    margin-left:5em;
}

.info-banner {
    background: white;
    padding: 2rem 0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.info-item i {
    font-size: 2.5rem;
    color: #3b82f6;
    margin-left:2em;
    
}

.info-item strong {
    display: block;
    color: #1e293b;
    font-size: 1.125rem;
    margin-bottom: 0.25rem;
}

.info-item span {
    color: #64748b;
    font-size: 0.9375rem;
}

.search-section {
    padding: 2rem 0 4rem;
    background: #f8fafc;
    margin-left: 10em;
}

.search-tabs {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.tab-btn {
    flex: 1;
    min-width: 200px;
    padding: 1rem 1.5rem;
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.tab-btn:hover {
    border-color: #3b82f6;
    color: #3b82f6;
}

.tab-btn.active {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    border-color: #3b82f6;
}

.search-card {
    background: white;
    padding: 3rem;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    max-width: 700px;
    margin: 0 auto;
    text-align: center;
}

.search-card h2 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.search-card > p {
    color: #64748b;
    margin-bottom: 2rem;
}

.search-box {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: #f8fafc;
    padding: 1rem;
    border-radius: 12px;
    border: 2px solid #e2e8f0;
}

.search-box:focus-within {
    border-color: #3b82f6;
}

.search-box i {
    color: #64748b;
    font-size: 1.5rem;
}

.search-box input {
    flex: 1;
    border: none;
    background: transparent;
    font-size: 1.125rem;
    outline: none;
    color: #1e293b;
    font-weight: 600;
}

.search-box button {
    padding: 0.75rem 2rem;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.search-box button:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
}

.help-text {
    margin-top: 1rem;
    padding: 1rem;
    background: #fef3c7;
    border-radius: 8px;
    color: #92400e;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    text-align: left;
}

.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-top: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.alert-error {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

.results-section {
    padding: 3rem 0;
}

.results-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.results-header h2 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1e293b;
}

.badge {
    padding: 0.5rem 1rem;
    background: #dbeafe;
    color: #1e40af;
    border-radius: 6px;
    font-weight: 600;
}

.complaints-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 2rem;
}

.complaint-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: all 0.3s;
}

.complaint-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}

.card-header {
    padding: 1.5rem;
    background: #f8fafc;
    border-bottom: 2px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: start;
    flex-wrap: wrap;
    gap: 1rem;
}

.ticket-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.ticket-label {
    font-size: 0.875rem;
    color: #64748b;
}

.ticket-number {
    font-family: 'Courier New', monospace;
    font-size: 1.125rem;
    font-weight: 700;
    color: #3b82f6;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.875rem;
}

.status-badge.status-submitted { background: #fef3c7; color: #92400e; }
.status-badge.status-verified { background: #dbeafe; color: #1e40af; }
.status-badge.status-in_progress { background: #e9d5ff; color: #6b21a8; }
.status-badge.status-resolved { background: #d1fae5; color: #065f46; }
.status-badge.status-closed { background: #f1f5f9; color: #475569; }
.status-badge.status-rejected { background: #fee2e2; color: #991b1b; }

.card-body {
    padding: 1.5rem;
}

.card-body h3 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1rem;
}

.meta-info {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    font-size: 0.875rem;
    color: #64748b;
}

.meta-info i {
    margin-right: 0.25rem;
}

.mini-timeline {
    padding: 1rem 1.5rem;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
}

.timeline-item {
    display: flex;
    gap: 1rem;
    align-items: start;
}

.timeline-item i {
    color: #3b82f6;
    font-size: 1.25rem;
    margin-top: 0.25rem;
}

.timeline-item strong {
    display: block;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.timeline-item p {
    color: #475569;
    margin: 0;
    font-size: 0.9375rem;
}

.timeline-item small {
    color: #94a3b8;
    font-size: 0.8125rem;
}

.card-footer {
    padding: 1.5rem;
    display: flex;
    gap: 1rem;
    border-top: 1px solid #e2e8f0;
}

.btn {
    flex: 1;
    padding: 0.75rem;
    border-radius: 8px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
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

.no-result-section {
    padding: 4rem 0;
    margin-left:3em;
}

.no-result {
    max-width: 600px;
    margin: 0 auto;
    text-align: center;
    background: white;
    padding: 3rem;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.no-result i {
    font-size: 4rem;
    color: #cbd5e1;
    margin-bottom: 1.5rem;
}

.no-result h3 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1rem;
}

.no-result p {
    color: #64748b;
    margin-bottom: 1.5rem;
}

.help-box {
    background: #f8fafc;
    padding: 1.5rem;
    border-radius: 8px;
    text-align: left;
}

.help-box strong {
    display: block;
    margin-bottom: 0.75rem;
    color: #1e293b;
}

.help-box ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.help-box li {
    padding: 0.5rem 0;
    color: #475569;
    line-height: 1.6;
}

.help-box code {
    background: white;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    color: #3b82f6;
    font-family: 'Courier New', monospace;
}

.guide-section {
    padding: 4rem 0;
    background: #f8fafc;
    margin-left: 2em;
    margin-right: 2em;
}

.guide-section h2 {
    text-align: center;
    font-size: 2rem;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 3rem;
}

.guide-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
}

.guide-card {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    text-align: center;
    position: relative;
}

.guide-number {
    position: absolute;
    top: -15px;
    left: 50%;
    transform: translateX(-50%);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.25rem;
}

.guide-icon {
    font-size: 3rem;
    color: #3b82f6;
    margin: 1.5rem 0 1rem;
}

.guide-card h3 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.75rem;
}

.guide-card p {
    color: #64748b;
    line-height: 1.6;
}

.contact-section {
    padding: 4rem 0;
}

.contact-card {
    background: white;
    padding: 3rem;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    text-align: center;
}

.contact-card h3 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1rem;
}

.contact-card > p {
    color: #64748b;
    margin-bottom: 2rem;
}

.contact-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.contact-btn {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.3s;
}

.contact-btn:hover {
    background: #3b82f6;
    border-color: #3b82f6;
    transform: translateY(-4px);
}

.contact-btn i {
    font-size: 2rem;
    color: #3b82f6;
}

.contact-btn:hover i {
    color: white;
}

.contact-btn div {
    text-align: left;
}

.contact-btn strong {
    display: block;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.contact-btn:hover strong {
    color: white;
}

.contact-btn span {
    color: #64748b;
    font-size: 0.9375rem;
}

.contact-btn:hover span {
    color: white;
}

@media (max-width: 768px) {
    .tracking-hero h1 {
        font-size: 2rem;
    }

    .search-tabs {
        flex-direction: column;
    }

    .tab-btn {
        min-width: 100%;
    }

    .search-card {
        padding: 2rem 1.5rem;
    }

    .search-box {
        flex-direction: column;
    }

    .search-box button {
        width: 100%;
    }

    .complaints-grid {
        grid-template-columns: 1fr;
    }

    .card-footer {
        flex-direction: column;
    }
}
</style>

<script>
function switchTab(tab) {
    // Hide all tabs
    document.querySelectorAll('.search-card').forEach(card => {
        card.style.display = 'none';
    });
    
    // Remove active from all buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Show selected tab
    document.getElementById('tab-' + tab).style.display = 'block';
    
    // Add active to clicked button
    event.target.closest('.tab-btn').classList.add('active');
}

function printTicket(ticketNumber) {
    window.open('{{ route("public.complaints.show", ":ticket") }}'.replace(':ticket', ticketNumber), '_blank');
}
</script>

@endsection