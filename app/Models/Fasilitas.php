<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    use HasFactory;

    protected $table = 'fasilitas';
    protected $primaryKey = 'id_fasilitas';

    protected $fillable = [
        'nama_fasilitas',
        'deskripsi',
    ];

    public function lokasi()
    {
        return $this->hasMany(Lokasi::class, 'id_fasilitas', 'id_fasilitas');
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'id_fasilitas', 'id_fasilitas');
    }
}