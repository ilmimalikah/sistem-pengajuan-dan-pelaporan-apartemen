<?php

use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Penghuni\LaporanController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\KategoriMasalahController;
use App\Models\Fasilitas;
use App\Models\KategoriMasalah;
use App\Models\Laporan;
use App\Models\Lokasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth')->group(function () {
    Route::post('/keluar', [AuthController::class, 'logout']);

    Route::get('/dashboard', function () {
        $laporan = Laporan::with('fasilitas')
            ->where('id_pengguna', Auth::user()->id_pengguna)
            ->latest()
            ->take(3)
            ->get();

        $jumlah = [
            'Menunggu' => Laporan::where('id_pengguna', Auth::user()->id_pengguna)->where('status', 'Menunggu')->count(),
            'Diproses' => Laporan::where('id_pengguna', Auth::user()->id_pengguna)->where('status', 'Diproses')->count(),
            'Selesai' => Laporan::where('id_pengguna', Auth::user()->id_pengguna)->where('status', 'Selesai')->count(),
            'Ditolak' => Laporan::where('id_pengguna', Auth::user()->id_pengguna)->where('status', 'Ditolak')->count(),
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

    Route::get('/admin/dashboard', function () {
        $ringkasan = [
            'Menunggu' => Laporan::where('status', 'Menunggu')->count(),
            'Diproses' => Laporan::where('status', 'Diproses')->count(),
            'Selesai' => Laporan::where('status', 'Selesai')->count(),
            'Ditolak' => Laporan::where('status', 'Ditolak')->count(),
        ];

        $perKategori = Laporan::query()
            ->selectRaw('id_kategori, COUNT(*) as jumlah')
            ->with('kategori')
            ->groupBy('id_kategori')
            ->orderByDesc('jumlah')
            ->take(4)
            ->get();
        $maksKategori = max((int) $perKategori->max('jumlah'), 1);
        $perKategori = $perKategori->map(fn($item) => [
            'nama' => $item->kategori->nama_kategori,
            'jumlah' => $item->jumlah,
            'persen' => (int) round($item->jumlah / $maksKategori * 100),
        ]);

        $perFasilitas = Laporan::query()
            ->selectRaw('id_fasilitas, COUNT(*) as jumlah')
            ->with('fasilitas')
            ->groupBy('id_fasilitas')
            ->orderByDesc('jumlah')
            ->take(4)
            ->get();
        $maksFasilitas = max((int) $perFasilitas->max('jumlah'), 1);
        $perFasilitas = $perFasilitas->map(fn($item) => [
            'nama' => $item->fasilitas->nama_fasilitas,
            'jumlah' => $item->jumlah,
            'persen' => (int) round($item->jumlah / $maksFasilitas * 100),
        ]);

        return view('dashboard.admin', [
            'role' => 'admin',
            'laporan' => Laporan::with(['penghuni', 'kategori', 'fasilitas'])->latest()->take(5)->get(),
            'perKategori' => $perKategori,
            'perFasilitas' => $perFasilitas,
            'ringkasan' => $ringkasan,
        ]);
    })->middleware('admin');

    Route::middleware('admin')->prefix('admin/laporan')->name('admin.laporan.')->group(function () {
        Route::get('/', [AdminLaporanController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminLaporanController::class, 'show'])->name('show');
        Route::post('/{id}', [AdminLaporanController::class, 'update'])->name('update');
    });


    Route::middleware('admin')
        ->prefix('admin/fasilitas')
        ->name('admin.fasilitas.')
        ->controller(FasilitasController::class)
        ->group(function () {

            Route::get('/', 'index')->name('index');

            Route::get('/tambah', 'create')->name('create');

            Route::post('/', 'store')->name('store');

            Route::get('/{id}/ubah', 'edit')->name('edit');

            Route::post('/{id}/ubah', 'update')->name('update');

            Route::post('/{id}/hapus', 'destroy')->name('destroy');
        });

    Route::middleware('admin')
        ->prefix('admin/kategori')
        ->name('admin.kategori.')
        ->controller(KategoriMasalahController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/tambah', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{id}/ubah', 'edit')->name('edit');
            Route::post('/{id}/ubah', 'update')->name('update');
            Route::post('/{id}/hapus', 'destroy')->name('destroy');
        });
    Route::get('/admin/lokasi', function () {
        $lokasi = Lokasi::with('fasilitas')->orderBy('id_fasilitas')->get();

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
        $data = Lokasi::find($id);

        if (! $data) {
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
