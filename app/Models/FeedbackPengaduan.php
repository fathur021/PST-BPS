<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackPengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lengkap',
        'petugas_pengaduan',
        'kepuasan_petugas_pengaduan',
        'kepuasan_sarana_prasarana_pengaduan',
        'kritik_saran',
    ];

    public function petugasPengaduan()
    {
        return $this->belongsTo(User::class, 'petugas_pengaduan');
    }

}
