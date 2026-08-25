@extends('layouts.app')

@section('title', 'Riwayat Aktivitas - AKTALINK')
@section('page-title', 'Riwayat Aktivitas')
@section('page-description', 'Pantau semua aktivitas pengguna di sistem AKTALINK')

@section('page-actions')
    <button type="button" class="btn-outline-danger" onclick="clearLogs()">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="3 6 5 6 21 6"/>
            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
        </svg>
        Bersihkan
    </button>
@endsection

@section('content')


{{-- ============================================
    FILTER & SEARCH
============================================ --}}
<div class="filter-container">
    <form method="GET" action="{{ route('admin.riwayat.index') }}" id="filterForm">
        <div class="filter-grid">
            <div class="filter-item search-item">
                <div class="search-wrapper">
                    <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" name="search" class="search-input" placeholder="Cari aktivitas, IP, URL..." value="{{ request('search') }}">
                    @if(request('search'))
                    <a href="{{ route('admin.riwayat.index') }}" class="search-clear">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18"/>
                            <line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                    </a>
                    @endif
                </div>
            </div>

            <div class="filter-item">
                <select name="user_id" class="filter-select">
                    <option value="">Semua Pengguna</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-item">
                <select name="subject_type" class="filter-select">
                    <option value="">Semua Modul</option>
                    @foreach($subjectTypes as $subject)
                    <option value="{{ $subject['value'] }}" {{ request('subject_type') == $subject['value'] ? 'selected' : '' }}>
                        {{ $subject['label'] }}
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
                <a href="{{ route('admin.riwayat.index') }}" class="btn-reset">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23 4 23 10 17 10"/>
                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                    </svg>
                </a>
            </div>
        </div>

        @if(request()->anyFilled(['search', 'user_id', 'subject_type', 'date_from', 'date_to']))
        <div class="active-filters">
            <span class="active-filters-label">Filter aktif:</span>
            @if(request('search'))
            <span class="filter-tag">
                Pencarian: "{{ request('search') }}"
                <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="filter-tag-remove">×</a>
            </span>
            @endif
            @if(request('user_id'))
            <span class="filter-tag">
                Pengguna: {{ $users->firstWhere('id', request('user_id'))->name ?? '' }}
                <a href="{{ request()->fullUrlWithQuery(['user_id' => null]) }}" class="filter-tag-remove">×</a>
            </span>
            @endif
            @if(request('subject_type'))
            <span class="filter-tag">
                Modul: {{ class_basename(request('subject_type')) }}
                <a href="{{ request()->fullUrlWithQuery(['subject_type' => null]) }}" class="filter-tag-remove">×</a>
            </span>
            @endif
            @if(request('date_from') || request('date_to'))
            <span class="filter-tag">
                Tanggal: {{ request('date_from') ?? '...' }} — {{ request('date_to') ?? '...' }}
                <a href="{{ request()->fullUrlWithQuery(['date_from' => null, 'date_to' => null]) }}" class="filter-tag-remove">×</a>
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
            <span class="table-count">{{ $logs->total() }}</span>
            <span class="table-label">aktivitas ditemukan</span>
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
                    <th class="col-user">Pengguna</th>
                    <th class="col-aktivitas">Aktivitas</th>
                    <th class="col-deskripsi">Deskripsi</th>
                    <th class="col-modul">Modul</th>
                    <th class="col-ip">IP Address</th>
                    <th class="col-tanggal">Tanggal</th>
                    <th class="col-aksi">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $index => $log)
                <tr>
                    <td class="col-no">{{ $logs->firstItem() + $index }}</td>
                    <td class="col-user">
                        <div class="user-wrapper">
                            <div class="user-avatar" style="background: {{ $log->user?->role_color ?? '#6b7280' }}20; color: {{ $log->user?->role_color ?? '#6b7280' }}">
                                {{ $log->user ? Str::substr($log->user->name, 0, 2) : '?' }}
                            </div>
                            <div>
                                <div class="user-name">{{ $log->user?->name ?? 'System' }}</div>
                                <div class="user-role">{{ $log->user?->role_label ?? 'System' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="col-aktivitas">
                        <span class="aktivitas-badge">
                            {{ $log->aktivitas }}
                        </span>
                    </td>
                    <td class="col-deskripsi">
                        <span class="deskripsi-text">{{ Str::limit($log->deskripsi ?? '-', 50) }}</span>
                    </td>
                    <td class="col-modul">
                        <span class="modul-badge">
                            {{ $log->subject_type ? class_basename($log->subject_type) : '-' }}
                        </span>
                    </td>
                    <td class="col-ip">
                        <span class="ip-badge">{{ $log->ip_address ?? '-' }}</span>
                    </td>
                    <td class="col-tanggal">
                        <span class="tanggal-date">{{ $log->created_at->format('d M Y') }}</span>
                        <span class="tanggal-time">{{ $log->created_at->format('H:i:s') }}</span>
                    </td>
                    <td class="col-aksi">
                        <div class="action-group">
                            <button type="button" class="action-btn view-btn" onclick="openDetailModal({{ $log->id }})" title="Detail">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
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
                            <h4>Belum ada riwayat aktivitas</h4>
                            <p>Belum ada aktivitas yang tercatat di sistem</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    @if($logs->hasPages())
    <div class="table-footer">
        <div class="pagination-info">
            Menampilkan <strong>{{ $logs->firstItem() ?? 0 }}</strong> - <strong>{{ $logs->lastItem() ?? 0 }}</strong>
            dari <strong>{{ $logs->total() }}</strong> data
        </div>
        <nav class="pagination-nav">
            @if($logs->onFirstPage())
                <span class="page-btn disabled">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6"/>
                    </svg>
                </span>
            @else
                <a href="{{ $logs->previousPageUrl() }}" class="page-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6"/>
                    </svg>
                </a>
            @endif

            <div class="page-numbers">
                @php
                    $current = $logs->currentPage();
                    $last = $logs->lastPage();
                    $start = max(1, $current - 2);
                    $end = min($last, $current + 2);
                @endphp

                @if($start > 1)
                    <a href="{{ $logs->url(1) }}" class="page-num">1</a>
                    @if($start > 2)
                        <span class="page-dots">…</span>
                    @endif
                @endif

                @for($i = $start; $i <= $end; $i++)
                    @if($i == $current)
                        <span class="page-num active">{{ $i }}</span>
                    @else
                        <a href="{{ $logs->url($i) }}" class="page-num">{{ $i }}</a>
                    @endif
                @endfor

                @if($end < $last)
                    @if($end < $last - 1)
                        <span class="page-dots">…</span>
                    @endif
                    <a href="{{ $logs->url($last) }}" class="page-num">{{ $last }}</a>
                @endif
            </div>

            @if($logs->hasMorePages())
                <a href="{{ $logs->nextPageUrl() }}" class="page-btn">
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


{{-- ============================================
    DETAIL MODAL
============================================ --}}
<div class="modal-overlay" id="detailModal" style="display: none;">
    <div class="modal-container">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-header-icon" style="background: #dbeafe; color: #2563eb;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <h4 class="modal-title">Detail Aktivitas</h4>
                <button type="button" class="modal-close" onclick="closeModal('detailModal')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body" id="detailModalBody">
                <div class="detail-loading text-center">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#07573c" stroke-width="2" class="spinner">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                    </svg>
                    <p class="mt-2">Memuat data...</p>
                </div>
                <div class="detail-content" style="display: none;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('detailModal')">Tutup</button>
            </div>
        </div>
    </div>
</div>

{{-- TOAST NOTIFICATION --}}
<div id="toastContainer" style="position: fixed; top: 20px; right: 20px; z-index: 99999; display: flex; flex-direction: column; gap: 8px;"></div>

@endsection

@push('styles')
<style>
/* ============================================
   USER STYLES
============================================ */
.user-wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
}

.user-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 700;
    flex-shrink: 0;
}

.user-name {
    font-weight: 600;
    color: #1d2b27;
    font-size: 13px;
}

.user-role {
    font-size: 11px;
    color: #8a9a94;
}

.aktivitas-badge {
    display: inline-block;
    padding: 3px 12px;
    background: #f0f5f2;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
    color: #4a5a54;
}

.deskripsi-text {
    font-size: 12px;
    color: #4a5a54;
}

.modul-badge {
    display: inline-block;
    padding: 2px 10px;
    background: #eef6ff;
    color: #2563eb;
    border-radius: 10px;
    font-size: 10px;
    font-weight: 600;
}

.ip-badge {
    font-family: monospace;
    font-size: 11px;
    color: #6c7a75;
    background: #f8faf9;
    padding: 2px 8px;
    border-radius: 6px;
}

.col-no { width: 40px; text-align: center; color: #b0c4bc; font-weight: 500; }
.col-user { min-width: 180px; }
.col-aktivitas { min-width: 150px; }
.col-deskripsi { min-width: 200px; }
.col-modul { min-width: 100px; }
.col-ip { min-width: 120px; }
.col-tanggal { min-width: 110px; }
.col-aksi { width: 60px; text-align: center; }

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

.btn-outline-danger {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 9px 14px;
    background: transparent;
    color: #dc2626;
    border: 1px solid #fde8e8;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-outline-danger:hover {
    background: #fde8e8;
    border-color: #dc2626;
}

/* ============================================
   HERO STATS - SAMA DENGAN SEBELUMNYA
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
   FILTER
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

.filter-item-date {
    flex: 0 0 150px;
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

.search-input::placeholder { color: #b0c4bc; }

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

.filter-select,
.filter-input {
    padding: 10px 14px;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    font-size: 13px;
    font-family: inherit;
    background: #fafcfb;
    color: #1d2b27;
    width: 100%;
    transition: all 0.3s ease;
}

.filter-select {
    padding-right: 36px;
    background: #fafcfb url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238a9a94' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") no-repeat right 12px center;
    background-size: 14px;
    appearance: none;
}

.filter-select:focus,
.filter-input:focus {
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

.filter-tag-remove:hover { color: #dc2626; }

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

.data-table tbody tr:hover {
    background: #fafcfb;
}

.data-table tbody tr:last-child td { border-bottom: none; }

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

.action-btn:hover { transform: translateY(-1px); }
.view-btn:hover { background: #dbeafe; color: #2563eb; }

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

.pagination-info strong { color: #1d2b27; }

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
   MODAL
============================================ */
.modal-overlay {
    position: fixed;
    inset: 0;
    z-index: 100000;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    animation: modalFadeIn 0.3s ease;
}

@keyframes modalFadeIn {
    from { opacity: 0; backdrop-filter: blur(0px); }
    to { opacity: 1; backdrop-filter: blur(8px); }
}

.modal-container {
    width: 100%;
    max-width: 540px;
    max-height: 90vh;
    animation: modalSlideUp 0.3s ease;
}

@keyframes modalSlideUp {
    from { transform: translateY(30px) scale(0.95); opacity: 0; }
    to { transform: translateY(0) scale(1); opacity: 1; }
}

.modal-content {
    background: white;
    border-radius: 20px;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.2);
    overflow: hidden;
}

.modal-header {
    padding: 1.25rem 1.5rem 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    border-bottom: 1px solid #f0f2f1;
}

.modal-header-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.modal-title {
    flex: 1;
    font-size: 1.1rem;
    font-weight: 700;
    color: #1d2b27;
    margin: 0;
}

.modal-close {
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 50%;
    background: transparent;
    color: #8a9a94;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.modal-close:hover {
    background: #f0f5f2;
    color: #1d2b27;
}

.modal-body {
    padding: 1.5rem;
    overflow-y: auto;
    max-height: calc(90vh - 160px);
}

.modal-footer {
    padding: 0.75rem 1.5rem 1.25rem;
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
    border-top: 1px solid #f0f2f1;
}

.detail-loading {
    padding: 40px 20px;
}

.spinner {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.detail-item.full-width {
    grid-column: 1 / -1;
}

.detail-item label {
    font-size: 11px;
    font-weight: 600;
    color: #8a9a94;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}

.detail-item .detail-value {
    font-size: 14px;
    color: #1d2b27;
    padding: 6px 12px;
    background: #f8faf9;
    border-radius: 8px;
    word-break: break-word;
}

.detail-item .detail-value.empty {
    color: #b0c4bc;
    font-style: italic;
}

.detail-profile {
    text-align: center;
    padding: 8px 0 16px;
    border-bottom: 1px solid #f0f2f1;
    margin-bottom: 16px;
}

.detail-profile .avatar-lg {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    font-weight: 700;
    margin: 0 auto 8px;
}

.detail-profile .name {
    font-size: 16px;
    font-weight: 700;
    color: #1d2b27;
}

.detail-profile .role {
    font-size: 12px;
    color: #8a9a94;
}

.btn-secondary {
    background: transparent;
    color: #6c7a75;
    border: 1px solid #dce2e0;
    padding: 0.5rem 1.25rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 13px;
    font-family: inherit;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-secondary:hover {
    background: #f1f4f3;
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
}

@media (max-width: 992px) {
    .filter-grid {
        flex-direction: column;
        align-items: stretch;
    }
    .filter-item.search-item { flex: unset; }
    .filter-item-date { flex: unset; }
    .filter-actions { justify-content: flex-end; }
    .detail-grid { grid-template-columns: 1fr; }
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
    .modal-container {
        max-width: 100%;
        margin: 10px;
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
    .table-container { border-radius: 12px; }
    .table-toolbar { padding: 12px 16px; }
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
    .col-no, .col-user, .col-aktivitas, .col-deskripsi, .col-modul, .col-ip, .col-tanggal, .col-aksi {
        width: 100% !important;
        min-width: unset !important;
    }
    .col-aksi { justify-content: center; }
}
</style>
@endpush

@push('scripts')
<script>

// ============================================
// CLEAR LOGS
// ============================================
function clearLogs() {
    if (!confirm('⚠️ Apakah Anda yakin ingin menghapus SEMUA riwayat aktivitas?\n\nTindakan ini tidak dapat dibatalkan!')) {
        return;
    }

    fetch('{{ route('admin.riwayat.clear') }}', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            setTimeout(() => window.location.reload(), 500);
        } else {
            showToast(data.message || 'Gagal membersihkan data', 'error');
        }
    })
    .catch(error => {
        showToast('Terjadi kesalahan pada server', 'error');
    });
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
// MODAL FUNCTIONS
// ============================================
function openModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }
}

// Close modal on overlay click
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.modal-overlay').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.style.display = 'none';
                document.body.style.overflow = '';
            }
        });
    });
});

// Close modal with ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay:not([style*="display: none"])').forEach(modal => {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        });
    }
});

// ============================================
// DETAIL MODAL
// ============================================
function openDetailModal(id) {
    const loading = document.querySelector('#detailModalBody .detail-loading');
    const content = document.querySelector('#detailModalBody .detail-content');

    if (loading) loading.style.display = 'block';
    if (content) {
        content.style.display = 'none';
        content.innerHTML = '';
    }

    openModal('detailModal');

    fetch(`{{ route('admin.riwayat.index') }}/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const log = data.data;
                const user = log.user || { name: 'System', role: 'System', role_color: '#6b7280' };

                content.innerHTML = `
                    <div class="detail-profile">
                        <div class="avatar-lg" style="background: ${user.role_color}20; color: ${user.role_color}">
                            ${user.name.substring(0, 2).toUpperCase()}
                        </div>
                        <div class="name">${user.name}</div>
                        <div class="role">${user.role || 'System'}</div>
                    </div>
                    <div class="detail-grid">
                        <div class="detail-item full-width">
                            <label>Aktivitas</label>
                            <div class="detail-value">${log.aktivitas}</div>
                        </div>
                        <div class="detail-item full-width">
                            <label>Deskripsi</label>
                            <div class="detail-value ${!log.deskripsi ? 'empty' : ''}">${log.deskripsi || '-'}</div>
                        </div>
                        <div class="detail-item">
                            <label>Modul</label>
                            <div class="detail-value">${log.subject_type ? log.subject_type.split('\\').pop() : '-'}</div>
                        </div>
                        <div class="detail-item">
                            <label>ID Modul</label>
                            <div class="detail-value">${log.subject_id || '-'}</div>
                        </div>
                        <div class="detail-item">
                            <label>IP Address</label>
                            <div class="detail-value">${log.ip_address || '-'}</div>
                        </div>
                        <div class="detail-item">
                            <label>Method</label>
                            <div class="detail-value">
                                <span class="badge ${log.method === 'GET' ? 'badge-info' : (log.method === 'POST' ? 'badge-success' : (log.method === 'DELETE' ? 'badge-danger' : 'badge-secondary'))}">
                                    ${log.method || '-'}
                                </span>
                            </div>
                        </div>
                        <div class="detail-item full-width">
                            <label>URL</label>
                            <div class="detail-value" style="font-size:12px;word-break:break-all;">${log.url || '-'}</div>
                        </div>
                        <div class="detail-item full-width">
                            <label>User Agent</label>
                            <div class="detail-value" style="font-size:11px;word-break:break-all;">${log.user_agent || '-'}</div>
                        </div>
                        <div class="detail-item full-width">
                            <label>Waktu</label>
                            <div class="detail-value">${new Date(log.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' })}</div>
                        </div>
                    </div>
                `;

                // Tambahkan CSS badge
                const style = document.createElement('style');
                style.textContent = `
                    .badge { display: inline-block; padding: 2px 10px; border-radius: 10px; font-size: 11px; font-weight: 600; }
                    .badge-info { background: #dbeafe; color: #1e40af; }
                    .badge-success { background: #d1fae5; color: #065f46; }
                    .badge-danger { background: #fde8e8; color: #b91c1c; }
                    .badge-secondary { background: #e9ecef; color: #495057; }
                `;
                content.appendChild(style);

                if (loading) loading.style.display = 'none';
                content.style.display = 'block';
            } else {
                showToast('Gagal memuat data', 'error');
                closeModal('detailModal');
            }
        })
        .catch(() => {
            showToast('Terjadi kesalahan', 'error');
            closeModal('detailModal');
        });
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