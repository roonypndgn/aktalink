<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'phone',
        'photo',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    public function permohonanDibuat()
    {
        return $this->hasMany(Permohonan::class, 'petugas_loket_id');
    }

    public function dokumenDiunggah()
    {
        return $this->hasMany(PermohonanDokumen::class, 'uploaded_by');
    }

    public function dokumenDiverifikasi()
    {
        return $this->hasMany(PermohonanDokumen::class, 'verified_by');
    }

    public function penugasan()
    {
        return $this->hasMany(PermohonanPetugas::class);
    }

    public function permohonanDitugaskan()
    {
        return $this->hasMany(PermohonanPetugas::class, 'assigned_by');
    }

    public function riwayatStatus()
    {
        return $this->hasMany(RiwayatStatus::class, 'changed_by');
    }

    public function hasilPemeriksaan()
    {
        return $this->hasMany(HasilPemeriksaan::class, 'diperiksa_oleh');
    }

    public function komentar()
    {
        return $this->hasMany(KomentarPermohonan::class);
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class);
    }

    public function aktivitasLog()
    {
        return $this->hasMany(AktivitasLog::class);
    }
}