<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';
    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'id_pengguna',
        'id_fasilitas',
        'id_kategori',
        'id_lokasi',
        'deskripsi',
        'status',
    ];

    public function penghuni()
    {
        return $this->belongsTo(User::class, 'id_pengguna', 'id_pengguna');
    }

    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class, 'id_fasilitas', 'id_fasilitas');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriMasalah::class, 'id_kategori', 'id_kategori');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi', 'id_lokasi');
    }

    public function riwayatLaporan()
    {
        return $this->hasMany(RiwayatLaporan::class, 'id_laporan', 'id_laporan');
    }
}