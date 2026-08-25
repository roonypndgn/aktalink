<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatStatus extends Model
{
    protected $table = 'riwayat_status';

    protected $fillable = [
        'permohonan_id',
        'status_lama_id',
        'status_baru_id',
        'changed_by',
        'keterangan',
        'changed_at',
    ];

    protected $casts = [
        'changed_at' => 'datetime',
    ];

    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(Permohonan::class);
    }

    public function statusLama(): BelongsTo
    {
        return $this->belongsTo(StatusPermohonan::class, 'status_lama_id');
    }

    public function statusBaru(): BelongsTo
    {
        return $this->belongsTo(StatusPermohonan::class, 'status_baru_id');
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}