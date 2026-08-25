<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'phone',
        'is_active',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
    ];

    /**
     * Relasi ke Permohonan (sebagai petugas loket)
     */
    public function permohonanLoket(): HasMany
    {
        return $this->hasMany(Permohonan::class, 'petugas_loket_id');
    }

    /**
     * Relasi ke PermohonanPetugas (sebagai petugas penanganan)
     */
    public function penangananPermohonan(): HasMany
    {
        return $this->hasMany(PermohonanPetugas::class, 'user_id');
    }

    /**
     * Accessor untuk label role
     */
    public function getRoleLabelAttribute(): string
    {
        $labels = [
            'admin' => 'Administrator',
            'petugas_loket' => 'Petugas Loket',
            'pengecekan_kehilangan' => 'Pengecekan Kehilangan',
            'kutipan_kedua' => 'Kutipan Kedua',
            'banjir_kepolisian' => 'Banjir Kepolisian',
            'keabsahan' => 'Keabsahan',
            'surat_pengantar' => 'Surat Pengantar',
        ];

        return $labels[$this->role] ?? $this->role;
    }

    /**
     * Accessor untuk warna role
     */
    public function getRoleColorAttribute(): string
    {
        $colors = [
            'admin' => '#07573c',
            'petugas_loket' => '#2563eb',
            'kutipan_kedua' => '#8b5cf6',
            'keabsahan' => '#06b6d4',
            'surat_pengantar' => '#10b981',
        ];

        return $colors[$this->role] ?? '#6b7280';
    }


    /**
     * Scope untuk pencarian
     */
    public function scopeSearch($query, $search)
    {
        if (empty($search)) return $query;

        return $query->where('name', 'like', "%{$search}%")
                     ->orWhere('username', 'like', "%{$search}%")
                     ->orWhere('phone', 'like', "%{$search}%")
                     ->orWhere('role', 'like', "%{$search}%");
    }

    /**
     * Scope untuk filter role
     */
    public function scopeFilterRole($query, $role)
    {
        if ($role) {
            return $query->where('role', $role);
        }
        return $query;
    }

    /**
     * Scope untuk filter status
     */
    public function scopeFilterStatus($query, $status)
    {
        if ($status !== null && $status !== '') {
            return $query->where('is_active', $status);
        }
        return $query;
    }
}