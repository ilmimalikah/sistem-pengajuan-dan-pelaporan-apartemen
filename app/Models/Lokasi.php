<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    protected $table = 'lokasi';
    protected $primaryKey = 'id_lokasi';

    protected $fillable = [
        'id_fasilitas',
        'lantai',
        'detail_lokasi',
    ];

    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class, 'id_fasilitas', 'id_fasilitas');
    }
    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'id_lokasi', 'id_lokasi');
    }
}