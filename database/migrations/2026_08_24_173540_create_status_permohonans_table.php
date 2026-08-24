<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('status_permohonans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_status', 100);
            $table->string('kode_status', 100)->unique();
            $table->integer('urutan')->default(0);
            $table->string('warna', 30)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('status_permohonans');
    }
};