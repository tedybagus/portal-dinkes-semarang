@extends('layouts.app')

@section('title', 'Dashboard Pengaduan')

@section('content')
<div class="dashboard-page">
    <!-- Header -->
    <div class="page-header">
        <div class="header-left">
            <h1><i class="fas fa-chart-line"></i> Dashboard Pengaduan</h1>
            <p class="subtitle">Overview & Analytics sistem pengaduan</p>
        </div>
        <div class="header-right">
            <a href="{{ route('admin.complaints.index') }}" class="btn btn-primary">
                <i class="fas fa-inbox"></i> Kelola Pengaduan
            </a>
        </div>
    </div>

    <!-- Overview Stats -->
    <div class="overview-stats">
        <div class="stat-card total-card">
            <div class="stat-icon">
                <i class="fas fa-inbox"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label">Total Pengaduan</span>
                <span class="stat-value">{{ number_format($stats['total']) }}</span>
                <span class="stat-sublabel">Semua waktu</span>
            </div>
        </div>

        <div class="stat-card today-card">
            <div class="stat-icon">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label">Hari Ini</span>
                <span class="stat-value">{{ number_format($stats['today']) }}</span>
                <span class="stat-sublabel">{{ date('d M Y') }}</span>
            </div>
        </div>

        <div class="stat-card week-card">
            <div class="stat-icon">
                <i class="fas fa-calendar-week"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label">Minggu Ini</span>
                <span class="stat-value">{{ number_format($stats['this_week']) }}</span>
                <span class="stat-sublabel">7 hari terakhir</span>
            </div>
        </div>

        <div class="stat-card month-card">
            <div class="stat-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label">Bulan Ini</span>
                <span class="stat-value">{{ number_format($stats['this_month']) }}</span>
                <span class="stat-sublabel">{{ date('F Y') }}</span>
            </div>
        </div>
    </div>

    <div class="charts-grid">
        <!-- By Status -->
        <div class="chart-card">
            <div class="chart-header">
                <h2><i class="fas fa-tasks"></i> Status Pengaduan</h2>
            </div>
            <div class="chart-content">
                <canvas id="statusChart"></canvas>
            </div>
            <div class="chart-legend">
                @foreach($stats['by_status'] as $status => $count)
                <div class="legend-item">
                    <span class="legend-dot status-{{ $status }}"></span>
                    <span class="legend-label">
                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                    </span>
                    <span class="legend-value">{{ $count }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- By Priority -->
        <div class="chart-card">
            <div class="chart-header">
                <h2><i class="fas fa-exclamation-triangle"></i> Prioritas</h2>
            </div>
            <div class="chart-content">
                <canvas id="priorityChart"></canvas>
            </div>
            <div class="chart-legend">
                @foreach($stats['by_priority'] as $priority => $count)
                <div class="legend-item">
                    <span class="legend-dot priority-{{ $priority }}"></span>
                    <span class="legend-label">{{ ucfirst($priority) }}</span>
                    <span class="legend-value">{{ $count }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- By Service -->
    <div class="service-stats">
        <div class="chart-card full-width">
            <div class="chart-header">
                <h2><i class="fas fa-list"></i> Pengaduan per Layanan</h2>
            </div>
            <div class="service-grid">
                @foreach($stats['by_service'] as $item)
                <div class="service-item">
                    <div class="service-info">
                        <div class="service-icon" style="background: {{ $item->service->color }}20; color: {{ $item->service->color }};">
                            <i class="fas {{ $item->service->icon }}"></i>
                        </div>
                        <div class="service-details">
                            <strong>{{ $item->service->name }}</strong>
                            <span class="service-count">{{ $item->count }} pengaduan</span>
                        </div>
                    </div>
                    <div class="service-bar">
                        <div class="service-fill" 
                             style="width: {{ ($item->count / $stats['total']) * 100 }}%; background: {{ $item->service->color }};">
                        </div>
                    </div>
                    <div class="service-percentage">
                        {{ number_format(($item->count / $stats['total']) * 100, 1) }}%
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Performance Metrics -->
    <div class="metrics-grid">
        <div class="metric-card">
            <div class="metric-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="metric-content">
                <span class="metric-label">Rata-rata Waktu Penyelesaian</span>
                <span class="metric-value">
                    {{ $stats['avg_resolution_days'] ? number_format($stats['avg_resolution_days'], 1) : '0' }} hari
                </span>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="metric-content">
                <span class="metric-label">Tingkat Kepuasan</span>
                <span class="metric-value">
                    {{ $stats['satisfaction_rate'] ? number_format($stats['satisfaction_rate'], 1) : '0' }}/5.0
                </span>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon">
                <i class="fas fa-percentage"></i>
            </div>
            <div class="metric-content">
                <span class="metric-label">Tingkat Penyelesaian</span>
                <span class="metric-value">
                    {{ $stats['total'] > 0 ? number_format((($stats['by_status']['resolved'] ?? 0) / $stats['total']) * 100, 1) : 0 }}%
                </span>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div class="metric-content">
                <span class="metric-label">Pengaduan Pending</span>
                <span class="metric-value">
                    {{ ($stats['by_status']['submitted'] ?? 0) + ($stats['by_status']['verified'] ?? 0) + ($stats['by_status']['in_progress'] ?? 0) }}
                </span>
            </div>
        </div>
    </div>

    <!-- Recent Complaints -->
    <div class="recent-card">
        <div class="recent-header">
            <h2><i class="fas fa-history"></i> Pengaduan Terbaru</h2>
            <a href="{{ route('admin.complaints.index') }}" class="view-all">Lihat Semua <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="recent-list">
            @forelse($stats['recent_complaints'] as $complaint)
            <div class="recent-item">
                <div class="recent-left">
                    <div class="recent-icon status-{{ $complaint->status }}">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="recent-info">
                        <strong>{{ $complaint->ticket_number }}</strong>
                        <span class="recent-subject">{{ Str::limit($complaint->subject, 60) }}</span>
                        <div class="recent-meta">
                            <span><i class="fas fa-user"></i> {{ $complaint->reporter_name }}</span>
                            <span><i class="fas fa-list"></i> {{ $complaint->service->name }}</span>
                            <span><i class="fas fa-clock"></i> {{ $complaint->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                <div class="recent-right">
                    <span class="status-badge status-{{ $complaint->status }}">
                        {{ $complaint->status_label }}
                    </span>
                    <a href="{{ route('admin.complaints.show', $complaint->id) }}" class="btn-view">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <p>Belum ada pengaduan</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<style>
.dashboard-page {
    padding: 2rem;
    background: #f8fafc;
    min-height: 100vh;
}

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
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.subtitle {
    color: #64748b;
    font-size: 0.9375rem;
}

.btn {
    padding: 0.625rem 1.25rem;
    border-radius: 8px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
}

/* Overview Stats */
.overview-stats {
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
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}

.stat-icon {
    width: 70px;
    height: 70px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
}

.total-card .stat-icon { background: #dbeafe; color: #3b82f6; }
.today-card .stat-icon { background: #d1fae5; color: #10b981; }
.week-card .stat-icon { background: #e9d5ff; color: #8b5cf6; }
.month-card .stat-icon { background: #fef3c7; color: #f59e0b; }

.stat-content {
    display: flex;
    flex-direction: column;
}

.stat-label {
    font-size: 0.875rem;
    color: #64748b;
    margin-bottom: 0.25rem;
}

.stat-value {
    font-size: 2rem;
    font-weight: 800;
    color: #1e293b;
    line-height: 1;
    margin-bottom: 0.25rem;
}

.stat-sublabel {
    font-size: 0.8125rem;
    color: #94a3b8;
}

/* Charts Grid */
.charts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.chart-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    padding: 1.5rem;
}

.chart-card.full-width {
    grid-column: 1 / -1;
}

.chart-header {
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f1f5f9;
}

.chart-header h2 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.chart-content {
    margin-bottom: 1.5rem;
    min-height: 250px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.chart-legend {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 0.75rem;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.legend-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.legend-dot.status-submitted { background: #f59e0b; }
.legend-dot.status-verified { background: #3b82f6; }
.legend-dot.status-in_progress { background: #8b5cf6; }
.legend-dot.status-resolved { background: #10b981; }
.legend-dot.status-closed { background: #6b7280; }
.legend-dot.status-rejected { background: #ef4444; }

.legend-dot.priority-low { background: #10b981; }
.legend-dot.priority-medium { background: #f59e0b; }
.legend-dot.priority-high { background: #ef4444; }
.legend-dot.priority-urgent { background: #7f1d1d; }

.legend-label {
    flex: 1;
    font-size: 0.875rem;
    color: #64748b;
}

.legend-value {
    font-weight: 700;
    color: #1e293b;
}

/* Service Stats */
.service-stats {
    margin-bottom: 2rem;
}

.service-grid {
    display: grid;
    gap: 1.25rem;
}

.service-item {
    display: grid;
    grid-template-columns: 2fr 3fr auto;
    align-items: center;
    gap: 1.5rem;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 8px;
    transition: all 0.3s;
}

.service-item:hover {
    background: #f1f5f9;
    transform: translateX(4px);
}

.service-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.service-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.service-details {
    display: flex;
    flex-direction: column;
}

.service-details strong {
    color: #1e293b;
    font-size: 0.9375rem;
}

.service-count {
    font-size: 0.8125rem;
    color: #64748b;
}

.service-bar {
    height: 8px;
    background: #e2e8f0;
    border-radius: 4px;
    overflow: hidden;
}

.service-fill {
    height: 100%;
    border-radius: 4px;
    transition: width 0.5s ease;
}

.service-percentage {
    font-weight: 700;
    color: #475569;
    min-width: 50px;
    text-align: right;
}

/* Metrics Grid */
.metrics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.metric-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    display: flex;
    align-items: center;
    gap: 1rem;
    border-left: 4px solid #3b82f6;
}

.metric-icon {
    width: 60px;
    height: 60px;
    border-radius: 10px;
    background: #dbeafe;
    color: #3b82f6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
}

.metric-content {
    display: flex;
    flex-direction: column;
}

.metric-label {
    font-size: 0.875rem;
    color: #64748b;
    margin-bottom: 0.25rem;
}

.metric-value {
    font-size: 1.75rem;
    font-weight: 800;
    color: #1e293b;
}

/* Recent Card */
.recent-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    padding: 1.5rem;
}

.recent-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f1f5f9;
}

.recent-header h2 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.view-all {
    color: #3b82f6;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9375rem;
    display: flex;
    align-items: center;
    gap: 0.375rem;
    transition: all 0.3s;
}

.view-all:hover {
    gap: 0.625rem;
}

.recent-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.recent-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem;
    background: #f8fafc;
    border-radius: 10px;
    border-left: 4px solid #3b82f6;
    transition: all 0.3s;
}

.recent-item:hover {
    background: #f1f5f9;
    transform: translateX(4px);
}

.recent-left {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
}

.recent-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.recent-icon.status-submitted { background: #fef3c7; color: #92400e; }
.recent-icon.status-verified { background: #dbeafe; color: #1e40af; }
.recent-icon.status-in_progress { background: #e9d5ff; color: #6b21a8; }
.recent-icon.status-resolved { background: #d1fae5; color: #065f46; }

.recent-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.recent-info strong {
    font-family: 'Courier New', monospace;
    color: #3b82f6;
    font-size: 0.9375rem;
}

.recent-subject {
    color: #1e293b;
    font-weight: 600;
}

.recent-meta {
    display: flex;
    gap: 1rem;
    font-size: 0.8125rem;
    color: #94a3b8;
}

.recent-meta i {
    margin-right: 0.25rem;
}

.recent-right {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.status-badge {
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-size: 0.8125rem;
    font-weight: 600;
}

.status-badge.status-submitted { background: #fef3c7; color: #92400e; }
.status-badge.status-verified { background: #dbeafe; color: #1e40af; }
.status-badge.status-in_progress { background: #e9d5ff; color: #6b21a8; }
.status-badge.status-resolved { background: #d1fae5; color: #065f46; }
.status-badge.status-closed { background: #f1f5f9; color: #475569; }
.status-badge.status-rejected { background: #fee2e2; color: #991b1b; }

.btn-view {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: #dbeafe;
    color: #1e40af;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s;
}

.btn-view:hover {
    background: #3b82f6;
    color: white;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: #94a3b8;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

@media (max-width: 1024px) {
    .charts-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .dashboard-page {
        padding: 1rem;
    }
    
    .page-header {
        flex-direction: column;
        gap: 1rem;
    }
    
    .overview-stats {
        grid-template-columns: 1fr;
    }
    
    .service-item {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .service-percentage {
        text-align: left;
    }
    
    .recent-item {
        flex-direction: column;
        align-items: start;
        gap: 1rem;
    }
    
    .recent-right {
        width: 100%;
        justify-content: space-between;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Status Chart
const statusCtx = document.getElementById('statusChart').getContext('2d');
const statusChart = new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($stats['by_status']->keys()->map(fn($s) => ucfirst(str_replace('_', ' ', $s)))) !!},
        datasets: [{
            data: {!! json_encode($stats['by_status']->values()) !!},
            backgroundColor: [
                '#f59e0b', // submitted
                '#3b82f6', // verified
                '#8b5cf6', // in_progress
                '#10b981', // resolved
                '#6b7280', // closed
                '#ef4444'  // rejected
            ],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

// Priority Chart
const priorityCtx = document.getElementById('priorityChart').getContext('2d');
const priorityChart = new Chart(priorityCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($stats['by_priority']->keys()->map(fn($p) => ucfirst($p))) !!},
        datasets: [{
            data: {!! json_encode($stats['by_priority']->values()) !!},
            backgroundColor: [
                '#10b981', // low
                '#f59e0b', // medium
                '#ef4444', // high
                '#7f1d1d'  // urgent
            ],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
</script>

@endsection