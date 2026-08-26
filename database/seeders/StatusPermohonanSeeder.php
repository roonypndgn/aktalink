<?php

namespace Database\Seeders;

use App\Models\StatusPermohonan;
use Illuminate\Database\Seeder;

class StatusPermohonanSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['nama_status' => 'Menunggu', 'kode_status' => 'MENUNGGU', 'urutan' => 1, 'warna' => '#f59e0b', 'is_active' => true],
            ['nama_status' => 'Diteruskan', 'kode_status' => 'DITERUSKAN', 'urutan' => 2, 'warna' => '#3b82f6', 'is_active' => true],
            ['nama_status' => 'Sedang Diproses', 'kode_status' => 'DIPROSES', 'urutan' => 3, 'warna' => '#8b5cf6', 'is_active' => true],
            ['nama_status' => 'Berkas Kurang Lengkap', 'kode_status' => 'KURANG_LENGKAP', 'urutan' => 4, 'warna' => '#ef4444', 'is_active' => true],
            ['nama_status' => 'Selesai', 'kode_status' => 'SELESAI', 'urutan' => 5, 'warna' => '#059669', 'is_active' => true],
        ];

        foreach ($statuses as $status) {
            StatusPermohonan::create($status);
        }
    }
}