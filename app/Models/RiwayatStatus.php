<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'permohonan_id',
        'status_lama_id',
        'status_baru_id',
        'changed_by',
        'keterangan',
        'changed_at',
    ];

    protected function casts(): array
    {
        return [
            'changed_at' => 'datetime',
        ];
    }

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }

    public function statusLama()
    {
        return $this->belongsTo(StatusPermohonan::class, 'status_lama_id');
    }

    public function statusBaru()
    {
        return $this->belongsTo(StatusPermohonan::class, 'status_baru_id');
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}