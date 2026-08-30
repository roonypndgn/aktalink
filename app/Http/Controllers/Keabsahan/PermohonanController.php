<?php
namespace App\Http\Controllers\Keabsahan;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Pemohon;
use App\Models\JenisLayanan;
use App\Models\StatusPermohonan;
use App\Models\RiwayatStatus;
use App\Models\PermohonanDokumen;
use App\Models\JenisDokumen;
use App\Models\User;
use App\Models\KomentarPermohonan;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PermohonanController extends Controller
{
    use LogsActivity;

    /**
     * Display a listing of permohonan.
     */
    public function index(Request $request)
    {
        $permohonans = Permohonan::with([
            'pemohon',
            'jenisLayanan',
            'statusPermohonan',
            'petugasLoket',
            'dokumen',
            'komentar.user'
        ])
        ->whereHas('jenisLayanan', function($query) {
            $query->where('role_tujuan', 'keabsahan');
        })
        ->filter($request->all())
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->withQueryString();

        $stats = $this->getStats();

        $statuses = StatusPermohonan::where('is_active', true)->get();
        $layanans = JenisLayanan::where('is_active', true)->where('role_tujuan', 'keabsahan')->get();
        $prioritas = ['normal', 'penting', 'urgent'];
        $pemohons = Pemohon::orderBy('nama_lengkap')->get();
        $jenisDokumens = JenisDokumen::where('is_active', true)->get();

        return view('keabsahan.permohonan.index', compact(
            'permohonans',
            'stats',
            'statuses',
            'layanans',
            'prioritas',
            'pemohons',
            'jenisDokumens'
        ));
    }

    /**
     * Display permohonan yang perlu diproses
     */
    public function perluDiproses(Request $request)
    {
        $permohonans = Permohonan::with([
            'pemohon',
            'jenisLayanan',
            'statusPermohonan',
            'petugasLoket',
            'dokumen',
            'komentar.user'
        ])
        ->whereHas('jenisLayanan', function($query) {
            $query->where('role_tujuan', 'keabsahan');
        })
        ->whereHas('statusPermohonan', function($query) {
            $query->where('kode_status', 'DITERUSKAN');
        })
        ->filter($request->all())
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->withQueryString();

        $stats = $this->getStats();
        $statuses = StatusPermohonan::where('is_active', true)->get();
        $layanans = JenisLayanan::where('is_active', true)->where('role_tujuan', 'keabsahan')->get();
        $prioritas = ['normal', 'penting', 'urgent'];
        $pemohons = Pemohon::orderBy('nama_lengkap')->get();
        $jenisDokumens = JenisDokumen::where('is_active', true)->get();

        return view('keabsahan.permohonan.index', compact(
            'permohonans',
            'stats',
            'statuses',
            'layanans',
            'prioritas',
            'pemohons',
            'jenisDokumens'
        ));
    }

    /**
     * Display permohonan sedang diproses
     */
    public function sedangDiproses(Request $request)
    {
        $permohonans = Permohonan::with([
            'pemohon',
            'jenisLayanan',
            'statusPermohonan',
            'petugasLoket',
            'dokumen',
            'komentar.user'
        ])
        ->whereHas('jenisLayanan', function($query) {
            $query->where('role_tujuan', 'keabsahan');
        })
        ->whereHas('statusPermohonan', function($query) {
            $query->where('kode_status', 'DIPROSES');
        })
        ->filter($request->all())
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->withQueryString();

        $stats = $this->getStats();
        $statuses = StatusPermohonan::where('is_active', true)->get();
        $layanans = JenisLayanan::where('is_active', true)->where('role_tujuan', 'keabsahan')->get();
        $prioritas = ['normal', 'penting', 'urgent'];
        $pemohons = Pemohon::orderBy('nama_lengkap')->get();
        $jenisDokumens = JenisDokumen::where('is_active', true)->get();

        return view('keabsahan.permohonan.index', compact(
            'permohonans',
            'stats',
            'statuses',
            'layanans',
            'prioritas',
            'pemohons',
            'jenisDokumens'
        ));
    }

    /**
     * Display permohonan selesai
     */
    public function selesai(Request $request)
    {
        $permohonans = Permohonan::with([
            'pemohon',
            'jenisLayanan',
            'statusPermohonan',
            'petugasLoket',
            'dokumen',
            'komentar.user'
        ])
        ->whereHas('jenisLayanan', function($query) {
            $query->where('role_tujuan', 'keabsahan');
        })
        ->whereHas('statusPermohonan', function($query) {
            $query->where('kode_status', 'SELESAI');
        })
        ->filter($request->all())
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->withQueryString();

        $stats = $this->getStats();
        $statuses = StatusPermohonan::where('is_active', true)->get();
        $layanans = JenisLayanan::where('is_active', true)->where('role_tujuan', 'keabsahan')->get();
        $prioritas = ['normal', 'penting', 'urgent'];
        $pemohons = Pemohon::orderBy('nama_lengkap')->get();
        $jenisDokumens = JenisDokumen::where('is_active', true)->get();

        return view('keabsahan.permohonan.index', compact(
            'permohonans',
            'stats',
            'statuses',
            'layanans',
            'prioritas',
            'pemohons',
            'jenisDokumens'
        ));
    }

    /**
     * Get statistics
     */
    private function getStats()
    {
        return [
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
    }

    /**
     * Display detail permohonan
     */
    public function show(Permohonan $permohonan)
    {
        // Cek apakah permohonan ini untuk keabsahan
        if ($permohonan->jenisLayanan->role_tujuan !== 'keabsahan') {
            abort(403, 'Anda tidak memiliki akses ke permohonan ini.');
        }

        $permohonan->load([
            'pemohon',
            'jenisLayanan',
            'statusPermohonan',
            'petugasLoket',
            'dokumen.jenisDokumen',
            'dokumen.uploadedBy',
            'riwayatStatus.statusLama',
            'riwayatStatus.statusBaru',
            'riwayatStatus.changedBy',
            'komentar.user',
            'petugasPenanganan.user',
            'hasilPemeriksaan',
        ]);

        $statuses = StatusPermohonan::where('is_active', true)->get();
        $jenisDokumens = JenisDokumen::where('is_active', true)->get();

        return view('keabsahan.permohonan.show', compact('permohonan', 'statuses', 'jenisDokumens'));
    }

    /**
     * Update status permohonan
     */
    public function updateStatus(Request $request, Permohonan $permohonan)
    {
        try {
            $validator = Validator::make($request->all(), [
                'status_permohonan_id' => 'required|exists:status_permohonans,id',
                'keterangan' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // Cek apakah permohonan ini untuk keabsahan
            if ($permohonan->jenisLayanan->role_tujuan !== 'keabsahan') {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses ke permohonan ini.'
                ], 403);
            }

            DB::beginTransaction();

            $oldStatusId = $permohonan->status_permohonan_id;
            $newStatusId = $request->status_permohonan_id;
            $newStatus = StatusPermohonan::find($newStatusId);

            $permohonan->update([
                'status_permohonan_id' => $newStatusId,
            ]);

            // Jika status selesai, update tanggal selesai
            if ($newStatus && $newStatus->kode_status === 'SELESAI') {
                $permohonan->update(['tanggal_selesai' => now()]);
            }

            // Catat riwayat status
            RiwayatStatus::create([
                'permohonan_id' => $permohonan->id,
                'status_lama_id' => $oldStatusId,
                'status_baru_id' => $newStatusId,
                'changed_by' => auth()->id(),
                'keterangan' => $request->keterangan ?? 'Status diperbarui oleh petugas keabsahan',
                'changed_at' => now(),
            ]);

            DB::commit();

            $this->logWithSubject(
                'Update status permohonan (Keabsahan)',
                $permohonan,
                'Status baru: ' . ($newStatus ? $newStatus->nama_status : '') . ' | Nomor: ' . $permohonan->nomor_permohonan
            );

            return response()->json([
                'success' => true,
                'message' => 'Status permohonan berhasil diperbarui!',
                'data' => $permohonan->fresh(['statusPermohonan'])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error update status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tambah komentar pada permohonan
     */
    public function tambahKomentar(Request $request, Permohonan $permohonan)
    {
        try {
            $validator = Validator::make($request->all(), [
                'komentar' => 'required|string|max:1000',
                'is_internal' => 'nullable|boolean',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // Cek apakah permohonan ini untuk keabsahan
            if ($permohonan->jenisLayanan->role_tujuan !== 'keabsahan') {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses ke permohonan ini.'
                ], 403);
            }

            $komentar = KomentarPermohonan::create([
                'permohonan_id' => $permohonan->id,
                'user_id' => auth()->id(),
                'komentar' => $request->komentar,
                'is_internal' => $request->is_internal ?? true,
            ]);

            $this->logWithSubject(
                'Menambah komentar (Keabsahan)',
                $komentar,
                'Komentar: ' . substr($komentar->komentar, 0, 50) . ' | Permohonan: ' . $permohonan->nomor_permohonan
            );

            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil ditambahkan!',
                'data' => $komentar->load('user')
            ]);

        } catch (\Exception $e) {
            Log::error('Error tambah komentar: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get komentar permohonan
     */
    public function getKomentar(Permohonan $permohonan)
    {
        try {
            $komentar = $permohonan->komentar()
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $komentar
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Proses permohonan (ubah status dari DITERUSKAN ke DIPROSES)
     */
    public function proses(Request $request, Permohonan $permohonan)
    {
        try {
            // Cek apakah permohonan ini untuk keabsahan
            if ($permohonan->jenisLayanan->role_tujuan !== 'keabsahan') {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses ke permohonan ini.'
                ], 403);
            }

            // Cek status saat ini harus DITERUSKAN
            if ($permohonan->statusPermohonan->kode_status !== 'DITERUSKAN') {
                return response()->json([
                    'success' => false,
                    'message' => 'Permohonan ini tidak dapat diproses. Status saat ini: ' . $permohonan->statusPermohonan->nama_status
                ], 422);
            }

            DB::beginTransaction();

            $statusDiproses = StatusPermohonan::where('kode_status', 'DIPROSES')->first();
            if (!$statusDiproses) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status DIPROSES tidak ditemukan.'
                ], 500);
            }

            $oldStatusId = $permohonan->status_permohonan_id;

            $permohonan->update([
                'status_permohonan_id' => $statusDiproses->id,
            ]);

            // Catat riwayat status
            RiwayatStatus::create([
                'permohonan_id' => $permohonan->id,
                'status_lama_id' => $oldStatusId,
                'status_baru_id' => $statusDiproses->id,
                'changed_by' => auth()->id(),
                'keterangan' => $request->keterangan ?? 'Permohonan diproses oleh petugas keabsahan',
                'changed_at' => now(),
            ]);

            DB::commit();

            $this->logWithSubject(
                'Memproses permohonan (Keabsahan)',
                $permohonan,
                'Nomor: ' . $permohonan->nomor_permohonan
            );

            return response()->json([
                'success' => true,
                'message' => 'Permohonan berhasil diproses!',
                'data' => $permohonan->fresh(['statusPermohonan'])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error proses permohonan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * UPLOAD DOKUMEN - Optional
     */
    public function uploadDokumen(Request $request, Permohonan $permohonan)
    {
        try {
            Log::info('=== UPLOAD DOKUMEN KEABSAHAN ===');
            Log::info('Permohonan ID: ' . $permohonan->id);

            // Cek apakah permohonan ini untuk keabsahan
            if ($permohonan->jenisLayanan->role_tujuan !== 'keabsahan') {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses ke permohonan ini.'
                ], 403);
            }

            $validator = Validator::make($request->all(), [
                'dokumen' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
                'nama_dokumen' => 'nullable|string|max:150',
                'jenis_dokumen_id' => 'nullable|exists:jenis_dokumens,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // Jika tidak ada file yang diupload, return error
            if (!$request->hasFile('dokumen')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan pilih file yang akan diupload.'
                ], 422);
            }

            $file = $request->file('dokumen');
            
            if (!$file->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'File tidak valid.'
                ], 422);
            }

            $namaDokumen = $request->nama_dokumen ?? $file->getClientOriginalName();
            $jenisDokumenId = $request->jenis_dokumen_id ?? null;

            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . uniqid() . '.' . $extension;
            $path = 'permohonan/' . $permohonan->id . '/dokumen';

            // Simpan file
            $stored = Storage::disk('public')->putFileAs($path, $file, $fileName);

            if (!$stored) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan file.'
                ], 500);
            }

            // Simpan ke database
            $dokumen = PermohonanDokumen::create([
                'permohonan_id' => $permohonan->id,
                'jenis_dokumen_id' => $jenisDokumenId,
                'nama_dokumen' => $namaDokumen,
                'file_name' => $fileName,
                'file_path' => $stored,
                'file_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'status_verifikasi' => 'menunggu',
                'uploaded_by' => auth()->id(),
            ]);

            $this->logWithSubject(
                'Upload dokumen (Keabsahan)',
                $dokumen,
                'Dokumen: ' . $namaDokumen . ' | Permohonan: ' . $permohonan->nomor_permohonan
            );

            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil diupload!',
                'data' => $dokumen,
                'file_url' => asset('storage/' . $stored)
            ]);

        } catch (\Exception $e) {
            Log::error('Error upload dokumen keabsahan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * DELETE DOKUMEN
     */
    public function deleteDokumen(Permohonan $permohonan, $dokumenId)
    {
        try {
            // Cek apakah permohonan ini untuk keabsahan
            if ($permohonan->jenisLayanan->role_tujuan !== 'keabsahan') {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses ke permohonan ini.'
                ], 403);
            }

            $dokumen = PermohonanDokumen::where('permohonan_id', $permohonan->id)
                ->where('id', $dokumenId)
                ->first();

            if (!$dokumen) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dokumen tidak ditemukan.'
                ], 404);
            }

            // Hapus file dari storage
            if ($dokumen->file_path && Storage::disk('public')->exists($dokumen->file_path)) {
                Storage::disk('public')->delete($dokumen->file_path);
            }

            $dokumen->delete();

            $this->logWithSubject(
                'Menghapus dokumen (Keabsahan)',
                $dokumen,
                'Dokumen: ' . $dokumen->nama_dokumen . ' | Permohonan: ' . $permohonan->nomor_permohonan
            );

            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil dihapus!'
            ]);

        } catch (\Exception $e) {
            Log::error('Error delete dokumen keabsahan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}