<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AktivitasLog extends Model
{
    protected $table = 'aktivitas_logs';

    protected $fillable = [
        'user_id',
        'aktivitas',
        'deskripsi',
        'subject_type',
        'subject_id',
        'ip_address',
        'user_agent',
        'method',
        'url',
        'created_at',
    ];

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Relasi ke User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk pencarian
     */
    public function scopeSearch($query, $search)
    {
        if (empty($search)) return $query;

        return $query->where('aktivitas', 'like', "%{$search}%")
                     ->orWhere('deskripsi', 'like', "%{$search}%")
                     ->orWhere('ip_address', 'like', "%{$search}%")
                     ->orWhere('url', 'like', "%{$search}%")
                     ->orWhereHas('user', function ($q) use ($search) {
                         $q->where('name', 'like', "%{$search}%")
                           ->orWhere('username', 'like', "%{$search}%");
                     });
    }

    /**
     * Scope untuk filter user
     */
    public function scopeFilterUser($query, $userId)
    {
        if ($userId) {
            return $query->where('user_id', $userId);
        }
        return $query;
    }

    /**
     * Scope untuk filter subject type
     */
    public function scopeFilterSubject($query, $subject)
    {
        if ($subject) {
            return $query->where('subject_type', $subject);
        }
        return $query;
    }

    /**
     * Scope untuk filter tanggal
     */
    public function scopeFilterDate($query, $dateFrom, $dateTo)
    {
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }
        return $query;
    }

    /**
     * Log aktivitas
     */
    public static function log($aktivitas, $deskripsi = null, $subject = null)
    {
        $log = new self();
        $log->user_id = auth()->id();
        $log->aktivitas = $aktivitas;
        $log->deskripsi = $deskripsi;

        if ($subject) {
            $log->subject_type = get_class($subject);
            $log->subject_id = $subject->id;
        }

        $log->ip_address = request()->ip();
        $log->user_agent = request()->userAgent();
        $log->method = request()->method();
        $log->url = request()->fullUrl();
        $log->created_at = now();

        $log->save();

        return $log;
    }
}