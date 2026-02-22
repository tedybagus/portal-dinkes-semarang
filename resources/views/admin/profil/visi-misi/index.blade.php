@extends('layouts.app')

@section('title', 'Kelola Visi Misi & Motto')
@push('styles')
<style>
.body{
    background-color: #f9fafb;
    }
.page-header {
   background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    margin-bottom: 1.5rem;
}

.page-header h1 {
    font-size: 1.875rem;
    font-weight: 700;
    color: #111827;
    margin: 0;
}

.page-header p {
    color: #6b7280;
    margin: 0;
    font-size: 0.875rem;
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
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}
.filament-action-button {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.875rem;
        margin-right: 0.75rem;
        transition: color 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .filament-action-button:hover {
        color: #764ba2;
    }
    
    .filament-action-button-publish {
        color: #10b981;
    }
    
    .filament-action-button-publish:hover {
        color: #059669;
    }
    
    .filament-action-button-delete {
        color: #ef4444;
        background: none;
        border: none;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.875rem;
        padding: 0;
        transition: color 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .filament-action-button-delete:hover {
        color: #dc2626;
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
        background: linear-gradient(135deg, #ff0202 0%, #050505 100%);
        color: white;
    }
    
    .filament-button-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        color: white;
    }

.empty-state {
    text-align: center;
    padding: 3rem 2rem;
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
@endpush

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <h1><i class="fas fa-bullseye"></i> Kelola Visi Misi & Motto</h1>
        <p>Manajemen visi, misi, dan motto organisasi</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.visi-misi.create') }}" class="filament-button filament-button-primary">
            <i class="fas fa-plus"></i> Tambah Visi Misi
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
        @if($visiMisi->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="60">No</th>
                            <th>Visi</th>
                            <th>Misi</th>
                            <th>Motto</th>
                            <th width="100">Status</th>
                            <th width="150">Tanggal</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($visiMisi as $index => $item)
                            <tr>
                                <td>{{ $visiMisi->firstItem() + $index }}</td>
                                <td>{!!$item->visi !!}</td>
                                <td>{!!$item->misi !!}</td>
                                <td>
                                    @if($item->motto)
                                        <span class="badge badge-info">{{ $item->motto }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->is_active)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td>{{ $item->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="filament-action-button">
                                        <a href="{{ route('admin.visi-misi.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.visi-misi.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
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
                {{ $visiMisi->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-bullseye"></i>
                <h3>Belum Ada Data</h3>
                <p>Belum ada visi misi yang ditambahkan</p>
                <a href="{{ route('admin.visi-misi.create') }}" class="filament-button filament-button-primary">
                    Tambah Visi Misi
                </a>
            </div>
        @endif
    </div>
</div>


@endsection