{{-- resources/views/surat-pengantar/permohonan/show.blade.php --}}

@extends('layouts.surat-pengantar')

@section('title', 'Detail Permohonan - ' . $permohonan->nomor_permohonan)
@section('page-title', 'Detail Permohonan')
@section('page-description', $permohonan->nomor_permohonan . ' - ' . $permohonan->judul_permohonan)

@section('page-actions')
    <a href="{{ route('surat-pengantar.permohonan.index') }}" class="btn-outline">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="19" y1="12" x2="5" y2="12"/>
            <polyline points="12 19 5 12 12 5"/>
        </svg>
        Kembali
    </a>
@endsection

@section('content')

<div class="detail-grid">
    {{-- LEFT COLUMN - Info Permohonan --}}
    <div class="detail-left">

        {{-- Status Card --}}
        <div class="detail-card">
            <div class="detail-card-header">
                <span class="detail-card-title">Status Permohonan</span>
                <div class="status-actions">
                    <span class="status-badge" style="background: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}20; color: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}">
                        <span class="status-dot" style="background: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}"></span>
                        {{ $permohonan->statusPermohonan->nama_status ?? 'Tidak Diketahui' }}
                    </span>
                    @if($permohonan->statusPermohonan && $permohonan->statusPermohonan->kode_status !== 'SELESAI')
                    <button type="button" class="btn-small-primary" onclick="openUpdateStatusModal()">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                        Update Status
                    </button>
                    @endif
                </div>
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
                        <p class="info-value">{{ $permohonan->pemohon->tempat_lahir ?? '-' }}, {{ $permohonan->pemohon->tanggal_lahir ? $permohonan->pemohon->tanggal_lahir->setTimezone('Asia/Jakarta')->format('d M Y') : '-' }}</p>
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
    </div>

    {{-- RIGHT COLUMN - Dokumen, Komentar & Riwayat --}}
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

        {{-- Komentar Card --}}
        <div class="detail-card">
            <div class="detail-card-header">
                <span class="detail-card-title">Komentar</span>
                <button type="button" class="btn-small-primary" onclick="openTambahKomentarModal()">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Tambah
                </button>
            </div>
            <div class="detail-card-body" id="komentarContainer">
                @if($permohonan->komentar->count() > 0)
                    @foreach($permohonan->komentar as $komentar)
                    <div class="komentar-item {{ $komentar->is_internal ? 'internal' : 'eksternal' }}">
                        <div class="komentar-header">
                            <div class="komentar-user">
                                <div class="komentar-avatar">{{ Str::substr($komentar->user->name ?? 'U', 0, 2) }}</div>
                                <span class="komentar-nama">{{ $komentar->user->name ?? 'User' }}</span>
                                <span class="komentar-role">{{ $komentar->user->role_label ?? '-' }}</span>
                            </div>
                            <div class="komentar-meta">
                                @if($komentar->is_internal)
                                <span class="badge-internal">🔒 Internal</span>
                                @else
                                <span class="badge-eksternal">🌐 Eksternal</span>
                                @endif
                                <span class="komentar-waktu">{{ $komentar->created_at->setTimezone('Asia/Jakarta')->format('d M Y H:i') }}</span>
                            </div>
                        </div>
                        <div class="komentar-body">{{ $komentar->komentar }}</div>
                    </div>
                    @endforeach
                @else
                    <div class="empty-komentar">
                        <p class="text-muted">Belum ada komentar</p>
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

{{-- ============================================
    MODAL UPDATE STATUS
============================================ --}}
<div class="modal-overlay" id="updateStatusModal" style="display: none;">
    <div class="modal-container">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-header-icon" style="background: #fef3c7; color: #92400e;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                </div>
                <h4 class="modal-title">Update Status</h4>
                <button type="button" class="modal-close" onclick="closeModal('updateStatusModal')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            <form id="updateStatusForm" method="POST" action="{{ route('surat-pengantar.permohonan.update-status', $permohonan) }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group full-width">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status_permohonan_id" class="form-select" required>
                            <option value="">-- Pilih Status --</option>
                            @foreach($statuses as $status)
                            <option value="{{ $status->id }}" {{ $permohonan->status_permohonan_id == $status->id ? 'selected' : '' }}>
                                {{ $status->nama_status }}
                            </option>
                            @endforeach
                        </select>
                        <small class="text-muted" style="font-size:11px;color:#8a9a94;margin-top:4px;">
                            💡 Pilih "Berkas Kurang Lengkap" jika dokumen pemohon belum lengkap
                        </small>
                    </div>
                    <div class="form-group full-width" style="margin-top:12px;">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-textarea" rows="3" placeholder="Tambahkan keterangan (opsional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeModal('updateStatusModal')">Batal</button>
                    <button type="submit" class="btn-primary" id="updateStatusSubmit">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ============================================
    MODAL TAMBAH KOMENTAR
============================================ --}}
<div class="modal-overlay" id="tambahKomentarModal" style="display: none;">
    <div class="modal-container">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-header-icon" style="background: #dbeafe; color: #2563eb;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                </div>
                <h4 class="modal-title">Tambah Komentar</h4>
                <button type="button" class="modal-close" onclick="closeModal('tambahKomentarModal')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            <form id="tambahKomentarForm" method="POST" action="{{ route('surat-pengantar.permohonan.tambah-komentar', $permohonan) }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group full-width">
                        <label class="form-label">Komentar <span class="text-danger">*</span></label>
                        <textarea name="komentar" class="form-textarea" rows="4" placeholder="Tulis komentar Anda..." required></textarea>
                    </div>
                    <div class="form-group full-width" style="margin-top:12px;">
                        <label class="form-label">Tipe Komentar</label>
                        <select name="is_internal" class="form-select">
                            <option value="1">🔒 Internal (hanya terlihat oleh petugas)</option>
                            <option value="0">🌐 Eksternal (terlihat oleh semua)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeModal('tambahKomentarModal')">Batal</button>
                    <button type="submit" class="btn-primary" id="tambahKomentarSubmit">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                        Kirim Komentar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- TOAST --}}
<div id="toastContainer"></div>

@endsection

@push('styles')
<style>
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

.status-actions {
    display: flex;
    align-items: center;
    gap: 12px;
}

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

.komentar-item {
    padding: 14px 0;
    border-bottom: 1px solid #f5f7f6;
}
.komentar-item:last-child { border-bottom: none; }
.komentar-item.internal {
    background: #f8faf9;
    border-radius: 8px;
    padding: 12px 14px;
    margin-bottom: 8px;
}
.komentar-item.eksternal {
    background: #f0f9ff;
    border-radius: 8px;
    padding: 12px 14px;
    margin-bottom: 8px;
}

.komentar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 6px;
}

.komentar-user {
    display: flex;
    align-items: center;
    gap: 8px;
}

.komentar-avatar {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: linear-gradient(135deg, #07573c, #0d8a5a);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: 700;
    flex-shrink: 0;
}

.komentar-nama {
    font-weight: 600;
    font-size: 12px;
    color: #1d2b27;
}

.komentar-role {
    font-size: 10px;
    color: #8a9a94;
}

.komentar-meta {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 10px;
    color: #8a9a94;
}

.badge-internal {
    background: #e8f0ed;
    color: #4a5a54;
    padding: 1px 8px;
    border-radius: 10px;
    font-size: 9px;
    font-weight: 600;
}

.badge-eksternal {
    background: #dbeafe;
    color: #2563eb;
    padding: 1px 8px;
    border-radius: 10px;
    font-size: 9px;
    font-weight: 600;
}

.komentar-body {
    font-size: 13px;
    color: #1d2b27;
    padding-left: 36px;
}

.empty-komentar {
    text-align: center;
    padding: 20px 0;
}
.empty-komentar .text-muted { color: #8a9a94; font-size: 13px; }

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

.btn-small-primary {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    background: #07573c;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}
.btn-small-primary:hover {
    background: #043d2a;
    transform: translateY(-1px);
}

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
    background: #dc2626;
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
    background: #b91c1c;
    transform: translateY(-2px);
    color: white;
}

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

.form-group { display: flex; flex-direction: column; gap: 4px; }
.form-group.full-width { width: 100%; }
.form-label { font-size: 13px; font-weight: 600; color: #1d2b27; }
.form-select, .form-textarea {
    padding: 10px 14px;
    border: 1px solid #e9ecef;
    border-radius: 10px;
    font-size: 13px;
    background: #fafcfb;
    color: #1d2b27;
    width: 100%;
    font-family: inherit;
}
.form-select:focus, .form-textarea:focus {
    outline: none;
    border-color: #07573c;
    background: white;
    box-shadow: 0 0 0 4px rgba(7,87,60,0.08);
}
.form-textarea {
    resize: vertical;
    min-height: 60px;
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
    color: #8a9a94;
    background: transparent;
    transition: all 0.2s ease;
    text-decoration: none;
}
.action-btn:hover { transform: translateY(-1px); }
.view-btn:hover { background: #dbeafe; color: #2563eb; }
.edit-btn:hover { background: #fef3c7; color: #92400e; }

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

@media (max-width: 1024px) {
    .detail-grid { grid-template-columns: 1fr; }
}
@media (max-width: 768px) {
    .info-grid { grid-template-columns: 1fr; }
    .detail-card-header { flex-wrap: wrap; gap: 8px; }
    .pemohon-profile { flex-direction: column; text-align: center; }
    .komentar-header { flex-direction: column; align-items: flex-start; }
}
</style>
@endpush

@push('scripts')
<script>
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

function openUpdateStatusModal() {
    document.getElementById('updateStatusForm').reset();
    openModal('updateStatusModal');
}

document.getElementById('updateStatusForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const submitBtn = document.getElementById('updateStatusSubmit');
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
            closeModal('updateStatusModal');
            setTimeout(() => window.location.reload(), 500);
        } else {
            showToast(data.message || 'Terjadi kesalahan', 'error');
        }
    })
    .catch(err => {
        console.error(err);
        showToast('Terjadi kesalahan server', 'error');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg> Update Status';
    });
});

function openTambahKomentarModal() {
    document.getElementById('tambahKomentarForm').reset();
    openModal('tambahKomentarModal');
}

document.getElementById('tambahKomentarForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const submitBtn = document.getElementById('tambahKomentarSubmit');
    submitBtn.disabled = true;
    submitBtn.innerHTML = 'Mengirim...';
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
            closeModal('tambahKomentarModal');
            setTimeout(() => window.location.reload(), 500);
        } else {
            if (data.errors) {
                const firstError = Object.values(data.errors)[0];
                showToast(firstError[0] || 'Terjadi kesalahan', 'error');
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
        submitBtn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg> Kirim Komentar';
    });
});

document.addEventListener('DOMContentLoaded', function() {
    if (window.location.hash) {
        const hash = window.location.hash;
        if (hash === '#updateStatus') {
            setTimeout(function() { openUpdateStatusModal(); }, 800);
        }
        if (hash === '#tambahKomentar') {
            setTimeout(function() { openTambahKomentarModal(); }, 800);
        }
        if (hash === '#prosesModal') {
            setTimeout(function() { 
                const prosesBtn = document.querySelector('[onclick*="openProsesModal"]');
                if (prosesBtn) prosesBtn.click();
            }, 800);
        }
    }
});

console.log('✅ Surat Pengantar - Detail Permohonan loaded successfully');
</script>
@endpush