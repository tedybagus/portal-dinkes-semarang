@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header bg-gradient-primary text-white">
        <h5 class="mb-0">Import Data Fasyankes (Excel)</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.fasyankes.import.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Upload File Excel</label>
                <input type="file" name="file" class="form-control" required>
                <small class="text-muted">
                    Format: xlsx | Kolom wajib: klinik_id, nama, alamat
                </small>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.fasyankes.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

                <button class="btn btn-success">
                    <i class="fas fa-file-import"></i> Import Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
