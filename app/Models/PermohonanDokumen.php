<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class PermohonanDokumen extends Model
{
    protected $table = 'permohonan_dokumens';

    protected $fillable = [
        'permohonan_id',
        'jenis_dokumen_id',
        'nama_dokumen',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'status_verifikasi',
        'keterangan',
        'uploaded_by',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'verified_at' => 'datetime',
    ];

    // RELATIONSHIPS
    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(Permohonan::class);
    }

    public function jenisDokumen(): BelongsTo
    {
        return $this->belongsTo(JenisDokumen::class);
    }

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // ============================================
    // ACCESSORS - PERBAIKAN
    // ============================================
    
    public function getFileUrlAttribute(): string
    {
        if (empty($this->file_path)) {
            return '#';
        }
        
        // Jika sudah memiliki storage prefix
        if (str_starts_with($this->file_path, 'storage/')) {
            return asset($this->file_path);
        }
        
        // Jika path sudah memiliki prefix 'permohonan/'
        if (str_starts_with($this->file_path, 'permohonan/')) {
            return asset('storage/' . $this->file_path);
        }
        
        return asset('storage/' . $this->file_path);
    }

    public function getFileSizeFormattedAttribute(): string
    {
        $bytes = $this->file_size;
        if (!$bytes || $bytes <= 0) {
            return '0 B';
        }
        
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        
        return number_format($bytes, 2) . ' ' . $units[$i];
    }

    // ============================================
    // HELPER UNTUK DELETE FILE
    // ============================================
    
    public function deleteFile(): bool
    {
        if (empty($this->file_path)) {
            return false;
        }
        
        if (Storage::disk('public')->exists($this->file_path)) {
            return Storage::disk('public')->delete($this->file_path);
        }
        
        return false;
    }
}