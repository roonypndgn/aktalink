<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('permohonans', function (Blueprint $table) {
            $table->id();

            $table->string('nomor_permohonan', 50)->unique();

            $table->foreignId('pemohon_id')
                ->constrained('pemohons')
                ->cascadeOnDelete();

            $table->foreignId('jenis_layanan_id')
                ->constrained('jenis_layanans')
                ->restrictOnDelete();

            $table->foreignId('status_permohonan_id')
                ->constrained('status_permohonans')
                ->restrictOnDelete();

            $table->foreignId('petugas_loket_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('judul_permohonan', 200)->nullable();

            $table->text('keterangan');

            $table->enum('prioritas', [
                'normal',
                'penting',
                'urgent'
            ])->default('normal');

            $table->timestamp('tanggal_permohonan')->useCurrent();

            $table->timestamp('tanggal_diteruskan')->nullable();

            $table->timestamp('tanggal_selesai')->nullable();

            $table->text('catatan_loket')->nullable();

            $table->timestamps();

            $table->index('nomor_permohonan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permohonans');
    }
};