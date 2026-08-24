<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('username', 100)->unique();
            $table->string('password');
            $table->enum('role', [
                'admin',
                'petugas_loket',
                'pengecekan_kehilangan',
                'kutipan_kedua',
                'banjir_kepolisian',
                'keabsahan',
                'surat_pengantar'
            ])->default('petugas_loket');
            $table->string('phone', 20)->nullable();
            $table->string('photo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};