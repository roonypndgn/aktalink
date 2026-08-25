<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('permohonan_dokumens')) {
            Schema::create('permohonan_dokumens', function (Blueprint $table) {
                $table->id();
                $table->foreignId('permohonan_id')
                    ->constrained('permohonans')
                    ->cascadeOnDelete();
                $table->foreignId('jenis_dokumen_id')
                    ->nullable()
                    ->constrained('jenis_dokumens')
                    ->nullOnDelete();
                $table->string('nama_dokumen', 150);
                $table->string('file_name');
                $table->string('file_path');
                $table->string('file_type', 100)->nullable();
                $table->unsignedBigInteger('file_size')->nullable();
                $table->enum('status_verifikasi', ['menunggu', 'valid', 'tidak_valid'])->default('menunggu');
                $table->text('keterangan')->nullable();
                $table->foreignId('uploaded_by')->constrained('users')->restrictOnDelete();
                $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamp('verified_at')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('permohonan_dokumens');
    }
};