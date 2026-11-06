<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna';

    protected $primaryKey = 'id_pengguna';

    protected $fillable = [
        'nama',
        'email',
        'kata_sandi',
        'peran',
        'nomor_telepon',
    ];

    protected $hidden = [
        'kata_sandi',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'kata_sandi' => 'hashed'
        ];
    }

    public function getAuthPasswordName()
    {
        return 'kata_sandi';
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'id_pengguna', 'id_pengguna');
    }

    public function riwayatLaporanAdmin()
    {
        return $this->hasMany(RiwayatLaporan::class, 'id_admin', 'id_pengguna');
    }
}
