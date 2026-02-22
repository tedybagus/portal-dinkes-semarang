@extends('layouts.public.app')

@section('title', 'Peta Fasyankes')

@push('styles')
<!-- Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<!-- Filament Style -->
    <link rel="stylesheet" href="{{ asset('css/filament-style.css') }}">

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
    :root {
    --bg-page: #f5f7fb;
    --card-bg: #ffffff;
    --primary: #2563eb;
    --primary-soft: #e0e7ff;
    --text-main: #0f172a;
    --text-muted: #64748b;
    --border-soft: #e5e7eb;
    --radius: 14px;
}

/* PAGE */
body {
    background: var(--bg-page);
    color: var(--text-main);
    font-family: 'Inter', system-ui, sans-serif;
}

/* HEADER TITLE */
.page-title {
    font-size: 1.75rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 10px;
}

.page-title i {
    color: var(--primary);
}

/* BREADCRUMB */
.breadcrumb {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin-top: 6px;
}

.breadcrumb a {
    color: var(--primary);
    text-decoration: none;
}

.breadcrumb a:hover {
    text-decoration: underline;
}

/* CARD */
.card {
    background: var(--card-bg);
    border-radius: var(--radius);
    padding: 20px;
    box-shadow:
        0 1px 2px rgba(0,0,0,.05),
        0 8px 24px rgba(0,0,0,.04);
    border: 1px solid var(--border-soft);
    margin-bottom: 16px;
}

/* STAT LIST */
.stat-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 18px;
}

.stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: var(--primary-soft);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 1.25rem;
}

.stat-content {
    flex: 1;
    width: 2em;
}

.stat-title {
    font-size: 0.875rem;
    color: var(--text-muted);
}

.stat-value {
    font-size: 1.1rem;
    font-weight: 600;
}

/* FILTER BADGE */
.filter-group {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.filter-badge {
    padding: 6px 12px;
    border-radius: 999px;
    background: #f1f5f9;
    color: #334155;
    font-size: 0.8rem;
    cursor: pointer;
    transition: all .2s ease;
}

.filter-badge:hover {
    background: var(--primary-soft);
    color: var(--primary);
}

.filter-badge.active {
    background: var(--primary);
    color: #fff;
}

/* MAP CONTAINER */
.map-card {
    height: 420px;
    border-radius: var(--radius);
    overflow: hidden;
    border: 1px solid var(--border-soft);
}
.container-filament {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 16px;
}
.filter-wrapper {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.filter-chip {
    padding: 8px 16px;
    border-radius: 999px;
    border: 1px solid #e5e7eb;
    background: #ffffff;
    font-size: 0.85rem;
    color: #334155;
    cursor: pointer;
    transition: all .2s ease;
}

.filter-chip:hover {
    background: #eef2ff;
    border-color: #c7d2fe;
    color: #2563eb;
}

.filter-chip.active {
    background: #2563eb;
    color: #ffffff;
    border-color: #2563eb;
    box-shadow: 0 4px 10px rgba(37, 99, 235, .35);
}
.stat-grid-small {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 14px;
    margin-bottom: 24px;
}

.stat-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 1px 4px rgba(0,0,0,.06);
    transition: all .2s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0,0,0,.1);
}

.stat-content span {
    font-size: .75rem;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: .04em;
}

.stat-content strong {
    font-size: 1.35rem;
    color: #0f172a;
}

</style>
@endpush

@section('content')
<div class="container-filament">
<h1 class="page-title">
    <i class="fas fa-map-marked-alt"></i>
    Peta Fasyankes
</h1>

<div class="breadcrumb">
    <a href="/">Beranda</a> / Peta
</div>
<section class="content">
    <div class="container-fluid">
        
        {{-- Info Stats --}}
        <div class="stat-grid-small">
            
                <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-hospital"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-title">Total Fasyankes</div>
                            <div class="stat-value">{{ $fasyankes->count() }}</div>
                        </div>
                </div>
                <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-clinic-medical"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-title">Klinik</div>
                            <div class="stat-value">{{ $totalKlinik }}</div>
                        </div>
                </div>
                <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-clinic-medical"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-title">Puskesmas</div>
                            <div class="stat-value">{{ $totalPuskesmas }}</div>
                        </div>
                </div>
                <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-clinic-medical"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-title">Rumah Sakit</div>
                            <div class="stat-value">{{$totalRsud }}</div>
                        </div>
                </div>
                <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-flask"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-title">Laboratorium</div>
                            <div class="stat-value">{{$totallab }}</div>
                        </div>
                </div>
                
                <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-capsules"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-title">Apotek</div>
                            <div class="stat-value">{{ $totalapotek }}</div>
                        </div>
                </div>
            
            
        </div>

        {{-- Filter --}}
        <div class="bg-white rounded-xl shadow p-4 mb-4">
    <p class="text-sm font-semibold text-gray-700 mb-2">
        Filter Kategori
    </p>

    <div class="filter-wrapper" id="filterKategori">
       
        @foreach (['Semua', 'Apotek', 'klinik', 'laboratorium', 'Puskesmas', 'rumah_sakit'] as $item)
            <button
                type="button"
                data-kategori="{{ strtolower($item) }}"
                class="filter-chip">
                {{ $item }}
            </button>
        @endforeach
        
    </div>
</div>
<br>

        {{-- Map --}}
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title"><i class="fas fa-map"></i> Peta Lokasi Fasyankes</h3>
                <div class="card-tools">
                </div>
            </div>
            <div class="card-body">
                <div id="map"></div>
            </div>
        </div>

    </div>
</section>
</div>

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