<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('layanan_persyaratans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('jenis_layanan_id')
                ->constrained('jenis_layanans')
                ->cascadeOnDelete();

            $table->foreignId('jenis_dokumen_id')
                ->constrained('jenis_dokumens')
                ->restrictOnDelete();

            $table->boolean('is_required')->default(true);

            $table->timestamps();

            $table->unique([
                'jenis_layanan_id',
                'jenis_dokumen_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan_persyaratans');
    }
};