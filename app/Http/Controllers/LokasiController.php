<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    private function daftarFasilitas(): array
    {
        return Fasilitas::orderBy('nama_fasilitas')->get()->map(fn ($f) => [
            'id' => $f->id_fasilitas,
            'nama' => $f->nama_fasilitas,
            'deskripsi' => $f->deskripsi,
            'jumlah_lokasi' => 0,
        ])->all();
    }

    private function ubah($l): array
    {
        return [
            'id' => $l->id_lokasi,
            'id_fasilitas' => $l->id_fasilitas,
            'fasilitas' => $l->fasilitas->nama_fasilitas ?? '-',
            'lantai' => $l->lantai,
            'detail' => $l->detail_lokasi,
        ];
    }

    public function index()
    {
        $lokasi = Lokasi::with('fasilitas')->orderBy('id_fasilitas')->get()
            ->map(fn ($l) => $this->ubah($l))->all();

        return view('admin.lokasi.index', [
            'role' => 'admin',
            'lokasi' => $lokasi,
        ]);
    }

    public function create()
    {
        return view('admin.lokasi.form', [
            'role' => 'admin',
            'judul' => 'Tambah lokasi',
            'fasilitas' => $this->daftarFasilitas(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_fasilitas' => 'required|exists:fasilitas,id_fasilitas',
            'lantai' => 'required|string|max:100',
            'detail_lokasi' => 'nullable|string|max:255',
        ]);

        Lokasi::create($data);

        return redirect('/admin/lokasi')->with('success', 'Lokasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $l = Lokasi::with('fasilitas')->findOrFail($id);

        return view('admin.lokasi.form', [
            'role' => 'admin',
            'judul' => 'Ubah lokasi',
            'lokasi' => $this->ubah($l),
            'fasilitas' => $this->daftarFasilitas(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $l = Lokasi::findOrFail($id);

        $data = $request->validate([
            'id_fasilitas' => 'required|exists:fasilitas,id_fasilitas',
            'lantai' => 'required|string|max:100',
            'detail_lokasi' => 'nullable|string|max:255',
        ]);

        $l->update($data);

        return redirect('/admin/lokasi')->with('success', 'Lokasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $l = Lokasi::withCount('laporan')->findOrFail($id);

        if ($l->laporan_count > 0) {
            return redirect('/admin/lokasi')
                ->with('error', 'Lokasi masih dipakai oleh laporan, tidak bisa dihapus.');
        }

        $l->delete();

        return redirect('/admin/lokasi')->with('success', 'Lokasi berhasil dihapus.');
    }
}