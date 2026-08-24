<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('status_hasils', function (Blueprint $table) {
            $table->id();

            $table->foreignId('jenis_layanan_id')
                ->constrained('jenis_layanans')
                ->cascadeOnDelete();

            $table->string('nama_hasil', 150);

            $table->string('kode_hasil', 100);

            $table->string('warna', 30)->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique([
                'jenis_layanan_id',
                'kode_hasil'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('status_hasils');
    }
};