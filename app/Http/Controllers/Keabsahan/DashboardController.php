<?php

namespace App\Http\Controllers\Keabsahan;

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
                    'keabsahan'
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

        return view('keabsahan.dashboard', $data);
    }
}