@extends('layouts.app')

@section('title', 'Jenis Layanan - AKTALINK')
@section('page-title', 'Jenis Layanan')
@section('page-description', 'Kelola master data jenis layanan akta')

@section('page-actions')
    <button type="button" class="btn-pdf" onclick="openCreateModal()">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Tambah Layanan
    </button>
@endsection

@section('content')

{{-- FILTER --}}
<div class="filter-container">
    <form method="GET" action="{{ route('admin.jenis-layanan.index') }}" id="filterForm">
        <div class="filter-grid">
            <div class="filter-item search-item">
                <div class="search-wrapper">
                    <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" name="search" class="search-input" placeholder="Cari layanan..." value="{{ request('search') }}">
                    @if(request('search'))
                    <a href="{{ route('admin.jenis-layanan.index') }}" class="search-clear">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18"/>
                            <line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                    </a>
                    @endif
                </div>
            </div>

            <div class="filter-item">
                <select name="status_filter" class="filter-select">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('status_filter') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('status_filter') === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn-filter">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polygon points="22 3 2 3 10 13.46 10 19 14 21 14 13.46 22 3"/>
                    </svg>
                    Filter
                </button>
                <a href="{{ route('admin.jenis-layanan.index') }}" class="btn-reset">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23 4 23 10 17 10"/>
                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                    </svg>
                </a>
            </div>
        </div>

        @if(request()->anyFilled(['search', 'status_filter']))
        <div class="active-filters">
            <span class="active-filters-label">Filter aktif:</span>
            @if(request('search'))
            <span class="filter-tag">
                Pencarian: "{{ request('search') }}"
                <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="filter-tag-remove">×</a>
            </span>
            @endif
            @if(request('status_filter') !== null && request('status_filter') !== '')
            <span class="filter-tag">
                Status: {{ request('status_filter') == '1' ? 'Aktif' : 'Nonaktif' }}
                <a href="{{ request()->fullUrlWithQuery(['status_filter' => null]) }}" class="filter-tag-remove">×</a>
            </span>
            @endif
        </div>
        @endif
    </form>
</div>

{{-- TABLE --}}
<div class="table-container">
    <div class="table-toolbar">
        <div class="table-info">
            <span class="table-count">{{ $jenisLayanans->total() }}</span>
            <span class="table-label">layanan ditemukan</span>
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
                    <th class="col-nama">Nama Layanan</th>
                    <th class="col-kode">Kode</th>
                    <th class="col-role">Role Tujuan</th>
                    <th class="col-status">Status</th>
                    <th class="col-tanggal">Dibuat</th>
                    <th class="col-aksi">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jenisLayanans as $index => $layanan)
                <tr>
                    <td class="col-no">{{ $jenisLayanans->firstItem() + $index }}</td>
                    <td class="col-nama">
                        <div class="layanan-wrapper">
                            <span class="layanan-name">{{ $layanan->nama_layanan }}</span>
                            @if($layanan->deskripsi)
                            <span class="layanan-desc">{{ Str::limit($layanan->deskripsi, 50) }}</span>
                            @endif
                        </div>
                    </td>
                    <td class="col-kode">
                        <span class="kode-badge">{{ $layanan->kode_layanan }}</span>
                    </td>
                    <td class="col-role">
                        <span class="role-badge">
                            {{ $roleTujuan[$layanan->role_tujuan] ?? $layanan->role_tujuan }}
                        </span>
                    </td>
                    <td class="col-status">
                        <span class="status-indicator {{ $layanan->is_active ? 'status-active' : 'status-inactive' }}">
                            <span class="status-dot"></span>
                            {{ $layanan->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="col-tanggal">
                        <span class="tanggal-date">{{ $layanan->created_at->format('d M Y') }}</span>
                        <span class="tanggal-time">{{ $layanan->created_at->format('H:i') }}</span>
                    </td>
                    <td class="col-aksi">
                        <div class="action-group">
                            <button type="button" class="action-btn edit-btn" onclick="openEditModal({{ $layanan->id }})" title="Edit">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </button>
                            <button type="button" class="action-btn toggle-btn" onclick="openToggleModal({{ $layanan->id }}, '{{ $layanan->nama_layanan }}', {{ $layanan->is_active ? 'true' : 'false' }})" title="{{ $layanan->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    @if($layanan->is_active)
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                        <line x1="12" y1="9" x2="12" y2="15"/>
                                        <line x1="9" y1="12" x2="15" y2="12"/>
                                    @else
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                        <line x1="12" y1="9" x2="12" y2="15"/>
                                    @endif
                                </svg>
                            </button>
                            <button type="button" class="action-btn delete-btn" onclick="openDeleteModal({{ $layanan->id }}, '{{ $layanan->nama_layanan }}')" title="Hapus">
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
                    <td colspan="7">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#b0c4bc" stroke-width="1.5">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                                    <line x1="3" y1="9" x2="21" y2="9"/>
                                    <line x1="3" y1="15" x2="21" y2="15"/>
                                </svg>
                            </div>
                            <h4>Belum ada jenis layanan</h4>
                            <p>Tambahkan jenis layanan baru untuk mulai mengelola permohonan</p>
                            <button type="button" class="btn-pdf mt-3" onclick="openCreateModal()">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="12" y1="5" x2="12" y2="19"/>
                                    <line x1="5" y1="12" x2="19" y2="12"/>
                                </svg>
                                Tambah Layanan
                            </button>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    @if($jenisLayanans->hasPages())
    <div class="table-footer">
        <div class="pagination-info">
            Menampilkan <strong>{{ $jenisLayanans->firstItem() ?? 0 }}</strong> - <strong>{{ $jenisLayanans->lastItem() ?? 0 }}</strong>
            dari <strong>{{ $jenisLayanans->total() }}</strong> data
        </div>
        <nav class="pagination-nav">
            @if($jenisLayanans->onFirstPage())
                <span class="page-btn disabled">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6"/>
                    </svg>
                </span>
            @else
                <a href="{{ $jenisLayanans->previousPageUrl() }}" class="page-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6"/>
                    </svg>
                </a>
            @endif

            <div class="page-numbers">
                @php
                    $current = $jenisLayanans->currentPage();
                    $last = $jenisLayanans->lastPage();
                    $start = max(1, $current - 2);
                    $end = min($last, $current + 2);
                @endphp

                @if($start > 1)
                    <a href="{{ $jenisLayanans->url(1) }}" class="page-num">1</a>
                    @if($start > 2)
                        <span class="page-dots">…</span>
                    @endif
                @endif

                @for($i = $start; $i <= $end; $i++)
                    @if($i == $current)
                        <span class="page-num active">{{ $i }}</span>
                    @else
                        <a href="{{ $jenisLayanans->url($i) }}" class="page-num">{{ $i }}</a>
                    @endif
                @endfor

                @if($end < $last)
                    @if($end < $last - 1)
                        <span class="page-dots">…</span>
                    @endif
                    <a href="{{ $jenisLayanans->url($last) }}" class="page-num">{{ $last }}</a>
                @endif
            </div>

            @if($jenisLayanans->hasMorePages())
                <a href="{{ $jenisLayanans->nextPageUrl() }}" class="page-btn">
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
                <h4 class="modal-title">Tambah Jenis Layanan</h4>
                <button type="button" class="modal-close" onclick="closeModal('createModal')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            <form id="createForm" method="POST" action="{{ route('admin.jenis-layanan.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label class="form-label">Nama Layanan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_layanan" class="form-input" placeholder="Contoh: Pengecekan Kehilangan" required>
                            <span class="form-error" id="error-nama_layanan"></span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Kode Layanan <span class="text-danger">*</span></label>
                            <input type="text" name="kode_layanan" class="form-input" placeholder="Contoh: PENGECEKAN_KEHILANGAN" required>
                            <small class="form-hint">Gunakan huruf kapital dan underscore (_)</small>
                            <span class="form-error" id="error-kode_layanan"></span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Role Tujuan <span class="text-danger">*</span></label>
                            <select name="role_tujuan" class="form-select" required>
                                <option value="">-- Pilih Role --</option>
                                @foreach($roleTujuan as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <span class="form-error" id="error-role_tujuan"></span>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-textarea" rows="3" placeholder="Deskripsi layanan"></textarea>
                            <span class="form-error" id="error-deskripsi"></span>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label checkbox-label">
                                <input type="checkbox" name="is_active" value="1" checked>
                                <span class="checkbox-text">Aktif</span>
                            </label>
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
                <h4 class="modal-title">Edit Jenis Layanan</h4>
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
                            <label class="form-label">Nama Layanan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_layanan" id="edit_nama_layanan" class="form-input" required>
                            <span class="form-error" id="edit-error-nama_layanan"></span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Kode Layanan <span class="text-danger">*</span></label>
                            <input type="text" name="kode_layanan" id="edit_kode_layanan" class="form-input" required>
                            <small class="form-hint">Gunakan huruf kapital dan underscore (_)</small>
                            <span class="form-error" id="edit-error-kode_layanan"></span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Role Tujuan <span class="text-danger">*</span></label>
                            <select name="role_tujuan" id="edit_role_tujuan" class="form-select" required>
                                @foreach($roleTujuan as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <span class="form-error" id="edit-error-role_tujuan"></span>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="edit_deskripsi" class="form-textarea" rows="3"></textarea>
                            <span class="form-error" id="edit-error-deskripsi"></span>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label checkbox-label">
                                <input type="checkbox" name="is_active" id="edit_is_active" value="1">
                                <span class="checkbox-text">Aktif</span>
                            </label>
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

{{-- TOGGLE MODAL --}}
<div class="modal-overlay" id="toggleModal" style="display: none;">
    <div class="modal-container">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-header-icon" style="background: #fef3c7; color: #92400e;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        <line x1="12" y1="9" x2="12" y2="15"/>
                    </svg>
                </div>
                <h4 class="modal-title" id="toggleModalTitle">Konfirmasi Status</h4>
                <button type="button" class="modal-close" onclick="closeModal('toggleModal')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="delete-info text-center">
                    <p id="toggleMessage">Apakah Anda yakin ingin <strong>menonaktifkan</strong> layanan <strong id="toggleLayananName"></strong>?</p>
                    <p class="text-muted small mt-2">⚠️ Layanan yang dinonaktifkan tidak akan muncul di pilihan permohonan.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('toggleModal')">Batal</button>
                <button type="button" class="btn-primary" id="toggleConfirmBtn" onclick="confirmToggle()">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"/>
                        <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"/>
                    </svg>
                    Konfirmasi
                </button>
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
                    <p>Apakah Anda yakin ingin menghapus layanan <strong id="deleteLayananName"></strong>?</p>
                    <p class="text-muted small mt-2">⚠️ Tindakan ini tidak dapat dibatalkan.</p>
                    <p class="text-muted small" id="deleteWarning">Data yang terkait dengan layanan ini akan terpengaruh.</p>
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
   STYLE KONSISTEN DENGAN PERMOHONAN
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

.col-no { width: 44px; text-align: center; color: #b0c4bc; font-weight: 500; }
.col-nama { min-width: 180px; }
.col-kode { min-width: 120px; }
.col-role { min-width: 150px; }
.col-status { min-width: 100px; }
.col-tanggal { min-width: 110px; }
.col-aksi { width: 120px; text-align: center; }

.layanan-wrapper {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.layanan-name {
    font-weight: 600;
    color: #1d2b27;
    font-size: 14px;
}

.layanan-desc {
    font-size: 12px;
    color: #8a9a94;
}

.kode-badge {
    display: inline-block;
    padding: 3px 12px;
    background: #f0f5f2;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    color: #4a5a54;
    font-family: monospace;
    letter-spacing: 0.04em;
}

.role-badge {
    display: inline-block;
    padding: 3px 12px;
    background: #eef6ff;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    color: #2563eb;
}

.status-indicator {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 4px 14px 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.status-active {
    background: #d1fae520;
    color: #059669;
}

.status-inactive {
    background: #fde8e840;
    color: #6b7280;
}

.status-indicator .status-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    display: inline-block;
    background: currentColor;
}

.tanggal-date {
    display: block;
    font-weight: 600;
    color: #1d2b27;
}

.tanggal-time {
    font-size: 12px;
    color: #8a9a94;
}

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
.edit-btn:hover { background: #fef3c7; color: #92400e; }
.toggle-btn:hover { background: #fef3c7; color: #92400e; }
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

.mt-3 { margin-top: 16px; }

/* MODAL */
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
    min-height: 80px;
}

.form-hint {
    font-size: 11px;
    color: #8a9a94;
}

.form-error {
    font-size: 12px;
    color: #dc2626;
    display: none;
}

.form-error.show {
    display: block;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    font-weight: 500;
}

.checkbox-label input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: #07573c;
    cursor: pointer;
}

.text-danger { color: #dc2626; }
.text-muted { color: #8a9a94; }
.small { font-size: 12px; }
.text-center { text-align: center; }
.mt-2 { margin-top: 8px; }

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

/* RESPONSIVE */
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
    .form-grid { grid-template-columns: 1fr; }
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
    .col-no, .col-nama, .col-kode, .col-role, .col-status, .col-tanggal, .col-aksi {
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
    const form = document.getElementById('createForm');
    if (form) form.reset();

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

            fetch('{{ route("admin.jenis-layanan.store") }}', {
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
        form.action = `{{ route('admin.jenis-layanan.index') }}/${id}`;
    }

    fetch(`{{ route('admin.jenis-layanan.index') }}/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const layanan = data.data;
                document.getElementById('edit_nama_layanan').value = layanan.nama_layanan;
                document.getElementById('edit_kode_layanan').value = layanan.kode_layanan;
                document.getElementById('edit_role_tujuan').value = layanan.role_tujuan;
                document.getElementById('edit_deskripsi').value = layanan.deskripsi || '';
                document.getElementById('edit_is_active').checked = layanan.is_active;
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
// TOGGLE STATUS - DENGAN MODAL
// ============================================
let toggleData = { id: null, nama: null, currentStatus: null };

function openToggleModal(id, nama, currentStatus) {
    toggleData.id = id;
    toggleData.nama = nama;
    toggleData.currentStatus = currentStatus;

    const action = currentStatus ? 'menonaktifkan' : 'mengaktifkan';
    const statusLabel = currentStatus ? 'Nonaktifkan' : 'Aktifkan';

    document.getElementById('toggleModalTitle').textContent = `Konfirmasi ${statusLabel}`;
    document.getElementById('toggleLayananName').textContent = nama;
    document.getElementById('toggleMessage').innerHTML = `
        Apakah Anda yakin ingin <strong>${action}</strong> layanan <strong>${nama}</strong>?
    `;

    openModal('toggleModal');
}

function confirmToggle() {
    if (!toggleData.id) return;

    const btn = document.getElementById('toggleConfirmBtn');
    btn.disabled = true;
    btn.innerHTML = 'Memproses...';

    const action = toggleData.currentStatus ? 'nonaktifkan' : 'aktifkan';

    fetch(`{{ route('admin.jenis-layanan.index') }}/${toggleData.id}/toggle`, {
        method: 'PATCH',
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
            closeModal('toggleModal');
            setTimeout(() => window.location.reload(), 500);
        } else {
            showToast(data.message || 'Gagal mengubah status', 'error');
            closeModal('toggleModal');
        }
    })
    .catch(error => {
        showToast('Terjadi kesalahan pada server', 'error');
        closeModal('toggleModal');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = `
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"/>
                <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"/>
            </svg>
            Konfirmasi
        `;
        toggleData = { id: null, nama: null, currentStatus: null };
    });
}

// ============================================
// DELETE - DENGAN MODAL
// ============================================
function openDeleteModal(id, nama) {
    document.getElementById('deleteLayananName').textContent = nama;
    const form = document.getElementById('deleteForm');
    if (form) {
        form.action = `{{ route('admin.jenis-layanan.index') }}/${id}`;
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