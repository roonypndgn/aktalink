{{-- resources/views/admin/permohonan/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Monitoring Permohonan - AKTALINK')
@section('page-title', 'Monitoring Permohonan')
@section('page-description', 'Pantau seluruh permohonan layanan akta secara real-time')

@section('page-actions')
    <button onclick="generatePdf()" class="btn-pdf">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <line x1="12" y1="18" x2="12" y2="12"/>
            <polyline points="9 15 12 18 15 15"/>
        </svg>
        Export PDF
    </button>
    <button onclick="window.print()" class="btn-outline">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="6 9 6 2 18 2 18 9"/>
            <path d="M18 9H6M18 9a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-4a2 2 0 0 1 2-2"/>
            <rect x="8" y="14" width="8" height="6" rx="1"/>
        </svg>
    </button>
@endsection

@section('content')
{{-- ============================================
    FILTER & SEARCH
============================================ --}}
<div class="filter-container">
    <form method="GET" action="{{ route('admin.permohonan.index') }}" id="filterForm" class="filter-form">
        <div class="filter-grid">
            {{-- Search --}}
            <div class="filter-item search-item">
                <div class="search-wrapper">
                    <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text"
                           name="search"
                           class="search-input"
                           placeholder="Cari permohonan..."
                           value="{{ request('search') }}">
                    @if(request('search'))
                    <a href="{{ route('admin.permohonan.index') }}" class="search-clear">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18"/>
                            <line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                    </a>
                    @endif
                </div>
            </div>

            {{-- Filters --}}
            <div class="filter-item">
                <select name="status" class="filter-select">
                    <option value="">Status</option>
                    @foreach($statuses as $status)
                    <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>
                        {{ $status->nama_status }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-item">
                <select name="jenis_layanan" class="filter-select">
                    <option value="">Layanan</option>
                    @foreach($layanans as $layanan)
                    <option value="{{ $layanan->id }}" {{ request('jenis_layanan') == $layanan->id ? 'selected' : '' }}>
                        {{ $layanan->nama_layanan }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-item">
                <select name="prioritas" class="filter-select">
                    <option value="">Prioritas</option>
                    @foreach($prioritas as $p)
                    <option value="{{ $p }}" {{ request('prioritas') == $p ? 'selected' : '' }}>
                        {{ ucfirst($p) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn-filter">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polygon points="22 3 2 3 10 13.46 10 19 14 21 14 13.46 22 3"/>
                    </svg>
                    Filter
                </button>
                <a href="{{ route('admin.permohonan.index') }}" class="btn-reset">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23 4 23 10 17 10"/>
                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                    </svg>
                </a>
            </div>
        </div>

        {{-- Active Filters --}}
        @if(request()->anyFilled(['status', 'jenis_layanan', 'prioritas', 'search']))
        <div class="active-filters">
            <span class="active-filters-label">Filter aktif:</span>
            @if(request('search'))
            <span class="filter-tag">
                Pencarian: "{{ request('search') }}"
                <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="filter-tag-remove">×</a>
            </span>
            @endif
            @if(request('status'))
            <span class="filter-tag">
                Status: {{ $statuses->firstWhere('id', request('status'))->nama_status ?? '' }}
                <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}" class="filter-tag-remove">×</a>
            </span>
            @endif
            @if(request('jenis_layanan'))
            <span class="filter-tag">
                Layanan: {{ $layanans->firstWhere('id', request('jenis_layanan'))->nama_layanan ?? '' }}
                <a href="{{ request()->fullUrlWithQuery(['jenis_layanan' => null]) }}" class="filter-tag-remove">×</a>
            </span>
            @endif
            @if(request('prioritas'))
            <span class="filter-tag">
                Prioritas: {{ ucfirst(request('prioritas')) }}
                <a href="{{ request()->fullUrlWithQuery(['prioritas' => null]) }}" class="filter-tag-remove">×</a>
            </span>
            @endif
        </div>
        @endif
    </form>
</div>

{{-- ============================================
    TABLE
============================================ --}}
<div class="table-container">
    <div class="table-toolbar">
        <div class="table-info">
            <span class="table-count">{{ $permohonans->total() }}</span>
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
            <button class="view-option" title="Card view">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                    <line x1="3" y1="9" x2="21" y2="9"/>
                    <line x1="3" y1="15" x2="21" y2="15"/>
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
                    <th class="col-prioritas">Prioritas</th>
                    <th class="col-tanggal">Tanggal</th>
                    <th class="col-aksi">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($permohonans as $index => $permohonan)
                <tr>
                    <td class="col-no">{{ $permohonans->firstItem() + $index }}</td>
                    <td class="col-nomor">
                        <div class="nomor-wrapper">
                            <span class="nomor-number">{{ $permohonan->nomor_permohonan }}</span>
                            <span class="nomor-title">{{ Str::limit($permohonan->judul_permohonan ?? 'Tanpa judul', 35) }}</span>
                        </div>
                    </td>
                    <td class="col-pemohon">
                        <div class="pemohon-wrapper">
                            <div class="pemohon-avatar">
                                {{ Str::substr($permohonan->pemohon->nama_lengkap, 0, 2) }}
                            </div>
                            <div class="pemohon-info">
                                <span class="pemohon-name">{{ $permohonan->pemohon->nama_lengkap }}</span>
                                <span class="pemohon-nik">{{ $permohonan->pemohon->nik }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="col-layanan">
                        <span class="layanan-badge">
                            {{ Str::limit($permohonan->jenisLayanan->nama_layanan, 20) }}
                        </span>
                    </td>
                    <td class="col-status">
                        <span class="status-indicator" style="--status-color: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}">
                            <span class="status-dot"></span>
                            {{ $permohonan->statusPermohonan->nama_status }}
                        </span>
                    </td>
                    <td class="col-prioritas">
                        <span class="priority-badge priority-{{ $permohonan->prioritas }}">
                            {{ $permohonan->label_prioritas }}
                        </span>
                    </td>
                    <td class="col-tanggal">
                        <span class="tanggal-date">{{ $permohonan->tanggal_permohonan->format('d M Y') }}</span>
                        <span class="tanggal-time">{{ $permohonan->tanggal_permohonan->format('H:i') }}</span>
                    </td>
                    <td class="col-aksi">
                        <div class="action-group">
                            <a href="{{ route('admin.permohonan.show', $permohonan) }}"
                               class="action-btn view-btn"
                               title="Detail">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </a>
                            <a href="{{ route('admin.permohonan.pdf-detail', $permohonan) }}"
                               class="action-btn pdf-btn"
                               title="PDF" target="_blank">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                    <line x1="12" y1="18" x2="12" y2="12"/>
                                    <polyline points="9 15 12 18 15 15"/>
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
                            <h4>Tidak ada permohonan</h4>
                            <p>Belum ada data permohonan yang tersedia</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    @if($permohonans->hasPages())
    <div class="table-footer">
        <div class="pagination-info">
            Menampilkan <strong>{{ $permohonans->firstItem() ?? 0 }}</strong> - <strong>{{ $permohonans->lastItem() ?? 0 }}</strong>
            dari <strong>{{ $permohonans->total() }}</strong> data
        </div>
        <nav class="pagination-nav">
            {{-- Previous --}}
            @if($permohonans->onFirstPage())
                <span class="page-btn disabled">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6"/>
                    </svg>
                </span>
            @else
                <a href="{{ $permohonans->previousPageUrl() }}" class="page-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6"/>
                    </svg>
                </a>
            @endif

            {{-- Pages --}}
            <div class="page-numbers">
                @php
                    $current = $permohonans->currentPage();
                    $last = $permohonans->lastPage();
                    $start = max(1, $current - 2);
                    $end = min($last, $current + 2);
                @endphp

                @if($start > 1)
                    <a href="{{ $permohonans->url(1) }}" class="page-num">1</a>
                    @if($start > 2)
                        <span class="page-dots">…</span>
                    @endif
                @endif

                @for($i = $start; $i <= $end; $i++)
                    @if($i == $current)
                        <span class="page-num active">{{ $i }}</span>
                    @else
                        <a href="{{ $permohonans->url($i) }}" class="page-num">{{ $i }}</a>
                    @endif
                @endfor

                @if($end < $last)
                    @if($end < $last - 1)
                        <span class="page-dots">…</span>
                    @endif
                    <a href="{{ $permohonans->url($last) }}" class="page-num">{{ $last }}</a>
                @endif
            </div>

            {{-- Next --}}
            @if($permohonans->hasMorePages())
                <a href="{{ $permohonans->nextPageUrl() }}" class="page-btn">
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

{{-- Form PDF --}}
<form id="pdfForm" action="{{ route('admin.permohonan.pdf') }}" method="GET" style="display: none;">
    @foreach(request()->all() as $key => $value)
        @if(!in_array($key, ['page']))
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endif
    @endforeach
</form>

@endsection

@push('styles')
<style>
/* ============================================
   HERO STATISTICS
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

.hero-stat-trend.up {
    color: #059669;
    background: #d1fae5;
}

.hero-stat-trend.down {
    color: #dc2626;
    background: #fde8e8;
}

/* ============================================
   FILTER CONTAINER
============================================ */
.filter-container {
    background: white;
    border-radius: 16px;
    padding: 20px 24px;
    margin-bottom: 24px;
    border: 1px solid #f0f2f1;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
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

.filter-item.search-item {
    flex: 2 1 260px;
    min-width: 200px;
}

.search-wrapper {
    position: relative;
    width: 100%;
}

.search-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #b0c4bc;
    pointer-events: none;
}

.search-input {
    width: 100%;
    padding: 10px 40px 10px 44px;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    font-size: 13px;
    font-family: inherit;
    background: #fafcfb;
    color: #1d2b27;
    transition: all 0.3s ease;
}

.search-input:focus {
    outline: none;
    border-color: #07573c;
    background: white;
    box-shadow: 0 0 0 4px rgba(7, 87, 60, 0.08);
}

.search-input::placeholder {
    color: #b0c4bc;
}

.search-clear {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #b0c4bc;
    text-decoration: none;
    padding: 4px;
    border-radius: 50%;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
}

.search-clear:hover {
    background: #f0f5f2;
    color: #4a5a54;
}

.filter-select {
    padding: 10px 36px 10px 14px;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    font-size: 13px;
    font-family: inherit;
    background: #fafcfb url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238a9a94' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") no-repeat right 12px center;
    background-size: 14px;
    appearance: none;
    color: #1d2b27;
    cursor: pointer;
    min-width: 130px;
    transition: all 0.3s ease;
}

.filter-select:focus {
    outline: none;
    border-color: #07573c;
    background-color: white;
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
    gap: 8px;
    padding: 10px 20px;
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

.btn-filter:hover {
    background: #043d2a;
    transform: translateY(-1px);
    box-shadow: 0 4px 16px rgba(7, 87, 60, 0.25);
}

.btn-reset {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 42px;
    height: 42px;
    border: 1px solid #e9ecef;
    border-radius: 12px;
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

/* Active Filters */
.active-filters {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 8px;
    margin-top: 12px;
    padding-top: 12px;
    border-top: 1px solid #f0f2f1;
}

.active-filters-label {
    font-size: 11px;
    font-weight: 600;
    color: #8a9a94;
}

.filter-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px 4px 14px;
    background: #f0f5f2;
    border-radius: 20px;
    font-size: 12px;
    color: #4a5a54;
}

.filter-tag-remove {
    color: #b0c4bc;
    text-decoration: none;
    font-size: 14px;
    line-height: 1;
    padding: 0 2px;
    transition: color 0.2s ease;
}

.filter-tag-remove:hover {
    color: #dc2626;
}

/* ============================================
   TABLE CONTAINER
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
    padding: 16px 24px;
    border-bottom: 1px solid #f0f2f1;
}

.table-info {
    display: flex;
    align-items: baseline;
    gap: 6px;
}

.table-count {
    font-size: 18px;
    font-weight: 800;
    color: #07573c;
}

.table-label {
    font-size: 13px;
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
    width: 34px;
    height: 34px;
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

/* ============================================
   DATA TABLE
============================================ */
.data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

.data-table thead th {
    padding: 12px 16px;
    text-align: left;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #8a9a94;
    background: #fafcfb;
    border-bottom: 2px solid #f0f2f1;
}

.data-table tbody td {
    padding: 14px 16px;
    border-bottom: 1px solid #f5f7f6;
    vertical-align: middle;
}

.data-table tbody tr {
    transition: background 0.2s ease;
}

.data-table tbody tr:hover {
    background: #fafcfb;
}

.data-table tbody tr:last-child td {
    border-bottom: none;
}

/* Columns */
.col-no { width: 44px; text-align: center; color: #b0c4bc; font-weight: 500; }
.col-nomor { min-width: 150px; }
.col-pemohon { min-width: 180px; }
.col-layanan { min-width: 130px; }
.col-status { min-width: 110px; }
.col-prioritas { min-width: 90px; }
.col-tanggal { min-width: 110px; }
.col-aksi { width: 80px; text-align: center; }

/* Nomor */
.nomor-wrapper {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.nomor-number {
    font-weight: 700;
    color: #07573c;
    font-size: 13px;
}

.nomor-title {
    font-size: 12px;
    color: #8a9a94;
}

/* Pemohon */
.pemohon-wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
}

.pemohon-avatar {
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

.pemohon-info {
    display: flex;
    flex-direction: column;
    gap: 1px;
}

.pemohon-name {
    font-weight: 600;
    color: #1d2b27;
}

.pemohon-nik {
    font-size: 12px;
    color: #8a9a94;
}

/* Layanan Badge */
.layanan-badge {
    display: inline-block;
    padding: 4px 12px;
    background: #eef6ff;
    color: #2563eb;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

/* Status Indicator */
.status-indicator {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 4px 14px 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    background: var(--status-color)20;
    color: var(--status-color);
}

.status-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: var(--status-color);
    display: inline-block;
}

/* Priority Badge */
.priority-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 12px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
}

.priority-normal {
    background: #e9ecef;
    color: #495057;
}

.priority-penting {
    background: #fef3c7;
    color: #92400e;
}

.priority-urgent {
    background: #fde8e8;
    color: #b91c1c;
}

/* Tanggal */
.tanggal-date {
    display: block;
    font-weight: 600;
    color: #1d2b27;
}

.tanggal-time {
    font-size: 12px;
    color: #8a9a94;
}

/* Action Buttons */
.action-group {
    display: flex;
    gap: 4px;
    justify-content: center;
}

.action-btn {
    width: 32px;
    height: 32px;
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

.action-btn:hover {
    transform: translateY(-1px);
}

.view-btn:hover {
    background: #eef6ff;
    color: #2563eb;
}

.pdf-btn:hover {
    background: #fde8e8;
    color: #dc2626;
}

/* ============================================
   TABLE FOOTER & PAGINATION
============================================ */
.table-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 24px;
    border-top: 1px solid #f0f2f1;
    background: #fafcfb;
}

.pagination-info {
    font-size: 13px;
    color: #6c7a75;
}

.pagination-info strong {
    color: #1d2b27;
}

.pagination-nav {
    display: flex;
    align-items: center;
    gap: 4px;
}

.page-btn {
    width: 36px;
    height: 36px;
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
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    font-size: 13px;
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
    width: 36px;
    height: 36px;
    color: #b0c4bc;
    font-size: 14px;
}

/* ============================================
   EMPTY STATE
============================================ */
.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-icon {
    margin-bottom: 16px;
    color: #d0dcd6;
}

.empty-state h4 {
    font-size: 18px;
    font-weight: 700;
    color: #1d2b27;
    margin-bottom: 4px;
}

.empty-state p {
    color: #8a9a94;
    font-size: 14px;
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
   RESPONSIVE
============================================ */
@media (max-width: 1200px) {
    .hero-stats {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 992px) {
    .filter-grid {
        flex-direction: column;
        align-items: stretch;
    }
    .filter-item.search-item {
        flex: unset;
    }
    .filter-actions {
        justify-content: flex-end;
    }
}

@media (max-width: 768px) {
    .hero-stats {
        grid-template-columns: 1fr;
    }
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
    .data-table thead {
        display: none;
    }
    .data-table tbody tr {
        display: block;
        padding: 16px;
        border-bottom: 1px solid #f0f2f1;
    }
    .data-table tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 6px 0;
        border: none;
    }
    .data-table tbody td::before {
        content: attr(data-label);
        font-weight: 600;
        font-size: 11px;
        color: #8a9a94;
        text-transform: uppercase;
    }
    .col-no, .col-nomor, .col-pemohon, .col-layanan, .col-status, .col-prioritas, .col-tanggal, .col-aksi {
        width: 100% !important;
        min-width: unset !important;
    }
    .col-aksi {
        justify-content: center;
    }
}
</style>
@endpush

@push('scripts')
<script>
    function generatePdf() {
        document.getElementById('pdfForm').submit();
    }

    // Toggle view options
    document.querySelectorAll('.view-option').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.view-option').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });
</script>
@endpush