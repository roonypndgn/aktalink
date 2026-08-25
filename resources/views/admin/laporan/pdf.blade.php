<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Permohonan - AKTALINK</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
            font-size: 10px;
            color: #1d2b27;
            background: white;
            padding: 20px;
        }

        .pdf-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #07573c;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }

        .pdf-header-left { display: flex; align-items: center; gap: 14px; }
        .pdf-logo {
            width: 48px; height: 48px;
            background: #07573c;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            font-weight: 800;
        }
        .pdf-title h1 { font-size: 18px; font-weight: 800; color: #07573c; }
        .pdf-title h1 span { color: #f4b32a; }
        .pdf-title p { font-size: 9px; color: #788580; }

        .pdf-header-right { text-align: right; }
        .pdf-header-right .label { font-size: 8px; color: #788580; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; }
        .pdf-header-right .value { font-size: 11px; font-weight: 700; color: #1d2b27; }

        .pdf-filter-info {
            background: #f8faf9;
            padding: 8px 14px;
            border-radius: 6px;
            margin-bottom: 14px;
            font-size: 9px;
            color: #4a5a54;
            border: 1px solid #e9ecef;
        }
        .pdf-filter-info strong { color: #1d2b27; }

        .pdf-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 16px;
        }
        .pdf-stat {
            background: #f8faf9;
            border-radius: 8px;
            padding: 10px 14px;
            border: 1px solid #e9ecef;
            text-align: center;
        }
        .pdf-stat .number { font-size: 20px; font-weight: 800; color: #07573c; }
        .pdf-stat .label { font-size: 8px; color: #788580; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; margin-top: 2px; }

        .pdf-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
        }
        .pdf-table thead th {
            background: #07573c;
            color: white;
            padding: 6px 8px;
            text-align: left;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            font-size: 7px;
        }
        .pdf-table tbody td {
            padding: 5px 8px;
            border-bottom: 1px solid #e9ecef;
            vertical-align: middle;
        }
        .pdf-table tbody tr:last-child td { border-bottom: none; }

        .badge {
            display: inline-block;
            padding: 1px 8px;
            border-radius: 10px;
            font-size: 7px;
            font-weight: 700;
        }
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-danger { background: #fde8e8; color: #b91c1c; }
        .badge-info { background: #dbeafe; color: #1e40af; }
        .badge-secondary { background: #e9ecef; color: #495057; }

        .status-dot {
            display: inline-block;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            margin-right: 4px;
        }

        .pdf-footer {
            margin-top: 16px;
            padding-top: 12px;
            border-top: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            font-size: 8px;
            color: #788580;
        }
        .pdf-footer .page-number { font-weight: 600; }

        @media print {
            body { padding: 10px; }
            .pdf-table thead th { background: #07573c !important; color: white !important; }
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="pdf-header">
        <div class="pdf-header-left">
            <div class="pdf-logo">AK</div>
            <div class="pdf-title">
                <h1>AKTA<span>LINK</span></h1>
                <p>Dinas Kependudukan dan Pencatatan Sipil Kota Medan</p>
            </div>
        </div>
        <div class="pdf-header-right">
            <div class="label">Tanggal Cetak</div>
            <div class="value">{{ $generatedAt }}</div>
            <div class="label" style="margin-top:4px;">Total Data</div>
            <div class="value">{{ $totalData }} Permohonan</div>
        </div>
    </div>

    {{-- FILTER INFO --}}
    <div class="pdf-filter-info">
        <strong>Filter:</strong> {{ $filterText ?? 'Semua Data' }}
    </div>

    {{-- STATS --}}
    <div class="pdf-stats">
        <div class="pdf-stat"><div class="number">{{ $stats['total'] }}</div><div class="label">Total</div></div>
        <div class="pdf-stat"><div class="number">{{ $stats['selesai'] }}</div><div class="label">Selesai</div></div>
        <div class="pdf-stat"><div class="number">{{ $stats['proses'] }}</div><div class="label">Diproses</div></div>
        <div class="pdf-stat"><div class="number">{{ $stats['menunggu'] }}</div><div class="label">Menunggu</div></div>
    </div>

    {{-- TABLE --}}
    <table class="pdf-table">
        <thead>
            <tr>
                <th width="25">#</th>
                <th width="100">Nomor</th>
                <th width="120">Pemohon</th>
                <th width="120">Layanan</th>
                <th width="80">Status</th>
                <th width="80">Petugas</th>
                <th width="80">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($permohonans as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ $p->nomor_permohonan }}</strong></td>
                <td>{{ $p->pemohon->nama_lengkap ?? '-' }}</td>
                <td>{{ $p->jenisLayanan->nama_layanan ?? '-' }}</td>
                <td>
                    @php
                        $status = $p->statusPermohonan;
                        $badgeClass = 'secondary';
                        if ($status) {
                            if ($status->kode_status === 'SELESAI') $badgeClass = 'success';
                            elseif ($status->kode_status === 'MENUNGGU') $badgeClass = 'warning';
                            elseif ($status->kode_status === 'KURANG_LENGKAP') $badgeClass = 'danger';
                            elseif (in_array($status->kode_status, ['DITERUSKAN', 'DIPROSES'])) $badgeClass = 'info';
                        }
                    @endphp
                    <span class="badge badge-{{ $badgeClass }}">
                        @if($status)
                            <span class="status-dot" style="background: {{ $status->warna ?? '#6c757d' }}"></span>
                            {{ $status->nama_status }}
                        @else
                            -
                        @endif
                    </span>
                </td>
                <td>{{ $p->petugasLoket->name ?? '-' }}</td>
                <td>{{ $p->created_at->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;padding:20px;color:#788580;">
                    Tidak ada data permohonan yang ditemukan
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- FOOTER --}}
    <div class="pdf-footer">
        <div><strong>AKTALINK</strong> - Sistem Informasi Monitoring, Pengelolaan, dan Pengecekan Akta</div>
        <div class="page-number">Halaman <span class="pageNumber"></span></div>
    </div>

</body>
</html>