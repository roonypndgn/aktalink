<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Pemohon</title>
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
            font-size: 9px;
        }
        .pdf-table thead th {
            background: #07573c;
            color: white;
            padding: 8px 10px;
            text-align: left;
            font-weight: 700;
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .pdf-table tbody td {
            padding: 7px 10px;
            border-bottom: 1px solid #e9ecef;
            vertical-align: middle;
        }
        .pdf-table tbody tr:hover { background: #f8faf9; }
        .pdf-table tbody tr:last-child td { border-bottom: none; }

        .badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 7px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        .badge-male { background: #dbeafe; color: #2563eb; }
        .badge-female { background: #fce7f3; color: #db2777; }
        .badge-unknown { background: #f3f4f6; color: #6b7280; }
        .badge-nik { background: #f0f5f2; color: #4a5a54; font-family: monospace; }

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
            .pdf-table tbody tr:hover { background: transparent; }
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
            <div class="label" style="margin-top: 4px;">Total Data</div>
            <div class="value">{{ $totalData }} Pemohon</div>
        </div>
    </div>

    {{-- FILTER INFO --}}
    <div class="pdf-filter-info">
        <strong>Filter:</strong> {{ $filterText }}
    </div>

    {{-- STATS --}}
    <div class="pdf-stats">
        <div class="pdf-stat"><div class="number">{{ $stats['total'] }}</div><div class="label">Total</div></div>
        <div class="pdf-stat"><div class="number">{{ $stats['laki'] }}</div><div class="label">Laki-laki</div></div>
        <div class="pdf-stat"><div class="number">{{ $stats['perempuan'] }}</div><div class="label">Perempuan</div></div>
        <div class="pdf-stat"><div class="number">{{ $stats['belum_isi'] }}</div><div class="label">Belum Terisi</div></div>
    </div>

    {{-- TABLE --}}
    <table class="pdf-table">
        <thead>
            <tr>
                <th width="30">#</th>
                <th width="140">Nama Lengkap</th>
                <th width="120">NIK</th>
                <th width="80">Jenis Kelamin</th>
                <th width="100">Tempat Lahir</th>
                <th width="90">Tanggal Lahir</th>
                <th width="100">No. HP</th>
                <th width="180">Alamat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pemohons as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ $p->nama_lengkap }}</strong></td>
                <td><span class="badge badge-nik">{{ $p->nik }}</span></td>
                <td>
                    <span class="badge 
                        @if($p->jenis_kelamin == 'L') badge-male
                        @elseif($p->jenis_kelamin == 'P') badge-female
                        @else badge-unknown @endif">
                        {{ $p->jenis_kelamin_label }}
                    </span>
                </td>
                <td>{{ $p->tempat_lahir ?? '-' }}</td>
                <td>{{ $p->tanggal_lahir ? $p->tanggal_lahir->format('d/m/Y') : '-' }}</td>
                <td>{{ $p->nomor_hp ?? '-' }}</td>
                <td>{{ Str::limit($p->alamat ?? '-', 40) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center;padding:30px;color:#788580;">
                    Tidak ada data pemohon yang ditemukan
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