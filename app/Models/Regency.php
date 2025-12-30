<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regency extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false; // Non-auto-increment
    protected $keyType = 'integer'; // Tipe kunci utama

    protected $fillable = ['id', 'provinsi_id', 'name']; // Pastikan kolom id ada di fillable

    public function provinsi()
    {
        return $this->belongsTo(Province::class);
    }

    // Relasi ke tabel Guestbook
    public function guestbooks()
    {
        return $this->hasMany(Guestbook::class);
    }
}
