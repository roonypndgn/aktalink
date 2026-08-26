<?php
namespace App\Http\Controllers\Loket;

use App\Http\Controllers\Controller;
use App\Models\Pemohon;
use App\Traits\LogsActivity; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PemohonController extends Controller
{
    use LogsActivity;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pemohons = Pemohon::search($request->search)
            ->filterGender($request->jenis_kelamin)
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Statistik
        $stats = [
            'total' => Pemohon::count(),
            'laki' => Pemohon::where('jenis_kelamin', 'L')->count(),
            'perempuan' => Pemohon::where('jenis_kelamin', 'P')->count(),
            'belum_isi' => Pemohon::whereNull('jenis_kelamin')->count(),
        ];

        return view('loket.pemohon.index', compact('pemohons', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('loket.pemohon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|size:16|unique:pemohons,nik',
            'nama_lengkap' => 'required|string|max:150',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date|before:today',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat' => 'nullable|string',
            'nomor_hp' => 'nullable|string|max:20',
        ], [
            'nik.size' => 'NIK harus 16 digit angka',
            'nik.unique' => 'NIK sudah terdaftar',
            'tanggal_lahir.before' => 'Tanggal lahir tidak valid',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $pemohon = Pemohon::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Data pemohon berhasil ditambahkan!',
                'data' => $pemohon
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pemohon $pemohon)
    {
        return response()->json([
            'success' => true,
            'data' => $pemohon
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pemohon $pemohon)
    {
        return response()->json([
            'success' => true,
            'data' => $pemohon
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pemohon $pemohon)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|size:16|unique:pemohons,nik,' . $pemohon->id,
            'nama_lengkap' => 'required|string|max:150',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date|before:today',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat' => 'nullable|string',
            'nomor_hp' => 'nullable|string|max:20',
        ], [
            'nik.size' => 'NIK harus 16 digit angka',
            'nik.unique' => 'NIK sudah terdaftar',
            'tanggal_lahir.before' => 'Tanggal lahir tidak valid',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $pemohon->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Data pemohon berhasil diperbarui!',
                'data' => $pemohon
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pemohon $pemohon)
    {
        try {
            // Cek apakah pemohon memiliki permohonan
            if ($pemohon->permohonans()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pemohon tidak dapat dihapus karena memiliki permohonan terdaftar.'
                ], 422);
            }

            $nama = $pemohon->nama_lengkap;
            $pemohon->delete();

            return response()->json([
                'success' => true,
                'message' => "Pemohon '{$nama}' berhasil dihapus!"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export data pemohon ke PDF.
     */
    public function exportPdf(Request $request)
    {
        $pemohons = Pemohon::search($request->search)
            ->filterGender($request->jenis_kelamin)
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total' => $pemohons->count(),
            'laki' => $pemohons->where('jenis_kelamin', 'L')->count(),
            'perempuan' => $pemohons->where('jenis_kelamin', 'P')->count(),
            'belum_isi' => $pemohons->whereNull('jenis_kelamin')->count(),
        ];

        $filters = [];
        if ($request->search) $filters[] = 'Cari: ' . $request->search;
        if ($request->jenis_kelamin) {
            $filters[] = 'Jenis Kelamin: ' . ($request->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan');
        }
        $filterText = !empty($filters) ? implode(' | ', $filters) : 'Semua Data';

        $data = [
            'pemohons' => $pemohons,
            'stats' => $stats,
            'filterText' => $filterText,
            'generatedAt' => now()->format('d F Y H:i:s'),
            'totalData' => $pemohons->count(),
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('loket.pemohon.pdf', $data);
        $pdf->setPaper('A4', 'landscape');

        $pdf->setOptions([
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        return $pdf->download('Laporan_Data_Pemohon_' . date('Y-m-d') . '.pdf');
    }
}