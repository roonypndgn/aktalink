<?php

namespace App\Http\Controllers\Loket;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Pemohon;
use App\Models\JenisLayanan;
use App\Models\StatusPermohonan;
use App\Models\User;
use App\Models\RiwayatStatus;
use App\Models\PermohonanPetugas;
use App\Models\PermohonanDokumen;
use App\Models\JenisDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PermohonanController extends Controller
{
    /**
     * Display a listing of all permohonan.
     */
    public function index(Request $request)
    {
        $permohonans = Permohonan::with([
            'pemohon',
            'jenisLayanan',
            'statusPermohonan',
            'petugasLoket',
            'dokumen'
        ])
        ->filter($request->all())
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->withQueryString();

        $stats = [
            'total' => Permohonan::count(),
            'menunggu' => Permohonan::perluDiteruskan()->count(),
            'proses' => Permohonan::sedangDiproses()->count(),
            'selesai' => Permohonan::selesai()->count(),
        ];

        $statuses = StatusPermohonan::where('is_active', true)->get();
        $layanans = JenisLayanan::where('is_active', true)->get();
        $prioritas = ['normal', 'penting', 'urgent'];
        $pemohons = Pemohon::orderBy('nama_lengkap')->get();
        $jenisDokumens = JenisDokumen::where('is_active', true)->get();

        $roleTujuan = JenisLayanan::where('is_active', true)
            ->pluck('role_tujuan', 'id')
            ->toArray();

        return view('loket.permohonan.index', compact(
            'permohonans',
            'stats',
            'statuses',
            'layanans',
            'prioritas',
            'pemohons',
            'jenisDokumens',
            'roleTujuan'
        ));
    }

    /**
     * Store a newly created permohonan (TANPA DOKUMEN).
     */
    public function store(Request $request)
    {
        Log::info('Store permohonan dipanggil', $request->all());

        $validator = Validator::make($request->all(), [
            'pemohon_id' => 'required|exists:pemohons,id',
            'jenis_layanan_id' => 'required|exists:jenis_layanans,id',
            'status_permohonan_id' => 'required|exists:status_permohonans,id',
            'judul_permohonan' => 'nullable|string|max:200',
            'keterangan' => 'required|string',
            'prioritas' => 'required|in:normal,penting,urgent',
            'catatan_loket' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            $permohonan = Permohonan::create([
                'nomor_permohonan' => Permohonan::generateNomor(),
                'pemohon_id' => $request->pemohon_id,
                'jenis_layanan_id' => $request->jenis_layanan_id,
                'status_permohonan_id' => $request->status_permohonan_id,
                'petugas_loket_id' => auth()->id(),
                'judul_permohonan' => $request->judul_permohonan ?? 'Permohonan ' . date('d-m-Y'),
                'keterangan' => $request->keterangan,
                'prioritas' => $request->prioritas,
                'tanggal_permohonan' => now(),
                'catatan_loket' => $request->catatan_loket ?? null,
            ]);

            RiwayatStatus::create([
                'permohonan_id' => $permohonan->id,
                'status_baru_id' => $request->status_permohonan_id,
                'changed_by' => auth()->id(),
                'keterangan' => 'Permohonan dibuat oleh petugas loket',
                'changed_at' => now(),
            ]);

            // ============================================
            // DISTRIBUSI OTOMATIS
            // ============================================
            $distribusiStatus = 'tidak_dikirim';
            $petugasTujuan = null;

            $status = StatusPermohonan::find($request->status_permohonan_id);
            if ($status && $status->kode_status === 'MENUNGGU') {
                $layanan = $permohonan->jenisLayanan;
                if ($layanan && $layanan->role_tujuan) {
                    $petugasTujuan = User::where('role', $layanan->role_tujuan)
                        ->where('is_active', true)
                        ->first();

                    if ($petugasTujuan) {
                        PermohonanPetugas::create([
                            'permohonan_id' => $permohonan->id,
                            'user_id' => $petugasTujuan->id,
                            'assigned_by' => auth()->id(),
                            'assigned_at' => now(),
                            'is_active' => true,
                        ]);

                        $statusDiteruskan = StatusPermohonan::where('kode_status', 'DITERUSKAN')->first();
                        if ($statusDiteruskan) {
                            $permohonan->update([
                                'status_permohonan_id' => $statusDiteruskan->id,
                                'tanggal_diteruskan' => now(),
                            ]);

                            RiwayatStatus::create([
                                'permohonan_id' => $permohonan->id,
                                'status_lama_id' => $request->status_permohonan_id,
                                'status_baru_id' => $statusDiteruskan->id,
                                'changed_by' => auth()->id(),
                                'keterangan' => 'Permohonan diteruskan ke ' . $petugasTujuan->role_label,
                                'changed_at' => now(),
                            ]);

                            $distribusiStatus = 'dikirim';
                        }
                    } else {
                        $distribusiStatus = 'tidak_ada_petugas';
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Permohonan berhasil ditambahkan! Nomor: ' . $permohonan->nomor_permohonan,
                'data' => $permohonan,
                'distribusi' => [
                    'status' => $distribusiStatus,
                    'petugas' => $petugasTujuan ? $petugasTujuan->name : null,
                    'role' => $petugasTujuan ? $petugasTujuan->role_label : null,
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error store permohonan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
 * UPLOAD DOKUMEN - DENGAN LOGGING DETAIL
 */
public function uploadDokumen(Request $request, Permohonan $permohonan)
{
    try {
        // VALIDASI
        $validator = Validator::make($request->all(), [
            'dokumen' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'nama_dokumen' => 'nullable|string|max:150',
            'jenis_dokumen_id' => 'nullable|exists:jenis_dokumens,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        if (!$request->hasFile('dokumen')) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada file yang diupload.'
            ], 422);
        }

        $file = $request->file('dokumen');
        
        if (!$file->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'File tidak valid.'
            ], 422);
        }

        // ============================================
        // SIMPAN KE PUBLIC FOLDER LANGSUNG
        // ============================================
        $namaDokumen = $request->nama_dokumen ?? $file->getClientOriginalName();
        $jenisDokumenId = $request->jenis_dokumen_id ?? null;

        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $filePath = 'uploads/dokumen/' . $permohonan->id;

        // Buat folder di public
        $directory = public_path($filePath);
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        // Pindahkan file ke public folder
        $file->move($directory, $fileName);

        // Cek apakah file berhasil
        if (!file_exists($directory . '/' . $fileName)) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan file.'
            ], 500);
        }

        // Simpan ke database (path relatif dari public)
        $dokumen = PermohonanDokumen::create([
            'permohonan_id' => $permohonan->id,
            'jenis_dokumen_id' => $jenisDokumenId,
            'nama_dokumen' => $namaDokumen,
            'file_name' => $fileName,
            'file_path' => $filePath . '/' . $fileName,
            'file_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'status_verifikasi' => 'menunggu',
            'uploaded_by' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Dokumen berhasil diupload!',
            'data' => $dokumen
        ]);

    } catch (\Exception $e) {
        Log::error('Error upload: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
}
public function uploadDokumenSimple(Request $request, Permohonan $permohonan)
{
    // Validasi
    $validator = Validator::make($request->all(), [
        'dokumen' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        'nama_dokumen' => 'nullable|string|max:150',
        'jenis_dokumen_id' => 'nullable|exists:jenis_dokumens,id',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->with('error', 'Validasi gagal: ' . $validator->errors()->first())
            ->withInput();
    }

    try {
        if (!$request->hasFile('dokumen')) {
            return redirect()->back()->with('error', 'Tidak ada file yang diupload.');
        }

        $file = $request->file('dokumen');
        
        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid.');
        }

        // ============================================
        // SIMPAN FILE KE PUBLIC FOLDER
        // ============================================
        $namaDokumen = $request->nama_dokumen ?? $file->getClientOriginalName();
        $jenisDokumenId = $request->jenis_dokumen_id ?? null;

        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $filePath = 'uploads/dokumen/' . $permohonan->id;

        // Buat folder
        $directory = public_path($filePath);
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        // Pindahkan file
        $file->move($directory, $fileName);

        // Simpan ke database
        PermohonanDokumen::create([
            'permohonan_id' => $permohonan->id,
            'jenis_dokumen_id' => $jenisDokumenId,
            'nama_dokumen' => $namaDokumen,
            'file_name' => $fileName,
            'file_path' => $filePath . '/' . $fileName,
            'file_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'status_verifikasi' => 'menunggu',
            'uploaded_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Dokumen berhasil diupload!');

    } catch (\Exception $e) {
        Log::error('Error upload: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}
    /**
     * DELETE DOKUMEN
     */
    public function deleteDokumen(Permohonan $permohonan, $dokumenId)
{
    try {
        $dokumen = PermohonanDokumen::where('permohonan_id', $permohonan->id)
            ->where('id', $dokumenId)
            ->first();

        if (!$dokumen) {
            return redirect()->back()->with('error', 'Dokumen tidak ditemukan.');
        }

        // Hapus file
        $fullPath = public_path('storage/' . $dokumen->file_path);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        $dokumen->delete();

        return redirect()->back()->with('success', 'Dokumen berhasil dihapus!');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

    /**
     * Display the specified permohonan.
     */
    public function show(Permohonan $permohonan)
    {
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
            'hasilPemeriksaan.statusHasil',
            'hasilPemeriksaan.diperiksaOleh',
            'petugasPenanganan.user',
            'petugasPenanganan.assignedBy',
        ]);

        return view('loket.permohonan.show', compact('permohonan'));
    }

    /**
     * Show the form for editing the specified permohonan.
     */
    public function edit(Permohonan $permohonan)
    {
        $pemohons = Pemohon::orderBy('nama_lengkap')->get();
        $layanans = JenisLayanan::where('is_active', true)->get();
        $statuses = StatusPermohonan::where('is_active', true)->get();

        return response()->json([
            'success' => true,
            'data' => $permohonan,
            'pemohons' => $pemohons,
            'layanans' => $layanans,
            'statuses' => $statuses
        ]);
    }

    /**
     * Update the specified permohonan.
     */
    public function update(Request $request, Permohonan $permohonan)
    {
        $validator = Validator::make($request->all(), [
            'pemohon_id' => 'required|exists:pemohons,id',
            'jenis_layanan_id' => 'required|exists:jenis_layanans,id',
            'status_permohonan_id' => 'required|exists:status_permohonans,id',
            'judul_permohonan' => 'nullable|string|max:200',
            'keterangan' => 'required|string',
            'prioritas' => 'required|in:normal,penting,urgent',
            'catatan_loket' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            $oldStatusId = $permohonan->status_permohonan_id;
            $newStatusId = $request->status_permohonan_id;

            $permohonan->update([
                'pemohon_id' => $request->pemohon_id,
                'jenis_layanan_id' => $request->jenis_layanan_id,
                'status_permohonan_id' => $newStatusId,
                'judul_permohonan' => $request->judul_permohonan,
                'keterangan' => $request->keterangan,
                'prioritas' => $request->prioritas,
                'catatan_loket' => $request->catatan_loket,
            ]);

            if ($oldStatusId != $newStatusId) {
                RiwayatStatus::create([
                    'permohonan_id' => $permohonan->id,
                    'status_lama_id' => $oldStatusId,
                    'status_baru_id' => $newStatusId,
                    'changed_by' => auth()->id(),
                    'keterangan' => 'Status diperbarui oleh petugas loket',
                    'changed_at' => now(),
                ]);

                $status = StatusPermohonan::find($newStatusId);
                if ($status && $status->kode_status === 'SELESAI') {
                    $permohonan->update(['tanggal_selesai' => now()]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Permohonan berhasil diperbarui!',
                'data' => $permohonan
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified permohonan.
     */
    public function destroy(Permohonan $permohonan)
    {
        try {
            // Hapus semua dokumen
            foreach ($permohonan->dokumen as $dokumen) {
                $fullPath = storage_path('app/public/' . $dokumen->file_path);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }

            $nomor = $permohonan->nomor_permohonan;
            $permohonan->delete();

            return response()->json([
                'success' => true,
                'message' => "Permohonan {$nomor} berhasil dihapus!"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // ============================================
    // SUB MENU METHODS
    // ============================================

    public function perluDiteruskan(Request $request)
    {
        $permohonans = Permohonan::with([
            'pemohon',
            'jenisLayanan',
            'statusPermohonan',
            'petugasLoket',
            'dokumen'
        ])
        ->perluDiteruskan()
        ->filter($request->all())
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->withQueryString();

        $stats = [
            'total' => Permohonan::count(),
            'menunggu' => Permohonan::perluDiteruskan()->count(),
            'proses' => Permohonan::sedangDiproses()->count(),
            'selesai' => Permohonan::selesai()->count(),
        ];

        $statuses = StatusPermohonan::where('is_active', true)->get();
        $layanans = JenisLayanan::where('is_active', true)->get();
        $prioritas = ['normal', 'penting', 'urgent'];
        $pemohons = Pemohon::orderBy('nama_lengkap')->get();
        $jenisDokumens = JenisDokumen::where('is_active', true)->get();
        $roleTujuan = JenisLayanan::where('is_active', true)->pluck('role_tujuan', 'id')->toArray();

        return view('loket.permohonan.index', compact(
            'permohonans',
            'stats',
            'statuses',
            'layanans',
            'prioritas',
            'pemohons',
            'jenisDokumens',
            'roleTujuan'
        ));
    }

    public function sedangDiproses(Request $request)
    {
        $permohonans = Permohonan::with([
            'pemohon',
            'jenisLayanan',
            'statusPermohonan',
            'petugasLoket',
            'dokumen'
        ])
        ->sedangDiproses()
        ->filter($request->all())
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->withQueryString();

        $stats = [
            'total' => Permohonan::count(),
            'menunggu' => Permohonan::perluDiteruskan()->count(),
            'proses' => Permohonan::sedangDiproses()->count(),
            'selesai' => Permohonan::selesai()->count(),
        ];

        $statuses = StatusPermohonan::where('is_active', true)->get();
        $layanans = JenisLayanan::where('is_active', true)->get();
        $prioritas = ['normal', 'penting', 'urgent'];
        $pemohons = Pemohon::orderBy('nama_lengkap')->get();
        $jenisDokumens = JenisDokumen::where('is_active', true)->get();
        $roleTujuan = JenisLayanan::where('is_active', true)->pluck('role_tujuan', 'id')->toArray();

        return view('loket.permohonan.index', compact(
            'permohonans',
            'stats',
            'statuses',
            'layanans',
            'prioritas',
            'pemohons',
            'jenisDokumens',
            'roleTujuan'
        ));
    }

    public function selesai(Request $request)
    {
        $permohonans = Permohonan::with([
            'pemohon',
            'jenisLayanan',
            'statusPermohonan',
            'petugasLoket',
            'dokumen'
        ])
        ->selesai()
        ->filter($request->all())
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->withQueryString();

        $stats = [
            'total' => Permohonan::count(),
            'menunggu' => Permohonan::perluDiteruskan()->count(),
            'proses' => Permohonan::sedangDiproses()->count(),
            'selesai' => Permohonan::selesai()->count(),
        ];

        $statuses = StatusPermohonan::where('is_active', true)->get();
        $layanans = JenisLayanan::where('is_active', true)->get();
        $prioritas = ['normal', 'penting', 'urgent'];
        $pemohons = Pemohon::orderBy('nama_lengkap')->get();
        $jenisDokumens = JenisDokumen::where('is_active', true)->get();
        $roleTujuan = JenisLayanan::where('is_active', true)->pluck('role_tujuan', 'id')->toArray();

        return view('loket.permohonan.index', compact(
            'permohonans',
            'stats',
            'statuses',
            'layanans',
            'prioritas',
            'pemohons',
            'jenisDokumens',
            'roleTujuan'
        ));
    }

    public function distribusikan(Request $request, Permohonan $permohonan)
    {
        try {
            $layanan = $permohonan->jenisLayanan;
            if (!$layanan || !$layanan->role_tujuan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jenis layanan tidak memiliki role tujuan.'
                ], 422);
            }

            $existing = PermohonanPetugas::where('permohonan_id', $permohonan->id)
                ->where('is_active', true)
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Permohonan sudah diteruskan ke petugas.'
                ], 422);
            }

            $petugas = User::where('role', $layanan->role_tujuan)
                ->where('is_active', true)
                ->first();

            if (!$petugas) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada petugas yang tersedia untuk layanan ini.'
                ], 422);
            }

            DB::beginTransaction();

            PermohonanPetugas::create([
                'permohonan_id' => $permohonan->id,
                'user_id' => $petugas->id,
                'assigned_by' => auth()->id(),
                'assigned_at' => now(),
                'is_active' => true,
                'keterangan' => $request->catatan ?? 'Diteruskan dari loket',
            ]);

            $statusDiteruskan = StatusPermohonan::where('kode_status', 'DITERUSKAN')->first();
            if ($statusDiteruskan) {
                $oldStatusId = $permohonan->status_permohonan_id;
                $permohonan->update([
                    'status_permohonan_id' => $statusDiteruskan->id,
                    'tanggal_diteruskan' => now(),
                ]);

                RiwayatStatus::create([
                    'permohonan_id' => $permohonan->id,
                    'status_lama_id' => $oldStatusId,
                    'status_baru_id' => $statusDiteruskan->id,
                    'changed_by' => auth()->id(),
                    'keterangan' => 'Permohonan diteruskan ke ' . $petugas->role_label . ' (' . $petugas->name . ')',
                    'changed_at' => now(),
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Permohonan berhasil diteruskan ke {$petugas->name} (" . $petugas->role_label . ")",
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getPetugasByLayanan(Request $request)
    {
        $layananId = $request->jenis_layanan_id;
        if (!$layananId) {
            return response()->json([
                'success' => false,
                'message' => 'Jenis layanan tidak ditemukan.'
            ]);
        }

        $layanan = JenisLayanan::find($layananId);
        if (!$layanan || !$layanan->role_tujuan) {
            return response()->json([
                'success' => false,
                'message' => 'Jenis layanan tidak memiliki role tujuan.'
            ]);
        }

        $petugas = User::where('role', $layanan->role_tujuan)
            ->where('is_active', true)
            ->select('id', 'name', 'role')
            ->first();

        if (!$petugas) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada petugas yang tersedia untuk layanan ini.'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'petugas' => $petugas->name,
                'role' => $petugas->role_label,
                'role_tujuan' => $layanan->role_tujuan,
            ]
        ]);
    }
}