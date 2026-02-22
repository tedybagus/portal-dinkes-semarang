@extends('layouts.app')

@section('title', 'Kelola Tupoksi')

@section('content')
<div class="page-content">
<div class="page-header">
    <h1>Tupoksi (Tugas Pokok & Fungsi)</h1>
    <a href="{{ route('admin.tupoksi.create') }}" class="btn btn-primary" >
        <i class="fas fa-plus"></i> Tambah Tupoksi
    </a>
</div>

<!-- Success Message (Hidden, will be shown by JS) -->
    @if(session('success'))
        <div data-success-message="{{ session('success') }}" style="display: none;"></div>
    @endif

    <!-- Error Message (Hidden, will be shown by JS) -->
    @if(session('error'))
        <div data-error-message="{{ session('error') }}" style="display: none;"></div>
    @endif
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div id="bulk-actions" style="display: none; gap: 0.75rem; align-items: center;">
            <span class="badge badge-info">
                <span id="selected-count">0</span> dipilih
            </span>
            <button type="button" id="bulk-delete-btn" class="btn btn-danger btn-sm">
                <i class="fas fa-trash"></i> Hapus Terpilih
            </button>
        </div>
        
        <a href="{{ route('admin.pejabat.create') }}" class="btn btn-primary" style="margin-left: auto;">
            <i class="fas fa-plus"></i>
            Tambah Pejabat
        </a>
    </div>

<div class="table-container">
    @if($tupoksi->count() > 0)
        <div class="table-responsive">
            <table class="table">
            <thead>
                <tr>
                      <th width="50">
                        <input type="checkbox" id="select-all" style="cursor: pointer;">
                     </th>
                     <th width="60">No</th>
                    <th>Bidang/Bagian</th>
                    <th>Tugas Pokok</th>
                    <th>Fungsi</th>
                    <th width="80">Urutan</th>
                    <th width="100">Status</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tupoksi as $index => $item)
                <tr>
                    <td>
                    <input type="checkbox" class="item-checkbox" value="{{ $item->id }}" style="cursor: pointer;">
                    </td>
                    <td>{{ $tupoksi->firstItem() + $index }}</td>
                    <td><strong>{{ $item->title }}</strong></td>
                    <td>{!!$item->tugas_pokok !!}</td>
                    <td>{!!$item->fungsi !!}</td>
                    <td>
                        <span class="badge badge-secondary">{{ $item->order }}</span>
                    </td>
                    <td>
                        @if($item->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-danger">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.tupoksi.edit', $item->id) }}" 
                                class="btn btn-warning btn-sm" 
                                title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.tupoksi.destroy', $item->id) }}" method="POST" style="display: inline;" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger critical-delete" data-item-name="{{ $item->id }}">
                                    <i class="fas fa-exclamation-triangle"></i> Hapus Permanen
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $tupoksi->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-tasks"></i>
            <h3>Belum Ada Data</h3>
            <p>Klik tombol "Tambah Tupoksi" untuk menambah data baru</p>
        </div>
    @endif
</div>
<!-- Checkbox di table header -->
    <form id="bulk-delete-form" action="{{ route('admin.pejabat.bulk-delete') }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
        <input type="hidden" name="ids" id="bulk-delete-ids">
    </form>
</div>
@push('scripts')
<script>
// Bulk delete functionality
document.getElementById('bulk-delete-btn')?.addEventListener('click', function() {
    const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
    const ids = Array.from(checkedBoxes).map(cb => cb.value);
    
    if (ids.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Tidak Ada Data Dipilih',
            text: 'Pilih minimal 1 data untuk dihapus',
            confirmButtonColor: '#3b82f6'
        });
        return;
    }
    
    Swal.fire({
        title: 'Konfirmasi Hapus Massal',
        html: `Anda akan menghapus <strong>${ids.length} pejabat</strong>.<br>Foto dan semua data terkait akan ikut terhapus!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: `<i class="fas fa-trash"></i> Hapus ${ids.length} Data`,
        cancelButtonText: '<i class="fas fa-times"></i> Batal',
        reverseButtons: true,
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('bulk-delete-ids').value = ids.join(',');
            document.getElementById('bulk-delete-form').submit();
        }
    });
});
</script>
@endpush
@endsection