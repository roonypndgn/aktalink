<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jenis_layanans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_layanan', 150);
            $table->string('kode_layanan', 50)->unique();
            $table->enum('role_tujuan', [
                'pengecekan_kehilangan',
                'kutipan_kedua',
                'banjir_kepolisian',
                'keabsahan',
                'surat_pengantar'
            ]);
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_layanans');
    }
};