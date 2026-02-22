@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Detail Klinik</h2>
                <p class="mt-1 text-sm text-gray-500">Informasi lengkap klinik</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.kliniks.edit', $klinik) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <a href="{{ route('admin.kliniks.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <!-- Status Card -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="h-16 w-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center shadow-lg">
                        <i class="fas fa-hospital text-white text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $klinik->nama }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Kode: <span class="font-mono font-semibold">{{ $klinik->kode_fasyankes }}</span></p>
                    </div>
                </div>
                <div>
                    <span class="px-4 py-2 text-sm font-semibold rounded-full {{ $klinik->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $klinik->is_active ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Information Card -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                    <h4 class="text-lg font-semibold text-white">
                        <i class="fas fa-info-circle mr-2"></i> Informasi Klinik
                    </h4>
                </div>
                <div class="p-6 space-y-4">
                    <!-- Nama -->
                    <div class="flex items-start gap-4 pb-4 border-b border-gray-200">
                        <div class="h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-hospital text-blue-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-500">Nama Klinik</p>
                            <p class="text-base font-semibold text-gray-900">{{ $klinik->nama }}</p>
                        </div>
                    </div>

                    <!-- Kode Fasyankes -->
                    <div class="flex items-start gap-4 pb-4 border-b border-gray-200">
                        <div class="h-10 w-10 rounded-lg bg-purple-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-barcode text-purple-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-500">Kode Fasyankes</p>
                            <p class="text-base font-mono font-semibold text-gray-900">{{ $klinik->kode_fasyankes }}</p>
                        </div>
                    </div>

                    <!-- No Telp -->
                    <div class="flex items-start gap-4 pb-4 border-b border-gray-200">
                        <div class="h-10 w-10 rounded-lg bg-green-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-phone text-green-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-500">No Telepon</p>
                            <p class="text-base font-semibold text-gray-900">{{ $klinik->no_telp ?: '-' }}</p>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="flex items-start gap-4 pb-4 border-b border-gray-200">
                        <div class="h-10 w-10 rounded-lg bg-yellow-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-yellow-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-500">Alamat</p>
                            <p class="text-base text-gray-900">{{ $klinik->alamat }}</p>
                        </div>
                    </div>

                    <!-- Koordinat -->
                    <div class="flex items-start gap-4">
                        <div class="h-10 w-10 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-compass text-red-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-500 mb-2">Koordinat</p>
                            @if($klinik->latitude && $klinik->longitude)
                            <div class="space-y-1">
                                <p class="text-sm">
                                    <span class="text-gray-600">Latitude:</span> 
                                    <span class="font-mono font-semibold text-gray-900">{{ $klinik->latitude }}</span>
                                </p>
                                <p class="text-sm">
                                    <span class="text-gray-600">Longitude:</span> 
                                    <span class="font-mono font-semibold text-gray-900">{{ $klinik->longitude }}</span>
                                </p>
                                <a href="{{ $klinik->map_url }}" target="_blank" class="inline-flex items-center px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition mt-2">
                                    <i class="fas fa-external-link-alt mr-2"></i> Buka di Google Maps
                                </a>
                            </div>
                            @else
                            <p class="text-sm text-gray-400 italic">Koordinat belum diatur</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Map Card -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-teal-600 px-6 py-4">
                    <h4 class="text-lg font-semibold text-white">
                        <i class="fas fa-map mr-2"></i> Lokasi di Map
                    </h4>
                </div>
                <div class="p-6">
                    @if($klinik->latitude && $klinik->longitude)
                    <div id="map" class="w-full h-96 rounded-lg shadow-md border-2 border-gray-200"></div>
                    <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="text-sm text-blue-800">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Lokasi:</strong> {{ $klinik->nama }}
                        </p>
                        <p class="text-xs text-blue-600 mt-1">
                            Koordinat: {{ $klinik->latitude }}, {{ $klinik->longitude }}
                        </p>
                    </div>
                    @else
                    <div class="text-center py-12">
                        <div class="h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-map-marked-alt text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500 font-medium">Lokasi belum diatur</p>
                        <p class="text-sm text-gray-400 mt-1">Silakan edit klinik untuk menambahkan lokasi</p>
                        <a href="{{ route('admin.kliniks.edit', $klinik) }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-map-marker-alt mr-2"></i> Atur Lokasi
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Metadata Card -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h4 class="text-lg font-semibold text-gray-900 mb-4">
                <i class="far fa-clock mr-2"></i> Informasi Sistem
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-500 mb-1">Dibuat</p>
                    <p class="text-base font-semibold text-gray-900">{{ $klinik->created_at->format('d M Y H:i') }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-500 mb-1">Terakhir Diperbarui</p>
                    <p class="text-base font-semibold text-gray-900">{{ $klinik->updated_at->format('d M Y H:i') }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-500 mb-1">Status</p>
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $klinik->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $klinik->is_active ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Actions Card -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h4 class="text-lg font-semibold text-gray-900 mb-4">
                <i class="fas fa-cog mr-2"></i> Aksi
            </h4>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.kliniks.edit', $klinik) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-edit mr-2"></i> Edit Klinik
                </a>

                @if($klinik->map_url)
                <a href="{{ $klinik->map_url }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-map-marked-alt mr-2"></i> Buka di Google Maps
                </a>
                @endif

                <button 
                    type="button"
                    onclick="openDeleteModal()"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
                >
                    <i class="fas fa-trash mr-2"></i> Hapus Klinik
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full">
        <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 rounded-t-2xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center">
                        <i class="fas fa-trash text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white">Hapus Klinik</h3>
                </div>
                <button 
                    type="button"
                    onclick="closeDeleteModal()"
                    class="text-white hover:text-red-100 transition"
                >
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <form action="{{ route('admin.kliniks.destroy', $klinik) }}" method="POST">
            @csrf
            @method('DELETE')
            
            <div class="p-6">
                <div class="flex justify-center mb-4">
                    <div class="h-16 w-16 rounded-full bg-red-100 flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600 text-3xl"></i>
                    </div>
                </div>

                <div class="text-center mb-6">
                    <p class="text-lg font-semibold text-gray-900 mb-2">Hapus klinik ini?</p>
                    <p class="text-sm text-gray-600 mb-4">"{{ $klinik->nama }}"</p>
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-left">
                        <p class="text-sm text-red-800">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <strong>Peringatan:</strong> Data klinik akan dihapus permanen dan tidak dapat dikembalikan.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 rounded-b-2xl flex items-center justify-end gap-3">
                <button 
                    type="button"
                    onclick="closeDeleteModal()"
                    class="px-6 py-2.5 bg-white border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium"
                >
                    <i class="fas fa-times mr-2"></i> Batal
                </button>
                <button 
                    type="submit" 
                    class="px-6 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium shadow-lg"
                >
                    <i class="fas fa-trash mr-2"></i> Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>

@if($klinik->latitude && $klinik->longitude)
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>

 document.addEventListener('DOMContentLoaded', function() {
    const lat = {{ $klinik->latitude }};
    const lng = {{ $klinik->longitude }};

    const map = L.map('map').setView([lat, lng], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    const marker = L.marker([lat, lng]).addTo(map);

    marker.bindPopup(`
        <div style="padding: 5px;">
            <h3 style="margin: 0 0 5px 0; font-weight: bold; color: #1f2937;">{{ $klinik->nama }}</h3>
            <p style="margin: 0; font-size: 12px; color: #6b7280;">{{ $klinik->kode_fasyankes }}</p>
            <p style="margin: 5px 0 0 0; font-size: 12px; color: #4b5563;">{{ $klinik->alamat }}</p>
            <a href="https://www.openstreetmap.org/?mlat={{ $klinik->latitude }}&mlon={{ $klinik->longitude }}#map=15/{{ $klinik->latitude }}/{{ $klinik->longitude }}" target="_blank" style="display: inline-block; margin-top: 5px; color: #3b82f6; font-size: 12px;">Lihat di OpenStreetMap</a>
        </div>
    `).openPopup();
});

function openDeleteModal() {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeDeleteModal();
    }
});

document.getElementById('deleteModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeDeleteModal();
    }
});   

</script>
@endif
@endsection