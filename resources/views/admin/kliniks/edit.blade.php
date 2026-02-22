@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Edit Klinik</h2>
                <p class="mt-1 text-sm text-gray-500">Perbarui data klinik</p>
            </div>
            <a href="{{ route('admin.kliniks.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="py-6">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan:</h3>
                                <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('admin.kliniks.update', $klinik) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Nama Klinik -->
                            <div>
                                <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Klinik <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="nama" 
                                    id="nama" 
                                    value="{{ old('nama', $klinik->nama) }}" 
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('nama') border-red-500 @enderror" 
                                    required
                                >
                                @error('nama')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kode Fasyankes -->
                            <div>
                                <label for="kode_fasyankes" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Kode Fasyankes <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="kode_fasyankes" 
                                    id="kode_fasyankes" 
                                    value="{{ old('kode_fasyankes', $klinik->kode_fasyankes) }}" 
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition font-mono @error('kode_fasyankes') border-red-500 @enderror" 
                                    required
                                >
                                @error('kode_fasyankes')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- No Telp -->
                            <div>
                                <label for="no_telp" class="block text-sm font-semibold text-gray-700 mb-2">
                                    No Telepon
                                </label>
                                <input 
                                    type="text" 
                                    name="no_telp" 
                                    id="no_telp" 
                                    value="{{ old('no_telp', $klinik->no_telp) }}" 
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('no_telp') border-red-500 @enderror" 
                                >
                                @error('no_telp')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Alamat -->
                            <div>
                                <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Alamat <span class="text-red-500">*</span>
                                </label>
                                <textarea 
                                    name="alamat" 
                                    id="alamat" 
                                    rows="4" 
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('alamat') border-red-500 @enderror" 
                                    required
                                >{{ old('alamat', $klinik->alamat) }}</textarea>
                                @error('alamat')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Status
                                </label>
                                <div class="flex items-center">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input 
                                            type="checkbox" 
                                            name="is_active" 
                                            value="1" 
                                            {{ old('is_active', $klinik->is_active) ? 'checked' : '' }}
                                            class="sr-only peer"
                                        >
                                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                        <span class="ml-3 text-sm font-medium text-gray-700">Aktif</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Map & Coordinates -->
                        <div class="space-y-6">
                            <!-- Latitude & Longitude -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="latitude" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Latitude
                                    </label>
                                    <input 
                                        type="text" 
                                        name="latitude" 
                                        id="latitude" 
                                        value="{{ old('latitude', $klinik->latitude) }}" 
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition font-mono @error('latitude') border-red-500 @enderror" 
                                        step="any"
                                    >
                                    @error('latitude')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="longitude" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Longitude
                                    </label>
                                    <input 
                                        type="text" 
                                        name="longitude" 
                                        id="longitude" 
                                        value="{{ old('longitude', $klinik->longitude) }}" 
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition font-mono @error('longitude') border-red-500 @enderror" 
                                        step="any"
                                    >
                                    @error('longitude')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Info Box -->
                            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-blue-700">
                                            <strong>Tips:</strong> Klik pada map di bawah untuk mengubah lokasi klinik atau masukkan koordinat secara manual.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Google Maps -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Pilih Lokasi di Map
                                </label>
                                <div id="map" class="w-full h-96 rounded-lg border-2 border-gray-300 shadow-md"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="mt-8 flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.kliniks.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                            <i class="fas fa-times mr-2"></i> Batal
                        </a>
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition font-medium shadow-lg">
                            <i class="fas fa-save mr-2"></i> Update Klinik
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=initMap" async defer></script> --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
let map;
let marker;

function initMap() {
    const defaultLat = -7.3318;
    const defaultLng = 110.4922;
    
    const lat = parseFloat(document.getElementById('latitude').value) || defaultLat;
    const lng = parseFloat(document.getElementById('longitude').value) || defaultLng;

    map = L.map('map').setView([lat, lng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    marker = L.marker([lat, lng], {
        draggable: true
    }).addTo(map);

    marker.on('dragend', function(e) {
        const position = marker.getLatLng();
        updateCoordinates(position.lat, position.lng);
    });

    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        updateCoordinates(e.latlng.lat, e.latlng.lng);
    });

    // Add popup if location exists
    @if($klinik->latitude && $klinik->longitude)
    marker.bindPopup('<b>{{ $klinik->nama }}</b><br>{{ $klinik->alamat }}').openPopup();
    @endif
}

function updateCoordinates(lat, lng) {
    document.getElementById('latitude').value = lat.toFixed(8);
    document.getElementById('longitude').value = lng.toFixed(8);
}

async function searchLocation() {
    const searchQuery = document.getElementById('searchLocation').value;
    
    if (!searchQuery) {
        alert('Masukkan alamat atau nama tempat yang ingin dicari');
        return;
    }

    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(searchQuery)}&limit=1`);
        const data = await response.json();

        if (data && data.length > 0) {
            const lat = parseFloat(data[0].lat);
            const lng = parseFloat(data[0].lon);

            map.setView([lat, lng], 15);
            marker.setLatLng([lat, lng]);
            updateCoordinates(lat, lng);

            marker.bindPopup(`<b>Lokasi ditemukan:</b><br>${data[0].display_name}`).openPopup();
        } else {
            alert('Lokasi tidak ditemukan. Coba kata kunci yang lebih spesifik.');
        }
    } catch (error) {
        console.error('Error searching location:', error);
        alert('Terjadi kesalahan saat mencari lokasi.');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    initMap();
});
</script>
@endsection
