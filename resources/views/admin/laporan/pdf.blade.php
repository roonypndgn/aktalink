<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Permohonan - AKTALINK</title>
    <style>
        /* ============================================
           ROOT
        ============================================ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', 'Times', 'Segoe UI', serif;
            font-size: 10pt;
            color: #1a2a24;
            background: white;
            padding: 20px;
            line-height: 1.5;
        }

        /* ============================================
           KOP SURAT
        ============================================ */
        .letterhead {
            text-align: center;
            border-bottom: 3px double #07573c;
            padding-bottom: 14px;
            margin-bottom: 16px;
        }

        .letterhead .institution {
            font-size: 14pt;
            font-weight: 700;
            color: #07573c;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .letterhead .institution span {
            color: #f4b32a;
        }

        .letterhead .address {
            font-size: 8pt;
            color: #4a5a54;
            margin-top: 2px;
            letter-spacing: 0.03em;
        }

        .letterhead .title {
            font-size: 16pt;
            font-weight: 700;
            color: #07573c;
            margin-top: 8px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            border-top: 1px solid #07573c;
            padding-top: 8px;
        }

        .letterhead .subtitle {
            font-size: 9pt;
            color: #4a5a54;
            font-weight: 500;
        }

        /* ============================================
           HEADER INFO
        ============================================ */
        .report-info {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 14px;
            padding: 8px 14px;
            background: #f8faf9;
            border-radius: 4px;
            border: 1px solid #e9ecef;
            font-size: 8.5pt;
        }

        .report-info .info-left {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .report-info .info-left .label {
            color: #6c7a75;
            font-weight: 600;
            font-size: 7.5pt;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .report-info .info-left .value {
            font-weight: 600;
            color: #1a2a24;
        }

        .report-info .info-right {
            text-align: right;
        }

        .report-info .info-right .label {
            color: #6c7a75;
            font-size: 7.5pt;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .report-info .info-right .value {
            font-weight: 600;
            color: #1a2a24;
        }

        /* ============================================
           FILTER INFO
        ============================================ */
        .filter-info {
            background: #f8faf9;
            padding: 6px 14px;
            border-radius: 4px;
            margin-bottom: 14px;
            font-size: 8.5pt;
            color: #4a5a54;
            border-left: 3px solid #07573c;
        }

        .filter-info strong {
            color: #1a2a24;
        }

        /* ============================================
           STATISTICS
        ============================================ */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            margin-bottom: 16px;
        }

        .stat-card {
            background: #f8faf9;
            border-radius: 6px;
            padding: 8px 12px;
            border: 1px solid #e9ecef;
            text-align: center;
        }

        .stat-card .number {
            font-size: 16pt;
            font-weight: 700;
            color: #07573c;
        }

        .stat-card .label {
            font-size: 7pt;
            color: #6c7a75;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            font-weight: 600;
            margin-top: 2px;
        }

        /* ============================================
           TABLE
        ============================================ */
        .table-container {
            margin-top: 12px;
        }

        .table-title {
            font-size: 9pt;
            font-weight: 700;
            color: #1a2a24;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
        }

        .data-table thead th {
            background: #07573c;
            color: white;
            padding: 5px 8px;
            text-align: left;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            font-size: 7pt;
            border: 1px solid #07573c;
        }

        .data-table thead th.center {
            text-align: center;
        }

        .data-table tbody td {
            padding: 4px 8px;
            border: 1px solid #e9ecef;
            vertical-align: middle;
        }

        .data-table tbody tr:nth-child(even) {
            background: #fafcfb;
        }

        .data-table tbody tr:hover {
            background: #f0f5f2;
        }

        .data-table tbody td.center {
            text-align: center;
        }

        /* ============================================
           BADGE STATUS
        ============================================ */
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 1px 8px;
            border-radius: 10px;
            font-size: 6.5pt;
            font-weight: 700;
        }

        .badge-status .dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            display: inline-block;
        }

        .badge-selesai {
            background: #d1fae5;
            color: #065f46;
        }
        .badge-diproses {
            background: #dbeafe;
            color: #1e40af;
        }
        .badge-menunggu {
            background: #fef3c7;
            color: #92400e;
        }
        .badge-kurang_lengkap {
            background: #fde8e8;
            color: #b91c1c;
        }
        .badge-default {
            background: #e9ecef;
            color: #495057;
        }

        /* ============================================
           PRIORITAS
        ============================================ */
        .priority {
            display: inline-block;
            padding: 1px 8px;
            border-radius: 8px;
            font-size: 6.5pt;
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

        /* ============================================
           FOOTER
        ============================================ */
        .footer {
            margin-top: 16px;
            padding-top: 12px;
            border-top: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            font-size: 7.5pt;
            color: #6c7a75;
        }

        .footer .left {
            flex: 1;
        }

        .footer .left .official {
            font-weight: 600;
            color: #1a2a24;
            font-size: 8pt;
        }

        .footer .center {
            text-align: center;
            flex: 1;
        }

        .footer .center .signature-line {
            margin-top: 24px;
            width: 180px;
            border-top: 1px solid #1a2a24;
            margin-left: auto;
            margin-right: auto;
        }

        .footer .center .signature-name {
            font-weight: 600;
            color: #1a2a24;
            font-size: 8pt;
            margin-top: 2px;
        }

        .footer .center .signature-position {
            font-size: 7pt;
            color: #6c7a75;
        }

        .footer .right {
            text-align: right;
            flex: 1;
        }

        .footer .right .page-number {
            font-weight: 600;
            color: #07573c;
        }

        /* ============================================
           EMPTY STATE
        ============================================ */
        .empty-state {
            text-align: center;
            padding: 30px 20px;
            color: #6c7a75;
            font-size: 9pt;
        }

        .empty-state .icon {
            font-size: 28pt;
            margin-bottom: 6px;
            opacity: 0.5;
        }

        /* ============================================
           PRINT
        ============================================ */
        @media print {
            body {
                padding: 15px;
            }
            .data-table thead th {
                background: #07573c !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .badge-status,
            .priority,
            .stat-card {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .stat-card .number {
                color: #07573c !important;
            }
            .footer .center .signature-line {
                border-top: 1px solid #1a2a24 !important;
            }
        }
    </style>
</head>
<body>

    {{-- ============================================
        KOP SURAT
    ============================================ --}}
    <div class="letterhead">
        <div class="institution">AKTA<span>LINK</span></div>
        <div class="address">
            DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL KOTA MEDAN
            <br>
            Jalan Kapten Maulana Lubis No. 1, Medan, Sumatera Utara
        </div>
        <div class="title">LAPORAN PERMOHONAN</div>
        <div class="subtitle">Periode: {{ $filterText ?? 'Semua Data' }}</div>
    </div>

    {{-- ============================================
        INFO LAPORAN
    ============================================ --}}
    <div class="report-info">
        <div class="info-left">
            <div class="label">Filter Laporan</div>
            <div class="value">{{ $filterText ?? 'Semua Data' }}</div>
        </div>
        <div class="info-right">
            <div class="label">Tanggal Cetak</div>
            <div class="value">{{ $generatedAt }}</div>
            <div class="label" style="margin-top:4px;">Jumlah Data</div>
            <div class="value">{{ $totalData }} Permohonan</div>
        </div>
    </div>

    {{-- ============================================
        STATISTIK
    ============================================ --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="number">{{ number_format($stats['total']) }}</div>
            <div class="label">Total</div>
        </div>
        <div class="stat-card">
            <div class="number">{{ number_format($stats['selesai']) }}</div>
            <div class="label">Selesai</div>
        </div>
        <div class="stat-card">
            <div class="number">{{ number_format($stats['proses']) }}</div>
            <div class="label">Diproses</div>
        </div>
        <div class="stat-card">
            <div class="number">{{ number_format($stats['menunggu']) }}</div>
            <div class="label">Menunggu</div>
        </div>
    </div>

    {{-- ============================================
        TABEL DATA
    ============================================ --}}
    <div class="table-container">
        <div class="table-title">Daftar Permohonan</div>

        <table class="data-table">
            <thead>
                <tr>
                    <th width="25" class="center">No</th>
                    <th width="110">Nomor Permohonan</th>
                    <th width="120">Nama Pemohon</th>
                    <th width="110">Jenis Layanan</th>
                    <th width="80">Status</th>
                    <th width="70">Prioritas</th>
                    <th width="100">Petugas Loket</th>
                    <th width="85">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($permohonans as $index => $p)
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td><strong>{{ $p->nomor_permohonan }}</strong></td>
                    <td>{{ $p->pemohon->nama_lengkap ?? '-' }}</td>
                    <td>{{ $p->jenisLayanan->nama_layanan ?? '-' }}</td>
                    <td>
                        @php
                            $status = $p->statusPermohonan;
                            $badgeClass = 'default';
                            $badgeLabel = '-';
                            if ($status) {
                                $badgeLabel = $status->nama_status;
                                if ($status->kode_status === 'SELESAI') $badgeClass = 'selesai';
                                elseif ($status->kode_status === 'MENUNGGU') $badgeClass = 'menunggu';
                                elseif ($status->kode_status === 'KURANG_LENGKAP') $badgeClass = 'kurang_lengkap';
                                elseif (in_array($status->kode_status, ['DITERUSKAN', 'DIPROSES'])) $badgeClass = 'diproses';
                            }
                        @endphp
                        <span class="badge-status badge-{{ $badgeClass }}">
                            <span class="dot" style="background: {{ $status->warna ?? '#6c757d' }}"></span>
                            {{ $badgeLabel }}
                        </span>
                    </td>
                    <td>
                        @php
                            $prioritas = $p->prioritas ?? 'normal';
                            $priorityClass = $prioritas;
                        @endphp
                        <span class="priority priority-{{ $priorityClass }}">
                            {{ ucfirst($prioritas) }}
                        </span>
                    </td>
                    <td>{{ $p->petugasLoket->name ?? '-' }}</td>
                    <td>{{ $p->created_at ? $p->created_at->format('d/m/Y') : '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <div class="icon">📋</div>
                            <p>Tidak ada data permohonan yang ditemukan</p>
                            <p style="font-size:7pt;margin-top:4px;">Silakan ubah filter untuk menampilkan data</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ============================================
        FOOTER
    ============================================ --}}
    <div class="footer">
        <div class="left">
            <div class="official">AKTALINK</div>
            <div style="font-size:6.5pt;margin-top:2px;">
                Sistem Informasi Monitoring, Pengelolaan, dan Pengecekan Akta
            </div>
            <div style="font-size:6pt;color:#8a9a94;margin-top:2px;">
                Dokumen ini dicetak secara otomatis oleh sistem
            </div>
        </div>
        <div class="center">
            <div>Dicetak oleh,</div>
            <div class="signature-line"></div>
            <div class="signature-name">{{ auth()->user()->name ?? 'Petugas' }}</div>
            <div class="signature-position">Petugas</div>
        </div>
        <div class="right">
            <div class="page-number">Halaman <span class="pageNumber"></span></div>
            <div style="font-size:6pt;color:#8a9a94;margin-top:4px;">
                {{ now()->format('d/m/Y H:i:s') }}
            </div>
        </div>
    </div>

</body>
</html>