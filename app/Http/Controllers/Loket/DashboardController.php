<?php

namespace App\Http\Controllers\Loket;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $data = [
            'totalPermohonan' => Permohonan::where(
                'petugas_loket_id',
                $user->id
            )->count(),

            'permohonanTerbaru' => Permohonan::with([
                'pemohon',
                'jenisLayanan',
                'statusPermohonan'
            ])
            ->where('petugas_loket_id', $user->id)
            ->latest()
            ->take(10)
            ->get(),
        ];

        return view('loket.dashboard', $data);
    }
}