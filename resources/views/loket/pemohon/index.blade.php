@extends('layouts.loket')

@section('title', 'Data Pemohon - AKTALINK')
@section('page-title', 'Data Pemohon')
@section('page-description', 'Kelola data pemohon layanan akta')

@section('page-actions')
    <button type="button" class="btn-pdf" onclick="openCreateModal()">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Tambah Pemohon
    </button>
    <button type="button" class="btn-pdf" onclick="exportPdf()">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <line x1="12" y1="18" x2="12" y2="12"/>
            <polyline points="9 15 12 18 15 15"/>
        </svg>
        Export PDF
    </button>
@endsection

@section('content')

{{-- ============================================
    FILTER & SEARCH
============================================ --}}
<div class="filter-container">
    <form method="GET" action="{{ route('loket.pemohon.index') }}" id="filterForm">
        <div class="filter-grid">
            <div class="filter-item search-item">
                <div class="search-wrapper">
                    <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" name="search" class="search-input" placeholder="Cari NIK, nama, alamat..." value="{{ request('search') }}">
                    @if(request('search'))
                    <a href="{{ route('loket.pemohon.index') }}" class="search-clear">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18"/>
                            <line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                    </a>
                    @endif
                </div>
            </div>

            <div class="filter-item">
                <select name="jenis_kelamin" class="filter-select">
                    <option value="">Semua Jenis Kelamin</option>
                    <option value="L" {{ request('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ request('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn-filter">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polygon points="22 3 2 3 10 13.46 10 19 14 21 14 13.46 22 3"/>
                    </svg>
                    Filter
                </button>
                <a href="{{ route('loket.pemohon.index') }}" class="btn-reset">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23 4 23 10 17 10"/>
                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                    </svg>
                </a>
            </div>
        </div>

        @if(request()->anyFilled(['search', 'jenis_kelamin']))
        <div class="active-filters">
            <span class="active-filters-label">Filter aktif:</span>
            @if(request('search'))
            <span class="filter-tag">
                Pencarian: "{{ request('search') }}"
                <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="filter-tag-remove">×</a>
            </span>
            @endif
            @if(request('jenis_kelamin'))
            <span class="filter-tag">
                Jenis Kelamin: {{ request('jenis_kelamin') == 'L' ? 'Laki-laki' : 'Perempuan' }}
                <a href="{{ request()->fullUrlWithQuery(['jenis_kelamin' => null]) }}" class="filter-tag-remove">×</a>
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
            <span class="table-count">{{ $pemohons->total() }}</span>
            <span class="table-label">pemohon ditemukan</span>
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
                    <th class="col-nama">Nama Lengkap</th>
                    <th class="col-nik">NIK</th>
                    <th class="col-kelamin">Jenis Kelamin</th>
                    <th class="col-tempat">Tempat Lahir</th>
                    <th class="col-tanggal">Tanggal Lahir</th>
                    <th class="col-hp">No. HP</th>
                    <th class="col-aksi">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pemohons as $index => $pemohon)
                <tr>
                    <td class="col-no">{{ $pemohons->firstItem() + $index }}</td>
                    <td class="col-nama">
                        <div class="pemohon-wrapper">
                            <div class="pemohon-avatar">
                                {{ Str::substr($pemohon->nama_lengkap, 0, 2) }}
                            </div>
                            <span class="pemohon-name">{{ $pemohon->nama_lengkap }}</span>
                        </div>
                    </td>
                    <td class="col-nik">
                        <span class="nik-badge">{{ $pemohon->nik }}</span>
                    </td>
                    <td class="col-kelamin">
                        <span class="gender-badge {{ $pemohon->jenis_kelamin == 'L' ? 'gender-male' : ($pemohon->jenis_kelamin == 'P' ? 'gender-female' : 'gender-unknown') }}">
                            {{ $pemohon->jenis_kelamin_label }}
                        </span>
                    </td>
                    <td class="col-tempat">
                        {{ $pemohon->tempat_lahir ?? '-' }}
                    </td>
                    <td class="col-tanggal">
                        @if($pemohon->tanggal_lahir)
                            <span class="tanggal-date">{{ $pemohon->tanggal_lahir->format('d M Y') }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="col-hp">
                        {{ $pemohon->nomor_hp ?? '-' }}
                    </td>
                    <td class="col-aksi">
                        <div class="action-group">
                            <button type="button" class="action-btn view-btn" onclick="openDetailModal({{ $pemohon->id }})" title="Detail">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                            <button type="button" class="action-btn edit-btn" onclick="openEditModal({{ $pemohon->id }})" title="Edit">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </button>
                            <button type="button" class="action-btn delete-btn" onclick="openDeleteModal({{ $pemohon->id }}, '{{ $pemohon->nama_lengkap }}')" title="Hapus">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
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
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                            </div>
                            <h4>Belum ada data pemohon</h4>
                            <p>Tambahkan pemohon baru untuk mulai mengelola data</p>
                            <button type="button" class="btn-pdf mt-3" onclick="openCreateModal()">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="12" y1="5" x2="12" y2="19"/>
                                    <line x1="5" y1="12" x2="19" y2="12"/>
                                </svg>
                                Tambah Pemohon
                            </button>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    @if($pemohons->hasPages())
    <div class="table-footer">
        <div class="pagination-info">
            Menampilkan <strong>{{ $pemohons->firstItem() ?? 0 }}</strong> - <strong>{{ $pemohons->lastItem() ?? 0 }}</strong>
            dari <strong>{{ $pemohons->total() }}</strong> data
        </div>
        <nav class="pagination-nav">
            @if($pemohons->onFirstPage())
                <span class="page-btn disabled">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6"/>
                    </svg>
                </span>
            @else
                <a href="{{ $pemohons->previousPageUrl() }}" class="page-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6"/>
                    </svg>
                </a>
            @endif

            <div class="page-numbers">
                @php
                    $current = $pemohons->currentPage();
                    $last = $pemohons->lastPage();
                    $start = max(1, $current - 2);
                    $end = min($last, $current + 2);
                @endphp

                @if($start > 1)
                    <a href="{{ $pemohons->url(1) }}" class="page-num">1</a>
                    @if($start > 2)
                        <span class="page-dots">…</span>
                    @endif
                @endif

                @for($i = $start; $i <= $end; $i++)
                    @if($i == $current)
                        <span class="page-num active">{{ $i }}</span>
                    @else
                        <a href="{{ $pemohons->url($i) }}" class="page-num">{{ $i }}</a>
                    @endif
                @endfor

                @if($end < $last)
                    @if($end < $last - 1)
                        <span class="page-dots">…</span>
                    @endif
                    <a href="{{ $pemohons->url($last) }}" class="page-num">{{ $last }}</a>
                @endif
            </div>

            @if($pemohons->hasMorePages())
                <a href="{{ $pemohons->nextPageUrl() }}" class="page-btn">
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

{{-- Form untuk PDF --}}
<form id="pdfForm" action="{{ route('loket.pemohon.pdf') }}" method="GET" style="display: none;">
    @foreach(request()->all() as $key => $value)
        @if(!in_array($key, ['page']))
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endif
    @endforeach
</form>

{{-- ============================================
    MODALS
============================================ --}}

{{-- CREATE MODAL --}}
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
                <h4 class="modal-title">Tambah Pemohon</h4>
                <button type="button" class="modal-close" onclick="closeModal('createModal')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            <form id="createForm" method="POST" action="{{ route('loket.pemohon.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label class="form-label">NIK <span class="text-danger">*</span></label>
                            <input type="text" name="nik" class="form-input" placeholder="16 digit NIK" maxlength="16" required>
                            <span class="form-error" id="error-nik"></span>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" class="form-input" placeholder="Masukkan nama lengkap" required>
                            <span class="form-error" id="error-nama_lengkap"></span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-input" placeholder="Kota lahir">
                            <span class="form-error" id="error-tempat_lahir"></span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-input">
                            <span class="form-error" id="error-tanggal_lahir"></span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select">
                                <option value="">-- Pilih --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            <span class="form-error" id="error-jenis_kelamin"></span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nomor HP</label>
                            <input type="text" name="nomor_hp" class="form-input" placeholder="Contoh: 08123456789">
                            <span class="form-error" id="error-nomor_hp"></span>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-textarea" rows="2" placeholder="Alamat lengkap"></textarea>
                            <span class="form-error" id="error-alamat"></span>
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

{{-- EDIT MODAL --}}
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
                <h4 class="modal-title">Edit Pemohon</h4>
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
                            <label class="form-label">NIK <span class="text-danger">*</span></label>
                            <input type="text" name="nik" id="edit_nik" class="form-input" maxlength="16" required>
                            <span class="form-error" id="edit-error-nik"></span>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" id="edit_nama_lengkap" class="form-input" required>
                            <span class="form-error" id="edit-error-nama_lengkap"></span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" id="edit_tempat_lahir" class="form-input">
                            <span class="form-error" id="edit-error-tempat_lahir"></span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="edit_tanggal_lahir" class="form-input">
                            <span class="form-error" id="edit-error-tanggal_lahir"></span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="edit_jenis_kelamin" class="form-select">
                                <option value="">-- Pilih --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            <span class="form-error" id="edit-error-jenis_kelamin"></span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nomor HP</label>
                            <input type="text" name="nomor_hp" id="edit_nomor_hp" class="form-input">
                            <span class="form-error" id="edit-error-nomor_hp"></span>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" id="edit_alamat" class="form-textarea" rows="2"></textarea>
                            <span class="form-error" id="edit-error-alamat"></span>
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

{{-- DETAIL MODAL --}}
<div class="modal-overlay" id="detailModal" style="display: none;">
    <div class="modal-container">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-header-icon" style="background: #dbeafe; color: #2563eb;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <h4 class="modal-title">Detail Pemohon</h4>
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

{{-- DELETE MODAL --}}
<div class="modal-overlay" id="deleteModal" style="display: none;">
    <div class="modal-container">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-header-icon" style="background: #fde8e8; color: #b91c1c;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                    </svg>
                </div>
                <h4 class="modal-title">Konfirmasi Hapus</h4>
                <button type="button" class="modal-close" onclick="closeModal('deleteModal')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="delete-info text-center">
                    <p>Apakah Anda yakin ingin menghapus pemohon <strong id="deletePemohonName"></strong>?</p>
                    <p class="text-muted small mt-2">⚠️ Tindakan ini tidak dapat dibatalkan.</p>
                    <p class="text-muted small">Data yang terkait dengan pemohon ini akan terpengaruh.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('deleteModal')">Batal</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger">
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

{{-- TOAST NOTIFICATION --}}
<div id="toastContainer" style="position: fixed; top: 20px; right: 20px; z-index: 99999; display: flex; flex-direction: column; gap: 8px;"></div>

@endsection

@push('styles')
<style>
/* ============================================
   PEMOHON STYLES
============================================ */
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

.pemohon-name {
    font-weight: 600;
    color: #1d2b27;
    font-size: 14px;
}

.nik-badge {
    display: inline-block;
    padding: 3px 12px;
    background: #f0f5f2;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
    color: #4a5a54;
    font-family: monospace;
    letter-spacing: 0.04em;
}

.gender-badge {
    display: inline-block;
    padding: 3px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

.gender-male {
    background: #dbeafe;
    color: #2563eb;
}

.gender-female {
    background: #fce7f3;
    color: #db2777;
}

.gender-unknown {
    background: #f3f4f6;
    color: #6b7280;
}

.col-nama { min-width: 180px; }
.col-nik { min-width: 140px; }
.col-kelamin { min-width: 100px; }
.col-tempat { min-width: 120px; }
.col-tanggal { min-width: 110px; }
.col-hp { min-width: 120px; }
.col-aksi { min-width: 120px; text-align: center; }

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

/* ============================================
   HERO STATS
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
   TABLE
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
.edit-btn:hover { background: #fef3c7; color: #92400e; }
.delete-btn:hover { background: #fde8e8; color: #b91c1c; }

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

.mt-3 { margin-top: 16px; }
.text-muted { color: #8a9a94; }

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
    max-width: 480px;
    max-height: 90vh;
    animation: modalSlideUp 0.3s ease;
}

.modal-lg .modal-container { max-width: 580px; }

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

/* FORM */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-label {
    font-size: 13px;
    font-weight: 600;
    color: #1d2b27;
}

.form-input,
.form-select,
.form-textarea {
    padding: 10px 14px;
    border: 1px solid #e9ecef;
    border-radius: 10px;
    font-size: 13px;
    font-family: inherit;
    transition: all 0.3s ease;
    background: #fafcfb;
    color: #1d2b27;
    width: 100%;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: #07573c;
    background: white;
    box-shadow: 0 0 0 4px rgba(7, 87, 60, 0.08);
}

.form-textarea {
    resize: vertical;
    min-height: 60px;
}

.form-error {
    font-size: 12px;
    color: #dc2626;
    display: none;
}

.form-error.show {
    display: block;
}

.text-danger { color: #dc2626; }

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

.btn-primary {
    background: #07573c;
    color: white;
    border: 1px solid #07573c;
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

.btn-primary:hover {
    background: #043d2a;
    border-color: #043d2a;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(7, 87, 60, 0.25);
}

.btn-danger {
    background: #dc2626;
    color: white;
    border: 1px solid #dc2626;
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

.btn-danger:hover {
    background: #b91c1c;
    border-color: #b91c1c;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);
}

/* DETAIL MODAL */
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
    gap: 16px;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
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
    padding: 12px 0 20px;
    border-bottom: 1px solid #f0f2f1;
    margin-bottom: 16px;
}

.detail-profile-avatar {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: linear-gradient(135deg, #e8f0ed, #c5d9d0);
    color: #07573c;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    font-weight: 700;
    margin: 0 auto 10px;
}

.detail-profile-name {
    font-size: 18px;
    font-weight: 700;
    color: #1d2b27;
}

.detail-profile-nik {
    font-size: 13px;
    color: #8a9a94;
}

/* TOAST */
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
    .filter-actions { justify-content: flex-end; }
    .form-grid { grid-template-columns: 1fr; }
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
    .modal-lg .modal-container {
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
    .col-aksi .action-group {
        gap: 2px;
    }
    .col-aksi .action-btn {
        width: 28px;
        height: 28px;
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
    .col-no, .col-nama, .col-nik, .col-kelamin, .col-tempat, .col-tanggal, .col-hp, .col-aksi {
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
// EXPORT PDF
// ============================================
function exportPdf() {
    document.getElementById('pdfForm').submit();
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
    document.querySelectorAll(`#${id} .form-error`).forEach(el => {
        el.classList.remove('show');
        el.textContent = '';
    });
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
// CREATE
// ============================================
function openCreateModal() {
    document.getElementById('createForm').reset();
    document.querySelectorAll('#createModal .form-error').forEach(el => {
        el.classList.remove('show');
        el.textContent = '';
    });
    openModal('createModal');
}

document.addEventListener('DOMContentLoaded', function() {
    const createForm = document.getElementById('createForm');
    if (createForm) {
        createForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = document.getElementById('createSubmit');
            if (!submitBtn) return;

            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Menyimpan...';

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    closeModal('createModal');
                    setTimeout(() => window.location.reload(), 500);
                } else {
                    if (data.errors) {
                        Object.keys(data.errors).forEach(key => {
                            const errorEl = document.getElementById(`error-${key}`);
                            if (errorEl) {
                                errorEl.textContent = data.errors[key][0];
                                errorEl.classList.add('show');
                            }
                        });
                        showToast('Silakan perbaiki form yang salah', 'error');
                    } else {
                        showToast(data.message || 'Terjadi kesalahan', 'error');
                    }
                }
            })
            .catch(error => {
                showToast('Terjadi kesalahan pada server', 'error');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = `
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Simpan
                `;
            });
        });
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

    const form = document.getElementById('editForm');
    if (form) {
        form.action = `{{ route('loket.pemohon.index') }}/${id}`;
    }

    fetch(`{{ route('loket.pemohon.index') }}/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const p = data.data;
                document.getElementById('edit_nik').value = p.nik;
                document.getElementById('edit_nama_lengkap').value = p.nama_lengkap;
                document.getElementById('edit_tempat_lahir').value = p.tempat_lahir || '';
                document.getElementById('edit_tanggal_lahir').value = p.tanggal_lahir || '';
                document.getElementById('edit_jenis_kelamin').value = p.jenis_kelamin || '';
                document.getElementById('edit_nomor_hp').value = p.nomor_hp || '';
                document.getElementById('edit_alamat').value = p.alamat || '';
                openModal('editModal');
            } else {
                showToast('Gagal memuat data', 'error');
            }
        })
        .catch(() => showToast('Terjadi kesalahan', 'error'));
}

document.addEventListener('DOMContentLoaded', function() {
    const editForm = document.getElementById('editForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = document.getElementById('editSubmit');
            if (!submitBtn) return;

            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Menyimpan...';

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    closeModal('editModal');
                    setTimeout(() => window.location.reload(), 500);
                } else {
                    if (data.errors) {
                        Object.keys(data.errors).forEach(key => {
                            const errorEl = document.getElementById(`edit-error-${key}`);
                            if (errorEl) {
                                errorEl.textContent = data.errors[key][0];
                                errorEl.classList.add('show');
                            }
                        });
                        showToast('Silakan perbaiki form yang salah', 'error');
                    } else {
                        showToast(data.message || 'Terjadi kesalahan', 'error');
                    }
                }
            })
            .catch(error => {
                showToast('Terjadi kesalahan pada server', 'error');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = `
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Update
                `;
            });
        });
    }
});

// ============================================
// DETAIL
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

    fetch(`{{ route('loket.pemohon.index') }}/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const p = data.data;
                const genderLabel = p.jenis_kelamin === 'L' ? 'Laki-laki' : (p.jenis_kelamin === 'P' ? 'Perempuan' : '-');

                content.innerHTML = `
                    <div class="detail-profile">
                        <div class="detail-profile-avatar">${p.nama_lengkap.substring(0, 2).toUpperCase()}</div>
                        <div class="detail-profile-name">${p.nama_lengkap}</div>
                        <div class="detail-profile-nik">NIK: ${p.nik}</div>
                    </div>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <label>Tempat Lahir</label>
                            <div class="detail-value ${!p.tempat_lahir ? 'empty' : ''}">${p.tempat_lahir || '-'}</div>
                        </div>
                        <div class="detail-item">
                            <label>Tanggal Lahir</label>
                            <div class="detail-value ${!p.tanggal_lahir ? 'empty' : ''}">${p.tanggal_lahir ? new Date(p.tanggal_lahir).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : '-'}</div>
                        </div>
                        <div class="detail-item">
                            <label>Jenis Kelamin</label>
                            <div class="detail-value">${genderLabel}</div>
                        </div>
                        <div class="detail-item">
                            <label>Nomor HP</label>
                            <div class="detail-value ${!p.nomor_hp ? 'empty' : ''}">${p.nomor_hp || '-'}</div>
                        </div>
                        <div class="detail-item full-width">
                            <label>Alamat</label>
                            <div class="detail-value ${!p.alamat ? 'empty' : ''}">${p.alamat || '-'}</div>
                        </div>
                        <div class="detail-item full-width">
                            <label>Tanggal Terdaftar</label>
                            <div class="detail-value">${new Date(p.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' })}</div>
                        </div>
                    </div>
                `;

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
// DELETE
// ============================================
function openDeleteModal(id, name) {
    document.getElementById('deletePemohonName').textContent = name;
    const form = document.getElementById('deleteForm');
    if (form) {
        form.action = `{{ route('loket.pemohon.index') }}/${id}`;
    }
    openModal('deleteModal');
}

document.addEventListener('DOMContentLoaded', function() {
    const deleteForm = document.getElementById('deleteForm');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = this.querySelector('.btn-danger');
            if (!submitBtn) return;

            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Menghapus...';

            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: new FormData(this)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    closeModal('deleteModal');
                    setTimeout(() => window.location.reload(), 500);
                } else {
                    showToast(data.message || 'Gagal menghapus data', 'error');
                    closeModal('deleteModal');
                }
            })
            .catch(error => {
                showToast('Terjadi kesalahan pada server', 'error');
                closeModal('deleteModal');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = `
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                    </svg>
                    Ya, Hapus
                `;
            });
        });
    }
});

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
</script>
@endpush