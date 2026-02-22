@extends('layouts.public.app')

@section('title', 'Ajukan Pengaduan')

@section('content')
<!-- Hero Section -->
<section class="form-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('public.complaints.services') }}">Layanan Pengaduan</a></li>
                <li class="breadcrumb-item active">Ajukan Pengaduan</li>
            </ol>
        </nav>
        <h1><i class="fas fa-file-alt"></i> Ajukan Pengaduan</h1>
        <p>Sampaikan pengaduan Anda dengan mengisi formulir di bawah ini</p>
    </div>
</section>

<!-- Progress Steps -->
<section class="progress-section">
    <div class="container">
        <div class="progress-steps">
            <div class="step active" data-step="1">
                <div class="step-number">1</div>
                <div class="step-label">Pilih Layanan</div>
            </div>
            <div class="step-line"></div>
            <div class="step" data-step="2">
                <div class="step-number">2</div>
                <div class="step-label">Isi Data</div>
            </div>
            <div class="step-line"></div>
            <div class="step" data-step="3">
                <div class="step-number">3</div>
                <div class="step-label">Konfirmasi</div>
            </div>
        </div>
    </div>
</section>

<!-- Form Section -->
<section class="form-section">
    <div class="container">
        <form action="{{ route('public.complaints.store') }}" method="POST" enctype="multipart/form-data" id="complaintForm">
            @csrf
            {{-- ADD THIS - Error Display --}}
                @if($errors->any())
                <div style="background: #fee2e2; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; color: #991b1b;">
                    <strong>❌ Form tidak valid:</strong>
                    <ul style="margin: 0.5rem 0 0 1.5rem;">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                @if(session('error'))
                <div style="background: #fee2e2; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; color: #991b1b;">
                    {{ session('error') }}
                </div>
                @endif

            <!-- Step 1: Pilih Layanan -->
            <div class="form-step active" id="step1">
                <div class="step-header">
                    <h2><i class="fas fa-list"></i> Pilih Layanan Pengaduan</h2>
                    <p>Pilih kategori yang sesuai dengan pengaduan Anda</p>
                </div>

                <div class="services-grid">
                    @foreach($services as $service)
                    <label class="service-card {{ $selectedService && $selectedService->id == $service->id ? 'selected' : '' }}">
                        <input type="radio" 
                               name="complaint_service_id" 
                               value="{{ $service->id }}" 
                               {{ $selectedService && $selectedService->id == $service->id ? 'checked' : '' }}
                               {{ old('complaint_service_id') == $service->id ? 'checked' : '' }}
                               required>
                        <div class="service-icon" style="background: {{ $service->color }}20; color: {{ $service->color }}">
                            <i class="fas {{ $service->icon }}"></i>
                        </div>
                        <h3>{{ $service->name }}</h3>
                        <p>{{ $service->description }}</p>
                        <div class="check-mark">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </label>
                    @endforeach
                </div>

                @error('complaint_service_id')
                <div class="error-message">{{ $message }}</div>
                @enderror

                <div class="step-actions">
                    <button type="button" class="btn btn-primary" onclick="nextStep(1)">
                        Lanjut <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- Step 2: Isi Data -->
            <div class="form-step" id="step2">
                <div class="step-header">
                    <h2><i class="fas fa-edit"></i> Data Pelapor & Detail Pengaduan</h2>
                    <p>Lengkapi informasi di bawah ini dengan benar</p>
                </div>

                <div class="form-grid">
                    <!-- Data Pelapor -->
                    <div class="form-section-card">
                        <h3><i class="fas fa-user"></i> Data Pelapor</h3>
                        
                        <div class="form-group">
                            <label for="reporter_name" class="required">Nama Lengkap</label>
                            <input type="text" 
                                   name="reporter_name" 
                                   id="reporter_name" 
                                   class="form-control @error('reporter_name') is-invalid @enderror" 
                                   value="{{ old('reporter_name') }}" 
                                   placeholder="Masukkan nama lengkap Anda"
                                   required>
                            @error('reporter_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="reporter_nik">NIK (Opsional)</label>
                                    <input type="text" 
                                           name="reporter_nik" 
                                           id="reporter_nik" 
                                           class="form-control @error('reporter_nik') is-invalid @enderror" 
                                           value="{{ old('reporter_nik') }}" 
                                           placeholder="16 digit NIK"
                                           maxlength="16"
                                           pattern="[0-9]{16}">
                                    @error('reporter_nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text">NIK membantu mempercepat proses verifikasi</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="reporter_phone" class="required">No. Handphone</label>
                                    <input type="tel" 
                                           name="reporter_phone" 
                                           id="reporter_phone" 
                                           class="form-control @error('reporter_phone') is-invalid @enderror" 
                                           value="{{ old('reporter_phone') }}" 
                                           placeholder="Contoh: 08123456789"
                                           required>
                                    @error('reporter_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text">Untuk notifikasi WhatsApp</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="reporter_email">Email (Opsional)</label>
                            <input type="email" 
                                   name="reporter_email" 
                                   id="reporter_email" 
                                   class="form-control @error('reporter_email') is-invalid @enderror" 
                                   value="{{ old('reporter_email') }}" 
                                   placeholder="email@example.com">
                            @error('reporter_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text">Untuk notifikasi email</small>
                        </div>

                        <div class="form-group">
                            <label for="reporter_address">Alamat (Opsional)</label>
                            <textarea name="reporter_address" 
                                      id="reporter_address" 
                                      class="form-control @error('reporter_address') is-invalid @enderror" 
                                      rows="3" 
                                      placeholder="Alamat lengkap Anda"
                                      required>{{ old('reporter_address') }}</textarea>
                            @error('reporter_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Detail Pengaduan -->
                    <div class="form-section-card">
                        <h3><i class="fas fa-exclamation-circle"></i> Detail Pengaduan</h3>
                        
                        <div class="form-group">
                            <label for="subject" class="required">Judul Pengaduan</label>
                            <input type="text" 
                                   name="subject" 
                                   id="subject" 
                                   class="form-control @error('subject') is-invalid @enderror" 
                                   value="{{ old('subject') }}" 
                                   placeholder="Ringkasan singkat pengaduan Anda"
                                   required>
                            @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description" class="required">Isi Pengaduan</label>
                            <textarea name="description" 
                                      id="description" 
                                      class="form-control @error('description') is-invalid @enderror" 
                                      rows="6" 
                                      placeholder="Jelaskan pengaduan Anda secara detail..."
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text">Minimal 20 karakter</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="location">Lokasi Kejadian</label>
                                    <input type="text" 
                                           name="location" 
                                           id="location" 
                                           class="form-control @error('location') is-invalid @enderror" 
                                           value="{{ old('location') }}" 
                                           placeholder="Contoh: Puskesmas Ungaran"
                                           required>
                                    @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="incident_date">Tanggal Kejadian</label>
                                    <input type="date" 
                                           name="incident_date" 
                                           id="incident_date" 
                                           class="form-control @error('incident_date') is-invalid @enderror" 
                                           value="{{ old('incident_date') }}"
                                           max="{{ date('Y-m-d') }}"
                                           required>
                                    @error('incident_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="priority">Tingkat Urgensi</label>
                            <select name="priority" 
                                    id="priority" 
                                    class="form-control @error('priority') is-invalid @enderror">
                                <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Sedang</option>
                                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                                <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Mendesak</option>
                            </select>
                            @error('priority')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="evidence_file">Upload Bukti (Opsional)</label>
                            <div class="file-upload-wrapper">
                                <input type="file" 
                                       name="evidence_file" 
                                       id="evidence_file" 
                                       class="form-control-file @error('evidence_file') is-invalid @enderror" 
                                       accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                                       onchange="previewFile(this)">
                                <div class="file-upload-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Klik untuk pilih file atau drag & drop</span>
                                    <small>Format: JPG, PNG, PDF, DOC (Max. 5MB)</small>
                                </div>
                                <div class="file-preview" id="filePreview" style="display:none;">
                                    <i class="fas fa-file"></i>
                                    <span class="file-name"></span>
                                    <span class="file-size"></span>
                                    <button type="button" class="remove-file" onclick="removeFile()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            @error('evidence_file')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="step-actions">
                    <button type="button" class="btn btn-secondary" onclick="prevStep(2)">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </button>
                    <button type="button" class="btn btn-primary" onclick="nextStep(2)">
                        Lanjut <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- Step 3: Konfirmasi -->
            <div class="form-step" id="step3">
                <div class="step-header">
                    <h2><i class="fas fa-check-circle"></i> Konfirmasi & Submit</h2>
                    <p>Periksa kembali data Anda sebelum mengirim</p>
                </div>

                <div class="review-card">
                    <h3>Ringkasan Pengaduan</h3>
                    
                    <div class="review-section">
                        <h4><i class="fas fa-list"></i> Layanan</h4>
                        <p id="review-service">-</p>
                    </div>

                    <div class="review-section">
                        <h4><i class="fas fa-user"></i> Data Pelapor</h4>
                        <table class="review-table">
                            <tr>
                                <td>Nama</td>
                                <td id="review-name">-</td>
                            </tr>
                            <tr>
                                <td>NIK</td>
                                <td id="review-nik">-</td>
                            </tr>
                            <tr>
                                <td>No. HP</td>
                                <td id="review-phone">-</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td id="review-email">-</td>
                            </tr>
                        </table>
                    </div>

                    <div class="review-section">
                        <h4><i class="fas fa-exclamation-circle"></i> Detail Pengaduan</h4>
                        <table class="review-table">
                            <tr>
                                <td>Judul</td>
                                <td id="review-subject">-</td>
                            </tr>
                            <tr>
                                <td>Isi Pengaduan</td>
                                <td id="review-description">-</td>
                            </tr>
                            <tr>
                                <td>Lokasi</td>
                                <td id="review-location">-</td>
                            </tr>
                            <tr>
                                <td>Tanggal Kejadian</td>
                                <td id="review-date">-</td>
                            </tr>
                            <tr>
                                <td>Urgensi</td>
                                <td id="review-priority">-</td>
                            </tr>
                            <tr>
                                <td>File Bukti</td>
                                <td id="review-file">-</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="agreement-section">
                    <label class="agreement-checkbox">
                        <input type="checkbox" id="agreement" required>
                        <span>
                            Saya menyatakan bahwa data yang saya sampaikan adalah <strong>benar</strong> dan dapat <strong>dipertanggungjawabkan</strong>. Saya bersedia menerima konsekuensi hukum apabila data yang saya berikan terbukti <strong>tidak benar</strong>.
                        </span>
                    </label>
                </div>

                <div class="step-actions">
                    <button type="button" class="btn btn-secondary" onclick="prevStep(3)">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </button>
                    <button type="submit" class="btn btn-success" id="submitBtn">
                        <i class="fas fa-paper-plane"></i> Kirim Pengaduan
                    </button>
                </div>
            </div>
        </form>

        <!-- Info Panel -->
        <div class="info-panel">
            <div class="info-card">
                <i class="fas fa-info-circle"></i>
                <h4>Informasi Penting</h4>
                <ul>
                    <li>Pengaduan akan diproses maksimal <strong>3-7 hari kerja</strong></li>
                    <li>Anda akan mendapat <strong>nomor tiket</strong> untuk tracking</li>
                    <li>Notifikasi akan dikirim via <strong>Email & WhatsApp</strong></li>
                    <li>Data pribadi Anda akan <strong>dijaga kerahasiaannya</strong></li>
                </ul>
            </div>

            <div class="info-card">
                <i class="fas fa-headset"></i>
                <h4>Butuh Bantuan?</h4>
                <p>Hubungi kami:</p>
                
                    <i class="fas fa-phone"></i> (024) 6923955<br>
                    <i class="fas fa-envelope"></i> dinkeskabsemarang@gmail.com<br>
                    <i class="fas fa-clock"></i>Senin-kamis: 08:00-15:30 <br>
                     <i class="fas fa-clock"></i>Jum'at: 08:00-11:00 <br>
                    <i class="fas fa-clock"></i>Sabtu-minggu Libur
                </p>
            </div>
        </div>
    </div>
</section>

<style>
.form-hero {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    padding: 3rem 0;
    margin-bottom: 2rem;
}

.form-hero h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
}

.breadcrumb {
    background: rgba(255,255,255,0.1);
    padding: 0.75rem 1.25rem;
    border-radius: 8px;
    display: inline-flex;
    margin-bottom: 1.5rem;
}

.breadcrumb-item a {
    color: rgba(255,255,255,0.9);
    text-decoration: none;
}

.breadcrumb-item.active {
    color: white;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    padding: 0 0.5rem;
}

/* Progress Steps */
.progress-section {
    background: white;
    padding: 2rem 0;
    margin-bottom: 2rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.progress-steps {
    display: flex;
    align-items: center;
    justify-content: center;
    max-width: 600px;
    margin: 0 auto;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
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
    font-size: 1.25rem;
    font-weight: 700;
    transition: all 0.3s;
}

.step.active .step-number,
.step.completed .step-number {
    background: #3b82f6;
    color: white;
}

.step-label {
    font-size: 0.875rem;
    color: #64748b;
    font-weight: 600;
}

.step.active .step-label {
    color: #1e293b;
}

.step-line {
    flex: 1;
    height: 2px;
    background: #e2e8f0;
    margin: 0 1rem;
    max-width: 100px;
}

/* Form Section */
.form-section {
    padding: 2rem 0 4rem;
    background: #f8fafc;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

.form-step {
    display: none;
}

.form-step.active {
    display: block;
}

.step-header {
    text-align: center;
    margin-bottom: 3rem;
}

.step-header h2 {
    font-size: 2rem;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.step-header p {
    color: #64748b;
    font-size: 1.125rem;
}

/* Service Cards */
.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.service-card {
    position: relative;
    background: white;
    padding: 2rem;
    border-radius: 12px;
    border: 3px solid #e2e8f0;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.service-card input[type="radio"] {
    position: absolute;
    opacity: 0;
}

.service-card:hover {
    border-color: #3b82f6;
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(59, 130, 246, 0.2);
}

.service-card.selected {
    border-color: #3b82f6;
    background: #eff6ff;
}

.service-icon {
    width: 80px;
    height: 80px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.service-card h3 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.service-card p {
    color: #64748b;
    font-size: 0.875rem;
    line-height: 1.6;
}

.check-mark {
    position: absolute;
    top: 1rem;
    right: 1rem;
    font-size: 1.5rem;
    color: #3b82f6;
    opacity: 0;
    transition: all 0.3s;
}

.service-card.selected .check-mark {
    opacity: 1;
}

/* Form Grid */
.form-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
    margin-bottom: 2rem;
}

.form-section-card {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.form-section-card h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f1f5f9;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    font-weight: 600;
    color: #334155;
    margin-bottom: 0.5rem;
    font-size: 0.9375rem;
}

.form-group label.required::after {
    content: '*';
    color: #ef4444;
    margin-left: 0.25rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.9375rem;
    transition: all 0.3s;
}

.form-control:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
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

.row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

/* File Upload */
.file-upload-wrapper {
    position: relative;
}

.form-control-file {
    position: absolute;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

.file-upload-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem 2rem;
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    background: #f8fafc;
    cursor: pointer;
    transition: all 0.3s;
}

.file-upload-label:hover {
    border-color: #3b82f6;
    background: #eff6ff;
}

.file-upload-label i {
    font-size: 3rem;
    color: #3b82f6;
    margin-bottom: 1rem;
}

.file-upload-label span {
    font-size: 1rem;
    color: #475569;
    font-weight: 600;
}

.file-upload-label small {
    font-size: 0.8125rem;
    color: #94a3b8;
    margin-top: 0.5rem;
}

.file-preview {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f1f5f9;
    border-radius: 8px;
    margin-top: 1rem;
}

.file-preview i {
    font-size: 2rem;
    color: #3b82f6;
}

.file-preview .file-name {
    flex: 1;
    font-weight: 600;
    color: #1e293b;
}

.file-preview .file-size {
    color: #64748b;
    font-size: 0.875rem;
}

.remove-file {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: none;
    background: #ef4444;
    color: white;
    cursor: pointer;
    transition: all 0.3s;
}

.remove-file:hover {
    background: #dc2626;
}

/* Review Card */
.review-card {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
}

.review-card h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f1f5f9;
}

.review-section {
    margin-bottom: 2rem;
}

.review-section h4 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #475569;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.review-section > p {
    font-size: 1rem;
    color: #1e293b;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 8px;
}

.review-table {
    width: 100%;
}

.review-table td {
    padding: 0.75rem;
    border-bottom: 1px solid #f1f5f9;
}

.review-table td:first-child {
    font-weight: 600;
    color: #64748b;
    width: 200px;
}

.review-table td:last-child {
    color: #1e293b;
}

/* Agreement */
.agreement-section {
    background: #fef3c7;
    border: 2px solid #fbbf24;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.agreement-checkbox {
    display: flex;
    gap: 1rem;
    align-items: start;
    cursor: pointer;
}

.agreement-checkbox input {
    width: 20px;
    height: 20px;
    margin-top: 0.25rem;
    cursor: pointer;
}

.agreement-checkbox span {
    flex: 1;
    color: #92400e;
    line-height: 1.6;
}

/* Step Actions */
.step-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-top: 2rem;
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

.btn-success {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
}

/* Info Panel */
.info-panel {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-top: 3rem;
}

.info-card {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.info-card i {
    font-size: 2.5rem;
    color: #3b82f6;
    margin-bottom: 1rem;
}

.info-card h4 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1rem;
}

.info-card ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.info-card li {
    padding: 0.5rem 0;
    color: #475569;
    line-height: 1.6;
}

.info-card p {
    color: #475569;
    line-height: 1.8;
}

.error-message {
    background: #fee2e2;
    color: #991b1b;
    padding: 1rem;
    border-radius: 8px;
    margin-top: 1rem;
}

@media (max-width: 768px) {
    .form-hero h1 {
        font-size: 2rem;
    }

    .progress-steps {
        flex-direction: column;
    }

    .step-line {
        width: 2px;
        height: 40px;
        margin: 0.5rem 0;
    }

    .services-grid {
        grid-template-columns: 1fr;
    }

    .step-actions {
        flex-direction: column;
    }

    .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
let currentStep = 1;

// Service selection handler
document.querySelectorAll('.service-card').forEach(card => {
    card.addEventListener('click', function() {
        document.querySelectorAll('.service-card').forEach(c => c.classList.remove('selected'));
        this.classList.add('selected');
        this.querySelector('input[type="radio"]').checked = true;
    });
});

// Step navigation
function nextStep(step) {
    // Validate current step
    if (!validateStep(step)) {
        return;
    }

    // Hide current step
    document.getElementById('step' + step).classList.remove('active');
    
    // Show next step
    document.getElementById('step' + (step + 1)).classList.add('active');
    
    // Update progress
    updateProgress(step + 1);
    
    // Scroll to top
    window.scrollTo({top: 0, behavior: 'smooth'});

    // If going to review, populate review data
    if (step === 2) {
        populateReview();
    }
}

function prevStep(step) {
    document.getElementById('step' + step).classList.remove('active');
    document.getElementById('step' + (step - 1)).classList.add('active');
    updateProgress(step - 1);
    window.scrollTo({top: 0, behavior: 'smooth'});
}

function updateProgress(step) {
    document.querySelectorAll('.step').forEach((s, index) => {
        if (index + 1 < step) {
            s.classList.add('completed');
            s.classList.remove('active');
        } else if (index + 1 === step) {
            s.classList.add('active');
            s.classList.remove('completed');
        } else {
            s.classList.remove('active', 'completed');
        }
    });
}

function validateStep(step) {
    if (step === 1) {
        const serviceSelected = document.querySelector('input[name="complaint_service_id"]:checked');
        if (!serviceSelected) {
            alert('Silakan pilih layanan terlebih dahulu!');
            return false;
        }
    }
    
    if (step === 2) {
        const requiredFields = ['reporter_name', 'reporter_phone', 'subject', 'description'];
        for (let field of requiredFields) {
            const input = document.getElementById(field);
            if (!input.value.trim()) {
                alert('Mohon lengkapi semua field yang wajib diisi!');
                input.focus();
                return false;
            }
        }

        // Validate description length
        const description = document.getElementById('description').value;
        if (description.length < 20) {
            alert('Isi pengaduan minimal 20 karakter!');
            document.getElementById('description').focus();
            return false;
        }
    }
    
    return true;
}

function populateReview() {
    // Service
    const selectedService = document.querySelector('input[name="complaint_service_id"]:checked');
    const serviceLabel = selectedService ? selectedService.closest('.service-card').querySelector('h3').textContent : '-';
    document.getElementById('review-service').textContent = serviceLabel;

    // Data Pelapor
    document.getElementById('review-name').textContent = document.getElementById('reporter_name').value || '-';
    document.getElementById('review-nik').textContent = document.getElementById('reporter_nik').value || '-';
    document.getElementById('review-phone').textContent = document.getElementById('reporter_phone').value || '-';
    document.getElementById('review-email').textContent = document.getElementById('reporter_email').value || '-';

    // Detail Pengaduan
    document.getElementById('review-subject').textContent = document.getElementById('subject').value || '-';
    document.getElementById('review-description').textContent = document.getElementById('description').value || '-';
    document.getElementById('review-location').textContent = document.getElementById('location').value || '-';
    document.getElementById('review-date').textContent = document.getElementById('incident_date').value || '-';
    
    const priority = document.getElementById('priority');
    document.getElementById('review-priority').textContent = priority.options[priority.selectedIndex].text;

    const fileInput = document.getElementById('evidence_file');
    document.getElementById('review-file').textContent = fileInput.files.length > 0 ? fileInput.files[0].name : 'Tidak ada file';
}

// File upload preview
function previewFile(input) {
    const file = input.files[0];
    if (file) {
        const filePreview = document.getElementById('filePreview');
        const fileName = filePreview.querySelector('.file-name');
        const fileSize = filePreview.querySelector('.file-size');
        
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        
        filePreview.style.display = 'flex';
        input.closest('.file-upload-wrapper').querySelector('.file-upload-label').style.display = 'none';
    }
}

function removeFile() {
    const fileInput = document.getElementById('evidence_file');
    fileInput.value = '';
    
    document.getElementById('filePreview').style.display = 'none';
    document.querySelector('.file-upload-label').style.display = 'flex';
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
}

// Form submission
document.getElementById('complaintForm').addEventListener('submit', function(e) {
    const agreement = document.getElementById('agreement');
    if (!agreement.checked) {
        e.preventDefault();
        alert('Anda harus menyetujui pernyataan terlebih dahulu!');
        return false;
    }

    // Show loading
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
});
</script>
@endsection