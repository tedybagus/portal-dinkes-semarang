@extends('layouts.app')
@section('title','Standar Pelayanan')

@section('content')
<div class="sp-admin">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1><i class="fas fa-certificate"></i> Standar Pelayanan</h1>
            <p>Kelola standar pelayanan Dinas Kesehatan Kabupaten Semarang</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('public.standar_pelayanan.index') }}" target="_blank" class="btn btn-secondary">
                <i class="fas fa-eye"></i> Lihat Public
            </a>
            <a href="{{ route('admin.standar-pelayanan.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Layanan
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-row">
        <div class="stat-pill">
            <div class="sp-icon" style="background:#dbeafe;color:#3b82f6"><i class="fas fa-list"></i></div>
            <div><span class="sv">{{ $stats['total'] }}</span><small>Total Layanan</small></div>
        </div>
        <div class="stat-pill">
            <div class="sp-icon" style="background:#d1fae5;color:#10b981"><i class="fas fa-check-circle"></i></div>
            <div><span class="sv">{{ $stats['active'] }}</span><small>Aktif</small></div>
        </div>
        <div class="stat-pill">
            <div class="sp-icon" style="background:#fee2e2;color:#ef4444"><i class="fas fa-times-circle"></i></div>
            <div><span class="sv">{{ $stats['inactive'] }}</span><small>Nonaktif</small></div>
        </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
    <div class="alert-success-bar">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button onclick="this.parentElement.remove()">&times;</button>
    </div>
    @endif

    {{-- Filters --}}
    <div class="filter-card">
        <form action="{{ route('admin.standar-pelayanan.index') }}" method="GET" class="filter-form">
            <div class="search-wrap">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Cari nama layanan..."
                       value="{{ request('search') }}">
            </div>
            <select name="kategori" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $kat)
                <option value="{{ $kat }}" {{ request('kategori')==$kat?'selected':'' }}>{{ $kat }}</option>
                @endforeach
            </select>
            <select name="status" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="aktif"    {{ request('status')=='aktif'?'selected':'' }}>Aktif</option>
                <option value="nonaktif" {{ request('status')=='nonaktif'?'selected':'' }}>Nonaktif</option>
            </select>
            <button type="submit" class="btn btn-search"><i class="fas fa-search"></i></button>
            @if(request()->hasAny(['search','kategori','status']))
            <a href="{{ route('admin.standar-pelayanan.index') }}" class="btn btn-clear">
                <i class="fas fa-times"></i> Reset
            </a>
            @endif
        </form>

        {{-- Bulk --}}
        <form action="{{ route('admin.standar-pelayanan.bulk') }}" method="POST" id="bulkForm">
            @csrf
            <div class="bulk-bar">
                <label><input type="checkbox" id="checkAll" onchange="toggleAll(this)"> Pilih Semua</label>
                <select name="action">
                    <option value="">-- Aksi --</option>
                    <option value="activate">Aktifkan</option>
                    <option value="deactivate">Nonaktifkan</option>
                    <option value="delete">Hapus</option>
                </select>
                <button type="submit" onclick="return confirmBulk(this.form)" class="btn btn-sm">Jalankan</button>
                <span id="selCount" class="sel-count">0 dipilih</span>
            </div>
        </form>
    </div>

    {{-- Cards Grid --}}
    @if($items->count())
    <div class="cards-grid">
        @foreach($items as $item)
        <div class="sp-card {{ !$item->is_active ? 'sp-card-inactive' : '' }}">
            <div class="card-check">
                <input type="checkbox" class="row-check" value="{{ $item->id }}"
                       onchange="updateSel()" form="bulkForm" name="ids[]">
            </div>

            {{-- Color Bar --}}
            <div class="color-bar" style="background: {{ $item->warna }}"></div>

            <div class="card-body">
                {{-- Icon + Badge --}}
                <div class="card-top">
                    <div class="card-icon" style="background:{{ $item->warna }}20;color:{{ $item->warna }}">
                        <i class="fas {{ $item->icon }}"></i>
                    </div>
                    <div class="card-badges">
                        <span class="kat-badge">{{ $item->kategori }}</span>
                        <form action="{{ route('admin.standar-pelayanan.toggle', $item) }}" method="POST">
                            @csrf
                            <button type="submit" class="toggle-btn {{ $item->is_active?'t-active':'t-inactive' }}">
                                {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Name --}}
                <h3 class="card-title">{{ $item->nama }}</h3>

                @if($item->deskripsi)
                <p class="card-desc">{{ Str::limit($item->deskripsi, 100) }}</p>
                @endif

                {{-- Stats --}}
                <div class="card-meta">
                    <span><i class="fas fa-list-ul"></i> {{ $item->total_persyaratan }} persyaratan</span>
                    <span><i class="fas fa-eye"></i> {{ $item->view_count }} views</span>
                    <span><i class="fas fa-sort-numeric-up"></i> Urutan: {{ $item->urutan }}</span>
                </div>

                {{-- Persyaratan preview --}}
                @if($item->persyaratan)
                <div class="req-preview">
                    @foreach($item->persyaratan as $sek)
                    <div class="req-section-mini">
                        <strong>{{ $sek['judul'] }}</strong>
                        <ul>
                            @foreach(array_slice($sek['items'] ?? [], 0, 3) as $req)
                            <li>{{ $req }}</li>
                            @endforeach
                            @if(count($sek['items'] ?? []) > 3)
                            <li class="more">+{{ count($sek['items']) - 3 }} lainnya...</li>
                            @endif
                        </ul>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Actions --}}
            <div class="card-actions">
                <a href="{{ route('public.standar-pelayanan.show', $item->slug) }}"
                   target="_blank" class="act-btn act-view" title="Preview Public">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('admin.standar-pelayanan.edit', $item) }}"
                   class="act-btn act-edit" title="Edit">
                    <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('admin.standar-pelayanan.destroy', $item) }}" method="POST"
                      style="display:inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="act-btn act-del" title="Hapus"
                            onclick="return confirm('Hapus layanan ini?')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    <div class="pag-row">
        <span>Menampilkan {{ $items->firstItem() }}–{{ $items->lastItem() }} dari {{ $items->total() }}</span>
        {{ $items->links() }}
    </div>
    @else
    <div class="empty-state">
        <i class="fas fa-certificate"></i>
        <h3>Belum Ada Standar Pelayanan</h3>
        <p>@if(request()->hasAny(['search','kategori','status']))
            Tidak ada yang sesuai filter. <a href="{{ route('admin.standar-pelayanan.index') }}">Reset</a>
           @else Mulai tambahkan standar pelayanan. @endif</p>
        <a href="{{ route('admin.standar-pelayanan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Sekarang
        </a>
    </div>
    @endif
</div>

<style>
.sp-admin { padding:2rem; max-width:1400px; }
.page-header { display:flex; justify-content:space-between; align-items:start; margin-bottom:1.5rem; }
.page-header h1 { font-size:1.875rem; font-weight:800; color:#1e293b; display:flex; align-items:center; gap:.75rem; margin-bottom:.25rem; }
.page-header h1 i { color:#f59e0b; }
.page-header p { color:#64748b; }
.header-actions { display:flex; gap:.75rem; }

.stats-row { display:flex; gap:1rem; margin-bottom:1.5rem; flex-wrap:wrap; }
.stat-pill { background:white; border-radius:10px; padding:1rem 1.25rem; display:flex; align-items:center; gap:1rem; box-shadow:0 2px 6px rgba(0,0,0,.06); }
.sp-icon { width:48px; height:48px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1.375rem; flex-shrink:0; }
.sv { font-size:1.75rem; font-weight:800; color:#1e293b; display:block; line-height:1; }
.stat-pill small { color:#64748b; font-size:.8125rem; }

.alert-success-bar { display:flex; align-items:center; gap:.75rem; padding:.875rem 1.25rem; background:#d1fae5; color:#065f46; border:1px solid #10b981; border-radius:8px; margin-bottom:1.25rem; }
.alert-success-bar button { margin-left:auto; background:none; border:none; font-size:1.25rem; cursor:pointer; }

.filter-card { background:white; padding:1.25rem; border-radius:12px; box-shadow:0 2px 6px rgba(0,0,0,.06); margin-bottom:1.5rem; }
.filter-form { display:flex; gap:.75rem; align-items:center; flex-wrap:wrap; margin-bottom:1rem; }
.search-wrap { flex:1; min-width:250px; position:relative; }
.search-wrap i { position:absolute; left:.875rem; top:50%; transform:translateY(-50%); color:#94a3b8; }
.search-wrap input { width:100%; padding:.625rem .875rem .625rem 2.5rem; border:2px solid #e2e8f0; border-radius:8px; font-size:.9375rem; }
.search-wrap input:focus { outline:none; border-color:#3b82f6; }
.filter-form select { padding:.625rem .875rem; border:2px solid #e2e8f0; border-radius:8px; font-size:.9375rem; background:white; cursor:pointer; }
.filter-form select:focus { outline:none; border-color:#3b82f6; }
.bulk-bar { display:flex; align-items:center; gap:.875rem; padding-top:1rem; border-top:1px solid #f1f5f9; }
.bulk-bar label { display:flex; align-items:center; gap:.5rem; font-weight:600; color:#475569; cursor:pointer; }
.bulk-bar input[type=checkbox] { width:16px; height:16px; accent-color:#3b82f6; }
.bulk-bar select { padding:.5rem .75rem; border:2px solid #e2e8f0; border-radius:6px; font-size:.875rem; }
.sel-count { margin-left:auto; color:#64748b; font-size:.875rem; font-weight:600; }

.btn { display:inline-flex; align-items:center; gap:.5rem; padding:.625rem 1.25rem; border-radius:8px; font-weight:600; font-size:.9375rem; border:none; cursor:pointer; text-decoration:none; transition:all .2s; }
.btn-primary { background:linear-gradient(135deg,#3b82f6,#2563eb); color:white; }
.btn-primary:hover { transform:translateY(-2px); box-shadow:0 4px 12px rgba(59,130,246,.35); }
.btn-secondary { background:#f1f5f9; color:#475569; }
.btn-secondary:hover { background:#e2e8f0; }
.btn-search { background:#3b82f6; color:white; padding:.625rem 1rem; }
.btn-clear { background:#fee2e2; color:#991b1b; }
.btn-sm { padding:.5rem .875rem; font-size:.875rem; background:#f1f5f9; color:#475569; }

/* Cards Grid */
.cards-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(360px,1fr)); gap:1.5rem; margin-bottom:1.5rem; }
.sp-card { background:white; border-radius:14px; box-shadow:0 2px 8px rgba(0,0,0,.07); overflow:hidden; transition:all .25s; border:2px solid transparent; position:relative; }
.sp-card:hover { box-shadow:0 8px 24px rgba(0,0,0,.12); border-color:#e0e7ff; transform:translateY(-2px); }
.sp-card-inactive { opacity:.6; }
.color-bar { height:5px; }
.card-check { position:absolute; top:.875rem; left:.875rem; z-index:1; }
.card-check input { width:18px; height:18px; accent-color:#3b82f6; cursor:pointer; }

.card-body { padding:1.25rem 1.25rem 1rem; }
.card-top { display:flex; align-items:start; justify-content:space-between; margin-bottom:1rem; margin-left:1.75rem; }
.card-icon { width:52px; height:52px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1.5rem; flex-shrink:0; }
.card-badges { display:flex; flex-direction:column; align-items:flex-end; gap:.375rem; }
.kat-badge { padding:.25rem .75rem; background:#eff6ff; color:#2563eb; border-radius:20px; font-size:.75rem; font-weight:700; white-space:nowrap; }
.toggle-btn { padding:.25rem .75rem; border-radius:20px; font-size:.8125rem; font-weight:600; border:none; cursor:pointer; transition:all .2s; }
.t-active { background:#d1fae5; color:#065f46; }
.t-active:hover { background:#a7f3d0; }
.t-inactive { background:#fee2e2; color:#991b1b; }
.t-inactive:hover { background:#fecaca; }

.card-title { font-size:1.0625rem; font-weight:700; color:#1e293b; margin-bottom:.5rem; line-height:1.4; }
.card-desc { font-size:.875rem; color:#64748b; line-height:1.6; margin-bottom:.75rem; }
.card-meta { display:flex; flex-wrap:wrap; gap:1rem; font-size:.8125rem; color:#94a3b8; margin-bottom:.875rem; }
.card-meta i { margin-right:.25rem; }

.req-preview { background:#f8fafc; border-radius:8px; padding:.875rem 1rem; border-left:3px solid #e2e8f0; }
.req-section-mini strong { font-size:.8125rem; font-weight:700; color:#475569; display:block; margin-bottom:.375rem; }
.req-section-mini ul { list-style:none; padding:0; display:flex; flex-direction:column; gap:.2rem; }
.req-section-mini li { font-size:.8125rem; color:#64748b; padding-left:1rem; position:relative; }
.req-section-mini li::before { content:'•'; position:absolute; left:0; color:#94a3b8; }
.req-section-mini li.more { color:#3b82f6; font-weight:600; }
.req-section-mini li.more::before { color:#3b82f6; }

.card-actions { display:flex; border-top:1px solid #f1f5f9; }
.act-btn { flex:1; padding:.75rem; border:none; cursor:pointer; transition:all .2s; text-align:center; font-size:.9375rem; display:flex; align-items:center; justify-content:center; text-decoration:none; }
.act-view { background:#f0fdf4; color:#16a34a; }
.act-view:hover { background:#dcfce7; }
.act-edit { background:#eff6ff; color:#2563eb; }
.act-edit:hover { background:#dbeafe; }
.act-del { background:#fff1f2; color:#e11d48; }
.act-del:hover { background:#ffe4e6; }

.pag-row { display:flex; justify-content:space-between; align-items:center; }
.pag-row > span { color:#64748b; font-size:.875rem; }

.empty-state { background:white; border-radius:12px; padding:4rem 2rem; text-align:center; box-shadow:0 2px 6px rgba(0,0,0,.06); }
.empty-state > i { font-size:4rem; color:#cbd5e1; display:block; margin-bottom:1rem; }
.empty-state h3 { font-size:1.5rem; font-weight:700; color:#1e293b; margin-bottom:.5rem; }
.empty-state p { color:#64748b; margin-bottom:1.5rem; }

@media(max-width:768px){
    .sp-admin { padding:1rem; }
    .page-header { flex-direction:column; gap:1rem; }
    .cards-grid { grid-template-columns:1fr; }
    .header-actions,.stats-row { flex-direction:column; }
    .btn { width:100%; justify-content:center; }
}
</style>

<script>
function toggleAll(cb){
    document.querySelectorAll('.row-check').forEach(c=>c.checked=cb.checked);
    updateSel();
}
function updateSel(){
    const n=document.querySelectorAll('.row-check:checked').length;
    document.getElementById('selCount').textContent=n+' dipilih';
    const all=document.querySelectorAll('.row-check').length;
    document.getElementById('checkAll').checked=n===all&&all>0;
}
function confirmBulk(form){
    const n=document.querySelectorAll('.row-check:checked').length;
    const act=form.action.value;
    if(!n){alert('Pilih minimal 1 item!');return false;}
    if(!act){alert('Pilih aksi!');return false;}
    const lbl={activate:'aktifkan',deactivate:'nonaktifkan',delete:'hapus'};
    return confirm(`${lbl[act]} ${n} item terpilih?`);
}
setTimeout(()=>{
    document.querySelectorAll('.alert-success-bar').forEach(el=>{
        el.style.transition='opacity .4s';el.style.opacity='0';
        setTimeout(()=>el.remove(),400);
    });
},4000);
</script>
@endsection