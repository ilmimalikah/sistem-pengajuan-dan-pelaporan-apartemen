<?php

namespace App\Http\Controllers;

use App\Models\KategoriMasalah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriMasalahController extends Controller
{
    private function ubah($k): array
    {
        return [
            'id' => $k->id_kategori,
            'nama' => $k->nama_kategori,
            'deskripsi' => $k->deskripsi,
            'jumlah_laporan' => $k->laporan_count ?? 0,
        ];
    }

    public function index()
    {
        $kategori = KategoriMasalah::withCount('laporan')
            ->orderBy('nama_kategori')->get()
            ->map(fn ($k) => $this->ubah($k))->all();

        return view('admin.kategori.index', [
            'role' => 'admin',
            'kategori' => $kategori,
        ]);
    }

    public function create()
    {
        return view('admin.kategori.form', [
            'role' => 'admin',
            'judul' => 'Tambah kategori',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori_masalah,nama_kategori',
            'deskripsi' => 'nullable|string',
        ]);

        KategoriMasalah::create($data);

        return redirect('/admin/kategori')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $k = KategoriMasalah::findOrFail($id);

        return view('admin.kategori.form', [
            'role' => 'admin',
            'judul' => 'Ubah kategori',
            'kategori' => $this->ubah($k),
        ]);
    }

    public function update(Request $request, $id)
    {
        $k = KategoriMasalah::findOrFail($id);

        $data = $request->validate([
            'nama_kategori' => [
                'required', 'string', 'max:100',
                Rule::unique('kategori_masalah', 'nama_kategori')->ignore($k->id_kategori, 'id_kategori'),
            ],
            'deskripsi' => 'nullable|string',
        ]);

        $k->update($data);

        return redirect('/admin/kategori')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $k = KategoriMasalah::withCount('laporan')->findOrFail($id);

        if ($k->laporan_count > 0) {
            return redirect('/admin/kategori')
                ->with('error', 'Kategori masih dipakai oleh laporan, tidak bisa dihapus.');
        }

        $k->delete();

        return redirect('/admin/kategori')->with('success', 'Kategori berhasil dihapus.');
    }
}