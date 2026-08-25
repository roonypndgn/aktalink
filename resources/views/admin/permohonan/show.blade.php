@extends('layouts.app')

@section('title', 'Detail Permohonan - ' . $permohonan->nomor_permohonan)
@section('page-title', '📄 Detail Permohonan')
@section('page-description', 'Informasi lengkap permohonan ' . $permohonan->nomor_permohonan)

@section('page-actions')
    <a href="{{ route('admin.permohonan.edit', $permohonan) }}" class="btn btn-warning">
        <i data-lucide="edit" class="w-4 h-4"></i>
        Edit
    </a>
    <a href="{{ route('admin.permohonan.index') }}" class="btn btn-outline-secondary">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Kembali
    </a>
@endsection

@section('content')
<div class="detail-grid">

    {{-- LEFT COLUMN --}}
    <div class="detail-left">

        {{-- Status Timeline --}}
        <div class="card detail-card">
            <div class="card-header">
                <h5 class="card-title">
                    <i data-lucide="clock" class="w-4 h-4 me-2"></i>
                    Status & Timeline
                </h5>
            </div>
            <div class="card-body">
                <div class="status-current">
                    <span class="status-badge-lg" style="background: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}20; color: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}">
                        <span class="status-dot-lg" style="background: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}"></span>
                        {{ $permohonan->statusPermohonan->nama_status }}
                    </span>
                    <span class="priority-badge priority-{{ $permohonan->prioritas }}">
                        <i data-lucide="flag" class="w-3 h-3"></i>
                        {{ $permohonan->label_prioritas }}
                    </span>
                </div>

                <div class="timeline-modern">
                    @forelse($permohonan->riwayatStatus as $riwayat)
                    <div class="timeline-item-modern">
                        <div class="timeline-dot" style="background: {{ $riwayat->statusBaru->warna ?? '#6c757d' }}"></div>
                        <div class="timeline-content-modern">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="fw-600">{{ $riwayat->statusBaru->nama_status }}</span>
                                    @if($riwayat->statusLama)
                                    <span class="text-muted small">(dari {{ $riwayat->statusLama->nama_status }})</span>
                                    @endif
                                </div>
                                <small class="text-muted">{{ $riwayat->changed_at->format('d M Y, H:i') }}</small>
                            </div>
                            @if($riwayat->keterangan)
                            <div class="timeline-note">{{ $riwayat->keterangan }}</div>
                            @endif
                            <div class="timeline-user">
                                <i data-lucide="user" class="w-3 h-3"></i>
                                {{ $riwayat->changedBy->name }}
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-muted text-center py-3">Belum ada riwayat status</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Informasi Permohonan --}}
        <div class="card detail-card mt-4">
            <div class="card-header">
                <h5 class="card-title">
                    <i data-lucide="file-text" class="w-4 h-4 me-2"></i>
                    Informasi Permohonan
                </h5>
            </div>
            <div class="card-body">
                <div class="detail-grid-2">
                    <div class="detail-item">
                        <label>Nomor Permohonan</label>
                        <div class="fw-600">{{ $permohonan->nomor_permohonan }}</div>
                    </div>
                    <div class="detail-item">
                        <label>Jenis Layanan</label>
                        <div>{{ $permohonan->jenisLayanan->nama_layanan }}</div>
                    </div>
                    <div class="detail-item">
                        <label>Tanggal Permohonan</label>
                        <div>{{ $permohonan->tanggal_permohonan->format('d M Y, H:i') }}</div>
                    </div>
                    <div class="detail-item">
                        <label>Tanggal Selesai</label>
                        <div>{{ $permohonan->tanggal_selesai ? $permohonan->tanggal_selesai->format('d M Y, H:i') : '-' }}</div>
                    </div>
                    <div class="detail-item full-width">
                        <label>Judul Permohonan</label>
                        <div>{{ $permohonan->judul_permohonan ?? '-' }}</div>
                    </div>
                    <div class="detail-item full-width">
                        <label>Keterangan</label>
                        <div class="detail-text">{{ $permohonan->keterangan }}</div>
                    </div>
                    <div class="detail-item full-width">
                        <label>Catatan Loket</label>
                        <div class="detail-text">{{ $permohonan->catatan_loket ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT COLUMN --}}
    <div class="detail-right">

        {{-- Data Pemohon --}}
        <div class="card detail-card">
            <div class="card-header">
                <h5 class="card-title">
                    <i data-lucide="user" class="w-4 h-4 me-2"></i>
                    Data Pemohon
                </h5>
            </div>
            <div class="card-body">
                <div class="pemohon-profile">
                    <div class="pemohon-avatar">
                        <i data-lucide="user" class="w-8 h-8"></i>
                    </div>
                    <div class="pemohon-name">{{ $permohonan->pemohon->nama_lengkap }}</div>
                    <div class="pemohon-nik">NIK: {{ $permohonan->pemohon->nik }}</div>
                </div>
                <hr>
                <div class="detail-grid-2">
                    <div class="detail-item">
                        <label>Tempat Lahir</label>
                        <div>{{ $permohonan->pemohon->tempat_lahir ?? '-' }}</div>
                    </div>
                    <div class="detail-item">
                        <label>Tanggal Lahir</label>
                        <div>{{ $permohonan->pemohon->tanggal_lahir ? $permohonan->pemohon->tanggal_lahir->format('d M Y') : '-' }}</div>
                    </div>
                    <div class="detail-item">
                        <label>Jenis Kelamin</label>
                        <div>{{ $permohonan->pemohon->jenis_kelamin == 'L' ? 'Laki-laki' : ($permohonan->pemohon->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</div>
                    </div>
                    <div class="detail-item">
                        <label>Nomor HP</label>
                        <div>{{ $permohonan->pemohon->nomor_hp ?? '-' }}</div>
                    </div>
                    <div class="detail-item full-width">
                        <label>Alamat</label>
                        <div>{{ $permohonan->pemohon->alamat ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Petugas --}}
        <div class="card detail-card mt-4">
            <div class="card-header">
                <h5 class="card-title">
                    <i data-lucide="users" class="w-4 h-4 me-2"></i>
                    Petugas
                </h5>
            </div>
            <div class="card-body">
                <div class="detail-item">
                    <label>Petugas Loket</label>
                    <div class="d-flex align-items-center gap-2">
                        <div class="avatar-sm">
                            <i data-lucide="user" class="w-4 h-4"></i>
                        </div>
                        {{ $permohonan->petugasLoket->name }}
                    </div>
                </div>
                @if($permohonan->petugasPenanganan->isNotEmpty())
                <div class="detail-item mt-3">
                    <label>Petugas Penanganan</label>
                    @foreach($permohonan->petugasPenanganan as $penugasan)
                    <div class="d-flex align-items-center justify-content-between py-1">
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-sm">
                                <i data-lucide="user" class="w-4 h-4"></i>
                            </div>
                            {{ $penugasan->user->name }}
                        </div>
                        <span class="badge-soft badge-soft-{{ $penugasan->is_active ? 'success' : 'secondary' }}">
                            {{ $penugasan->is_active ? 'Aktif' : 'Selesai' }}
                        </span>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        {{-- Hasil Pemeriksaan --}}
        @if($permohonan->hasilPemeriksaan)
        <div class="card detail-card mt-4">
            <div class="card-header">
                <h5 class="card-title">
                    <i data-lucide="check-circle" class="w-4 h-4 me-2"></i>
                    Hasil Pemeriksaan
                </h5>
            </div>
            <div class="card-body">
                <div class="detail-item">
                    <label>Hasil</label>
                    <div>
                        <span class="status-badge" style="background: {{ $permohonan->hasilPemeriksaan->statusHasil->warna ?? '#6c757d' }}20; color: {{ $permohonan->hasilPemeriksaan->statusHasil->warna ?? '#6c757d' }}">
                            <span class="status-dot" style="background: {{ $permohonan->hasilPemeriksaan->statusHasil->warna ?? '#6c757d' }}"></span>
                            {{ $permohonan->hasilPemeriksaan->statusHasil->nama_hasil }}
                        </span>
                    </div>
                </div>
                <div class="detail-item">
                    <label>Diperiksa Oleh</label>
                    <div>{{ $permohonan->hasilPemeriksaan->diperiksaOleh->name }}</div>
                </div>
                <div class="detail-item">
                    <label>Tanggal Pemeriksaan</label>
                    <div>{{ $permohonan->hasilPemeriksaan->tanggal_pemeriksaan->format('d M Y, H:i') }}</div>
                </div>
                <div class="detail-item">
                    <label>Hasil Pemeriksaan</label>
                    <div class="detail-text">{{ $permohonan->hasilPemeriksaan->hasil_pemeriksaan }}</div>
                </div>
                @if($permohonan->hasilPemeriksaan->keterangan)
                <div class="detail-item">
                    <label>Keterangan</label>
                    <div class="detail-text">{{ $permohonan->hasilPemeriksaan->keterangan }}</div>
                </div>
                @endif
                @if($permohonan->hasilPemeriksaan->rekomendasi)
                <div class="detail-item">
                    <label>Rekomendasi</label>
                    <div class="detail-text">{{ $permohonan->hasilPemeriksaan->rekomendasi }}</div>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
/* ==========================================
   DETAIL GRID
========================================== */
.detail-grid {
    display: grid;
    grid-template-columns: 1.4fr 1fr;
    gap: 1.5rem;
}

.detail-left,
.detail-right {
    display: flex;
    flex-direction: column;
    gap: 0;
}

.detail-card {
    border-radius: 16px;
    border: 1px solid #e9ecef;
    background: white;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    overflow: hidden;
}

.detail-card .card-header {
    background: transparent;
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #f0f2f1;
}

.detail-card .card-body {
    padding: 1.25rem;
}

/* ==========================================
   DETAIL ITEMS
========================================== */
.detail-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem 1.5rem;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 0.15rem;
}

.detail-item.full-width {
    grid-column: 1 / -1;
}

.detail-item label {
    font-size: 0.65rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #8a9a94;
    font-weight: 600;
}

.detail-item .detail-text {
    padding: 0.5rem 0.75rem;
    background: #f8faf9;
    border-radius: 8px;
    font-size: 0.85rem;
    color: #1d2b27;
}

/* ==========================================
   STATUS BADGE LG
========================================== */
.status-badge-lg {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.4rem 1.2rem;
    border-radius: 24px;
    font-size: 0.85rem;
    font-weight: 700;
}

.status-dot-lg {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
}

.status-current {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.25rem;
    flex-wrap: wrap;
}

/* ==========================================
   TIMELINE MODERN
========================================== */
.timeline-modern {
    position: relative;
    padding-left: 1.5rem;
}

.timeline-modern::before {
    content: '';
    position: absolute;
    left: 5px;
    top: 4px;
    bottom: 4px;
    width: 2px;
    background: #e9ecef;
}

.timeline-item-modern {
    position: relative;
    margin-bottom: 1rem;
    padding-left: 0.5rem;
}

.timeline-item-modern:last-child {
    margin-bottom: 0;
}

.timeline-dot {
    position: absolute;
    left: -1.2rem;
    top: 4px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-content-modern {
    padding-left: 0.25rem;
}

.timeline-note {
    font-size: 0.78rem;
    color: #6c7a75;
    margin-top: 0.15rem;
}

.timeline-user {
    font-size: 0.7rem;
    color: #8a9a94;
    display: flex;
    align-items: center;
    gap: 0.25rem;
    margin-top: 0.15rem;
}

/* ==========================================
   PEMOHON PROFILE
========================================== */
.pemohon-profile {
    text-align: center;
    padding: 0.5rem 0;
}

.pemohon-avatar {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: #e8f0ed;
    color: #07573c;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 0.5rem;
}

.pemohon-name {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1d2b27;
}

.pemohon-nik {
    font-size: 0.8rem;
    color: #8a9a94;
}

/* ==========================================
   AVATAR SMALL
========================================== */
.avatar-sm {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: #e8f0ed;
    color: #07573c;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

/* ==========================================
   BADGE SOFT
========================================== */
.badge-soft-success {
    background: #d1fae5;
    color: #065f46;
    padding: 0.15rem 0.6rem;
    border-radius: 12px;
    font-size: 0.65rem;
    font-weight: 600;
}

.badge-soft-secondary {
    background: #e9ecef;
    color: #495057;
    padding: 0.15rem 0.6rem;
    border-radius: 12px;
    font-size: 0.65rem;
    font-weight: 600;
}

/* ==========================================
   RESPONSIVE
========================================== */
@media (max-width: 992px) {
    .detail-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .detail-grid-2 {
        grid-template-columns: 1fr;
    }
    .status-current {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>
@endpush