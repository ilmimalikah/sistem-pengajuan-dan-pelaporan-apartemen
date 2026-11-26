<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FasilitasController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::withCount('lokasi')
            ->orderBy('nama_fasilitas')
            ->get();

        return view('fasilitas.index', [
            'role' => 'admin',
            'fasilitas' => $fasilitas,
        ]);
    }

    public function create()
    {
        return view('fasilitas.form', [
            'role' => 'admin',
            'judul' => 'Tambah Fasilitas',
            'nama' => '',
            'deskripsi' => '',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_fasilitas' => [
                'required',
                'string',
                'max:100',
                'unique:fasilitas,nama_fasilitas',
            ],
            'deskripsi' => [
                'nullable',
                'string',
            ],
        ]);

        Fasilitas::create($validated);

        return redirect()
            ->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = Fasilitas::findOrFail($id);

        return view('fasilitas.form', [
            'role' => 'admin',
            'judul' => 'Ubah Fasilitas',
            'data' => $data,
            'nama' => $data->nama_fasilitas,
            'deskripsi' => $data->deskripsi,
        ]);
    }

    public function update(Request $request, $id)
    {
        $fasilitas = Fasilitas::findOrFail($id);

        $validated = $request->validate([
            'nama_fasilitas' => [
                'required',
                'string',
                'max:100',
                Rule::unique('fasilitas', 'nama_fasilitas')
                    ->ignore($fasilitas->id_fasilitas, 'id_fasilitas'),
            ],
            'deskripsi' => [
                'nullable',
                'string',
            ],
        ]);

        $fasilitas->update($validated);

        return redirect()
            ->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);

        if (
            $fasilitas->lokasi()->exists() ||
            $fasilitas->laporan()->exists()
        ) {
            return redirect()
                ->route('admin.fasilitas.index')
                ->with('error', 'Fasilitas tidak dapat dihapus karena masih digunakan.');
        }

        $fasilitas->delete();

        return redirect()
            ->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil dihapus.');
    }
}
