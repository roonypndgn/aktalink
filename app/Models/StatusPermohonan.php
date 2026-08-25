<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StatusPermohonan extends Model
{
    protected $fillable = [
        'nama_status',
        'kode_status',
        'urutan',
        'warna',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Relasi ke Permohonan
     */
    public function permohonans(): HasMany
    {
        return $this->hasMany(Permohonan::class, 'status_permohonan_id');
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
        return $query->where('nama_status', 'like', "%{$search}%")
                     ->orWhere('kode_status', 'like', "%{$search}%");
    }
}