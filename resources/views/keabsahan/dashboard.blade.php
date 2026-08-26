@extends('layouts.keabsahan')

@section('title', 'Dashboard - AKTALINK')
@section('page-title', 'Dashboard')
@section('page-description', 'Ringkasan permohonan layanan keabsahan')


@section('content')

{{-- ============================================
    STATISTICS CARDS
============================================ --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-icon" style="background: linear-gradient(135deg, #07573c, #0d8a5a);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <rect x="2" y="7" width="20" height="14" rx="2"/>
                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
            </svg>
        </div>
        <div class="stat-card-content">
            <span class="stat-card-value">{{ number_format($stats['total']) }}</span>
            <span class="stat-card-label">Total Permohonan</span>
        </div>
        <div class="stat-card-trend up">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
            </svg>
            100%
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
            </svg>
        </div>
        <div class="stat-card-content">
            <span class="stat-card-value">{{ number_format($stats['menunggu']) }}</span>
            <span class="stat-card-label">Perlu Diproses</span>
        </div>
        <div class="stat-card-trend neutral">
            {{ $percentages['menunggu'] }}%
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon" style="background: linear-gradient(135deg, #3b82f6, #60a5fa);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
            </svg>
        </div>
        <div class="stat-card-content">
            <span class="stat-card-value">{{ number_format($stats['proses']) }}</span>
            <span class="stat-card-label">Sedang Diproses</span>
        </div>
        <div class="stat-card-trend neutral">
            {{ $percentages['proses'] }}%
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon" style="background: linear-gradient(135deg, #059669, #34d399);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
        </div>
        <div class="stat-card-content">
            <span class="stat-card-value">{{ number_format($stats['selesai']) }}</span>
            <span class="stat-card-label">Selesai</span>
        </div>
        <div class="stat-card-trend up">
            {{ $percentages['selesai'] }}%
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon" style="background: linear-gradient(135deg, #ef4444, #f87171);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
        </div>
        <div class="stat-card-content">
            <span class="stat-card-value">{{ number_format($stats['kurang_lengkap']) }}</span>
            <span class="stat-card-label">Kurang Lengkap</span>
        </div>
        <div class="stat-card-trend down">
            {{ $percentages['kurang_lengkap'] }}%
        </div>
    </div>
</div>

{{-- ============================================
    TODAY STATS
============================================ --}}
<div class="today-stats">
    <div class="today-stat-item">
        <div class="today-stat-icon" style="background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
            </svg>
        </div>
        <div>
            <span class="today-stat-value">{{ $todayStats['hari_ini'] }}</span>
            <span class="today-stat-label">Hari Ini</span>
        </div>
    </div>
    <div class="today-stat-item">
        <div class="today-stat-icon" style="background: linear-gradient(135deg, #dbeafe, #93c5fd); color: #1e40af;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
                <path d="M8 14h.01"/>
                <path d="M12 14h.01"/>
                <path d="M16 14h.01"/>
                <path d="M8 18h.01"/>
                <path d="M12 18h.01"/>
                <path d="M16 18h.01"/>
            </svg>
        </div>
        <div>
            <span class="today-stat-value">{{ $todayStats['minggu_ini'] }}</span>
            <span class="today-stat-label">Minggu Ini</span>
        </div>
    </div>
    <div class="today-stat-item">
        <div class="today-stat-icon" style="background: linear-gradient(135deg, #fef3c7, #fde68a); color: #92400e;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
            </svg>
        </div>
        <div>
            <span class="today-stat-value">{{ $todayStats['bulan_ini'] }}</span>
            <span class="today-stat-label">Bulan Ini</span>
        </div>
    </div>
</div>

{{-- ============================================
    MAIN GRID
============================================ --}}
<div class="dashboard-grid">

    {{-- LEFT COLUMN --}}
    <div class="dashboard-left">

        {{-- PERMOHONAN TERBARU --}}
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <div class="card-header-left">
                    <div class="card-icon" style="background: #d1fae5; color: #065f46;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="7" width="20" height="14" rx="2"/>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                        </svg>
                    </div>
                    <span class="card-title">Permohonan Terbaru</span>
                </div>
                <a href="{{ route('keabsahan.permohonan.index') }}" class="card-link">
                    Lihat Semua →
                </a>
            </div>
            <div class="dashboard-card-body">
                @if($recentPermohonans->count() > 0)
                    @foreach($recentPermohonans as $permohonan)
                    <div class="recent-item">
                        <div class="recent-item-left">
                            <div class="recent-avatar">{{ Str::substr($permohonan->pemohon->nama_lengkap, 0, 2) }}</div>
                            <div class="recent-info">
                                <div class="recent-name">{{ $permohonan->pemohon->nama_lengkap }}</div>
                                <div class="recent-meta">
                                    <span class="recent-number">{{ $permohonan->nomor_permohonan }}</span>
                                    <span>•</span>
                                    <span>{{ $permohonan->jenisLayanan->nama_layanan }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="recent-item-right">
                            <span class="status-badge" style="background: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}20; color: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}">
                                <span class="status-dot" style="background: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}"></span>
                                {{ $permohonan->statusPermohonan->nama_status }}
                            </span>
                            <span class="recent-date">{{ $permohonan->created_at->setTimezone('Asia/Jakarta')->format('d M Y') }}</span>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="empty-state-dashboard">
                        <div class="empty-icon">📋</div>
                        <p>Belum ada permohonan</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- AKTIVITAS TERBARU --}}
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <div class="card-header-left">
                    <div class="card-icon" style="background: #ede9fe; color: #7c3aed;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </div>
                    <span class="card-title">Aktivitas Terbaru</span>
                </div>
            </div>
            <div class="dashboard-card-body">
                @if($recentActivities->count() > 0)
                    <div class="activity-timeline">
                        @foreach($recentActivities as $activity)
                        <div class="activity-item">
                            <div class="activity-dot" style="background: {{ $activity->statusBaru->warna ?? '#6c757d' }};"></div>
                            <div class="activity-content">
                                <div class="activity-text">
                                    <strong>{{ $activity->permohonan->pemohon->nama_lengkap }}</strong>
                                    → <span style="color: {{ $activity->statusBaru->warna ?? '#6c757d' }};">{{ $activity->statusBaru->nama_status }}</span>
                                    <span class="activity-number">({{ $activity->permohonan->nomor_permohonan }})</span>
                                </div>
                                <div class="activity-meta">
                                    <span>{{ $activity->changedBy->name ?? 'Sistem' }}</span>
                                    <span>•</span>
                                    <span>{{ $activity->changed_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}</span>
                                </div>
                                @if($activity->keterangan)
                                <div class="activity-note">{{ $activity->keterangan }}</div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state-dashboard">
                        <div class="empty-icon">🔄</div>
                        <p>Belum ada aktivitas</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- RIGHT COLUMN --}}
    <div class="dashboard-right">

        {{-- STATUS DISTRIBUSI --}}
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <div class="card-header-left">
                    <div class="card-icon" style="background: #fef3c7; color: #92400e;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M12 6v6l4 2"/>
                        </svg>
                    </div>
                    <span class="card-title">Status Distribusi</span>
                </div>
            </div>
            <div class="dashboard-card-body">
                @if(count($statusDistribution) > 0)
                    <div class="status-distribution">
                        @foreach($statusDistribution as $status)
                        <div class="status-dist-item">
                            <div class="status-dist-left">
                                <span class="status-dist-dot" style="background: {{ $status['warna'] }};"></span>
                                <span class="status-dist-name">{{ $status['status'] }}</span>
                            </div>
                            <div class="status-dist-right">
                                <span class="status-dist-count">{{ $status['count'] }}</span>
                                <div class="status-dist-bar-wrap">
                                    <div class="status-dist-bar" style="width: {{ $stats['total'] > 0 ? round(($status['count'] / $stats['total']) * 100) : 0 }}%; background: {{ $status['warna'] }};"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state-dashboard">
                        <div class="empty-icon">📊</div>
                        <p>Belum ada data</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- QUICK ACTION --}}
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <div class="card-header-left">
                    <div class="card-icon" style="background: #fce4ec; color: #c62828;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>
                    <span class="card-title">Akses Cepat</span>
                </div>
            </div>
            <div class="dashboard-card-body">
                <div class="quick-actions">
                    <a href="{{ route('keabsahan.permohonan.index') }}" class="quick-action-item" style="background: linear-gradient(135deg, #d1fae5, #a7f3d0);">
                        
                        <span class="quick-label">Semua Permohonan</span>
                    </a>
                    <a href="{{ route('keabsahan.permohonan.diproses') }}" class="quick-action-item" style="background: linear-gradient(135deg, #fef3c7, #fde68a);">
                        
                        <span class="quick-label">Perlu Diproses</span>
                        @if($stats['menunggu'] > 0)
                        <span class="quick-badge">{{ $stats['menunggu'] }}</span>
                        @endif
                    </a>
                    <a href="{{ route('keabsahan.permohonan.sedang-diproses') }}" class="quick-action-item" style="background: linear-gradient(135deg, #dbeafe, #93c5fd);">
                        
                        <span class="quick-label">Sedang Diproses</span>
                        @if($stats['proses'] > 0)
                        <span class="quick-badge">{{ $stats['proses'] }}</span>
                        @endif
                    </a>
                    <a href="{{ route('keabsahan.permohonan.selesai') }}" class="quick-action-item" style="background: linear-gradient(135deg, #d1fae5, #6ee7b7);">
                        
                        <span class="quick-label">Selesai</span>
                        @if($stats['selesai'] > 0)
                        <span class="quick-badge">{{ $stats['selesai'] }}</span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============================================
    TOAST
============================================ --}}
<div id="toastContainer"></div>

@endsection

@push('styles')
<style>
/* ============================================
   STATS GRID
============================================ */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 16px;
    margin-bottom: 16px;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 20px 24px;
    display: flex;
    align-items: center;
    gap: 16px;
    border: 1px solid #f0f2f1;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
}

.stat-card-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.stat-card-content {
    flex: 1;
}

.stat-card-value {
    display: block;
    font-size: 22px;
    font-weight: 800;
    color: #1d2b27;
}

.stat-card-label {
    display: block;
    font-size: 11px;
    font-weight: 500;
    color: #8a9a94;
    margin-top: 2px;
}

.stat-card-trend {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
}

.stat-card-trend.up {
    color: #059669;
    background: #d1fae5;
}

.stat-card-trend.down {
    color: #dc2626;
    background: #fde8e8;
}

.stat-card-trend.neutral {
    color: #6b7280;
    background: #f3f4f6;
}

/* ============================================
   TODAY STATS
============================================ */
.today-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}

.today-stat-item {
    background: white;
    border-radius: 12px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    border: 1px solid #f0f2f1;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    transition: all 0.3s ease;
}

.today-stat-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
}

.today-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.today-stat-icon svg {
    width: 22px;
    height: 22px;
}

.today-stat-value {
    display: block;
    font-size: 20px;
    font-weight: 800;
    color: #1d2b27;
    line-height: 1.2;
}

.today-stat-label {
    display: block;
    font-size: 12px;
    color: #8a9a94;
    font-weight: 500;
}

/* ============================================
   DASHBOARD GRID
============================================ */
.dashboard-grid {
    display: grid;
    grid-template-columns: 1.6fr 1fr;
    gap: 24px;
}

.dashboard-left,
.dashboard-right {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

/* ============================================
   DASHBOARD CARD
============================================ */
.dashboard-card {
    background: white;
    border-radius: 16px;
    border: 1px solid #f0f2f1;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}

.dashboard-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    border-bottom: 1px solid #f0f2f1;
    background: #fafcfb;
}

.card-header-left {
    display: flex;
    align-items: center;
    gap: 10px;
}

.card-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.card-title {
    font-weight: 700;
    font-size: 14px;
    color: #1d2b27;
}

.card-link {
    font-size: 12px;
    font-weight: 600;
    color: #07573c;
    text-decoration: none;
    transition: color 0.3s ease;
}

.card-link:hover {
    color: #043d2a;
    text-decoration: underline;
}

.dashboard-card-body {
    padding: 16px 20px;
}

/* ============================================
   RECENT ITEMS
============================================ */
.recent-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #f5f7f6;
}

.recent-item:last-child {
    border-bottom: none;
}

.recent-item-left {
    display: flex;
    align-items: center;
    gap: 12px;
}

.recent-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, #e8f0ed, #c5d9d0);
    color: #07573c;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 700;
    flex-shrink: 0;
}

.recent-name {
    font-weight: 600;
    font-size: 13px;
    color: #1d2b27;
}

.recent-meta {
    font-size: 11px;
    color: #8a9a94;
    display: flex;
    align-items: center;
    gap: 4px;
}

.recent-number {
    font-weight: 600;
    color: #07573c;
}

.recent-item-right {
    display: flex;
    align-items: center;
    gap: 10px;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3px 12px;
    border-radius: 16px;
    font-size: 11px;
    font-weight: 600;
}

.status-dot {
    width: 5px;
    height: 5px;
    border-radius: 50%;
    display: inline-block;
}

.recent-date {
    font-size: 11px;
    color: #8a9a94;
}

/* ============================================
   ACTIVITY TIMELINE
============================================ */
.activity-timeline {
    position: relative;
    padding-left: 20px;
}

.activity-timeline::before {
    content: '';
    position: absolute;
    left: 4px;
    top: 4px;
    bottom: 4px;
    width: 2px;
    background: #e9ecef;
}

.activity-item {
    position: relative;
    padding-bottom: 16px;
}

.activity-item:last-child {
    padding-bottom: 0;
}

.activity-dot {
    position: absolute;
    left: -16px;
    top: 4px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 0 0 2px #e9ecef;
}

.activity-text {
    font-size: 13px;
    color: #1d2b27;
}

.activity-text strong {
    font-weight: 600;
}

.activity-number {
    font-size: 11px;
    color: #8a9a94;
    font-weight: 500;
}

.activity-meta {
    font-size: 11px;
    color: #8a9a94;
    margin-top: 2px;
    display: flex;
    align-items: center;
    gap: 4px;
}

.activity-note {
    margin-top: 4px;
    padding: 4px 10px;
    background: #f5f7f6;
    border-radius: 6px;
    font-size: 12px;
    color: #4a5a54;
}

/* ============================================
   STATUS DISTRIBUTION
============================================ */
.status-distribution {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.status-dist-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}

.status-dist-left {
    display: flex;
    align-items: center;
    gap: 8px;
    min-width: 120px;
}

.status-dist-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
}

.status-dist-name {
    font-size: 13px;
    font-weight: 500;
    color: #1d2b27;
}

.status-dist-right {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 12px;
}

.status-dist-count {
    font-size: 13px;
    font-weight: 700;
    color: #1d2b27;
    min-width: 30px;
    text-align: right;
}

.status-dist-bar-wrap {
    flex: 1;
    height: 6px;
    background: #f0f2f1;
    border-radius: 4px;
    overflow: hidden;
}

.status-dist-bar {
    height: 100%;
    border-radius: 4px;
    transition: width 1s ease;
}

/* ============================================
   QUICK ACTIONS
============================================ */
.quick-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

.quick-action-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 16px;
    border-radius: 12px;
    text-decoration: none;
    color: #1d2b27;
    transition: all 0.3s ease;
    position: relative;
    cursor: pointer;
    border: none;
    width: 100%;
    text-align: left;
    font-family: inherit;
    font-size: inherit;
}

.quick-action-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
}

.quick-icon {
    font-size: 20px;
}

.quick-label {
    font-size: 13px;
    font-weight: 600;
}

.quick-badge {
    position: absolute;
    top: -4px;
    right: -4px;
    padding: 2px 8px;
    background: #dc2626;
    color: white;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 700;
    min-width: 20px;
    text-align: center;
}

/* ============================================
   EMPTY STATE
============================================ */
.empty-state-dashboard {
    text-align: center;
    padding: 30px 20px;
}

.empty-state-dashboard .empty-icon {
    font-size: 40px;
    margin-bottom: 8px;
}

.empty-state-dashboard p {
    color: #8a9a94;
    font-size: 13px;
}

/* ============================================
   BUTTONS
============================================ */
.btn-outline {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: transparent;
    color: #4a5a54;
    border: 1.5px solid #dce2e0;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-outline:hover {
    background: #f0f5f2;
    border-color: #07573c;
    color: #07573c;
    transform: translateY(-2px);
}

/* ============================================
   TOAST
============================================ */
#toastContainer {
    position: fixed;
    bottom: 24px;
    right: 24px;
    z-index: 999999;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
}

.toast {
    padding: 14px 20px;
    border-radius: 12px;
    color: white;
    font-size: 14px;
    font-weight: 500;
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    min-width: 280px;
    max-width: 420px;
    margin-bottom: 8px;
    animation: slideIn 0.3s ease;
}

.toast-success { background: #059669; }
.toast-error { background: #dc2626; }
.toast-info { background: #2563eb; }

@keyframes slideIn {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

/* ============================================
   RESPONSIVE
============================================ */
@media (max-width: 1200px) {
    .stats-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 992px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr 1fr;
    }

    .today-stats {
        grid-template-columns: 1fr;
    }

    .stat-card {
        padding: 16px;
    }

    .quick-actions {
        grid-template-columns: 1fr;
    }

    .status-dist-item {
        flex-wrap: wrap;
    }

    .recent-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }

    .recent-item-right {
        width: 100%;
        justify-content: space-between;
    }
}

@media (max-width: 480px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }

    .stat-card-value {
        font-size: 18px;
    }

    .dashboard-card-header {
        flex-wrap: wrap;
        gap: 8px;
    }

    .today-stat-icon {
        width: 40px;
        height: 40px;
    }

    .today-stat-icon svg {
        width: 18px;
        height: 18px;
    }
}
</style>
@endpush

@push('scripts')
<script>
// ============================================
// TOAST
// ============================================
function showToast(message, type = 'success') {
    const container = document.getElementById('toastContainer');
    if (!container) {
        const newContainer = document.createElement('div');
        newContainer.id = 'toastContainer';
        newContainer.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:999999;display:flex;flex-direction:column;align-items:flex-end;';
        document.body.appendChild(newContainer);
    }
    const toastContainer = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.textContent = message;
    toastContainer.appendChild(toast);
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.3s';
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}

// ============================================
// ANIMASI BAR
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.status-dist-bar').forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0%';
        setTimeout(() => {
            bar.style.width = width;
        }, 300);
    });

    // Toast dari session
    @if(session('success'))
        showToast('{{ session('success') }}', 'success');
    @endif
    @if(session('error'))
        showToast('{{ session('error') }}', 'error');
    @endif
});

console.log('✅ Keabsahan Dashboard loaded successfully');
</script>
@endpush