@extends('layouts.app')

@section('title', 'Detail Permohonan - ' . $permohonan->nomor_permohonan)
@section('page-title', 'Detail Permohonan')
@section('page-description', 'Informasi lengkap permohonan ' . $permohonan->nomor_permohonan)

@section('page-actions')
    <a href="{{ route('admin.permohonan.index') }}" class="btn-outline">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="19" y1="12" x2="5" y2="12"/>
            <polyline points="12 19 5 12 12 5"/>
        </svg>
        Kembali
    </a>
@endsection

@section('content')

<div class="detail-grid">
    {{-- ============================================
    LEFT COLUMN - Info Permohonan
    ============================================ --}}
    <div class="detail-left">

        {{-- Status Card --}}
        <div class="detail-card">
            <div class="detail-card-header">
                <span class="detail-card-title">Status Permohonan</span>
                <span class="status-badge" style="background: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}20; color: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}">
                    <span class="status-dot" style="background: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}"></span>
                    {{ $permohonan->statusPermohonan->nama_status ?? 'Tidak Diketahui' }}
                </span>
            </div>
            <div class="detail-card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <label>Nomor Permohonan</label>
                        <p class="info-value">{{ $permohonan->nomor_permohonan }}</p>
                    </div>
                    <div class="info-item">
                        <label>Prioritas</label>
                        <p><span class="priority-badge priority-{{ $permohonan->prioritas }}">{{ $permohonan->label_prioritas }}</span></p>
                    </div>
                    <div class="info-item full-width">
                        <label>Judul</label>
                        <p class="info-value">{{ $permohonan->judul_permohonan ?? 'Tanpa judul' }}</p>
                    </div>
                    <div class="info-item full-width">
                        <label>Keterangan</label>
                        <p class="info-value">{{ $permohonan->keterangan }}</p>
                    </div>
                    <div class="info-item">
                        <label>Tanggal Permohonan</label>
                        <p class="info-value">{{ $permohonan->tanggal_permohonan->setTimezone('Asia/Jakarta')->format('d M Y H:i') }}</p>
                    </div>
                    <div class="info-item">
                        <label>Petugas Loket</label>
                        <p class="info-value">{{ $permohonan->petugasLoket->name ?? '-' }}</p>
                    </div>
                    @if($permohonan->tanggal_diteruskan)
                    <div class="info-item">
                        <label>Tanggal Diteruskan</label>
                        <p class="info-value">{{ $permohonan->tanggal_diteruskan->setTimezone('Asia/Jakarta')->format('d M Y H:i') }}</p>
                    </div>
                    @endif
                    @if($permohonan->tanggal_selesai)
                    <div class="info-item">
                        <label>Tanggal Selesai</label>
                        <p class="info-value">{{ $permohonan->tanggal_selesai->setTimezone('Asia/Jakarta')->format('d M Y H:i') }}</p>
                    </div>
                    @endif
                    @if($permohonan->catatan_loket)
                    <div class="info-item full-width">
                        <label>Catatan Loket</label>
                        <p class="info-value">{{ $permohonan->catatan_loket }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Pemohon Card --}}
        <div class="detail-card">
            <div class="detail-card-header">
                <span class="detail-card-title">Data Pemohon</span>
                <span class="text-muted" style="font-size:12px;">NIK: {{ $permohonan->pemohon->nik }}</span>
            </div>
            <div class="detail-card-body">
                <div class="pemohon-profile">
                    <div class="pemohon-avatar-large">{{ Str::substr($permohonan->pemohon->nama_lengkap, 0, 2) }}</div>
                    <div class="pemohon-info">
                        <h4>{{ $permohonan->pemohon->nama_lengkap }}</h4>
                        <p>{{ $permohonan->pemohon->nik }}</p>
                    </div>
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Tempat, Tanggal Lahir</label>
                        <p class="info-value">{{ $permohonan->pemohon->tempat_lahir ?? '-' }}, {{ $permohonan->pemohon->tanggal_lahir ? $permohonan->pemohon->tanggal_lahir->format('d M Y') : '-' }}</p>
                    </div>
                    <div class="info-item">
                        <label>Jenis Kelamin</label>
                        <p class="info-value">{{ $permohonan->pemohon->jenis_kelamin == 'L' ? 'Laki-laki' : ($permohonan->pemohon->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</p>
                    </div>
                    <div class="info-item full-width">
                        <label>Alamat</label>
                        <p class="info-value">{{ $permohonan->pemohon->alamat ?? '-' }}</p>
                    </div>
                    <div class="info-item">
                        <label>No. Telepon</label>
                        <p class="info-value">{{ $permohonan->pemohon->no_telepon ?? '-' }}</p>
                    </div>
                    <div class="info-item">
                        <label>Email</label>
                        <p class="info-value">{{ $permohonan->pemohon->email ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Layanan Card --}}
        <div class="detail-card">
            <div class="detail-card-header">
                <span class="detail-card-title">Jenis Layanan</span>
            </div>
            <div class="detail-card-body">
                <div class="info-grid">
                    <div class="info-item full-width">
                        <label>Nama Layanan</label>
                        <p class="info-value" style="font-size:16px;font-weight:600;">{{ $permohonan->jenisLayanan->nama_layanan }}</p>
                    </div>
                    <div class="info-item">
                        <label>Kode Layanan</label>
                        <p class="info-value"><code>{{ $permohonan->jenisLayanan->kode_layanan }}</code></p>
                    </div>
                    <div class="info-item">
                        <label>Role Tujuan</label>
                        <p class="info-value">{{ $permohonan->jenisLayanan->role_tujuan ?? '-' }}</p>
                    </div>
                    <div class="info-item full-width">
                        <label>Deskripsi</label>
                        <p class="info-value">{{ $permohonan->jenisLayanan->deskripsi ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Hasil Pemeriksaan Card --}}
        @if($permohonan->hasilPemeriksaan)
        <div class="detail-card">
            <div class="detail-card-header">
                <span class="detail-card-title">📊 Hasil Pemeriksaan</span>
            </div>
            <div class="detail-card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <label>Hasil</label>
                        <p class="info-value">
                            <span class="status-badge" style="background: {{ $permohonan->hasilPemeriksaan->statusHasil->warna ?? '#6c757d' }}20; color: {{ $permohonan->hasilPemeriksaan->statusHasil->warna ?? '#6c757d' }}">
                                <span class="status-dot" style="background: {{ $permohonan->hasilPemeriksaan->statusHasil->warna ?? '#6c757d' }}"></span>
                                {{ $permohonan->hasilPemeriksaan->statusHasil->nama_hasil ?? '-' }}
                            </span>
                        </p>
                    </div>
                    <div class="info-item">
                        <label>Diperiksa Oleh</label>
                        <p class="info-value">{{ $permohonan->hasilPemeriksaan->diperiksaOleh->name ?? '-' }}</p>
                    </div>
                    <div class="info-item">
                        <label>Tanggal Pemeriksaan</label>
                        <p class="info-value">{{ $permohonan->hasilPemeriksaan->tanggal_pemeriksaan ? $permohonan->hasilPemeriksaan->tanggal_pemeriksaan->format('d M Y H:i') : '-' }}</p>
                    </div>
                    <div class="info-item full-width">
                        <label>Hasil Pemeriksaan</label>
                        <p class="info-value">{{ $permohonan->hasilPemeriksaan->hasil_pemeriksaan ?? '-' }}</p>
                    </div>
                    @if($permohonan->hasilPemeriksaan->keterangan)
                    <div class="info-item full-width">
                        <label>Keterangan</label>
                        <p class="info-value">{{ $permohonan->hasilPemeriksaan->keterangan }}</p>
                    </div>
                    @endif
                    @if($permohonan->hasilPemeriksaan->rekomendasi)
                    <div class="info-item full-width">
                        <label>Rekomendasi</label>
                        <p class="info-value">{{ $permohonan->hasilPemeriksaan->rekomendasi }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- ============================================
    RIGHT COLUMN - Dokumen & Riwayat
    ============================================ --}}
    <div class="detail-right">

        {{-- Dokumen Card --}}
        <div class="detail-card">
            <div class="detail-card-header">
                <span class="detail-card-title">Dokumen Terupload</span>
                <span class="badge-count">{{ $permohonan->dokumen->count() }}</span>
            </div>
            <div class="detail-card-body">
                @if($permohonan->dokumen->count() > 0)
                    @foreach($permohonan->dokumen as $dokumen)
                    <div class="dokumen-item">
                        <div class="dokumen-icon">
                            @php
                                $ext = pathinfo($dokumen->file_name, PATHINFO_EXTENSION);
                                $icon = match(strtolower($ext)) {
                                    'pdf' => '📄',
                                    'jpg', 'jpeg', 'png' => '🖼️',
                                    default => '📎'
                                };
                            @endphp
                            {{ $icon }}
                        </div>
                        <div class="dokumen-info">
                            <div class="dokumen-nama">{{ $dokumen->nama_dokumen }}</div>
                            <div class="dokumen-meta">
                                <span>{{ $dokumen->file_size_formatted }}</span>
                                <span>•</span>
                                <span>{{ $dokumen->jenisDokumen->nama_dokumen ?? 'Tanpa Kategori' }}</span>
                                
                            </div>
                        </div>
                        <div class="dokumen-actions">
                            <a href="{{ $dokumen->file_url }}" target="_blank" class="action-btn view-btn" title="Lihat">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </a>
                            <a href="{{ $dokumen->file_url }}" download class="action-btn edit-btn" title="Download">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline points="7 10 12 15 17 10"/>
                                    <line x1="12" y1="15" x2="12" y2="3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="empty-dokumen">
                        <p class="text-muted">Belum ada dokumen yang diupload</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Riwayat Status Card --}}
        <div class="detail-card">
            <div class="detail-card-header">
                <span class="detail-card-title">Riwayat Status</span>
            </div>
            <div class="detail-card-body">
                @if($permohonan->riwayatStatus->count() > 0)
                    <div class="timeline">
                        @foreach($permohonan->riwayatStatus as $riwayat)
                        <div class="timeline-item">
                            <div class="timeline-dot" style="background: {{ $riwayat->statusBaru->warna ?? '#6c757d' }}"></div>
                            <div class="timeline-content">
                                <div class="timeline-header">
                                    <span class="timeline-status" style="color: {{ $riwayat->statusBaru->warna ?? '#6c757d' }}">
                                        {{ $riwayat->statusBaru->nama_status }}
                                    </span>
                                    @if($riwayat->statusLama)
                                    <span class="timeline-arrow">← dari {{ $riwayat->statusLama->nama_status }}</span>
                                    @endif
                                </div>
                                <div class="timeline-meta">
                                    <span>{{ $riwayat->changedBy->name ?? 'Sistem' }}</span>
                                    <span>•</span>
                                    <span>{{ $riwayat->changed_at->setTimezone('Asia/Jakarta')->format('d M Y H:i') }}</span>
                                </div>
                                @if($riwayat->keterangan)
                                <div class="timeline-keterangan">{{ $riwayat->keterangan }}</div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">Belum ada riwayat status</p>
                @endif
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
   DETAIL PAGE STYLES
============================================ */
.detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}

.detail-card {
    background: white;
    border-radius: 16px;
    border: 1px solid #f0f2f1;
    overflow: hidden;
    margin-bottom: 24px;
}

.detail-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    border-bottom: 1px solid #f0f2f1;
    background: #fafcfb;
}

.detail-card-title {
    font-weight: 700;
    font-size: 14px;
    color: #1d2b27;
}

.detail-card-body {
    padding: 20px;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 14px 4px 10px;
    border-radius: 16px;
    font-size: 12px;
    font-weight: 600;
}

.status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    display: inline-block;
}

/* Info Grid */
.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px 20px;
}

.info-item.full-width {
    grid-column: 1 / -1;
}

.info-item label {
    display: block;
    font-size: 11px;
    font-weight: 600;
    color: #8a9a94;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 2px;
}

.info-value {
    font-size: 14px;
    color: #1d2b27;
    margin: 0;
    word-break: break-word;
}

/* Priority Badge */
.priority-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 2px 10px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
}
.priority-normal { background: #e8f0ed; color: #4a5a54; }
.priority-penting { background: #fef3c7; color: #92400e; }
.priority-urgent { background: #fde8e8; color: #b91c1c; }

/* Pemohon Profile */
.pemohon-profile {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 16px;
    padding-bottom: 16px;
    border-bottom: 1px solid #f0f2f1;
}

.pemohon-avatar-large {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: linear-gradient(135deg, #07573c, #0d8a5a);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: 700;
    flex-shrink: 0;
}

.pemohon-info h4 {
    font-size: 16px;
    font-weight: 700;
    color: #1d2b27;
    margin: 0;
}

.pemohon-info p {
    font-size: 13px;
    color: #8a9a94;
    margin: 2px 0 0;
}

.badge-count {
    background: #07573c;
    color: white;
    padding: 2px 10px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
}

/* Dokumen */
.dokumen-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid #f5f7f6;
}
.dokumen-item:last-child { border-bottom: none; }

.dokumen-icon {
    font-size: 24px;
    width: 40px;
    text-align: center;
    flex-shrink: 0;
}

.dokumen-info {
    flex: 1;
    min-width: 0;
}

.dokumen-nama {
    font-weight: 600;
    font-size: 13px;
    color: #1d2b27;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.dokumen-meta {
    font-size: 11px;
    color: #8a9a94;
    display: flex;
    gap: 6px;
    align-items: center;
    flex-wrap: wrap;
}

.status-verifikasi {
    font-weight: 600;
    padding: 1px 8px;
    border-radius: 10px;
    font-size: 10px;
}
.status-menunggu { background: #fef3c7; color: #92400e; }
.status-valid { background: #d1fae5; color: #065f46; }
.status-tidak_valid { background: #fde8e8; color: #b91c1c; }

.dokumen-actions {
    display: flex;
    gap: 4px;
    flex-shrink: 0;
}

.empty-dokumen {
    text-align: center;
    padding: 20px 0;
}
.empty-dokumen .text-muted { color: #8a9a94; font-size: 13px; }

/* Action Buttons */
.action-btn {
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #8a9a94;
    background: transparent;
    transition: all 0.2s ease;
    text-decoration: none;
}
.action-btn:hover { transform: translateY(-1px); }
.view-btn:hover { background: #dbeafe; color: #2563eb; }
.edit-btn:hover { background: #fef3c7; color: #92400e; }
.delete-btn:hover { background: #fde8e8; color: #b91c1c; }

/* Timeline */
.timeline {
    position: relative;
    padding-left: 20px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 4px;
    top: 4px;
    bottom: 4px;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    padding-bottom: 20px;
}
.timeline-item:last-child { padding-bottom: 0; }

.timeline-dot {
    position: absolute;
    left: -16px;
    top: 4px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-content {
    padding-left: 8px;
}

.timeline-header {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.timeline-status {
    font-weight: 700;
    font-size: 13px;
}

.timeline-arrow {
    font-size: 11px;
    color: #8a9a94;
}

.timeline-meta {
    font-size: 11px;
    color: #8a9a94;
    margin-top: 2px;
}

.timeline-keterangan {
    font-size: 12px;
    color: #4a5a54;
    margin-top: 4px;
    padding: 6px 10px;
    background: #f5f7f6;
    border-radius: 6px;
}

/* Petugas */
.petugas-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid #f5f7f6;
}
.petugas-item:last-child { border-bottom: none; }

.petugas-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #e8f0ed;
    color: #07573c;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 700;
    flex-shrink: 0;
}

.petugas-info { flex: 1; }
.petugas-nama { font-weight: 600; font-size: 13px; color: #1d2b27; }
.petugas-role { font-size: 11px; color: #8a9a94; }

.petugas-status {
    font-size: 11px;
    font-weight: 600;
}
.status-done { color: #059669; }
.status-progress { color: #2563eb; }
.status-waiting { color: #f59e0b; }

.text-muted { color: #8a9a94; }
.text-danger { color: #dc2626; }

/* Button Styles */
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

/* Toast */
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

/* Responsive */
@media (max-width: 1024px) {
    .detail-grid { grid-template-columns: 1fr; }
}

@media (max-width: 768px) {
    .info-grid { grid-template-columns: 1fr; }
    .detail-card-header { flex-wrap: wrap; gap: 8px; }
    .pemohon-profile { flex-direction: column; text-align: center; }
}
</style>
@endpush