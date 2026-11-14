@extends('layouts.app')

@section('title', $judul)

@section('content')
    <div class="max-w-xl">
        <a href="/admin/fasilitas" class="text-sm text-ink-soft hover:text-ink">&larr; Kembali ke daftar fasilitas</a>

        <h1 class="mt-4 text-3xl">{{ $judul }}</h1>
        <p class="mt-1 text-sm text-ink-soft">Isi data fasilitas dengan lengkap.</p>

        <form action="/admin/fasilitas" method="post" class="mt-8 space-y-5">
            <div>
                <label for="nama" class="field-label">Nama fasilitas</label>
                <input type="text" id="nama" name="nama" class="field-input" value="{{ $fasilitas['nama'] ?? '' }}" placeholder="Contoh: Kolam renang">
            </div>

            <div>
                <label for="deskripsi" class="field-label">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" class="field-input" placeholder="Keterangan singkat fasilitas">{{ $fasilitas['deskripsi'] ?? '' }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">Simpan</button>
                <a href="/admin/fasilitas" class="btn-ghost">Batal</a>
            </div>
        </form>
    </div>
@endsection
