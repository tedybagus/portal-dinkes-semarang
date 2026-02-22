{{--
    SHARED FORM untuk CREATE & EDIT FAQ
    Usage create: @include('admin.faqs._form')
    Usage edit:   @include('admin.faqs._form', ['faq' => $faq])
--}}

@extends('layouts.app')
@section('title', isset($faq) ? 'Edit FAQ' : 'Tambah FAQ')

@section('content')
<div class="faq-form-page">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('admin.faqs.index') }}"><i class="fas fa-question-circle"></i> FAQ</a>
        <i class="fas fa-chevron-right"></i>
        <span>{{ isset($faq) ? 'Edit' : 'Tambah' }} FAQ</span>
    </div>

    <div class="form-layout">
        {{-- Main Form --}}
        <div class="form-main">
            <div class="form-card">
                <div class="form-card-header">
                    <h2>
                        <i class="fas fa-{{ isset($faq) ? 'edit' : 'plus-circle' }}"></i>
                        {{ isset($faq) ? 'Edit FAQ' : 'Tambah FAQ Baru' }}
                    </h2>
                </div>
                <div class="form-card-body">
                    <form action="{{ isset($faq) ? route('admin.faqs.update', $faq) : route('admin.faqs.store') }}"
                          method="POST" id="faqForm">
                        @csrf
                        @if(isset($faq)) @method('PUT') @endif

                        {{-- Pertanyaan --}}
                        <div class="form-group">
                            <label class="form-label">
                                Pertanyaan <span class="required">*</span>
                            </label>
                            <input type="text"
                                   name="pertanyaan"
                                   class="form-input @error('pertanyaan') is-error @enderror"
                                   placeholder="Contoh: Bagaimana cara mendaftar layanan?"
                                   value="{{ old('pertanyaan', $faq->pertanyaan ?? '') }}">
                            @error('pertanyaan')
                            <span class="error-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                            @enderror
                            <small class="form-hint">Tulis pertanyaan dengan jelas dan singkat</small>
                        </div>

                        {{-- Jawaban --}}
                        <div class="form-group">
                            <label class="form-label">
                                Jawaban <span class="required">*</span>
                            </label>
                            <textarea name="jawaban"
                                      id="jawaban"
                                      class="form-textarea @error('jawaban') is-error @enderror"
                                      rows="8"
                                      placeholder="Tulis jawaban yang lengkap dan mudah dipahami...">{{ old('jawaban', $faq->jawaban ?? '') }}</textarea>
                            @error('jawaban')
                            <span class="error-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                            @enderror
                            <div class="char-count">
                                <span id="charCount">0</span> karakter
                            </div>
                        </div>

                        {{-- Kategori --}}
                        <div class="form-group">
                            <label class="form-label">Kategori <span class="required">*</span></label>
                            <div class="kategori-input-wrap">
                                <select name="kategori"
                                        id="kategoriSelect"
                                        class="form-select @error('kategori') is-error @enderror"
                                        onchange="handleKategoriChange(this)">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($kategoris as $kat)
                                    <option value="{{ $kat }}" {{ old('kategori', $faq->kategori ?? '') == $kat ? 'selected' : '' }}>
                                        {{ $kat }}
                                    </option>
                                    @endforeach
                                    <option value="__new__" {{ !in_array(old('kategori', $faq->kategori ?? ''), $kategoris->toArray()) ? 'selected' : '' }}>
                                        + Tambah Kategori Baru
                                    </option>
                                </select>
                                <div id="newKategoriWrap" class="new-kategori-wrap" style="display:none">
                                    <input type="text"
                                           name="kategori_baru"
                                           class="form-input"
                                           placeholder="Nama kategori baru..."
                                           value="{{ old('kategori_baru') }}">
                                    <button type="button" onclick="cancelNewKategori()" class="btn-cancel-kat">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            @error('kategori')
                            <span class="error-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-row">
                            {{-- Urutan --}}
                            <div class="form-group">
                                <label class="form-label">Urutan Tampil</label>
                                <input type="number"
                                       name="urutan"
                                       class="form-input"
                                       min="0"
                                       placeholder="0"
                                       value="{{ old('urutan', $faq->urutan ?? 0) }}">
                                <small class="form-hint">Angka kecil tampil lebih dulu. 0 = otomatis</small>
                            </div>

                            {{-- Status --}}
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <div class="status-toggle-wrap">
                                    <label class="status-toggle">
                                        <input type="hidden"   name="is_active" value="0">
                                        <input type="checkbox" name="is_active" value="1" id="isActiveToggle"
                                               {{ old('is_active', $faq->is_active ?? true) ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                    <span id="toggleLabel" class="toggle-label">
                                        {{ old('is_active', $faq->is_active ?? true) ? 'Aktif (tampil di publik)' : 'Nonaktif (disembunyikan)' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="form-actions">
                            <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                {{ isset($faq) ? 'Simpan Perubahan' : 'Tambah FAQ' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="form-sidebar">
            {{-- Tips --}}
            <div class="sidebar-card">
                <h3><i class="fas fa-lightbulb"></i> Tips Menulis FAQ</h3>
                <ul class="tips-list">
                    <li><i class="fas fa-check"></i> Gunakan bahasa yang mudah dipahami</li>
                    <li><i class="fas fa-check"></i> Jawaban yang singkat tapi lengkap</li>
                    <li><i class="fas fa-check"></i> Satu pertanyaan per FAQ</li>
                    <li><i class="fas fa-check"></i> Kelompokkan dalam kategori yang tepat</li>
                    <li><i class="fas fa-check"></i> Perbarui jawaban secara berkala</li>
                </ul>
            </div>

            @if(isset($faq))
            {{-- Info FAQ --}}
            <div class="sidebar-card info-card">
                <h3><i class="fas fa-info-circle"></i> Info FAQ</h3>
                <div class="info-item">
                    <span>Dibuat</span>
                    <strong>{{ $faq->created_at->format('d M Y') }}</strong>
                </div>
                <div class="info-item">
                    <span>Diperbarui</span>
                    <strong>{{ $faq->updated_at->format('d M Y') }}</strong>
                </div>
                <div class="info-item">
                    <span>Dilihat</span>
                    <strong>{{ number_format($faq->view_count) }}×</strong>
                </div>
                <div class="info-item">
                    <span>Status</span>
                    <strong class="{{ $faq->is_active ? 'text-green' : 'text-red' }}">
                        {{ $faq->is_active ? 'Aktif' : 'Nonaktif' }}
                    </strong>
                </div>
            </div>

            {{-- Danger Zone --}}
            <div class="sidebar-card danger-card">
                <h3><i class="fas fa-exclamation-triangle"></i> Hapus FAQ</h3>
                <p>Setelah dihapus, FAQ tidak dapat dipulihkan.</p>
                <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Yakin ingin menghapus FAQ ini?')">
                        <i class="fas fa-trash"></i> Hapus FAQ Ini
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.faq-form-page { padding:2rem; max-width:1200px; }

.breadcrumb { display:flex; align-items:center; gap:.5rem; color:#64748b; font-size:.9375rem; margin-bottom:1.5rem; }
.breadcrumb a { color:#3b82f6; text-decoration:none; display:flex; align-items:center; gap:.5rem; }
.breadcrumb a:hover { text-decoration:underline; }
.breadcrumb i.fa-chevron-right { font-size:.75rem; }

.form-layout { display:grid; grid-template-columns:1fr 300px; gap:2rem; }

.form-card { background:white; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,.08); overflow:hidden; }
.form-card-header { padding:1.25rem 1.5rem; border-bottom:2px solid #f1f5f9; background:#fafafa; }
.form-card-header h2 { font-size:1.25rem; font-weight:700; color:#1e293b; display:flex; align-items:center; gap:.75rem; margin:0; }
.form-card-header h2 i { color:#3b82f6; }
.form-card-body { padding:1.5rem; }

.form-group { margin-bottom:1.5rem; }
.form-row { display:grid; grid-template-columns:1fr 1fr; gap:1.5rem; }
.form-label { display:block; font-weight:600; color:#374151; font-size:.9375rem; margin-bottom:.5rem; }
.required { color:#ef4444; }
.form-input, .form-textarea, .form-select {
    width:100%; padding:.75rem 1rem; border:2px solid #e2e8f0; border-radius:8px;
    font-size:.9375rem; transition:border-color .2s; background:white; color:#1e293b;
}
.form-input:focus, .form-textarea:focus, .form-select:focus {
    outline:none; border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.08);
}
.form-textarea { resize:vertical; min-height:180px; line-height:1.7; font-family:inherit; }
.is-error { border-color:#ef4444 !important; }
.error-msg { display:flex; align-items:center; gap:.375rem; color:#dc2626; font-size:.8125rem; margin-top:.375rem; }
.form-hint { color:#94a3b8; font-size:.8125rem; margin-top:.375rem; display:block; }
.char-count { text-align:right; font-size:.8125rem; color:#94a3b8; margin-top:.375rem; }

.kategori-input-wrap { display:flex; flex-direction:column; gap:.75rem; }
.new-kategori-wrap { display:flex; gap:.5rem; align-items:center; }
.new-kategori-wrap .form-input { flex:1; }
.btn-cancel-kat { background:#fee2e2; color:#dc2626; border:none; padding:.625rem .875rem; border-radius:6px; cursor:pointer; }

/* Toggle */
.status-toggle-wrap { display:flex; align-items:center; gap:1rem; margin-top:.5rem; }
.status-toggle { position:relative; display:inline-block; width:52px; height:28px; }
.status-toggle input { opacity:0; width:0; height:0; }
.slider { position:absolute; inset:0; background:#e2e8f0; border-radius:28px; cursor:pointer; transition:.3s; }
.slider:before { content:''; position:absolute; height:20px; width:20px; left:4px; bottom:4px; background:white; border-radius:50%; transition:.3s; }
input:checked ~ .slider { background:#10b981; }
input:checked ~ .slider:before { transform:translateX(24px); }
.toggle-label { font-weight:600; font-size:.9375rem; }

/* Form Actions */
.form-actions { display:flex; gap:.75rem; justify-content:flex-end; padding-top:1.5rem; border-top:2px solid #f1f5f9; }

/* Buttons */
.btn { display:inline-flex; align-items:center; gap:.5rem; padding:.75rem 1.5rem; border-radius:8px; font-weight:600; font-size:.9375rem; border:none; cursor:pointer; text-decoration:none; transition:all .2s; }
.btn-primary { background:linear-gradient(135deg,#3b82f6,#2563eb); color:white; }
.btn-primary:hover { transform:translateY(-2px); box-shadow:0 4px 12px rgba(59,130,246,.4); }
.btn-secondary { background:#f1f5f9; color:#475569; }
.btn-secondary:hover { background:#e2e8f0; }
.btn-danger { background:#ef4444; color:white; width:100%; justify-content:center; }
.btn-danger:hover { background:#dc2626; }

/* Sidebar */
.sidebar-card { background:white; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,.08); padding:1.25rem; margin-bottom:1.25rem; }
.sidebar-card h3 { font-size:1rem; font-weight:700; color:#1e293b; display:flex; align-items:center; gap:.5rem; margin-bottom:1rem; }
.sidebar-card h3 i { color:#3b82f6; }
.tips-list { list-style:none; padding:0; display:flex; flex-direction:column; gap:.625rem; }
.tips-list li { display:flex; align-items:start; gap:.5rem; font-size:.9rem; color:#475569; }
.tips-list li i { color:#10b981; margin-top:.1rem; flex-shrink:0; }
.info-card h3 i { color:#f59e0b; }
.info-item { display:flex; justify-content:space-between; padding:.5rem 0; border-bottom:1px solid #f1f5f9; font-size:.875rem; }
.info-item:last-child { border:none; }
.info-item span { color:#64748b; }
.text-green { color:#10b981; }
.text-red { color:#ef4444; }
.danger-card h3 i { color:#ef4444; }
.danger-card h3 { color:#ef4444; }
.danger-card p { color:#64748b; font-size:.875rem; margin-bottom:1rem; }

@media (max-width:1024px) { .form-layout { grid-template-columns:1fr; } }
@media (max-width:768px) {
    .faq-form-page { padding:1rem; }
    .form-row { grid-template-columns:1fr; }
    .form-actions { flex-direction:column; }
    .btn { width:100%; justify-content:center; }
}
</style>

<script>
// Character counter
const jawaban = document.getElementById('jawaban');
const counter = document.getElementById('charCount');
function updateCount() { counter.textContent = jawaban.value.length; }
jawaban.addEventListener('input', updateCount);
updateCount();

// Toggle label
const toggle = document.getElementById('isActiveToggle');
const toggleLabel = document.getElementById('toggleLabel');
toggle.addEventListener('change', () => {
    toggleLabel.textContent = toggle.checked
        ? 'Aktif (tampil di publik)'
        : 'Nonaktif (disembunyikan)';
});

// New kategori
function handleKategoriChange(sel) {
    const wrap = document.getElementById('newKategoriWrap');
    if (sel.value === '__new__') {
        wrap.style.display = 'flex';
        wrap.querySelector('input').focus();
    } else {
        wrap.style.display = 'none';
    }
}
function cancelNewKategori() {
    document.getElementById('newKategoriWrap').style.display = 'none';
    document.getElementById('kategoriSelect').value = '';
}
// Init on load if edit has new kategori
(function () {
    const sel = document.getElementById('kategoriSelect');
    if (sel && sel.value === '__new__') {
        document.getElementById('newKategoriWrap').style.display = 'flex';
    }
})();
</script>
@endsection