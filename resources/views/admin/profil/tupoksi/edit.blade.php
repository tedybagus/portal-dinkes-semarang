@extends('layouts.app')

@section('title', isset($tupoksi) ? 'Edit Tupoksi' : 'Tambah Tupoksi')

@section('content')
<div class="page-header">
    <h1>{{ isset($tupoksi) ? 'Edit Tupoksi' : 'Tambah Tupoksi' }}</h1>
    <a href="{{ route('admin.tupoksi.index') }}" class="btn-secondary" >
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="form-card">
    <form action="{{ isset($tupoksi) ? route('admin.tupoksi.update', $tupoksi->id) : route('admin.tupoksi.store') }}" method="POST">
        @csrf
        @if(isset($tupoksi))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="title" class="form-label required">Bidang/Bagian</label>
            <input 
                type="text" 
                name="title" 
                id="title" 
                class="form-control @error('title') is-invalid @enderror" 
                placeholder="Contoh: Bidang Pencegahan dan Pengendalian Penyakit"
                value="{{ old('title', $tupoksi->title ?? '') }}"
                required
            >
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="tugas_pokok" class="form-label required">Tugas Pokok</label>
            <textarea 
                name="tugas_pokok" 
                id="tugas_pokok" 
                class="form-control editor @error('tugas_pokok') is-invalid @enderror"
                rows="8"
                required
            >{{ old('tugas_pokok', $tupoksi->tugas_pokok ?? '') }}</textarea>
            @error('tugas_pokok')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text">Gunakan bullet list untuk detail tugas</small>
        </div>

        <div class="form-group">
            <label for="fungsi" class="form-label required">Fungsi</label>
            <textarea 
                name="fungsi" 
                id="fungsi" 
                class="form-control editor @error('fungsi') is-invalid @enderror"
                rows="8"
                required
            >{{ old('fungsi', $tupoksi->fungsi ?? '') }}</textarea>
            @error('fungsi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text">Gunakan bullet list untuk detail fungsi</small>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="order" class="form-label">Urutan Tampilan</label>
                    <input 
                        type="number" 
                        name="order" 
                        id="order" 
                        class="form-control @error('order') is-invalid @enderror" 
                        value="{{ old('order', $tupoksi->order ?? 0) }}"
                        min="0"
                    >
                    @error('order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text">Urutan 1 = paling atas</small>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <div class="form-check">
                        <input 
                            type="checkbox" 
                            name="is_active" 
                            id="is_active" 
                            class="form-check-input" 
                            value="1"
                            {{ old('is_active', $tupoksi->is_active ?? true) ? 'checked' : '' }}
                        >
                        <label for="is_active" class="form-check-label">
                            Aktif (tampilkan di halaman publik)
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> {{ isset($tupoksi) ? 'Update' : 'Simpan' }}
            </button>
            <a href="{{ route('admin.tupoksi.index') }}" class="btn-secondary">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>

<style>
.row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

@media (max-width: 768px) {
    .row {
        grid-template-columns: 1fr;
    }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const editorInstances = {};
    const editorPromises = [];
    
    // Inisialisasi CKEditor untuk setiap textarea
    document.querySelectorAll('textarea.editor').forEach(function(element) {
        const promise = ClassicEditor
            .create(element, {
                toolbar: {
                    items: [
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        '|',
                        'numberedList',
                        'bulletedList',
                        '|',
                        'outdent',
                        'indent',
                        '|',
                        'link',
                        'blockQuote',
                        'insertTable',
                        '|',
                        'undo',
                        'redo'
                    ],
                    shouldNotGroupWhenFull: true
                },
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' }
                    ]
                },
                table: {
                    contentToolbar: [
                        'tableColumn',
                        'tableRow',
                        'mergeTableCells'
                    ]
                },
                language: 'id'
            })
            .then(editor => {
                console.log('CKEditor loaded for:', element.id);
                
                // Simpan instance
                editorInstances[element.id] = editor;
                
                // Set min height
                editor.editing.view.change(writer => {
                    writer.setStyle('min-height', '400px', editor.editing.view.document.getRoot());
                });
                
                // PENTING: Update textarea secara realtime setiap ada perubahan
                editor.model.document.on('change:data', () => {
                    element.value = editor.getData();
                    console.log(element.id + ' updated:', element.value.substring(0, 50) + '...');
                });
                
                return editor;
            })
            .catch(error => {
                console.error('CKEditor error:', error);
            });
            
        editorPromises.push(promise);
    });
    
    // Tunggu semua editor siap
    Promise.all(editorPromises).then(() => {
        console.log('All editors ready');
        
        // Handler untuk form submit
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            console.log('=== FORM SUBMITTING ===');
            
            // Force update semua editor ke textarea
            Object.keys(editorInstances).forEach(function(id) {
                const editor = editorInstances[id];
                const textarea = document.getElementById(id);
                const data = editor.getData();
                
                textarea.value = data;
                console.log(id + ' final value length:', data.length);
            });
            
            // Debug: cek nilai sebelum submit
            const tugasPokok = document.getElementById('tugas_pokok').value;
            const fungsi = document.getElementById('fungsi').value;
            
            console.log('Tugas Pokok length:', tugasPokok.length);
            console.log('Fungsi length:', fungsi.length);
            
            // Validasi di frontend juga
            if (!tugasPokok || tugasPokok.trim() === '' || tugasPokok === '<p>&nbsp;</p>') {
                e.preventDefault();
                alert('Tugas Pokok wajib diisi!');
                console.log('VALIDATION FAILED: Tugas Pokok kosong');
                return false;
            }
            
            if (!fungsi || fungsi.trim() === '' || fungsi === '<p>&nbsp;</p>') {
                e.preventDefault();
                alert('Fungsi wajib diisi!');
                console.log('VALIDATION FAILED: Fungsi kosong');
                return false;
            }
            
            console.log('=== VALIDATION PASSED ===');
        });
    });
});
</script>    
@endpush
@endsection