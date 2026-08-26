<?php
namespace App\Http\Controllers\Keabsahan;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Pemohon;
use App\Models\JenisLayanan;
use App\Models\StatusPermohonan;
use App\Models\RiwayatStatus;
use App\Traits\LogsActivity; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    use LogsActivity;
    /**
     * Display dashboard for keabsahan
     */
    public function index()
    {
        // ============================================
        // STATISTIK UTAMA
        // ============================================
        $stats = [
            'total' => Permohonan::whereHas('jenisLayanan', function($q) {
                $q->where('role_tujuan', 'keabsahan');
            })->count(),
            'menunggu' => Permohonan::whereHas('jenisLayanan', function($q) {
                $q->where('role_tujuan', 'keabsahan');
            })->whereHas('statusPermohonan', function($q) {
                $q->where('kode_status', 'DITERUSKAN');
            })->count(),
            'proses' => Permohonan::whereHas('jenisLayanan', function($q) {
                $q->where('role_tujuan', 'keabsahan');
            })->whereHas('statusPermohonan', function($q) {
                $q->where('kode_status', 'DIPROSES');
            })->count(),
            'selesai' => Permohonan::whereHas('jenisLayanan', function($q) {
                $q->where('role_tujuan', 'keabsahan');
            })->whereHas('statusPermohonan', function($q) {
                $q->where('kode_status', 'SELESAI');
            })->count(),
            'kurang_lengkap' => Permohonan::whereHas('jenisLayanan', function($q) {
                $q->where('role_tujuan', 'keabsahan');
            })->whereHas('statusPermohonan', function($q) {
                $q->where('kode_status', 'KURANG_LENGKAP');
            })->count(),
        ];

        // ============================================
        // PERMOHONAN TERBARU
        // ============================================
        $recentPermohonans = Permohonan::with([
            'pemohon',
            'jenisLayanan',
            'statusPermohonan',
            'petugasLoket'
        ])
        ->whereHas('jenisLayanan', function($q) {
            $q->where('role_tujuan', 'keabsahan');
        })
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

        // ============================================
        // PERMOHONAN PER BULAN (Chart)
        // ============================================
        $monthlyData = $this->getMonthlyData();

        // ============================================
        // STATUS DISTRIBUSI (Chart)
        // ============================================
        $statusDistribution = $this->getStatusDistribution();

        // ============================================
        // AKTIVITAS TERBARU (Riwayat Status)
        // ============================================
        $recentActivities = RiwayatStatus::with([
            'permohonan',
            'permohonan.pemohon',
            'permohonan.jenisLayanan',
            'statusBaru',
            'changedBy'
        ])
        ->whereHas('permohonan.jenisLayanan', function($q) {
            $q->where('role_tujuan', 'keabsahan');
        })
        ->orderBy('changed_at', 'desc')
        ->limit(10)
        ->get();

        // ============================================
        // STATISTIK HARI INI
        // ============================================
        $todayStats = [
            'hari_ini' => Permohonan::whereHas('jenisLayanan', function($q) {
                $q->where('role_tujuan', 'keabsahan');
            })->whereDate('created_at', today())->count(),
            'minggu_ini' => Permohonan::whereHas('jenisLayanan', function($q) {
                $q->where('role_tujuan', 'keabsahan');
            })->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'bulan_ini' => Permohonan::whereHas('jenisLayanan', function($q) {
                $q->where('role_tujuan', 'keabsahan');
            })->whereMonth('created_at', now()->month)->count(),
        ];

        // ============================================
        // PERSENTASE
        // ============================================
        $total = $stats['total'] > 0 ? $stats['total'] : 1;
        $percentages = [
            'menunggu' => round(($stats['menunggu'] / $total) * 100),
            'proses' => round(($stats['proses'] / $total) * 100),
            'selesai' => round(($stats['selesai'] / $total) * 100),
            'kurang_lengkap' => round(($stats['kurang_lengkap'] / $total) * 100),
        ];

        return view('keabsahan.dashboard', compact(
            'stats',
            'recentPermohonans',
            'monthlyData',
            'statusDistribution',
            'recentActivities',
            'todayStats',
            'percentages'
        ));
    }

    /**
     * Get monthly data for chart
     */
    private function getMonthlyData()
    {
        $months = collect(range(1, 12))->map(function($month) {
            return [
                'month' => $month,
                'month_name' => date('M', mktime(0, 0, 0, $month, 1)),
                'total' => Permohonan::whereHas('jenisLayanan', function($q) {
                    $q->where('role_tujuan', 'keabsahan');
                })
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', date('Y'))
                ->count(),
            ];
        });

        return $months;
    }

    /**
     * Get status distribution for chart
     */
    private function getStatusDistribution()
    {
        $statuses = StatusPermohonan::where('is_active', true)->get();
        $distribution = [];

        foreach ($statuses as $status) {
            $count = Permohonan::whereHas('jenisLayanan', function($q) {
                $q->where('role_tujuan', 'keabsahan');
            })
            ->where('status_permohonan_id', $status->id)
            ->count();

            if ($count > 0) {
                $distribution[] = [
                    'status' => $status->nama_status,
                    'warna' => $status->warna ?? '#6c757d',
                    'count' => $count,
                ];
            }
        }

        return $distribution;
    }
}