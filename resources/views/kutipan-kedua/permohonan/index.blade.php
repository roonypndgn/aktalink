@extends('layouts.kutipan-kedua')

@section('title', 'Permohonan Kutipan Kedua - AKTALINK')
@section('page-title', 'Permohonan Kutipan Kedua')
@section('page-description', 'Kelola permohonan layanan kutipan kedua')

@section('content')

{{-- ============================================
    TAB NAVIGATION
============================================ --}}
<div class="tab-navigation">
    <a href="{{ route('kutipan-kedua.permohonan.index') }}" 
       class="tab-link {{ Route::currentRouteName() == 'kutipan-kedua.permohonan.index' ? 'active' : '' }}">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="2" y="7" width="20" height="14" rx="2"/>
            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
        </svg>
        Semua
        <span class="tab-badge">{{ $stats['total'] }}</span>
    </a>
    <a href="{{ route('kutipan-kedua.permohonan.diproses') }}" 
       class="tab-link {{ Route::currentRouteName() == 'kutipan-kedua.permohonan.diproses' ? 'active' : '' }}">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <polyline points="12 6 12 12 16 14"/>
        </svg>
        Perlu Diproses
        <span class="tab-badge warning">{{ $stats['menunggu'] }}</span>
    </a>
    <a href="{{ route('kutipan-kedua.permohonan.sedang-diproses') }}" 
       class="tab-link {{ Route::currentRouteName() == 'kutipan-kedua.permohonan.sedang-diproses' ? 'active' : '' }}">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <polyline points="12 6 12 12 16 14"/>
        </svg>
        Diproses
        <span class="tab-badge info">{{ $stats['proses'] }}</span>
    </a>
    <a href="{{ route('kutipan-kedua.permohonan.selesai') }}" 
       class="tab-link {{ Route::currentRouteName() == 'kutipan-kedua.permohonan.selesai' ? 'active' : '' }}">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
            <polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
        Selesai
        <span class="tab-badge success">{{ $stats['selesai'] }}</span>
    </a>
</div>

{{-- ============================================
    FILTER
============================================ --}}
<div class="filter-container">
    <form method="GET" action="{{ route('kutipan-kedua.permohonan.index') }}" id="filterForm">
        <div class="filter-grid">
            <div class="filter-item search-item">
                <div class="search-wrapper">
                    <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" name="search" class="search-input" placeholder="Cari nomor, nama, NIK..." value="{{ request('search') }}">
                    @if(request('search'))
                    <a href="{{ route('kutipan-kedua.permohonan.index') }}" class="search-clear">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18"/>
                            <line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                    </a>
                    @endif
                </div>
            </div>

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
                <select name="prioritas" class="filter-select">
                    <option value="">Semua Prioritas</option>
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
                <a href="{{ route('kutipan-kedua.permohonan.index') }}" class="btn-reset">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23 4 23 10 17 10"/>
                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                    </svg>
                </a>
            </div>
        </div>
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
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nomor</th>
                    <th>Pemohon</th>
                    <th>Layanan</th>
                    <th>Status</th>
                    <th>Prioritas</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($permohonans as $index => $permohonan)
                <tr>
                    <td>{{ $permohonans->firstItem() + $index }}</td>
                    <td>
                        <div class="nomor-number">{{ $permohonan->nomor_permohonan }}</div>
                        <div class="nomor-title">{{ Str::limit($permohonan->judul_permohonan ?? 'Tanpa judul', 30) }}</div>
                    </td>
                    <td>
                        <div class="pemohon-wrapper">
                            <div class="pemohon-avatar">{{ Str::substr($permohonan->pemohon->nama_lengkap, 0, 2) }}</div>
                            <span class="pemohon-name">{{ $permohonan->pemohon->nama_lengkap }}</span>
                        </div>
                    </td>
                    <td><span class="layanan-badge">{{ Str::limit($permohonan->jenisLayanan->nama_layanan, 20) }}</span></td>
                    <td>
                        <span class="status-indicator" style="background: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}20; color: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}">
                            <span class="status-dot" style="background: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}"></span>
                            {{ $permohonan->statusPermohonan->nama_status }}
                        </span>
                    </td>
                    <td>
                        <span class="priority-badge priority-{{ $permohonan->prioritas }}">
                            {{ $permohonan->label_prioritas }}
                        </span>
                    </td>
                    <td>
                        <div class="tanggal-date">{{ $permohonan->tanggal_permohonan->format('d M Y') }}</div>
                        <div class="tanggal-time">{{ $permohonan->tanggal_permohonan->setTimezone('Asia/Jakarta')->format('H:i') }}</div>
                    </td>
                    <td>
    <div class="action-group">
        {{-- Detail --}}
        <a href="{{ route('kutipan-kedua.permohonan.show', $permohonan) }}" class="action-btn view-btn" title="Detail">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
        </a>

        {{-- Update Status --}}
        <button type="button" class="action-btn status-btn" onclick="openUpdateStatusModal({{ $permohonan->id }})" title="Update Status">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
        </button>

        {{-- Tambah Komentar --}}
        <button type="button" class="action-btn comment-btn" onclick="openTambahKomentarModal({{ $permohonan->id }})" title="Tambah Komentar">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </svg>
        </button>

        {{-- Upload Dokumen --}}
        <button type="button" class="action-btn upload-btn" onclick="openUploadDokumenModal({{ $permohonan->id }})" title="Upload Dokumen">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="16 16 12 12 8 16"/>
                <line x1="12" y1="12" x2="12" y2="21"/>
                <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>
                <polyline points="16 16 12 12 8 16"/>
            </svg>
        </button>

        {{-- Proses (hanya untuk status DITERUSKAN) --}}
        @if($permohonan->statusPermohonan && $permohonan->statusPermohonan->kode_status === 'DITERUSKAN')
        <button type="button" class="action-btn proses-btn" onclick="openProsesModal({{ $permohonan->id }})" title="Proses">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
            </svg>
        </button>
        @endif
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
                            <p>Belum ada permohonan yang terdaftar</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($permohonans->hasPages())
    <div class="table-footer">
        <div class="pagination-info">
            Menampilkan <strong>{{ $permohonans->firstItem() ?? 0 }}</strong> - <strong>{{ $permohonans->lastItem() ?? 0 }}</strong>
            dari <strong>{{ $permohonans->total() }}</strong> data
        </div>
        <nav class="pagination-nav">
            {{ $permohonans->links() }}
        </nav>
    </div>
    @endif
</div>
{{-- ============================================
    MODAL UPLOAD DOKUMEN
============================================ --}}
<div class="modal-overlay" id="uploadDokumenModal" style="display: none;">
    <div class="modal-container">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-header-icon" style="background: #dbeafe; color: #2563eb;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="17 8 12 3 7 8"/>
                        <line x1="12" y1="3" x2="12" y2="15"/>
                    </svg>
                </div>
                <h4 class="modal-title">Upload Dokumen</h4>
                <button type="button" class="modal-close" onclick="closeModal('uploadDokumenModal')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            <form id="uploadDokumenForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group full-width">
                        <label class="form-label">Pilih Dokumen <span class="text-danger">*</span></label>
                        <div class="file-drop-zone" id="dropZone">
                            <input type="file" name="dokumen" id="upload_dokumen_file" class="file-input" accept=".jpg,.jpeg,.png,.pdf" required>
                            <div class="file-drop-content">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#07573c" stroke-width="1.5">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline points="17 8 12 3 7 8"/>
                                    <line x1="12" y1="3" x2="12" y2="15"/>
                                </svg>
                                <p class="upload-text" id="uploadText">Klik atau drag file ke sini</p>
                                <p class="upload-hint">Format: JPG, JPEG, PNG, PDF (Max 5MB)</p>
                                <p class="upload-filename" id="uploadFileName" style="display:none;"></p>
                            </div>
                        </div>
                        <span class="form-error" id="upload-error-dokumen"></span>
                    </div>

                    <div class="form-grid-upload">
                        <div class="form-group">
                            <label class="form-label">Nama Dokumen</label>
                            <input type="text" name="nama_dokumen" id="upload_nama_dokumen" class="form-input" placeholder="Nama dokumen (opsional)">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Jenis Dokumen</label>
                            <select name="jenis_dokumen_id" id="upload_jenis_dokumen_id" class="form-select">
                                <option value="">-- Pilih Jenis --</option>
                                @if(isset($jenisDokumens) && $jenisDokumens->count() > 0)
                                    @foreach($jenisDokumens as $jenis)
                                    <option value="{{ $jenis->id }}">{{ $jenis->nama_dokumen }}</option>
                                    @endforeach
                                @else
                                    <option value="">Jenis dokumen belum tersedia</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div id="uploadModalError" style="display:none;color:#dc2626;font-size:13px;margin-top:8px;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeModal('uploadDokumenModal')">Batal</button>
                    <button type="submit" class="btn-primary" id="uploadDokumenSubmit">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="22" y1="2" x2="11" y2="13"/>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                        </svg>
                        Upload Dokumen
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- ============================================
    MODAL PROSES
============================================ --}}
<div class="modal-overlay" id="prosesModal" style="display: none;">
    <div class="modal-container">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-header-icon" style="background: #dbeafe; color: #2563eb;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <h4 class="modal-title">Proses Permohonan</h4>
                <button type="button" class="modal-close" onclick="closeModal('prosesModal')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            <form id="prosesForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Apakah Anda akan memproses permohonan ini?</p>
                    <div class="form-group full-width" style="margin-top:12px;">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-textarea" rows="3" placeholder="Tambahkan keterangan (opsional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeModal('prosesModal')">Batal</button>
                    <button type="submit" class="btn-primary" id="prosesSubmit">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        Proses Permohonan
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

/* ============================================
   TAB NAVIGATION
============================================ */
.tab-navigation {
    display: flex;
    gap: 4px;
    background: white;
    border-radius: 16px;
    padding: 6px;
    margin-bottom: 24px;
    border: 1px solid #f0f2f1;
    flex-wrap: wrap;
}
.tab-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
    color: #6c7a75;
    text-decoration: none;
    transition: all 0.3s ease;
    background: transparent;
    border: none;
    cursor: pointer;
}
.tab-link:hover {
    background: #f0f5f2;
    color: #07573c;
}
.tab-link.active {
    background: linear-gradient(135deg, #07573c, #0d8a5a);
    color: white;
    box-shadow: 0 4px 12px rgba(7, 87, 60, 0.25);
}
.tab-link.active .tab-badge {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}
.tab-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 20px;
    padding: 1px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 700;
    background: #e8f0ed;
    color: #4a5a54;
}
.tab-badge.warning {
    background: #fef3c7;
    color: #92400e;
}
.tab-badge.info {
    background: #dbeafe;
    color: #2563eb;
}
.tab-badge.success {
    background: #d1fae5;
    color: #065f46;
}
.upload-btn:hover {
    background: #dbeafe;
    color: #2563eb;
}
/* ============================================
   FILE DROP ZONE - STYLE
============================================ */
.file-drop-zone {
    border: 2px dashed #dce2e0;
    border-radius: 12px;
    padding: 30px 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s;
    background: #fafcfb;
    position: relative;
}

.file-drop-zone:hover {
    border-color: #07573c;
    background: #f0f9f5;
}

.file-drop-zone .file-input {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    z-index: 2;
    width: 100%;
    height: 100%;
}

.file-drop-zone.drag-over {
    border-color: #07573c;
    background: #f0f9f5;
}

.file-drop-zone .file-drop-content {
    pointer-events: none;
}

.file-drop-zone .file-drop-content svg {
    color: #07573c;
}

.file-drop-zone .upload-text {
    margin-top: 8px;
    font-weight: 500;
    color: #1d2b27;
}

.file-drop-zone .upload-hint {
    font-size: 12px;
    color: #8a9a94;
    margin-top: 2px;
}

.file-drop-zone .upload-filename {
    font-weight: 600;
    color: #07573c;
    margin-top: 4px;
}

/* ============================================
   FORM GRID UPLOAD
============================================ */
.form-grid-upload {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-top: 16px;
}

.form-grid-upload .form-group {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.form-grid-upload .form-group .form-label {
    font-size: 13px;
    font-weight: 600;
    color: #1d2b27;
}

.form-grid-upload .form-group .form-input,
.form-grid-upload .form-group .form-select {
    padding: 10px 14px;
    border: 1px solid #e9ecef;
    border-radius: 10px;
    font-size: 13px;
    background: #fafcfb;
    color: #1d2b27;
    width: 100%;
    font-family: inherit;
    transition: all 0.3s ease;
}

.form-grid-upload .form-group .form-input:focus,
.form-grid-upload .form-group .form-select:focus {
    outline: none;
    border-color: #07573c;
    background: white;
    box-shadow: 0 0 0 4px rgba(7, 87, 60, 0.08);
}

.form-grid-upload .form-group .form-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238a9a94' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    padding-right: 36px;
    cursor: pointer;
}

.form-grid-upload .form-group .form-input::placeholder {
    color: #b0c4bc;
    font-weight: 400;
}

/* ============================================
   RESPONSIVE MODAL UPLOAD
============================================ */
@media (max-width: 768px) {
    .form-grid-upload {
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .file-drop-zone {
        padding: 20px 15px;
    }

    .file-drop-zone .file-drop-content svg {
        width: 36px;
        height: 36px;
    }
}
/* ============================================
   FILTER
============================================ */
.filter-container {
    background: white;
    border-radius: 16px;
    padding: 20px 24px;
    margin-bottom: 24px;
    border: 1px solid #f0f2f1;
}
.filter-grid {
    display: flex;
    gap: 12px;
    align-items: center;
    flex-wrap: wrap;
}
.filter-item.search-item { flex: 2 1 260px; min-width: 200px; }
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
    background: #fafcfb;
    color: #1d2b27;
}
.search-input:focus {
    outline: none;
    border-color: #07573c;
    background: white;
    box-shadow: 0 0 0 4px rgba(7,87,60,0.08);
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
}
.search-clear:hover { background: #f0f5f2; color: #4a5a54; }
.filter-select {
    padding: 10px 36px 10px 14px;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    font-size: 13px;
    background: #fafcfb;
    color: #1d2b27;
    cursor: pointer;
    min-width: 130px;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238a9a94' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
}
.filter-select:focus {
    outline: none;
    border-color: #07573c;
    background-color: white;
    box-shadow: 0 0 0 4px rgba(7,87,60,0.08);
}
.filter-actions { display: flex; gap: 8px; }
.btn-filter {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: #07573c;
    color: white;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    border: none;
}
.btn-filter:hover { background: #043d2a; }
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
    text-decoration: none;
}
.btn-reset:hover { background: #f0f5f2; }
.action-group {
    display: flex;
    gap: 4px;
    justify-content: center;
    flex-wrap: wrap;
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

.action-btn:hover {
    transform: translateY(-1px);
}

/* Detail - Biru */
.view-btn:hover {
    background: #dbeafe;
    color: #2563eb;
}

/* Update Status - Kuning */
.status-btn:hover {
    background: #fef3c7;
    color: #92400e;
}

/* Tambah Komentar - Biru Muda */
.comment-btn:hover {
    background: #dbeafe;
    color: #2563eb;
}

/* Proses - Hijau */
.proses-btn:hover {
    background: #d1fae5;
    color: #065f46;
}

/* Responsive */
@media (max-width: 768px) {
    .action-group {
        gap: 2px;
    }
    .action-btn {
        width: 28px;
        height: 28px;
    }
    .action-btn svg {
        width: 14px;
        height: 14px;
    }
}
/* ============================================
   TABLE
============================================ */
.table-container {
    background: white;
    border-radius: 16px;
    border: 1px solid #f0f2f1;
    overflow: hidden;
}
.table-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 24px;
    border-bottom: 1px solid #f0f2f1;
}
.table-count {
    font-size: 18px;
    font-weight: 800;
    color: #07573c;
}
.table-label { font-size: 13px; color: #8a9a94; }
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
    color: #8a9a94;
    background: #fafcfb;
    border-bottom: 2px solid #f0f2f1;
}
.data-table tbody td {
    padding: 14px 16px;
    border-bottom: 1px solid #f5f7f6;
    vertical-align: middle;
}
.data-table tbody tr:hover { background: #fafcfb; }

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
.pemohon-name { font-weight: 600; color: #1d2b27; font-size: 14px; }
.nomor-number { font-weight: 700; color: #07573c; font-size: 13px; }
.nomor-title { font-size: 12px; color: #8a9a94; }

.layanan-badge {
    display: inline-block;
    padding: 3px 12px;
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

.tanggal-date { display: block; font-weight: 500; color: #1d2b27; font-size: 12px; }
.tanggal-time { font-size: 10px; color: #8a9a94; }

.action-group {
    display: flex;
    gap: 4px;
    justify-content: center;
    flex-wrap: wrap;
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
}
.action-btn:hover { transform: translateY(-1px); }
.view-btn:hover { background: #dbeafe; color: #2563eb; }
.edit-btn:hover { background: #fef3c7; color: #92400e; }

.table-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 24px;
    border-top: 1px solid #f0f2f1;
    background: #fafcfb;
}
.pagination-info { font-size: 13px; color: #6c7a75; }

.empty-state {
    text-align: center;
    padding: 60px 20px;
}
.empty-icon { margin-bottom: 16px; color: #d0dcd6; }
.empty-state h4 { font-size: 18px; font-weight: 700; color: #1d2b27; }
.empty-state p { color: #8a9a94; font-size: 14px; }

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
.form-textarea {
    padding: 10px 14px;
    border: 1px solid #e9ecef;
    border-radius: 10px;
    font-size: 13px;
    background: #fafcfb;
    color: #1d2b27;
    width: 100%;
    resize: vertical;
    min-height: 60px;
    font-family: inherit;
}
.form-textarea:focus {
    outline: none;
    border-color: #07573c;
    background: white;
    box-shadow: 0 0 0 4px rgba(7,87,60,0.08);
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
@media (max-width: 992px) {
    .hero-stats { grid-template-columns: 1fr 1fr; }
    .filter-grid { flex-direction: column; }
    .filter-item.search-item { flex: unset; }
}
@media (max-width: 768px) {
    .hero-stats { grid-template-columns: 1fr; }
    .data-table thead { display: none; }
    .data-table tbody tr { display: block; padding: 16px; border-bottom: 1px solid #f0f2f1; }
    .data-table tbody td { display: flex; justify-content: space-between; align-items: center; padding: 6px 0; border: none; }
    .data-table tbody td::before {
        content: attr(data-label);
        font-weight: 600;
        font-size: 11px;
        color: #8a9a94;
        text-transform: uppercase;
    }
    .table-footer { flex-direction: column; gap: 12px; text-align: center; }
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
// UPDATE STATUS - DARI INDEX
// ============================================
function openUpdateStatusModal(id) {
    // Redirect ke halaman show dengan anchor ke modal update status
    window.location.href = `{{ url('kutipan-kedua/permohonan') }}/${id}#updateStatus`;
}

// ============================================
// TAMBAH KOMENTAR - DARI INDEX
// ============================================
function openTambahKomentarModal(id) {
    // Redirect ke halaman show dengan anchor ke modal tambah komentar
    window.location.href = `{{ url('kutipan-kedua/permohonan') }}/${id}#tambahKomentar`;
}

// ============================================
// PROSES PERMOHONAN - DARI INDEX
// ============================================
function openProsesModal(id) {
    // Redirect ke halaman show dengan anchor ke modal proses
    window.location.href = `{{ url('kutipan-kedua/permohonan') }}/${id}#prosesModal`;
}
// ============================================
// FILTER AUTO-SUBMIT
// ============================================
document.querySelectorAll('.filter-select').forEach(select => {
    select.addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
});

document.querySelector('.search-input')?.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('filterForm').submit();
    }
});

// ============================================
// PROSES PERMOHONAN
// ============================================
let prosesPermohonanId = null;

function openProsesModal(id) {
    prosesPermohonanId = id;
    document.getElementById('prosesForm').reset();
    document.getElementById('prosesForm').action = `{{ url('kutipan-kedua/permohonan') }}/${id}/proses`;
    openModal('prosesModal');
}

document.getElementById('prosesForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const submitBtn = document.getElementById('prosesSubmit');
    submitBtn.disabled = true;
    submitBtn.innerHTML = 'Memproses...';
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
            closeModal('prosesModal');
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
        submitBtn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> Proses Permohonan';
    });
});
// ============================================
// UPLOAD DOKUMEN
// ============================================
let uploadPermohonanId = null;

function openUploadDokumenModal(id) {
    uploadPermohonanId = id;
    const form = document.getElementById('uploadDokumenForm');
    if (form) {
        form.reset();
        form.action = `{{ url('kutipan-kedua/permohonan') }}/${id}/upload-dokumen`;
    }
    
    // Reset drop zone
    const dropZone = document.getElementById('dropZone');
    if (dropZone) {
        dropZone.style.borderColor = '#dce2e0';
        dropZone.style.background = '#fafcfb';
        dropZone.classList.remove('drag-over');
    }
    
    document.getElementById('uploadFileName').style.display = 'none';
    document.getElementById('uploadText').textContent = 'Klik atau drag file ke sini';
    document.getElementById('uploadModalError').style.display = 'none';
    
    openModal('uploadDokumenModal');
}

document.getElementById('uploadDokumenForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const fileInput = document.getElementById('upload_dokumen_file');
    const errorEl = document.getElementById('uploadModalError');
    
    // VALIDASI FILE
    if (!fileInput.files || fileInput.files.length === 0) {
        if (errorEl) {
            errorEl.textContent = '⚠️ Pilih file dulu!';
            errorEl.style.display = 'block';
        }
        return;
    }
    
    const file = fileInput.files[0];
    const maxSize = 5 * 1024 * 1024; // 5MB
    
    // VALIDASI UKURAN FILE
    if (file.size > maxSize) {
        if (errorEl) {
            errorEl.textContent = '⚠️ Ukuran file terlalu besar. Maksimal 5MB.';
            errorEl.style.display = 'block';
        }
        return;
    }
    
    // VALIDASI EKSTENSI FILE
    const allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
    const extension = file.name.split('.').pop().toLowerCase();
    if (!allowedExtensions.includes(extension)) {
        if (errorEl) {
            errorEl.textContent = '⚠️ Format file tidak didukung. Gunakan JPG, JPEG, PNG, atau PDF.';
            errorEl.style.display = 'block';
        }
        return;
    }
    
    if (errorEl) {
        errorEl.style.display = 'none';
    }
    
    // PROSES UPLOAD
    const submitBtn = document.getElementById('uploadDokumenSubmit');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '⏳ Uploading...';
    
    const formData = new FormData(this);
    
    fetch(this.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => {
                throw new Error(err.message || 'Server error');
            });
        }
        return response.json();
    })
    .then(data => {
        console.log('Response:', data);
        
        if (data.success) {
            showToast(data.message, 'success');
            closeModal('uploadDokumenModal');
            setTimeout(() => window.location.reload(), 500);
        } else {
            if (data.errors) {
                const firstError = Object.values(data.errors)[0];
                if (Array.isArray(firstError)) {
                    showToast(firstError[0], 'error');
                } else {
                    showToast(firstError || 'Terjadi kesalahan', 'error');
                }
            } else {
                showToast(data.message || 'Terjadi kesalahan', 'error');
            }
        }
    })
    .catch(err => {
        console.error('Upload error:', err);
        showToast('❌ ' + (err.message || 'Terjadi kesalahan server'), 'error');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});

// DROP ZONE EVENTS
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('upload_dokumen_file');
    const uploadText = document.getElementById('uploadText');
    const fileName = document.getElementById('uploadFileName');

    if (dropZone && fileInput) {
        fileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                const file = this.files[0];
                uploadText.textContent = '📄 File siap diupload';
                fileName.textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
                fileName.style.display = 'block';
                dropZone.style.borderColor = '#07573c';
                dropZone.style.background = '#f0f9f5';
                dropZone.classList.add('drag-over');
            }
        });

        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.style.borderColor = '#07573c';
            this.style.background = '#f0f9f5';
            this.classList.add('drag-over');
        });

        dropZone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            if (!this.contains(e.relatedTarget)) {
                this.style.borderColor = '#dce2e0';
                this.style.background = '#fafcfb';
                this.classList.remove('drag-over');
            }
        });

        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.style.borderColor = '#dce2e0';
            this.style.background = '#fafcfb';
            this.classList.remove('drag-over');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                const file = files[0];
                uploadText.textContent = '📄 File siap diupload';
                fileName.textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
                fileName.style.display = 'block';
                this.style.borderColor = '#07573c';
                this.style.background = '#f0f9f5';
                this.classList.add('drag-over');
            }
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

console.log('✅ Kutipan Kedua - Permohonan module loaded successfully');
</script>
@endpush