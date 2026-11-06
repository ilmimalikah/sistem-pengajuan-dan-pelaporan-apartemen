<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatLaporan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_laporan';
    protected $primaryKey = 'id_riwayat';

    protected $fillable = [
        'id_laporan',
        'id_admin',
        'status',
        'catatan',
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'id_laporan', 'id_laporan');
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin', 'id_pengguna');
    }
}