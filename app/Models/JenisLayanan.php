<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisLayanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_layanan',
        'kode_layanan',
        'role_tujuan',
        'deskripsi',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function permohonan()
    {
        return $this->hasMany(Permohonan::class);
    }

    public function persyaratan()
    {
        return $this->hasMany(LayananPersyaratan::class);
    }

    public function statusHasil()
    {
        return $this->hasMany(StatusHasil::class);
    }
}