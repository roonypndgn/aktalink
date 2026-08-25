<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('riwayat_status', function (Blueprint $table) {
            $table->id();

            $table->foreignId('permohonan_id')
                ->constrained('permohonans')
                ->cascadeOnDelete();

            $table->foreignId('status_lama_id')
                ->nullable()
                ->constrained('status_permohonans')
                ->nullOnDelete();

            $table->foreignId('status_baru_id')
                ->constrained('status_permohonans')
                ->restrictOnDelete();

            $table->foreignId('changed_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->text('keterangan')->nullable();

            $table->timestamp('changed_at')->useCurrent();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_status');
    }
};