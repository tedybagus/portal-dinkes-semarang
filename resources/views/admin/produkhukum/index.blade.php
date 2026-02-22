@extends('layouts.app')
@section('title', 'Produk Hukum')

@section('content')
<div class="produk-hukum-page">
    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1>Produk Hukum</h1>
            <p>Kelola dokumen produk hukum daerah</p>
        </div>
        <a href="{{ route('admin.produkhukum.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i>
            Tambah Produk Hukum
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: #dbeafe;">
                <i class="fas fa-file-alt" style="color: #3b82f6;"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $stats['total'] }}</div>
                <div class="stat-label">Total Dokumen</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #dcfce7;">
                <i class="fas fa-check-circle" style="color: #10b981;"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $stats['berlaku'] }}</div>
                <div class="stat-label">Berlaku</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fee2e2;">
                <i class="fas fa-times-circle" style="color: #ef4444;"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $stats['tidak_berlaku'] }}</div>
                <div class="stat-label">Tidak Berlaku</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fef3c7;">
                <i class="fas fa-calendar" style="color: #f59e0b;"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $stats['tahun_ini'] }}</div>
                <div class="stat-label">Tahun Ini</div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="filter-card">
        <form method="GET" class="filter-form">
            <div class="filter-group">
                <input type="text" 
                       name="search" 
                       class="form-input" 
                       placeholder="Cari nomor, tentang..."
                       value="{{ request('search') }}">
                
                <select name="kategori" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $key => $label)
                        <option value="{{ $key }}" {{ request('kategori') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>

                <select name="tahun" class="form-select">
                    <option value="">Semua Tahun</option>
                    @foreach($tahuns as $tahun)
                        <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                            {{ $tahun }}
                        </option>
                    @endforeach
                </select>

                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="berlaku" {{ request('status') == 'berlaku' ? 'selected' : '' }}>Berlaku</option>
                    <option value="tidak_berlaku" {{ request('status') == 'tidak_berlaku' ? 'selected' : '' }}>Tidak Berlaku</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                </select>

                <button type="submit" class="btn-filter">
                    <i class="fas fa-search"></i>
                    Filter
                </button>

                @if(request()->hasAny(['search', 'kategori', 'tahun', 'status']))
                    <a href="{{ route('admin.produkhukum.index') }}" class="btn-reset">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="table-card">
        @if($Produkhukum->count())
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th width="50">
                            <input type="checkbox" id="selectAll">
                        </th>
                        <th>Nomor & Tahun</th>
                        <th>Kategori</th>
                        <th>Tentang</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Download</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Produkhukum as $ph)
                    <tr>
                        <td>
                            <input type="checkbox" class="row-checkbox" value="{{ $ph->id }}">
                        </td>
                        <td>
                            <div class="nomor-info">
                                <div class="nomor">{{ $ph->nomor }}</div>
                                <div class="tahun">Tahun {{ $ph->tahun }}</div>
                            </div>
                        </td>
                        <td>
                            <span class="kategori-badge">{{ $ph->kategori_label }}</span>
                        </td>
                        <td>
                            <div class="tentang">{{ Str::limit($ph->tentang, 80) }}</div>
                        </td>
                        <td>
                            <div class="tanggal">{{ $ph->tanggal_penetapan->format('d M Y') }}</div>
                        </td>
                        <td>
                            <span class="status-badge status-{{ $ph->status }}">
                                {{ ucfirst($ph->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="download-info">
                                <i class="fas fa-download"></i>
                                {{ $ph->download_count }}x
                            </div>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.produkhukum.edit', $ph) }}" 
                                   class="btn-action btn-edit"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.produkhukum.toggle', $ph) }}" 
                                      method="POST" 
                                      style="display: inline;">
                                    @csrf
                                    <button type="submit" 
                                            class="btn-action btn-toggle"
                                            title="{{ $ph->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="fas fa-{{ $ph->is_active ? 'eye' : 'eye-slash' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.produkhukum.destroy', $ph) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Yakin hapus dokumen ini?')"
                                      style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn-action btn-delete"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="pagination-wrapper">
            {{ $Produkhukum->links() }}
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h3>Tidak ada data</h3>
            <p>{{ request()->hasAny(['search', 'kategori', 'tahun', 'status']) ? 'Tidak ada hasil yang sesuai filter' : 'Belum ada produk hukum yang ditambahkan' }}</p>
        </div>
        @endif
    </div>
</div>

<style>
.produk-hukum-page {
    padding: 2rem;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.page-header h1 {
    font-size: 1.875rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.page-header p {
    color: #64748b;
}

/* Stats */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,.1);
    display: flex;
    gap: 1rem;
}

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.stat-value {
    font-size: 2rem;
    font-weight: 800;
    color: #1e293b;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.875rem;
    color: #64748b;
}

/* Filter */
.filter-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,.1);
    margin-bottom: 1.5rem;
}

.filter-form {
    display: flex;
    gap: 1rem;
}

.filter-group {
    display: flex;
    gap: 1rem;
    flex: 1;
}

.form-input,
.form-select {
    padding: 0.625rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.9375rem;
}

.form-input {
    flex: 1;
}

.form-select {
    min-width: 180px;
}

.btn-filter,
.btn-reset {
    padding: 0.625rem 1.25rem;
    border-radius: 8px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-filter {
    background: #3b82f6;
    color: white;
}

.btn-filter:hover {
    background: #2563eb;
}

.btn-reset {
    background: #fee2e2;
    color: #991b1b;
    text-decoration: none;
    display: flex;
    align-items: center;
}

/* Table */
.table-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,.1);
    overflow: hidden;
}

.table-responsive {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th {
    background: #f8fafc;
    padding: 1rem;
    text-align: left;
    font-size: 0.875rem;
    font-weight: 600;
    color: #475569;
    border-bottom: 2px solid #e2e8f0;
}

.data-table td {
    padding: 1rem;
    border-bottom: 1px solid #e2e8f0;
}

.nomor-info .nomor {
    font-weight: 700;
    color: #1e293b;
}

.nomor-info .tahun {
    font-size: 0.875rem;
    color: #64748b;
}

.kategori-badge {
    display: inline-block;
    padding: 0.375rem 0.875rem;
    background: #eff6ff;
    color: #1e40af;
    border-radius: 20px;
    font-size: 0.8125rem;
    font-weight: 600;
}

.tentang {
    font-size: 0.9375rem;
    color: #475569;
    line-height: 1.5;
}

.tanggal {
    font-size: 0.875rem;
    color: #64748b;
}

.status-badge {
    display: inline-block;
    padding: 0.375rem 0.875rem;
    border-radius: 20px;
    font-size: 0.8125rem;
    font-weight: 600;
}

.status-berlaku {
    background: #dcfce7;
    color: #166534;
}

.status-tidak_berlaku {
    background: #fee2e2;
    color: #991b1b;
}

.status-draft {
    background: #fef3c7;
    color: #92400e;
}

.download-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #64748b;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn-action {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.btn-edit {
    background: #dbeafe;
    color: #1e40af;
}

.btn-toggle {
    background: #fef3c7;
    color: #92400e;
}

.btn-delete {
    background: #fee2e2;
    color: #991b1b;
}

.btn-action:hover {
    transform: scale(1.1);
}

.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: #3b82f6;
    color: white;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.2s;
}

.btn-primary:hover {
    background: #2563eb;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-state i {
    font-size: 4rem;
    color: #cbd5e1;
    margin-bottom: 1rem;
}

.empty-state h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #64748b;
}

.pagination-wrapper {
    padding: 1.5rem;
    border-top: 1px solid #e2e8f0;
}

@media (max-width: 1024px) {
    .filter-group {
        flex-wrap: wrap;
    }
    
    .form-input {
        flex: 1 1 100%;
    }
}
</style>

<script>
document.getElementById('selectAll')?.addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
});
</script>
@endsection