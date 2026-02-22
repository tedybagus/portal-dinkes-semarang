@extends('layouts.app')
@section('title', 'Kelola FAQ')

@section('content')
<div class="faq-admin-page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1><i class="fas fa-question-circle"></i> Kelola FAQ</h1>
            <p>Pertanyaan yang sering diajukan oleh masyarakat</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('faqs.index') }}" target="_blank" class="btn btn-secondary">
                <i class="fas fa-eye"></i> Lihat Public
            </a>
            <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah FAQ
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-row">
        <div class="stat-pill stat-total">
            <i class="fas fa-list"></i>
            <div><span>{{ $stats['total'] }}</span><small>Total FAQ</small></div>
        </div>
        <div class="stat-pill stat-active">
            <i class="fas fa-check-circle"></i>
            <div><span>{{ $stats['active'] }}</span><small>Aktif</small></div>
        </div>
        <div class="stat-pill stat-inactive">
            <i class="fas fa-times-circle"></i>
            <div><span>{{ $stats['inactive'] }}</span><small>Nonaktif</small></div>
        </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button onclick="this.parentElement.remove()" class="alert-close">&times;</button>
    </div>
    @endif

    {{-- Filters --}}
    <div class="filter-card">
        <form action="{{ route('admin.faqs.index') }}" method="GET" class="filter-form">
            <div class="filter-search">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Cari pertanyaan atau jawaban..."
                       value="{{ request('search') }}" class="form-input">
            </div>

            <select name="kategori" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $kat)
                <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                @endforeach
            </select>

            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="aktif"    {{ request('status') == 'aktif'    ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>

            <button type="submit" class="btn btn-search"><i class="fas fa-search"></i></button>

            @if(request()->hasAny(['search','kategori','status']))
            <a href="{{ route('admin.faqs.index') }}" class="btn btn-clear">
                <i class="fas fa-times"></i> Reset
            </a>
            @endif
        </form>

        {{-- Bulk actions --}}
        <form action="{{ route('admin.faqs.bulk') }}" method="POST" id="bulkForm">
            @csrf
            <div class="bulk-bar">
                <label class="bulk-check">
                    <input type="checkbox" id="checkAll" onchange="toggleAll(this)">
                    <span>Pilih semua</span>
                </label>
                <select name="action" class="form-select form-select-sm">
                    <option value="">-- Aksi --</option>
                    <option value="activate">Aktifkan</option>
                    <option value="deactivate">Nonaktifkan</option>
                    <option value="delete">Hapus</option>
                </select>
                <button type="submit" class="btn btn-sm btn-secondary"
                        onclick="return confirmBulk(this.form)">
                    Jalankan
                </button>
                <span id="selectedCount" class="selected-count">0 dipilih</span>
            </div>
        </form>
    </div>

    {{-- Table --}}
    @if($faqs->count())
    <div class="table-card">
        <table class="faq-table">
            <thead>
                <tr>
                    <th width="40">#</th>
                    <th width="40"><i class="fas fa-sort"></i></th>
                    <th>Pertanyaan</th>
                    <th width="120">Kategori</th>
                    <th width="80">Status</th>
                    <th width="80">Views</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody id="sortableBody">
                @foreach($faqs as $i => $faq)
                <tr class="faq-row {{ !$faq->is_active ? 'row-inactive' : '' }}" data-id="{{ $faq->id }}">
                    <td>
                        <input type="checkbox" class="row-check" value="{{ $faq->id }}"
                               onchange="updateSelected()" form="bulkForm" name="ids[]">
                    </td>
                    <td class="drag-handle" title="Drag untuk ubah urutan">
                        <i class="fas fa-grip-vertical"></i>
                    </td>
                    <td class="td-question">
                        <div class="question-text">{{ $faq->pertanyaan }}</div>
                        <div class="answer-preview">{{ Str::limit(strip_tags($faq->jawaban), 100) }}</div>
                    </td>
                    <td>
                        <span class="kat-badge">{{ $faq->kategori }}</span>
                    </td>
                    <td>
                        <form action="{{ route('admin.faqs.toggle', $faq) }}" method="POST">
                            @csrf
                            <button type="submit" class="toggle-btn {{ $faq->is_active ? 'toggle-active' : 'toggle-inactive' }}"
                                    title="{{ $faq->is_active ? 'Klik untuk nonaktifkan' : 'Klik untuk aktifkan' }}">
                                {{ $faq->is_active ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </form>
                    </td>
                    <td class="td-center">
                        <span class="view-count"><i class="fas fa-eye"></i> {{ $faq->view_count }}</span>
                    </td>
                    <td class="td-actions">
                        <a href="{{ route('admin.faqs.edit', $faq) }}" class="action-btn edit-btn" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn delete-btn" title="Hapus"
                                    onclick="return confirm('Hapus FAQ ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="pagination-wrap">
        <div class="pag-info">
            Menampilkan {{ $faqs->firstItem() }}–{{ $faqs->lastItem() }} dari {{ $faqs->total() }} FAQ
        </div>
        {{ $faqs->links() }}
    </div>

    @else
    <div class="empty-state">
        <i class="fas fa-question-circle"></i>
        <h3>Belum Ada FAQ</h3>
        <p>
            @if(request()->hasAny(['search','kategori','status']))
                Tidak ada FAQ yang sesuai filter. <a href="{{ route('admin.faqs.index') }}">Reset filter</a>
            @else
                Mulai dengan menambahkan FAQ pertama Anda.
            @endif
        </p>
        <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah FAQ Pertama
        </a>
    </div>
    @endif
</div>

<style>
.faq-admin-page { padding: 2rem; max-width: 1400px; }

/* Header */
.page-header { display:flex; justify-content:space-between; align-items:start; margin-bottom:1.5rem; }
.page-header h1 { font-size:1.875rem; font-weight:800; color:#1e293b; display:flex; align-items:center; gap:.75rem; margin-bottom:.25rem; }
.page-header h1 i { color:#f59e0b; }
.page-header p { color:#64748b; }
.header-actions { display:flex; gap:.75rem; }

/* Stats */
.stats-row { display:flex; gap:1rem; margin-bottom:1.5rem; }
.stat-pill { background:white; border-radius:10px; padding:1rem 1.5rem; display:flex; align-items:center; gap:1rem; box-shadow:0 2px 6px rgba(0,0,0,.07); }
.stat-pill i { font-size:1.75rem; }
.stat-pill span { font-size:1.75rem; font-weight:800; color:#1e293b; display:block; line-height:1; }
.stat-pill small { color:#64748b; font-size:.8125rem; }
.stat-total i { color:#3b82f6; }
.stat-active i { color:#10b981; }
.stat-inactive i { color:#ef4444; }

/* Alert */
.alert { display:flex; align-items:center; gap:.75rem; padding:1rem 1.25rem; border-radius:8px; margin-bottom:1.5rem; }
.alert-success { background:#d1fae5; color:#065f46; border:1px solid #10b981; }
.alert-close { margin-left:auto; background:none; border:none; font-size:1.25rem; cursor:pointer; opacity:.7; }
.alert-close:hover { opacity:1; }

/* Filters */
.filter-card { background:white; padding:1.25rem; border-radius:12px; box-shadow:0 2px 6px rgba(0,0,0,.07); margin-bottom:1.5rem; }
.filter-form { display:flex; gap:.75rem; align-items:center; margin-bottom:1rem; flex-wrap:wrap; }
.filter-search { flex:1; min-width:250px; position:relative; }
.filter-search i { position:absolute; left:.875rem; top:50%; transform:translateY(-50%); color:#94a3b8; }
.filter-search .form-input { padding-left:2.5rem; }
.form-input, .form-select { width:100%; padding:.625rem .875rem; border:2px solid #e2e8f0; border-radius:8px; font-size:.9375rem; transition:border-color .2s; }
.form-input:focus, .form-select:focus { outline:none; border-color:#3b82f6; }
.form-select { cursor:pointer; background-color:white; }
.form-select-sm { width:auto; padding:.5rem .75rem; font-size:.875rem; }

.bulk-bar { display:flex; align-items:center; gap:1rem; padding-top:1rem; border-top:1px solid #f1f5f9; }
.bulk-check { display:flex; align-items:center; gap:.5rem; cursor:pointer; font-weight:600; color:#475569; }
.bulk-check input { width:18px; height:18px; accent-color:#3b82f6; cursor:pointer; }
.selected-count { margin-left:auto; color:#64748b; font-size:.875rem; font-weight:600; }

/* Buttons */
.btn { display:inline-flex; align-items:center; gap:.5rem; padding:.75rem 1.25rem; border-radius:8px; font-weight:600; font-size:.9375rem; border:none; cursor:pointer; text-decoration:none; transition:all .2s; }
.btn-primary { background:linear-gradient(135deg,#3b82f6,#2563eb); color:white; }
.btn-primary:hover { transform:translateY(-2px); box-shadow:0 4px 12px rgba(59,130,246,.4); }
.btn-secondary { background:#f1f5f9; color:#475569; }
.btn-secondary:hover { background:#e2e8f0; }
.btn-search { background:#3b82f6; color:white; padding:.625rem 1rem; }
.btn-clear { background:#fee2e2; color:#991b1b; }
.btn-sm { padding:.5rem .875rem; font-size:.875rem; }

/* Table */
.table-card { background:white; border-radius:12px; box-shadow:0 2px 6px rgba(0,0,0,.07); overflow:hidden; margin-bottom:1.5rem; }
.faq-table { width:100%; border-collapse:collapse; }
.faq-table thead th { background:#f8fafc; padding:.875rem 1rem; text-align:left; font-size:.75rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.05em; border-bottom:2px solid #e2e8f0; }
.faq-table tbody tr { border-bottom:1px solid #f1f5f9; transition:background .15s; }
.faq-table tbody tr:hover { background:#f8fafc; }
.faq-table tbody td { padding:.875rem 1rem; vertical-align:middle; }
.row-inactive { opacity:.55; }

.td-question .question-text { font-weight:600; color:#1e293b; margin-bottom:.25rem; }
.td-question .answer-preview { font-size:.8125rem; color:#64748b; }

.kat-badge { padding:.25rem .875rem; background:#eff6ff; color:#2563eb; border-radius:20px; font-size:.8125rem; font-weight:600; white-space:nowrap; }

.toggle-btn { padding:.375rem .875rem; border-radius:20px; font-size:.8125rem; font-weight:600; border:none; cursor:pointer; transition:all .2s; }
.toggle-active { background:#d1fae5; color:#065f46; }
.toggle-active:hover { background:#a7f3d0; }
.toggle-inactive { background:#fee2e2; color:#991b1b; }
.toggle-inactive:hover { background:#fecaca; }

.td-center { text-align:center; }
.view-count { font-size:.8125rem; color:#94a3b8; display:flex; align-items:center; gap:.25rem; justify-content:center; }

.td-actions { white-space:nowrap; }
.action-btn { display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:6px; border:none; cursor:pointer; transition:all .2s; text-decoration:none; font-size:.875rem; }
.edit-btn { background:#dbeafe; color:#2563eb; }
.edit-btn:hover { background:#bfdbfe; }
.delete-btn { background:#fee2e2; color:#dc2626; }
.delete-btn:hover { background:#fecaca; }

.drag-handle { color:#cbd5e1; cursor:grab; }
.drag-handle:active { cursor:grabbing; }

/* Pagination */
.pagination-wrap { display:flex; justify-content:space-between; align-items:center; padding:.5rem 0; }
.pag-info { color:#64748b; font-size:.875rem; }

/* Empty */
.empty-state { background:white; border-radius:12px; padding:4rem 2rem; text-align:center; box-shadow:0 2px 6px rgba(0,0,0,.07); }
.empty-state > i { font-size:4rem; color:#cbd5e1; display:block; margin-bottom:1rem; }
.empty-state h3 { font-size:1.5rem; font-weight:700; color:#1e293b; margin-bottom:.5rem; }
.empty-state p { color:#64748b; margin-bottom:1.5rem; }
.empty-state a:not(.btn) { color:#3b82f6; font-weight:600; }

@media (max-width:768px) {
    .faq-admin-page { padding:1rem; }
    .page-header { flex-direction:column; gap:1rem; }
    .stats-row { flex-direction:column; }
    .filter-form { flex-direction:column; }
    .filter-search { min-width:unset; width:100%; }
    .header-actions { flex-direction:column; width:100%; }
    .btn { width:100%; justify-content:center; }
}
</style>

<script>
function toggleAll(cb) {
    document.querySelectorAll('.row-check').forEach(c => c.checked = cb.checked);
    updateSelected();
}
function updateSelected() {
    const n = document.querySelectorAll('.row-check:checked').length;
    document.getElementById('selectedCount').textContent = n + ' dipilih';
    const all = document.querySelectorAll('.row-check').length;
    document.getElementById('checkAll').checked = n === all && all > 0;
}
function confirmBulk(form) {
    const n   = document.querySelectorAll('.row-check:checked').length;
    const act = form.action.value;
    if (!n)   { alert('Pilih minimal 1 FAQ!'); return false; }
    if (!act) { alert('Pilih aksi!'); return false; }
    const labels = { activate:'aktifkan', deactivate:'nonaktifkan', delete:'hapus' };
    return confirm(`${labels[act]} ${n} FAQ terpilih?`);
}

// Auto-dismiss alert
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(el => {
        el.style.transition = 'opacity .4s';
        el.style.opacity    = '0';
        setTimeout(() => el.remove(), 400);
    });
}, 4000);
</script>
@endsection