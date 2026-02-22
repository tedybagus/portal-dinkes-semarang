@extends('layouts.public.app')

@section('title', 'Ajukan Permohonan Informasi')

@section('content')
<!-- Hero Section -->
<section class="page-hero-form">
    <div class="container">
        <div class="hero-content">
            <div class="breadcrumb-wrapper">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('information.flow') }}">Permohonan Informasi</a></li>
                        <li class="breadcrumb-item active">Ajukan Permohonan</li>
                    </ol>
                </nav>
            </div>
            <h1 class="hero-title">
                <i class="fas fa-file-upload"></i>
                Formulir Permohonan Informasi
            </h1>
            <p class="hero-description">
                Lengkapi formulir berikut untuk mengajukan permohonan informasi publik
            </p>
        </div>
    </div>
</section>

<!-- Form Section -->
<section class="form-section">
    <div class="container">
        <div class="form-container">
            <!-- Progress Steps -->
            <div class="form-steps">
                <div class="step active">
                    <div class="step-icon">1</div>
                    <span>Data Pemohon</span>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <div class="step-icon">2</div>
                    <span>Informasi</span>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <div class="step-icon">3</div>
                    <span>Konfirmasi</span>
                </div>
            </div>

            <!-- Form Card -->
            <div class="form-card">
                <form action="{{ route('information.store') }}" method="POST" enctype="multipart/form-data" id="requestForm">
                    @csrf

                    <!-- Section 1: Data Pemohon -->
                    <div class="form-section-wrapper active" data-section="1">
                        <div class="section-header">
                            <h3><i class="fas fa-user"></i> Data Pemohon</h3>
                            <p>Lengkapi data diri Anda dengan benar</p>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="name" class="form-label required">Nama Lengkap</label>
                                <input 
                                    type="text" 
                                    name="name" 
                                    id="name" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    value="{{ old('name') }}"
                                    placeholder="Masukkan nama lengkap sesuai KTP"
                                    required
                                >
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="id_card_number" class="form-label required">NIK (Nomor Induk Kependudukan)</label>
                                <input 
                                    type="text" 
                                    name="id_card_number" 
                                    id="id_card_number" 
                                    class="form-control @error('id_card_number') is-invalid @enderror" 
                                    value="{{ old('id_card_number') }}"
                                    placeholder="16 digit NIK"
                                    maxlength="16"
                                    pattern="[0-9]{16}"
                                    required
                                >
                                @error('id_card_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address" class="form-label required">Alamat Lengkap</label>
                            <textarea 
                                name="address" 
                                id="address" 
                                class="form-control @error('address') is-invalid @enderror" 
                                rows="3"
                                placeholder="Masukkan alamat lengkap sesuai KTP"
                                required
                            >{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone" class="form-label required">Nomor Telepon/HP</label>
                                <input 
                                    type="tel" 
                                    name="phone" 
                                    id="phone" 
                                    class="form-control @error('phone') is-invalid @enderror" 
                                    value="{{ old('phone') }}"
                                    placeholder="08xxxxxxxxxx"
                                    required
                                >
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label required">Alamat Email</label>
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    value="{{ old('email') }}"
                                    placeholder="nama@email.com"
                                    required
                                >
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="requester_type" class="form-label required">Jenis Pemohon</label>
                                <select 
                                    name="requester_type" 
                                    id="requester_type" 
                                    class="form-control @error('requester_type') is-invalid @enderror"
                                    required
                                >
                                    <option value="">Pilih Jenis Pemohon</option>
                                    <option value="perorangan" {{ old('requester_type') == 'perorangan' ? 'selected' : '' }}>Perorangan</option>
                                    <option value="kelompok" {{ old('requester_type') == 'kelompok' ? 'selected' : '' }}>Kelompok Orang</option>
                                    <option value="organisasi" {{ old('requester_type') == 'organisasi' ? 'selected' : '' }}>Organisasi</option>
                                </select>
                                @error('requester_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="id_card_file" class="form-label">Upload KTP (Opsional)</label>
                                <input 
                                    type="file" 
                                    name="id_card_file" 
                                    id="id_card_file" 
                                    class="form-control-file @error('id_card_file') is-invalid @enderror"
                                    accept="image/*,.pdf"
                                >
                                <small class="form-text">Format: JPG, PNG, PDF (Max. 2MB)</small>
                                @error('id_card_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn-next" onclick="nextSection(2)">
                                Selanjutnya <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Section 2: Detail Informasi -->
                    <div class="form-section-wrapper" data-section="2">
                        <div class="section-header">
                            <h3><i class="fas fa-info-circle"></i> Detail Informasi yang Dimohonkan</h3>
                            <p>Jelaskan informasi yang Anda butuhkan</p>
                        </div>

                        <div class="form-group">
                            <label for="information_needed" class="form-label required">Informasi yang Dibutuhkan</label>
                            <textarea 
                                name="information_needed" 
                                id="information_needed" 
                                class="form-control @error('information_needed') is-invalid @enderror" 
                                rows="5"
                                placeholder="Jelaskan secara detail informasi yang Anda butuhkan..."
                                required
                            >{{ old('information_needed') }}</textarea>
                            @error('information_needed')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text">Jelaskan sejelas mungkin agar kami dapat memproses dengan tepat</small>
                        </div>

                        <div class="form-group">
                            <label for="information_purpose" class="form-label required">Tujuan Penggunaan Informasi</label>
                            <textarea 
                                name="information_purpose" 
                                id="information_purpose" 
                                class="form-control @error('information_purpose') is-invalid @enderror" 
                                rows="4"
                                placeholder="Jelaskan untuk apa informasi ini akan digunakan..."
                                required
                            >{{ old('information_purpose') }}</textarea>
                            @error('information_purpose')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label required">Format Informasi</label>
                                <div class="radio-group">
                                    <div class="radio-item">
                                        <input 
                                            type="radio" 
                                            name="information_format" 
                                            id="format_softcopy" 
                                            value="softcopy"
                                            {{ old('information_format', 'softcopy') == 'softcopy' ? 'checked' : '' }}
                                            required
                                        >
                                        <label for="format_softcopy">
                                            <i class="fas fa-file-alt"></i>
                                            <span>Softcopy (Digital)</span>
                                        </label>
                                    </div>
                                    <div class="radio-item">
                                        <input 
                                            type="radio" 
                                            name="information_format" 
                                            id="format_hardcopy" 
                                            value="hardcopy"
                                            {{ old('information_format') == 'hardcopy' ? 'checked' : '' }}
                                        >
                                        <label for="format_hardcopy">
                                            <i class="fas fa-print"></i>
                                            <span>Hardcopy (Cetak)</span>
                                        </label>
                                    </div>
                                    <div class="radio-item">
                                        <input 
                                            type="radio" 
                                            name="information_format" 
                                            id="format_both" 
                                            value="keduanya"
                                            {{ old('information_format') == 'keduanya' ? 'checked' : '' }}
                                        >
                                        <label for="format_both">
                                            <i class="fas fa-copy"></i>
                                            <span>Keduanya</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label required">Cara Pengambilan</label>
                                <div class="radio-group">
                                    <div class="radio-item">
                                        <input 
                                            type="radio" 
                                            name="delivery_method" 
                                            id="delivery_email" 
                                            value="email"
                                            {{ old('delivery_method', 'email') == 'email' ? 'checked' : '' }}
                                            required
                                        >
                                        <label for="delivery_email">
                                            <i class="fas fa-envelope"></i>
                                            <span>Email</span>
                                        </label>
                                    </div>
                                    <div class="radio-item">
                                        <input 
                                            type="radio" 
                                            name="delivery_method" 
                                            id="delivery_direct" 
                                            value="langsung"
                                            {{ old('delivery_method') == 'langsung' ? 'checked' : '' }}
                                        >
                                        <label for="delivery_direct">
                                            <i class="fas fa-hand-holding"></i>
                                            <span>Ambil Langsung</span>
                                        </label>
                                    </div>
                                    <div class="radio-item">
                                        <input 
                                            type="radio" 
                                            name="delivery_method" 
                                            id="delivery_post" 
                                            value="pos"
                                            {{ old('delivery_method') == 'pos' ? 'checked' : '' }}
                                        >
                                        <label for="delivery_post">
                                            <i class="fas fa-mail-bulk"></i>
                                            <span>Pos</span>
                                        </label>
                                    </div>
                                    <div class="radio-item">
                                        <input 
                                            type="radio" 
                                            name="delivery_method" 
                                            id="delivery_courier" 
                                            value="kurir"
                                            {{ old('delivery_method') == 'kurir' ? 'checked' : '' }}
                                        >
                                        <label for="delivery_courier">
                                            <i class="fas fa-shipping-fast"></i>
                                            <span>Kurir</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn-prev" onclick="prevSection(1)">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </button>
                            <button type="button" class="btn-next" onclick="nextSection(3)">
                                Selanjutnya <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Section 3: Konfirmasi -->
                    <div class="form-section-wrapper" data-section="3">
                        <div class="section-header">
                            <h3><i class="fas fa-check-circle"></i> Konfirmasi Data</h3>
                            <p>Periksa kembali data yang Anda masukkan</p>
                        </div>

                        <div class="confirmation-box">
                            <div class="confirmation-item">
                                <label>Nama Lengkap:</label>
                                <span id="confirm_name">-</span>
                            </div>
                            <div class="confirmation-item">
                                <label>NIK:</label>
                                <span id="confirm_nik">-</span>
                            </div>
                            <div class="confirmation-item">
                                <label>Email:</label>
                                <span id="confirm_email">-</span>
                            </div>
                            <div class="confirmation-item">
                                <label>Telepon:</label>
                                <span id="confirm_phone">-</span>
                            </div>
                            <div class="confirmation-item">
                                <label>Jenis Pemohon:</label>
                                <span id="confirm_type">-</span>
                            </div>
                            <div class="confirmation-item full">
                                <label>Informasi yang Dibutuhkan:</label>
                                <span id="confirm_info">-</span>
                            </div>
                        </div>

                        <div class="agreement-box">
                            <label class="checkbox-label">
                                <input type="checkbox" id="agreement" required>
                                <span>
                                    Saya menyatakan bahwa data yang saya isi adalah benar dan saya bertanggung jawab penuh atas permohonan ini. 
                                    Saya telah membaca dan menyetujui ketentuan permohonan informasi publik yang berlaku.
                                </span>
                            </label>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn-prev" onclick="prevSection(2)">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </button>
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-paper-plane"></i> Kirim Permohonan
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Info Sidebar -->
            <div class="info-sidebar">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <h4>Informasi Penting</h4>
                    <ul>
                        <li><i class="fas fa-check"></i> Pastikan data yang diisi sudah benar</li>
                        <li><i class="fas fa-check"></i> Simpan nomor registrasi yang diberikan</li>
                        <li><i class="fas fa-check"></i> Proses maksimal 14 hari kerja</li>
                        <li><i class="fas fa-check"></i> Anda akan mendapat email notifikasi</li>
                    </ul>
                </div>

                <div class="help-card">
                    <i class="fas fa-headset"></i>
                    <h4>Butuh Bantuan?</h4>
                    <p>Hubungi kami di:</p>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <span>(024) 6923955</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>dinkeskabsemarang@gmail.com</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Hero */
.page-hero-form {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    padding: 3rem 0 4rem;
    margin-bottom: -2rem;
}

.hero-content {
    color: white;
    margin-left: 5em;
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

/* Form Section */
.form-section {
    padding: 4rem 0;
    background: #f8fafc;
}

.form-container {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 2rem;
    max-width: 1400px;
    margin: 0 auto;
}

/* Progress Steps */
.form-steps {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 3rem;
    grid-column: 1 / -1;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.step-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #e2e8f0;
    color: #94a3b8;
    font-weight: 700;
    font-size: 1.25rem;
    transition: all 0.3s;
}

.step.active .step-icon {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.step span {
    font-size: 0.875rem;
    color: #64748b;
    font-weight: 600;
}

.step.active span {
    color: #10b981;
}

.step-line {
    width: 100px;
    height: 2px;
    background: #e2e8f0;
    margin: 0 1rem;
}

/* Form Card */
.form-card {
    background: white;
    border-radius: 16px;
    padding: 2.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.form-section-wrapper {
    display: none;
}

.form-section-wrapper.active {
    display: block;
    animation: fadeIn 0.3s;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.section-header {
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid #e2e8f0;
}

.section-header h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.section-header p {
    color: #64748b;
    margin: 0;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #334155;
    margin-bottom: 0.5rem;
    font-size: 0.9375rem;
}

.form-label.required::after {
    content: '*';
    color: #ef4444;
    margin-left: 0.25rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.9375rem;
    transition: all 0.3s;
}

.form-control:focus {
    outline: none;
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

.form-control.is-invalid {
    border-color: #ef4444;
}

.invalid-feedback {
    color: #ef4444;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    display: block;
}

.form-text {
    font-size: 0.8125rem;
    color: #94a3b8;
    margin-top: 0.25rem;
    display: block;
}

.form-control-file {
    display: block;
    width: 100%;
    padding: 0.5rem;
    border: 2px dashed #cbd5e1;
    border-radius: 8px;
    cursor: pointer;
}

/* Radio Group */
.radio-group {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
}

.radio-item {
    position: relative;
}

.radio-item input[type="radio"] {
    position: absolute;
    opacity: 0;
}

.radio-item label {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s;
    text-align: center;
}

.radio-item input:checked + label {
    border-color: #10b981;
    background: #f0fdf4;
}

.radio-item label i {
    font-size: 1.5rem;
    color: #10b981;
}

/* Confirmation */
.confirmation-box {
    background: #f8fafc;
    padding: 2rem;
    border-radius: 12px;
    margin-bottom: 2rem;
}

.confirmation-item {
    display: grid;
    grid-template-columns: 200px 1fr;
    gap: 1rem;
    padding: 1rem 0;
    border-bottom: 1px solid #e2e8f0;
}

.confirmation-item:last-child {
    border-bottom: none;
}

.confirmation-item.full {
    grid-template-columns: 1fr;
}

.confirmation-item label {
    font-weight: 600;
    color: #64748b;
}

.confirmation-item span {
    color: #1e293b;
}

.agreement-box {
    background: #eff6ff;
    border-left: 4px solid #3b82f6;
    padding: 1.5rem;
    border-radius: 8px;
    margin-bottom: 2rem;
}

.checkbox-label {
    display: flex;
    gap: 1rem;
    align-items: start;
    cursor: pointer;
}

.checkbox-label input {
    margin-top: 0.25rem;
    width: 18px;
    height: 18px;
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 2px solid #e2e8f0;
}

.btn-prev, .btn-next, .btn-submit {
    padding: 0.875rem 2rem;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-prev {
    background: #f1f5f9;
    color: #475569;
}

.btn-prev:hover {
    background: #e2e8f0;
}

.btn-next {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.btn-next:hover, .btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
}

.btn-submit {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.btn-submit:hover {
    box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
}

/* Info Sidebar */
.info-sidebar {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.info-card, .help-card {
    background: white;
    padding: 2rem;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.info-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    color: #1e40af;
    border-radius: 12px;
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

.info-card h4, .help-card h4 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1rem;
}

.info-card ul {
    list-style: none;
    padding: 0;
}

.info-card li {
    padding: 0.75rem 0;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.info-card li i {
    color: #10b981;
}

.help-card {
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    border: 2px solid #10b981;
    text-align: center;
}

.help-card i:first-child {
    font-size: 3rem;
    color: #10b981;
    margin-bottom: 1rem;
}

.help-card p {
    color: #064e3b;
    margin-bottom: 1rem;
}

.contact-item {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.5rem;
    color: #065f46;
    font-weight: 600;
}

/* Responsive */
@media (max-width: 1024px) {
    .form-container {
        grid-template-columns: 1fr;
    }

    .info-sidebar {
        flex-direction: row;
    }
}

@media (max-width: 768px) {
    .hero-title {
        font-size: 2rem;
    }

    .form-row {
        grid-template-columns: 1fr;
    }

    .form-steps {
        gap: 0.5rem;
    }

    .step span {
        display: none;
    }

    .step-line {
        width: 50px;
        margin: 0 0.5rem;
    }

    .info-sidebar {
        flex-direction: column;
    }

    .confirmation-item {
        grid-template-columns: 1fr;
    }

    .radio-group {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
let currentSection = 1;

function nextSection(section) {
    // Validate current section
    if (!validateSection(currentSection)) {
        return;
    }

    // Hide current
    document.querySelectorAll('.form-section-wrapper').forEach(el => {
        el.classList.remove('active');
    });

    // Show next
    document.querySelector(`.form-section-wrapper[data-section="${section}"]`).classList.add('active');

    // Update steps
    document.querySelectorAll('.step').forEach((step, index) => {
        if (index < section) {
            step.classList.add('active');
        } else {
            step.classList.remove('active');
        }
    });

    // Update confirmation if section 3
    if (section === 3) {
        updateConfirmation();
    }

    currentSection = section;

    // Scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function prevSection(section) {
    nextSection(section);
}

function validateSection(section) {
    const sectionEl = document.querySelector(`.form-section-wrapper[data-section="${section}"]`);
    const inputs = sectionEl.querySelectorAll('[required]');
    let valid = true;

    inputs.forEach(input => {
        if (!input.value || (input.type === 'checkbox' && !input.checked) || (input.type === 'radio' && !document.querySelector(`input[name="${input.name}"]:checked`))) {
            input.classList.add('is-invalid');
            valid = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });

    if (!valid) {
        alert('Mohon lengkapi semua field yang wajib diisi');
    }

    return valid;
}

function updateConfirmation() {
    document.getElementById('confirm_name').textContent = document.getElementById('name').value;
    document.getElementById('confirm_nik').textContent = document.getElementById('id_card_number').value;
    document.getElementById('confirm_email').textContent = document.getElementById('email').value;
    document.getElementById('confirm_phone').textContent = document.getElementById('phone').value;
    
    const typeSelect = document.getElementById('requester_type');
    document.getElementById('confirm_type').textContent = typeSelect.options[typeSelect.selectedIndex].text;
    
    document.getElementById('confirm_info').textContent = document.getElementById('information_needed').value;
}

// Real-time validation
document.querySelectorAll('.form-control, input[type="radio"]').forEach(input => {
    input.addEventListener('change', function() {
        if (this.value) {
            this.classList.remove('is-invalid');
        }
    });
});
</script>
@endsection