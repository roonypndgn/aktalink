<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pemohon extends Model
{
    protected $fillable = [
        'nik',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'nomor_hp',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Relasi ke Permohonan
     */
    public function permohonans(): HasMany
    {
        return $this->hasMany(Permohonan::class);
    }

    /**
     * Accessor untuk jenis kelamin
     */
    public function getJenisKelaminLabelAttribute(): string
    {
        return match ($this->jenis_kelamin) {
            'L' => 'Laki-laki',
            'P' => 'Perempuan',
            default => '-',
        };
    }

    /**
     * Scope untuk pencarian
     */
    public function scopeSearch($query, $search)
    {
        if (empty($search)) return $query;

        return $query->where('nik', 'like', "%{$search}%")
                     ->orWhere('nama_lengkap', 'like', "%{$search}%")
                     ->orWhere('tempat_lahir', 'like', "%{$search}%")
                     ->orWhere('alamat', 'like', "%{$search}%")
                     ->orWhere('nomor_hp', 'like', "%{$search}%");
    }

    /**
     * Scope untuk filter jenis kelamin
     */
    public function scopeFilterGender($query, $gender)
    {
        if ($gender) {
            return $query->where('jenis_kelamin', $gender);
        }
        return $query;
    }
}