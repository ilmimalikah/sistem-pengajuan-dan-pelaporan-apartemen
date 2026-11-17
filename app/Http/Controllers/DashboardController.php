<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    private function queryLaporan()
    {
        return DB::table('laporan as l')
            ->join('pengguna as p', 'p.id_pengguna', '=', 'l.id_pengguna')
            ->join('fasilitas as f', 'f.id_fasilitas', '=', 'l.id_fasilitas')
            ->join('kategori_masalah as k', 'k.id_kategori', '=', 'l.id_kategori')
            ->leftJoin('lokasi as lo', 'lo.id_lokasi', '=', 'l.id_lokasi')
            ->select(
                'l.id_laporan', 'l.deskripsi', 'l.status', 'l.created_at',
                'p.nama as pelapor', 'p.nomor_telepon',
                'f.nama_fasilitas', 'k.nama_kategori',
                'lo.lantai', 'lo.detail_lokasi'
            )
            ->orderByDesc('l.created_at')
            ->orderByDesc('l.id_laporan');
    }

    private function ubahLaporan($rows): array
    {
        return $rows->map(function ($r) {
            $lokasi = trim(($r->lantai ?? '') . ($r->detail_lokasi ? ' - ' . $r->detail_lokasi : ''));

            return [
                'id' => $r->id_laporan,
                'judul' => Str::limit($r->deskripsi, 40),
                'pelapor' => $r->pelapor,
                'telepon' => $r->nomor_telepon,
                'fasilitas' => $r->nama_fasilitas,
                'lokasi' => $lokasi ?: '-',
                'kategori' => $r->nama_kategori,
                'tanggal' => Carbon::parse($r->created_at)->format('d M Y'),
                'status' => $r->status,
                'deskripsi' => $r->deskripsi,
                'riwayat' => [],
            ];
        })->all();
    }

    private function statistik(string $tabel, string $kolomId, string $kolomNama): array
    {
        $rows = DB::table('laporan as l')
            ->join("$tabel as t", "t.$kolomId", '=', "l.$kolomId")
            ->select("t.$kolomNama as nama", DB::raw('count(*) as jumlah'))
            ->groupBy("t.$kolomId", "t.$kolomNama")
            ->orderByDesc('jumlah')
            ->get();

        $maks = max(1, (int) ($rows->first()->jumlah ?? 1));

        return $rows->map(fn ($r) => [
            'nama' => $r->nama,
            'jumlah' => (int) $r->jumlah,
            'persen' => (int) round($r->jumlah / $maks * 100),
        ])->all();
    }

    private function ringkasan($idPengguna = null): array
    {
        $q = DB::table('laporan')->select('status', DB::raw('count(*) as jumlah'))->groupBy('status');

        if ($idPengguna) {
            $q->where('id_pengguna', $idPengguna);
        }

        $per = $q->pluck('jumlah', 'status');

        return [
            'Menunggu' => (int) ($per['Menunggu'] ?? 0),
            'Diproses' => (int) ($per['Diproses'] ?? 0),
            'Selesai' => (int) ($per['Selesai'] ?? 0),
            'Ditolak' => (int) ($per['Ditolak'] ?? 0),
        ];
    }

    public function admin()
    {
        $ringkasan = $this->ringkasan();

        return view('dashboard.admin', [
            'role' => 'admin',
            'laporan' => $this->ubahLaporan($this->queryLaporan()->limit(4)->get()),
            'ringkasan' => $ringkasan,
            'total' => array_sum($ringkasan),
            'perKategori' => $this->statistik('kategori_masalah', 'id_kategori', 'nama_kategori'),
            'perFasilitas' => $this->statistik('fasilitas', 'id_fasilitas', 'nama_fasilitas'),
        ]);
    }

    public function penghuni()
    {
        $query = $this->queryLaporan();
        $idPengguna = Auth::check() ? Auth::user()->id_pengguna : null;

        // kalau sudah login, tampilkan laporan milik sendiri saja
        if ($idPengguna) {
            $query->where('l.id_pengguna', $idPengguna);
        }

        $ringkasan = $this->ringkasan($idPengguna);

        return view('dashboard.penghuni', [
            'role' => 'penghuni',
            'laporan' => $this->ubahLaporan($query->limit(3)->get()),
            'ringkasan' => $ringkasan,
            'total' => array_sum($ringkasan),
        ]);
    }
}