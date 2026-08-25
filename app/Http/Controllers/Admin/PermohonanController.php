<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Pemohon;
use App\Models\JenisLayanan;
use App\Models\StatusPermohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf; // Import DomPDF

class PermohonanController extends Controller
{
    /**
     * Display a listing of the resource (Read-Only untuk Admin)
     */
    public function index(Request $request)
    {
        $permohonans = Permohonan::with([
            'pemohon',
            'jenisLayanan',
            'statusPermohonan',
            'petugasLoket'
        ])
        ->filter($request->all())
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->withQueryString();

        // Data untuk filter
        $statuses = StatusPermohonan::where('is_active', true)->get();
        $layanans = JenisLayanan::where('is_active', true)->get();
        $prioritas = ['normal', 'penting', 'urgent'];
        return view('admin.permohonan.index', compact(
            'permohonans',
            'statuses',
            'layanans',
            'prioritas'
        ));
    }

    /**
     * Display the specified resource (Read-Only)
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

        return view('admin.permohonan.show', compact('permohonan'));
    }

    /**
     * Generate PDF Laporan Permohonan
     */
    public function generatePdf(Request $request)
    {
        // Ambil data dengan filter yang sama
        $permohonans = Permohonan::with([
            'pemohon',
            'jenisLayanan',
            'statusPermohonan',
            'petugasLoket'
        ])
        ->filter($request->all())
        ->orderBy('created_at', 'desc')
        ->get();

        // Data statistik
        $stats = [
            'total' => $permohonans->count(),
            'menunggu' => $permohonans->filter(function($item) {
                return $item->statusPermohonan && $item->statusPermohonan->kode_status === 'MENUNGGU';
            })->count(),
            'proses' => $permohonans->filter(function($item) {
                return $item->statusPermohonan && in_array($item->statusPermohonan->kode_status, ['DITERUSKAN', 'DIPROSES']);
            })->count(),
            'selesai' => $permohonans->filter(function($item) {
                return $item->statusPermohonan && $item->statusPermohonan->kode_status === 'SELESAI';
            })->count(),
        ];

        // Filter info untuk judul
        $filters = [];
        if ($request->search) $filters[] = 'Cari: ' . $request->search;
        if ($request->status) {
            $status = StatusPermohonan::find($request->status);
            if ($status) $filters[] = 'Status: ' . $status->nama_status;
        }
        if ($request->jenis_layanan) {
            $layanan = JenisLayanan::find($request->jenis_layanan);
            if ($layanan) $filters[] = 'Layanan: ' . $layanan->nama_layanan;
        }
        if ($request->prioritas) $filters[] = 'Prioritas: ' . ucfirst($request->prioritas);
        if ($request->date_from && $request->date_to) {
            $filters[] = 'Tanggal: ' . $request->date_from . ' s/d ' . $request->date_to;
        }

        $filterText = !empty($filters) ? implode(' | ', $filters) : 'Semua Data';

        $data = [
            'permohonans' => $permohonans,
            'stats' => $stats,
            'filterText' => $filterText,
            'generatedAt' => now()->format('d F Y H:i:s'),
            'totalData' => $permohonans->count(),
        ];

        // Load view PDF
        $pdf = Pdf::loadView('admin.permohonan.pdf', $data);
        $pdf->setPaper('A4', 'landscape');

        // Set options untuk PDF yang lebih baik
        $pdf->setOptions([
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        // Download atau stream
        return $pdf->download('Laporan_Permohonan_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Generate PDF Detail Permohonan
     */
    public function generateDetailPdf(Permohonan $permohonan)
    {
        $permohonan->load([
            'pemohon',
            'jenisLayanan',
            'statusPermohonan',
            'petugasLoket',
            'riwayatStatus.statusLama',
            'riwayatStatus.statusBaru',
            'riwayatStatus.changedBy',
            'hasilPemeriksaan.statusHasil',
            'hasilPemeriksaan.diperiksaOleh',
            'petugasPenanganan.user',
            'dokumen.jenisDokumen',
        ]);

        $data = [
            'permohonan' => $permohonan,
            'generatedAt' => now()->format('d F Y H:i:s'),
        ];

        $pdf = Pdf::loadView('admin.permohonan.pdf-detail', $data);
        $pdf->setPaper('A4', 'portrait');

        $pdf->setOptions([
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        return $pdf->download('Detail_Permohonan_' . $permohonan->nomor_permohonan . '.pdf');
    }
}