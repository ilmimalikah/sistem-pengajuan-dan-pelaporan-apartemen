<?php

namespace Database\Seeders;

use App\Models\Fasilitas;
use App\Models\KategoriMasalah;
use App\Models\Laporan;
use App\Models\Lokasi;
use App\Models\RiwayatLaporan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'nama' => 'Rina Kartika',
            'email' => 'rina@example.com',
            'kata_sandi' => 'password',
            'peran' => 'admin',
            'nomor_telepon' => '081200000001',
        ]);

        $thomas = User::create([
            'nama' => 'Thomas',
            'email' => 'thomas@example.com',
            'kata_sandi' => 'password',
            'peran' => 'penghuni',
            'nomor_telepon' => '081200000002',
        ]);

        $sari = User::create([
            'nama' => 'Sari Wulandari',
            'email' => 'sari@example.com',
            'kata_sandi' => 'password',
            'peran' => 'penghuni',
            'nomor_telepon' => '081200000003',
        ]);

        $kolam = Fasilitas::create([
            'nama_fasilitas' => 'Kolam Renang',
            'deskripsi' => 'Kolam renang outdoor di lantai dasar',
        ]);

        $lift = Fasilitas::create([
            'nama_fasilitas' => 'Lift',
            'deskripsi' => 'Lift penumpang tiap tower',
        ]);

        $taman = Fasilitas::create([
            'nama_fasilitas' => 'Taman',
            'deskripsi' => 'Taman dan area hijau bersama',
        ]);

        $parkir = Fasilitas::create([
            'nama_fasilitas' => 'Parkir Basement',
            'deskripsi' => 'Area parkir penghuni',
        ]);

        $kebocoran = KategoriMasalah::create([
            'nama_kategori' => 'Kebocoran air',
            'deskripsi' => 'Pipa bocor atau genangan air',
        ]);

        $listrik = KategoriMasalah::create([
            'nama_kategori' => 'Kerusakan listrik',
            'deskripsi' => 'Lampu mati atau korsleting',
        ]);

        $kebersihan = KategoriMasalah::create([
            'nama_kategori' => 'Kebersihan',
            'deskripsi' => 'Sampah menumpuk atau area kotor',
        ]);

        $rusak = KategoriMasalah::create([
            'nama_kategori' => 'Kerusakan fasilitas',
            'deskripsi' => 'Peralatan rusak atau tidak berfungsi',
        ]);

        $lokasiKolam = Lokasi::create([
            'id_fasilitas' => $kolam->id_fasilitas,
            'lantai' => 'Lantai dasar',
            'detail_lokasi' => 'Sisi kolam anak',
        ]);

        $lokasiLiftA = Lokasi::create([
            'id_fasilitas' => $lift->id_fasilitas,
            'lantai' => 'Tower A',
            'detail_lokasi' => 'Lift 1',
        ]);

        $lokasiLiftB = Lokasi::create([
            'id_fasilitas' => $lift->id_fasilitas,
            'lantai' => 'Tower B',
            'detail_lokasi' => 'Lift 2',
        ]);

        $lokasiTaman = Lokasi::create([
            'id_fasilitas' => $taman->id_fasilitas,
            'lantai' => 'Lantai dasar',
            'detail_lokasi' => 'Dekat gazebo',
        ]);

        $lokasiParkir = Lokasi::create([
            'id_fasilitas' => $parkir->id_fasilitas,
            'lantai' => 'Basement 1',
            'detail_lokasi' => 'Zona B',
        ]);

        $laporan1 = Laporan::create([
            'id_pengguna' => $thomas->id_pengguna,
            'id_fasilitas' => $lift->id_fasilitas,
            'id_kategori' => $listrik->id_kategori,
            'id_lokasi' => $lokasiLiftA->id_lokasi,
            'deskripsi' => 'Lampu di depan lift Tower A mati sejak dua hari lalu. Koridor menjadi gelap pada malam hari.',
            'status' => 'Menunggu',
        ]);
        $this->simpanRiwayat($laporan1, $thomas->id_pengguna, 'Menunggu', 'Laporan dibuat.');

        $laporan2 = Laporan::create([
            'id_pengguna' => $thomas->id_pengguna,
            'id_fasilitas' => $kolam->id_fasilitas,
            'id_kategori' => $kebocoran->id_kategori,
            'id_lokasi' => $lokasiKolam->id_lokasi,
            'deskripsi' => 'Ada rembesan air di sekitar kolam anak. Area lantai menjadi licin dan berbahaya.',
            'status' => 'Diproses',
        ]);
        $this->simpanRiwayat($laporan2, $thomas->id_pengguna, 'Menunggu', 'Laporan dibuat.');
        $this->simpanRiwayat($laporan2, $admin->id_pengguna, 'Diproses', 'Teknisi dijadwalkan memeriksa pipa.');

        $laporan3 = Laporan::create([
            'id_pengguna' => $thomas->id_pengguna,
            'id_fasilitas' => $taman->id_fasilitas,
            'id_kategori' => $kebersihan->id_kategori,
            'id_lokasi' => $lokasiTaman->id_lokasi,
            'deskripsi' => 'Tempat sampah di dekat gazebo penuh dan tidak diangkut selama tiga hari.',
            'status' => 'Selesai',
        ]);
        $this->simpanRiwayat($laporan3, $thomas->id_pengguna, 'Menunggu', 'Laporan dibuat.');
        $this->simpanRiwayat($laporan3, $admin->id_pengguna, 'Diproses', 'Petugas kebersihan dihubungi.');
        $this->simpanRiwayat($laporan3, $admin->id_pengguna, 'Selesai', 'Sampah sudah diangkut dan area dibersihkan.');

        $laporan4 = Laporan::create([
            'id_pengguna' => $thomas->id_pengguna,
            'id_fasilitas' => $parkir->id_fasilitas,
            'id_kategori' => $listrik->id_kategori,
            'id_lokasi' => $lokasiParkir->id_lokasi,
            'deskripsi' => 'Lampu di zona B basement redup sehingga sulit melihat saat memarkir kendaraan.',
            'status' => 'Ditolak',
        ]);
        $this->simpanRiwayat($laporan4, $thomas->id_pengguna, 'Menunggu', 'Laporan dibuat.');
        $this->simpanRiwayat($laporan4, $admin->id_pengguna, 'Ditolak', 'Lampu sudah dijadwalkan diganti pada pemeliharaan rutin.');

        $laporan5 = Laporan::create([
            'id_pengguna' => $sari->id_pengguna,
            'id_fasilitas' => $lift->id_fasilitas,
            'id_kategori' => $rusak->id_kategori,
            'id_lokasi' => $lokasiLiftB->id_lokasi,
            'deskripsi' => 'Pintu lift Tower B tidak menutup sempurna dan sering terbuka kembali.',
            'status' => 'Menunggu',
        ]);
        $this->simpanRiwayat($laporan5, $sari->id_pengguna, 'Menunggu', 'Laporan dibuat.');
    }

    private function simpanRiwayat(Laporan $laporan, int $idPengguna, string $status, string $catatan): void
    {
        RiwayatLaporan::create([
            'id_laporan' => $laporan->id_laporan,
            'id_admin' => $idPengguna,
            'status' => $status,
            'catatan' => $catatan,
        ]);
    }
}
