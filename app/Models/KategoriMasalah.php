<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriMasalah extends Model
{
    use HasFactory;

    protected $table = 'kategori_masalah';
    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'id_kategori', 'id_kategori');
    }
}
