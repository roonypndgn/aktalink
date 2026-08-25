<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemohon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PemohonController extends Controller
{
    /**
     * Display a listing of the resource (Read-Only untuk Admin)
     */
    public function index(Request $request)
    {
        $pemohons = Pemohon::search($request->search)
            ->filterGender($request->jenis_kelamin)
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.pemohon.index', compact('pemohons'));
    }

    /**
     * Display the specified resource (via Modal)
     */
    public function show(Pemohon $pemohon)
    {
        return response()->json([
            'success' => true,
            'data' => $pemohon
        ]);
    }

    /**
     * Generate PDF Laporan Data Pemohon
     */
    public function generatePdf(Request $request)
    {
        // Ambil data dengan filter yang sama
        $pemohons = Pemohon::search($request->search)
            ->filterGender($request->jenis_kelamin)
            ->orderBy('created_at', 'desc')
            ->get();

        // Data statistik
        $stats = [
            'total' => $pemohons->count(),
            'laki' => $pemohons->where('jenis_kelamin', 'L')->count(),
            'perempuan' => $pemohons->where('jenis_kelamin', 'P')->count(),
            'belum_isi' => $pemohons->whereNull('jenis_kelamin')->count(),
        ];

        // Filter info untuk judul
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

        // Load view PDF
        $pdf = Pdf::loadView('admin.pemohon.pdf', $data);
        $pdf->setPaper('A4', 'landscape');

        // Set options untuk PDF yang lebih baik
        $pdf->setOptions([
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        // Download atau stream
        return $pdf->download('Laporan_Data_Pemohon_' . date('Y-m-d') . '.pdf');
    }
}