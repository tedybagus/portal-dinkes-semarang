@extends('layouts.app')

@section('title', 'Kelola Alur Permohonan')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-route"></i> Alur Permohonan Informasi</h1>
    <a href="{{ route('admin.information-flows.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Tambah Alur
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-list"></i> Daftar Alur Permohonan</h3>
        <span class="badge badge-primary">Total: {{ $flows->total() }}</span>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="80">Step</th>
                        <th>Judul Langkah</th>
                        <th>Deskripsi</th>
                        <th width="100">Durasi</th>
                        <th width="100">Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($flows as $flow)
                    <tr>
                        <td>
                            <div class="step-number">
                                {{ $flow->step_number }}
                            </div>
                        </td>
                        <td>
                            <div class="flow-title">
                                @if($flow->icon)
                                <i class="fas {{ $flow->icon }}"></i>
                                @endif
                                <strong>{{ $flow->title }}</strong>
                            </div>
                        </td>
                        <td>
                            <p class="text-muted mb-0">{{ Str::limit($flow->description, 80) }}</p>
                        </td>
                        <td>
                            @if($flow->duration_days)
                            <span class="badge badge-info">
                                <i class="fas fa-clock"></i>
                                {{ $flow->duration_days }} hari
                            </span>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $flow->is_active ? 'badge-success' : 'badge-secondary' }}">
                                {{ $flow->is_active ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.information-flows.edit', $flow->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.information-flows.destroy', $flow->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada alur permohonan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($flows->hasPages())
        <div class="mt-3">
            {{ $flows->links() }}
        </div>
        @endif
    </div>
</div>

<style>
.step-number {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    border-radius: 50%;
    font-weight: 700;
    font-size: 1.125rem;
}

.flow-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.flow-title i {
    color: #3b82f6;
    font-size: 1.25rem;
}
</style>
@endsection