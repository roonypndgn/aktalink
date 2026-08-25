<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AktivitasLog;
use App\Models\User;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $logs = AktivitasLog::with('user')
            ->search($request->search)
            ->filterUser($request->user_id)
            ->filterSubject($request->subject_type)
            ->filterDate($request->date_from, $request->date_to)
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Statistik
        $stats = [
            'total' => AktivitasLog::count(),
            'hari_ini' => AktivitasLog::whereDate('created_at', today())->count(),
            'minggu_ini' => AktivitasLog::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'bulan_ini' => AktivitasLog::whereMonth('created_at', now()->month)->count(),
        ];

        // Data untuk filter
        $users = User::where('is_active', true)->orderBy('name')->get();

        // Subject types yang tersedia
        $subjectTypes = AktivitasLog::select('subject_type')
            ->whereNotNull('subject_type')
            ->distinct()
            ->pluck('subject_type')
            ->filter()
            ->map(function ($type) {
                $shortName = class_basename($type);
                return [
                    'value' => $type,
                    'label' => $shortName,
                ];
            })
            ->values();

        return view('admin.riwayat.index', compact(
            'logs',
            'stats',
            'users',
            'subjectTypes'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(AktivitasLog $riwayat)
    {
        $riwayat->load('user');
        return response()->json([
            'success' => true,
            'data' => $riwayat
        ]);
    }

    /**
     * Clear all logs (Hanya admin super)
     */
    public function clear()
    {
        // Hanya admin tertentu yang bisa menghapus semua log
        if (auth()->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki izin untuk melakukan ini.'
            ], 403);
        }

        try {
            AktivitasLog::truncate();

            return response()->json([
                'success' => true,
                'message' => 'Semua riwayat aktivitas berhasil dibersihkan!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export riwayat ke PDF
     */
    public function exportPdf(Request $request)
    {
        $logs = AktivitasLog::with('user')
            ->search($request->search)
            ->filterUser($request->user_id)
            ->filterSubject($request->subject_type)
            ->filterDate($request->date_from, $request->date_to)
            ->orderBy('created_at', 'desc')
            ->get();

        $data = [
            'logs' => $logs,
            'generatedAt' => now()->format('d F Y H:i:s'),
            'totalData' => $logs->count(),
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.riwayat.pdf', $data);
        $pdf->setPaper('A4', 'landscape');

        $pdf->setOptions([
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        return $pdf->download('Riwayat_Aktivitas_' . date('Y-m-d') . '.pdf');
    }
}