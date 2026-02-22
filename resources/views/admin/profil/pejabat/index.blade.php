@extends('layouts.app')

@section('title', 'Kelola Pejabat Struktural')


@section('content')
<div class="page-content">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <h1>
                <i class="fas fa-users"></i>
                Kelola Pejabat Struktural
            </h1>
            <p>Manajemen profil pejabat struktural organisasi</p>
        </div>
    </div>

    <!-- Success Message (Hidden, will be shown by JS) -->
    @if(session('success'))
        <div data-success-message="{{ session('success') }}" style="display: none;"></div>
    @endif

    <!-- Error Message (Hidden, will be shown by JS) -->
    @if(session('error'))
        <div data-error-message="{{ session('error') }}" style="display: none;"></div>
    @endif

    <!-- Action Bar -->
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

    <!-- Table Card -->
    <div class="table-container">
        @if($pejabat->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="50">
                                <input type="checkbox" id="select-all" style="cursor: pointer;">
                            </th>
                            <th width="60">#</th>
                            <th width="80">Foto</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>NIP</th>
                            <th width="80">Urutan</th>
                            <th width="100">Status</th>
                            <th width="200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pejabat as $index => $item)
                            <tr>
                                <td>
                                    <input type="checkbox" class="item-checkbox" value="{{ $item->id }}" style="cursor: pointer;">
                                </td>
                                <td>{{ $pejabat->firstItem() + $index }}</td>
                                <td>
                                    @if($item->foto)
                                        <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}" 
                                             style="width: 50px; height: 50px; border-radius: 0.5rem; object-fit: cover; border: 2px solid #e5e7eb;">
                                    @else
                                        <div style="width: 50px; height: 50px; border-radius: 0.5rem; background: #3b82f6; color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.25rem;">
                                            {{ strtoupper(substr($item->nama, 0, 1)) }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: #111827;">{{ $item->nama }}</div>
                                    @if($item->pendidikan)
                                        <div style="font-size: 0.8125rem; color: #6b7280; margin-top: 0.125rem;">
                                            {{ $item->pendidikan }}
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $item->jabatan }}</td>
                                <td>
                                    <code style="background: #f3f4f6; padding: 0.25rem 0.5rem; border-radius: 0.375rem; font-size: 0.8125rem;">
                                        {{ $item->nip ?? '-' }}
                                    </code>
                                </td>
                                <td>
                                    <span class="badge badge-secondary">{{ $item->order }}</span>
                                </td>
                                <td>
                                    @if($item->is_active)
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle"></i> Aktif
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">
                                            <i class="fas fa-times-circle"></i> Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.pejabat.edit', $item->id) }}" 
                                           class="btn btn-warning btn-sm" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.pejabat.destroy', $item->id) }}" 
                                              method="POST" 
                                              class="delete-form" 
                                              data-item-name="{{ $item->nama }}"
                                              style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger critical-delete" data-item-name="{{ $item->nama }}">
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

            <!-- Pagination -->
            <div class="card-footer">
                {{ $pejabat->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-users"></i>
                <h3>Belum Ada Data</h3>
                <p>Belum ada profil pejabat yang ditambahkan</p>
                <a href="{{ route('admin.pejabat.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Pejabat
                </a>
            </div>
        @endif
    </div>
        <!-- Checkbox di table header -->
        {{-- <th>
            <input type="checkbox" id="select-all">
        </th> --}}

        <!-- Checkbox di setiap row -->
        {{-- <td>
            <input type="checkbox" class="item-checkbox" value="{{ $item->id }}">
        </td> --}}

        {{-- <!-- Button bulk delete -->
        <button type="button" id="bulk-delete-btn" class="btn btn-danger">
            <i class="fas fa-trash"></i> Hapus Terpilih
        </button> --}}

    <!-- Bulk Delete Form (Hidden) -->
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