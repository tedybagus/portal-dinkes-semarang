@extends('layouts.app')

@section('title', 'Import Data PPID')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-file-upload"></i> Import Data Informasi Publik</h1>
    <a href="{{ route('admin.ppid-informations.index') }}" class="btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    <i class="fas fa-exclamation-circle"></i>
    {{ session('error') }}
</div>
@endif

<div class="import-container">
    <!-- Instructions Card -->
    <div class="card info-card">
        <div class="card-header">
            <h3><i class="fas fa-info-circle"></i> Panduan Import</h3>
        </div>
        <div class="card-body">
            <ol class="import-steps">
                <li>
                    <strong>Download Template Excel</strong>
                    <p>Download template untuk memastikan format yang benar</p>
                    <a href="{{ route('admin.ppid-informations.download-template') }}" class="btn btn-success">
                        <i class="fas fa-download"></i> Download Template
                    </a>
                </li>
                <li>
                    <strong>Isi Data di Template</strong>
                    <p>Lengkapi data informasi publik sesuai kolom yang tersedia</p>
                </li>
                <li>
                    <strong>Upload File Excel</strong>
                    <p>Upload file yang sudah diisi menggunakan form di bawah</p>
                </li>
            </ol>

            <div class="format-info">
                <h4><i class="fas fa-table"></i> Format Kolom Excel:</h4>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Kolom</th>
                            <th>Wajib</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>Kategori</code></td>
                            <td><span class="badge badge-danger">Ya</span></td>
                            <td>
                                Nama kategori. Pilihan:
                                @foreach($categories as $cat)
                                    <span class="badge badge-info">{{ $cat->name }}</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td><code>Judul</code></td>
                            <td><span class="badge badge-danger">Ya</span></td>
                            <td>Judul informasi publik</td>
                        </tr>
                        <tr>
                            <td><code>Deskripsi</code></td>
                            <td><span class="badge badge-secondary">Tidak</span></td>
                            <td>Deskripsi detail informasi</td>
                        </tr>
                        <tr>
                            <td><code>Nomor Informasi</code></td>
                            <td><span class="badge badge-secondary">Tidak</span></td>
                            <td>Nomor SK/Dokumen</td>
                        </tr>
                        <tr>
                            <td><code>Jenis</code></td>
                            <td><span class="badge badge-secondary">Tidak</span></td>
                            <td>Jenis informasi (Laporan, SK, dll)</td>
                        </tr>
                        <tr>
                            <td><code>Penanggung Jawab</code></td>
                            <td><span class="badge badge-secondary">Tidak</span></td>
                            <td>Unit penanggung jawab</td>
                        </tr>
                        <tr>
                            <td><code>Format</code></td>
                            <td><span class="badge badge-secondary">Tidak</span></td>
                            <td>softcopy / hardcopy / keduanya</td>
                        </tr>
                        <tr>
                            <td><code>Tahun</code></td>
                            <td><span class="badge badge-secondary">Tidak</span></td>
                            <td>Tahun (default: tahun sekarang)</td>
                        </tr>
                        <tr>
                            <td><code>Tanggal Terbit</code></td>
                            <td><span class="badge badge-secondary">Tidak</span></td>
                            <td>Format: dd/mm/yyyy</td>
                        </tr>
                        <tr>
                            <td><code>Publik</code></td>
                            <td><span class="badge badge-secondary">Tidak</span></td>
                            <td>Ya / Tidak (default: Ya)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Upload Form Card -->
    <div class="card upload-card">
        <div class="card-header">
            <h3><i class="fas fa-upload"></i> Upload File Excel</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.ppid-informations.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
                @csrf

                <div class="upload-zone" id="uploadZone">
                    <input 
                        type="file" 
                        name="file" 
                        id="fileInput" 
                        accept=".xlsx,.xls,.csv"
                        required
                        hidden
                    >
                    
                    <div class="upload-placeholder" id="uploadPlaceholder">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p class="upload-title">Klik atau Drag & Drop file Excel di sini</p>
                        <p class="upload-subtitle">Format: .xlsx, .xls, .csv (Max. 5MB)</p>
                        <button type="button" class="btn btn-primary" onclick="document.getElementById('fileInput').click()">
                            <i class="fas fa-folder-open"></i> Pilih File
                        </button>
                    </div>

                    <div class="upload-preview" id="uploadPreview" style="display: none;">
                        <i class="fas fa-file-excel file-icon"></i>
                        <div class="file-info">
                            <p class="file-name" id="fileName"></p>
                            <p class="file-size" id="fileSize"></p>
                        </div>
                        <button type="button" class="btn-remove" onclick="removeFile()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                @error('file')
                    <div class="alert alert-danger mt-3">{{ $message }}</div>
                @enderror

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-lg" id="submitBtn" disabled>
                        <i class="fas fa-upload"></i> Import Data
                    </button>
                    <a href="{{ route('admin.ppid-informations.index') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Warning Card -->
    <div class="card warning-card">
        <div class="card-body">
            <h4><i class="fas fa-exclamation-triangle"></i> Perhatian!</h4>
            <ul>
                <li>Pastikan format file sesuai dengan template yang disediakan</li>
                <li>Kategori harus sesuai dengan yang tersedia di sistem</li>
                <li>Data yang sudah ada tidak akan di-overwrite, hanya ditambahkan</li>
                <li>Proses import mungkin membutuhkan waktu untuk file berukuran besar</li>
                <li>Jika ada error, periksa kembali format data di Excel</li>
            </ul>
        </div>
    </div>
</div>

<style>
.import-container {
    max-width: 1200px;
    margin: 0 auto;
}

.card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
}

.card-header {
    padding: 1.5rem;
    border-bottom: 2px solid #f1f5f9;
}

.card-header h3 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.card-body {
    padding: 2rem;
}

/* Info Card */
.import-steps {
    counter-reset: step-counter;
    list-style: none;
    padding: 0;
}

.import-steps li {
    counter-increment: step-counter;
    margin-bottom: 2rem;
    padding-left: 3rem;
    position: relative;
}

.import-steps li::before {
    content: counter(step-counter);
    position: absolute;
    left: 0;
    top: 0;
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.125rem;
}

.import-steps strong {
    display: block;
    font-size: 1.125rem;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.import-steps p {
    color: #64748b;
    margin-bottom: 0.75rem;
}

.format-info {
    margin-top: 2rem;
    padding: 1.5rem;
    background: #f8fafc;
    border-radius: 8px;
}

.format-info h4 {
    font-size: 1rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1rem;
}

/* Upload Zone */
.upload-zone {
    border: 3px dashed #cbd5e1;
    border-radius: 12px;
    padding: 3rem;
    text-align: center;
    transition: all 0.3s;
    background: #f8fafc;
}

.upload-zone:hover {
    border-color: #3b82f6;
    background: #eff6ff;
}

.upload-zone.dragover {
    border-color: #10b981;
    background: #ecfdf5;
}

.upload-placeholder i {
    font-size: 4rem;
    color: #94a3b8;
    margin-bottom: 1rem;
}

.upload-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.upload-subtitle {
    color: #64748b;
    margin-bottom: 1.5rem;
}

.upload-preview {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1.5rem;
    padding: 2rem;
}

.file-icon {
    font-size: 4rem;
    color: #10b981;
}

.file-info {
    flex: 1;
    text-align: left;
}

.file-name {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.file-size {
    color: #64748b;
    font-size: 0.875rem;
}

.btn-remove {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: none;
    background: #fee2e2;
    color: #ef4444;
    cursor: pointer;
    font-size: 1.25rem;
    transition: all 0.3s;
}

.btn-remove:hover {
    background: #ef4444;
    color: white;
}

/* Warning Card */
.warning-card {
    border-left: 4px solid #f59e0b;
}

.warning-card .card-body {
    background: #fffbeb;
}

.warning-card h4 {
    color: #92400e;
    margin-bottom: 1rem;
}

.warning-card ul {
    color: #78350f;
    margin: 0;
    padding-left: 1.5rem;
}

.warning-card li {
    margin-bottom: 0.5rem;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}
</style>

<script>
const fileInput = document.getElementById('fileInput');
const uploadZone = document.getElementById('uploadZone');
const uploadPlaceholder = document.getElementById('uploadPlaceholder');
const uploadPreview = document.getElementById('uploadPreview');
const submitBtn = document.getElementById('submitBtn');

// File input change
fileInput.addEventListener('change', function(e) {
    handleFile(this.files[0]);
});

// Drag & Drop
['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    uploadZone.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    uploadZone.addEventListener(eventName, () => {
        uploadZone.classList.add('dragover');
    }, false);
});

['dragleave', 'drop'].forEach(eventName => {
    uploadZone.addEventListener(eventName, () => {
        uploadZone.classList.remove('dragover');
    }, false);
});

uploadZone.addEventListener('drop', function(e) {
    const files = e.dataTransfer.files;
    if (files.length) {
        fileInput.files = files;
        handleFile(files[0]);
    }
}, false);

function handleFile(file) {
    if (!file) return;

    // Validate file type
    const validTypes = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/csv'];
    if (!validTypes.includes(file.type) && !file.name.match(/\.(xlsx|xls|csv)$/i)) {
        alert('Format file tidak valid. Gunakan .xlsx, .xls, atau .csv');
        return;
    }

    // Validate file size (5MB)
    if (file.size > 5 * 1024 * 1024) {
        alert('Ukuran file terlalu besar. Maksimal 5MB');
        return;
    }

    // Show preview
    document.getElementById('fileName').textContent = file.name;
    document.getElementById('fileSize').textContent = formatBytes(file.size);
    
    uploadPlaceholder.style.display = 'none';
    uploadPreview.style.display = 'flex';
    submitBtn.disabled = false;
}

function removeFile() {
    fileInput.value = '';
    uploadPlaceholder.style.display = 'block';
    uploadPreview.style.display = 'none';
    submitBtn.disabled = true;
}

function formatBytes(bytes, decimals = 2) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

// Form submission
document.getElementById('importForm').addEventListener('submit', function() {
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Importing...';
});
</script>
@endsection