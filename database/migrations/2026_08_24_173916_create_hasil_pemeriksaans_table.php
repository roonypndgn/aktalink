<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hasil_pemeriksaans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('permohonan_id')
                ->constrained('permohonans')
                ->cascadeOnDelete();

            $table->foreignId('status_hasil_id')
                ->constrained('status_hasils')
                ->restrictOnDelete();

            $table->foreignId('diperiksa_oleh')
                ->constrained('users')
                ->restrictOnDelete();

            $table->timestamp('tanggal_pemeriksaan')->useCurrent();

            $table->text('hasil_pemeriksaan');

            $table->text('keterangan')->nullable();

            $table->text('rekomendasi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_pemeriksaans');
    }
};