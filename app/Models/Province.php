<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false; // Non-auto-increment
    protected $keyType = 'integer'; // Tipe kunci utama

    protected $fillable = ['id', 'name']; // Pastikan kolom id ada di fillable

    public function regencies()
    {
        return $this->hasMany(Regency::class);
    }
    
    // Relasi ke tabel Guestbook
    public function guestbooks()
    {
        return $this->hasMany(Guestbook::class);
    }
    
}
