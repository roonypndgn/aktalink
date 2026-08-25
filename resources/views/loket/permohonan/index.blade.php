{{-- resources/views/loket/permohonan/index.blade.php --}}

@extends('layouts.loket')

@section('title', 'Semua Permohonan - AKTALINK')
@section('page-title', '📋 Semua Permohonan')
@section('page-description', 'Kelola dan pantau semua permohonan layanan akta')

@section('page-actions')
    <button type="button" class="btn-pdf" onclick="openCreateModal()">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Tambah Permohonan
    </button>
    <button type="button" class="btn-outline" onclick="window.print()">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="6 9 6 2 18 2 18 9"/>
            <path d="M18 9H6M18 9a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-4a2 2 0 0 1 2-2"/>
            <rect x="8" y="14" width="8" height="6" rx="1"/>
        </svg>
    </button>
@endsection

@section('content')

{{-- ============================================
    HERO STATISTICS
============================================ --}}
<div class="hero-stats">
    <div class="hero-stat">
        <div class="hero-stat-icon" style="background: linear-gradient(135deg, #07573c, #0d8a5a);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/>
                <line x1="16" y1="17" x2="8" y2="17"/>
            </svg>
        </div>
        <div class="hero-stat-content">
            <span class="hero-stat-value">{{ number_format($stats['total']) }}</span>
            <span class="hero-stat-label">Total Permohonan</span>
        </div>
        <div class="hero-stat-trend up">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                <polyline points="17 6 23 6 23 12"/>
            </svg>
            100%
        </div>
    </div>

    <div class="hero-stat">
        <div class="hero-stat-icon" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
            </svg>
        </div>
        <div class="hero-stat-content">
            <span class="hero-stat-value">{{ number_format($stats['menunggu']) }}</span>
            <span class="hero-stat-label">Menunggu</span>
        </div>
        <div class="hero-stat-trend neutral">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            {{ $stats['total'] > 0 ? round(($stats['menunggu'] / $stats['total']) * 100) : 0 }}%
        </div>
    </div>

    <div class="hero-stat">
        <div class="hero-stat-icon" style="background: linear-gradient(135deg, #3b82f6, #60a5fa);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
            </svg>
        </div>
        <div class="hero-stat-content">
            <span class="hero-stat-value">{{ number_format($stats['proses']) }}</span>
            <span class="hero-stat-label">Diproses</span>
        </div>
        <div class="hero-stat-trend neutral">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            {{ $stats['total'] > 0 ? round(($stats['proses'] / $stats['total']) * 100) : 0 }}%
        </div>
    </div>

    <div class="hero-stat">
        <div class="hero-stat-icon" style="background: linear-gradient(135deg, #059669, #34d399);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
        </div>
        <div class="hero-stat-content">
            <span class="hero-stat-value">{{ number_format($stats['selesai']) }}</span>
            <span class="hero-stat-label">Selesai</span>
        </div>
        <div class="hero-stat-trend up">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                <polyline points="17 6 23 6 23 12"/>
            </svg>
            {{ $stats['total'] > 0 ? round(($stats['selesai'] / $stats['total']) * 100) : 0 }}%
        </div>
    </div>
</div>

{{-- ============================================
    FILTER & SEARCH
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

        @if(request()->anyFilled(['search', 'status', 'jenis_layanan', 'prioritas']))
        <div class="active-filters">
            <span class="active-filters-label">Filter aktif:</span>
            @if(request('search'))
            <span class="filter-tag">
                Pencarian: "{{ request('search') }}"
                <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="filter-tag-remove">×</a>
            </span>
            @endif
            @if(request('status'))
            <span class="filter-tag">
                Status: {{ $statuses->firstWhere('id', request('status'))->nama_status ?? '' }}
                <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}" class="filter-tag-remove">×</a>
            </span>
            @endif
            @if(request('jenis_layanan'))
            <span class="filter-tag">
                Layanan: {{ $layanans->firstWhere('id', request('jenis_layanan'))->nama_layanan ?? '' }}
                <a href="{{ request()->fullUrlWithQuery(['jenis_layanan' => null]) }}" class="filter-tag-remove">×</a>
            </span>
            @endif
            @if(request('prioritas'))
            <span class="filter-tag">
                Prioritas: {{ ucfirst(request('prioritas')) }}
                <a href="{{ request()->fullUrlWithQuery(['prioritas' => null]) }}" class="filter-tag-remove">×</a>
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
            <span class="table-count">{{ $permohonans->total() }}</span>
            <span class="table-label">permohonan ditemukan</span>
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
                    <th class="col-nomor">Nomor</th>
                    <th class="col-pemohon">Pemohon</th>
                    <th class="col-layanan">Layanan</th>
                    <th class="col-status">Status</th>
                    <th class="col-prioritas">Prioritas</th>
                    <th class="col-tanggal">Tanggal</th>
                    <th class="col-aksi">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($permohonans as $index => $permohonan)
                <tr>
                    <td class="col-no">{{ $permohonans->firstItem() + $index }}</td>
                    <td class="col-nomor">
                        <div class="nomor-wrapper">
                            <span class="nomor-number">{{ $permohonan->nomor_permohonan }}</span>
                            <span class="nomor-title">{{ Str::limit($permohonan->judul_permohonan ?? 'Tanpa judul', 30) }}</span>
                        </div>
                    </td>
                    <td class="col-pemohon">
                        <div class="pemohon-wrapper">
                            <div class="pemohon-avatar">
                                {{ Str::substr($permohonan->pemohon->nama_lengkap, 0, 2) }}
                            </div>
                            <span class="pemohon-name">{{ $permohonan->pemohon->nama_lengkap }}</span>
                        </div>
                    </td>
                    <td class="col-layanan">
                        <span class="layanan-badge">{{ Str::limit($permohonan->jenisLayanan->nama_layanan, 20) }}</span>
                    </td>
                    <td class="col-status">
                        <span class="status-indicator" style="background: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}20; color: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}">
                            <span class="status-dot" style="background: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}"></span>
                            {{ $permohonan->statusPermohonan->nama_status }}
                        </span>
                    </td>
                    <td class="col-prioritas">
                        <span class="priority-badge priority-{{ $permohonan->prioritas }}">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                            </svg>
                            {{ $permohonan->label_prioritas }}
                        </span>
                    </td>
                    <td class="col-tanggal">
                        <span class="tanggal-date">{{ $permohonan->tanggal_permohonan->format('d M Y') }}</span>
                        <span class="tanggal-time">{{ $permohonan->tanggal_permohonan->format('H:i') }}</span>
                    </td>
                    <td class="col-aksi">
                        <div class="action-group">
                            <a href="{{ route('loket.permohonan.show', $permohonan) }}" class="action-btn view-btn" title="Detail">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </a>
                            <button type="button" class="action-btn edit-btn" onclick="openEditModal({{ $permohonan->id }})" title="Edit">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </button>
                            @if($permohonan->statusPermohonan && $permohonan->statusPermohonan->kode_status === 'MENUNGGU')
                            <button type="button" class="action-btn distribusi-btn" onclick="openDistribusiModal({{ $permohonan->id }})" title="Teruskan ke Petugas">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="22" y1="2" x2="11" y2="13"/>
                                    <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                                </svg>
                            </button>
                            @endif
                            <button type="button" class="action-btn delete-btn" onclick="openDeleteModal({{ $permohonan->id }}, '{{ $permohonan->nomor_permohonan }}')" title="Hapus">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                </svg>
                            </button>
                            <button type="button" class="action-btn upload-btn" onclick="openUploadDokumenModal({{ $permohonan->id }})" title="Upload Dokumen">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="22" y1="2" x2="11" y2="13"/>
                                    <polygon points="22 2 15 22 11 13 2 9 22 2"/>
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
                                    <rect x="2" y="7" width="20" height="14" rx="2"/>
                                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                                </svg>
                            </div>
                            <h4>Tidak ada permohonan</h4>
                            <p>Belum ada permohonan yang terdaftar</p>
                            <button type="button" class="btn-pdf mt-3" onclick="openCreateModal()">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="12" y1="5" x2="12" y2="19"/>
                                    <line x1="5" y1="12" x2="19" y2="12"/>
                                </svg>
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
            @if($permohonans->onFirstPage())
                <span class="page-btn disabled">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6"/>
                    </svg>
                </span>
            @else
                <a href="{{ $permohonans->previousPageUrl() }}" class="page-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6"/>
                    </svg>
                </a>
            @endif

            <div class="page-numbers">
                @php
                    $current = $permohonans->currentPage();
                    $last = $permohonans->lastPage();
                    $start = max(1, $current - 2);
                    $end = min($last, $current + 2);
                @endphp

                @if($start > 1)
                    <a href="{{ $permohonans->url(1) }}" class="page-num">1</a>
                    @if($start > 2)
                        <span class="page-dots">…</span>
                    @endif
                @endif

                @for($i = $start; $i <= $end; $i++)
                    @if($i == $current)
                        <span class="page-num active">{{ $i }}</span>
                    @else
                        <a href="{{ $permohonans->url($i) }}" class="page-num">{{ $i }}</a>
                    @endif
                @endfor

                @if($end < $last)
                    @if($end < $last - 1)
                        <span class="page-dots">…</span>
                    @endif
                    <a href="{{ $permohonans->url($last) }}" class="page-num">{{ $last }}</a>
                @endif
            </div>

            @if($permohonans->hasMorePages())
                <a href="{{ $permohonans->nextPageUrl() }}" class="page-btn">
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

{{-- resources/views/loket/permohonan/index.blade.php --}}

{{-- ============================================
    CREATE MODAL - TANPA UPLOAD DOKUMEN
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
                    <!-- FORM FIELDS (tanpa dokumen) -->
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label class="form-label">Pemohon <span class="text-danger">*</span></label>
                            <select name="pemohon_id" id="create_pemohon_id" class="form-select" required>
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
    UPLOAD DOKUMEN MODAL - PERBAIKAN
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
                        <div class="file-upload-wrapper" style="border:2px dashed #dce2e0;border-radius:12px;padding:20px;text-align:center;cursor:pointer;transition:all 0.3s;background:#fafcfb;" id="dropZone">
                            <input type="file" name="dokumen" id="upload_dokumen_file" class="file-input" accept=".jpg,.jpeg,.png,.pdf" required style="position:absolute;inset:0;opacity:0;cursor:pointer;z-index:2;">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#07573c" stroke-width="1.5">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="17 8 12 3 7 8"/>
                                <line x1="12" y1="3" x2="12" y2="15"/>
                            </svg>
                            <p style="margin-top:8px;font-weight:500;color:#1d2b27;" id="uploadText">Klik atau drag file ke sini</p>
                            <p style="font-size:12px;color:#8a9a94;">Format: JPG, JPEG, PNG, PDF (Max 5MB)</p>
                            <p id="uploadFileName" style="font-weight:600;color:#07573c;margin-top:4px;display:none;"></p>
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
                            <span class="form-error" id="edit-error-pemohon_id"></span>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">Judul Permohonan</label>
                            <input type="text" name="judul_permohonan" id="edit_judul_permohonan" class="form-input">
                            <span class="form-error" id="edit-error-judul_permohonan"></span>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">Keterangan <span class="text-danger">*</span></label>
                            <textarea name="keterangan" id="edit_keterangan" class="form-textarea" rows="3" required></textarea>
                            <span class="form-error" id="edit-error-keterangan"></span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Jenis Layanan <span class="text-danger">*</span></label>
                            <select name="jenis_layanan_id" id="edit_jenis_layanan_id" class="form-select" required>
                                @foreach($layanans as $layanan)
                                <option value="{{ $layanan->id }}">{{ $layanan->nama_layanan }}</option>
                                @endforeach
                            </select>
                            <span class="form-error" id="edit-error-jenis_layanan_id"></span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status_permohonan_id" id="edit_status_permohonan_id" class="form-select" required>
                                @foreach($statuses as $status)
                                <option value="{{ $status->id }}">{{ $status->nama_status }}</option>
                                @endforeach
                            </select>
                            <span class="form-error" id="edit-error-status_permohonan_id"></span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Prioritas <span class="text-danger">*</span></label>
                            <select name="prioritas" id="edit_prioritas" class="form-select" required>
                                <option value="normal">Normal</option>
                                <option value="penting">Penting</option>
                                <option value="urgent">Urgent</option>
                            </select>
                            <span class="form-error" id="edit-error-prioritas"></span>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">Catatan Loket</label>
                            <textarea name="catatan_loket" id="edit_catatan_loket" class="form-textarea" rows="2"></textarea>
                            <span class="form-error" id="edit-error-catatan_loket"></span>
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
                    <p>Apakah Anda yakin ingin menghapus permohonan <strong id="deletePermohonanNomor"></strong>?</p>
                    <p class="text-muted small mt-2">⚠️ Tindakan ini tidak dapat dibatalkan.</p>
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

{{-- DISTRIBUSI MODAL --}}
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
                <h4 class="modal-title">Konfirmasi Distribusi</h4>
                <button type="button" class="modal-close" onclick="closeModal('distribusiModal')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body" id="distribusiModalBody">
                <div class="distribusi-loading text-center" id="distribusiLoading">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#07573c" stroke-width="2" class="spinner">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                    </svg>
                    <p class="mt-2">Memuat data...</p>
                </div>
                <div class="distribusi-content" id="distribusiContent" style="display: none;">
                    <div class="distribusi-info">
                        <div class="distribusi-info-item">
                            <label>Nomor Permohonan</label>
                            <span id="distribusi_nomor" class="fw-600"></span>
                        </div>
                        <div class="distribusi-info-item">
                            <label>Jenis Layanan</label>
                            <span id="distribusi_layanan"></span>
                        </div>
                        <div class="distribusi-info-item">
                            <label>Role Tujuan</label>
                            <span id="distribusi_role" class="role-badge-distribusi"></span>
                        </div>
                        <div class="distribusi-info-item">
                            <label>Petugas Tujuan</label>
                            <span id="distribusi_petugas"></span>
                        </div>
                        <div class="distribusi-info-item full-width">
                            <label>Catatan</label>
                            <textarea id="distribusi_catatan" class="form-textarea" rows="2" placeholder="Catatan tambahan (opsional)"></textarea>
                        </div>
                    </div>
                    <div class="distribusi-warning">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            <line x1="12" y1="9" x2="12" y2="13"/>
                            <line x1="12" y1="17" x2="12.01" y2="17"/>
                        </svg>
                        <span>Permohonan akan diteruskan ke petugas yang bertugas. Pastikan data sudah lengkap.</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('distribusiModal')">Batal</button>
                <button type="button" class="btn-primary" id="distribusiSubmit">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13"/>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                    </svg>
                    Teruskan Permohonan
                </button>
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

.nomor-wrapper {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.nomor-number {
    font-weight: 700;
    color: #07573c;
    font-size: 13px;
}

.nomor-title {
    font-size: 12px;
    color: #8a9a94;
}

.layanan-badge {
    display: inline-block;
    padding: 3px 12px;
    background: #eef6ff;
    color: #2563eb;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 500;
}
.upload-btn:hover {
    background: #dbeafe;
    color: #2563eb;
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

.tanggal-date {
    display: block;
    font-weight: 500;
    color: #1d2b27;
    font-size: 12px;
}

.tanggal-time {
    font-size: 10px;
    color: #8a9a94;
}

.col-no { width: 40px; text-align: center; color: #b0c4bc; font-weight: 500; }
.col-nomor { min-width: 150px; }
.col-pemohon { min-width: 180px; }
.col-layanan { min-width: 130px; }
.col-status { min-width: 110px; }
.col-prioritas { min-width: 90px; }
.col-tanggal { min-width: 110px; }
.col-aksi { min-width: 160px; text-align: center; }

/* ============================================
   BUTTON STYLES
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
   DISTRIBUSI BUTTON
============================================ */
.distribusi-btn:hover {
    background: #dbeafe;
    color: #2563eb;
}

/* ============================================
   DOKUMEN UPLOAD
============================================ */
.dokumen-item {
    margin-bottom: 8px;
    padding: 10px;
    background: #f8faf9;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.dokumen-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr auto;
    gap: 8px;
    align-items: center;
}

.file-upload-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    background: white;
    padding: 0 12px;
    height: 40px;
    overflow: hidden;
    cursor: pointer;
}

.file-upload-wrapper .file-input {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    z-index: 2;
}

.file-upload-wrapper .file-placeholder {
    color: #b0c4bc;
    font-size: 12px;
    white-space: nowrap;
}

.file-upload-wrapper .file-name {
    font-size: 12px;
    color: #07573c;
    font-weight: 500;
    margin-left: 8px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.file-upload-wrapper.has-file .file-placeholder {
    display: none;
}

.btn-remove-dokumen {
    padding: 4px 8px;
    border-radius: 6px;
    background: transparent;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-remove-dokumen:hover {
    background: #fde8e8;
}

.btn-add-dokumen {
    margin-top: 8px;
    padding: 6px 16px;
    background: #e8f0ed;
    border-radius: 8px;
    color: #07573c;
    font-weight: 600;
    font-size: 12px;
    border: 1px dashed #07573c;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
}

.btn-add-dokumen:hover {
    background: #d1e6dd;
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
.fw-600 { font-weight: 600; }

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

/* ============================================
   DISTRIBUSI MODAL
============================================ */
.spinner {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.distribusi-info {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px 20px;
    margin-bottom: 16px;
}

.distribusi-info-item {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.distribusi-info-item.full-width {
    grid-column: 1 / -1;
}

.distribusi-info-item label {
    font-size: 11px;
    font-weight: 600;
    color: #8a9a94;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}

.distribusi-info-item span {
    font-size: 14px;
    color: #1d2b27;
    padding: 4px 0;
}

.role-badge-distribusi {
    display: inline-block;
    padding: 2px 12px;
    background: #dbeafe;
    color: #2563eb;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

.distribusi-warning {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    padding: 10px 14px;
    background: #fef3c7;
    border-radius: 8px;
    color: #92400e;
    font-size: 12px;
    margin-top: 8px;
}

.distribusi-warning svg {
    flex-shrink: 0;
    margin-top: 1px;
}

.distribusi-info-text {
    margin-top: 8px;
    padding: 8px 12px;
    background: #dbeafe;
    border-radius: 8px;
    font-size: 12px;
    color: #1e40af;
}

.distribusi-info-text svg {
    display: inline;
    vertical-align: middle;
    margin-right: 6px;
}

/* ============================================
   BUTTONS
============================================ */
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
    .distribusi-info { grid-template-columns: 1fr; }
    .dokumen-grid {
        grid-template-columns: 1fr;
        gap: 6px;
    }
    .dokumen-aksi {
        text-align: right;
    }
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
    .col-no, .col-nomor, .col-pemohon, .col-layanan, .col-status, .col-prioritas, .col-tanggal, .col-aksi {
        width: 100% !important;
        min-width: unset !important;
    }
    .col-aksi { justify-content: center; }
}
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>
@endpush

{{-- @push('scripts') --}}

<script>
// ============================================
// TOAST NOTIFICATION - TETAP SAMA
// ============================================
function showToast(message, type = 'success') {
    const container = document.getElementById('toastContainer');
    if (!container) {
        console.warn('Toast container not found');
        return;
    }

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
    // Reset form errors
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
// DOKUMEN FUNCTIONS
// ============================================

function addDokumen() {
    const container = document.getElementById('dokumenContainer');
    if (!container) return;

    const item = document.querySelector('.dokumen-item');
    if (!item) return;

    const newItem = item.cloneNode(true);

    // Reset input file
    const fileInput = newItem.querySelector('.file-input');
    if (fileInput) {
        fileInput.value = '';
        const wrapper = newItem.querySelector('.file-upload-wrapper');
        const placeholder = wrapper?.querySelector('.file-placeholder');
        const fileName = wrapper?.querySelector('.file-name');
        if (placeholder) placeholder.style.display = 'block';
        if (fileName) fileName.textContent = '';
        if (wrapper) wrapper.classList.remove('has-file');
    }

    // Reset input text
    const nameInput = newItem.querySelector('input[name="dokumen_nama[]"]');
    if (nameInput) nameInput.value = '';

    // Reset select
    const selectInput = newItem.querySelector('select[name="dokumen_jenis[]"]');
    if (selectInput) selectInput.value = '';

    container.appendChild(newItem);
    initFileInput(newItem);
}

function removeDokumen(btn) {
    const item = btn.closest('.dokumen-item');
    const container = document.getElementById('dokumenContainer');
    if (!item || !container) return;

    if (container.querySelectorAll('.dokumen-item').length > 1) {
        item.remove();
    } else {
        // Reset jika hanya satu item
        const fileInput = item.querySelector('.file-input');
        if (fileInput) {
            fileInput.value = '';
            const wrapper = item.querySelector('.file-upload-wrapper');
            const placeholder = wrapper?.querySelector('.file-placeholder');
            const fileName = wrapper?.querySelector('.file-name');
            if (placeholder) placeholder.style.display = 'block';
            if (fileName) fileName.textContent = '';
            if (wrapper) wrapper.classList.remove('has-file');
        }

        const nameInput = item.querySelector('input[name="dokumen_nama[]"]');
        if (nameInput) nameInput.value = '';

        const selectInput = item.querySelector('select[name="dokumen_jenis[]"]');
        if (selectInput) selectInput.value = '';
    }
}

function initFileInput(container) {
    const fileInput = container?.querySelector('.file-input');
    if (!fileInput) return;

    const newFileInput = fileInput.cloneNode(true);
    fileInput.parentNode.replaceChild(newFileInput, fileInput);

    newFileInput.addEventListener('change', function() {
        const wrapper = this.closest('.file-upload-wrapper');
        if (!wrapper) return;

        const placeholder = wrapper.querySelector('.file-placeholder');
        const fileName = wrapper.querySelector('.file-name');

        if (this.files && this.files.length > 0) {
            const file = this.files[0];
            wrapper.classList.add('has-file');
            if (placeholder) placeholder.style.display = 'none';
            if (fileName) fileName.textContent = file.name;

            const nameInput = wrapper.closest('.dokumen-item')?.querySelector('input[name="dokumen_nama[]"]');
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

// ============================================
// CREATE MODAL
// ============================================
function openCreateModal() {
    const form = document.getElementById('createForm');
    if (form) form.reset();

    document.querySelectorAll('#createModal .form-error').forEach(el => {
        el.classList.remove('show');
        el.textContent = '';
    });

    // Reset dokumen
    const container = document.getElementById('dokumenContainer');
    if (container) {
        container.innerHTML = `
            <div class="dokumen-item">
                <div class="dokumen-grid">
                    <div class="dokumen-file">
                        <div class="file-upload-wrapper">
                            <input type="file" name="dokumen[]" class="file-input" accept=".jpg,.jpeg,.png,.pdf">
                            <span class="file-placeholder">Pilih file...</span>
                            <span class="file-name"></span>
                        </div>
                    </div>
                    <div class="dokumen-nama">
                        <input type="text" name="dokumen_nama[]" class="form-input" placeholder="Nama dokumen">
                    </div>
                    <div class="dokumen-jenis">
                        <select name="dokumen_jenis[]" class="form-select">
                            <option value="">-- Pilih Jenis --</option>
                            @foreach($jenisDokumens as $jenis)
                            <option value="{{ $jenis->id }}">{{ $jenis->nama_dokumen }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="dokumen-aksi">
                        <button type="button" class="btn-remove-dokumen" onclick="removeDokumen(this)" title="Hapus dokumen">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"/>
                                <line x1="6" y1="6" x2="18" y2="18"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    // Re-init file input
    document.querySelectorAll('.dokumen-item').forEach(function(item) {
        initFileInput(item);
    });

    // Sembunyikan info distribusi
    const distribusiInfo = document.getElementById('create_distribusi_info');
    if (distribusiInfo) distribusiInfo.style.display = 'none';

    openModal('createModal');
}

// Auto show distribusi info saat pilih jenis layanan
document.addEventListener('DOMContentLoaded', function() {
    const layananSelect = document.getElementById('create_jenis_layanan_id');
    if (layananSelect) {
        layananSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const role = selectedOption?.getAttribute('data-role');
            const infoDiv = document.getElementById('create_distribusi_info');
            const infoText = document.getElementById('create_distribusi_text');

            if (role && infoDiv && infoText) {
                const roleLabels = {
                    'pengecekan_kehilangan': 'Pengecekan Kehilangan',
                    'kutipan_kedua': 'Kutipan Kedua',
                    'banjir_kepolisian': 'Banjir Kepolisian',
                    'keabsahan': 'Keabsahan',
                    'surat_pengantar': 'Surat Pengantar'
                };
                const label = roleLabels[role] || role;
                infoText.innerHTML = `Permohonan akan diteruskan ke petugas <strong>${label}</strong>`;
                infoDiv.style.display = 'block';
            } else if (infoDiv) {
                infoDiv.style.display = 'none';
            }
        });
    }

    // Init file input
    document.querySelectorAll('.dokumen-item').forEach(function(item) {
        initFileInput(item);
    });
});

// ============================================
// CREATE FORM SUBMIT
// ============================================
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
            .then(response => {
                // Cek apakah response OK
                if (!response.ok) {
                    return response.text().then(text => {
                        throw new Error(`Server error (${response.status}): ${text.substring(0, 200)}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    let message = data.message;
                    if (data.distribusi && data.distribusi.status === 'dikirim') {
                        message += `\n✅ Permohonan diteruskan ke ${data.distribusi.petugas} (${data.distribusi.role})`;
                    } else if (data.distribusi && data.distribusi.status === 'tidak_ada_petugas') {
                        message += `\n⚠️ Belum ada petugas yang tersedia. Permohonan akan tetap di status Menunggu.`;
                    }
                    showToast(message, 'success');
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
                console.error('Error:', error);
                showToast('Terjadi kesalahan: ' + error.message, 'error');
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
        form.action = `{{ route('loket.permohonan.index') }}/${id}`;
    }

    fetch(`{{ route('loket.permohonan.index') }}/${id}/edit`)
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error(`Server error (${response.status}): ${text.substring(0, 200)}`);
                });
            }
            return response.json();
        })
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
                openModal('editModal');
            } else {
                showToast('Gagal memuat data', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Terjadi kesalahan: ' + error.message, 'error');
        });
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
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => {
                        throw new Error(`Server error (${response.status}): ${text.substring(0, 200)}`);
                    });
                }
                return response.json();
            })
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
                console.error('Error:', error);
                showToast('Terjadi kesalahan: ' + error.message, 'error');
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
// DELETE
// ============================================
function openDeleteModal(id, nomor) {
    document.getElementById('deletePermohonanNomor').textContent = nomor;
    const form = document.getElementById('deleteForm');
    if (form) {
        form.action = `{{ route('loket.permohonan.index') }}/${id}`;
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
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => {
                        throw new Error(`Server error (${response.status}): ${text.substring(0, 200)}`);
                    });
                }
                return response.json();
            })
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
                console.error('Error:', error);
                showToast('Terjadi kesalahan: ' + error.message, 'error');
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
// UPLOAD DOKUMEN
// ============================================
let uploadPermohonanId = null;

function openUploadDokumenModal(id) {
    uploadPermohonanId = id;

    // Reset form
    const form = document.getElementById('uploadDokumenForm');
    if (form) form.reset();

    document.querySelectorAll('#uploadDokumenModal .form-error').forEach(el => {
        el.classList.remove('show');
        el.textContent = '';
    });

    // Reset tampilan file
    const fileName = document.getElementById('uploadFileName');
    const uploadText = document.getElementById('uploadText');
    const dropZone = document.getElementById('dropZone');

    if (fileName) {
        fileName.style.display = 'none';
        fileName.textContent = '';
    }
    if (uploadText) uploadText.textContent = 'Klik atau drag file ke sini';
    if (dropZone) {
        dropZone.style.borderColor = '#dce2e0';
        dropZone.style.background = '#fafcfb';
    }

    // Set action form
    if (form) {
        form.action = `{{ url('loket/permohonan') }}/${id}/upload-dokumen`;
    }

    openModal('uploadDokumenModal');
}

// File input handler
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('upload_dokumen_file');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const fileName = document.getElementById('uploadFileName');
            const uploadText = document.getElementById('uploadText');
            const dropZone = document.getElementById('dropZone');

            if (this.files && this.files.length > 0) {
                const file = this.files[0];
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];

                if (!validTypes.includes(file.type)) {
                    alert('Format file tidak didukung. Gunakan JPG, JPEG, PNG, atau PDF.');
                    this.value = '';
                    return;
                }

                if (file.size > 5 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 5MB.');
                    this.value = '';
                    return;
                }

                const fileSize = (file.size / 1024).toFixed(1) + ' KB';
                if (fileName) {
                    fileName.textContent = `📄 ${file.name} (${fileSize})`;
                    fileName.style.display = 'block';
                }
                if (uploadText) uploadText.textContent = 'File siap diupload';
                if (dropZone) {
                    dropZone.style.borderColor = '#07573c';
                    dropZone.style.background = '#e8f0ed';
                }
            } else {
                if (fileName) {
                    fileName.style.display = 'none';
                    fileName.textContent = '';
                }
                if (uploadText) uploadText.textContent = 'Klik atau drag file ke sini';
                if (dropZone) {
                    dropZone.style.borderColor = '#dce2e0';
                    dropZone.style.background = '#fafcfb';
                }
            }
        });
    }

    // Drag and drop
    const dropZone = document.getElementById('dropZone');
    if (dropZone) {
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, function(e) {
                e.preventDefault();
                this.style.borderColor = '#07573c';
                this.style.background = '#e8f0ed';
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, function(e) {
                e.preventDefault();
                if (eventName !== 'drop') {
                    this.style.borderColor = '#dce2e0';
                    this.style.background = '#fafcfb';
                }
            });
        });

        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const fileInput = document.getElementById('upload_dokumen_file');
                if (fileInput) {
                    fileInput.files = files;
                    fileInput.dispatchEvent(new Event('change'));
                }
            }
        });
    }
});

// Submit upload dokumen
document.addEventListener('DOMContentLoaded', function() {
    const uploadForm = document.getElementById('uploadDokumenForm');
    if (uploadForm) {
        uploadForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const fileInput = document.getElementById('upload_dokumen_file');
            if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
                showToast('Silakan pilih file terlebih dahulu', 'error');
                return;
            }

            const submitBtn = document.getElementById('uploadDokumenSubmit');
            if (!submitBtn) return;

            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Mengupload...';

            const formData = new FormData(this);

            // Debug log
            console.log('=== UPLOAD DOKUMEN ===');
            for (let pair of formData.entries()) {
                if (pair[0] === 'dokumen') {
                    console.log('File:', pair[1].name, pair[1].size, pair[1].type);
                } else {
                    console.log(pair[0], pair[1]);
                }
            }

            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => {
                // Cek apakah response OK
                if (!response.ok) {
                    return response.text().then(text => {
                        console.error('Response error:', text);
                        throw new Error(`Server error (${response.status}): ${text.substring(0, 200)}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    closeModal('uploadDokumenModal');
                    setTimeout(() => window.location.reload(), 500);
                } else {
                    if (data.errors) {
                        Object.keys(data.errors).forEach(key => {
                            const errorEl = document.getElementById(`upload-error-${key}`);
                            if (errorEl) {
                                errorEl.textContent = data.errors[key][0];
                                errorEl.classList.add('show');
                            }
                        });
                        showToast('Silakan perbaiki form', 'error');
                    } else {
                        showToast(data.message || 'Terjadi kesalahan', 'error');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan: ' + error.message, 'error');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = `
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13"/>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                    </svg>
                    Upload Dokumen
                `;
            });
        });
    }
});

// ============================================
// DISTRIBUSI MODAL
// ============================================
let distribusiPermohonanId = null;

function openDistribusiModal(id) {
    distribusiPermohonanId = id;

    document.getElementById('distribusiLoading').style.display = 'block';
    document.getElementById('distribusiContent').style.display = 'none';

    const submitBtn = document.getElementById('distribusiSubmit');
    if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = `
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="22" y1="2" x2="11" y2="13"/>
                <polygon points="22 2 15 22 11 13 2 9 22 2"/>
            </svg>
            Teruskan Permohonan
        `;
    }

    openModal('distribusiModal');

    fetch(`{{ url('loket/permohonan') }}/${id}`)
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error(`Server error (${response.status}): ${text.substring(0, 200)}`);
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const p = data.data;
                const roleLabels = {
                    'pengecekan_kehilangan': 'Pengecekan Kehilangan',
                    'kutipan_kedua': 'Kutipan Kedua',
                    'banjir_kepolisian': 'Banjir Kepolisian',
                    'keabsahan': 'Keabsahan',
                    'surat_pengantar': 'Surat Pengantar'
                };

                document.getElementById('distribusi_nomor').textContent = p.nomor_permohonan;
                document.getElementById('distribusi_layanan').textContent = p.jenis_layanan.nama_layanan;

                const role = p.jenis_layanan.role_tujuan;
                const roleLabel = roleLabels[role] || role || 'Tidak ada';
                document.getElementById('distribusi_role').textContent = roleLabel;

                fetch(`{{ url('loket/permohonan/get-petugas') }}?jenis_layanan_id=${p.jenis_layanan_id}`)
                    .then(res => {
                        if (!res.ok) {
                            throw new Error(`Server error (${res.status})`);
                        }
                        return res.json();
                    })
                    .then(petugasData => {
                        if (petugasData.success) {
                            document.getElementById('distribusi_petugas').innerHTML = `
                                <span style="background:#d1fae5;color:#065f46;padding:2px 12px;border-radius:12px;font-weight:600;">
                                    ${petugasData.data.petugas} (${petugasData.data.role})
                                </span>
                            `;
                        } else {
                            document.getElementById('distribusi_petugas').innerHTML = `
                                <span style="color:#dc2626;font-weight:600;">${petugasData.message}</span>
                            `;
                        }
                        document.getElementById('distribusiLoading').style.display = 'none';
                        document.getElementById('distribusiContent').style.display = 'block';
                    })
                    .catch(() => {
                        document.getElementById('distribusi_petugas').textContent = 'Gagal memuat data petugas';
                        document.getElementById('distribusiLoading').style.display = 'none';
                        document.getElementById('distribusiContent').style.display = 'block';
                    });
            } else {
                showToast('Gagal memuat data', 'error');
                closeModal('distribusiModal');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Terjadi kesalahan: ' + error.message, 'error');
            closeModal('distribusiModal');
        });
}

document.addEventListener('DOMContentLoaded', function() {
    const distribusiSubmit = document.getElementById('distribusiSubmit');
    if (distribusiSubmit) {
        const newSubmit = distribusiSubmit.cloneNode(true);
        distribusiSubmit.parentNode.replaceChild(newSubmit, distribusiSubmit);

        newSubmit.addEventListener('click', function() {
            if (!distribusiPermohonanId) {
                showToast('Data permohonan tidak valid', 'error');
                return;
            }

            if (!confirm('Apakah Anda yakin ingin meneruskan permohonan ini ke petugas terkait?')) {
                return;
            }

            const btn = this;
            btn.disabled = true;
            btn.innerHTML = 'Memproses...';

            const catatan = document.getElementById('distribusi_catatan')?.value || '';

            fetch(`{{ url('loket/permohonan') }}/${distribusiPermohonanId}/distribusikan`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    catatan: catatan
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => {
                        throw new Error(`Server error (${response.status}): ${text.substring(0, 200)}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    closeModal('distribusiModal');
                    setTimeout(() => window.location.reload(), 500);
                } else {
                    showToast(data.message || 'Gagal meneruskan permohonan', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan: ' + error.message, 'error');
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = `
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13"/>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                    </svg>
                    Teruskan Permohonan
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
{{-- @endpush --}}