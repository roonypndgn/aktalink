<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Pemohon;
use App\Models\JenisLayanan;
use App\Models\StatusPermohonan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /**
     * Display laporan dashboard.
     */
    public function index(Request $request)
    {
        // ============================================
        // STATISTIK UMUM
        // ============================================
        $stats = [
            'total_permohonan' => Permohonan::count(),
            'total_pemohon' => Pemohon::count(),
            'total_petugas' => User::where('role', '!=', 'admin')->count(),
            'total_admin' => User::where('role', 'admin')->count(),
        ];

        // ============================================
        // STATISTIK PER STATUS
        // ============================================
        $statusStats = StatusPermohonan::withCount('permohonans')
            ->get()
            ->map(function ($status) {
                return [
                    'nama' => $status->nama_status,
                    'warna' => $status->warna ?? '#6c757d',
                    'total' => $status->permohonans_count ?? 0,
                ];
            });

        if ($statusStats->isEmpty()) {
            $statusStats = collect([
                ['nama' => 'Menunggu', 'warna' => '#f59e0b', 'total' => 0],
                ['nama' => 'Diteruskan', 'warna' => '#3b82f6', 'total' => 0],
                ['nama' => 'Diproses', 'warna' => '#8b5cf6', 'total' => 0],
                ['nama' => 'Kurang Lengkap', 'warna' => '#ef4444', 'total' => 0],
                ['nama' => 'Selesai', 'warna' => '#059669', 'total' => 0],
            ]);
        }

        // ============================================
        // STATISTIK PER LAYANAN
        // ============================================
        $layananStats = JenisLayanan::withCount('permohonans')
            ->where('is_active', true)
            ->get()
            ->map(function ($layanan) {
                return [
                    'nama' => $layanan->nama_layanan,
                    'total' => $layanan->permohonans_count ?? 0,
                ];
            });

        if ($layananStats->isEmpty()) {
            $layananStats = collect([
                ['nama' => 'Pengecekan Kehilangan', 'total' => 0],
                ['nama' => 'Kutipan Kedua', 'total' => 0],
                ['nama' => 'Banjir Kepolisian', 'total' => 0],
                ['nama' => 'Keabsahan', 'total' => 0],
                ['nama' => 'Surat Pengantar', 'total' => 0],
            ]);
        }

        // ============================================
        // STATISTIK BULANAN (6 bulan terakhir) - SQLITE COMPATIBLE
        // ============================================
        // SQLite menggunakan strftime untuk ekstrak tahun dan bulan
        $bulanan = Permohonan::select(
                DB::raw("strftime('%Y', created_at) as tahun"),
                DB::raw("strftime('%m', created_at) as bulan"),
                DB::raw("COUNT(*) as total")
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'asc')
            ->orderBy('bulan', 'asc')
            ->get()
            ->map(function ($item) {
                $namaBulan = [
                    '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr',
                    '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Agu',
                    '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des'
                ];
                // Hapus leading zero dari bulan
                $bulan = ltrim($item->bulan, '0');
                return [
                    'bulan' => ($namaBulan[$item->bulan] ?? $item->bulan) . ' ' . $item->tahun,
                    'total' => $item->total,
                ];
            });

        // ============================================
        // PERMOHONAN TERBARU
        // ============================================
        $permohonanTerbaru = Permohonan::with(['pemohon', 'jenisLayanan', 'statusPermohonan'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // ============================================
        // FILTER DATA UNTUK TABEL LAPORAN
        // ============================================
        $laporanPermohonan = Permohonan::with(['pemohon', 'jenisLayanan', 'statusPermohonan', 'petugasLoket'])
            ->when($request->status, function ($query, $status) {
                return $query->where('status_permohonan_id', $status);
            })
            ->when($request->jenis_layanan, function ($query, $layanan) {
                return $query->where('jenis_layanan_id', $layanan);
            })
            ->when($request->date_from, function ($query, $date) {
                return $query->whereDate('created_at', '>=', $date);
            })
            ->when($request->date_to, function ($query, $date) {
                return $query->whereDate('created_at', '<=', $date);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Data untuk filter dropdown
        $statuses = StatusPermohonan::where('is_active', true)->get();
        $layanans = JenisLayanan::where('is_active', true)->get();

        return view('admin.laporan.index', compact(
            'stats',
            'statusStats',
            'layananStats',
            'bulanan',
            'permohonanTerbaru',
            'laporanPermohonan',
            'statuses',
            'layanans'
        ));
    }

    /**
     * Export laporan ke PDF.
     */
    public function exportPdf(Request $request)
    {
        $permohonans = Permohonan::with(['pemohon', 'jenisLayanan', 'statusPermohonan', 'petugasLoket'])
            ->when($request->status, function ($query, $status) {
                return $query->where('status_permohonan_id', $status);
            })
            ->when($request->jenis_layanan, function ($query, $layanan) {
                return $query->where('jenis_layanan_id', $layanan);
            })
            ->when($request->date_from, function ($query, $date) {
                return $query->whereDate('created_at', '>=', $date);
            })
            ->when($request->date_to, function ($query, $date) {
                return $query->whereDate('created_at', '<=', $date);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total' => $permohonans->count(),
            'selesai' => $permohonans->filter(function($item) {
                return $item->statusPermohonan && $item->statusPermohonan->kode_status === 'SELESAI';
            })->count(),
            'proses' => $permohonans->filter(function($item) {
                return $item->statusPermohonan && in_array($item->statusPermohonan->kode_status, ['DITERUSKAN', 'DIPROSES']);
            })->count(),
            'menunggu' => $permohonans->filter(function($item) {
                return $item->statusPermohonan && $item->statusPermohonan->kode_status === 'MENUNGGU';
            })->count(),
        ];

        // Filter info
        $filterText = [];
        if ($request->status) {
            $status = StatusPermohonan::find($request->status);
            if ($status) $filterText[] = 'Status: ' . $status->nama_status;
        }
        if ($request->jenis_layanan) {
            $layanan = JenisLayanan::find($request->jenis_layanan);
            if ($layanan) $filterText[] = 'Layanan: ' . $layanan->nama_layanan;
        }
        if ($request->date_from && $request->date_to) {
            $filterText[] = 'Tanggal: ' . $request->date_from . ' s/d ' . $request->date_to;
        }

        $data = [
            'permohonans' => $permohonans,
            'stats' => $stats,
            'generatedAt' => now()->format('d F Y H:i:s'),
            'totalData' => $permohonans->count(),
            'filterText' => !empty($filterText) ? implode(' | ', $filterText) : 'Semua Data',
        ];

        $pdf = Pdf::loadView('admin.laporan.pdf', $data);
        $pdf->setPaper('A4', 'landscape');

        $pdf->setOptions([
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        return $pdf->download('Laporan_Permohonan_' . date('Y-m-d') . '.pdf');
    }
}