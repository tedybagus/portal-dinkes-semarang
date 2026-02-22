@extends('layouts.app')

@section('title', 'Kelola Struktur Organisasi')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <h1><i class="fas fa-sitemap"></i> Kelola Struktur Organisasi</h1>
        <p>Manajemen bagan dan informasi struktur organisasi</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.struktur-organisasi.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Struktur Organisasi
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="card-body">
        @if($struktur->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="60">#</th>
                            <th width="120">Bagan</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th width="100">Status</th>
                            <th width="150">Tanggal</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($struktur as $index => $item)
                            <tr>
                                <td>{{ $struktur->firstItem() + $index }}</td>
                                <td>
                                    @if($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="struktur-thumb">
                                    @else
                                        <div class="struktur-thumb-placeholder">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $item->title }}</strong>
                                </td>
                                <td>{{ Str::limit($item->description, 100) }}</td>
                                <td>
                                    @if($item->is_active)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td>{{ $item->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="btn-group">
                                        @if($item->image)
                                            <a href="{{ asset('storage/' . $item->image) }}" target="_blank" class="btn btn-sm btn-info" title="Lihat Bagan">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.struktur-organisasi.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.struktur-organisasi.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus? Gambar bagan juga akan terhapus.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
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

            <div class="mt-3">
                {{ $struktur->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-sitemap"></i>
                <h3>Belum Ada Data</h3>
                <p>Belum ada struktur organisasi yang ditambahkan</p>
                <a href="{{ route('admin.struktur-organisasi.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Struktur Organisasi
                </a>
            </div>
        @endif
    </div>
</div>

<style>
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e5e7eb;
}

.page-header-content h1 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.page-header-content p {
    color: #6b7280;
    margin: 0;
}

.card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.card-body {
    padding: 1.5rem;
}

.table {
    width: 100%;
    margin: 0;
}

.table thead th {
    background: #f9fafb;
    font-weight: 600;
    color: #374151;
    padding: 1rem;
    border-bottom: 2px solid #e5e7eb;
}

.table tbody td {
    padding: 1rem;
    border-bottom: 1px solid #e5e7eb;
    vertical-align: middle;
}

.struktur-thumb {
    width: 100px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
    border: 2px solid #e5e7eb;
}

.struktur-thumb-placeholder {
    width: 100px;
    height: 60px;
    border-radius: 6px;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    font-size: 1.5rem;
    border: 2px dashed #d1d5db;
}

.badge {
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 600;
}

.badge-success {
    background: #d1fae5;
    color: #065f46;
}

.badge-secondary {
    background: #e5e7eb;
    color: #6b7280;
}

.badge-info {
    background: #dbeafe;
    color: #1e40af;
}

.btn-group {
    display: flex;
    gap: 0.5rem;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-state i {
    font-size: 4rem;
    color: #d1d5db;
    margin-bottom: 1rem;
}

.empty-state h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #6b7280;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #9ca3af;
    margin-bottom: 1.5rem;
}

.alert {
    padding: 1rem 1.25rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.alert-success {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #10b981;
}
</style>
@endsection