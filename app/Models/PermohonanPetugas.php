<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PermohonanPetugas extends Model
{
    use HasFactory;

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

    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
            'accepted_at' => 'datetime',
            'finished_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}