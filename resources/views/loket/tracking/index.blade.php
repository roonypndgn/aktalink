@extends('layouts.loket')

@section('title', 'Tracking Permohonan - AKTALINK')
@section('page-title', 'Tracking Permohonan')
@section('page-description', 'Lacak status permohonan secara real-time')

@section('content')
{{-- ============================================
    TRACKING SEARCH
============================================ --}}
<div class="tracking-container">
    <div class="tracking-header">
        <div class="tracking-header-icon">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#07573c" stroke-width="1.5">
                <circle cx="11" cy="11" r="8"/>
                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
        </div>
        <div class="tracking-header-text">
            <h2>Lacak Permohonan Anda</h2>
            <p>Masukkan Nomor Permohonan atau NIK Pemohon untuk melacak status terbaru</p>
        </div>
    </div>

    <div class="tracking-search">
        <form method="GET" action="{{ route('loket.tracking.index') }}" id="trackingForm">
            <div class="search-box">
                <div class="search-type-selector">
                    <button type="button" class="type-btn {{ $searchType == 'nomor' ? 'active' : '' }}" data-type="nomor">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="7" width="20" height="14" rx="2"/>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                        </svg>
                        Nomor Permohonan
                    </button>
                    <button type="button" class="type-btn {{ $searchType == 'nik' ? 'active' : '' }}" data-type="nik">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        NIK / Nama
                    </button>
                </div>
                <div class="search-input-wrapper">
                    <input type="text" name="search_value" id="searchValue" 
                           class="search-input-tracking" 
                           placeholder="{{ $searchType == 'nomor' ? 'Masukkan Nomor Permohonan...' : 'Masukkan NIK atau Nama Pemohon...' }}"
                           value="{{ $searchValue }}">
                    <input type="hidden" name="search_type" id="searchType" value="{{ $searchType }}">
                    <button type="submit" class="btn-search">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        Lacak
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- ============================================
        TRACKING RESULT
    ============================================ --}}
    @if($searchValue)
        <div class="tracking-result">
            @if($result)
                @if($result instanceof \Illuminate\Database\Eloquent\Collection)
                    {{-- Multiple Results --}}
                    <div class="result-multiple">
                        <div class="result-header">
                            <h3>Ditemukan <span class="highlight">{{ $result->count() }}</span> permohonan</h3>
                            <p>Silakan pilih salah satu permohonan untuk melihat detail</p>
                        </div>
                        <div class="result-list">
                            @foreach($result as $item)
                            <div class="result-card" onclick="showTrackingDetail({{ $item->id }})">
                                <div class="result-card-left">
                                    <div class="result-number">{{ $item->nomor_permohonan }}</div>
                                    <div class="result-pemohon">
                                        <div class="result-avatar">{{ Str::substr($item->pemohon->nama_lengkap, 0, 2) }}</div>
                                        <div class="result-pemohon-info">
                                            <span class="result-name">{{ $item->pemohon->nama_lengkap }}</span>
                                            <span class="result-nik">{{ $item->pemohon->nik }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="result-card-right">
                                    <span class="status-badge" style="background: {{ $item->statusPermohonan->warna ?? '#6c757d' }}20; color: {{ $item->statusPermohonan->warna ?? '#6c757d' }}">
                                        <span class="status-dot" style="background: {{ $item->statusPermohonan->warna ?? '#6c757d' }}"></span>
                                        {{ $item->statusPermohonan->nama_status }}
                                    </span>
                                    <span class="result-date">{{ $item->tanggal_permohonan->setTimezone('Asia/Jakarta')->format('d M Y') }}</span>
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="9 18 15 12 9 6"/>
                                    </svg>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    {{-- Single Result --}}
                    @include('loket.tracking.partials.detail', ['permohonan' => $result])
                @endif
            @else
                <div class="result-empty">
                    <div class="empty-icon">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#b0c4bc" stroke-width="1.5">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                    </div>
                    <h4>Permohonan Tidak Ditemukan</h4>
                    <p>Pastikan nomor permohonan atau NIK yang Anda masukkan benar</p>
                    <div class="empty-tips">
                        <div class="tip-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#07573c" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                            <span>Cek kembali nomor permohonan</span>
                        </div>
                        <div class="tip-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#07573c" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                            <span>Pastikan NIK yang dimasukkan benar</span>
                        </div>
                        <div class="tip-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#07573c" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                            <span>Hubungi petugas jika masih kesulitan</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @else
        {{-- Default Empty State --}}
        <div class="tracking-default">
            <div class="default-content">
                <div class="default-icon">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#c5d9d0" stroke-width="1.5">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        <path d="M8 11L10 13L16 7"/>
                    </svg>
                </div>
                <h3>Lacak Status Permohonan</h3>
                <p>Cari tahu status terbaru permohonan Anda dengan memasukkan Nomor Permohonan atau NIK</p>
                <div class="default-features">
                    <div class="feature-item">
                        <div class="feature-icon" style="background: #d1fae5; color: #065f46;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                <polyline points="22 4 12 14.01 9 11.01"/>
                            </svg>
                        </div>
                        <span>Update Status Real-time</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon" style="background: #dbeafe; color: #2563eb;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="7" width="20" height="14" rx="2"/>
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                            </svg>
                        </div>
                        <span>Riwayat Status Lengkap</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon" style="background: #fef3c7; color: #92400e;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="17 8 12 3 7 8"/>
                                <line x1="12" y1="3" x2="12" y2="15"/>
                            </svg>
                        </div>
                        <span>Dokumen Terupload</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

{{-- ============================================
    MODAL DETAIL TRACKING
============================================ --}}
<div class="modal-overlay" id="trackingDetailModal" style="display: none;">
    <div class="modal-container modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-header-icon" style="background: linear-gradient(135deg, #07573c, #0d8a5a);">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                </div>
                <h4 class="modal-title">Detail Permohonan</h4>
                <button type="button" class="modal-close" onclick="closeModal('trackingDetailModal')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body" id="trackingDetailBody">
                <div class="loading-state">
                    <div class="spinner"></div>
                    <p>Memuat data...</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- TOAST --}}
<div id="toastContainer"></div>

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
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    transition: all 0.3s ease;
}
.hero-stat:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
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
.hero-stat-content { flex: 1; }
.hero-stat-value {
    display: block;
    font-size: 22px;
    font-weight: 800;
    color: #1d2b27;
}
.hero-stat-label {
    display: block;
    font-size: 11px;
    font-weight: 500;
    color: #8a9a94;
    margin-top: 2px;
}
.hero-stat-trend {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
}
.hero-stat-trend.up { color: #059669; background: #d1fae5; }
.hero-stat-trend.down { color: #dc2626; background: #fde8e8; }
.hero-stat-trend.neutral { color: #6b7280; background: #f3f4f6; }

/* ============================================
   TRACKING CONTAINER
============================================ */
.tracking-container {
    background: white;
    border-radius: 20px;
    border: 1px solid #f0f2f1;
    padding: 32px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}

/* ============================================
   TRACKING HEADER
============================================ */
.tracking-header {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 32px;
    padding-bottom: 24px;
    border-bottom: 1px solid #f0f2f1;
}
.tracking-header-icon {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    background: #f0f9f5;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.tracking-header-text h2 {
    font-size: 22px;
    font-weight: 800;
    color: #1d2b27;
    margin: 0;
}
.tracking-header-text p {
    margin: 4px 0 0;
    color: #8a9a94;
    font-size: 14px;
}

/* ============================================
   TRACKING SEARCH
============================================ */
.tracking-search {
    margin-bottom: 32px;
}
.search-box {
    background: #f8faf9;
    border-radius: 16px;
    padding: 8px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}
.search-box:focus-within {
    border-color: #07573c;
    box-shadow: 0 0 0 4px rgba(7,87,60,0.08);
}
.search-type-selector {
    display: flex;
    gap: 6px;
    padding: 0 6px 6px;
    border-bottom: 1px solid #e9ecef;
}
.type-btn {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 600;
    color: #6c7a75;
    background: transparent;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}
.type-btn:hover {
    background: #e8f0ed;
    color: #07573c;
}
.type-btn.active {
    background: #07573c;
    color: white;
}
.type-btn.active svg {
    stroke: white;
}
.type-btn svg {
    stroke: #6c7a75;
    transition: stroke 0.3s ease;
}
.search-input-wrapper {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 4px 6px;
}
.search-input-tracking {
    flex: 1;
    padding: 12px 16px;
    border: none;
    background: transparent;
    font-size: 15px;
    color: #1d2b27;
    outline: none;
}
.search-input-tracking::placeholder {
    color: #b0c4bc;
}
.btn-search {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 24px;
    background: linear-gradient(135deg, #07573c, #0d8a5a);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
}
.btn-search:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(7,87,60,0.3);
}
.btn-search:active {
    transform: translateY(0);
}

/* ============================================
   TRACKING DEFAULT
============================================ */
.tracking-default {
    text-align: center;
    padding: 40px 20px;
}
.default-content {
    max-width: 500px;
    margin: 0 auto;
}
.default-icon {
    margin-bottom: 20px;
    color: #c5d9d0;
}
.default-content h3 {
    font-size: 20px;
    font-weight: 700;
    color: #1d2b27;
    margin: 0;
}
.default-content p {
    color: #8a9a94;
    font-size: 14px;
    margin: 8px 0 24px;
}
.default-features {
    display: flex;
    justify-content: center;
    gap: 24px;
    flex-wrap: wrap;
}
.feature-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #4a5a54;
}
.feature-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.modal-detail-content {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* Status Banner */
.modal-status-banner {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    border-radius: 12px;
    background: #f8faf9;
    flex-wrap: wrap;
    gap: 12px;
}

.modal-status-left {
    display: flex;
    align-items: center;
    gap: 12px;
}

.modal-status-label {
    font-size: 12px;
    color: #8a9a94;
    font-weight: 500;
}

.modal-status-name {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 16px;
    font-weight: 700;
}

.modal-status-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    display: inline-block;
    animation: pulse-dot-modal 2s ease-in-out infinite;
}

@keyframes pulse-dot-modal {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.3); opacity: 0.7; }
}

.modal-status-right {
    display: flex;
    align-items: center;
    gap: 12px;
}

.modal-priority {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
}
.modal-priority.priority-normal {
    background: #e8f0ed;
    color: #4a5a54;
}
.modal-priority.priority-penting {
    background: #fef3c7;
    color: #92400e;
}
.modal-priority.priority-urgent {
    background: #fde8e8;
    color: #b91c1c;
}

.modal-date {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 12px;
    color: #8a9a94;
}

/* Info Grid */
.modal-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.modal-info-card {
    background: #fafcfb;
    border-radius: 12px;
    padding: 16px 18px;
    border: 1px solid #f0f2f1;
}

.modal-info-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 700;
    color: #1d2b27;
    margin-bottom: 12px;
    padding-bottom: 10px;
    border-bottom: 1px solid #f0f2f1;
}

.modal-info-row {
    display: flex;
    justify-content: space-between;
    padding: 4px 0;
    font-size: 13px;
}

.modal-info-label {
    color: #8a9a94;
    font-weight: 500;
}

.modal-info-value {
    color: #1d2b27;
    text-align: right;
    max-width: 60%;
}

/* Pemohon Profile */
.modal-pemohon-profile {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f0f2f1;
}

.modal-pemohon-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: linear-gradient(135deg, #07573c, #0d8a5a);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 700;
    flex-shrink: 0;
}

.modal-pemohon-name {
    font-size: 14px;
    font-weight: 700;
    color: #1d2b27;
}

.modal-pemohon-nik {
    font-size: 12px;
    color: #8a9a94;
}

/* Timeline Section */
.modal-timeline-section {
    background: #fafcfb;
    border-radius: 12px;
    border: 1px solid #f0f2f1;
    overflow: hidden;
}

.modal-timeline-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 18px;
    border-bottom: 1px solid #f0f2f1;
    background: white;
}

.modal-timeline-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 700;
    color: #1d2b27;
}

.modal-timeline-count {
    font-size: 11px;
    color: #8a9a94;
    padding: 2px 10px;
    background: #f0f5f2;
    border-radius: 12px;
}

.modal-timeline-list {
    padding: 16px 18px;
    max-height: 320px;
    overflow-y: auto;
}

.modal-timeline-list::-webkit-scrollbar {
    width: 4px;
}

.modal-timeline-list::-webkit-scrollbar-thumb {
    background: #dce2e0;
    border-radius: 4px;
}

.modal-timeline-item {
    position: relative;
    padding-left: 32px;
    padding-bottom: 16px;
}

.modal-timeline-item:last-child {
    padding-bottom: 0;
}

.modal-timeline-item.active .modal-timeline-status {
    font-weight: 700;
}

.modal-timeline-dot {
    position: absolute;
    left: 4px;
    top: 4px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid white;
    z-index: 2;
    transition: all 0.3s ease;
}

.modal-timeline-pulse {
    position: absolute;
    inset: -4px;
    border-radius: 50%;
    animation: pulse-dot-modal 2s ease-in-out infinite;
    z-index: -1;
}

.modal-timeline-line {
    position: absolute;
    left: 9px;
    top: 20px;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.modal-timeline-content {
    padding-left: 4px;
}

.modal-timeline-status {
    font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.modal-timeline-badge {
    font-size: 10px;
    font-weight: 600;
    color: #059669;
    background: #d1fae5;
    padding: 1px 10px;
    border-radius: 12px;
}

.modal-timeline-meta {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 11px;
    color: #8a9a94;
    margin-top: 2px;
}

.modal-timeline-user {
    display: flex;
    align-items: center;
    gap: 4px;
}

.modal-timeline-note {
    margin-top: 4px;
    padding: 6px 10px;
    background: white;
    border-radius: 6px;
    font-size: 12px;
    color: #4a5a54;
    border: 1px solid #f0f2f1;
}

/* Dokumen Section */
.modal-dokumen-section {
    background: #fafcfb;
    border-radius: 12px;
    border: 1px solid #f0f2f1;
    overflow: hidden;
}

.modal-dokumen-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 18px;
    border-bottom: 1px solid #f0f2f1;
    background: white;
}

.modal-dokumen-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 700;
    color: #1d2b27;
}

.modal-dokumen-count {
    font-size: 11px;
    color: #8a9a94;
    padding: 2px 10px;
    background: #f0f5f2;
    border-radius: 12px;
}

.modal-dokumen-list {
    padding: 12px 18px;
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.modal-dokumen-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 12px;
    background: white;
    border-radius: 8px;
    border: 1px solid #f0f2f1;
    text-decoration: none;
    color: #1d2b27;
    transition: all 0.3s ease;
}

.modal-dokumen-item:hover {
    border-color: #07573c;
    transform: translateX(4px);
    box-shadow: 0 2px 8px rgba(7,87,60,0.08);
}

.modal-dokumen-icon {
    font-size: 16px;
}

.modal-dokumen-name {
    flex: 1;
    font-size: 12px;
    font-weight: 500;
    color: #1d2b27;
}

.modal-dokumen-size {
    font-size: 11px;
    color: #8a9a94;
}

.modal-dokumen-action {
    color: #b0c4bc;
    transition: color 0.3s ease;
}

.modal-dokumen-item:hover .modal-dokumen-action {
    color: #07573c;
}

/* Empty State */
.modal-empty-state {
    text-align: center;
    padding: 40px 20px;
}

.modal-empty-icon {
    font-size: 48px;
    margin-bottom: 12px;
}

.modal-empty-state h4 {
    font-size: 16px;
    font-weight: 700;
    color: #1d2b27;
    margin: 0;
}

.modal-empty-state p {
    color: #8a9a94;
    font-size: 14px;
    margin: 4px 0 0;
}

/* Loading State */
.loading-state {
    text-align: center;
    padding: 40px 20px;
}

.spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #f0f2f1;
    border-top-color: #07573c;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
    margin: 0 auto 12px;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.loading-state p {
    color: #8a9a94;
    font-size: 14px;
}

/* Responsive */
@media (max-width: 768px) {
    .modal-info-grid {
        grid-template-columns: 1fr;
    }
    
    .modal-status-banner {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .modal-status-right {
        flex-wrap: wrap;
    }
    
    .modal-info-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 2px;
    }
    
    .modal-info-value {
        text-align: left;
        max-width: 100%;
    }
}
/* ============================================
   RESULT SINGLE
============================================ */
.result-single {
    animation: fadeInUp 0.4s ease;
}
.result-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 12px;
}
.result-header h3 {
    font-size: 18px;
    font-weight: 700;
    color: #1d2b27;
    margin: 0;
}
.result-header .highlight {
    color: #07573c;
}
.result-actions {
    display: flex;
    gap: 8px;
}
.btn-small-outline {
    padding: 6px 14px;
    border: 1px solid #dce2e0;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    color: #4a5a54;
    background: transparent;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 6px;
}
.btn-small-outline:hover {
    background: #f0f5f2;
    border-color: #07573c;
    color: #07573c;
}
.btn-small-primary {
    padding: 6px 14px;
    background: #07573c;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 6px;
}
.btn-small-primary:hover {
    background: #043d2a;
}
/* ============================================
   TIMELINE MODERN - REDESIGNED
============================================ */
.timeline-wrapper {
    margin-top: 24px;
    background: white;
    border-radius: 16px;
    border: 1px solid #f0f2f1;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

.timeline-header-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 24px;
    border-bottom: 1px solid #f0f2f1;
    background: #fafcfb;
}

.timeline-header-left {
    display: flex;
    align-items: center;
    gap: 10px;
}

.timeline-header-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #d1fae5;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #065f46;
}

.timeline-header-left h4 {
    margin: 0;
    font-size: 14px;
    font-weight: 700;
    color: #1d2b27;
}

.timeline-header-right {
    font-size: 12px;
    color: #8a9a94;
    font-weight: 500;
}

.timeline-count {
    padding: 2px 12px;
    background: #f0f5f2;
    border-radius: 12px;
}

/* Timeline Items */
.timeline-modern {
    padding: 24px 24px 12px;
    position: relative;
}

.timeline-item-modern {
    position: relative;
    padding-left: 44px;
    padding-bottom: 24px;
}

.timeline-item-modern:last-child {
    padding-bottom: 0;
}

.timeline-item-modern.active .timeline-card {
    border-color: #07573c;
    background: #fafcfb;
}

.timeline-line {
    position: absolute;
    left: 14px;
    top: 28px;
    bottom: 0;
    width: 0;
    border-left: 2px dashed;
    border-left-color: #e9ecef;
}

.timeline-dot-modern {
    position: absolute;
    left: 8px;
    top: 6px;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    border: 2px solid white;
    z-index: 2;
    transition: all 0.3s ease;
}

.timeline-dot-pulse {
    position: absolute;
    inset: -4px;
    border-radius: 50%;
    animation: pulse-dot 2s ease-in-out infinite;
    z-index: -1;
}

@keyframes pulse-dot {
    0% {
        transform: scale(1);
        opacity: 0.6;
    }
    50% {
        transform: scale(1.8);
        opacity: 0;
    }
    100% {
        transform: scale(1);
        opacity: 0;
    }
}

/* Timeline Card */
.timeline-card {
    background: white;
    border-radius: 12px;
    border: 1px solid #f0f2f1;
    overflow: hidden;
    transition: all 0.3s ease;
}

.timeline-card:hover {
    border-color: #dce2e0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.04);
}

.timeline-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 16px;
    border-bottom: 1px solid #f5f7f6;
    flex-wrap: wrap;
    gap: 8px;
}

.timeline-status-modern {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 700;
}

.status-badge-current {
    font-size: 10px;
    font-weight: 600;
    color: #059669;
    background: #d1fae5;
    padding: 2px 10px;
    border-radius: 12px;
    animation: glow-badge 2s ease-in-out infinite;
}

@keyframes glow-badge {
    0%, 100% { opacity: 0.8; }
    50% { opacity: 1; box-shadow: 0 0 8px rgba(5, 150, 105, 0.3); }
}

.timeline-time-modern {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 12px;
    color: #8a9a94;
    font-weight: 500;
}

.timeline-card-body {
    padding: 12px 16px;
}

.timeline-user-modern {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.user-avatar-small {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: 700;
}

.user-name {
    font-size: 12px;
    font-weight: 600;
    color: #1d2b27;
}

.status-change {
    font-size: 11px;
    color: #8a9a94;
    display: flex;
    align-items: center;
    gap: 4px;
}

.timeline-note-modern {
    margin-top: 8px;
    padding: 8px 12px;
    background: #f8faf9;
    border-radius: 8px;
    font-size: 13px;
    color: #4a5a54;
    display: flex;
    align-items: flex-start;
    gap: 6px;
    line-height: 1.5;
}

.timeline-note-modern svg {
    flex-shrink: 0;
    margin-top: 2px;
    color: #8a9a94;
}

/* Timeline Footer */
.timeline-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 24px;
    background: #f8faf9;
    border-top: 1px solid #f0f2f1;
    flex-wrap: wrap;
    gap: 8px;
}

.timeline-footer-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: #6c7a75;
}

.dot-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
}

/* ============================================
   DOKUMEN WRAPPER
============================================ */
.dokumen-wrapper {
    margin-top: 16px;
    background: white;
    border-radius: 16px;
    border: 1px solid #f0f2f1;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

.dokumen-header-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 24px;
    border-bottom: 1px solid #f0f2f1;
    background: #fafcfb;
}

.dokumen-header-left {
    display: flex;
    align-items: center;
    gap: 10px;
}

.dokumen-header-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #fef3c7;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #92400e;
}

.dokumen-header-left h4 {
    margin: 0;
    font-size: 14px;
    font-weight: 700;
    color: #1d2b27;
}

.dokumen-header-right {
    font-size: 12px;
    color: #8a9a94;
    font-weight: 500;
}

.dokumen-count {
    padding: 2px 12px;
    background: #f0f5f2;
    border-radius: 12px;
}

.dokumen-grid-modern {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 8px;
    padding: 16px 24px;
}

.dokumen-item-modern {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    background: #fafcfb;
    border-radius: 10px;
    border: 1px solid #f0f2f1;
    text-decoration: none;
    color: #1d2b27;
    transition: all 0.3s ease;
    cursor: pointer;
}

.dokumen-item-modern:hover {
    border-color: #07573c;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(7,87,60,0.08);
}

.dokumen-icon-wrap {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.dokumen-icon-big {
    font-size: 18px;
}

.dokumen-info-wrap {
    flex: 1;
    min-width: 0;
}

.dokumen-name {
    font-size: 12px;
    font-weight: 600;
    color: #1d2b27;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.dokumen-size {
    font-size: 10px;
    color: #8a9a94;
}

.dokumen-action-wrap {
    flex-shrink: 0;
    color: #b0c4bc;
    transition: color 0.3s ease;
}

.dokumen-item-modern:hover .dokumen-action-wrap {
    color: #07573c;
}

/* ============================================
   RESPONSIVE
============================================ */
@media (max-width: 768px) {
    .timeline-modern {
        padding: 16px 16px 8px;
    }
    .timeline-item-modern {
        padding-left: 36px;
        padding-bottom: 16px;
    }
    .timeline-dot-modern {
        left: 2px;
        width: 12px;
        height: 12px;
    }
    .timeline-line {
        left: 8px;
    }
    .timeline-card-header {
        flex-direction: column;
        align-items: flex-start;
    }
    .timeline-footer {
        flex-direction: column;
        align-items: flex-start;
    }
    .dokumen-grid-modern {
        grid-template-columns: 1fr;
        padding: 12px 16px;
    }
    .timeline-header-section,
    .dokumen-header-section {
        padding: 12px 16px;
        flex-wrap: wrap;
    }
}
/* ============================================
   TRACKING CARD
============================================ */
.tracking-card {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}
.tracking-card .card {
    background: #fafcfb;
    border-radius: 16px;
    padding: 20px 24px;
}
.tracking-card .card-title {
    font-size: 13px;
    font-weight: 700;
    color: #8a9a94;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.info-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #f0f2f1;
}
.info-row:last-child {
    border-bottom: none;
}
.info-row .label {
    color: #6c7a75;
    font-size: 13px;
}
.info-row .value {
    font-weight: 600;
    color: #1d2b27;
    font-size: 13px;
    text-align: right;
}

/* ============================================
   TIMELINE
============================================ */
.timeline-tracking {
    position: relative;
    padding-left: 28px;
}
.timeline-tracking::before {
    content: '';
    position: absolute;
    left: 8px;
    top: 4px;
    bottom: 4px;
    width: 2px;
    background: #e9ecef;
}
.timeline-item-tracking {
    position: relative;
    padding-bottom: 20px;
}
.timeline-item-tracking:last-child {
    padding-bottom: 0;
}
.timeline-dot-tracking {
    position: absolute;
    left: -20px;
    top: 4px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 0 0 2px #e9ecef;
}
.timeline-dot-tracking.active {
    box-shadow: 0 0 0 3px rgba(7,87,60,0.3);
}
.timeline-content-tracking {
    padding-left: 4px;
}
.timeline-status-tracking {
    font-weight: 700;
    font-size: 14px;
}
.timeline-meta-tracking {
    font-size: 12px;
    color: #8a9a94;
    margin-top: 2px;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}
.timeline-meta-tracking .user {
    display: flex;
    align-items: center;
    gap: 4px;
}
.timeline-note-tracking {
    font-size: 13px;
    color: #4a5a54;
    margin-top: 4px;
    padding: 6px 12px;
    background: #f5f7f6;
    border-radius: 6px;
}

/* ============================================
   RESULT MULTIPLE
============================================ */
.result-multiple {
    animation: fadeInUp 0.4s ease;
}
.result-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.result-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    background: #fafcfb;
    border-radius: 12px;
    border: 1px solid #f0f2f1;
    cursor: pointer;
    transition: all 0.3s ease;
}
.result-card:hover {
    background: white;
    border-color: #07573c;
    box-shadow: 0 4px 16px rgba(7,87,60,0.08);
    transform: translateX(4px);
}
.result-card-left {
    display: flex;
    align-items: center;
    gap: 16px;
}
.result-number {
    font-weight: 700;
    color: #07573c;
    font-size: 14px;
}
.result-pemohon {
    display: flex;
    align-items: center;
    gap: 10px;
}
.result-avatar {
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
.result-pemohon-info {
    display: flex;
    flex-direction: column;
}
.result-name {
    font-weight: 600;
    font-size: 13px;
    color: #1d2b27;
}
.result-nik {
    font-size: 11px;
    color: #8a9a94;
}
.result-card-right {
    display: flex;
    align-items: center;
    gap: 12px;
}
.result-date {
    font-size: 12px;
    color: #8a9a94;
}

/* ============================================
   RESULT EMPTY
============================================ */
.result-empty {
    text-align: center;
    padding: 40px 20px;
}
.result-empty .empty-icon {
    margin-bottom: 16px;
    color: #d0dcd6;
}
.result-empty h4 {
    font-size: 18px;
    font-weight: 700;
    color: #1d2b27;
    margin: 0;
}
.result-empty p {
    color: #8a9a94;
    font-size: 14px;
    margin: 4px 0 20px;
}
.empty-tips {
    display: flex;
    justify-content: center;
    gap: 24px;
    flex-wrap: wrap;
}
.tip-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: #4a5a54;
}
.tip-item svg {
    flex-shrink: 0;
}

/* ============================================
   LOADING
============================================ */
.loading-state {
    text-align: center;
    padding: 40px 20px;
}
.spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #f0f2f1;
    border-top-color: #07573c;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
    margin: 0 auto 12px;
}
@keyframes spin {
    to { transform: rotate(360deg); }
}
.loading-state p {
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
    background: rgba(0,0,0,0.5);
    backdrop-filter: blur(8px);
    display: none;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}
.modal-container.modal-lg {
    max-width: 700px;
}
.modal-content {
    background: white;
    border-radius: 20px;
    box-shadow: 0 25px 60px rgba(0,0,0,0.2);
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
}
.modal-title { flex: 1; font-size: 1.1rem; font-weight: 700; color: #1d2b27; }
.modal-close {
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 50%;
    background: transparent;
    color: #8a9a94;
    cursor: pointer;
}
.modal-close:hover { background: #f0f5f2; color: #1d2b27; }
.modal-body {
    padding: 1.5rem;
    overflow-y: auto;
    max-height: calc(90vh - 160px);
}

/* ============================================
   ANIMATIONS
============================================ */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ============================================
   RESPONSIVE
============================================ */
@media (max-width: 992px) {
    .hero-stats { grid-template-columns: 1fr 1fr; }
    .tracking-card { grid-template-columns: 1fr; }
}
@media (max-width: 768px) {
    .hero-stats { grid-template-columns: 1fr; }
    .tracking-container { padding: 20px; }
    .tracking-header { flex-direction: column; text-align: center; }
    .search-type-selector { flex-wrap: wrap; }
    .type-btn { flex: 1; justify-content: center; }
    .search-input-wrapper { flex-wrap: wrap; }
    .btn-search { width: 100%; justify-content: center; }
    .result-card { flex-direction: column; align-items: flex-start; gap: 12px; }
    .result-card-right { width: 100%; justify-content: space-between; }
    .default-features { flex-direction: column; align-items: center; }
    .empty-tips { flex-direction: column; align-items: center; }
}
@media (max-width: 480px) {
    .tracking-container { padding: 16px; }
    .tracking-header-icon { width: 48px; height: 48px; }
    .tracking-header-text h2 { font-size: 18px; }
    .search-input-tracking { font-size: 13px; }
    .modal-container.modal-lg { max-width: 100%; margin: 10px; }
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
// SEARCH TYPE TOGGLE
// ============================================
document.querySelectorAll('.type-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.type-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        const type = this.dataset.type;
        document.getElementById('searchType').value = type;
        
        const input = document.getElementById('searchValue');
        if (type === 'nomor') {
            input.placeholder = 'Masukkan Nomor Permohonan...';
        } else {
            input.placeholder = 'Masukkan NIK atau Nama Pemohon...';
        }
        input.focus();
    });
});

// Enter key submit
document.getElementById('searchValue')?.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('trackingForm').submit();
    }
});

// ============================================
// TRACKING DETAIL MODAL - REDESIGN
// ============================================
function showTrackingDetail(id) {
    const modal = document.getElementById('trackingDetailModal');
    const body = document.getElementById('trackingDetailBody');
    
    body.innerHTML = `
        <div class="loading-state">
            <div class="spinner"></div>
            <p>Memuat data...</p>
        </div>
    `;
    
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    fetch(`{{ url('loket/tracking/detail') }}?id=${id}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const d = data.data;
                const permohonan = d.permohonan;
                const timeline = d.timeline;
                
                let html = `
                    <div class="modal-detail-content">
                        {{-- STATUS BANNER --}}
                        <div class="modal-status-banner" style="background: ${permohonan.status_permohonan.warna}15; border-left: 4px solid ${permohonan.status_permohonan.warna};">
                            <div class="modal-status-left">
                                <span class="modal-status-label">Status Saat Ini</span>
                                <span class="modal-status-name" style="color: ${permohonan.status_permohonan.warna}">
                                    <span class="modal-status-dot" style="background: ${permohonan.status_permohonan.warna};"></span>
                                    ${permohonan.status_permohonan.nama_status}
                                </span>
                            </div>
                            <div class="modal-status-right">
                                <span class="modal-date">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    ${new Date(permohonan.updated_at).toLocaleString('id-ID', { 
                                        day: 'numeric', 
                                        month: 'short', 
                                        year: 'numeric', 
                                        hour: '2-digit', 
                                        minute: '2-digit' 
                                    })}
                                </span>
                            </div>
                        </div>

                        {{-- GRID INFO --}}
                        <div class="modal-info-grid">
                            {{-- Left: Permohonan --}}
                            <div class="modal-info-card">
                                <div class="modal-info-title">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#07573c" stroke-width="2">
                                        <rect x="2" y="7" width="20" height="14" rx="2"/>
                                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                                    </svg>
                                    Informasi Permohonan
                                </div>
                                <div class="modal-info-row">
                                    <span class="modal-info-label">Nomor</span>
                                    <span class="modal-info-value"><strong>${permohonan.nomor_permohonan}</strong></span>
                                </div>
                                <div class="modal-info-row">
                                    <span class="modal-info-label">Layanan</span>
                                    <span class="modal-info-value">${permohonan.jenis_layanan.nama_layanan}</span>
                                </div>
                                <div class="modal-info-row">
                                    <span class="modal-info-label">Tanggal</span>
                                    <span class="modal-info-value">${new Date(permohonan.tanggal_permohonan).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })}</span>
                                </div>
                                ${permohonan.catatan_loket ? `
                                <div class="modal-info-row">
                                    <span class="modal-info-label">Catatan</span>
                                    <span class="modal-info-value">${permohonan.catatan_loket}</span>
                                </div>
                                ` : ''}
                            </div>

                            {{-- Right: Pemohon --}}
                            <div class="modal-info-card">
                                <div class="modal-info-title">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#07573c" stroke-width="2">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                        <circle cx="12" cy="7" r="4"/>
                                    </svg>
                                    Data Pemohon
                                </div>
                                <div class="modal-pemohon-profile">
                                    <div class="modal-pemohon-avatar">
                                        ${permohonan.pemohon.nama_lengkap.substring(0, 2).toUpperCase()}
                                    </div>
                                    <div class="modal-pemohon-info">
                                        <div class="modal-pemohon-name">${permohonan.pemohon.nama_lengkap}</div>
                                        <div class="modal-pemohon-nik">NIK: ${permohonan.pemohon.nik}</div>
                                    </div>
                                </div>
                                <div class="modal-info-row">
                                    <span class="modal-info-label">Tempat, Tgl Lahir</span>
                                    <span class="modal-info-value">${permohonan.pemohon.tempat_lahir || '-'}, ${permohonan.pemohon.tanggal_lahir ? new Date(permohonan.pemohon.tanggal_lahir).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) : '-'}</span>
                                </div>
                                <div class="modal-info-row">
                                    <span class="modal-info-label">Jenis Kelamin</span>
                                    <span class="modal-info-value">${permohonan.pemohon.jenis_kelamin == 'L' ? 'Laki-laki' : (permohonan.pemohon.jenis_kelamin == 'P' ? 'Perempuan' : '-')}</span>
                                </div>
                                <div class="modal-info-row">
                                    <span class="modal-info-label">No. Telepon</span>
                                    <span class="modal-info-value">${permohonan.pemohon.no_telepon || '-'}</span>
                                </div>
                            </div>
                        </div>

                        {{-- TIMELINE --}}
                        <div class="modal-timeline-section">
                            <div class="modal-timeline-header">
                                <div class="modal-timeline-title">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#07573c" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    Riwayat Status
                                </div>
                                <span class="modal-timeline-count">${timeline.length} perubahan</span>
                            </div>
                            <div class="modal-timeline-list">
                `;
                
                timeline.forEach((item, index) => {
                    const isFirst = index === 0;
                    html += `
                        <div class="modal-timeline-item ${isFirst ? 'active' : ''}">
                            <div class="modal-timeline-dot" style="background: ${item.warna}; ${isFirst ? `box-shadow: 0 0 0 4px ${item.warna}25, 0 0 0 8px ${item.warna}12;` : ''}">
                                ${isFirst ? `<div class="modal-timeline-pulse" style="background: ${item.warna};"></div>` : ''}
                            </div>
                            ${!isFirst ? `<div class="modal-timeline-line"></div>` : ''}
                            <div class="modal-timeline-content">
                                <div class="modal-timeline-status" style="color: ${item.warna}">
                                    ${item.status}
                                    ${isFirst ? `<span class="modal-timeline-badge">● Saat Ini</span>` : ''}
                                </div>
                                <div class="modal-timeline-meta">
                                    <span class="modal-timeline-user">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                            <circle cx="12" cy="7" r="4"/>
                                        </svg>
                                        ${item.changed_by}
                                    </span>
                                    <span class="modal-timeline-time">${item.changed_at}</span>
                                </div>
                                ${item.keterangan ? `<div class="modal-timeline-note">${item.keterangan}</div>` : ''}
                            </div>
                        </div>
                    `;
                });
                
                html += `
                            </div>
                        </div>

                        {{-- DOKUMEN --}}
                        ${permohonan.dokumen && permohonan.dokumen.length > 0 ? `
                        <div class="modal-dokumen-section">
                            <div class="modal-dokumen-header">
                                <div class="modal-dokumen-title">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#07573c" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                        <polyline points="17 8 12 3 7 8"/>
                                        <line x1="12" y1="3" x2="12" y2="15"/>
                                    </svg>
                                    Dokumen Terupload
                                </div>
                                <span class="modal-dokumen-count">${permohonan.dokumen.length} file</span>
                            </div>
                            <div class="modal-dokumen-list">
                                ${permohonan.dokumen.map(dok => `
                                    <a href="${dok.file_url}" target="_blank" class="modal-dokumen-item">
                                        <span class="modal-dokumen-icon">${dok.file_name.split('.').pop() === 'pdf' ? '📄' : '📎'}</span>
                                        <span class="modal-dokumen-name">${dok.nama_dokumen}</span>
                                        <span class="modal-dokumen-size">${dok.file_size_formatted}</span>
                                        <span class="modal-dokumen-action">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="15 3 21 3 21 9"/>
                                                <line x1="10" y1="14" x2="21" y2="3"/>
                                            </svg>
                                        </span>
                                    </a>
                                `).join('')}
                            </div>
                        </div>
                        ` : ''}
                    </div>
                `;
                
                body.innerHTML = html;
                
                // Re-initialize Lucide icons
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            } else {
                body.innerHTML = `
                    <div class="modal-empty-state">
                        <div class="modal-empty-icon">🔍</div>
                        <h4>Data Tidak Ditemukan</h4>
                        <p>${data.message || 'Permohonan tidak ditemukan'}</p>
                    </div>
                `;
            }
        })
        .catch(err => {
            console.error(err);
            body.innerHTML = `
                <div class="modal-empty-state">
                    <div class="modal-empty-icon">⚠️</div>
                    <h4>Terjadi Kesalahan</h4>
                    <p>Gagal memuat data permohonan</p>
                </div>
            `;
            showToast('Gagal memuat detail permohonan', 'error');
        });
}

// ============================================
// MODAL
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

document.querySelectorAll('.modal-overlay').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) { 
            this.style.display = 'none'; 
            document.body.style.overflow = ''; 
        }
    });
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay:not([style*="display: none"])').forEach(modal => {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        });
    }
});

// ============================================
// AUTO-CLOSE TOAST
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        showToast('{{ session('success') }}', 'success');
    @endif
    @if(session('error'))
        showToast('{{ session('error') }}', 'error');
    @endif
});

console.log('✅ Tracking module loaded successfully');
</script>
@endpush