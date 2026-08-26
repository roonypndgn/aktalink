{{-- resources/views/loket/permohonan/index.blade.php --}}

@extends('layouts.loket')

@section('title', 'Semua Permohonan - AKTALINK')
@section('page-title', 'Semua Permohonan')
@section('page-description', 'Kelola dan pantau semua permohonan layanan akta')

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
    TAB NAVIGATION
============================================ --}}
<div class="tab-navigation">
    <a href="{{ route('loket.permohonan.index') }}" 
       class="tab-link {{ Route::currentRouteName() == 'loket.permohonan.index' ? 'active' : '' }}">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="2" y="7" width="20" height="14" rx="2"/>
            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
        </svg>
        Semua
        <span class="tab-badge">{{ $stats['total'] }}</span>
    </a>
    <a href="{{ route('loket.permohonan.diteruskan') }}" 
       class="tab-link {{ Route::currentRouteName() == 'loket.permohonan.diteruskan' ? 'active' : '' }}">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <polyline points="12 6 12 12 16 14"/>
        </svg>
        Perlu Diteruskan
        <span class="tab-badge warning">{{ $stats['menunggu'] }}</span>
    </a>
    <a href="{{ route('loket.permohonan.proses') }}" 
       class="tab-link {{ Route::currentRouteName() == 'loket.permohonan.proses' ? 'active' : '' }}">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <polyline points="12 6 12 12 16 14"/>
        </svg>
        Sedang Diproses
        <span class="tab-badge info">{{ $stats['proses'] }}</span>
    </a>
    <a href="{{ route('loket.permohonan.selesai') }}" 
       class="tab-link {{ Route::currentRouteName() == 'loket.permohonan.selesai' ? 'active' : '' }}">
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
    <form method="GET" action="{{ route('loket.permohonan.index') }}" id="filterForm">
        <div class="filter-grid">
            <div class="filter-item search-item">
                <div class="search-wrapper">
                    <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" name="search" class="search-input" placeholder="Cari nomor, nama, NIK..." value="{{ request('search') }}">
                    @if(request('search'))
                    <a href="{{ route('loket.permohonan.index') }}" class="search-clear">
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
                <select name="jenis_layanan" class="filter-select">
                    <option value="">Semua Layanan</option>
                    @foreach($layanans as $layanan)
                    <option value="{{ $layanan->id }}" {{ request('jenis_layanan') == $layanan->id ? 'selected' : '' }}>
                        {{ $layanan->nama_layanan }}
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
                <a href="{{ route('loket.permohonan.index') }}" class="btn-reset">
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
                            <a href="{{ route('loket.permohonan.show', $permohonan) }}" class="action-btn view-btn" title="Detail">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                            <button type="button" class="action-btn edit-btn" onclick="openEditModal({{ $permohonan->id }})" title="Edit">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            @if($permohonan->statusPermohonan && $permohonan->statusPermohonan->kode_status === 'MENUNGGU')
                            <button type="button" class="action-btn distribusi-btn" onclick="openDistribusiModal({{ $permohonan->id }})" title="Teruskan">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                            </button>
                            @endif
                            <button type="button" class="action-btn upload-btn" onclick="openUploadDokumenModal({{ $permohonan->id }})" title="Upload Dokumen">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/><polyline points="16 16 12 12 8 16"/></svg>
                            </button>
                            <button type="button" class="action-btn delete-btn" onclick="openDeleteModal({{ $permohonan->id }}, '{{ $permohonan->nomor_permohonan }}')" title="Hapus">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
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
                            <h4>Tidak ada permohonan</h4>
                            <p>Belum ada permohonan yang terdaftar</p>
                            <button type="button" class="btn-pdf mt-3" onclick="openCreateModal()">
                                Tambah Permohonan
                            </button>
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
            {{ $permohonans->links() }}
        </nav>
    </div>
    @endif
</div>

{{-- ============================================
    MODAL CREATE
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
    MODAL EDIT
============================================ --}}
<div class="modal-overlay" id="editModal" style="display: none;">
    <div class="modal-container modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-header-icon" style="background: #fef3c7; color: #92400e;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                </div>
                <h4 class="modal-title">Edit Permohonan</h4>
                <button type="button" class="modal-close" onclick="closeModal('editModal')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label class="form-label">Pemohon <span class="text-danger">*</span></label>
                            <select name="pemohon_id" id="edit_pemohon_id" class="form-select" required>
                                <option value="">-- Pilih Pemohon --</option>
                                @foreach($pemohons as $pemohon)
                                <option value="{{ $pemohon->id }}">{{ $pemohon->nama_lengkap }} ({{ $pemohon->nik }})</option>
                                @endforeach
                            </select>
                            <span class="form-error" id="error-edit-pemohon_id"></span>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">Judul Permohonan</label>
                            <input type="text" name="judul_permohonan" id="edit_judul_permohonan" class="form-input" placeholder="Masukkan judul permohonan">
                            <span class="form-error" id="error-edit-judul_permohonan"></span>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">Keterangan <span class="text-danger">*</span></label>
                            <textarea name="keterangan" id="edit_keterangan" class="form-textarea" rows="3" placeholder="Deskripsikan permasalahan" required></textarea>
                            <span class="form-error" id="error-edit-keterangan"></span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Jenis Layanan <span class="text-danger">*</span></label>
                            <select name="jenis_layanan_id" id="edit_jenis_layanan_id" class="form-select" required>
                                <option value="">-- Pilih Layanan --</option>
                                @foreach($layanans as $layanan)
                                <option value="{{ $layanan->id }}">{{ $layanan->nama_layanan }}</option>
                                @endforeach
                            </select>
                            <span class="form-error" id="error-edit-jenis_layanan_id"></span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status_permohonan_id" id="edit_status_permohonan_id" class="form-select" required>
                                <option value="">-- Pilih Status --</option>
                                @foreach($statuses as $status)
                                <option value="{{ $status->id }}">{{ $status->nama_status }}</option>
                                @endforeach
                            </select>
                            <span class="form-error" id="error-edit-status_permohonan_id"></span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Prioritas <span class="text-danger">*</span></label>
                            <select name="prioritas" id="edit_prioritas" class="form-select" required>
                                <option value="normal">Normal</option>
                                <option value="penting">Penting</option>
                                <option value="urgent">Urgent</option>
                            </select>
                            <span class="form-error" id="error-edit-prioritas"></span>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">Catatan Loket</label>
                            <textarea name="catatan_loket" id="edit_catatan_loket" class="form-textarea" rows="2"></textarea>
                            <span class="form-error" id="error-edit-catatan_loket"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeModal('editModal')">Batal</button>
                    <button type="submit" class="btn-primary" id="editSubmit">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ============================================
    MODAL UPLOAD DOKUMEN - PERBAIKAN
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
                        <div class="file-drop-zone" id="dropZone" style="border:2px dashed #dce2e0;border-radius:12px;padding:30px 20px;text-align:center;cursor:pointer;transition:all 0.3s;background:#fafcfb;">
                            <input type="file" name="dokumen" id="upload_dokumen_file" class="file-input" accept=".jpg,.jpeg,.png,.pdf" required style="position:absolute;inset:0;opacity:0;cursor:pointer;z-index:2;width:100%;height:100%;">
                            <div style="pointer-events:none;">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#07573c" stroke-width="1.5">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline points="17 8 12 3 7 8"/>
                                    <line x1="12" y1="3" x2="12" y2="15"/>
                                </svg>
                                <p style="margin-top:8px;font-weight:500;color:#1d2b27;" id="uploadText">Klik atau drag file ke sini</p>
                                <p style="font-size:12px;color:#8a9a94;">Format: JPG, JPEG, PNG, PDF (Max 5MB)</p>
                                <p id="uploadFileName" style="font-weight:600;color:#07573c;margin-top:4px;display:none;"></p>
                            </div>
                        </div>
                        <span class="form-error" id="upload-error-dokumen"></span>
                    </div>
                    
                    <div class="form-group full-width" style="margin-top:12px;">
                        <label class="form-label">Nama Dokumen</label>
                        <input type="text" name="nama_dokumen" id="upload_nama_dokumen" class="form-input" placeholder="Nama dokumen (opsional)">
                    </div>
                    
                    <div class="form-group full-width">
                        <label class="form-label">Jenis Dokumen</label>
                        <select name="jenis_dokumen_id" id="upload_jenis_dokumen_id" class="form-select">
                            <option value="">-- Pilih Jenis --</option>
                            @foreach($jenisDokumens as $jenis)
                            <option value="{{ $jenis->id }}">{{ $jenis->nama_dokumen }}</option>
                            @endforeach
                        </select>
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
    MODAL DELETE
============================================ --}}
<div class="modal-overlay" id="deleteModal" style="display: none;">
    <div class="modal-container" style="max-width:400px;">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-header-icon" style="background: #fde8e8; color: #b91c1c;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                    </svg>
                </div>
                <h4 class="modal-title">Hapus Permohonan</h4>
                <button type="button" class="modal-close" onclick="closeModal('deleteModal')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus permohonan <strong id="deleteNomor"></strong>?</p>
                <p class="text-muted" style="font-size:13px;">Semua data terkait termasuk dokumen akan dihapus. Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('deleteModal')">Batal</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger" id="deleteSubmit">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                        </svg>
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ============================================
    MODAL DISTRIBUSI
============================================ --}}
<div class="modal-overlay" id="distribusiModal" style="display: none;">
    <div class="modal-container">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-header-icon" style="background: #dbeafe; color: #2563eb;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13"/>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                    </svg>
                </div>
                <h4 class="modal-title">Teruskan Permohonan</h4>
                <button type="button" class="modal-close" onclick="closeModal('distribusiModal')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            <form id="distribusiForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div id="distribusi_info" style="margin-bottom:16px;">
                        <div class="distribusi-info">
                            <div class="distribusi-info-item full-width" style="color:#f59e0b;font-weight:500;">
                                ⏳ Mengecek ketersediaan petugas...
                            </div>
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" class="form-textarea" rows="2" placeholder="Catatan untuk petugas tujuan (opsional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeModal('distribusiModal')">Batal</button>
                    <button type="submit" class="btn-primary" id="distribusi_submit" style="display:none;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="22" y1="2" x2="11" y2="13"/>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                        </svg>
                        Teruskan Permohonan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- TOAST NOTIFICATION --}}
<div id="toastContainer"></div>

@endsection

@push('styles')
<style>
/* ============================================
   BASE STYLES
============================================ */
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
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
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
    text-decoration: none;
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

.tab-link.active:hover {
    background: linear-gradient(135deg, #043d2a, #07573c);
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
    transition: all 0.3s ease;
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

.tab-link svg {
    flex-shrink: 0;
}

/* Responsive Tab */
@media (max-width: 768px) {
    .tab-navigation {
        flex-direction: column;
        gap: 4px;
        padding: 4px;
    }
    
    .tab-link {
        justify-content: center;
        padding: 10px 16px;
        width: 100%;
    }
}
/* ============================================
   BUTTON PDF & OUTLINE
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
/* Filter */
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

/* Table */
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
.data-table tbody tr:last-child td { border-bottom: none; }

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
.delete-btn:hover { background: #fde8e8; color: #b91c1c; }
.upload-btn:hover { background: #dbeafe; color: #2563eb; }
.distribusi-btn:hover { background: #dbeafe; color: #2563eb; }

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

/* Modal */
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

/* Form */
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
.btn-danger {
    background: #dc2626;
    color: white;
    border: 1px solid #dc2626;
    padding: 0.5rem 1.25rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
.btn-danger:hover { background: #b91c1c; }

.file-drop-zone {
    position: relative;
    border: 2px dashed #dce2e0;
    border-radius: 12px;
    padding: 30px 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s;
    background: #fafcfb;
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

.distribusi-info-text {
    margin-top: 8px;
    padding: 8px 12px;
    background: #dbeafe;
    border-radius: 8px;
    font-size: 12px;
    color: #1e40af;
}
.distribusi-info { display: grid; grid-template-columns: 1fr 1fr; gap: 12px 20px; }
.distribusi-info-item.full-width { grid-column: 1 / -1; }
.distribusi-info-item label { font-size: 11px; font-weight: 600; color: #8a9a94; text-transform: uppercase; }

.mt-3 { margin-top: 16px; }
.text-muted { color: #8a9a94; }
.fw-600 { font-weight: 600; }

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
@media (max-width: 992px) {
    .hero-stats { grid-template-columns: 1fr 1fr; }
    .filter-grid { flex-direction: column; }
    .filter-item.search-item { flex: unset; }
    .form-grid { grid-template-columns: 1fr; }
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
    .modal-lg .modal-container { max-width: 100%; margin: 10px; }
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
    } else {
        console.error('Modal not found:', id);
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

// Close modal on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay[style*="display: flex"]').forEach(modal => {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        });
    }
});

// ============================================
// CREATE
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
        const labels = { 'pengecekan_kehilangan': 'Pengecekan Kehilangan', 'kutipan_kedua': 'Kutipan Kedua', 'banjir_kepolisian': 'Banjir Kepolisian', 'keabsahan': 'Keabsahan', 'surat_pengantar': 'Surat Pengantar' };
        text.innerHTML = `Permohonan akan diteruskan ke petugas <strong>${labels[role] || role}</strong>`;
        info.style.display = 'block';
    } else if (info) {
        info.style.display = 'none';
    }
});

// ============================================
// EDIT
// ============================================
function openEditModal(id) {
    document.querySelectorAll('#editModal .form-error').forEach(el => {
        el.classList.remove('show');
        el.textContent = '';
    });
    fetch(`{{ url('loket/permohonan') }}/${id}/edit`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const p = data.data;
                document.getElementById('edit_pemohon_id').value = p.pemohon_id;
                document.getElementById('edit_judul_permohonan').value = p.judul_permohonan || '';
                document.getElementById('edit_keterangan').value = p.keterangan;
                document.getElementById('edit_jenis_layanan_id').value = p.jenis_layanan_id;
                document.getElementById('edit_status_permohonan_id').value = p.status_permohonan_id;
                document.getElementById('edit_prioritas').value = p.prioritas;
                document.getElementById('edit_catatan_loket').value = p.catatan_loket || '';
                document.getElementById('editForm').action = `{{ url('loket/permohonan') }}/${id}`;
                openModal('editModal');
            } else {
                showToast('Gagal memuat data', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            showToast('Terjadi kesalahan', 'error');
        });
}

document.getElementById('editForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const submitBtn = document.getElementById('editSubmit');
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
            closeModal('editModal');
            setTimeout(() => window.location.reload(), 500);
        } else {
            if (data.errors) {
                Object.keys(data.errors).forEach(key => {
                    const el = document.getElementById(`error-edit-${key}`);
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
        submitBtn.innerHTML = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg> Update`;
    });
});

// ============================================
// UPLOAD DOKUMEN - PERBAIKAN
// ============================================
let uploadPermohonanId = null;

function openUploadDokumenModal(id) {
    uploadPermohonanId = id;
    const form = document.getElementById('uploadDokumenForm');
    if (form) {
        form.reset();
        // Reset action URL
        form.action = `{{ url('loket/permohonan') }}/${id}/upload-dokumen`;
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
    
    // LOG UNTUK DEBUG
    console.log('Uploading to:', this.action);
    console.log('File:', file.name, file.size, file.type);
    
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

// DROP ZONE EVENTS - PERBAIKAN
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('upload_dokumen_file');
    const uploadText = document.getElementById('uploadText');
    const fileName = document.getElementById('uploadFileName');

    if (dropZone && fileInput) {
        // HAPUS EVENT LISTENER LAMA (jika ada)
        const newDropZone = dropZone.cloneNode(true);
        dropZone.parentNode.replaceChild(newDropZone, dropZone);
        
        // RE-ATTACH EVENT LISTENER
        const freshDropZone = document.getElementById('dropZone');
        const freshFileInput = document.getElementById('upload_dokumen_file');
        const freshUploadText = document.getElementById('uploadText');
        const freshFileName = document.getElementById('uploadFileName');

        if (freshDropZone && freshFileInput) {
            freshFileInput.addEventListener('change', function(e) {
                e.stopPropagation();
                if (this.files && this.files.length > 0) {
                    const file = this.files[0];
                    freshUploadText.textContent = '📄 File siap diupload';
                    freshFileName.textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
                    freshFileName.style.display = 'block';
                    freshDropZone.style.borderColor = '#07573c';
                    freshDropZone.style.background = '#f0f9f5';
                    freshDropZone.classList.add('drag-over');
                }
            });

            freshDropZone.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.style.borderColor = '#07573c';
                this.style.background = '#f0f9f5';
                this.classList.add('drag-over');
            });

            freshDropZone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                if (!this.contains(e.relatedTarget)) {
                    this.style.borderColor = '#dce2e0';
                    this.style.background = '#fafcfb';
                    this.classList.remove('drag-over');
                }
            });

            freshDropZone.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.style.borderColor = '#dce2e0';
                this.style.background = '#fafcfb';
                this.classList.remove('drag-over');
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    freshFileInput.files = files;
                    const file = files[0];
                    freshUploadText.textContent = '📄 File siap diupload';
                    freshFileName.textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
                    freshFileName.style.display = 'block';
                    this.style.borderColor = '#07573c';
                    this.style.background = '#f0f9f5';
                    this.classList.add('drag-over');
                    
                    // Trigger change event
                    const event = new Event('change', { bubbles: true });
                    freshFileInput.dispatchEvent(event);
                }
            });
        }
    }
});

// ============================================
// DELETE
// ============================================
let deletePermohonanId = null;

function openDeleteModal(id, nomor) {
    deletePermohonanId = id;
    document.getElementById('deleteNomor').textContent = nomor;
    document.getElementById('deleteForm').action = `{{ url('loket/permohonan') }}/${id}`;
    openModal('deleteModal');
}

document.getElementById('deleteForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const submitBtn = document.getElementById('deleteSubmit');
    submitBtn.disabled = true;
    submitBtn.innerHTML = 'Menghapus...';
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
            closeModal('deleteModal');
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
        submitBtn.innerHTML = 'Ya, Hapus';
    });
});

// ============================================
// DISTRIBUSI
// ============================================
let distribusiPermohonanId = null;

function openDistribusiModal(id) {
    distribusiPermohonanId = id;
    document.getElementById('distribusiForm').reset();
    document.getElementById('distribusiForm').action = `{{ url('loket/permohonan') }}/${id}/distribusikan`;
    document.getElementById('distribusi_submit').style.display = 'none';
    document.getElementById('distribusi_info').innerHTML = `
        <div class="distribusi-info">
            <div class="distribusi-info-item full-width" style="color:#f59e0b;font-weight:500;">
                ⏳ Mengecek ketersediaan petugas...
            </div>
        </div>
    `;
    openModal('distribusiModal');
    
    // Cek petugas tersedia
    fetch(`{{ url('loket/permohonan/get-petugas') }}?jenis_layanan_id=1`)
        .then(res => res.json())
        .then(data => {
            const info = document.getElementById('distribusi_info');
            if (data.success) {
                info.innerHTML = `
                    <div class="distribusi-info">
                        <div class="distribusi-info-item">
                            <label>Petugas Tujuan</label>
                            <p class="fw-600">${data.data.petugas}</p>
                        </div>
                        <div class="distribusi-info-item">
                            <label>Role</label>
                            <p class="fw-600">${data.data.role}</p>
                        </div>
                        <div class="distribusi-info-item full-width" style="color:#059669;font-weight:500;">
                            ✅ Petugas tersedia, permohonan akan diteruskan
                        </div>
                    </div>
                `;
                document.getElementById('distribusi_submit').style.display = 'inline-flex';
            } else {
                info.innerHTML = `
                    <div class="distribusi-info">
                        <div class="distribusi-info-item full-width" style="color:#dc2626;font-weight:500;">
                            ⚠️ ${data.message}
                        </div>
                    </div>
                `;
                document.getElementById('distribusi_submit').style.display = 'none';
            }
        })
        .catch(err => {
            document.getElementById('distribusi_info').innerHTML = `
                <div class="distribusi-info">
                    <div class="distribusi-info-item full-width" style="color:#dc2626;font-weight:500;">
                        ⚠️ Gagal mengecek ketersediaan petugas
                    </div>
                </div>
            `;
        });
}

document.getElementById('distribusiForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const submitBtn = document.getElementById('distribusi_submit');
    submitBtn.disabled = true;
    submitBtn.innerHTML = 'Meneruskan...';
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
            closeModal('distribusiModal');
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
        submitBtn.innerHTML = 'Teruskan Permohonan';
    });
});

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

console.log('✅ Permohonan module loaded successfully');
</script>
@endpush