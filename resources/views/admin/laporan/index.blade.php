@extends('layouts.app')

@section('title', 'Laporan - AKTALINK')
@section('page-title', 'Laporan & Statistik')
@section('page-description', 'Pantau kinerja dan statistik permohonan secara real-time')

@section('page-actions')
    <button type="button" class="btn-pdf" onclick="exportPdf()">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <line x1="12" y1="18" x2="12" y2="12"/>
            <polyline points="9 15 12 18 15 15"/>
        </svg>
        Export PDF
    </button>
    <button type="button" class="btn-outline" onclick="window.print()">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="6 9 6 2 18 2 18 9"/>
            <path d="M18 9H6M18 9a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-4a2 2 0 0 1 2-2"/>
            <rect x="8" y="14" width="8" height="6" rx="1"/>
        </svg>
    </button>
@endsection

@section('content')

{{-- ============================================
    HERO STATISTICS
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
            +{{ $stats['total_permohonan'] > 0 ? round(($stats['total_permohonan'] / max(1, $stats['total_permohonan'] - 10)) * 100) : 0 }}%
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
            <span class="chart-badge">Update terkini</span>
        </div>
        <div class="chart-body">
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
        </div>
    </div>

    {{-- Layanan Chart --}}
    <div class="chart-card">
        <div class="chart-header">
            <h5 class="chart-title">Jenis Layanan</h5>
            <span class="chart-badge">Populer</span>
        </div>
        <div class="chart-body">
            <div class="layanan-chart">
                @foreach($layananStats as $layanan)
                <div class="layanan-item">
                    <div class="layanan-info">
                        <span class="layanan-name">{{ $layanan['nama'] }}</span>
                        <span class="layanan-count">{{ $layanan['total'] }}</span>
                    </div>
                    <div class="layanan-bar">
                        <div class="layanan-fill" 
                             style="width: {{ $layanan['total'] > 0 ? ($layanan['total'] / max(1, $layananStats->sum('total'))) * 100 : 0 }}%; 
                                    background: {{ ['#07573c', '#2563eb', '#f59e0b', '#8b5cf6', '#ef4444', '#06b6d4', '#10b981'][$loop->index] ?? '#6b7280' }}">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Bulanan Chart --}}
    <div class="chart-card full-width">
        <div class="chart-header">
            <h5 class="chart-title">Tren Permohonan 6 Bulan Terakhir</h5>
            <span class="chart-badge">Grafik</span>
        </div>
        <div class="chart-body">
            <div class="tren-chart">
                @foreach($bulanan as $item)
                <div class="tren-item">
                    <div class="tren-bar">
                        <div class="tren-fill" 
                             style="height: {{ $item['total'] > 0 ? ($item['total'] / max(1, $bulanan->max('total'))) * 100 : 0 }}%; 
                                    background: #07573c">
                            <span class="tren-value">{{ $item['total'] }}</span>
                        </div>
                    </div>
                    <span class="tren-label">{{ $item['bulan'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- ============================================
    FILTER & TABLE LAPORAN
============================================ --}}
<div class="report-section">
    <div class="report-header">
        <h5 class="report-title">Data Permohonan</h5>
        <span class="report-subtitle">Filter dan lihat detail permohonan</span>
    </div>

    <div class="filter-container">
        <form method="GET" action="{{ route('admin.laporan.index') }}" id="filterForm">
            <div class="filter-grid">
                <div class="filter-item">
                    <select name="status" class="filter-select">
                        <option value="">Semua Status</option>
                        @foreach($statuses as $status)
                        <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>
                            {{ $status->nama_status }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-item">
                    <select name="jenis_layanan" class="filter-select">
                        <option value="">Semua Layanan</option>
                        @foreach($layanans as $layanan)
                        <option value="{{ $layanan->id }}" {{ request('jenis_layanan') == $layanan->id ? 'selected' : '' }}>
                            {{ $layanan->nama_layanan }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-item filter-item-date">
                    <input type="date" name="date_from" class="filter-input" placeholder="Dari" value="{{ request('date_from') }}">
                </div>

                <div class="filter-item filter-item-date">
                    <input type="date" name="date_to" class="filter-input" placeholder="Sampai" value="{{ request('date_to') }}">
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn-filter">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polygon points="22 3 2 3 10 13.46 10 19 14 21 14 13.46 22 3"/>
                        </svg>
                        Filter
                    </button>
                    <a href="{{ route('admin.laporan.index') }}" class="btn-reset">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="23 4 23 10 17 10"/>
                            <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                        </svg>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="table-container">
        <div class="table-toolbar">
            <div class="table-info">
                <span class="table-count">{{ $laporanPermohonan->total() }}</span>
                <span class="table-label">permohonan ditemukan</span>
            </div>
            <div class="table-view-options">
                <button class="view-option active" title="Table view">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"/>
                        <rect x="14" y="3" width="7" height="7"/>
                        <rect x="3" y="14" width="7" height="7"/>
                        <rect x="14" y="14" width="7" height="7"/>
                    </svg>
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th class="col-no">#</th>
                        <th class="col-nomor">Nomor</th>
                        <th class="col-pemohon">Pemohon</th>
                        <th class="col-layanan">Layanan</th>
                        <th class="col-status">Status</th>
                        <th class="col-petugas">Petugas Loket</th>
                        <th class="col-tanggal">Tanggal</th>
                        <th class="col-aksi">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporanPermohonan as $index => $permohonan)
                    <tr>
                        <td class="col-no">{{ $laporanPermohonan->firstItem() + $index }}</td>
                        <td class="col-nomor">
                            <span class="nomor-number">{{ $permohonan->nomor_permohonan }}</span>
                        </td>
                        <td class="col-pemohon">
                            <div class="pemohon-wrapper">
                                <div class="pemohon-avatar">
                                    {{ Str::substr($permohonan->pemohon->nama_lengkap, 0, 2) }}
                                </div>
                                <span class="pemohon-name">{{ $permohonan->pemohon->nama_lengkap }}</span>
                            </div>
                        </td>
                        <td class="col-layanan">
                            <span class="layanan-badge">{{ $permohonan->jenisLayanan->nama_layanan }}</span>
                        </td>
                        <td class="col-status">
                            <span class="status-indicator" style="background: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}20; color: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}">
                                <span class="status-dot" style="background: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}"></span>
                                {{ $permohonan->statusPermohonan->nama_status }}
                            </span>
                        </td>
                        <td class="col-petugas">
                            {{ $permohonan->petugasLoket->name ?? '-' }}
                        </td>
                        <td class="col-tanggal">
                            <span class="tanggal-date">{{ $permohonan->created_at->format('d M Y') }}</span>
                            <span class="tanggal-time">{{ $permohonan->created_at->format('H:i') }}</span>
                        </td>
                        <td class="col-aksi">
                            <div class="action-group">
                                <a href="{{ route('admin.permohonan.show', $permohonan) }}" class="action-btn view-btn" title="Detail">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#b0c4bc" stroke-width="1.5">
                                        <rect x="2" y="7" width="20" height="14" rx="2"/>
                                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                                    </svg>
                                </div>
                                <h4>Tidak ada data permohonan</h4>
                                <p>Belum ada permohonan yang sesuai dengan filter</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($laporanPermohonan->hasPages())
        <div class="table-footer">
            <div class="pagination-info">
                Menampilkan <strong>{{ $laporanPermohonan->firstItem() ?? 0 }}</strong> - <strong>{{ $laporanPermohonan->lastItem() ?? 0 }}</strong>
                dari <strong>{{ $laporanPermohonan->total() }}</strong> data
            </div>
            <nav class="pagination-nav">
                @if($laporanPermohonan->onFirstPage())
                    <span class="page-btn disabled">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="15 18 9 12 15 6"/>
                        </svg>
                    </span>
                @else
                    <a href="{{ $laporanPermohonan->previousPageUrl() }}" class="page-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="15 18 9 12 15 6"/>
                        </svg>
                    </a>
                @endif

                <div class="page-numbers">
                    @php
                        $current = $laporanPermohonan->currentPage();
                        $last = $laporanPermohonan->lastPage();
                        $start = max(1, $current - 2);
                        $end = min($last, $current + 2);
                    @endphp

                    @if($start > 1)
                        <a href="{{ $laporanPermohonan->url(1) }}" class="page-num">1</a>
                        @if($start > 2)
                            <span class="page-dots">…</span>
                        @endif
                    @endif

                    @for($i = $start; $i <= $end; $i++)
                        @if($i == $current)
                            <span class="page-num active">{{ $i }}</span>
                        @else
                            <a href="{{ $laporanPermohonan->url($i) }}" class="page-num">{{ $i }}</a>
                        @endif
                    @endfor

                    @if($end < $last)
                        @if($end < $last - 1)
                            <span class="page-dots">…</span>
                        @endif
                        <a href="{{ $laporanPermohonan->url($last) }}" class="page-num">{{ $last }}</a>
                    @endif
                </div>

                @if($laporanPermohonan->hasMorePages())
                    <a href="{{ $laporanPermohonan->nextPageUrl() }}" class="page-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="9 18 15 12 9 6"/>
                        </svg>
                    </a>
                @else
                    <span class="page-btn disabled">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="9 18 15 12 9 6"/>
                        </svg>
                    </span>
                @endif
            </nav>
        </div>
        @endif
    </div>
</div>

{{-- Form untuk PDF --}}
<form id="pdfForm" action="{{ route('admin.laporan.export-pdf') }}" method="GET" style="display: none;">
    @foreach(request()->all() as $key => $value)
        @if(!in_array($key, ['page']))
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endif
    @endforeach
</form>

{{-- TOAST NOTIFICATION --}}
<div id="toastContainer" style="position: fixed; top: 20px; right: 20px; z-index: 99999; display: flex; flex-direction: column; gap: 8px;"></div>

@endsection

@push('styles')
<style>
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
    padding: 20px 24px;
    display: flex;
    align-items: center;
    gap: 16px;
    border: 1px solid #f0f2f1;
    transition: all 0.3s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}

.hero-stat:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
    border-color: #e0e8e4;
}

.hero-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
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
    font-size: 22px;
    font-weight: 800;
    color: #1d2b27;
    line-height: 1.2;
}

.hero-stat-label {
    display: block;
    font-size: 11px;
    font-weight: 500;
    color: #8a9a94;
    margin-top: 2px;
    letter-spacing: 0.02em;
}

.hero-stat-trend {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
    flex-shrink: 0;
}

.hero-stat-trend.up { color: #059669; background: #d1fae5; }
.hero-stat-trend.down { color: #dc2626; background: #fde8e8; }
.hero-stat-trend.neutral { color: #6b7280; background: #f3f4f6; }

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
    padding: 16px 20px;
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
    padding: 16px 20px;
}

/* Status Chart */
.status-chart {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.status-bar-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
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
    gap: 8px;
}

.layanan-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
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
    height: 180px;
    padding-top: 20px;
}

.tren-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    flex: 1;
}

.tren-bar {
    width: 32px;
    height: 140px;
    background: #f0f5f2;
    border-radius: 8px 8px 0 0;
    position: relative;
    display: flex;
    align-items: flex-end;
    justify-content: center;
}

.tren-fill {
    width: 100%;
    border-radius: 8px 8px 0 0;
    transition: height 0.8s ease;
    position: relative;
    min-height: 8px;
}

.tren-value {
    position: absolute;
    top: -20px;
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
   REPORT SECTION
============================================ */
.report-section {
    background: white;
    border-radius: 16px;
    border: 1px solid #f0f2f1;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    overflow: hidden;
}

.report-header {
    padding: 16px 24px;
    border-bottom: 1px solid #f0f2f1;
}

.report-title {
    font-size: 16px;
    font-weight: 700;
    color: #1d2b27;
    margin: 0;
}

.report-subtitle {
    font-size: 12px;
    color: #8a9a94;
}

/* ============================================
   FILTER
============================================ */
.filter-container {
    padding: 16px 24px;
    border-bottom: 1px solid #f0f2f1;
}

.filter-grid {
    display: flex;
    gap: 12px;
    align-items: center;
    flex-wrap: wrap;
}

.filter-item {
    flex: 0 0 auto;
}

.filter-item-date {
    flex: 0 0 150px;
}

.filter-select,
.filter-input {
    padding: 8px 14px;
    border: 1px solid #e9ecef;
    border-radius: 10px;
    font-size: 12px;
    font-family: inherit;
    background: #fafcfb;
    color: #1d2b27;
    width: 100%;
    transition: all 0.3s ease;
}

.filter-select:focus,
.filter-input:focus {
    outline: none;
    border-color: #07573c;
    background: white;
    box-shadow: 0 0 0 4px rgba(7, 87, 60, 0.08);
}

.filter-actions {
    display: flex;
    gap: 8px;
    align-items: center;
}

.btn-filter {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 18px;
    background: #07573c;
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-filter:hover {
    background: #043d2a;
    transform: translateY(-1px);
    box-shadow: 0 4px 16px rgba(7, 87, 60, 0.25);
}

.btn-reset {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border: 1px solid #e9ecef;
    border-radius: 10px;
    background: transparent;
    color: #8a9a94;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-reset:hover {
    background: #f0f5f2;
    border-color: #c5ceca;
    color: #4a5a54;
}

/* ============================================
   TABLE - SAMA DENGAN SEBELUMNYA
============================================ */
.table-container {
    background: white;
    border-radius: 16px;
    border: 1px solid #f0f2f1;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    overflow: hidden;
}

.table-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 20px;
    border-bottom: 1px solid #f0f2f1;
}

.table-info {
    display: flex;
    align-items: baseline;
    gap: 6px;
}

.table-count {
    font-size: 16px;
    font-weight: 800;
    color: #07573c;
}

.table-label {
    font-size: 12px;
    color: #8a9a94;
}

.table-view-options {
    display: flex;
    gap: 4px;
    background: #f8faf9;
    padding: 4px;
    border-radius: 10px;
}

.view-option {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 8px;
    background: transparent;
    color: #8a9a94;
    cursor: pointer;
    transition: all 0.2s ease;
}

.view-option:hover {
    background: #e9ecef;
    color: #4a5a54;
}

.view-option.active {
    background: white;
    color: #07573c;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

.data-table thead th {
    padding: 10px 16px;
    text-align: left;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #8a9a94;
    background: #fafcfb;
    border-bottom: 2px solid #f0f2f1;
}

.data-table tbody td {
    padding: 12px 16px;
    border-bottom: 1px solid #f5f7f6;
    vertical-align: middle;
}

.data-table tbody tr:hover {
    background: #fafcfb;
}

.data-table tbody tr:last-child td { border-bottom: none; }

.col-no { width: 40px; text-align: center; color: #b0c4bc; font-weight: 500; }
.col-nomor { min-width: 120px; }
.col-pemohon { min-width: 160px; }
.col-layanan { min-width: 130px; }
.col-status { min-width: 110px; }
.col-petugas { min-width: 120px; }
.col-tanggal { min-width: 110px; }
.col-aksi { width: 60px; text-align: center; }

.nomor-number {
    font-weight: 700;
    color: #07573c;
    font-size: 12px;
}

.pemohon-wrapper {
    display: flex;
    align-items: center;
    gap: 8px;
}

.pemohon-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, #e8f0ed, #c5d9d0);
    color: #07573c;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
    flex-shrink: 0;
}

.pemohon-name {
    font-weight: 500;
    color: #1d2b27;
    font-size: 13px;
}

.layanan-badge {
    display: inline-block;
    padding: 2px 10px;
    background: #eef6ff;
    color: #2563eb;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 500;
}

.status-indicator {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 3px 12px 3px 8px;
    border-radius: 16px;
    font-size: 11px;
    font-weight: 600;
}

.status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    display: inline-block;
}

.tanggal-date {
    display: block;
    font-weight: 500;
    color: #1d2b27;
    font-size: 12px;
}

.tanggal-time {
    font-size: 10px;
    color: #8a9a94;
}

.action-group {
    display: flex;
    gap: 4px;
    justify-content: center;
}

.action-btn {
    width: 30px;
    height: 30px;
    border: none;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    color: #8a9a94;
    background: transparent;
}

.action-btn:hover { transform: translateY(-1px); }
.view-btn:hover { background: #dbeafe; color: #2563eb; }

.table-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 20px;
    border-top: 1px solid #f0f2f1;
    background: #fafcfb;
}

.pagination-info {
    font-size: 12px;
    color: #6c7a75;
}

.pagination-info strong { color: #1d2b27; }

.pagination-nav {
    display: flex;
    align-items: center;
    gap: 4px;
}

.page-btn {
    width: 34px;
    height: 34px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    background: white;
    color: #4a5a54;
    text-decoration: none;
    transition: all 0.2s ease;
    cursor: pointer;
}

.page-btn:hover:not(.disabled) {
    border-color: #07573c;
    color: #07573c;
    background: #f0f5f2;
}

.page-btn.disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

.page-numbers {
    display: flex;
    gap: 2px;
}

.page-num {
    width: 34px;
    height: 34px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 500;
    color: #4a5a54;
    text-decoration: none;
    transition: all 0.2s ease;
}

.page-num:hover:not(.active) {
    background: #f0f5f2;
    color: #07573c;
}

.page-num.active {
    background: #07573c;
    color: white;
    font-weight: 700;
}

.page-dots {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
    color: #b0c4bc;
    font-size: 14px;
}

.empty-state {
    text-align: center;
    padding: 40px 20px;
}

.empty-icon {
    margin-bottom: 12px;
    color: #d0dcd6;
}

.empty-state h4 {
    font-size: 16px;
    font-weight: 700;
    color: #1d2b27;
    margin-bottom: 4px;
}

.empty-state p {
    color: #8a9a94;
    font-size: 13px;
}

/* ============================================
   BUTTONS
============================================ */
.btn-pdf {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 9px 20px;
    background: #07573c;
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-pdf:hover {
    background: #043d2a;
    transform: translateY(-1px);
    box-shadow: 0 4px 16px rgba(7, 87, 60, 0.25);
}

.btn-outline {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 9px 14px;
    background: transparent;
    color: #4a5a54;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-outline:hover {
    background: #f0f5f2;
    border-color: #c5ceca;
}

/* ============================================
   TOAST
============================================ */
#toastContainer .toast {
    padding: 14px 20px;
    border-radius: 12px;
    color: white;
    font-size: 14px;
    font-weight: 500;
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    animation: slideInRight 0.3s ease;
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 280px;
    max-width: 420px;
}

.toast-success { background: #059669; }
.toast-error { background: #dc2626; }
.toast-info { background: #2563eb; }

@keyframes slideInRight {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@keyframes fadeOut {
    from { opacity: 1; }
    to { opacity: 0; transform: translateX(100%); }
}

#toastContainer .toast.hide {
    animation: fadeOut 0.3s ease forwards;
}

/* ============================================
   RESPONSIVE
============================================ */
@media (max-width: 1200px) {
    .hero-stats { grid-template-columns: repeat(2, 1fr); }
    .chart-grid { grid-template-columns: 1fr; }
}

@media (max-width: 992px) {
    .filter-grid {
        flex-direction: column;
        align-items: stretch;
    }
    .filter-item-date { flex: unset; }
    .filter-actions { justify-content: flex-end; }
}

@media (max-width: 768px) {
    .hero-stats { grid-template-columns: 1fr; }
    .table-toolbar {
        flex-direction: column;
        gap: 10px;
        align-items: stretch;
    }
    .table-footer {
        flex-direction: column;
        gap: 12px;
        align-items: stretch;
        text-align: center;
    }
    .pagination-nav {
        justify-content: center;
        flex-wrap: wrap;
    }
    #toastContainer {
        top: 10px;
        right: 10px;
        left: 10px;
    }
    #toastContainer .toast {
        min-width: unset;
        width: 100%;
    }
}

@media (max-width: 480px) {
    .hero-stat { padding: 16px; }
    .hero-stat-value { font-size: 18px; }
    .data-table thead { display: none; }
    .data-table tbody tr {
        display: block;
        padding: 12px;
        border-bottom: 1px solid #f0f2f1;
    }
    .data-table tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 4px 0;
        border: none;
    }
    .data-table tbody td::before {
        content: attr(data-label);
        font-weight: 600;
        font-size: 10px;
        color: #8a9a94;
        text-transform: uppercase;
    }
    .col-no, .col-nomor, .col-pemohon, .col-layanan, .col-status, .col-petugas, .col-tanggal, .col-aksi {
        width: 100% !important;
        min-width: unset !important;
    }
    .col-aksi { justify-content: center; }
    .tren-chart { height: 120px; }
    .tren-bar { height: 80px; width: 24px; }
}
</style>
@endpush

@push('scripts')
<script>
// ============================================
// EXPORT PDF
// ============================================
function exportPdf() {
    document.getElementById('pdfForm').submit();
}

// ============================================
// TOAST NOTIFICATION
// ============================================
function showToast(message, type = 'success') {
    const container = document.getElementById('toastContainer');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;

    const icons = {
        success: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>`,
        error: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`,
        info: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>`
    };

    toast.innerHTML = `
        ${icons[type] || icons.info}
        <span>${message}</span>
    `;

    container.appendChild(toast);

    setTimeout(() => {
        toast.classList.add('hide');
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}

// ============================================
// VIEW TOGGLE
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.view-option').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.view-option').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });
});

// ============================================
// AUTO SUBMIT FILTER
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.filter-select, .filter-input').forEach(el => {
        el.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
});
</script>
@endpush