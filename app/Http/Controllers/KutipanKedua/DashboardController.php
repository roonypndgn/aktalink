<?php

namespace App\Http\Controllers\KutipanKedua;

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
                    'kutipan_kedua'
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

        return view('kutipan-kedua.dashboard', $data);
    }
}