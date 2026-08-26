<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Permohonan extends Model
{
    protected $fillable = [
        'nomor_permohonan',
        'pemohon_id',
        'jenis_layanan_id',
        'status_permohonan_id',
        'petugas_loket_id',
        'judul_permohonan',
        'keterangan',
        'prioritas',
        'tanggal_permohonan',
        'tanggal_diteruskan',
        'tanggal_selesai',
        'catatan_loket',
    ];

    protected $casts = [
        'tanggal_permohonan' => 'datetime',
        'tanggal_diteruskan' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    // =============================================
    // RELATIONSHIPS
    // =============================================

    public function pemohon(): BelongsTo
    {
        return $this->belongsTo(Pemohon::class);
    }

    public function jenisLayanan(): BelongsTo
    {
        return $this->belongsTo(JenisLayanan::class);
    }

    public function statusPermohonan(): BelongsTo
    {
        return $this->belongsTo(StatusPermohonan::class);
    }

    public function petugasLoket(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_loket_id');
    }

    public function dokumen(): HasMany
    {
        return $this->hasMany(PermohonanDokumen::class);
    }

    public function hasilPemeriksaan(): HasOne
    {
        return $this->hasOne(HasilPemeriksaan::class);
    }

    public function riwayatStatus(): HasMany
    {
        return $this->hasMany(RiwayatStatus::class)->orderBy('changed_at', 'desc');
    }

    public function petugasPenanganan(): HasMany
    {
        return $this->hasMany(PermohonanPetugas::class);
    }
    /**
     * Relasi ke komentar permohonan
     */
    public function komentar(): HasMany
    {
        return $this->hasMany(KomentarPermohonan::class)
            ->orderBy('created_at', 'desc');
    }

    /**
     * Relasi ke komentar internal
     */
    public function komentarInternal(): HasMany
    {
        return $this->hasMany(KomentarPermohonan::class)
            ->where('is_internal', true)
            ->orderBy('created_at', 'desc');
    }

    /**
     * Relasi ke komentar eksternal
     */
    public function komentarEksternal(): HasMany
    {
        return $this->hasMany(KomentarPermohonan::class)
            ->where('is_internal', false)
            ->orderBy('created_at', 'desc');
    }

    // =============================================
    // SCOPES
    // =============================================

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_permohonan', 'like', "%{$search}%")
                  ->orWhere('judul_permohonan', 'like', "%{$search}%")
                  ->orWhereHas('pemohon', function ($q) use ($search) {
                      $q->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%");
                  });
            });
        });

        $query->when($filters['status'] ?? null, function ($query, $status) {
            $query->where('status_permohonan_id', $status);
        });

        $query->when($filters['jenis_layanan'] ?? null, function ($query, $layanan) {
            $query->where('jenis_layanan_id', $layanan);
        });

        $query->when($filters['prioritas'] ?? null, function ($query, $prioritas) {
            $query->where('prioritas', $prioritas);
        });
    }

    public function scopePerluDiteruskan($query)
    {
        return $query->whereHas('statusPermohonan', function ($q) {
            $q->where('kode_status', 'MENUNGGU');
        });
    }

    public function scopeSedangDiproses($query)
    {
        return $query->whereHas('statusPermohonan', function ($q) {
            $q->whereIn('kode_status', ['DITERUSKAN', 'DIPROSES']);
        });
    }

    public function scopeSelesai($query)
    {
        return $query->whereHas('statusPermohonan', function ($q) {
            $q->where('kode_status', 'SELESAI');
        });
    }

    // =============================================
    // ACCESSORS
    // =============================================

    public function getWarnaPrioritasAttribute(): string
    {
        return match ($this->prioritas) {
            'urgent' => 'danger',
            'penting' => 'warning',
            default => 'secondary',
        };
    }

    public function getLabelPrioritasAttribute(): string
    {
        return match ($this->prioritas) {
            'urgent' => 'Urgent',
            'penting' => 'Penting',
            default => 'Normal',
        };
    }

    // =============================================
    // BOOT
    // =============================================

    protected static function booted()
    {
        static::creating(function ($permohonan) {
            if (empty($permohonan->nomor_permohonan)) {
                $permohonan->nomor_permohonan = self::generateNomor();
            }
        });
    }

    public static function generateNomor(): string
    {
        $tahun = date('Y');
        $bulan = date('m');
        $last = self::whereYear('created_at', $tahun)
                    ->whereMonth('created_at', $bulan)
                    ->count() + 1;

        return 'AKT/' . $tahun . '/' . $bulan . '/' . str_pad($last, 4, '0', STR_PAD_LEFT);
    }
}