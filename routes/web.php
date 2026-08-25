<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Loket\DashboardController as LoketDashboardController;
use App\Http\Controllers\PengecekanKehilangan\DashboardController as PengecekanKehilanganDashboardController;
use App\Http\Controllers\KutipanKedua\DashboardController as KutipanKeduaDashboardController;
use App\Http\Controllers\BanjirKepolisian\DashboardController as BanjirKepolisianDashboardController;
use App\Http\Controllers\Keabsahan\DashboardController as KeabsahanDashboardController;
use App\Http\Controllers\SuratPengantar\DashboardController as SuratPengantarDashboardController;
use App\Http\Controllers\Admin\PermohonanController;
use App\Http\Controllers\Admin\JenisLayananController;
use App\Http\Controllers\Admin\PemohonController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\RiwayatController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Loket\PemohonController as LoketPemohonController;
use App\Http\Controllers\Loket\PermohonanController as LoketPermohonanController; 
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        //Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        //Profil
        Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
        Route::delete('profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.delete-photo');
        //Permohonan
        Route::get('permohonan', [PermohonanController::class, 'index'])->name('permohonan.index');
        Route::get('permohonan/{permohonan}', [PermohonanController::class, 'show'])->name('permohonan.show');
        Route::get('permohonan/pdf/export', [PermohonanController::class, 'generatePdf'])->name('permohonan.pdf');
        Route::get('permohonan/{permohonan}/pdf', [PermohonanController::class, 'generateDetailPdf'])->name('permohonan.pdf-detail');
        //Jenis Layanan
        Route::resource('jenis-layanan', JenisLayananController::class)->except(['create', 'edit']);
        Route::get('jenis-layanan/create', [JenisLayananController::class, 'create'])->name('jenis-layanan.create');
        Route::get('jenis-layanan/{jenisLayanan}/edit', [JenisLayananController::class, 'edit'])->name('jenis-layanan.edit');
        Route::patch('jenis-layanan/{jenisLayanan}/toggle', [JenisLayananController::class, 'toggleStatus'])->name('jenis-layanan.toggle');
        //Pemohon
        Route::get('pemohon', [PemohonController::class, 'index'])->name('pemohon.index');
        Route::get('pemohon/{pemohon}', [PemohonController::class, 'show'])->name('pemohon.show');
        Route::get('pemohon/pdf/export', [PemohonController::class, 'generatePdf'])->name('pemohon.pdf');
        //User
        Route::resource('users', UserController::class);
        Route::patch('users/{user}/toggle', [UserController::class, 'toggleStatus'])->name('users.toggle');
        Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
        //Laporan
        Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');  
        //Riwayat Aktivitas
        Route::get('riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
        Route::get('riwayat/{riwayat}', [RiwayatController::class, 'show'])->name('riwayat.show');
        Route::delete('riwayat/clear', [RiwayatController::class, 'clear'])->name('riwayat.clear');
        Route::get('riwayat/export-pdf', [RiwayatController::class, 'exportPdf'])->name('riwayat.export-pdf');
        //Pengaturan
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('settings/general', [SettingsController::class, 'updateGeneral'])->name('settings.update-general');
        Route::put('settings/notification', [SettingsController::class, 'updateNotification'])->name('settings.update-notification');
        Route::put('settings/security', [SettingsController::class, 'updateSecurity'])->name('settings.update-security');
        Route::put('settings/system', [SettingsController::class, 'updateSystem'])->name('settings.update-system');
        Route::delete('settings/reset', [SettingsController::class, 'reset'])->name('settings.reset');

    });

Route::middleware(['auth', 'role:petugas_loket'])
    ->prefix('loket')
    ->name('loket.')
    ->group(function () {
        Route::get('/dashboard', [LoketDashboardController::class,'index'])->name('dashboard');
        //Pemohon
        Route::resource('pemohon', LoketPemohonController::class);
        Route::get('pemohon/pdf/export', [LoketPemohonController::class, 'exportPdf'])->name('pemohon.pdf');
        //Permohonan
        Route::get('permohonan', [LoketPermohonanController::class, 'index'])->name('permohonan.index');
    Route::get('permohonan/perlu-diteruskan', [LoketPermohonanController::class, 'perluDiteruskan'])->name('permohonan.diteruskan');
    Route::get('permohonan/sedang-diproses', [LoketPermohonanController::class, 'sedangDiproses'])->name('permohonan.proses');
    Route::get('permohonan/selesai', [LoketPermohonanController::class, 'selesai'])->name('permohonan.selesai');
    Route::get('permohonan/{permohonan}', [LoketPermohonanController::class, 'show'])->name('permohonan.show');
    Route::get('permohonan/{permohonan}/edit', [LoketPermohonanController::class, 'edit'])->name('permohonan.edit');
    Route::post('permohonan', [LoketPermohonanController::class, 'store'])->name('permohonan.store');
    Route::put('permohonan/{permohonan}', [LoketPermohonanController::class, 'update'])->name('permohonan.update');
    Route::delete('permohonan/{permohonan}', [LoketPermohonanController::class, 'destroy'])->name('permohonan.destroy');

    // ============================================
    // DOKUMEN Routes
    // ============================================
     Route::post('permohonan/{permohonan}/upload-dokumen-simple', [PermohonanController::class, 'uploadDokumenSimple'])->name('permohonan.upload-dokumen-simple');
     Route::delete('permohonan/{permohonan}/dokumen/{dokumenId}', [PermohonanController::class, 'deleteDokumen'])
    ->name('permohonan.delete-dokumen');

    // Distribusi
    Route::post('permohonan/{permohonan}/distribusikan', [LoketPermohonanController::class, 'distribusikan'])->name('permohonan.distribusikan');
    Route::get('permohonan/get-petugas', [LoketPermohonanController::class, 'getPetugasByLayanan'])->name('permohonan.get-petugas');
    });
Route::middleware(['auth','role:pengecekan_kehilangan'])
    ->prefix('pengecekan-kehilangan')
    ->name('pengecekan-kehilangan.')
    ->group(function () {
        Route::get('/dashboard', [PengecekanKehilanganDashboardController::class,'index'])->name('dashboard');
    });
Route::middleware(['auth', 'role:kutipan_kedua'])
    ->prefix('kutipan-kedua')
    ->name('kutipan-kedua.')
    ->group(function () {
        Route::get('/dashboard', [KutipanKeduaDashboardController::class, 'index'])->name('dashboard');
    });
Route::middleware(['auth', 'role:banjir_kepolisian'])
    ->prefix('banjir-kepolisian')
    ->name('banjir-kepolisian.')
    ->group(function () {
        Route::get('/dashboard', [BanjirKepolisianDashboardController::class, 'index'])->name('dashboard');
    });
Route::middleware(['auth', 'role:keabsahan'])
    ->prefix('keabsahan')
    ->name('keabsahan.')
    ->group(function () {
        Route::get('/dashboard', [KeabsahanDashboardController::class, 'index'])->name('dashboard');
    });
Route::middleware(['auth', 'role:surat_pengantar'])
    ->prefix('surat-pengantar')
    ->name('surat-pengantar.')
    ->group(function () {
        Route::get('/dashboard', [SuratPengantarDashboardController::class, 'index'])->name('dashboard');
    });
Route::middleware(['auth'])->post('/logout', [AuthController::class, 'logout'])->name('logout');