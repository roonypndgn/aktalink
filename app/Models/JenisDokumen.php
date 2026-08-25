<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisDokumen extends Model
{
    protected $fillable = [
        'nama_dokumen',
        'kode_dokumen',
        'deskripsi',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function permohonanDokumens(): HasMany
    {
        return $this->hasMany(PermohonanDokumen::class);
    }
}