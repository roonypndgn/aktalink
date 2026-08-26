@extends('layouts.app')

@section('title', 'Dashboard - AKTALINK')
@section('page-title', 'Dashboard')
@section('page-description', 'Selamat datang! Berikut ringkasan sistem AKTALINK')

@section('page-actions')
    <button type="button" class="btn-outline" onclick="window.location.reload()">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="23 4 23 10 17 10"/>
            <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
        </svg>
        Refresh
    </button>
@endsection

@section('content')

{{-- ============================================
    GREETING SECTION
============================================ --}}
<div class="greeting-section">
    <div class="greeting-content">
        <div class="greeting-text">
            <h2>Selamat Datang!</h2>
            <p>Berikut adalah ringkasan aktivitas sistem AKTALINK hari ini.</p>
        </div>
        <div class="greeting-date">
            <span class="date-badge">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                {{ now()->format('l, d F Y') }}
            </span>
            <span class="time-badge">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
                {{ now()->setTimezone('Asia/Jakarta')->format('H:i') }} WIB
            </span>
        </div>
    </div>
</div>

{{-- ============================================
    STATISTIK HARI INI
============================================ --}}
<div class="stats-today">
    <div class="stats-today-card">
        <div class="stats-today-icon" style="background: linear-gradient(135deg, #07573c, #0d8a5a);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/>
                <line x1="16" y1="17" x2="8" y2="17"/>
            </svg>
        </div>
        <div class="stats-today-content">
            <span class="stats-today-value">{{ number_format($hariIni['permohonan']) }}</span>
            <span class="stats-today-label">Permohonan Hari Ini</span>
        </div>
        <div class="stats-today-trend {{ $persentase >= 0 ? 'up' : 'down' }}">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="{{ $persentase >= 0 ? '23 6 13.5 15.5 8.5 10.5 1 18' : '23 18 13.5 8.5 8.5 13.5 1 6' }}"/>
                <polyline points="{{ $persentase >= 0 ? '17 6 23 6 23 12' : '17 18 23 18 23 12' }}"/>
            </svg>
            {{ abs($persentase) }}%
        </div>
    </div>

    <div class="stats-today-card">
        <div class="stats-today-icon" style="background: linear-gradient(135deg, #3b82f6, #60a5fa);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
        </div>
        <div class="stats-today-content">
            <span class="stats-today-value">{{ number_format($hariIni['pemohon']) }}</span>
            <span class="stats-today-label">Pemohon Baru</span>
        </div>
        <div class="stats-today-trend neutral">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            -
        </div>
    </div>

    <div class="stats-today-card">
        <div class="stats-today-icon" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
            </svg>
        </div>
        <div class="stats-today-content">
            <span class="stats-today-value">{{ number_format($hariIni['aktivitas']) }}</span>
            <span class="stats-today-label">Aktivitas Hari Ini</span>
        </div>
        <div class="stats-today-trend neutral">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            -
        </div>
    </div>

    <div class="stats-today-card">
        <div class="stats-today-icon" style="background: linear-gradient(135deg, #059669, #34d399);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
        </div>
        <div class="stats-today-content">
            <span class="stats-today-value">{{ number_format($hariIni['selesai']) }}</span>
            <span class="stats-today-label">Permohonan Selesai</span>
        </div>
        <div class="stats-today-trend up">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                <polyline points="17 6 23 6 23 12"/>
            </svg>
            {{ $hariIni['permohonan'] > 0 ? round(($hariIni['selesai'] / max(1, $hariIni['permohonan'])) * 100) : 0 }}%
        </div>
    </div>
</div>

{{-- ============================================
    HERO STATISTICS UTAMA
============================================ --}}
<div class="hero-stats">
    <div class="hero-stat">
        <div class="hero-stat-icon" style="background: linear-gradient(135deg, #07573c, #0d8a5a);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/>
                <line x1="16" y1="17" x2="8" y2="17"/>
            </svg>
        </div>
        <div class="hero-stat-content">
            <span class="hero-stat-value">{{ number_format($stats['total_permohonan']) }}</span>
            <span class="hero-stat-label">Total Permohonan</span>
        </div>
        <div class="hero-stat-trend up">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                <polyline points="17 6 23 6 23 12"/>
            </svg>
            100%
        </div>
    </div>

    <div class="hero-stat">
        <div class="hero-stat-icon" style="background: linear-gradient(135deg, #3b82f6, #60a5fa);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
        </div>
        <div class="hero-stat-content">
            <span class="hero-stat-value">{{ number_format($stats['total_pemohon']) }}</span>
            <span class="hero-stat-label">Total Pemohon</span>
        </div>
        <div class="hero-stat-trend neutral">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            -
        </div>
    </div>

    <div class="hero-stat">
        <div class="hero-stat-icon" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                <polyline points="9 12 11 14 15 10"/>
            </svg>
        </div>
        <div class="hero-stat-content">
            <span class="hero-stat-value">{{ number_format($stats['total_petugas']) }}</span>
            <span class="hero-stat-label">Total Petugas</span>
        </div>
        <div class="hero-stat-trend neutral">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            -
        </div>
    </div>

    <div class="hero-stat">
        <div class="hero-stat-icon" style="background: linear-gradient(135deg, #8b5cf6, #a78bfa);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
        </div>
        <div class="hero-stat-content">
            <span class="hero-stat-value">{{ number_format($stats['total_admin']) }}</span>
            <span class="hero-stat-label">Administrator</span>
        </div>
        <div class="hero-stat-trend neutral">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            -
        </div>
    </div>
</div>

{{-- ============================================
    CHART SECTION
============================================ --}}
<div class="chart-grid">
    {{-- Status Chart --}}
    <div class="chart-card">
        <div class="chart-header">
            <h5 class="chart-title">Status Permohonan</h5>
            <span class="chart-badge">Real-time</span>
        </div>
        <div class="chart-body">
            @if($statusStats->sum('total') > 0)
                <div class="status-chart">
                    @foreach($statusStats as $status)
                    <div class="status-bar-item">
                        <div class="status-bar-label">
                            <span class="status-dot" style="background: {{ $status['warna'] }}"></span>
                            <span>{{ $status['nama'] }}</span>
                            <span class="status-bar-count">{{ $status['total'] }}</span>
                        </div>
                        <div class="status-bar-track">
                            <div class="status-bar-fill" 
                                 style="width: {{ $status['total'] > 0 ? ($status['total'] / max(1, $statusStats->sum('total'))) * 100 : 0 }}%; 
                                        background: {{ $status['warna'] }}">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center text-muted py-3">
                    <p>Belum ada data permohonan</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Layanan Chart --}}
    <div class="chart-card">
        <div class="chart-header">
            <h5 class="chart-title">Top 5 Layanan</h5>
            <span class="chart-badge">Populer</span>
        </div>
        <div class="chart-body">
            @if($layananStats->sum('total') > 0)
                <div class="layanan-chart">
                    @foreach($layananStats as $layanan)
                    <div class="layanan-item">
                        <div class="layanan-info">
                            <span class="layanan-name">{{ Str::limit($layanan['nama'], 25) }}</span>
                            <span class="layanan-count">{{ $layanan['total'] }}</span>
                        </div>
                        <div class="layanan-bar">
                            <div class="layanan-fill" 
                                 style="width: {{ $layanan['total'] > 0 ? ($layanan['total'] / max(1, $layananStats->sum('total'))) * 100 : 0 }}%; 
                                        background: {{ ['#07573c', '#2563eb', '#f59e0b', '#8b5cf6', '#ef4444'][$loop->index] ?? '#6b7280' }}">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center text-muted py-3">
                    <p>Belum ada data permohonan</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Tren Chart --}}
    <div class="chart-card full-width">
        <div class="chart-header">
            <h5 class="chart-title">Tren Permohonan 6 Bulan Terakhir</h5>
            <span class="chart-badge">Grafik</span>
        </div>
        <div class="chart-body">
            @if($bulanan->isNotEmpty())
                <div class="tren-chart">
                    @foreach($bulanan as $item)
                    <div class="tren-item">
                        <div class="tren-bar">
                            <div class="tren-fill" 
                                 style="height: {{ $item['total'] > 0 ? ($item['total'] / max(1, $bulanan->max('total'))) * 100 : 0 }}%; 
                                        background: linear-gradient(180deg, #07573c, #0d8a5a)">
                                <span class="tren-value">{{ $item['total'] }}</span>
                            </div>
                        </div>
                        <span class="tren-label">{{ $item['bulan'] }}</span>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center text-muted py-3">
                    <p>Belum ada data untuk ditampilkan</p>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- ============================================
    RECENT ACTIVITIES
============================================ --}}
<div class="recent-grid">
    {{-- Permohonan Terbaru --}}
    <div class="recent-card">
        <div class="recent-header">
            <h5 class="recent-title">Permohonan Terbaru</h5>
            <a href="{{ route('admin.permohonan.index') }}" class="recent-link">
                Lihat Semua
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </a>
        </div>
        <div class="recent-body">
            @forelse($permohonanTerbaru as $permohonan)
            <div class="recent-item">
                <div class="recent-item-icon" style="background: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}20; color: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                    </svg>
                </div>
                <div class="recent-item-content">
                    <div class="recent-item-title">{{ $permohonan->nomor_permohonan }}</div>
                    <div class="recent-item-sub">
                        {{ $permohonan->pemohon->nama_lengkap }} • 
                        {{ $permohonan->jenisLayanan->nama_layanan }}
                    </div>
                </div>
                <div class="recent-item-time">
                    <span class="status-badge-sm" style="background: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}20; color: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}">
                        {{ $permohonan->statusPermohonan->nama_status }}
                    </span>
                </div>
            </div>
            @empty
            <div class="text-center text-muted py-3">
                <p>Belum ada permohonan</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Aktivitas Terbaru --}}
    <div class="recent-card">
        <div class="recent-body">
            @forelse($aktivitasTerbaru as $aktivitas)
            <div class="recent-item">
                <div class="recent-item-icon" style="background: #dbeafe; color: #2563eb;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <div class="recent-item-content">
                    <div class="recent-item-title">{{ $aktivitas->aktivitas }}</div>
                    <div class="recent-item-sub">
                        {{ $aktivitas->user?->name ?? 'System' }} • 
                        {{ $aktivitas->created_at->diffForHumans() }}
                    </div>
                </div>
                <div class="recent-item-time">
                    <span class="time-sm">{{ $aktivitas->created_at->format('H:i') }}</span>
                </div>
            </div>
            @empty
            <div class="text-center text-muted py-3">
                <p>Belum ada aktivitas</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- ============================================
    QUICK ACTIONS
============================================ --}}
<div class="quick-actions">
    <h5 class="quick-title">⚡ Akses Cepat</h5>
    <div class="quick-grid">
        <a href="{{ route('admin.permohonan.index') }}" class="quick-item">
            <div class="quick-icon" style="background: #d1fae5; color: #065f46;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
            </div>
            <span>Data Permohonan</span>
        </a>
        <a href="{{ route('admin.pemohon.index') }}" class="quick-item">
            <div class="quick-icon" style="background: #dbeafe; color: #2563eb;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <span>Data Pemohon</span>
        </a>
        <a href="{{ route('admin.laporan.index') }}" class="quick-item">
            <div class="quick-icon" style="background: #fef3c7; color: #92400e;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 12v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h7"/>
                    <polyline points="15 3 21 3 21 9"/>
                    <line x1="9" y1="15" x2="15" y2="9"/>
                </svg>
            </div>
            <span>Laporan</span>
        </a>
        <a href="{{ route('admin.users.index') }}" class="quick-item">
            <div class="quick-icon" style="background: #fce7f3; color: #db2777;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <span>Kelola Pengguna</span>
        </a>
        <a href="{{ route('admin.jenis-layanan.index') }}" class="quick-item">
            <div class="quick-icon" style="background: #e0e7ff; color: #4338ca;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"/>
                    <rect x="14" y="3" width="7" height="7"/>
                    <rect x="3" y="14" width="7" height="7"/>
                    <rect x="14" y="14" width="7" height="7"/>
                </svg>
            </div>
            <span>Jenis Layanan</span>
        </a>
    </div>
</div>

@endsection

@push('styles')
<style>
/* ============================================
   GREETING SECTION
============================================ */
.greeting-section {
    background: linear-gradient(135deg, #07573c, #0d8a5a);
    border-radius: 16px;
    padding: 24px 32px;
    margin-bottom: 24px;
    color: white;
    position: relative;
    overflow: hidden;
}

.greeting-section::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
}

.greeting-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    z-index: 1;
    flex-wrap: wrap;
    gap: 12px;
}

.greeting-text h2 {
    font-size: 22px;
    font-weight: 700;
    margin: 0;
}

.greeting-text p {
    font-size: 14px;
    opacity: 0.85;
    margin: 4px 0 0;
}

.greeting-date {
    display: flex;
    gap: 12px;
}

.date-badge,
.time-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    background: rgba(255,255,255,0.15);
    border-radius: 10px;
    font-size: 13px;
    font-weight: 500;
    backdrop-filter: blur(4px);
}

/* ============================================
   STATS TODAY
============================================ */
.stats-today {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}

.stats-today-card {
    background: white;
    border-radius: 16px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    border: 1px solid #f0f2f1;
    transition: all 0.3s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}

.stats-today-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
}

.stats-today-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.stats-today-content {
    flex: 1;
}

.stats-today-value {
    display: block;
    font-size: 20px;
    font-weight: 800;
    color: #1d2b27;
    line-height: 1.2;
}

.stats-today-label {
    font-size: 11px;
    font-weight: 500;
    color: #8a9a94;
}

.stats-today-trend {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 16px;
    flex-shrink: 0;
}

.stats-today-trend.up {
    color: #059669;
    background: #d1fae5;
}

.stats-today-trend.down {
    color: #dc2626;
    background: #fde8e8;
}

.stats-today-trend.neutral {
    color: #6b7280;
    background: #f3f4f6;
}

/* ============================================
   HERO STATS
============================================ */
.hero-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}

.hero-stat {
    background: white;
    border-radius: 16px;
    padding: 18px 22px;
    display: flex;
    align-items: center;
    gap: 14px;
    border: 1px solid #f0f2f1;
    transition: all 0.3s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}

.hero-stat:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
}

.hero-stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.hero-stat-content {
    flex: 1;
}

.hero-stat-value {
    display: block;
    font-size: 20px;
    font-weight: 800;
    color: #1d2b27;
    line-height: 1.2;
}

.hero-stat-label {
    font-size: 11px;
    font-weight: 500;
    color: #8a9a94;
}

.hero-stat-trend {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 16px;
    flex-shrink: 0;
}

.hero-stat-trend.up {
    color: #059669;
    background: #d1fae5;
}

.hero-stat-trend.down {
    color: #dc2626;
    background: #fde8e8;
}

.hero-stat-trend.neutral {
    color: #6b7280;
    background: #f3f4f6;
}

/* ============================================
   CHART SECTION
============================================ */
.chart-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 24px;
}

.chart-card {
    background: white;
    border-radius: 16px;
    border: 1px solid #f0f2f1;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    overflow: hidden;
}

.chart-card.full-width {
    grid-column: 1 / -1;
}

.chart-header {
    padding: 14px 20px;
    border-bottom: 1px solid #f0f2f1;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chart-title {
    font-size: 14px;
    font-weight: 700;
    color: #1d2b27;
    margin: 0;
}

.chart-badge {
    font-size: 10px;
    font-weight: 600;
    padding: 2px 12px;
    border-radius: 12px;
    background: #f0f5f2;
    color: #6c7a75;
}

.chart-body {
    padding: 14px 20px;
}

/* Status Chart */
.status-chart {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.status-bar-item {
    display: flex;
    flex-direction: column;
    gap: 3px;
}

.status-bar-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    font-weight: 500;
    color: #4a5a54;
}

.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
}

.status-bar-count {
    margin-left: auto;
    font-weight: 700;
    color: #1d2b27;
}

.status-bar-track {
    width: 100%;
    height: 6px;
    background: #f0f5f2;
    border-radius: 10px;
    overflow: hidden;
}

.status-bar-fill {
    height: 100%;
    border-radius: 10px;
    transition: width 0.8s ease;
}

/* Layanan Chart */
.layanan-chart {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.layanan-item {
    display: flex;
    flex-direction: column;
    gap: 3px;
}

.layanan-info {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    font-weight: 500;
    color: #4a5a54;
}

.layanan-count {
    font-weight: 700;
    color: #1d2b27;
}

.layanan-bar {
    width: 100%;
    height: 6px;
    background: #f0f5f2;
    border-radius: 10px;
    overflow: hidden;
}

.layanan-fill {
    height: 100%;
    border-radius: 10px;
    transition: width 0.8s ease;
}

/* Tren Chart */
.tren-chart {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    height: 160px;
    padding-top: 16px;
}

.tren-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    flex: 1;
}

.tren-bar {
    width: 28px;
    height: 120px;
    background: #f0f5f2;
    border-radius: 6px 6px 0 0;
    position: relative;
    display: flex;
    align-items: flex-end;
    justify-content: center;
}

.tren-fill {
    width: 100%;
    border-radius: 6px 6px 0 0;
    transition: height 0.8s ease;
    position: relative;
    min-height: 6px;
}

.tren-value {
    position: absolute;
    top: -18px;
    font-size: 10px;
    font-weight: 700;
    color: #07573c;
}

.tren-label {
    font-size: 10px;
    font-weight: 600;
    color: #8a9a94;
}

/* ============================================
   RECENT ACTIVITIES
============================================ */
.recent-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 24px;
}

.recent-card {
    background: white;
    border-radius: 16px;
    border: 1px solid #f0f2f1;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    overflow: hidden;
}

.recent-header {
    padding: 14px 20px;
    border-bottom: 1px solid #f0f2f1;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.recent-title {
    font-size: 14px;
    font-weight: 700;
    color: #1d2b27;
    margin: 0;
}

.recent-link {
    font-size: 12px;
    font-weight: 600;
    color: #07573c;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 4px;
    transition: all 0.2s ease;
}

.recent-link:hover {
    color: #043d2a;
    gap: 8px;
}

.recent-body {
    padding: 4px 0;
}

.recent-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 20px;
    border-bottom: 1px solid #f5f7f6;
    transition: background 0.2s ease;
}

.recent-item:hover {
    background: #fafcfb;
}

.recent-item:last-child {
    border-bottom: none;
}

.recent-item-icon {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.recent-item-content {
    flex: 1;
    min-width: 0;
}

.recent-item-title {
    font-size: 13px;
    font-weight: 600;
    color: #1d2b27;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.recent-item-sub {
    font-size: 11px;
    color: #8a9a94;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.recent-item-time {
    flex-shrink: 0;
}

.status-badge-sm {
    display: inline-block;
    padding: 2px 10px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 600;
}

.time-sm {
    font-size: 11px;
    color: #8a9a94;
}

/* ============================================
   QUICK ACTIONS
============================================ */
.quick-actions {
    background: white;
    border-radius: 16px;
    border: 1px solid #f0f2f1;
    padding: 20px 24px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}

.quick-title {
    font-size: 14px;
    font-weight: 700;
    color: #1d2b27;
    margin: 0 0 16px;
}

.quick-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 12px;
}

.quick-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 16px 12px;
    border-radius: 12px;
    border: 1px solid #f0f2f1;
    text-decoration: none;
    color: #1d2b27;
    transition: all 0.3s ease;
    background: white;
}

.quick-item:hover {
    transform: translateY(-3px);
    border-color: #07573c;
    box-shadow: 0 8px 25px rgba(7, 87, 60, 0.08);
}

.quick-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.quick-item span {
    font-size: 12px;
    font-weight: 600;
    text-align: center;
}

/* ============================================
   BUTTONS
============================================ */
.btn-outline {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 9px 16px;
    background: transparent;
    color: #4a5a54;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    transition: all 0.3s ease;
    gap: 6px;
}

.btn-outline:hover {
    background: #f0f5f2;
    border-color: #c5ceca;
}

/* ============================================
   TEXT UTILITY
============================================ */
.text-center { text-align: center; }
.text-muted { color: #8a9a94; }
.py-3 { padding-top: 12px; padding-bottom: 12px; }

/* ============================================
   RESPONSIVE
============================================ */
@media (max-width: 1200px) {
    .hero-stats { grid-template-columns: repeat(2, 1fr); }
    .stats-today { grid-template-columns: repeat(2, 1fr); }
    .chart-grid { grid-template-columns: 1fr; }
    .recent-grid { grid-template-columns: 1fr; }
    .quick-grid { grid-template-columns: repeat(3, 1fr); }
}

@media (max-width: 768px) {
    .greeting-content {
        flex-direction: column;
        align-items: flex-start;
    }
    .greeting-date {
        flex-wrap: wrap;
    }
    .hero-stats { grid-template-columns: 1fr; }
    .stats-today { grid-template-columns: 1fr; }
    .quick-grid { grid-template-columns: repeat(2, 1fr); }
    .greeting-section {
        padding: 16px 20px;
    }
    .greeting-text h2 {
        font-size: 18px;
    }
}

@media (max-width: 480px) {
    .quick-grid { grid-template-columns: 1fr 1fr; }
    .hero-stat { padding: 14px 16px; }
    .stats-today-card { padding: 14px 16px; }
    .greeting-text h2 { font-size: 16px; }
    .greeting-text p { font-size: 12px; }
}
</style>
@endpush