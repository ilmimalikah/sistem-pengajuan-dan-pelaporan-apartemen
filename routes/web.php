<?php

use Illuminate\Support\Facades\Route;

$fasilitas = [
    ['id' => 1, 'nama' => 'Kolam Renang', 'deskripsi' => 'Kolam renang outdoor lantai dasar', 'jumlah_lokasi' => 2],
    ['id' => 2, 'nama' => 'Lift', 'deskripsi' => 'Lift penumpang tiap tower', 'jumlah_lokasi' => 4],
    ['id' => 3, 'nama' => 'Taman', 'deskripsi' => 'Taman dan area hijau bersama', 'jumlah_lokasi' => 3],
    ['id' => 4, 'nama' => 'Parkir Basement', 'deskripsi' => 'Area parkir penghuni', 'jumlah_lokasi' => 2],
    ['id' => 5, 'nama' => 'Ruang Serbaguna', 'deskripsi' => 'Aula untuk kegiatan penghuni', 'jumlah_lokasi' => 1],
];

$kategori = [
    ['id' => 1, 'nama' => 'Kebocoran air', 'deskripsi' => 'Pipa bocor atau genangan air', 'jumlah_laporan' => 5],
    ['id' => 2, 'nama' => 'Kerusakan listrik', 'deskripsi' => 'Lampu mati atau korsleting', 'jumlah_laporan' => 4],
    ['id' => 3, 'nama' => 'Kebersihan', 'deskripsi' => 'Sampah menumpuk atau area kotor', 'jumlah_laporan' => 6],
    ['id' => 4, 'nama' => 'Kerusakan fasilitas', 'deskripsi' => 'Peralatan rusak atau tidak berfungsi', 'jumlah_laporan' => 3],
];

$lokasi = [
    ['id' => 1, 'fasilitas' => 'Kolam Renang', 'lantai' => 'Lantai dasar', 'detail' => 'Sisi kolam anak'],
    ['id' => 2, 'fasilitas' => 'Lift', 'lantai' => 'Tower A', 'detail' => 'Lift 1'],
    ['id' => 3, 'fasilitas' => 'Lift', 'lantai' => 'Tower B', 'detail' => 'Lift 2'],
    ['id' => 4, 'fasilitas' => 'Taman', 'lantai' => 'Lantai dasar', 'detail' => 'Dekat gazebo'],
    ['id' => 5, 'fasilitas' => 'Parkir Basement', 'lantai' => 'Basement 1', 'detail' => 'Zona B'],
];

$laporan = [
    [
        'id' => 1,
        'judul' => 'Lampu koridor mati',
        'pelapor' => 'Dimas Prakoso',
        'telepon' => '0812-3456-7890',
        'fasilitas' => 'Lift',
        'lokasi' => 'Tower A - Lift 1',
        'kategori' => 'Kerusakan listrik',
        'tanggal' => '12 Nov 2026',
        'status' => 'Menunggu',
        'deskripsi' => 'Lampu di depan lift Tower A mati sejak dua hari lalu. Koridor menjadi gelap pada malam hari.',
        'riwayat' => [
            ['status' => 'Menunggu', 'waktu' => '12 Nov 2026, 19:20', 'nama' => 'Dimas Prakoso', 'catatan' => 'Laporan dibuat.'],
        ],
    ],
    [
        'id' => 2,
        'judul' => 'Pipa kolam bocor',
        'pelapor' => 'Dimas Prakoso',
        'telepon' => '0812-3456-7890',
        'fasilitas' => 'Kolam Renang',
        'lokasi' => 'Lantai dasar - Sisi kolam anak',
        'kategori' => 'Kebocoran air',
        'tanggal' => '10 Nov 2026',
        'status' => 'Diproses',
        'deskripsi' => 'Ada rembesan air di sekitar kolam anak. Area lantai menjadi licin.',
        'riwayat' => [
            ['status' => 'Menunggu', 'waktu' => '10 Nov 2026, 08:15', 'nama' => 'Dimas Prakoso', 'catatan' => 'Laporan dibuat.'],
            ['status' => 'Diproses', 'waktu' => '11 Nov 2026, 09:40', 'nama' => 'Rina Kartika', 'catatan' => 'Teknisi dijadwalkan memeriksa pipa.'],
        ],
    ],
    [
        'id' => 3,
        'judul' => 'Sampah menumpuk di taman',
        'pelapor' => 'Dimas Prakoso',
        'telepon' => '0812-3456-7890',
        'fasilitas' => 'Taman',
        'lokasi' => 'Lantai dasar - Dekat gazebo',
        'kategori' => 'Kebersihan',
        'tanggal' => '05 Nov 2026',
        'status' => 'Selesai',
        'deskripsi' => 'Tempat sampah di dekat gazebo penuh dan tidak diangkut selama tiga hari.',
        'riwayat' => [
            ['status' => 'Menunggu', 'waktu' => '05 Nov 2026, 07:10', 'nama' => 'Dimas Prakoso', 'catatan' => 'Laporan dibuat.'],
            ['status' => 'Diproses', 'waktu' => '05 Nov 2026, 10:00', 'nama' => 'Rina Kartika', 'catatan' => 'Petugas kebersihan dihubungi.'],
            ['status' => 'Selesai', 'waktu' => '06 Nov 2026, 08:30', 'nama' => 'Rina Kartika', 'catatan' => 'Sampah sudah diangkut dan area dibersihkan.'],
        ],
    ],
    [
        'id' => 4,
        'judul' => 'Pintu lift tidak menutup',
        'pelapor' => 'Sari Wulandari',
        'telepon' => '0813-2233-4455',
        'fasilitas' => 'Lift',
        'lokasi' => 'Tower B - Lift 2',
        'kategori' => 'Kerusakan fasilitas',
        'tanggal' => '13 Nov 2026',
        'status' => 'Menunggu',
        'deskripsi' => 'Pintu lift Tower B tidak menutup sempurna dan sering terbuka kembali.',
        'riwayat' => [
            ['status' => 'Menunggu', 'waktu' => '13 Nov 2026, 16:45', 'nama' => 'Sari Wulandari', 'catatan' => 'Laporan dibuat.'],
        ],
    ],
    [
        'id' => 5,
        'judul' => 'Lampu parkir redup',
        'pelapor' => 'Bayu Nugroho',
        'telepon' => '0857-1122-3344',
        'fasilitas' => 'Parkir Basement',
        'lokasi' => 'Basement 1 - Zona B',
        'kategori' => 'Kerusakan listrik',
        'tanggal' => '09 Nov 2026',
        'status' => 'Ditolak',
        'deskripsi' => 'Lampu di zona B redup sehingga sulit melihat saat memarkir kendaraan.',
        'riwayat' => [
            ['status' => 'Menunggu', 'waktu' => '09 Nov 2026, 20:05', 'nama' => 'Bayu Nugroho', 'catatan' => 'Laporan dibuat.'],
            ['status' => 'Ditolak', 'waktu' => '10 Nov 2026, 11:20', 'nama' => 'Rina Kartika', 'catatan' => 'Lampu sudah dijadwalkan diganti pada pemeliharaan rutin bulan ini.'],
        ],
    ],
];

$perKategori = [
    ['nama' => 'Kebersihan', 'jumlah' => 6, 'persen' => 100],
    ['nama' => 'Kebocoran air', 'jumlah' => 5, 'persen' => 83],
    ['nama' => 'Kerusakan listrik', 'jumlah' => 4, 'persen' => 67],
    ['nama' => 'Kerusakan fasilitas', 'jumlah' => 3, 'persen' => 50],
];

$perFasilitas = [
    ['nama' => 'Lift', 'jumlah' => 6, 'persen' => 100],
    ['nama' => 'Kolam Renang', 'jumlah' => 4, 'persen' => 67],
    ['nama' => 'Taman', 'jumlah' => 3, 'persen' => 50],
    ['nama' => 'Parkir Basement', 'jumlah' => 2, 'persen' => 33],
    ['nama' => 'Ruang Serbaguna', 'jumlah' => 1, 'persen' => 17],
];

$lokasiPerFasilitas = [
    '1' => ['Lantai dasar - Sisi kolam anak', 'Lantai dasar - Sisi kolam dewasa'],
    '2' => ['Tower A - Lift 1', 'Tower B - Lift 2'],
    '3' => ['Lantai dasar - Dekat gazebo', 'Lantai dasar - Sisi timur'],
    '4' => ['Basement 1 - Zona A', 'Basement 1 - Zona B'],
    '5' => ['Lantai 2 - Aula utama'],
];

Route::get('/', function () {
    return redirect('/masuk');
});

Route::get('/masuk', function () {
    return view('auth.login');
});

Route::get('/daftar', function () {
    return view('auth.register');
});

Route::get('/dashboard', function () use ($laporan) {
    return view('dashboard.penghuni', [
        'role' => 'penghuni',
        'laporan' => array_slice($laporan, 0, 3),
    ]);
});

Route::get('/laporan', function () use ($laporan, $kategori) {
    return view('laporan.index', [
        'role' => 'penghuni',
        'laporan' => array_slice($laporan, 0, 3),
        'kategori' => $kategori,
    ]);
});

Route::get('/laporan/buat', function () use ($fasilitas, $kategori, $lokasiPerFasilitas) {
    return view('laporan.create', [
        'role' => 'penghuni',
        'fasilitas' => $fasilitas,
        'kategori' => $kategori,
        'lokasiPerFasilitas' => $lokasiPerFasilitas,
    ]);
});

Route::get('/laporan/{id}', function ($id) use ($laporan) {
    $data = collect($laporan)->firstWhere('id', (int) $id);

    return view('laporan.show', [
        'role' => 'penghuni',
        'laporan' => $data,
    ]);
});

Route::get('/fasilitas', function () use ($fasilitas) {
    return view('fasilitas.index', [
        'role' => 'penghuni',
        'fasilitas' => $fasilitas,
    ]);
});

Route::get('/admin/dashboard', function () use ($laporan, $perKategori, $perFasilitas) {
    return view('dashboard.admin', [
        'role' => 'admin',
        'laporan' => array_slice($laporan, 0, 4),
        'perKategori' => $perKategori,
        'perFasilitas' => $perFasilitas,
    ]);
});

Route::get('/admin/laporan', function () use ($laporan, $fasilitas) {
    return view('admin.laporan.index', [
        'role' => 'admin',
        'laporan' => $laporan,
        'fasilitas' => $fasilitas,
    ]);
});

Route::get('/admin/laporan/{id}', function ($id) use ($laporan) {
    $data = collect($laporan)->firstWhere('id', (int) $id);

    return view('admin.laporan.show', [
        'role' => 'admin',
        'laporan' => $data,
    ]);
});

Route::get('/admin/fasilitas', function () use ($fasilitas) {
    return view('fasilitas.index', [
        'role' => 'admin',
        'fasilitas' => $fasilitas,
    ]);
});

Route::get('/admin/fasilitas/tambah', function () {
    return view('fasilitas.form', [
        'role' => 'admin',
        'judul' => 'Tambah fasilitas',
    ]);
});

Route::get('/admin/fasilitas/{id}/ubah', function ($id) use ($fasilitas) {
    $data = collect($fasilitas)->firstWhere('id', (int) $id);

    return view('fasilitas.form', [
        'role' => 'admin',
        'judul' => 'Ubah fasilitas',
        'fasilitas' => $data,
    ]);
});

Route::get('/admin/kategori', function () use ($kategori) {
    return view('admin.kategori.index', [
        'role' => 'admin',
        'kategori' => $kategori,
    ]);
});

Route::get('/admin/kategori/tambah', function () {
    return view('admin.kategori.form', [
        'role' => 'admin',
        'judul' => 'Tambah kategori',
    ]);
});

Route::get('/admin/kategori/{id}/ubah', function ($id) use ($kategori) {
    $data = collect($kategori)->firstWhere('id', (int) $id);

    return view('admin.kategori.form', [
        'role' => 'admin',
        'judul' => 'Ubah kategori',
        'kategori' => $data,
    ]);
});

Route::get('/admin/lokasi', function () use ($lokasi) {
    return view('admin.lokasi.index', [
        'role' => 'admin',
        'lokasi' => $lokasi,
    ]);
});

Route::get('/admin/lokasi/tambah', function () use ($fasilitas) {
    return view('admin.lokasi.form', [
        'role' => 'admin',
        'judul' => 'Tambah lokasi',
        'fasilitas' => $fasilitas,
    ]);
});

Route::get('/admin/lokasi/{id}/ubah', function ($id) use ($lokasi, $fasilitas) {
    $data = collect($lokasi)->firstWhere('id', (int) $id);

    return view('admin.lokasi.form', [
        'role' => 'admin',
        'judul' => 'Ubah lokasi',
        'lokasi' => $data,
        'fasilitas' => $fasilitas,
    ]);
});
