@extends('layouts.app')

@section('title', 'Kelola Permohonan Informasi')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-inbox"></i> Permohonan Informasi</h1>
</div>

<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card stat-warning">
        <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
        <div class="stat-info">
            <span class="stat-label">Diajukan</span>
            <span class="stat-value">{{ $stats['submitted'] }}</span>
        </div>
    </div>
    <div class="stat-card stat-info">
        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
        <div class="stat-info">
            <span class="stat-label">Diverifikasi</span>
            <span class="stat-value">{{ $stats['verified'] }}</span>
        </div>
    </div>
    <div class="stat-card stat-primary">
        <div class="stat-icon"><i class="fas fa-cog"></i></div>
        <div class="stat-info">
            <span class="stat-label">Diproses</span>
            <span class="stat-value">{{ $stats['processed'] }}</span>
        </div>
    </div>
    <div class="stat-card stat-success">
        <div class="stat-icon"><i class="fas fa-check-double"></i></div>
        <div class="stat-info">
            <span class="stat-label">Selesai</span>
            <span class="stat-value">{{ $stats['completed'] }}</span>
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
        <h3><i class="fas fa-list"></i> Daftar Permohonan</h3>
        
        <div class="header-actions">
            <form method="GET" class="filter-form">
                <select name="status" onchange="this.form.submit()" class="form-control">
                    <option value="all">Semua Status</option>
                    <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Diajukan</option>
                    <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Diverifikasi</option>
                    <option value="processed" {{ request('status') == 'processed' ? 'selected' : '' }}>Diproses</option>
                    <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>Siap Diambil</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </form>
            
            <form method="GET" class="search-form">
                <input type="text" name="search" placeholder="Cari..." value="{{ request('search') }}" class="form-control">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="150">No. Registrasi</th>
                        <th>Pemohon</th>
                        <th>Informasi</th>
                        <th width="120">Tgl Pengajuan</th>
                        <th width="120">Status</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $request)
                    <tr>
                        <td>
                            <code class="reg-number">{{ $request->registration_number }}</code>
                        </td>
                        <td>
                            <strong>{{ $request->name }}</strong><br>
                            <small class="text-muted">
                                <i class="fas fa-envelope"></i> {{ $request->email }}<br>
                                <i class="fas fa-phone"></i> {{ $request->phone }}
                            </small>
                        </td>
                        <td>
                            <p class="mb-0">{{ Str::limit($request->information_needed, 80) }}</p>
                            <small class="text-muted">{{ $request->requester_type_label }}</small>
                        </td>
                        <td>
                            <small>{{ $request->submitted_at->format('d M Y') }}<br>{{ $request->submitted_at->format('H:i') }}</small>
                        </td>
                        <td>
                            <span class="badge badge-{{ $request->status }}">{{ $request->status_label }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.information-requests.show', $request->id) }}" class="btn btn-sm btn-primary" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada permohonan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($requests->hasPages())
        <div class="mt-3">
            {{ $requests->links() }}
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

.stat-warning .stat-icon { background: linear-gradient(135deg, #f59e0b, #d97706); }
.stat-info .stat-icon { background: linear-gradient(135deg, #3b82f6, #2563eb); }
.stat-primary .stat-icon { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.stat-success .stat-icon { background: linear-gradient(135deg, #10b981, #059669); }

.stat-info {
    flex: 1;
}

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

.header-actions {
    display: flex;
    gap: 1rem;
}

.filter-form, .search-form {
    display: flex;
    gap: 0.5rem;
}

.reg-number {
    background: #f1f5f9;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-family: 'Courier New', monospace;
    font-size: 0.875rem;
}

.badge-submitted { background: #fef3c7; color: #92400e; }
.badge-verified { background: #dbeafe; color: #1e40af; }
.badge-processed { background: #e0e7ff; color: #4338ca; }
.badge-ready { background: #d1fae5; color: #065f46; }
.badge-completed { background: #d1fae5; color: #065f46; }
.badge-rejected { background: #fee2e2; color: #991b1b; }
</style>
@endsection