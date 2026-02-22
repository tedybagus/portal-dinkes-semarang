@extends('layouts.app')

@section('title', 'Peta Fasyankes')

@push('styles')
<!-- Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<!-- Awesome Markers (UNPKG - STABLE) -->
<link rel="stylesheet" href="https://unpkg.com/leaflet.awesome-markers/dist/leaflet.awesome-markers.css">
<script src="https://unpkg.com/leaflet.awesome-markers/dist/leaflet.awesome-markers.js"></script>

<style>
    #map {
        height: 600px;
        width: 100%;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .category-filter {
        background: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    .info-box {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .filament-header {
        background: white;
        padding: 2em;
        border-radius: 12px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
    }
    /* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
    padding:2em;
}

.stat-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    display: flex;
    align-items: center;
    gap: 1.25rem;
    transition: all 0.3s;
    border-left: 4px solid transparent;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}

.card-total { border-left-color: #3b82f6; }
.card-puskesmas { border-left-color: #10b981; }
.card-rumah-sakit { border-left-color: #ef4444; }
.card-apotek { border-left-color: #f59e0b; }
.card-klinik { border-left-color: #8b5cf6; }
.card-lab { border-left-color: #06b6d4; }

.stat-icon {
    width: 70px;
    height: 70px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    flex-shrink: 0;
}

.card-total .stat-icon { background: #dbeafe; color: #3b82f6; }
.card-puskesmas .stat-icon { background: #d1fae5; color: #10b981; }
.card-rumah-sakit .stat-icon { background: #fee2e2; color: #ef4444; }
.card-apotek .stat-icon { background: #fef3c7; color: #f59e0b; }
.card-klinik .stat-icon { background: #ede9fe; color: #8b5cf6; }
.card-lab .stat-icon { background: #cffafe; color: #06b6d4; }

.stat-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.stat-label {
    font-size: 0.875rem;
    color: #64748b;
    font-weight: 500;
}

.stat-value {
    font-size: 2.25rem;
    font-weight: 800;
    color: #1e293b;
    line-height: 1;
}

.stat-subtitle {
    font-size: 0.8125rem;
    color: #94a3b8;
}

/* Charts Section */
.charts-section {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.chart-card {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.chart-header {
    margin-bottom: 1.5rem;
}

.chart-header h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.5rem;
}

.chart-header p {
    color: #64748b;
    font-size: 0.875rem;
}

.chart-container {
    height: 300px;
    position: relative;
}

.chart-legend {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 2px solid #f1f5f9;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.legend-color {
    width: 16px;
    height: 16px;
    border-radius: 4px;
}

.legend-item span {
    color: #64748b;
    font-size: 0.875rem;
}

.legend-item strong {
    margin-left: auto;
    color: #1e293b;
    font-size: 1.125rem;
}

/* Content Grid */
.content-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
    margin-bottom: 2rem;
}

.map-card,
.recent-card {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.map-header,
.recent-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.map-header h3,
.recent-header h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
</style>
@endpush

@section('content')
<div class="filament-header">
    <div class="container-fluid">
        <div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
        <i class="fas fa-map-marked-alt text-blue-600"></i>
        Peta Fasyankes
    </h1>

    <nav class="text-sm text-gray-500 mt-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">
            Dashboard
        </a>
        <span class="mx-1">/</span>

        <a href="{{ route('admin.fasyankes.index') }}" class="hover:text-blue-600">
            Fasyankes
        </a>
        <span class="mx-1">/</span>

        <span class="text-gray-700 font-medium">Peta</span>
    </nav>
</div>

    </div>
</div>

<section class="content">
    <div class="container-fluid">
         <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card card-total">
            <div class="stat-icon">
                <i class="fas fa-hospital-alt"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Total Fasyankes</span>
                <span class="stat-value">{{ $fasyankes->count() }}</span>
                <span class="stat-subtitle">Semua Kategori</span>
            </div>
        </div>

        <div class="stat-card card-puskesmas">
            <div class="stat-icon">
                <i class="fas fa-clinic-medical"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Puskesmas</span>
                <span class="stat-value">{{ $totalPuskesmas }}</span>
                <span class="stat-subtitle">
                    {{ number_format(($totalPuskesmas / max($fasyankes->count() , 1)) * 100, 1) }}% dari total
                </span>
            </div>
        </div>

        <div class="stat-card card-rumah-sakit">
            <div class="stat-icon">
                <i class="fas fa-hospital"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Rumah Sakit</span>
                <span class="stat-value">{{ $totalRsud}}</span>
                <span class="stat-subtitle">
                    {{ number_format(($totalRsud / max($fasyankes->count() , 1)) * 100, 1) }}% dari total
                </span>
            </div>
        </div>

        <div class="stat-card card-apotek">
            <div class="stat-icon">
                <i class="fas fa-pills"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Apotek</span>
                <span class="stat-value">{{ $totalapotek }}</span>
                <span class="stat-subtitle">
                    {{ number_format(($totalapotek / max($fasyankes->count() , 1)) * 100, 1) }}% dari total
                </span>
            </div>
        </div>

        <div class="stat-card card-klinik">
            <div class="stat-icon">
                <i class="fas fa-stethoscope"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Klinik</span>
                <span class="stat-value">{{ $totalKlinik }}</span>
                <span class="stat-subtitle">
                    {{ number_format(( $totalKlinik ?? 0 / max($fasyankes->count() , 1)) * 100,1) }}% dari total
                </span>
            </div>
        </div>

        <div class="stat-card card-lab">
            <div class="stat-icon">
                <i class="fas fa-flask"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Laboratorium</span>
                <span class="stat-value">{{ $totallab ?? 0 }}</span>
                <span class="stat-subtitle">Fasilitas Lab</span>
            </div>
        </div>
    </div>

        {{-- Filter --}}
        <div class="bg-white rounded-xl shadow p-4 mb-4" style="padding:2em">
    <p class="text-sm font-semibold text-gray-700 mb-2">
        Filter Kategori
    </p>

    <div class="flex flex-wrap gap-2" id="filterKategori">
        @foreach (['Semua', 'Apotek', 'klinik', 'laboratorium', 'Puskesmas', 'rumah_sakit'] as $item)
            <button
                type="button"
                data-kategori="{{ strtolower($item) }}"
                class="px-4 py-2 rounded-full border text-sm font-medium
                       bg-gray-100 text-gray-700 hover:bg-blue-100 hover:text-blue-700
                       transition">
                {{ $item }}
            </button>
        @endforeach
    </div>
</div>


        {{-- Map --}}
        <div class="card" style="padding: 2em">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title"><i class="fas fa-map"></i> Peta Lokasi Fasyankes</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.fasyankes.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-list"></i> Lihat Tabel
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div id="map"></div>
            </div>
        </div>

    </div>
</section>

@push('scripts')
<script>
// Data fasyankes dari Laravel
const fasyankesData = @json($fasyankes);
function normalizeKategori(text) {
    return text
        ?.toLowerCase()
        .replace(/\s+/g, '_') // spasi → _
        ?? 'default';
}
// Initialize map

console.log('Leaflet:', L);
    console.log('AwesomeMarkers:', L.AwesomeMarkers);

    if (!L.AwesomeMarkers) {
        console.warn('AwesomeMarkers gagal dimuat, pakai icon default');
}

    const map = L.map('map').setView(
        [-7.242126715500639, 110.38449158445297],10); // Kab.semarang coordinates

// Add tile layer
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors',
    maxZoom: 18,
}).addTo(map);
console.log('Leaflet:', L);
console.log('AwesomeMarkers:', L.AwesomeMarkers);
// Icon colors based on category
// Store all markers
let markers = [];

// Function to create custom icon
function getIconByKategori(kategori) {
    const colors = {
        klinik: 'blue',
        puskesmas: 'green',
        rumah_sakit: 'red',
        apotek: 'violet',
        laboratorium: 'orange',
        default: 'grey'
    };

    const color = colors[kategori] ?? colors.default;

    return L.icon({
        iconUrl: `https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-${color}.png`,
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });
}
// Add markers
fasyankesData.forEach(item => {

    if (!item.latitude || !item.longitude) return;

    const kategori = item.kategori?.nama
        ?.toLowerCase()
        ?.replace(' ', '_') ?? 'default';

    const icon = getIconByKategori(kategori);

    const marker = L.marker(
        [item.latitude, item.longitude],
        { icon }
    )
    .bindPopup(
        `<strong>${item.nama}</strong><br>
        ${item.kategori?.nama ?? '-'}<br>
        ${item.alamat}<br>
        ${[item.latitude, item.longitude]}`
    )
    .addTo(map);

    marker.kategori = kategori;
    markers.push(marker);
});


// Filter functionality
// $('input[name="category"]').on('change', function() {
//     const selectedCategory = $(this).val();
    
//     markers.forEach(function(marker) {
//         if (selectedCategory === 'all') {
//             marker.addTo(map);
//         } else {
//             if (marker.categoryId == selectedCategory) {
//                 marker.addTo(map);
//             } else {
//                 map.removeLayer(marker);
//             }
//         }
//     });
// });
function filterMarkerByKategori(kategori) {
    markers.forEach(marker => {
        if (kategori === 'semua'|| marker.kategori === kategori) {
            marker.addTo(map);
        } else {
            if (marker.kategori === kategori) {
                marker.addTo(map);
            } else {
                map.removeLayer(marker);
            }
        }
    });
}
document.querySelectorAll('#filterKategori button').forEach(btn => {
    btn.addEventListener('click', function () {

        document.querySelectorAll('#filterKategori button')
            .forEach(b => b.classList.remove('bg-blue-600', 'text-white'));

        this.classList.add('bg-blue-600', 'text-white');

        const kategori = this.dataset.kategori;

        // panggil fungsi filter marker
        filterMarkerByKategori(kategori);
    });
});


// Fit bounds to show all markers
if (markers.length > 0) {
    const group = L.featureGroup(markers);
    map.fitBounds(group.getBounds().pad(0.1));
}
</script>
@endpush
@endsection