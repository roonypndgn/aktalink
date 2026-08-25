<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisLayanan extends Model
{
    protected $fillable = [
        'nama_layanan',
        'kode_layanan',
        'role_tujuan',
        'deskripsi',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relasi ke Permohonan
     */
    public function permohonans(): HasMany
    {
        return $this->hasMany(Permohonan::class, 'jenis_layanan_id');
    }

    /**
     * Scope untuk data aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk pencarian
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('nama_layanan', 'like', "%{$search}%")
                     ->orWhere('kode_layanan', 'like', "%{$search}%")
                     ->orWhere('deskripsi', 'like', "%{$search}%");
    }
}