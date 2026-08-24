<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatusPermohonan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_status',
        'kode_status',
        'urutan',
        'warna',
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

    public function riwayatStatusLama()
    {
        return $this->hasMany(RiwayatStatus::class, 'status_lama_id');
    }

    public function riwayatStatusBaru()
    {
        return $this->hasMany(RiwayatStatus::class, 'status_baru_id');
    }
}