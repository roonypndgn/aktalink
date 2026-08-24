<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisDokumen extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_dokumen',
        'kode_dokumen',
        'deskripsi',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function persyaratanLayanan()
    {
        return $this->hasMany(LayananPersyaratan::class);
    }

    public function dokumenPermohonan()
    {
        return $this->hasMany(PermohonanDokumen::class);
    }
}