<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Penghuni\LaporanController;
use App\Models\Fasilitas;
use App\Models\KategoriMasalah;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

$laporanDummy = [
    [
        'id' => 1,
        'judul' => 'Lampu koridor mati',
        'pelapor' => 'Sari Wulandari',
        'telepon' => '0813-2233-4455',
        'fasilitas' => 'Lift',
        'lokasi' => 'Tower A - Lift 1',
        'kategori' => 'Kerusakan listrik',
        'tanggal' => '12 Nov 2026',
        'status' => 'Menunggu',
        'deskripsi' => 'Lampu di depan lift Tower A mati sejak dua hari lalu.',
        'riwayat' => [
            ['status' => 'Menunggu', 'waktu' => '12 Nov 2026, 19:20', 'nama' => 'Sari Wulandari', 'catatan' => 'Laporan dibuat.'],
        ],
    ],
    [
        'id' => 2,
        'judul' => 'Pipa kolam bocor',
        'pelapor' => 'Bayu Nugroho',
        'telepon' => '0857-1122-3344',
        'fasilitas' => 'Kolam Renang',
        'lokasi' => 'Lantai dasar - Sisi kolam anak',
        'kategori' => 'Kebocoran air',
        'tanggal' => '10 Nov 2026',
        'status' => 'Diproses',
        'deskripsi' => 'Ada rembesan air di sekitar kolam anak.',
        'riwayat' => [
            ['status' => 'Menunggu', 'waktu' => '10 Nov 2026, 08:15', 'nama' => 'Bayu Nugroho', 'catatan' => 'Laporan dibuat.'],
            ['status' => 'Diproses', 'waktu' => '11 Nov 2026, 09:40', 'nama' => 'Rina Kartika', 'catatan' => 'Teknisi dijadwalkan memeriksa pipa.'],
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
];

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }

    return redirect('/masuk');
});

Route::get('/masuk', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/masuk', [AuthController::class, 'login'])->middleware('guest');
Route::get('/daftar', [AuthController::class, 'showRegister'])->middleware('guest');
Route::post('/daftar', [AuthController::class, 'register'])->middleware('guest');

Route::middleware('auth')->group(function () use ($laporanDummy, $perKategori, $perFasilitas) {
    Route::post('/keluar', [AuthController::class, 'logout']);

    Route::get('/dashboard', function () {
        $laporan = Laporan::with('fasilitas')
            ->where('id_pengguna', auth()->id())
            ->latest()
            ->take(3)
            ->get();

        $jumlah = [
            'Menunggu' => Laporan::where('id_pengguna', auth()->id())->where('status', 'Menunggu')->count(),
            'Diproses' => Laporan::where('id_pengguna', auth()->id())->where('status', 'Diproses')->count(),
            'Selesai' => Laporan::where('id_pengguna', auth()->id())->where('status', 'Selesai')->count(),
            'Ditolak' => Laporan::where('id_pengguna', auth()->id())->where('status', 'Ditolak')->count(),
        ];

        return view('dashboard.penghuni', [
            'role' => 'penghuni',
            'laporan' => $laporan,
            'jumlah' => $jumlah,
        ]);
    });

    Route::get('/fasilitas', function () {
        $fasilitas = Fasilitas::withCount('lokasi')->orderBy('nama_fasilitas')->get();

        return view('fasilitas.index', [
            'role' => 'penghuni',
            'fasilitas' => $fasilitas,
        ]);
    });

    Route::get('/laporan', [LaporanController::class, 'index']);
    Route::get('/laporan/buat', [LaporanController::class, 'create']);
    Route::post('/laporan', [LaporanController::class, 'store']);
    Route::get('/laporan/lokasi/{idFasilitas}', [LaporanController::class, 'lokasiByFasilitas']);
    Route::get('/laporan/{id}', [LaporanController::class, 'show']);

    Route::get('/admin/dashboard', function () use ($laporanDummy, $perKategori, $perFasilitas) {
        $ringkasan = [
            'Menunggu' => Laporan::where('status', 'Menunggu')->count(),
            'Diproses' => Laporan::where('status', 'Diproses')->count(),
            'Selesai' => Laporan::where('status', 'Selesai')->count(),
            'Ditolak' => Laporan::where('status', 'Ditolak')->count(),
        ];

        return view('dashboard.admin', [
            'role' => 'admin',
            'laporan' => $laporanDummy,
            'perKategori' => $perKategori,
            'perFasilitas' => $perFasilitas,
            'ringkasan' => $ringkasan,
        ]);
    });

    Route::get('/admin/laporan', function () use ($laporanDummy) {
        return view('admin.laporan.index', [
            'role' => 'admin',
            'laporan' => $laporanDummy,
            'fasilitas' => Fasilitas::orderBy('nama_fasilitas')->get(),
        ]);
    });

    Route::get('/admin/laporan/{id}', function ($id) use ($laporanDummy) {
        $data = collect($laporanDummy)->firstWhere('id', (int) $id);

        if (!$data) {
            abort(404);
        }

        return view('admin.laporan.show', [
            'role' => 'admin',
            'laporan' => $data,
        ]);
    });

    Route::get('/admin/fasilitas', function () {
        return view('fasilitas.index', [
            'role' => 'admin',
            'fasilitas' => Fasilitas::withCount('lokasi')->orderBy('nama_fasilitas')->get(),
        ]);
    });

    Route::get('/admin/fasilitas/tambah', function () {
        return view('fasilitas.form', [
            'role' => 'admin',
            'judul' => 'Tambah fasilitas',
        ]);
    });

    Route::get('/admin/fasilitas/{id}/ubah', function ($id) {
        $data = Fasilitas::find($id);

        if (!$data) {
            abort(404);
        }

        return view('fasilitas.form', [
            'role' => 'admin',
            'judul' => 'Ubah fasilitas',
            'nama' => $data->nama_fasilitas,
            'deskripsi' => $data->deskripsi,
        ]);
    });

    Route::get('/admin/kategori', function () {
        $kategori = KategoriMasalah::withCount('laporan')->orderBy('nama_kategori')->get();

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

    Route::get('/admin/kategori/{id}/ubah', function ($id) {
        $data = KategoriMasalah::find($id);

        if (!$data) {
            abort(404);
        }

        return view('admin.kategori.form', [
            'role' => 'admin',
            'judul' => 'Ubah kategori',
            'nama' => $data->nama_kategori,
            'deskripsi' => $data->deskripsi,
        ]);
    });

    Route::get('/admin/lokasi', function () {
        $lokasi = App\Models\Lokasi::with('fasilitas')->orderBy('id_fasilitas')->get();

        return view('admin.lokasi.index', [
            'role' => 'admin',
            'lokasi' => $lokasi,
        ]);
    });

    Route::get('/admin/lokasi/tambah', function () {
        return view('admin.lokasi.form', [
            'role' => 'admin',
            'judul' => 'Tambah lokasi',
            'fasilitas' => Fasilitas::orderBy('nama_fasilitas')->get(),
        ]);
    });

    Route::get('/admin/lokasi/{id}/ubah', function ($id) {
        $data = App\Models\Lokasi::find($id);

        if (!$data) {
            abort(404);
        }

        return view('admin.lokasi.form', [
            'role' => 'admin',
            'judul' => 'Ubah lokasi',
            'fasilitas' => Fasilitas::orderBy('nama_fasilitas')->get(),
            'fasilitasTerpilih' => $data->id_fasilitas,
            'lantai' => $data->lantai,
            'detail' => $data->detail_lokasi,
        ]);
    });
});