<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Aktivitas - AKTALINK</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
            font-size: 9px;
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

        .pdf-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
        }
        .pdf-table thead th {
            background: #07573c;
            color: white;
            padding: 5px 8px;
            text-align: left;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            font-size: 7px;
        }
        .pdf-table tbody td {
            padding: 4px 8px;
            border-bottom: 1px solid #e9ecef;
            vertical-align: middle;
        }
        .pdf-table tbody tr:last-child td { border-bottom: none; }

        .badge {
            display: inline-block;
            padding: 1px 6px;
            border-radius: 8px;
            font-size: 7px;
            font-weight: 600;
        }
        .badge-info { background: #dbeafe; color: #1e40af; }
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-danger { background: #fde8e8; color: #b91c1c; }
        .badge-secondary { background: #e9ecef; color: #495057; }

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
            <div class="value">{{ $totalData }} Aktivitas</div>
        </div>
    </div>

    {{-- TABLE --}}
    <table class="pdf-table">
        <thead>
            <tr>
                <th width="25">#</th>
                <th width="120">Pengguna</th>
                <th width="140">Aktivitas</th>
                <th width="180">Deskripsi</th>
                <th width="80">Modul</th>
                <th width="100">IP Address</th>
                <th width="100">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $index => $log)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $log->user?->name ?? 'System' }}</td>
                <td><span class="badge badge-info">{{ $log->aktivitas }}</span></td>
                <td>{{ Str::limit($log->deskripsi ?? '-', 60) }}</td>
                <td>{{ $log->subject_type ? class_basename($log->subject_type) : '-' }}</td>
                <td>{{ $log->ip_address ?? '-' }}</td>
                <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;padding:20px;color:#788580;">
                    Tidak ada riwayat aktivitas
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