@extends('layouts.loket')

@section('title', 'Dashboard - AKTALINK')
@section('page-title', 'Dashboard')
@section('page-description', 'Ringkasan semua permohonan layanan')

@section('page-actions')
    <button type="button" class="btn-pdf" onclick="openCreateModal()">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Tambah Permohonan
    </button>
@endsection

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
            <span class="stat-card-label">Menunggu</span>
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
            <span class="stat-card-label">Diproses</span>
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
                <a href="{{ route('loket.permohonan.index') }}" class="card-link">
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

        {{-- PERMOHONAN PER LAYANAN --}}
<div class="dashboard-card">
    <div class="dashboard-card-header">
        <div class="card-header-left">
            <div class="card-icon" style="background: #dbeafe; color: #2563eb;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
            </div>
            <span class="card-title">Per Layanan</span>
        </div>
    </div>
    <div class="dashboard-card-body">
        @if($layananStats->count() > 0)
            <div class="layanan-list">
                @foreach($layananStats as $layanan)
                <div class="layanan-item">
                    <div class="layanan-left">
                        <span class="layanan-name">{{ $layanan->nama_layanan }}</span>
                        <span class="layanan-code">{{ $layanan->kode_layanan }}</span>
                    </div>
                    <div class="layanan-right">
                        <span class="layanan-count">{{ $layanan->permohonans_count }}</span> {{-- perbaiki di sini --}}
                        <div class="layanan-bar-wrap">
                            <div class="layanan-bar" style="width: {{ $stats['total'] > 0 ? round(($layanan->permohonans_count / $stats['total']) * 100) : 0 }}%;"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="empty-state-dashboard">
                <div class="empty-icon">📋</div>
                <p>Belum ada layanan</p>
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
                    <a href="{{ route('loket.permohonan.index') }}" class="quick-action-item" style="background: linear-gradient(135deg, #d1fae5, #a7f3d0);">
                        
                        <span class="quick-label">Semua Permohonan</span>
                    </a>
                    <a href="{{ route('loket.permohonan.diteruskan') }}" class="quick-action-item" style="background: linear-gradient(135deg, #fef3c7, #fde68a);">
                        
                        <span class="quick-label">Perlu Diteruskan</span>
                        @if($stats['menunggu'] > 0)
                        <span class="quick-badge">{{ $stats['menunggu'] }}</span>
                        @endif
                    </a>
                    <a href="{{ route('loket.permohonan.proses') }}" class="quick-action-item" style="background: linear-gradient(135deg, #dbeafe, #93c5fd);">
                       
                        <span class="quick-label">Sedang Diproses</span>
                        @if($stats['proses'] > 0)
                        <span class="quick-badge">{{ $stats['proses'] }}</span>
                        @endif
                    </a>
                    <a href="{{ route('loket.permohonan.selesai') }}" class="quick-action-item" style="background: linear-gradient(135deg, #d1fae5, #6ee7b7);">
                        
                        <span class="quick-label">Selesai</span>
                        @if($stats['selesai'] > 0)
                        <span class="quick-badge">{{ $stats['selesai'] }}</span>
                        @endif
                    </a>
                    <button type="button" class="quick-action-item" style="background: linear-gradient(135deg, #ede9fe, #c4b5fd);" onclick="openCreateModal()">
                       
                        <span class="quick-label">Tambah Permohonan</span>
                    </button>
                    <a href="{{ route('loket.tracking.index') }}" class="quick-action-item" style="background: linear-gradient(135deg, #fce4ec, #f9a8d4);">
                        
                        <span class="quick-label">Tracking</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============================================
    MODAL CREATE (DARI INDEX)
============================================ --}}
<div class="modal-overlay" id="createModal" style="display: none;">
    <div class="modal-container modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-header-icon" style="background: #d1fae5; color: #065f46;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                </div>
                <h4 class="modal-title">Tambah Permohonan</h4>
                <button type="button" class="modal-close" onclick="closeModal('createModal')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            <form id="createForm" method="POST" action="{{ route('loket.permohonan.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label class="form-label">Pemohon <span class="text-danger">*</span></label>
                            <select name="pemohon_id" class="form-select" required>
                                <option value="">-- Pilih Pemohon --</option>
                                @php
                                    $pemohons = \App\Models\Pemohon::orderBy('nama_lengkap')->get();
                                @endphp
                                @foreach($pemohons as $pemohon)
                                <option value="{{ $pemohon->id }}">{{ $pemohon->nama_lengkap }} ({{ $pemohon->nik }})</option>
                                @endforeach
                            </select>
                            <span class="form-error" id="error-pemohon_id"></span>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">Judul Permohonan</label>
                            <input type="text" name="judul_permohonan" class="form-input" placeholder="Masukkan judul permohonan">
                            <span class="form-error" id="error-judul_permohonan"></span>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">Keterangan <span class="text-danger">*</span></label>
                            <textarea name="keterangan" class="form-textarea" rows="3" placeholder="Deskripsikan permasalahan" required></textarea>
                            <span class="form-error" id="error-keterangan"></span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Jenis Layanan <span class="text-danger">*</span></label>
                            <select name="jenis_layanan_id" id="create_jenis_layanan_id" class="form-select" required>
                                <option value="">-- Pilih Layanan --</option>
                                @php
                                    $layanans = \App\Models\JenisLayanan::where('is_active', true)->get();
                                    $roleTujuan = $layanans->pluck('role_tujuan', 'id')->toArray();
                                @endphp
                                @foreach($layanans as $layanan)
                                <option value="{{ $layanan->id }}" data-role="{{ $roleTujuan[$layanan->id] ?? '' }}">
                                    {{ $layanan->nama_layanan }}
                                </option>
                                @endforeach
                            </select>
                            <span class="form-error" id="error-jenis_layanan_id"></span>
                            <div id="create_distribusi_info" class="distribusi-info-text" style="display: none;">
                                <span id="create_distribusi_text">Permohonan akan diteruskan ke petugas terkait</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status_permohonan_id" class="form-select" required>
                                <option value="">-- Pilih Status --</option>
                                @php
                                    $statuses = \App\Models\StatusPermohonan::where('is_active', true)->get();
                                @endphp
                                @foreach($statuses as $status)
                                <option value="{{ $status->id }}">{{ $status->nama_status }}</option>
                                @endforeach
                            </select>
                            <span class="form-error" id="error-status_permohonan_id"></span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Prioritas <span class="text-danger">*</span></label>
                            <select name="prioritas" class="form-select" required>
                                <option value="normal">Normal</option>
                                <option value="penting">Penting</option>
                                <option value="urgent">Urgent</option>
                            </select>
                            <span class="form-error" id="error-prioritas"></span>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">Catatan Loket</label>
                            <textarea name="catatan_loket" class="form-textarea" rows="2"></textarea>
                            <span class="form-error" id="error-catatan_loket"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeModal('createModal')">Batal</button>
                    <button type="submit" class="btn-primary" id="createSubmit">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Simpan
                    </button>
                </div>
            </form>
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
   LAYANAN LIST
============================================ */
.layanan-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.layanan-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}

.layanan-left {
    display: flex;
    align-items: center;
    gap: 8px;
    min-width: 140px;
}

.layanan-name {
    font-size: 13px;
    font-weight: 500;
    color: #1d2b27;
}

.layanan-code {
    font-size: 10px;
    color: #8a9a94;
    background: #f0f5f2;
    padding: 1px 8px;
    border-radius: 10px;
}

.layanan-right {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 12px;
}

.layanan-count {
    font-size: 13px;
    font-weight: 700;
    color: #1d2b27;
    min-width: 30px;
    text-align: right;
}

.layanan-bar-wrap {
    flex: 1;
    height: 6px;
    background: #f0f2f1;
    border-radius: 4px;
    overflow: hidden;
}

.layanan-bar {
    height: 100%;
    border-radius: 4px;
    background: linear-gradient(135deg, #07573c, #0d8a5a);
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
   MODAL (COPY dari index)
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
.modal-container {
    width: 100%;
    max-width: 480px;
    max-height: 90vh;
}
.modal-lg .modal-container { max-width: 580px; }
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
.modal-body { padding: 1.5rem; overflow-y: auto; max-height: calc(90vh - 160px); }
.modal-footer {
    padding: 0.75rem 1.5rem 1.25rem;
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
    border-top: 1px solid #f0f2f1;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
.form-group { display: flex; flex-direction: column; gap: 4px; }
.form-group.full-width { grid-column: 1 / -1; }
.form-label { font-size: 13px; font-weight: 600; color: #1d2b27; }
.form-input, .form-select, .form-textarea {
    padding: 10px 14px;
    border: 1px solid #e9ecef;
    border-radius: 10px;
    font-size: 13px;
    background: #fafcfb;
    color: #1d2b27;
    width: 100%;
}
.form-input:focus, .form-select:focus, .form-textarea:focus {
    outline: none;
    border-color: #07573c;
    background: white;
    box-shadow: 0 0 0 4px rgba(7,87,60,0.08);
}
.form-textarea { resize: vertical; min-height: 60px; }
.form-error { font-size: 12px; color: #dc2626; display: none; }
.form-error.show { display: block; }
.text-danger { color: #dc2626; }

.btn-secondary {
    background: transparent;
    color: #6c7a75;
    border: 1px solid #dce2e0;
    padding: 0.5rem 1.25rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
}
.btn-secondary:hover { background: #f1f4f3; }
.btn-primary {
    background: #07573c;
    color: white;
    border: 1px solid #07573c;
    padding: 0.5rem 1.25rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
.btn-primary:hover { background: #043d2a; }

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

.btn-pdf {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: #07573c;
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}
.btn-pdf:hover {
    background: #043d2a;
    transform: translateY(-2px);
}

.distribusi-info-text {
    margin-top: 8px;
    padding: 8px 12px;
    background: #dbeafe;
    border-radius: 8px;
    font-size: 12px;
    color: #1e40af;
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

    .layanan-item {
        flex-wrap: wrap;
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
// MODAL CREATE
// ============================================
function openCreateModal() {
    const form = document.getElementById('createForm');
    if (form) form.reset();
    document.querySelectorAll('#createModal .form-error').forEach(el => {
        el.classList.remove('show');
        el.textContent = '';
    });
    document.getElementById('create_distribusi_info').style.display = 'none';
    openModal('createModal');
}

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
// CREATE FORM SUBMIT
// ============================================
document.getElementById('createForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const submitBtn = document.getElementById('createSubmit');
    submitBtn.disabled = true;
    submitBtn.innerHTML = 'Menyimpan...';
    fetch(this.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: new FormData(this)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            closeModal('createModal');
            setTimeout(() => window.location.reload(), 500);
        } else {
            if (data.errors) {
                Object.keys(data.errors).forEach(key => {
                    const el = document.getElementById(`error-${key}`);
                    if (el) {
                        el.textContent = data.errors[key][0];
                        el.classList.add('show');
                    }
                });
                showToast('Perbaiki form yang salah', 'error');
            } else {
                showToast(data.message || 'Terjadi kesalahan', 'error');
            }
        }
    })
    .catch(err => {
        console.error(err);
        showToast('Terjadi kesalahan server', 'error');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg> Simpan`;
    });
});

document.getElementById('create_jenis_layanan_id')?.addEventListener('change', function() {
    const role = this.options[this.selectedIndex]?.getAttribute('data-role');
    const info = document.getElementById('create_distribusi_info');
    const text = document.getElementById('create_distribusi_text');
    if (role && info) {
        const labels = {
            'pengecekan_kehilangan': 'Pengecekan Kehilangan',
            'kutipan_kedua': 'Kutipan Kedua',
            'banjir_kepolisian': 'Banjir Kepolisian',
            'keabsahan': 'Keabsahan',
            'surat_pengantar': 'Surat Pengantar'
        };
        text.innerHTML = `Permohonan akan diteruskan ke petugas <strong>${labels[role] || role}</strong>`;
        info.style.display = 'block';
    } else if (info) {
        info.style.display = 'none';
    }
});

// ============================================
// ANIMASI BAR
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.status-dist-bar, .layanan-bar').forEach(bar => {
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

console.log('✅ Loket Dashboard loaded successfully');
</script>
@endpush