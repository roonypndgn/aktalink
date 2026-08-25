<?php

namespace Database\Seeders;

use App\Models\JenisDokumen;
use Illuminate\Database\Seeder;

class JenisDokumenSeeder extends Seeder
{
    public function run(): void
    {
        $dokumens = [
            [
                'nama_dokumen' => 'Kartu Tanda Penduduk',
                'kode_dokumen' => 'KTP',
                'deskripsi' => 'Foto KTP pemohon',
                'is_active' => true,
            ],
            [
                'nama_dokumen' => 'Kartu Keluarga',
                'kode_dokumen' => 'KK',
                'deskripsi' => 'Foto Kartu Keluarga',
                'is_active' => true,
            ],
            [
                'nama_dokumen' => 'Akta',
                'kode_dokumen' => 'AKTA',
                'deskripsi' => 'Foto akta yang bersangkutan',
                'is_active' => true,
            ],
            [
                'nama_dokumen' => 'Surat Kehilangan',
                'kode_dokumen' => 'SURAT_KEHILANGAN',
                'deskripsi' => 'Foto surat kehilangan dari kepolisian',
                'is_active' => true,
            ],
            [
                'nama_dokumen' => 'Dokumen Pendukung Lainnya',
                'kode_dokumen' => 'DOKUMEN_LAINNYA',
                'deskripsi' => 'Dokumen pendukung lainnya',
                'is_active' => true,
            ],
        ];

        foreach ($dokumens as $dokumen) {
            JenisDokumen::create($dokumen);
        }
    }
}