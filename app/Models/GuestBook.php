<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_antrian',  // Pindah ke atas (sebelum tamu_dari)
        'tamu_dari',      // TAMBAHKAN INI
        'nama_lengkap',
        'jenis_kelamin',
        'usia',
        'pekerjaan',
        'jurusan',
        'asal_universitas',
        'asal',
        'asal_universitas_lembaga',
        'organisasi_nama_perusahaan_kantor',
        'no_hp',
        'email',
        'provinsi_id',
        'kota_id',
        'alamat',
        'tujuan_kunjungan',
        'tujuan_kunjungan_lainnya',
        'status',
        'petugas_pst',
        'in_progress_at',
        'done_at',
        'duration',
        'bukti_identitas_diri_path',
        'jenis_layanan',
        'dokumen_permintaan_informasi_publik_path',
        // 'nomor_antrian', // HAPUS/SALIN YANG INI KE ATAS
    ];

    protected $casts = [
        'tujuan_kunjungan' => 'array',
        'in_progress_at' => 'datetime',
        'done_at' => 'datetime',
        'duration' => 'integer',
    ];

    public function petugasPst()
    {
        return $this->belongsTo(User::class, 'petugas_pst')->role('pst');
    }

    public function provinsi()
    {
        return $this->belongsTo(Province::class);
    }

    public function kota()
    {
        return $this->belongsTo(Regency::class);
    }

    public function getDurationAttribute()
    {
        if ($this->in_progress_at && $this->done_at) {
            return $this->done_at->diffForHumans($this->in_progress_at, true);
        }

        return null;
    }

    public function getJenisLayananTextAttribute()
    {
        return match($this->jenis_layanan) {
            'pst' => 'PST',
            'ppid' => 'PPID',
            null => '-',
        };
    }

    /**
     * Membuat nomor antrian otomatis saat data GuestBook dibuat
     */
    protected static function booted()
    {
        static::creating(function ($guestBook) {
            // Reset per hari
            $today = now()->format('Y-m-d');
            
            // Hitung berapa banyak data hari ini
            $countToday = self::whereDate('created_at', $today)->count();
            
            // Format: 001, 002, dst
            $guestBook->nomor_antrian = str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);
        });
    }
}