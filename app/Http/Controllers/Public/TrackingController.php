<?php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Pemohon;
use App\Models\StatusPermohonan;
use App\Traits\LogsActivity; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TrackingController extends Controller
{
    use LogsActivity;
    /**
     * Display public tracking page
     */
    public function index(Request $request)
    {
        $result = null;
        $searchValue = $request->search_value ?? '';
        $error = null;

        if ($searchValue) {
            $result = $this->searchByNIK($searchValue);
            if (!$result) {
                $error = 'Data permohonan tidak ditemukan untuk NIK tersebut.';
            }
        }

        return view('public.tracking.index', compact('result', 'searchValue', 'error'));
    }

    /**
     * Search permohonan by NIK
     */
    private function searchByNIK($nik)
    {
        // Cari pemohon berdasarkan NIK
        $pemohon = Pemohon::where('nik', $nik)->first();

        if (!$pemohon) {
            return null;
        }

        // Ambil semua permohonan pemohon
        $permohonans = Permohonan::with([
            'jenisLayanan',
            'statusPermohonan',
            'riwayatStatus.statusLama',
            'riwayatStatus.statusBaru',
            'riwayatStatus.changedBy',
            'dokumen'
        ])
        ->where('pemohon_id', $pemohon->id)
        ->orderBy('created_at', 'desc')
        ->get();

        if ($permohonans->isEmpty()) {
            return null;
        }

        return [
            'pemohon' => $pemohon,
            'permohonans' => $permohonans
        ];
    }

    /**
     * Get tracking detail via AJAX
     */
    public function detail(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:permohonans,id',
                'nik' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parameter tidak valid.'
                ], 422);
            }

            // Verifikasi bahwa permohonan milik pemohon dengan NIK tersebut
            $permohonan = Permohonan::with([
                'pemohon',
                'jenisLayanan',
                'statusPermohonan',
                'riwayatStatus.statusLama',
                'riwayatStatus.statusBaru',
                'riwayatStatus.changedBy',
                'dokumen'
            ])->find($request->id);

            if (!$permohonan || $permohonan->pemohon->nik !== $request->nik) {
                return response()->json([
                    'success' => false,
                    'message' => 'Permohonan tidak ditemukan atau tidak sesuai dengan NIK.'
                ], 404);
            }

            // Format timeline
            $timeline = $permohonan->riwayatStatus->map(function($item) {
                return [
                    'status' => $item->statusBaru->nama_status,
                    'warna' => $item->statusBaru->warna ?? '#6c757d',
                    'keterangan' => $item->keterangan,
                    'changed_by' => $item->changedBy->name ?? 'Sistem',
                    'changed_at' => $item->changed_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i'),
                ];
            });

            // Tambahkan status saat ini
            $timeline->prepend([
                'status' => $permohonan->statusPermohonan->nama_status,
                'warna' => $permohonan->statusPermohonan->warna ?? '#6c757d',
                'keterangan' => 'Status saat ini',
                'changed_by' => 'Sistem',
                'changed_at' => $permohonan->updated_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i'),
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
     * Get status list untuk dropdown
     */
    public function statusList()
    {
        $statuses = StatusPermohonan::where('is_active', true)
            ->select('id', 'nama_status', 'warna', 'kode_status')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $statuses
        ]);
    }
}