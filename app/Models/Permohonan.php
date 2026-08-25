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

        $query->when($filters['date_from'] ?? null, function ($query, $date) {
            $query->whereDate('tanggal_permohonan', '>=', $date);
        });

        $query->when($filters['date_to'] ?? null, function ($query, $date) {
            $query->whereDate('tanggal_permohonan', '<=', $date);
        });
    }

    public function scopeCariNomor($query, $nomor)
    {
        return $query->where('nomor_permohonan', $nomor);
    }

    // =============================================
    // SCOPES UNTUK STATUS
    // =============================================

    /**
     * Scope untuk permohonan yang perlu diteruskan (Menunggu)
     */
    public function scopePerluDiteruskan($query)
    {
        return $query->whereHas('statusPermohonan', function ($q) {
            $q->where('kode_status', 'MENUNGGU');
        });
    }

    /**
     * Scope untuk permohonan yang sedang diproses
     */
    public function scopeSedangDiproses($query)
    {
        return $query->whereHas('statusPermohonan', function ($q) {
            $q->whereIn('kode_status', ['DITERUSKAN', 'DIPROSES']);
        });
    }

    /**
     * Scope untuk permohonan selesai
     */
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

    public function getDurasiProsesAttribute(): ?string
    {
        if (!$this->tanggal_selesai) {
            return null;
        }

        $diff = $this->tanggal_selesai->diff($this->tanggal_permohonan);
        $days = $diff->days;

        if ($days == 0) {
            return 'Kurang dari 1 hari';
        }

        return $days . ' hari';
    }

    // =============================================
    // FUNGSI DISTRIBUSI
    // =============================================

    /**
     * Distribusikan permohonan ke petugas berdasarkan role tujuan
     */
    public function distribusikanKePetugas()
    {
        $layanan = $this->jenisLayanan;
        if (!$layanan || !$layanan->role_tujuan) {
            return null;
        }

        // Cari petugas dengan role tujuan yang aktif
        $petugas = User::where('role', $layanan->role_tujuan)
                       ->where('is_active', true)
                       ->first();

        if (!$petugas) {
            return null;
        }

        // Buat penugasan
        $penugasan = PermohonanPetugas::create([
            'permohonan_id' => $this->id,
            'user_id' => $petugas->id,
            'assigned_by' => auth()->id(),
            'assigned_at' => now(),
            'is_active' => true,
        ]);

        // Update status menjadi DITERUSKAN
        $statusDiteruskan = StatusPermohonan::where('kode_status', 'DITERUSKAN')->first();
        if ($statusDiteruskan) {
            $this->update([
                'status_permohonan_id' => $statusDiteruskan->id,
                'tanggal_diteruskan' => now(),
            ]);

            // Catat riwayat
            RiwayatStatus::create([
                'permohonan_id' => $this->id,
                'status_baru_id' => $statusDiteruskan->id,
                'changed_by' => auth()->id(),
                'keterangan' => 'Permohonan diteruskan ke ' . $petugas->role_label,
                'changed_at' => now(),
            ]);
        }

        return $penugasan;
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