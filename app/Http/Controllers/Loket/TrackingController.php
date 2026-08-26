<?php
namespace App\Http\Controllers\Loket;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Pemohon;
use App\Models\StatusPermohonan;
use App\Traits\LogsActivity; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TrackingController extends Controller
{
    use LogsActivity;
    /**
     * Display tracking page
     */
    public function index(Request $request)
    {
        $result = null;
        $searchType = $request->search_type ?? 'nomor';
        $searchValue = $request->search_value ?? '';

        if ($searchValue) {
            $result = $this->searchPermohonan($searchType, $searchValue);
        }

        // Statistik untuk dashboard tracking
        $stats = [
            'total' => Permohonan::count(),
            'menunggu' => Permohonan::perluDiteruskan()->count(),
            'proses' => Permohonan::sedangDiproses()->count(),
            'selesai' => Permohonan::selesai()->count(),
        ];

        // Status terbaru untuk tracking
        $recentStatuses = StatusPermohonan::where('is_active', true)->get();

        return view('loket.tracking.index', compact(
            'result',
            'searchType',
            'searchValue',
            'stats',
            'recentStatuses'
        ));
    }

    /**
     * Search permohonan by nomor or NIK
     */
    private function searchPermohonan($type, $value)
    {
        $query = Permohonan::with([
            'pemohon',
            'jenisLayanan',
            'statusPermohonan',
            'petugasLoket',
            'riwayatStatus.statusLama',
            'riwayatStatus.statusBaru',
            'riwayatStatus.changedBy',
            'dokumen',
            'komentar.user'
        ]);

        if ($type === 'nomor') {
            $query->where('nomor_permohonan', 'LIKE', "%{$value}%");
        } else {
            $query->whereHas('pemohon', function($q) use ($value) {
                $q->where('nik', 'LIKE', "%{$value}%")
                  ->orWhere('nama_lengkap', 'LIKE', "%{$value}%");
            });
        }

        $results = $query->orderBy('created_at', 'desc')->get();

        if ($results->count() === 0) {
            return null;
        }

        // Jika hanya 1 hasil, tampilkan detail langsung
        if ($results->count() === 1) {
            return $results->first();
        }

        // Jika lebih dari 1, tampilkan list
        return $results;
    }

    /**
     * Get tracking detail via AJAX
     */
    public function detail(Request $request)
    {
        try {
            $permohonan = Permohonan::with([
                'pemohon',
                'jenisLayanan',
                'statusPermohonan',
                'petugasLoket',
                'riwayatStatus.statusLama',
                'riwayatStatus.statusBaru',
                'riwayatStatus.changedBy',
                'dokumen',
                'komentar.user'
            ])->find($request->id);

            if (!$permohonan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Permohonan tidak ditemukan.'
                ], 404);
            }

            // Format riwayat status untuk timeline
            $timeline = $permohonan->riwayatStatus->map(function($item) {
                return [
                    'status' => $item->statusBaru->nama_status,
                    'warna' => $item->statusBaru->warna ?? '#6c757d',
                    'keterangan' => $item->keterangan,
                    'changed_by' => $item->changedBy->name ?? 'Sistem',
                    'changed_at' => $item->changed_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i'),
                    'is_last' => false,
                ];
            });

            // Tambahkan status saat ini sebagai yang terakhir
            $timeline->prepend([
                'status' => $permohonan->statusPermohonan->nama_status,
                'warna' => $permohonan->statusPermohonan->warna ?? '#6c757d',
                'keterangan' => 'Status saat ini',
                'changed_by' => 'Sistem',
                'changed_at' => $permohonan->updated_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i'),
                'is_last' => true,
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'permohonan' => $permohonan,
                    'timeline' => $timeline,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error tracking detail: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tracking by QR Code atau link
     */
    public function trackByToken($token)
    {
        // Decrypt token atau cari berdasarkan token
        $permohonan = Permohonan::where('nomor_permohonan', $token)->first();

        if (!$permohonan) {
            abort(404, 'Permohonan tidak ditemukan.');
        }

        return view('loket.tracking.public', compact('permohonan'));
    }

    /**
     * Get tracking statistics
     */
    public function stats()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'total' => Permohonan::count(),
                'menunggu' => Permohonan::perluDiteruskan()->count(),
                'proses' => Permohonan::sedangDiproses()->count(),
                'selesai' => Permohonan::selesai()->count(),
                'hari_ini' => Permohonan::whereDate('created_at', today())->count(),
                'minggu_ini' => Permohonan::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
                'bulan_ini' => Permohonan::whereMonth('created_at', now()->month)->count(),
            ]
        ]);
    }
}