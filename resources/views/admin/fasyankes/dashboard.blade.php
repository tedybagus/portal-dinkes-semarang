@extends('layouts.app')

@section('title', 'Dashboard Fasyankes')
@push('styles')
@push('styles')
<!-- Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<!-- Awesome Markers (UNPKG - STABLE) -->
<link rel="stylesheet" href="https://unpkg.com/leaflet.awesome-markers/dist/leaflet.awesome-markers.css">
<script src="https://unpkg.com/leaflet.awesome-markers/dist/leaflet.awesome-markers.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.fasyankes-dashboard {
    padding: 2rem;
    background: #f8fafc;
    min-height: 100vh;
}

/* Page Header */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 2rem;
}

.page-header h1 {
    font-size: 2rem;
    font-weight: 800;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.5rem;
}

.page-header h1 i {
    color: #3b82f6;
}

.subtitle {
    color: #64748b;
    font-size: 1rem;
}

.header-actions {
    display: flex;
    gap: 1rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    font-size: 0.9375rem;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
}

.btn-secondary {
    background: white;
    color: #475569;
    border: 2px solid #e2e8f0;
}

.btn-secondary:hover {
    border-color: #3b82f6;
    color: #3b82f6;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
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

.btn-link {
    color: #3b82f6;
    font-weight: 600;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    transition: all 0.3s;
}

.btn-link:hover {
    gap: 0.75rem;
}

.map-container {
    height: 400px;
    background: #f8fafc;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.map-placeholder {
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
}

.map-placeholder i {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.map-info {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #64748b;
}

/* Recent List */
.recent-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.recent-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 8px;
    transition: all 0.3s;
}

.recent-item:hover {
    background: #eff6ff;
    transform: translateX(4px);
}

.recent-icon {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.recent-icon.puskesmas { background: #d1fae5; color: #10b981; }
.recent-icon.rumah-sakit { background: #fee2e2; color: #ef4444; }
.recent-icon.apotek { background: #fef3c7; color: #f59e0b; }
.recent-icon.klinik { background: #ede9fe; color: #8b5cf6; }

.recent-info {
    flex: 1;
}

.recent-info h4 {
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.recent-info p {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.25rem;
}

.badge {
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.badge-puskesmas { background: #d1fae5; color: #065f46; }
.badge-rumah-sakit { background: #fee2e2; color: #991b1b; }
.badge-apotek { background: #fef3c7; color: #92400e; }
.badge-klinik { background: #ede9fe; color: #5b21b6; }

.text-muted {
    color: #94a3b8;
    font-size: 0.875rem;
}

.recent-info small {
    color: #64748b;
    font-size: 0.8125rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.recent-actions {
    display: flex;
    gap: 0.5rem;
}

.btn-icon {
    width: 36px;
    height: 36px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
    color: #64748b;
    border: 1px solid #e2e8f0;
    transition: all 0.3s;
    text-decoration: none;
}

.btn-icon:hover {
    color: #3b82f6;
    border-color: #3b82f6;
    background: #eff6ff;
}

/* Quick Stats */
.quick-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.quick-stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.quick-stat-item i {
    font-size: 2rem;
    color: #3b82f6;
}

.quick-stat-item strong {
    display: block;
    font-size: 1.5rem;
    font-weight: 800;
    color: #1e293b;
}

.quick-stat-item span {
    color: #64748b;
    font-size: 0.875rem;
}

.empty-state {
    padding: 3rem;
    text-align: center;
    color: #94a3b8;
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
}

@media (max-width: 1024px) {
    .content-grid {
        grid-template-columns: 1fr;
    }

    .charts-section {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .fasyankes-dashboard {
        padding: 1rem;
    }

    .page-header {
        flex-direction: column;
        gap: 1rem;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .header-actions {
        flex-direction: column;
        width: 100%;
    }

    .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush
@section('content')
<div class="fasyankes-dashboard">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1><i class="fas fa-hospital"></i> Dashboard Fasilitas Kesehatan</h1>
            <p class="subtitle">Overview dan statistik fasilitas kesehatan di wilayah Anda</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.fasyankes.index') }}" class="btn btn-secondary">
                <i class="fas fa-list"></i> Lihat Semua Data
            </a>
            <a href="{{ route('admin.fasyankes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Fasyankes
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card card-total">
            <div class="stat-icon">
                <i class="fas fa-hospital-alt"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Total Fasyankes</span>
                <span class="stat-value">{{ $stats['total'] }}</span>
                <span class="stat-subtitle">Semua Kategori</span>
            </div>
        </div>

        <div class="stat-card card-puskesmas">
            <div class="stat-icon">
                <i class="fas fa-clinic-medical"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Puskesmas</span>
                <span class="stat-value">{{ $stats['puskesmas'] }}</span>
                <span class="stat-subtitle">
                    {{ number_format(($stats['puskesmas'] / max($stats['total'], 1)) * 100, 1) }}% dari total
                </span>
            </div>
        </div>

        <div class="stat-card card-rumah-sakit">
            <div class="stat-icon">
                <i class="fas fa-hospital"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Rumah Sakit</span>
                <span class="stat-value">{{ $stats['rumah_sakit'] }}</span>
                <span class="stat-subtitle">
                    {{ number_format(($stats['rumah_sakit'] / max($stats['total'], 1)) * 100, 1) }}% dari total
                </span>
            </div>
        </div>

        <div class="stat-card card-apotek">
            <div class="stat-icon">
                <i class="fas fa-pills"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Apotek</span>
                <span class="stat-value">{{ $stats['apotek'] }}</span>
                <span class="stat-subtitle">
                    {{ number_format(($stats['apotek'] / max($stats['total'], 1)) * 100, 1) }}% dari total
                </span>
            </div>
        </div>

        <div class="stat-card card-klinik">
            <div class="stat-icon">
                <i class="fas fa-stethoscope"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Klinik</span>
                <span class="stat-value">{{ $stats['klinik'] ?? 0 }}</span>
                <span class="stat-subtitle">
                    {{ number_format((($stats['klinik'] ?? 0) / max($stats['total'], 1)) * 100, 1) }}% dari total
                </span>
            </div>
        </div>

        <div class="stat-card card-lab">
            <div class="stat-icon">
                <i class="fas fa-flask"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Laboratorium</span>
                <span class="stat-value">{{ $stats['laboratorium'] ?? 0 }}</span>
                <span class="stat-subtitle">Fasilitas Lab</span>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-section">
        <!-- Pie Chart - Distribusi Kategori -->
        <div class="chart-card">
            <div class="chart-header">
                <h3><i class="fas fa-chart-pie"></i> Distribusi Kategori Fasyankes</h3>
                <p>Persentase berdasarkan kategori</p>
            </div>
            <div class="chart-container">
                <canvas id="categoryChart"></canvas>
            </div>
            <div class="chart-legend">
                <div class="legend-item">
                    <span class="legend-color" style="background: #10b981;"></span>
                    <span>Puskesmas</span>
                    <strong>{{ $stats['puskesmas'] }}</strong>
                </div>
                <div class="legend-item">
                    <span class="legend-color" style="background: #ef4444;"></span>
                    <span>Rumah Sakit</span>
                    <strong>{{ $stats['rumah_sakit'] }}</strong>
                </div>
                <div class="legend-item">
                    <span class="legend-color" style="background: #f59e0b;"></span>
                    <span>Apotek</span>
                    <strong>{{ $stats['apotek'] }}</strong>
                </div>
                <div class="legend-item">
                    <span class="legend-color" style="background: #3b82f6;"></span>
                    <span>Klinik</span>
                    <strong>{{ $stats['klinik'] ?? 0 }}</strong>
                </div>
            </div>
        </div>

        <!-- Bar Chart - Perbandingan -->
        <div class="chart-card">
            <div class="chart-header">
                <h3><i class="fas fa-chart-bar"></i> Perbandingan Jumlah Fasyankes</h3>
                <p>Jumlah per kategori</p>
            </div>
            <div class="chart-container">
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Map & Recent Section -->
    <div class="content-grid">
        <!-- Map Section -->
        <div class="map-card">
            <div class="map-header">
                <h3><i class="fas fa-map-marked-alt"></i> Peta Sebaran Fasyankes</h3>
                <a href="{{ route('admin.fasyankes.maps') }}" class="btn-link">
                    Lihat Peta Lengkap <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="card-bodyr" id="map">
                <div class="map-placeholder">
                    <i class="fas fa-map-marker-alt"></i>
                    <p>Peta akan ditampilkan di sini</p>
                    <small>Total {{ $stats['total'] }} lokasi fasyankes</small>
                </div>
            </div>
            <div class="map-info">
                <div class="info-item">
                    <i class="fas fa-map-pin" style="color: #10b981;"></i>
                    <span>Puskesmas</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-map-pin" style="color: #ef4444;"></i>
                    <span>Rumah Sakit</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-map-pin" style="color: #f59e0b;"></i>
                    <span>Apotek</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-map-pin" style="color: #3b82f6;"></i>
                    <span>Klinik</span>
                </div>
            </div>
        </div>

        <!-- Recent Fasyankes -->
        <div class="recent-card">
            <div class="recent-header">
                <h3><i class="fas fa-clock"></i> Data Terbaru</h3>
                <a href="{{ route('admin.fasyankes.index') }}" class="btn-link">
                    Lihat Semua <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="recent-list">
                @forelse($recentFasyankes as $fasyankes)
                <div class="recent-item">
                    <div class="recent-icon {{ strtolower(str_replace(' ', '-', $fasyankes->kategori)) }}">
                        @if($fasyankes->kategori === 'Puskesmas')
                        <i class="fas fa-clinic-medical"></i>
                        @elseif($fasyankes->kategori === 'Rumah Sakit')
                        <i class="fas fa-hospital"></i>
                        @elseif($fasyankes->kategori === 'Apotek')
                        <i class="fas fa-pills"></i>
                        @else
                        <i class="fas fa-stethoscope"></i>
                        @endif
                    </div>
                    <div class="recent-info">
                        <h4>{{ $fasyankes->nama }}</h4>
                        <p>
                            <span class="badge badge-{{ strtolower(str_replace(' ', '-', $fasyankes->kategori)) }}">
                                {{ $fasyankes->kategori }}
                            </span>
                            <span class="text-muted">{{ $fasyankes->kode }}</span>
                        </p>
                        <small><i class="fas fa-map-marker-alt"></i> {{ Str::limit($fasyankes->alamat, 40) }}</small>
                    </div>
                    <div class="recent-actions">
                        <a href="{{ route('admin.fasyankes.show', $fasyankes->id) }}" class="btn-icon" title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.fasyankes.edit', $fasyankes->id) }}" class="btn-icon" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <p>Belum ada data fasyankes</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="quick-stats">
        <div class="quick-stat-item">
            <i class="fas fa-map-marker-alt"></i>
            <div>
                <strong>{{ $stats['with_coordinates'] ?? $stats['total'] }}</strong>
                <span>Memiliki Koordinat</span>
            </div>
        </div>
        <div class="quick-stat-item">
            <i class="fas fa-calendar-plus"></i>
            <div>
                <strong>{{ $stats['added_this_month'] ?? 0 }}</strong>
                <span>Ditambahkan Bulan Ini</span>
            </div>
        </div>
        <div class="quick-stat-item">
            <i class="fas fa-edit"></i>
            <div>
                <strong>{{ $stats['updated_today'] ?? 0 }}</strong>
                <span>Diupdate Hari Ini</span>
            </div>
        </div>
        <div class="quick-stat-item">
            <i class="fas fa-check-circle"></i>
            <div>
                <strong>{{ number_format(($stats['total'] / max($stats['total'], 1)) * 100, 0) }}%</strong>
                <span>Data Lengkap</span>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
  const fasyankesData = @json($fasyankes);
// Chart Colors
const chartColors = {
    puskesmas: '#10b981',
    rumahSakit: '#ef4444',
    apotek: '#f59e0b',
    klinik: '#3b82f6',
    laboratorium: '#06b6d4'
};

// Data from backend
const chartData = {
    puskesmas: {{ $stats['puskesmas'] }},
    rumahSakit: {{ $stats['rumah_sakit'] }},
    apotek: {{ $stats['apotek'] }},
    klinik: {{ $stats['klinik'] ?? 0 }},
    laboratorium: {{ $stats['laboratorium'] ?? 0 }}
};

// Pie Chart - Category Distribution
const ctxPie = document.getElementById('categoryChart').getContext('2d');
new Chart(ctxPie, {
    type: 'doughnut',
    data: {
        labels: ['Puskesmas', 'Rumah Sakit', 'Apotek', 'Klinik','laboratorium'],
        datasets: [{
            data: [
                chartData.puskesmas,
                chartData.rumahSakit,
                chartData.apotek,
                chartData.klinik,
                chartData.laboratorium
            ],
            backgroundColor: [
                chartColors.puskesmas,
                chartColors.rumahSakit,
                chartColors.apotek,
                chartColors.klinik,
                chartColors.laboratorium
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const percentage = ((context.parsed / total) * 100).toFixed(1);
                        return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                    }
                }
            }
        }
    }
});

// Bar Chart - Comparison
const ctxBar = document.getElementById('barChart').getContext('2d');
new Chart(ctxBar, {
    type: 'bar',
    data: {
        labels: ['Puskesmas', 'Rumah Sakit', 'Apotek', 'Klinik','laboratorium'],
        datasets: [{
            label: 'Jumlah Fasyankes',
            data: [
                chartData.puskesmas,
                chartData.rumahSakit,
                chartData.apotek,
                chartData.klinik,
                chartData.laboratorium
            ],
            backgroundColor: [
                chartColors.puskesmas,
                chartColors.rumahSakit,
                chartColors.apotek,
                chartColors.klinik,
                chartColors.laboratorium
            ],
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});
console.log('Leaflet:', L);
    console.log('AwesomeMarkers:', L.AwesomeMarkers);

    if (!L.AwesomeMarkers) {
        console.warn('AwesomeMarkers gagal dimuat, pakai icon default');
}
// Leaflet Map
const map = L.map('map').setView([-7.242126715500639, 110.38449158445297],10); // Semarang center

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);
console.log('Leaflet:', L);
console.log('AwesomeMarkers:', L.AwesomeMarkers);
let markers = [];
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
</script>
@endpush
@endsection