<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HasilPemeriksaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'permohonan_id',
        'status_hasil_id',
        'diperiksa_oleh',
        'tanggal_pemeriksaan',
        'hasil_pemeriksaan',
        'keterangan',
        'rekomendasi',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pemeriksaan' => 'datetime',
        ];
    }

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }

    public function statusHasil()
    {
        return $this->belongsTo(StatusHasil::class);
    }

    public function diperiksaOleh()
    {
        return $this->belongsTo(User::class, 'diperiksa_oleh');
    }
}