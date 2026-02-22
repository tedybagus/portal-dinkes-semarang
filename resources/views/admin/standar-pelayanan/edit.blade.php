@extends('layouts.app')
@section('title', isset($standarPelayanan) ? 'Edit Standar Pelayanan' : 'Tambah Standar Pelayanan')

@section('content')
<div class="sp-form-page">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('admin.standar-pelayanan.index') }}">
            <i class="fas fa-certificate"></i> Standar Pelayanan
        </a>
        <i class="fas fa-chevron-right"></i>
        <span>{{ isset($standarPelayanan) ? 'Edit' : 'Tambah' }}</span>
    </div>

    <div class="form-layout">

        {{-- ── MAIN FORM ── --}}
        <div class="form-main">
            <form action="{{ isset($standarPelayanan)
                    ? route('admin.standar-pelayanan.update', $standarPelayanan)
                    : route('admin.standar-pelayanan.store') }}"
                  method="POST" id="mainForm">
                @csrf
                @if(isset($standarPelayanan)) @method('PUT') @endif

                {{-- INFORMASI UMUM --}}
                <div class="form-card">
                    <div class="form-card-hd">
                        <h3><i class="fas fa-info-circle"></i> Informasi Umum</h3>
                    </div>
                    <div class="form-card-bd">
                        <div class="fg">
                            <label>Nama Layanan <span class="req">*</span></label>
                            <input type="text" name="nama" class="fi @error('nama') fi-err @enderror"
                                   placeholder="Contoh: Rekomendasi Perizinan Apotek"
                                   value="{{ old('nama', $standarPelayanan->nama ?? '') }}">
                            @error('nama')<span class="err-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>@enderror
                        </div>

                        <div class="fg-row">
                            <div class="fg">
                                <label>Kategori <span class="req">*</span></label>
                                <div style="display:flex;gap:.5rem">
                                    <select name="kategori" id="katSelect" class="fi fi-sel @error('kategori') fi-err @enderror"
                                            onchange="handleKat(this)" style="flex:1">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach(['Perizinan Fasyankes','Sanitasi & Higienitas','Pangan & IRTP','Perizinan Kesehatan Tradisional','Jaminan Kesehatan'] as $k)
                                        <option value="{{ $k }}" {{ old('kategori', $standarPelayanan->kategori ?? '') == $k ? 'selected' : '' }}>{{ $k }}</option>
                                        @endforeach
                                        @foreach($kategoris->diff(['Perizinan Fasyankes','Sanitasi & Higienitas','Pangan & IRTP','Perizinan Kesehatan Tradisional','Jaminan Kesehatan']) as $k)
                                        <option value="{{ $k }}" {{ old('kategori', $standarPelayanan->kategori ?? '') == $k ? 'selected' : '' }}>{{ $k }}</option>
                                        @endforeach
                                        <option value="__new__">+ Tambah Kategori Baru</option>
                                    </select>
                                </div>
                                <div id="newKatWrap" style="display:none;margin-top:.5rem;display:flex;gap:.5rem">
                                    <input type="text" id="newKatInput" class="fi" placeholder="Nama kategori baru..." style="flex:1">
                                    <button type="button" onclick="applyNewKat()" class="btn btn-sm btn-primary" style="white-space:nowrap">Pakai</button>
                                    <button type="button" onclick="cancelNewKat()" class="btn btn-sm">Batal</button>
                                </div>
                                @error('kategori')<span class="err-msg">{{ $message }}</span>@enderror
                            </div>
                            <div class="fg">
                                <label>Urutan Tampil</label>
                                <input type="number" name="urutan" class="fi" min="0"
                                       value="{{ old('urutan', $standarPelayanan->urutan ?? 0) }}"
                                       placeholder="0">
                                <small class="hint">Angka kecil tampil lebih dulu</small>
                            </div>
                        </div>

                        <div class="fg">
                            <label>Deskripsi Singkat</label>
                            <textarea name="deskripsi" class="ft" rows="3"
                                      placeholder="Penjelasan singkat tentang layanan ini...">{{ old('deskripsi', $standarPelayanan->deskripsi ?? '') }}</textarea>
                        </div>

                        <div class="fg-row">
                            <div class="fg">
                                <label>Icon (Font Awesome)</label>
                                <div style="display:flex;gap:.5rem;align-items:center">
                                    <input type="text" name="icon" id="iconInput" class="fi"
                                           placeholder="fa-file-alt"
                                           value="{{ old('icon', $standarPelayanan->icon ?? 'fa-file-alt') }}"
                                           oninput="previewIcon(this.value)">
                                    <div id="iconPreview" class="icon-preview">
                                        <i class="fas {{ old('icon', $standarPelayanan->icon ?? 'fa-file-alt') }}"></i>
                                    </div>
                                </div>
                                <small class="hint">Cari icon di <a href="https://fontawesome.com/icons" target="_blank">fontawesome.com</a></small>
                            </div>
                            <div class="fg">
                                <label>Warna</label>
                                <div style="display:flex;gap:.5rem;align-items:center">
                                    <input type="color" name="warna" id="warnaInput"
                                           value="{{ old('warna', $standarPelayanan->warna ?? '#f59e0b') }}"
                                           style="width:56px;height:42px;border:2px solid #e2e8f0;border-radius:8px;cursor:pointer;padding:2px">
                                    <input type="text" id="warnaText" class="fi"
                                           value="{{ old('warna', $standarPelayanan->warna ?? '#f59e0b') }}"
                                           oninput="syncColor(this.value)" placeholder="#f59e0b" style="flex:1">
                                </div>
                            </div>
                        </div>

                        <div class="fg">
                            <label>Catatan Tambahan</label>
                            <textarea name="catatan" class="ft" rows="2"
                                      placeholder="Contoh: Detail persyaratan bisa scan barcode...">{{ old('catatan', $standarPelayanan->catatan ?? '') }}</textarea>
                        </div>

                        <div class="fg">
                            <label class="status-label">
                                <div class="toggle-wrap">
                                    <label class="toggle">
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox" name="is_active" value="1" id="activeToggle"
                                               {{ old('is_active', $standarPelayanan->is_active ?? true) ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                    <span id="toggleLabel" class="tgl-lbl">
                                        {{ old('is_active', $standarPelayanan->is_active ?? true) ? 'Aktif – tampil di halaman publik' : 'Nonaktif – disembunyikan dari publik' }}
                                    </span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- PERSYARATAN --}}
                <div class="form-card">
                    <div class="form-card-hd">
                        <h3><i class="fas fa-list-ul"></i> Daftar Persyaratan</h3>
                        <p>Tambahkan satu atau beberapa bagian persyaratan (Umum, Khusus, Perpanjang, dll)</p>
                    </div>
                    <div class="form-card-bd">
                        <div id="seksiContainer">
                            @php
                                $persyaratan = old('sek_judul')
                                    ? collect(old('sek_judul'))->map(fn($j,$i)=>['judul'=>$j,'items'=>collect(explode("\n",old('sek_items')[$i]??''))->filter()->values()->implode("\n")])->all()
                                    : ($standarPelayanan->persyaratan ?? [['judul'=>'Persyaratan','items'=>[]]]);
                            @endphp

                            @foreach($persyaratan as $idx => $sek)
                            <div class="seksi-block" data-idx="{{ $idx }}">
                                <div class="seksi-hd">
                                    <span class="seksi-num">Bagian {{ $idx + 1 }}</span>
                                    <button type="button" onclick="removeSeksi(this)" class="btn-remove-sek">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="fg">
                                    <label>Judul Bagian</label>
                                    <input type="text" name="sek_judul[]" class="fi"
                                           placeholder="Contoh: Persyaratan Umum"
                                           value="{{ $sek['judul'] ?? '' }}">
                                </div>
                                <div class="fg">
                                    <label>Item Persyaratan <small>(satu per baris)</small></label>
                                    <textarea name="sek_items[]" class="ft ft-req" rows="6"
                                              placeholder="Tulis satu persyaratan per baris...">{{ is_array($sek['items'] ?? '') ? implode("\n", $sek['items']) : ($sek['items'] ?? '') }}</textarea>
                                    <small class="hint">Tekan Enter untuk baris berikutnya</small>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <button type="button" onclick="addSeksi()" class="btn-add-sek">
                            <i class="fas fa-plus"></i> Tambah Bagian Persyaratan
                        </button>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="form-actions">
                    <a href="{{ route('admin.standar-pelayanan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        {{ isset($standarPelayanan) ? 'Simpan Perubahan' : 'Tambah Layanan' }}
                    </button>
                </div>
            </form>
        </div>

        {{-- ── SIDEBAR ── --}}
        <div class="form-sidebar">
            {{-- Preview Card --}}
            <div class="sidebar-card">
                <h4><i class="fas fa-eye"></i> Preview Card</h4>
                <div class="preview-card" id="previewCard">
                    <div class="prev-bar" id="prevBar" style="background:{{ old('warna',$standarPelayanan->warna??'#f59e0b') }}"></div>
                    <div style="padding:1rem">
                        <div class="prev-icon" id="prevIcon"
                             style="background:{{ old('warna',$standarPelayanan->warna??'#f59e0b') }}20;color:{{ old('warna',$standarPelayanan->warna??'#f59e0b') }}">
                            <i class="fas {{ old('icon',$standarPelayanan->icon??'fa-file-alt') }}" id="prevIconI"></i>
                        </div>
                        <div class="prev-name" id="prevName">{{ old('nama',$standarPelayanan->nama??'Nama Layanan') }}</div>
                        <div class="prev-kat" id="prevKat">{{ old('kategori',$standarPelayanan->kategori??'Kategori') }}</div>
                    </div>
                </div>
            </div>

            {{-- Kategori Referensi --}}
            <div class="sidebar-card">
                <h4><i class="fas fa-tags"></i> Kategori yang Ada</h4>
                <div class="kat-list">
                    @foreach(['Perizinan Fasyankes','Sanitasi & Higienitas','Pangan & IRTP','Perizinan Kesehatan Tradisional','Jaminan Kesehatan'] as $k)
                    <span class="kat-pill">{{ $k }}</span>
                    @endforeach
                </div>
            </div>

            @if(isset($standarPelayanan))
            {{-- Info --}}
            <div class="sidebar-card">
                <h4><i class="fas fa-info-circle"></i> Info</h4>
                <div class="info-rows">
                    <div><span>Dibuat</span><strong>{{ $standarPelayanan->created_at->format('d M Y') }}</strong></div>
                    <div><span>Update</span><strong>{{ $standarPelayanan->updated_at->format('d M Y') }}</strong></div>
                    <div><span>Dilihat</span><strong>{{ number_format($standarPelayanan->view_count) }}×</strong></div>
                    <div><span>Slug</span><strong style="font-size:.8rem">{{ $standarPelayanan->slug }}</strong></div>
                </div>
            </div>
            {{-- Danger --}}
            <div class="sidebar-card danger-card">
                <h4><i class="fas fa-exclamation-triangle"></i> Hapus Layanan</h4>
                <p>Data akan dihapus permanen.</p>
                <form action="{{ route('admin.standar-pelayanan.destroy', $standarPelayanan) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus layanan ini?')">
                        <i class="fas fa-trash"></i> Hapus Permanen
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.sp-form-page { padding:2rem; max-width:1200px; }
.breadcrumb { display:flex; align-items:center; gap:.5rem; color:#64748b; font-size:.9375rem; margin-bottom:1.5rem; }
.breadcrumb a { color:#3b82f6; text-decoration:none; display:flex; align-items:center; gap:.5rem; }
.form-layout { display:grid; grid-template-columns:1fr 280px; gap:2rem; }
.form-card { background:white; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,.07); overflow:hidden; margin-bottom:1.5rem; }
.form-card-hd { padding:1.125rem 1.5rem; border-bottom:2px solid #f1f5f9; background:#fafafa; }
.form-card-hd h3 { font-size:1.125rem; font-weight:700; color:#1e293b; display:flex; align-items:center; gap:.625rem; margin:0 0 .25rem; }
.form-card-hd h3 i { color:#3b82f6; }
.form-card-hd p { color:#64748b; font-size:.875rem; margin:0; }
.form-card-bd { padding:1.5rem; }
.fg { margin-bottom:1.25rem; }
.fg-row { display:grid; grid-template-columns:1fr 1fr; gap:1.25rem; margin-bottom:1.25rem; }
.fg:last-child, .fg-row:last-child { margin-bottom:0; }
.fg label, .fg-row .fg label { display:block; font-weight:600; color:#374151; font-size:.9rem; margin-bottom:.4rem; }
.req { color:#ef4444; }
.fi { width:100%; padding:.6875rem .9375rem; border:2px solid #e2e8f0; border-radius:8px; font-size:.9375rem; transition:border-color .2s; background:white; }
.fi:focus { outline:none; border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.08); }
.fi-err { border-color:#ef4444 !important; }
.fi-sel { cursor:pointer; }
.ft { width:100%; padding:.6875rem .9375rem; border:2px solid #e2e8f0; border-radius:8px; font-size:.9375rem; resize:vertical; line-height:1.7; font-family:inherit; }
.ft:focus { outline:none; border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.08); }
.ft-req { min-height:140px; }
.hint { color:#94a3b8; font-size:.8125rem; margin-top:.3rem; display:block; }
.hint a { color:#3b82f6; }
.err-msg { display:flex; align-items:center; gap:.375rem; color:#dc2626; font-size:.8125rem; margin-top:.3rem; }
.icon-preview { width:44px; height:44px; border-radius:8px; background:#eff6ff; color:#3b82f6; display:flex; align-items:center; justify-content:center; font-size:1.25rem; flex-shrink:0; border:2px solid #e2e8f0; }

/* Status Toggle */
.toggle-wrap { display:flex; align-items:center; gap:1rem; margin-top:.5rem; }
.toggle { position:relative; width:50px; height:26px; }
.toggle input { opacity:0; width:0; height:0; }
.slider { position:absolute; inset:0; background:#e2e8f0; border-radius:26px; cursor:pointer; transition:.3s; }
.slider:before { content:''; position:absolute; height:18px; width:18px; left:4px; bottom:4px; background:white; border-radius:50%; transition:.3s; }
input:checked ~ .slider { background:#10b981; }
input:checked ~ .slider:before { transform:translateX(24px); }
.tgl-lbl { font-weight:600; color:#374151; font-size:.9375rem; }

/* Seksi blocks */
.seksi-block { background:#f8fafc; border-radius:10px; border:2px solid #e2e8f0; padding:1.25rem; margin-bottom:1.25rem; }
.seksi-hd { display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem; }
.seksi-num { font-weight:700; color:#475569; font-size:.9375rem; }
.btn-remove-sek { background:#fee2e2; color:#dc2626; border:none; width:32px; height:32px; border-radius:6px; cursor:pointer; font-size:.875rem; display:flex; align-items:center; justify-content:center; }
.btn-remove-sek:hover { background:#fecaca; }
.btn-add-sek { width:100%; padding:.875rem; border:2px dashed #cbd5e1; border-radius:10px; background:none; color:#64748b; font-weight:600; font-size:.9375rem; cursor:pointer; transition:all .2s; display:flex; align-items:center; justify-content:center; gap:.5rem; }
.btn-add-sek:hover { border-color:#3b82f6; color:#3b82f6; background:#eff6ff; }

/* Form Actions */
.form-actions { display:flex; gap:.75rem; justify-content:flex-end; }
.btn { display:inline-flex; align-items:center; gap:.5rem; padding:.6875rem 1.25rem; border-radius:8px; font-weight:600; font-size:.9375rem; border:none; cursor:pointer; text-decoration:none; transition:all .2s; }
.btn-primary { background:linear-gradient(135deg,#3b82f6,#2563eb); color:white; }
.btn-primary:hover { transform:translateY(-2px); box-shadow:0 4px 12px rgba(59,130,246,.35); }
.btn-secondary { background:#f1f5f9; color:#475569; }
.btn-secondary:hover { background:#e2e8f0; }
.btn-danger { background:#ef4444; color:white; width:100%; justify-content:center; }
.btn-danger:hover { background:#dc2626; }
.btn-sm { padding:.5rem .875rem; font-size:.875rem; }

/* Sidebar */
.sidebar-card { background:white; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,.07); padding:1.25rem; margin-bottom:1.25rem; }
.sidebar-card h4 { font-size:1rem; font-weight:700; color:#1e293b; display:flex; align-items:center; gap:.5rem; margin:0 0 1rem; }
.sidebar-card h4 i { color:#3b82f6; }
.preview-card { background:#f8fafc; border-radius:10px; overflow:hidden; border:2px solid #e2e8f0; }
.prev-bar { height:5px; transition:background .3s; }
.prev-icon { width:44px; height:44px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1.375rem; margin-bottom:.75rem; transition:all .3s; }
.prev-name { font-weight:700; color:#1e293b; font-size:.9375rem; line-height:1.4; margin-bottom:.375rem; }
.prev-kat { font-size:.8125rem; color:#3b82f6; font-weight:600; }
.kat-list { display:flex; flex-direction:column; gap:.375rem; }
.kat-pill { padding:.3rem .75rem; background:#eff6ff; color:#2563eb; border-radius:20px; font-size:.8125rem; font-weight:600; }
.info-rows { display:flex; flex-direction:column; gap:.5rem; }
.info-rows > div { display:flex; justify-content:space-between; font-size:.875rem; padding:.4rem 0; border-bottom:1px solid #f1f5f9; }
.info-rows > div:last-child { border:none; }
.info-rows span { color:#64748b; }
.danger-card h4 { color:#ef4444; }
.danger-card h4 i { color:#ef4444; }
.danger-card p { color:#64748b; font-size:.875rem; margin-bottom:1rem; }

@media(max-width:1024px){ .form-layout { grid-template-columns:1fr; } }
@media(max-width:768px){ .sp-form-page { padding:1rem; } .fg-row { grid-template-columns:1fr; } .form-actions { flex-direction:column; } .btn { width:100%; justify-content:center; } }
</style>

<script>
// Color sync
document.getElementById('warnaInput').addEventListener('input', function(){
    document.getElementById('warnaText').value = this.value;
    updatePreview();
});
function syncColor(val){
    document.getElementById('warnaInput').value = val;
    updatePreview();
}
function previewIcon(cls){
    document.getElementById('prevIconI').className = 'fas ' + cls;
    document.getElementById('iconPreview').innerHTML = '<i class="fas ' + cls + '"></i>';
    updatePreview();
}
function updatePreview(){
    const color = document.getElementById('warnaInput').value;
    document.getElementById('prevBar').style.background = color;
    document.getElementById('prevIcon').style.background = color + '20';
    document.getElementById('prevIcon').style.color = color;
    document.getElementById('prevName').textContent = document.querySelector('[name=nama]').value || 'Nama Layanan';
    document.getElementById('prevKat').textContent = document.getElementById('katSelect').value || 'Kategori';
}
document.querySelector('[name=nama]').addEventListener('input', updatePreview);
document.getElementById('katSelect').addEventListener('change', updatePreview);

// Status toggle label
document.getElementById('activeToggle').addEventListener('change', function(){
    document.getElementById('toggleLabel').textContent = this.checked
        ? 'Aktif – tampil di halaman publik'
        : 'Nonaktif – disembunyikan dari publik';
});

// Kategori baru
function handleKat(sel){
    const wrap = document.getElementById('newKatWrap');
    wrap.style.display = sel.value === '__new__' ? 'flex' : 'none';
    if(sel.value !== '__new__') updatePreview();
}
function applyNewKat(){
    const val = document.getElementById('newKatInput').value.trim();
    if(!val) return;
    const sel = document.getElementById('katSelect');
    const opt = new Option(val, val, true, true);
    sel.insertBefore(opt, sel.lastElementChild);
    document.getElementById('newKatWrap').style.display = 'none';
    updatePreview();
}
function cancelNewKat(){
    document.getElementById('katSelect').value = '';
    document.getElementById('newKatWrap').style.display = 'none';
}

// Add/Remove Seksi
let seksiCount = {{ count($persyaratan ?? []) }};
function addSeksi(){
    seksiCount++;
    const tpl = `
    <div class="seksi-block">
        <div class="seksi-hd">
            <span class="seksi-num">Bagian ${seksiCount}</span>
            <button type="button" onclick="removeSeksi(this)" class="btn-remove-sek"><i class="fas fa-times"></i></button>
        </div>
        <div class="fg">
            <label>Judul Bagian</label>
            <input type="text" name="sek_judul[]" class="fi" placeholder="Contoh: Persyaratan Khusus">
        </div>
        <div class="fg">
            <label>Item Persyaratan <small>(satu per baris)</small></label>
            <textarea name="sek_items[]" class="ft ft-req" rows="6" placeholder="Tulis satu persyaratan per baris..."></textarea>
            <small class="hint">Tekan Enter untuk baris berikutnya</small>
        </div>
    </div>`;
    document.getElementById('seksiContainer').insertAdjacentHTML('beforeend', tpl);
}
function removeSeksi(btn){
    const blocks = document.querySelectorAll('.seksi-block');
    if(blocks.length <= 1){ alert('Minimal 1 bagian persyaratan!'); return; }
    btn.closest('.seksi-block').remove();
}

// Init preview
updatePreview();
</script>
@endsection