<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lengkap',
        'petugas_pst',
        'front_office',
        'kepuasan_petugas_pst',
        'kepuasan_petugas_front_office',
        'kepuasan_sarana_prasarana',
        'kritik_saran',
    ];

    public function petugasPst()
    {
        return $this->belongsTo(User::class, 'petugas_pst')->role('pst');
    }

    public function frontOffice()
    {
        return $this->belongsTo(User::class, 'front_office')->role('front-office');
    }
}

