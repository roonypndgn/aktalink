{{-- resources/views/loket/permohonan/show.blade.php --}}

@extends('layouts.loket')

@section('title', 'Detail Permohonan - ' . $permohonan->nomor_permohonan)
@section('page-title', '📄 Detail Permohonan')
@section('page-description', 'Informasi lengkap permohonan ' . $permohonan->nomor_permohonan)

@section('page-actions')
    <a href="{{ route('loket.permohonan.index') }}" class="btn-outline">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="15 18 9 12 15 6"/>
        </svg>
        Kembali
    </a>
@endsection

@section('content')

{{-- ============================================
    NOTIFIKASI
============================================ --}}
@if(session('success'))
<div class="alert alert-success">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
        <polyline points="22 4 12 14.01 9 11.01"/>
    </svg>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="10"/>
        <line x1="12" y1="8" x2="12" y2="12"/>
        <line x1="12" y1="16" x2="12.01" y2="16"/>
    </svg>
    {{ session('error') }}
</div>
@endif

<div class="detail-grid">

    {{-- LEFT COLUMN --}}
    <div class="detail-left">

        {{-- Informasi Permohonan --}}
        <div class="card detail-card">
            <div class="card-header">
                <h5 class="card-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
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
                        <label>Status</label>
                        <div>
                            <span class="status-badge" style="background: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}20; color: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}">
                                <span class="status-dot" style="background: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}"></span>
                                {{ $permohonan->statusPermohonan->nama_status }}
                            </span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <label>Jenis Layanan</label>
                        <div>{{ $permohonan->jenisLayanan->nama_layanan }}</div>
                    </div>
                    <div class="detail-item">
                        <label>Prioritas</label>
                        <div>
                            <span class="priority-badge priority-{{ $permohonan->prioritas }}">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                </svg>
                                {{ $permohonan->label_prioritas }}
                            </span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <label>Tanggal Permohonan</label>
                        <div>{{ $permohonan->tanggal_permohonan->format('d/m/Y H:i') }}</div>
                    </div>
                    <div class="detail-item">
                        <label>Tanggal Selesai</label>
                        <div>{{ $permohonan->tanggal_selesai ? $permohonan->tanggal_selesai->format('d/m/Y H:i') : '-' }}</div>
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

        {{-- Riwayat Status --}}
        <div class="card detail-card mt-4">
            <div class="card-header">
                <h5 class="card-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    Riwayat Status
                </h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    @forelse($permohonan->riwayatStatus as $riwayat)
                    <div class="timeline-item">
                        <div class="timeline-marker" style="background: {{ $riwayat->statusBaru->warna ?? '#6c757d' }};"></div>
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="fw-600">{{ $riwayat->statusBaru->nama_status }}</span>
                                    @if($riwayat->statusLama)
                                    <span class="text-muted small">(dari {{ $riwayat->statusLama->nama_status }})</span>
                                    @endif
                                </div>
                                <small class="text-muted">{{ $riwayat->changed_at->format('d/m/Y H:i') }}</small>
                            </div>
                            <div class="text-muted small">
                                Oleh: {{ $riwayat->changedBy->name }}
                                @if($riwayat->keterangan)
                                <br>{{ $riwayat->keterangan }}
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-3">Belum ada riwayat status</div>
                    @endforelse
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
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    Data Pemohon
                </h5>
            </div>
            <div class="card-body">
                <div class="pemohon-profile">
                    <div class="pemohon-avatar">
                        {{ Str::substr($permohonan->pemohon->nama_lengkap, 0, 2) }}
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
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    Petugas
                </h5>
            </div>
            <div class="card-body">
                <div class="detail-item">
                    <label>Petugas Loket</label>
                    <div class="d-flex align-items-center gap-2">
                        <div class="avatar-sm">
                            {{ Str::substr($permohonan->petugasLoket->name, 0, 2) }}
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
                                {{ Str::substr($penugasan->user->name, 0, 2) }}
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
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
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
                    <div>{{ $permohonan->hasilPemeriksaan->tanggal_pemeriksaan->format('d/m/Y H:i') }}</div>
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

        {{-- Dokumen Terupload --}}
        @if($permohonan->dokumen->isNotEmpty())
        <div class="card detail-card mt-4">
            <div class="card-header">
                <h5 class="card-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                    </svg>
                    Dokumen Terupload ({{ $permohonan->dokumen->count() }})
                </h5>
            </div>
            <div class="card-body">
                <div class="dokumen-list">
                    @foreach($permohonan->dokumen as $dokumen)
                    <div class="dokumen-item-detail">
                        <div class="dokumen-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                        </div>
                        <div class="dokumen-info">
                            <div class="dokumen-nama">{{ $dokumen->nama_dokumen }}</div>
                            <div class="dokumen-meta">
                                <span class="dokumen-jenis">{{ $dokumen->jenisDokumen->nama_dokumen ?? 'Umum' }}</span>
                                <span class="dokumen-size">{{ $dokumen->file_size_formatted }}</span>
                            </div>
                        </div>
                        <div class="dokumen-status">
                            <span class="status-badge-sm status-{{ $dokumen->status_verifikasi }}">
                                {{ ucfirst($dokumen->status_verifikasi) }}
                            </span>
                        </div>
                        <div class="dokumen-actions">
                            <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank" class="btn-sm btn-primary" title="Lihat Dokumen">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </a>
                            <a href="{{ asset('storage/' . $dokumen->file_path) }}" download class="btn-sm btn-outline" title="Download">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline points="7 10 12 15 17 10"/>
                                    <line x1="12" y1="15" x2="12" y2="3"/>
                                </svg>
                            </a>
                            @if($permohonan->statusPermohonan && $permohonan->statusPermohonan->kode_status === 'MENUNGGU')
                            <form action="{{ route('loket.permohonan.delete-dokumen', ['permohonan' => $permohonan->id, 'dokumenId' => $dokumen->id]) }}" 
                                  method="POST" 
                                  style="display:inline;"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn-danger" title="Hapus Dokumen">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"/>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                    </svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- ============================================
            UPLOAD DOKUMEN - FORM SEDERHANA
            (HANYA TAMPIL JIKA STATUS MENUNGGU)
        ============================================ --}}
        @if($permohonan->statusPermohonan && $permohonan->statusPermohonan->kode_status === 'MENUNGGU')
        <div class="card detail-card mt-4">
            <div class="card-header">
                <h5 class="card-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="17 8 12 3 7 8"/>
                        <line x1="12" y1="3" x2="12" y2="15"/>
                    </svg>
                    Upload Dokumen
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('loket.permohonan.upload-dokumen-simple', $permohonan) }}" 
                      method="POST" 
                      enctype="multipart/form-data"
                      class="upload-form">
                    @csrf
                    
                    <div class="upload-form-grid">
                        <div class="upload-form-group">
                            <label class="form-label">Pilih File <span class="text-danger">*</span></label>
                            <div class="file-upload-wrapper-simple" id="uploadWrapper">
                                <input type="file" name="dokumen" id="dokumen_file" class="file-input-simple" accept=".jpg,.jpeg,.png,.pdf" required>
                                <span class="file-placeholder-simple" id="filePlaceholder">Klik untuk pilih file...</span>
                                <span class="file-name-simple" id="fileNameDisplay"></span>
                            </div>
                            <span class="form-hint">Format: JPG, JPEG, PNG, PDF (Max 5MB)</span>
                            @error('dokumen')
                            <span class="text-danger" style="font-size:12px;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="upload-form-group">
                            <label class="form-label">Nama Dokumen</label>
                            <input type="text" name="nama_dokumen" class="form-input" placeholder="Nama dokumen (opsional)">
                        </div>

                        <div class="upload-form-group">
                            <label class="form-label">Jenis Dokumen</label>
                            <select name="jenis_dokumen_id" class="form-select">
                                <option value="">-- Pilih Jenis --</option>
                                @foreach($jenisDokumens as $jenis)
                                <option value="{{ $jenis->id }}">{{ $jenis->nama_dokumen }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="upload-form-group upload-form-actions">
                            <button type="submit" class="btn-primary">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="22" y1="2" x2="11" y2="13"/>
                                    <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                                </svg>
                                Upload Dokumen
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif

    </div>
</div>

<style>
/* ============================================
   ALERT
============================================ */
.alert {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 18px;
    border-radius: 12px;
    margin-bottom: 20px;
    font-size: 14px;
    font-weight: 500;
}

.alert-success {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f0d0;
}

.alert-danger {
    background: #fde8e8;
    color: #b91c1c;
    border: 1px solid #fcc5c5;
}

/* ============================================
   UPLOAD FORM
============================================ */
.upload-form {
    margin-top: 4px;
}

.upload-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr auto;
    gap: 12px;
    align-items: end;
}

.upload-form-group {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.upload-form-actions {
    padding-bottom: 0;
}

.upload-form .form-label {
    font-size: 13px;
    font-weight: 600;
    color: #1d2b27;
}

.upload-form .form-input,
.upload-form .form-select {
    padding: 10px 14px;
    border: 1px solid #e9ecef;
    border-radius: 10px;
    font-size: 13px;
    font-family: inherit;
    background: #fafcfb;
    color: #1d2b27;
    width: 100%;
    transition: all 0.3s ease;
}

.upload-form .form-input:focus,
.upload-form .form-select:focus {
    outline: none;
    border-color: #07573c;
    background: white;
    box-shadow: 0 0 0 4px rgba(7, 87, 60, 0.08);
}

.upload-form .form-hint {
    font-size: 11px;
    color: #8a9a94;
}

.upload-form .text-danger {
    color: #dc2626;
    font-size: 12px;
}

/* File Upload Simple */
.file-upload-wrapper-simple {
    position: relative;
    display: flex;
    align-items: center;
    border: 1px solid #e9ecef;
    border-radius: 10px;
    background: #fafcfb;
    padding: 0 14px;
    height: 42px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.3s ease;
}

.file-upload-wrapper-simple:hover {
    border-color: #07573c;
    background: #f0f5f2;
}

.file-upload-wrapper-simple .file-input-simple {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    z-index: 2;
}

.file-upload-wrapper-simple .file-placeholder-simple {
    color: #b0c4bc;
    font-size: 13px;
    white-space: nowrap;
}

.file-upload-wrapper-simple .file-name-simple {
    font-size: 13px;
    color: #07573c;
    font-weight: 500;
    margin-left: 8px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: none;
}

.file-upload-wrapper-simple.has-file .file-placeholder-simple {
    display: none;
}

.file-upload-wrapper-simple.has-file .file-name-simple {
    display: block;
}

/* Button */
.upload-form .btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 24px;
    background: #07573c;
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
    justify-content: center;
}

.upload-form .btn-primary:hover {
    background: #043d2a;
    transform: translateY(-1px);
    box-shadow: 0 4px 16px rgba(7, 87, 60, 0.25);
}

.upload-form .btn-primary:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

.btn-sm.btn-danger {
    background: #dc2626;
    color: white;
    border: 1px solid #dc2626;
}

.btn-sm.btn-danger:hover {
    background: #b91c1c;
    border-color: #b91c1c;
}

/* ============================================
   DETAIL GRID - SAMA SEPERTI SEBELUMNYA
============================================ */
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

.detail-card .card-header .card-title {
    font-size: 14px;
    font-weight: 700;
    color: #1d2b27;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.detail-card .card-body {
    padding: 1.25rem;
}

.mt-4 { margin-top: 1.5rem; }

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

.fw-600 { font-weight: 600; }
.text-muted { color: #8a9a94; }
.small { font-size: 0.75rem; }

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    display: inline-block;
}

.priority-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.2rem 0.6rem;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 600;
}

.priority-normal {
    background: #e8f0ed;
    color: #4a5a54;
}

.priority-penting {
    background: #fef3c7;
    color: #92400e;
}

.priority-urgent {
    background: #fde8e8;
    color: #b91c1c;
}

.pemohon-profile {
    text-align: center;
    padding: 0.5rem 0;
}

.pemohon-avatar {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: linear-gradient(135deg, #e8f0ed, #c5d9d0);
    color: #07573c;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    font-weight: 700;
    margin: 0 auto 8px;
}

.pemohon-name {
    font-size: 16px;
    font-weight: 700;
    color: #1d2b27;
}

.pemohon-nik {
    font-size: 13px;
    color: #8a9a94;
}

.avatar-sm {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: linear-gradient(135deg, #e8f0ed, #c5d9d0);
    color: #07573c;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: 700;
}

.badge-soft-success {
    background: #d1fae5;
    color: #065f46;
    padding: 2px 10px;
    border-radius: 10px;
    font-size: 10px;
    font-weight: 600;
}

.badge-soft-secondary {
    background: #e9ecef;
    color: #495057;
    padding: 2px 10px;
    border-radius: 10px;
    font-size: 10px;
    font-weight: 600;
}

.timeline {
    position: relative;
    padding-left: 24px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 7px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 1rem;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -19px;
    top: 4px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-content {
    padding-left: 0.5rem;
}

.btn-outline {
    display: inline-flex;
    align-items: center;
    gap: 8px;
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
    text-decoration: none;
}

.btn-outline:hover {
    background: #f0f5f2;
    border-color: #c5ceca;
}

/* Dokumen List */
.dokumen-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.dokumen-item-detail {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    background: #f8faf9;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.dokumen-icon {
    color: #07573c;
}

.dokumen-info {
    flex: 1;
    min-width: 0;
}

.dokumen-nama {
    font-weight: 600;
    color: #1d2b27;
    font-size: 13px;
}

.dokumen-meta {
    font-size: 11px;
    color: #8a9a94;
    display: flex;
    gap: 12px;
}

.dokumen-jenis {
    background: #eef6ff;
    color: #2563eb;
    padding: 1px 8px;
    border-radius: 8px;
}

.dokumen-size {
    color: #8a9a94;
}

.status-badge-sm {
    padding: 2px 10px;
    border-radius: 10px;
    font-size: 10px;
    font-weight: 600;
}

.status-menunggu {
    background: #fef3c7;
    color: #92400e;
}

.status-valid {
    background: #d1fae5;
    color: #065f46;
}

.status-tidak_valid {
    background: #fde8e8;
    color: #b91c1c;
}

.dokumen-actions {
    display: flex;
    gap: 4px;
    align-items: center;
}

.btn-sm {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
}

.btn-sm.btn-primary {
    background: #07573c;
    color: white;
}

.btn-sm.btn-primary:hover {
    background: #043d2a;
}

.btn-sm.btn-outline {
    background: transparent;
    color: #4a5a54;
    border: 1px solid #e9ecef;
}

.btn-sm.btn-outline:hover {
    background: #f0f5f2;
}

.btn-sm.btn-danger {
    background: #dc2626;
    color: white;
    border: 1px solid #dc2626;
}

.btn-sm.btn-danger:hover {
    background: #b91c1c;
}

/* Responsive */
@media (max-width: 992px) {
    .detail-grid {
        grid-template-columns: 1fr;
    }
    .upload-form-grid {
        grid-template-columns: 1fr 1fr;
    }
    .upload-form-actions {
        grid-column: 1 / -1;
    }
}

@media (max-width: 768px) {
    .detail-grid-2 {
        grid-template-columns: 1fr;
    }
    .dokumen-item-detail {
        flex-wrap: wrap;
    }
    .dokumen-actions {
        width: 100%;
        justify-content: flex-end;
    }
    .upload-form-grid {
        grid-template-columns: 1fr;
    }
    .upload-form-actions {
        grid-column: 1;
    }
}
</style>

@push('scripts')
<script>
// ============================================
// FILE INPUT PREVIEW - UPLOAD DOKUMEN
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('dokumen_file');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const wrapper = document.getElementById('uploadWrapper');
            const placeholder = document.getElementById('filePlaceholder');
            const fileName = document.getElementById('fileNameDisplay');

            if (this.files && this.files.length > 0) {
                const file = this.files[0];
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];

                // Validasi tipe file
                if (!validTypes.includes(file.type)) {
                    alert('Format file tidak didukung. Gunakan JPG, JPEG, PNG, atau PDF.');
                    this.value = '';
                    wrapper.classList.remove('has-file');
                    if (placeholder) placeholder.style.display = 'block';
                    if (fileName) fileName.textContent = '';
                    return;
                }

                // Validasi ukuran file (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 5MB.');
                    this.value = '';
                    wrapper.classList.remove('has-file');
                    if (placeholder) placeholder.style.display = 'block';
                    if (fileName) fileName.textContent = '';
                    return;
                }

                wrapper.classList.add('has-file');
                if (placeholder) placeholder.style.display = 'none';
                if (fileName) fileName.textContent = file.name;

                // Auto fill nama dokumen dari nama file
                const nameInput = document.querySelector('input[name="nama_dokumen"]');
                if (nameInput && !nameInput.value) {
                    nameInput.value = file.name.replace(/\.[^/.]+$/, '');
                }
            } else {
                wrapper.classList.remove('has-file');
                if (placeholder) placeholder.style.display = 'block';
                if (fileName) fileName.textContent = '';
            }
        });
    }
});
</script>
@endpush

@endsection