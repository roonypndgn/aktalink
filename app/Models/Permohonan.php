<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permohonan extends Model
{
    use HasFactory;

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

    protected function casts(): array
    {
        return [
            'tanggal_permohonan' => 'datetime',
            'tanggal_diteruskan' => 'datetime',
            'tanggal_selesai' => 'datetime',
        ];
    }

    public function pemohon()
    {
        return $this->belongsTo(Pemohon::class);
    }

    public function jenisLayanan()
    {
        return $this->belongsTo(JenisLayanan::class);
    }

    public function statusPermohonan()
    {
        return $this->belongsTo(StatusPermohonan::class);
    }

    public function petugasLoket()
    {
        return $this->belongsTo(User::class, 'petugas_loket_id');
    }

    public function dokumen()
    {
        return $this->hasMany(PermohonanDokumen::class);
    }

    public function penugasan()
    {
        return $this->hasMany(PermohonanPetugas::class);
    }

    public function riwayatStatus()
    {
        return $this->hasMany(RiwayatStatus::class);
    }

    public function hasilPemeriksaan()
    {
        return $this->hasMany(HasilPemeriksaan::class);
    }

    public function komentar()
    {
        return $this->hasMany(KomentarPermohonan::class);
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class);
    }
}