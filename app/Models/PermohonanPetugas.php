<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermohonanPetugas extends Model
{
    protected $table = 'permohonan_petugas';

    protected $fillable = [
        'permohonan_id',
        'user_id',
        'assigned_by',
        'assigned_at',
        'accepted_at',
        'finished_at',
        'is_active',
        'keterangan',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'accepted_at' => 'datetime',
        'finished_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(Permohonan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}