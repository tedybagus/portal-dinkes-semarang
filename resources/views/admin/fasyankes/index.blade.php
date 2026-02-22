@extends('layouts.app')

@section('title', 'Data Fasyankes')

@push('styles')
<style>
    body {
        background-color: #f9fafb;
    }
    
    .filament-page {
        padding: 1.5rem;
    }
    
    .filament-header {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
    }
    
    .filament-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }
    
    .filament-subtitle {
        color: #6b7280;
        margin: 0;
        font-size: 0.875rem;
    }
    
    .filament-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .filament-card-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .filament-card-title {
        font-size: 1.125rem;
        font-weight: 600;
        margin: 0;
    }
    
    .filament-card-body {
        padding: 1.5rem;
    }
    
    .filament-search-wrapper {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        display: flex;
        align-items: center;
        padding: 0.5rem 1rem;
        transition: all 0.2s;
    }
    
    .filament-search-wrapper:focus-within {
        background: white;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .filament-search-wrapper input {
        border: none;
        background: transparent;
        width: 100%;
        outline: none;
        font-size: 0.875rem;
    }
    
    .filament-search-icon {
        color: #9ca3af;
        margin-right: 0.5rem;
    }
    
    .filament-select {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 0.625rem 1rem;
        font-size: 0.875rem;
        transition: all 0.2s;
        width: 100%;
    }
    
    .filament-select:focus {
        background: white;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }
    
    .filament-button {
        padding: 0.625rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }
    
    .filament-button-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .filament-button-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    .filament-button-secondary {
        background: #f3f4f6;
        color: #374151;
    }
    
    .filament-button-secondary:hover {
        background: #e5e7eb;
        color: #374151;
    }
    
    .filament-button-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }
    
    .filament-button-success:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        color: white;
    }
    
    .filament-button-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }
    
    .filament-button-danger:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        color: white;
    }
    
    .filament-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .filament-table thead th {
        background: #f9fafb;
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #6b7280;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .filament-table tbody tr {
        border-bottom: 1px solid #f3f4f6;
        transition: background-color 0.2s;
    }
    
    .filament-table tbody tr:hover {
        background-color: #f9fafb;
    }
    
    .filament-table tbody tr.selected {
        background-color: #eff6ff;
    }
    
    .filament-table tbody td {
        padding: 1rem;
        font-size: 0.875rem;
    }
    
    .filament-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.375rem 0.875rem;
        border-radius: 6px;
        font-size: 0.875rem;
        font-weight: 600;
        gap: 0.5rem;
    }
    
    .filament-badge-success {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .filament-badge-warning {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .filament-badge-danger {
        background-color: #fee2e2;
        color: #991b1b;
    }
    
    .filament-badge-info {
        background-color: #dbeafe;
        color: #1e40af;
    }
    
    .filament-action-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 2rem;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        margin: 0 0.125rem;
    }
    
    .filament-action-button-view {
        background-color: #dbeafe;
        color: #1e40af;
    }
    
    .filament-action-button-view:hover {
        background-color: #bfdbfe;
    }
    
    .filament-action-button-edit {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .filament-action-button-edit:hover {
        background-color: #fde68a;
    }
    
    .filament-action-button-delete {
        background-color: #fee2e2;
        color: #991b1b;
    }
    
    .filament-action-button-delete:hover {
        background-color: #fecaca;
    }
    
    .filament-stats {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #6b7280;
        font-size: 0.875rem;
        margin-bottom: 1rem;
    }
    
    .filament-empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }
    
    .filament-empty-state-icon {
        font-size: 4rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }
    
    .filament-empty-state-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
    }
    
    .filament-empty-state-description {
        color: #6b7280;
        margin-bottom: 1.5rem;
    }
    
    /* Checkbox Styles */
    .checkbox-custom {
        width: 1.125rem;
        height: 1.125rem;
        cursor: pointer;
        accent-color: #667eea;
    }
    
    /* Bulk Action Bar */
    .bulk-action-bar {
        position: fixed;
        bottom: 2rem;
        left: 50%;
        transform: translateX(-50%);
        background: white;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        display: none;
        align-items: center;
        gap: 1rem;
        z-index: 1000;
        animation: slideUp 0.3s ease-out;
    }
    
    .bulk-action-bar.active {
        display: flex;
    }
    
    @keyframes slideUp {
        from {
            transform: translateX(-50%) translateY(100%);
            opacity: 0;
        }
        to {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }
    }
    
    .bulk-action-bar-text {
        font-size: 0.875rem;
        font-weight: 600;
        color: #111827;
    }
    
    .bulk-action-bar-count {
        background: #667eea;
        color: white;
        padding: 0.25rem 0.625rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
    }
    
    /* Modal */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }
    
    .modal-overlay.active {
        display: flex;
    }
    
    .modal {
        background: white;
        border-radius: 12px;
        max-width: 500px;
        width: 100%;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        animation: modalSlideIn 0.3s ease-out;
    }
    
    @keyframes modalSlideIn {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    .modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .modal-header-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        border-radius: 12px 12px 0 0;
    }
    
    .modal-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.25rem;
        font-weight: 700;
        margin: 0;
    }
    
    .modal-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    
    .modal-body {
        padding: 1.5rem;
    }
    
    .modal-message {
        color: #6b7280;
        font-size: 0.875rem;
        line-height: 1.5;
    }
    
    .modal-footer {
        padding: 1.5rem;
        border-top: 1px solid #e5e7eb;
        background: #f9fafb;
        border-radius: 0 0 12px 12px;
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
    }
</style>
@endpush

@section('content')
<div class="filament-page">
    <div class="container-fluid">
        <div class="filament-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="filament-title">Data Fasyankes</h1>
                    <p class="filament-subtitle">Kelola data fasilitas kesehatan</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.fasyankes.maps') }}" class="filament-button filament-button-success">
                        <i class="fas fa-map-marked-alt"></i> Lihat Peta
                    </a>
                    <a href="{{ route('admin.fasyankes.create') }}" class="filament-button filament-button-primary">
                        <i class="fas fa-plus"></i> Tambah Data
                    </a>
                    <a href="{{ route('admin.fasyankes.import') }}" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Import Excel
                    </a>
                    {{-- <a href="{{ route('admin.fasyankes.dashboard.export') }}" class="btn btn-secondary">
                        <i class="fas fa-download"></i> Export PDF
                    </a> --}}

                </div>
            </div>
        </div>

        {{-- Alert Success --}}
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border-left: 4px solid #10b981;">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
        @endif

        {{-- Alert Error --}}
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; border-left: 4px solid #ef4444;">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
        @endif

        <div class="filament-card">
            <div class="filament-card-header">
                <h3 class="filament-card-title">
                    <i class="fas fa-hospital mr-2"></i> Daftar Fasyankes
                </h3>
            </div>

            <div class="filament-card-body">
                {{-- Search & Filter --}}
                <form action="{{ route('admin.fasyankes.index') }}" method="GET">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="filament-search-wrapper">
                                <i class="fas fa-search filament-search-icon"></i>
                                <input type="text" 
                                       name="search" 
                                       placeholder="Cari nama, kode, atau alamat..." 
                                       value="{{ request('search') }}">
                                @if(request('kategori'))
                                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                                @endif
                                <button type="submit" class="btn btn-link p-0 ml-2">
                                    <i class="fas fa-arrow-right text-primary"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select class="filament-select" name="kategori" onchange="this.form.submit()">
                                <option value="">Semua Kategori</option>
                                @foreach (\App\Models\Klinik::orderBy('nama')->get() as $kat)
                                    <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                                        {{ $kat->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            @if(request('search') || request('kategori'))
                                <a href="{{ route('admin.fasyankes.index') }}" class="filament-button filament-button-secondary w-100">
                                    <i class="fas fa-redo"></i> Reset
                                </a>
                            @endif
                        </div>
                    </div>
                </form>

                {{-- Stats --}}
                <div class="filament-stats">
                    <i class="fas fa-info-circle"></i>
                    <span>Menampilkan <strong>{{ $fasyankes->firstItem() ?? 0 }}</strong> - <strong>{{ $fasyankes->lastItem() ?? 0 }}</strong> dari <strong>{{ $fasyankes->total() }}</strong> data</span>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="filament-table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">
                                    <input type="checkbox" class="checkbox-custom" id="checkAll">
                                </th>
                                <th style="width: 60px;">No</th>
                                <th>Kategori</th>
                                <th>Nama Fasyankes</th>
                                <th>Kode</th>
                                <th>Alamat</th>
                                <th style="width: 100px;" class="text-center">Koordinat</th>
                                <th style="width: 120px;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($fasyankes as $index => $item)
                            <tr class="data-row">
                                <td>
                                    <input type="checkbox" 
                                           class="checkbox-custom row-checkbox" 
                                           name="selected_ids[]" 
                                           value="{{ $item->id }}"
                                           data-nama="{{ $item->nama }}">
                                </td>
                                <td class="text-center" style="color: #6b7280;">{{ $fasyankes->firstItem() + $index }}</td>
                                <td>
                                    <span class="filament-badge filament-badge-{{ 
                                        $item->kategori->color ?? 'info' 
                                    }}">
                                        <i class="{{ $item->kategori->icon ?? 'fas fa-hospital' }}"></i>
                                        {{ $item->kategori->nama ?? '-' }}
                                    </span>
                                </td>
                                <td style="font-weight: 600; color: #111827;">{{ $item->nama }}</td>
                                <td>
                                    <span style="color: #d1d5db;">•</span>
                                    <span style="color: #4d1d5db;">{{ $item->kode }}</span>
                                </td>
                                <td style="color: #6b7280;">{{ Str::limit($item->alamat, 50) }}</td>
                                <td class="text-center">
                                    @if ($item->latitude && $item->longitude)
                                        <a href="https://www.google.com/maps?q={{ $item->latitude }},{{ $item->longitude }}" 
                                           target="_blank" 
                                           class="filament-action-button filament-action-button-view" 
                                           title="Lihat di Google Maps">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </a>
                                    @else
                                        <span style="color: #d1d5db;">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('admin.fasyankes.edit', $item->id) }}" 
                                           class="filament-action-button filament-action-button-edit" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="filament-action-button filament-action-button-delete" 
                                                onclick="showDeleteModal({{ $item->id }}, '{{ addslashes($item->nama) }}')"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8">
                                    <div class="filament-empty-state">
                                        <div class="filament-empty-state-icon">
                                            <i class="fas fa-inbox"></i>
                                        </div>
                                        <div class="filament-empty-state-title">
                                            @if(request('search') || request('kategori'))
                                                Tidak ada data yang sesuai
                                            @else
                                                Belum ada data fasyankes
                                            @endif
                                        </div>
                                        <div class="filament-empty-state-description">
                                            @if(request('search') || request('kategori'))
                                                Coba ubah filter atau kata kunci pencarian
                                            @else
                                                Mulai dengan menambahkan data fasyankes pertama
                                            @endif
                                        </div>
                                        @if(request('search') || request('kategori'))
                                            <a href="{{ route('admin.fasyankes.index') }}" class="filament-button filament-button-secondary">
                                                <i class="fas fa-redo"></i> Reset Filter
                                            </a>
                                        @else
                                            <a href="{{ route('admin.fasyankes.create') }}" class="filament-button filament-button-primary">
                                                <i class="fas fa-plus"></i> Tambah Data Pertama
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($fasyankes->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $fasyankes->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Bulk Action Bar --}}
<div class="bulk-action-bar" id="bulkActionBar">
    <span class="bulk-action-bar-text">
        <span class="bulk-action-bar-count" id="selectedCount">0</span> data dipilih
    </span>
    <button type="button" class="filament-button filament-button-danger" onclick="showBulkDeleteModal()">
        <i class="fas fa-trash"></i> Hapus Semua
    </button>
    <button type="button" class="filament-button filament-button-secondary" onclick="clearSelection()">
        <i class="fas fa-times"></i> Batal
    </button>
</div>

{{-- Single Delete Modal --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <div class="modal-header modal-header-danger">
            <h5 class="modal-title">
                <div class="modal-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <span>Konfirmasi Hapus</span>
            </h5>
        </div>
        <div class="modal-body">
            <p class="modal-message">
                Apakah Anda yakin ingin menghapus fasyankes <strong id="deleteName"></strong>?
                <br><br>
                Tindakan ini tidak dapat dibatalkan.
            </p>
        </div>
        <div class="modal-footer">
            <button type="button" class="filament-button filament-button-secondary" onclick="hideDeleteModal()">
                <i class="fas fa-times"></i> Batal
            </button>
            <form id="deleteForm" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="filament-button filament-button-danger">
                    <i class="fas fa-trash"></i> Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Bulk Delete Modal --}}
<div class="modal-overlay" id="bulkDeleteModal">
    <div class="modal">
        <div class="modal-header modal-header-danger">
            <h5 class="modal-title">
                <div class="modal-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <span>Konfirmasi Hapus Massal</span>
            </h5>
        </div>
        <form action="{{ route('admin.fasyankes.bulk-delete') }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-body">
                <div style="background: #f3f4f6; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                    <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">
                        Anda akan menghapus <strong id="bulkDeleteCount">0</strong> data:
                    </p>
                    <ul id="bulkDeleteList" style="margin: 0; padding-left: 1.5rem; color: #111827; font-size: 0.875rem;">
                    </ul>
                </div>
                <p class="modal-message">
                    <i class="fas fa-exclamation-triangle" style="color: #ef4444;"></i>
                    <strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan. Semua data yang dipilih akan dihapus secara permanen.
                </p>
                <input type="hidden" name="ids" id="bulkDeleteIds">
            </div>
            <div class="modal-footer">
                <button type="button" class="filament-button filament-button-secondary" onclick="hideBulkDeleteModal()">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" class="filament-button filament-button-danger">
                    <i class="fas fa-trash"></i> Ya, Hapus Semua
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Single delete
function showDeleteModal(id, nama) {
    document.getElementById('deleteName').textContent = nama;
    document.getElementById('deleteForm').action = '{{ route("admin.fasyankes.destroy", ":id") }}'.replace(':id', id);
    document.getElementById('deleteModal').classList.add('active');
}

function hideDeleteModal() {
    document.getElementById('deleteModal').classList.remove('active');
}

// Bulk selection
const checkboxes = document.querySelectorAll('.row-checkbox');
const checkAll = document.getElementById('checkAll');
const bulkActionBar = document.getElementById('bulkActionBar');
const selectedCount = document.getElementById('selectedCount');

checkAll.addEventListener('change', function() {
    checkboxes.forEach(cb => {
        cb.checked = this.checked;
        if (this.checked) {
            cb.closest('tr').classList.add('selected');
        } else {
            cb.closest('tr').classList.remove('selected');
        }
    });
    updateBulkActionBar();
});

checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        if (this.checked) {
            this.closest('tr').classList.add('selected');
        } else {
            this.closest('tr').classList.remove('selected');
        }
        updateBulkActionBar();
        
        // Update check all status
        checkAll.checked = Array.from(checkboxes).every(cb => cb.checked);
    });
});

function updateBulkActionBar() {
    const selected = Array.from(checkboxes).filter(cb => cb.checked);
    selectedCount.textContent = selected.length;
    
    if (selected.length > 0) {
        bulkActionBar.classList.add('active');
    } else {
        bulkActionBar.classList.remove('active');
    }
}

function clearSelection() {
    checkboxes.forEach(cb => {
        cb.checked = false;
        cb.closest('tr').classList.remove('selected');
    });
    checkAll.checked = false;
    updateBulkActionBar();
}

function showBulkDeleteModal() {
    const selected = Array.from(checkboxes).filter(cb => cb.checked);
    const ids = selected.map(cb => cb.value);
    const names = selected.map(cb => cb.dataset.nama);
    
    document.getElementById('bulkDeleteCount').textContent = selected.length;
    document.getElementById('bulkDeleteIds').value = ids.join(',');
    
    const list = document.getElementById('bulkDeleteList');
    list.innerHTML = '';
    names.forEach(name => {
        const li = document.createElement('li');
        li.textContent = name;
        list.appendChild(li);
    });
    
    document.getElementById('bulkDeleteModal').classList.add('active');
}

function hideBulkDeleteModal() {
    document.getElementById('bulkDeleteModal').classList.remove('active');
}

// Close modals on ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        hideDeleteModal();
        hideBulkDeleteModal();
    }
});

// Close modal on outside click
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.remove('active');
        }
    });
});
</script>
@endpush
@endsection