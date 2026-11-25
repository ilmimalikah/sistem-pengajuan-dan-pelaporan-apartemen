<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use App\Models\KategoriMasalah;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class LaporanController extends Controller
{
    private const STATUSES = ['Menunggu', 'Diproses', 'Selesai', 'Ditolak'];

    public function index(Request $request)
    {
        $filters = $request->validate([
            'cari' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::in(self::STATUSES)],
            'fasilitas' => ['nullable', 'integer', 'exists:fasilitas,id_fasilitas'],
            'kategori' => ['nullable', 'integer', 'exists:kategori_masalah,id_kategori'],
        ]);

        $laporan = Laporan::with(['penghuni', 'fasilitas', 'kategori', 'lokasi'])
            ->when($filters['status'] ?? null, fn ($query, $status) => $query->where('status', $status))
            ->when($filters['fasilitas'] ?? null, fn ($query, $fasilitas) => $query->where('id_fasilitas', $fasilitas))
            ->when($filters['kategori'] ?? null, fn ($query, $kategori) => $query->where('id_kategori', $kategori))
            ->when($filters['cari'] ?? null, function ($query, $cari) {
                $query->where(function ($query) use ($cari) {
                    $query->where('deskripsi', 'like', '%'.$cari.'%')
                        ->orWhereHas('penghuni', function ($query) use ($cari) {
                            $query->where('nama', 'like', '%'.$cari.'%')
                                ->orWhere('email', 'like', '%'.$cari.'%')
                                ->orWhere('nomor_telepon', 'like', '%'.$cari.'%');
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.laporan.index', [
            'laporan' => $laporan,
            'fasilitas' => Fasilitas::orderBy('nama_fasilitas')->get(),
            'kategoriList' => KategoriMasalah::orderBy('nama_kategori')->get(),
            'statuses' => self::STATUSES,
        ]);
    }

    public function show(int $id)
    {
        $laporan = Laporan::with([
            'penghuni',
            'fasilitas',
            'kategori',
            'lokasi',
            'riwayatLaporan.admin',
        ])->findOrFail($id);
        $riwayat = $laporan->riwayatLaporan->sortByDesc('created_at')->map(fn ($item) => [
            'status' => $item->status,
            'waktu' => $item->created_at->format('d M Y, H:i'),
            'nama' => $item->admin?->nama,
            'catatan' => $item->catatan,
        ])->values();

        return view('admin.laporan.show', [
            'laporan' => $laporan,
            'statuses' => self::STATUSES,
            'riwayat' => $riwayat,
        ]);
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(self::STATUSES)],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($data, $id, $request) {
            $laporan = Laporan::whereKey($id)->lockForUpdate()->firstOrFail();
            $catatan = $data['catatan'] ?? null;

            if ($laporan->status === $data['status'] && blank($catatan)) {
                throw ValidationException::withMessages([
                    'catatan' => 'Pilih status berbeda atau isi catatan tindak lanjut.',
                ]);
            }

            $laporan->update(['status' => $data['status']]);
            $laporan->riwayatLaporan()->create([
                'id_admin' => $request->user()->getKey(),
                'status' => $data['status'],
                'catatan' => $catatan,
            ]);
        });

        return redirect()
            ->route('admin.laporan.show', $id)
            ->with('status', 'Tindak lanjut laporan berhasil disimpan.');
    }
}
