<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Pemohon;
use App\Models\JenisLayanan;
use App\Models\StatusPermohonan;
use App\Models\User;
use App\Models\AktivitasLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard.
     */
    public function index(Request $request)
    {
        // ============================================
        // STATISTIK UTAMA
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

        // ============================================
        // STATISTIK PER LAYANAN (Top 5)
        // ============================================
        $layananStats = JenisLayanan::withCount('permohonans')
            ->where('is_active', true)
            ->orderBy('permohonans_count', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($layanan) {
                return [
                    'nama' => $layanan->nama_layanan,
                    'total' => $layanan->permohonans_count ?? 0,
                ];
            });

        // ============================================
        // TREN BULANAN (6 bulan terakhir) - SQLITE COMPATIBLE
        // ============================================
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
                return [
                    'bulan' => ($namaBulan[$item->bulan] ?? $item->bulan) . ' ' . $item->tahun,
                    'total' => $item->total,
                ];
            });

        // ============================================
        // PERMOHONAN TERBARU (5 data)
        // ============================================
        $permohonanTerbaru = Permohonan::with(['pemohon', 'jenisLayanan', 'statusPermohonan'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // ============================================
        // AKTIVITAS TERBARU (5 data)
        // ============================================
        $aktivitasTerbaru = AktivitasLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // ============================================
        // STATISTIK HARI INI
        // ============================================
        $hariIni = [
            'permohonan' => Permohonan::whereDate('created_at', today())->count(),
            'pemohon' => Pemohon::whereDate('created_at', today())->count(),
            'aktivitas' => AktivitasLog::whereDate('created_at', today())->count(),
            'selesai' => Permohonan::whereDate('created_at', today())
                ->whereHas('statusPermohonan', function($q) {
                    $q->where('kode_status', 'SELESAI');
                })->count(),
        ];

        // ============================================
        // PERSENTASE PERUBAHAN (vs bulan lalu)
        // ============================================
        $bulanLalu = now()->subMonth();
        $bulanIni = Permohonan::whereMonth('created_at', now()->month)->count();
        $bulanLaluCount = Permohonan::whereMonth('created_at', $bulanLalu->month)->count();
        $persentase = $bulanLaluCount > 0 ? round((($bulanIni - $bulanLaluCount) / $bulanLaluCount) * 100, 1) : 0;

        return view('admin.dashboard.index', compact(
            'stats',
            'statusStats',
            'layananStats',
            'bulanan',
            'permohonanTerbaru',
            'aktivitasTerbaru',
            'hariIni',
            'persentase'
        ));
    }
}