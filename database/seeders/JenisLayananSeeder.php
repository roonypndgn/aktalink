<?php

namespace Database\Seeders;

use App\Models\JenisLayanan;
use Illuminate\Database\Seeder;

class JenisLayananSeeder extends Seeder
{
    public function run(): void
    {
        $layanans = [
            [
                'nama_layanan' => 'Layanan Surat Pengantar Polisi',
                'kode_layanan' => 'SURAT_POLISI',
                'role_tujuan' => 'keabsahan',
                'deskripsi' => 'Layanan pembuatan surat pengantar untuk keperluan kepolisian',
                'is_active' => true,
            ],
            [
                'nama_layanan' => 'Layanan Surat Pengantar',
                'kode_layanan' => 'LAYANAN_SURAT',
                'role_tujuan' => 'surat_pengantar',
                'deskripsi' => 'Layanan pembuatan surat pengantar untuk berbagai keperluan',
                'is_active' => true,
            ],
            [
                'nama_layanan' => 'Layanan Kehilangan/Perbaikan Akta',
                'kode_layanan' => 'LAYANAN_HILANG',
                'role_tujuan' => 'kutipan_kedua',
                'deskripsi' => 'Layanan pengurusan kehilangan atau perbaikan akta',
                'is_active' => true,
            ],
            [
                'nama_layanan' => 'Layanan Pengecekan Akta',
                'kode_layanan' => 'LAYANAN_PENGECEKAN',
                'role_tujuan' => 'kutipan_kedua',
                'deskripsi' => 'Layanan pengecekan keabsahan dan keberadaan akta',
                'is_active' => true,
            ],
        ];

        foreach ($layanans as $layanan) {
            JenisLayanan::create($layanan);
        }
    }
}