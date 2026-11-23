<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use App\Models\KategoriMasalah;
use App\Models\Laporan;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $kategoriList = KategoriMasalah::orderBy('nama_kategori')->get();

        $laporan = Laporan::with(['fasilitas', 'kategori', 'lokasi'])
            ->where('id_pengguna', auth()->id())
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->filled('kategori'), function ($query) use ($request) {
                $query->where('id_kategori', $request->kategori);
            })
            ->when($request->filled('cari'), function ($query) use ($request) {
                $query->where('deskripsi', 'like', '%' . $request->cari . '%');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('laporan.index', compact('laporan', 'kategoriList'));
    }

    public function create()
    {
        $fasilitas = Fasilitas::orderBy('nama_fasilitas')->get();
        $kategori = KategoriMasalah::orderBy('nama_kategori')->get();

        return view('laporan.create', compact('fasilitas', 'kategori'));
    }

    public function lokasiByFasilitas($idFasilitas)
    {
        $lokasi = Lokasi::where('id_fasilitas', $idFasilitas)
            ->orderBy('lantai')
            ->get(['id_lokasi', 'lantai', 'detail_lokasi']);

        return response()->json($lokasi);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_fasilitas' => 'required|exists:fasilitas,id_fasilitas',
            'id_lokasi' => 'nullable|exists:lokasi,id_lokasi',
            'id_kategori' => 'required|exists:kategori_masalah,id_kategori',
            'deskripsi' => 'required|string|min:10|max:1000',
        ]);

        $laporan = Laporan::create([
            'id_pengguna' => auth()->id(),
            'id_fasilitas' => $data['id_fasilitas'],
            'id_lokasi' => $data['id_lokasi'] ?? null,
            'id_kategori' => $data['id_kategori'],
            'deskripsi' => $data['deskripsi'],
            'status' => 'Menunggu',
        ]);

        $laporan->riwayatLaporan()->create([
            'id_admin' => auth()->id(),
            'status' => 'Menunggu',
            'catatan' => 'Laporan dibuat.',
        ]);

        return redirect('/laporan/' . $laporan->id_laporan)
            ->with('status', 'Laporan berhasil dikirim.');
    }

    public function show($id)
    {
        $laporan = Laporan::with(['fasilitas', 'kategori', 'lokasi', 'riwayatLaporan.admin'])
            ->where('id_pengguna', auth()->id())
            ->findOrFail($id);

        $riwayat = $laporan->riwayatLaporan->map(function ($item) {
            return [
                'status' => $item->status,
                'waktu' => $item->created_at->format('d M Y, H:i'),
                'nama' => optional($item->admin)->nama,
                'catatan' => $item->catatan,
            ];
        });

        return view('laporan.show', compact('laporan', 'riwayat'));
    }
}