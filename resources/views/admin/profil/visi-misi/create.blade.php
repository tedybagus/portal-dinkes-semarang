@extends('layouts.app')

@section('title', isset($visiMisi) ? 'Edit Visi Misi' : 'Tambah Visi Misi')
@push('styles')
<style>
.page-header{
     background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    margin-bottom: 1.5rem;
}
.page-header h1{
font-size: 1.875rem;
    font-weight: 700;
    color: #111827;
    margin: 0;
}
.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.9375rem;
}

.form-label.required::after {
    content: '*';
    color: #ef4444;
    margin-left: 0.25rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.9375rem;
    transition: all 0.3s;
    font-family: inherit;
}

.form-control:focus {
    outline: none;
    border-color: #1e40af;
    box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
}

.form-control.is-invalid {
    border-color: #ef4444;
}

.invalid-feedback {
    color: #ef4444;
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

.form-text {
    color: #6b7280;
    font-size: 0.875rem;
    margin-top: 0.5rem;
    display: block;
}

.form-check {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.form-check-input {
    width: 20px;
    height: 20px;
    cursor: pointer;
}

.form-check-label {
    cursor: pointer;
    color: #374151;
}

.form-actions {
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 2px solid #e5e7eb;
    display: flex;
    gap: 1rem;
}

textarea.form-control {
    resize: vertical;
    min-height: 100px;
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
.filament-button-danger {
        background: linear-gradient(135deg, #ff0000 0%, #ff0800 100%);
        color: white;
    }

.card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.card-body {
    padding: 1.5rem;
}
/* Custom CKEditor Styling */
.ck-editor__editable {
    min-height: 400px;
    max-height: 600px;
    overflow-y: auto;
}

.ck.ck-editor__main > .ck-editor__editable {
    background: #ffffff;
    border: 1px solid #d1d5db;
    border-radius: 0 0 8px 8px;
}

.ck.ck-toolbar {
    background: #f9fafb;
    border: 1px solid #d1d5db;
    border-radius: 8px 8px 0 0;
    border-bottom: none;
}

.ck.ck-editor__editable:focus {
    border-color: #1e40af;
    box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
}

/* Content styling inside editor */
.ck-content {
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    line-height: 1.6;
}

.ck-content h1 {
    font-size: 2em;
    font-weight: bold;
    margin: 1em 0 0.5em;
}

.ck-content h2 {
    font-size: 1.5em;
    font-weight: bold;
    margin: 1em 0 0.5em;
}

.ck-content h3 {
    font-size: 1.25em;
    font-weight: bold;
    margin: 1em 0 0.5em;
}

.ck-content ul,
.ck-content ol {
    margin-left: 2em;
    padding-left: 0;
}

.ck-content table {
    border-collapse: collapse;
    width: 100%;
    margin: 1em 0;
}

.ck-content table td,
.ck-content table th {
    border: 1px solid #ddd;
    padding: 8px;
}

.ck-content blockquote {
    border-left: 4px solid #1e40af;
    padding-left: 1em;
    margin-left: 0;
    font-style: italic;
    color: #6b7280;
}

</style>
@endpush
@section('content')
<div class="page-header">
    <div class="page-header-content">
        <h1>
            <i class="fas fa-bullseye"></i>
            {{ isset($visiMisi) ? 'Edit Visi Misi' : 'Tambah Visi Misi' }}
        </h1>
        <p>Formulir visi, misi, dan motto organisasi</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.visi-misi.index') }}" class="filament-button filament-button-primary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ isset($visiMisi) ? route('admin.visi-misi.update', $visiMisi->id) : route('admin.visi-misi.store') }}" method="POST">
            @csrf
            @if(isset($visiMisi))
                @method('PUT')
            @endif
            <div class="form-group">
                <label for="visi" class="form-label required">Visi</label>
                <input
                    name="visi" 
                    id="visi" 
                    rows="5" 
                    type="text"
                    class="form-control editor @error('visi') is-invalid @enderror" 
                    placeholder="Masukkan visi organisasi..."
                    required
                >{{ old('visi', $visiMisi->visi ?? '') }}
                @error('visi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text">Contoh: Mewujudkan Masyarakat Semarang yang Sehat, Mandiri, dan Berkualitas</small>
            </div>

            <div class="form-group">
                <label for="misi" class="form-label required">Misi</label>
                <textarea 
                    name="misi" 
                    id="misi" 
                    rows="8" 
                    class="form-control  @error('misi') is-invalid @enderror" 
                    placeholder="Masukkan misi organisasi..."
                    required
                >{{ old('misi', $visiMisi->misi ?? '') }}</textarea>
                @error('misi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text">Gunakan format list untuk misi. Contoh:<br>1. Meningkatkan kualitas pelayanan kesehatan<br>2. Memperluas akses pelayanan kesehatan</small>
            </div>

            <div class="form-group">
                <label for="motto" class="form-label">Motto</label>
                <input 
                    type="text" 
                    name="motto" 
                    id="motto" 
                    class="form-control @error('motto') is-invalid @enderror" 
                    placeholder="Masukkan motto organisasi..."
                    value="{{ old('motto', $visiMisi->motto ?? '') }}"
                    maxlength="255"
                >
                @error('motto')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text">Opsional. Contoh: Sehat, Mandiri, Berkualitas</small>
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Deskripsi Tambahan</label>
                <textarea 
                    name="description" 
                    id="description" 
                    rows="4" 
                    class="form-control @error('description') is-invalid @enderror" 
                    placeholder="Deskripsi tambahan (opsional)..."
                >{{ old('description', $visiMisi->description ?? '') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input 
                        type="checkbox" 
                        name="is_active" 
                        id="is_active" 
                        class="form-check-input" 
                        value="1"
                        {{ old('is_active', $visiMisi->is_active ?? true) ? 'checked' : '' }}
                    >
                    <label for="is_active" class="form-check-label">
                        Aktifkan (tampilkan di halaman publik)
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="filament-button filament-button-primary">
                    <i class="fas fa-save"></i>
                    {{ isset($visiMisi) ? 'Update' : 'Simpan' }}
                </button>
                <a href="{{ route('admin.visi-misi.index') }}" class="filament-button filament-button-danger">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('#editor').forEach(function(element) {
        ClassicEditor
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
                fontSize: {
                    options: [
                        9, 11, 13, 'default', 17, 19, 21, 24, 28, 32
                    ]
                },
                alignment: {
                    options: [ 'left', 'center', 'right', 'justify' ]
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
                console.log('CKEditor loaded!', editor);
                
                // Set min height
                editor.editing.view.change(writer => {
                    writer.setStyle('min-height', '400px', editor.editing.view.document.getRoot());
                });
            })
            .catch(error => {
                console.error('CKEditor error:', error);
            });
           
    });
});
</script>    
@endpush
@endsection