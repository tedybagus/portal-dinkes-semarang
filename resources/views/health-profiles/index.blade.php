@extends('layouts.public.app')

@section('title', 'Profil Kesehatan')
@section('content')
<!-- Hero Section -->
<div class="page-header">
    <div class="header-container">
        <h1 class="page-title">Profil Kesehatan Kabupaten Semarang</h1>
        <p class="page-subtitle">{{ $struktur->title ?? 'Profil Kesehatan Kabupaten Semarang' }}</p>
    </div>
</div>

<!-- Content Section -->
<section class="content-section">
    <div class="container">
        <div class="profile-card">
            <!-- Search & Filter -->
            <div class="card-header-custom">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Cari profil kesehatan..." class="search-input">
                </div>
                <div class="info-badge">
                    <i class="fas fa-database"></i>
                    <span>Total: <strong>{{ $profiles->count() }}</strong> Dokumen</span>
                </div>
            </div>

            <!-- Table -->
            <div class="table-container">
                <table class="modern-table" id="profileTable">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">No</th>
                            <th width="50"class="text-center">Nama Dokumen</th>
                            <th width="50" class="text-center">Format</th>
                            <th width="50" class="text-center">Statistik</th>
                            <th width="50" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($profiles as $index => $profile)
                        <tr class="table-row">
                            <td class="text-center">
                                <span class="row-number">{{ $index + 1 }}</span>
                            </td>
                            <td>
                                <div class="file-info">
                                    <div class="file-icon">
                                        <i class="fas fa-file-pdf"></i>
                                    </div>
                                    <div class="file-details">
                                        <h4 class="file-name">{{ $profile->name }}</h4>
                                        @if($profile->description)
                                        <p class="file-desc">{{ Str::limit($profile->description, 80) }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge-format badge-{{ strtolower($profile->file_type) }}">
                                    {{ strtoupper($profile->file_type) }}
                                </span>
                            </td>
                            <td>
                                <div class="stats-group">
                                    <div class="stat-item">
                                        <i class="fas fa-eye"></i>
                                        <span>{{ number_format($profile->view_count) }}</span>
                                    </div>
                                    <div class="stat-item">
                                        <i class="fas fa-download"></i>
                                        <span>{{ number_format($profile->download_count) }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <a href="{{ route('health-profiles.download', $profile->id) }}" 
                                       class="btn-download"
                                       title="Download {{ $profile->name }}">
                                        <i class="fas fa-download"></i>
                                        <span>Download</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="empty-state">
                                <div class="empty-content">
                                    <i class="fas fa-folder-open"></i>
                                    <h3>Belum Ada Data</h3>
                                    <p>Data profil kesehatan belum tersedia saat ini</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination if needed -->
            @if(method_exists($profiles, 'links') && $profiles->hasPages())
            <div class="pagination-wrapper">
                {{ $profiles->links() }}
            </div>
            @endif
        </div>

        <!-- Info Card -->
        <div class="info-alert">
            <i class="fas fa-info-circle"></i>
            <div>
                <strong>Informasi:</strong>
                <p>Dokumen profil kesehatan berisi data dan informasi kesehatan masyarakat Kabupaten Semarang. File tersedia dalam format PDF yang dapat diunduh secara gratis.</p>
            </div>
        </div>
    </div>
</section>
@push('styles')
    
@endpush
<style>
/* Hero Section */
.page-hero {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    padding: 3rem 0 4rem;
    margin-bottom: 3rem;
    position: relative;
    overflow: hidden;
}

.page-hero::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    border-radius: 50%;
}

.hero-content {
    position: relative;
    z-index: 1;
}

.breadcrumb-wrapper {
    margin-bottom: 1.5rem;
}

.breadcrumb {
    background: rgba(255, 255, 255, 0.1);
    padding: 0.75rem 1.25rem;
    border-radius: 8px;
    margin: 0;
    display: inline-flex;
}

.breadcrumb-item a {
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    transition: color 0.3s;
}

.breadcrumb-item a:hover {
    color: white;
}

.breadcrumb-item.active {
    color: white;
    font-weight: 600;
}

.breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, 0.7);
    content: "›";
}

.hero-title {
    color: white;
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.hero-title i {
    font-size: 2rem;
}

.hero-description {
    color: rgba(255, 255, 255, 0.95);
    font-size: 1.125rem;
    margin: 0;
}

/* Content Section */
.content-section {
    padding: 0 0 4rem;
    margin-top: -2rem;
}

.profile-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

/* Card Header */
.card-header-custom {
    background: linear-gradient(to right, #f8fafc, #f1f5f9);
    padding: 1.5rem 2rem;
    border-bottom: 2px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.search-box {
    position: relative;
    flex: 1;
    min-width: 250px;
    max-width: 400px;
}

.search-box i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #64748b;
}

.search-input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.75rem;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    font-size: 0.9375rem;
    transition: all 0.3s;
}

.search-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.info-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    color: #475569;
    font-size: 0.9375rem;
}

.info-badge i {
    color: #3b82f6;
}

/* Table Container */
.table-container {
    overflow-x: auto;
}

.modern-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.modern-table thead {
    background: linear-gradient(135deg, #1e293b, #334155);
}

.modern-table thead th {
    padding: 1.25rem 1.5rem;
    color: white;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 0.8125rem;
    letter-spacing: 0.5px;
    border: none;
}

.modern-table thead th:first-child {
    border-radius: 0;
}

.modern-table thead th:last-child {
    border-radius: 0;
}

.modern-table tbody tr {
    border-bottom: 1px solid #e2e8f0;
    transition: all 0.3s;
}

.modern-table tbody tr:hover {
    background: #f8fafc;
    transform: scale(1.001);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.modern-table tbody td {
    padding: 1.5rem 1.5rem;
    vertical-align: middle;
}

/* Row Number */
.row-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    border-radius: 8px;
    font-weight: 700;
    font-size: 0.875rem;
}

/* File Info */
.file-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.file-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    border-radius: 12px;
    color: #dc2626;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.file-details {
    flex: 1;
}

.file-name {
    font-size: 1rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 0.25rem 0;
    line-height: 1.4;
}

.file-desc {
    font-size: 0.875rem;
    color: #64748b;
    margin: 0;
    line-height: 1.5;
}

/* Badge Format */
.badge-format {
    display: inline-block;
    padding: 0.375rem 0.875rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-pdf {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    color: #991b1b;
}

.badge-doc,
.badge-docx {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    color: #1e40af;
}

.badge-xls,
.badge-xlsx {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    color: #065f46;
}

/* Stats Group */
.stats-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.375rem 0.75rem;
    background: #f1f5f9;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 600;
    color: #475569;
}

.stat-item i {
    color: #3b82f6;
    font-size: 0.75rem;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
}

.btn-download {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
}

.btn-download:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
    color: white;
}

.btn-download i {
    font-size: 0.875rem;
}

/* Empty State */
.empty-state {
    padding: 4rem 2rem !important;
}

.empty-content {
    text-align: center;
}

.empty-content i {
    font-size: 4rem;
    color: #cbd5e1;
    margin-bottom: 1rem;
}

.empty-content h3 {
    color: #475569;
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.empty-content p {
    color: #94a3b8;
    margin: 0;
}

/* Info Alert */
.info-alert {
    display: flex;
    gap: 1rem;
    padding: 1.25rem 1.5rem;
    background: linear-gradient(135deg, #dbeafe, #eff6ff);
    border-left: 4px solid #3b82f6;
    border-radius: 12px;
    margin-top: 2rem;
}

.info-alert i {
    color: #3b82f6;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.info-alert strong {
    color: #1e40af;
    display: block;
    margin-bottom: 0.25rem;
}

.info-alert p {
    color: #1e40af;
    margin: 0;
    line-height: 1.6;
}

/* Responsive */
@media (max-width: 768px) {
    .hero-title {
        font-size: 1.75rem;
    }

    .hero-title i {
        font-size: 1.5rem;
    }

    .card-header-custom {
        flex-direction: column;
        align-items: stretch;
    }

    .search-box {
        max-width: 100%;
    }

    .modern-table {
        font-size: 0.875rem;
    }

    .modern-table thead th,
    .modern-table tbody td {
        padding: 1rem;
    }

    .file-info {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .stats-group {
        flex-direction: row;
    }

    .info-alert {
        flex-direction: column;
        text-align: center;
    }
}
</style>
@push('scripts')
    

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('profileTable');
    const rows = table.querySelectorAll('tbody tr:not(.empty-state)');

    if (searchInput && rows.length > 0) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            rows.forEach(row => {
                const fileName = row.querySelector('.file-name')?.textContent.toLowerCase() || '';
                const fileDesc = row.querySelector('.file-desc')?.textContent.toLowerCase() || '';

                if (fileName.includes(searchTerm) || fileDesc.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});
</script>
@endpush
@endsection