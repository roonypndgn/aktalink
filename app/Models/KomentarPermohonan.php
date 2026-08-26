<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KomentarPermohonan extends Model
{
    use HasFactory;

    protected $table = 'komentar_permohonans';

    protected $fillable = [
        'permohonan_id',
        'user_id',
        'komentar',
        'is_internal',
    ];

    protected $casts = [
        'is_internal' => 'boolean',
    ];

    /**
     * Relasi ke Permohonan
     */
    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(Permohonan::class);
    }

    /**
     * Relasi ke User (pembuat komentar)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk komentar internal
     */
    public function scopeInternal($query)
    {
        return $query->where('is_internal', true);
    }

    /**
     * Scope untuk komentar eksternal
     */
    public function scopeEksternal($query)
    {
        return $query->where('is_internal', false);
    }
}