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
use App\Http\Controllers\KutipanKedua\PermohonanController as KutipanKeduaPermohonanController;
use App\Http\Controllers\Keabsahan\PermohonanController as KeabsahanPermohonanController;
use App\Http\Controllers\SuratPengantar\PermohonanController as SuratPengantarPermohonanController;
use App\Http\Controllers\Loket\TrackingController as LoketTrackingController;
use App\Http\Controllers\Public\TrackingController as PublicTrackingController;
use App\Http\Controllers\Loket\ProfileController as LoketProfileController;
use App\Http\Controllers\KutipanKedua\ProfileController as KutipanKeduaProfileController;
use App\Http\Controllers\Keabsahan\ProfileController as KeabsahanProfileController;
use App\Http\Controllers\SuratPengantar\ProfileController as SuratPengantarProfileController;
use Illuminate\Support\Facades\Route;

// ============================================
// PUBLIC ROUTES (Tanpa Login)
// ============================================

// Halaman utama - redirect ke tracking
Route::get('/', function () {
    return redirect()->route('public.tracking.index');
});

// ============================================
// PUBLIC TRACKING ROUTES (Tanpa Login)
// ============================================
Route::prefix('/')->name('public.')->group(function () {
    Route::get('/tracking', [PublicTrackingController::class, 'index'])->name('tracking.index');
    Route::get('/tracking/detail', [PublicTrackingController::class, 'detail'])->name('tracking.detail');
    Route::get('/tracking/status-list', [PublicTrackingController::class, 'statusList'])->name('tracking.status');
});


// ============================================
// AUTH ROUTES (Guest only)
// ============================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
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
        Route::get('permohonan/pdf', [PermohonanController::class, 'generatePdf'])->name('permohonan.pdf');
    Route::get('permohonan/{permohonan}/pdf-detail', [PermohonanController::class, 'pdfDetail'])->name('permohonan.pdf-detail');
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
        Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [LoketProfileController::class, 'index'])->name('index');
        Route::put('/update', [LoketProfileController::class, 'update'])->name('update');
        Route::put('/update-password', [LoketProfileController::class, 'updatePassword'])->name('update-password');
        Route::post('/update-photo', [LoketProfileController::class, 'updatePhoto'])->name('update-photo');
        Route::delete('/delete-photo', [LoketProfileController::class, 'deletePhoto'])->name('delete-photo');
    });
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
        // UPLOAD DOKUMEN
        // ============================================
        Route::post('permohonan/{permohonan}/upload-dokumen', [LoketPermohonanController::class, 'uploadDokumen'])
            ->name('permohonan.upload-dokumen');

        Route::delete('permohonan/{permohonan}/dokumen/{dokumenId}', [LoketPermohonanController::class, 'deleteDokumen'])
            ->name('permohonan.delete-dokumen');

        // ============================================
        // DISTRIBUSI
        // ============================================
        Route::post('permohonan/{permohonan}/distribusikan', [LoketPermohonanController::class, 'distribusikan'])->name('permohonan.distribusikan');
        Route::get('permohonan/get-petugas', [LoketPermohonanController::class, 'getPetugasByLayanan'])->name('permohonan.get-petugas');
        // ============================================
        // TRACKING
        // ============================================
        Route::get('tracking', [LoketTrackingController::class, 'index'])->name('tracking.index');
        Route::get('tracking/detail', [LoketTrackingController::class, 'detail'])->name('tracking.detail');
        Route::get('tracking/stats', [LoketTrackingController::class, 'stats'])->name('tracking.stats');
        Route::get('tracking/{token}', [LoketTrackingController::class, 'trackByToken'])->name('tracking.token');
    });

Route::middleware(['auth', 'role:kutipan_kedua'])
    ->prefix('kutipan-kedua')
    ->name('kutipan-kedua.')
    ->group(function () {
        Route::get('dashboard', [KutipanKeduaDashboardController::class, 'index'])->name('dashboard');
        Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [KutipanKeduaProfileController::class, 'index'])->name('index');
        Route::put('/update', [KutipanKeduaProfileController::class, 'update'])->name('update');
        Route::put('/update-password', [KutipanKeduaProfileController::class, 'updatePassword'])->name('update-password');
        Route::post('/update-photo', [KutipanKeduaProfileController::class, 'updatePhoto'])->name('update-photo');
        Route::delete('/delete-photo', [KutipanKeduaProfileController::class, 'deletePhoto'])->name('delete-photo');
    });
    Route::prefix('permohonan')->name('permohonan.')->group(function () {
        Route::get('/', [KutipanKeduaPermohonanController::class, 'index'])->name('index');
        Route::get('/perlu-diproses', [KutipanKeduaPermohonanController::class, 'perluDiproses'])->name('diproses');
        Route::get('/sedang-diproses', [KutipanKeduaPermohonanController::class, 'sedangDiproses'])->name('sedang-diproses');
        Route::get('/selesai', [KutipanKeduaPermohonanController::class, 'selesai'])->name('selesai');
        Route::get('/{permohonan}', [KutipanKeduaPermohonanController::class, 'show'])->name('show');
        
        // AJAX Endpoints
        Route::post('/{permohonan}/update-status', [KutipanKeduaPermohonanController::class, 'updateStatus'])->name('update-status');
        Route::post('/{permohonan}/tambah-komentar', [KutipanKeduaPermohonanController::class, 'tambahKomentar'])->name('tambah-komentar');
        Route::get('/{permohonan}/get-komentar', [KutipanKeduaPermohonanController::class, 'getKomentar'])->name('get-komentar');
        Route::post('/{permohonan}/proses', [KutipanKeduaPermohonanController::class, 'proses'])->name('proses');
        Route::post('/{permohonan}/upload-dokumen', [KutipanKeduaPermohonanController::class, 'uploadDokumen'])->name('upload-dokumen');
        Route::delete('/{permohonan}/dokumen/{dokumenId}', [KutipanKeduaPermohonanController::class, 'deleteDokumen'])->name('delete-dokumen');
    });
    });

Route::middleware(['auth', 'role:keabsahan'])
    ->prefix('keabsahan')
    ->name('keabsahan.')
    ->group(function () {
        Route::get('/dashboard', [KeabsahanDashboardController::class, 'index'])->name('dashboard');
        Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [KeabsahanProfileController::class, 'index'])->name('index');
        Route::put('/update', [KeabsahanProfileController::class, 'update'])->name('update');
        Route::put('/update-password', [KeabsahanProfileController::class, 'updatePassword'])->name('update-password');
        Route::post('/update-photo', [KeabsahanProfileController::class, 'updatePhoto'])->name('update-photo');
        Route::delete('/delete-photo', [KeabsahanProfileController::class, 'deletePhoto'])->name('delete-photo');
    });
        Route::prefix('permohonan')->name('permohonan.')->group(function () {
        Route::get('/', [KeabsahanPermohonanController::class, 'index'])->name('index');
        Route::get('/perlu-diproses', [KeabsahanPermohonanController::class, 'perluDiproses'])->name('diproses');
        Route::get('/sedang-diproses', [KeabsahanPermohonanController::class, 'sedangDiproses'])->name('sedang-diproses');
        Route::get('/selesai', [KeabsahanPermohonanController::class, 'selesai'])->name('selesai');
        Route::get('/{permohonan}', [KeabsahanPermohonanController::class, 'show'])->name('show');
        
        // AJAX Endpoints
        Route::post('/{permohonan}/update-status', [KeabsahanPermohonanController::class, 'updateStatus'])->name('update-status');
        Route::post('/{permohonan}/tambah-komentar', [KeabsahanPermohonanController::class, 'tambahKomentar'])->name('tambah-komentar');
        Route::get('/{permohonan}/get-komentar', [KeabsahanPermohonanController::class, 'getKomentar'])->name('get-komentar');
        Route::post('/{permohonan}/proses', [KeabsahanPermohonanController::class, 'proses'])->name('proses');
        Route::post('/{permohonan}/upload-dokumen', [KeabsahanPermohonanController::class, 'uploadDokumen'])->name('upload-dokumen');
        Route::delete('/{permohonan}/dokumen/{dokumenId}', [KeabsahanPermohonanController::class, 'deleteDokumen'])->name('delete-dokumen');
        });
    });
Route::middleware(['auth', 'role:surat_pengantar'])
    ->prefix('surat-pengantar')
    ->name('surat-pengantar.')
    ->group(function () {
        Route::get('/dashboard', [SuratPengantarDashboardController::class, 'index'])->name('dashboard');
        Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [SuratPengantarProfileController::class, 'index'])->name('index');
        Route::put('/update', [SuratPengantarProfileController::class, 'update'])->name('update');
        Route::put('/update-password', [SuratPengantarProfileController::class, 'updatePassword'])->name('update-password');
        Route::post('/update-photo', [SuratPengantarProfileController::class, 'updatePhoto'])->name('update-photo');
        Route::delete('/delete-photo', [SuratPengantarProfileController::class, 'deletePhoto'])->name('delete-photo');
    });
        Route::prefix('permohonan')->name('permohonan.')->group(function () {
        Route::get('/', [SuratPengantarPermohonanController::class, 'index'])->name('index');
        Route::get('/perlu-diproses', [SuratPengantarPermohonanController::class, 'perluDiproses'])->name('diproses');
        Route::get('/sedang-diproses', [SuratPengantarPermohonanController::class, 'sedangDiproses'])->name('sedang-diproses');
        Route::get('/selesai', [SuratPengantarPermohonanController::class, 'selesai'])->name('selesai');
        Route::get('/{permohonan}', [SuratPengantarPermohonanController::class, 'show'])->name('show');
        
        // AJAX Endpoints
        Route::post('/{permohonan}/update-status', [SuratPengantarPermohonanController::class, 'updateStatus'])->name('update-status');
        Route::post('/{permohonan}/tambah-komentar', [SuratPengantarPermohonanController::class, 'tambahKomentar'])->name('tambah-komentar');
        Route::get('/{permohonan}/get-komentar', [SuratPengantarPermohonanController::class, 'getKomentar'])->name('get-komentar');
        Route::post('/{permohonan}/proses', [SuratPengantarPermohonanController::class, 'proses'])->name('proses');
        Route::post('/{permohonan}/upload-dokumen', [SuratPengantarPermohonanController::class, 'uploadDokumen'])->name('upload-dokumen');
        Route::delete('/{permohonan}/dokumen/{dokumenId}', [SuratPengantarPermohonanController::class, 'deleteDokumen'])->name('delete-dokumen');
    });
    });
Route::middleware(['auth'])->post('/logout', [AuthController::class, 'logout'])->name('logout');