@extends('layouts.app')

@section('title', 'Kelola Informasi Publik')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-list"></i> Daftar Informasi Publik (PPID)</h1>
    
    <div class="header-actions">
        <a href="{{ route('admin.ppid-informations.import-form') }}" class="btn btn-info">
            <i class="fas fa-file-upload"></i> Import Excel
        </a>
        
        <!-- Export Dropdown - FIXED VERSION -->
        <div class="dropdown-wrapper">
            <button class="btn btn-success" id="exportDropdownBtn">
                <i class="fas fa-file-download"></i> Export
                <i class="fas fa-chevron-down ml-1"></i>
            </button>
            <div class="dropdown-menu-custom" id="exportDropdownMenu">
                <a href="{{ route('admin.ppid-informations.export') }}" class="dropdown-item-custom">
                    <i class="fas fa-file-excel"></i> Export Semua Data
                </a>
                <a href="{{ route('admin.ppid-informations.export', ['category' => request('category'), 'year' => request('year')]) }}" class="dropdown-item-custom">
                    <i class="fas fa-filter"></i> Export dengan Filter
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('admin.ppid-informations.download-template') }}" class="dropdown-item-custom">
                    <i class="fas fa-download"></i> Download Template
                </a>
            </div>
        </div>
        
        <a href="{{ route('admin.ppid-informations.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Informasi
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card stat-primary">
        <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
        <div class="stat-info">
            <span class="stat-label">Total Informasi</span>
            <span class="stat-value">{{ $stats['total'] }}</span>
        </div>
    </div>
    <div class="stat-card stat-success">
        <div class="stat-icon"><i class="fas fa-eye"></i></div>
        <div class="stat-info">
            <span class="stat-label">Dipublikasikan</span>
            <span class="stat-value">{{ $stats['public'] }}</span>
        </div>
    </div>
    <div class="stat-card stat-info">
        <div class="stat-icon"><i class="fas fa-calendar"></i></div>
        <div class="stat-info">
            <span class="stat-label">Tahun Ini</span>
            <span class="stat-value">{{ $stats['this_year'] }}</span>
        </div>
    </div>
    <div class="stat-card stat-warning">
        <div class="stat-icon"><i class="fas fa-download"></i></div>
        <div class="stat-info">
            <span class="stat-label">Total Download</span>
            <span class="stat-value">{{ number_format($stats['total_downloads']) }}</span>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-filter"></i> Filter & Pencarian</h3>
    </div>
    <div class="card-body">
        <form method="GET" class="filter-form">
            <div class="filter-grid">
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="category" class="form-control" onchange="this.form.submit()">
                        <option value="all">Semua Kategori</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Tahun</label>
                    <select name="year" class="form-control" onchange="this.form.submit()">
                        <option value="all">Semua Tahun</option>
                        @foreach($years as $year)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Pencarian</label>
                    <div class="search-box">
                        <input type="text" name="search" class="form-control" placeholder="Cari judul, nomor, kata kunci..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                
                @if(request()->hasAny(['category', 'year', 'search']))
                <div class="form-group">
                    <label>&nbsp;</label>
                    <a href="{{ route('admin.ppid-informations.index') }}" class="btn btn-secondary btn-block">
                        <i class="fas fa-redo"></i> Reset Filter
                    </a>
                </div>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-list"></i> Daftar Informasi Publik</h3>
        <span class="badge badge-primary">{{ $informations->total() }} Total</span>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th width="150">Kategori</th>
                        <th>Judul & Deskripsi</th>
                        <th width="100">Tahun</th>
                        <th width="100">Format</th>
                        <th width="80">Status</th>
                        <th width="100">Stats</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($informations as $index => $info)
                    <tr>
                        <td>{{ $informations->firstItem() + $index }}</td>
                        <td>
                            <span class="category-badge" style="background: {{ $info->category->color }}20; color: {{ $info->category->color }}; border-left: 3px solid {{ $info->category->color }};">
                                {{ $info->category->name }}
                            </span>
                        </td>
                        <td>
                            <strong class="info-title">{{ $info->title }}</strong>
                            @if($info->information_number)
                            <br><small class="text-muted"><i class="fas fa-hashtag"></i> {{ $info->information_number }}</small>
                            @endif
                            @if($info->description)
                            <br><small class="text-muted">{{ Str::limit($info->description, 100) }}</small>
                            @endif
                            @if($info->file_path)
                            <br><span class="badge badge-info"><i class="fas fa-file"></i> File tersedia</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-secondary">{{ $info->year }}</span>
                        </td>
                        <td>
                            <span class="badge badge-primary">{{ ucfirst($info->information_format) }}</span>
                        </td>
                        <td>
                            @if($info->is_public)
                            <span class="badge badge-success"><i class="fas fa-eye"></i> Publik</span>
                            @else
                            <span class="badge badge-secondary"><i class="fas fa-eye-slash"></i> Draft</span>
                            @endif
                        </td>
                        <td>
                            <small class="text-muted">
                                <i class="fas fa-eye"></i> {{ $info->view_count }}<br>
                                <i class="fas fa-download"></i> {{ $info->download_count }}
                            </small>
                        </td>
                        <td>
                            <div class="btn-group-vertical btn-group-sm">
                                <a href="{{ route('admin.ppid-informations.edit', $info->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.ppid-informations.destroy', $info->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada informasi publik</p>
                            <a href="{{ route('admin.ppid-informations.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Informasi
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($informations->hasPages())
        <div class="mt-3">
            {{ $informations->links() }}
        </div>
        @endif
    </div>
</div>

<style>
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.stat-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    font-size: 1.75rem;
    color: white;
}

.stat-primary .stat-icon { background: linear-gradient(135deg, #3b82f6, #2563eb); }
.stat-success .stat-icon { background: linear-gradient(135deg, #10b981, #059669); }
.stat-info .stat-icon { background: linear-gradient(135deg, #6366f1, #4f46e5); }
.stat-warning .stat-icon { background: linear-gradient(135deg, #f59e0b, #d97706); }

.stat-label {
    display: block;
    font-size: 0.875rem;
    color: #64748b;
    margin-bottom: 0.25rem;
}

.stat-value {
    display: block;
    font-size: 2rem;
    font-weight: 800;
    color: #1e293b;
}

.filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.search-box {
    display: flex;
    gap: 0.5rem;
}

.search-box input {
    flex: 1;
}

.category-badge {
    display: inline-block;
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
    font-size: 0.8125rem;
    font-weight: 600;
}

.info-title {
    color: #1e293b;
    font-size: 0.9375rem;
}

/* DROPDOWN FIXED STYLES */
.dropdown-wrapper {
    position: relative;
    display: inline-block;
}

.dropdown-menu-custom {
    display: none;
    position: absolute;
    background: white;
    min-width: 280px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    border-radius: 8px;
    padding: 0.5rem 0;
    z-index: 1000;
    right: 0;
    top: calc(100% + 0.5rem);
}

.dropdown-menu-custom.show {
    display: block;
}

.dropdown-item-custom {
    display: block;
    padding: 0.75rem 1.25rem;
    color: #475569;
    text-decoration: none;
    transition: all 0.2s;
}

.dropdown-item-custom:hover {
    background: #f1f5f9;
    color: #1e293b;
}

.dropdown-item-custom i {
    width: 20px;
    margin-right: 0.5rem;
}

.dropdown-divider {
    height: 1px;
    background: #e2e8f0;
    margin: 0.5rem 0;
}

.ml-1 {
    margin-left: 0.25rem;
}
</style>

<script>
// Dropdown Export - FIXED VERSION
document.addEventListener('DOMContentLoaded', function() {
    const dropdownBtn = document.getElementById('exportDropdownBtn');
    const dropdownMenu = document.getElementById('exportDropdownMenu');
    
    if (dropdownBtn && dropdownMenu) {
        // Toggle dropdown on button click
        dropdownBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdownMenu.classList.toggle('show');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!dropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.remove('show');
            }
        });
        
        // Prevent dropdown from closing when clicking inside
        dropdownMenu.addEventListener('click', function(e) {
            // Allow links to work but close dropdown after click
            if (e.target.tagName === 'A') {
                setTimeout(() => {
                    dropdownMenu.classList.remove('show');
                }, 100);
            }
        });
    }
});
</script>
@endsection
