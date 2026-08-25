<?php

namespace App\Http\Controllers\SuratPengantar;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;

class DashboardController extends Controller
{
    public function index()
    {
        $permohonan = Permohonan::whereHas(
            'jenisLayanan',
            function ($query) {
                $query->where(
                    'role_tujuan',
                    'surat_pengantar'
                );
            }
        );

        $data = [
            'totalPermohonan' => (clone $permohonan)->count(),

            'permohonanTerbaru' => $permohonan
                ->with([
                    'pemohon',
                    'jenisLayanan',
                    'statusPermohonan'
                ])
                ->latest()
                ->take(10)
                ->get(),
        ];

        return view('surat-pengantar.dashboard', $data);
    }
}