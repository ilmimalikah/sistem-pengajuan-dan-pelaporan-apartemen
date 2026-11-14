@extends('layouts.app')

@section('title', $judul)

@php $role = 'admin'; @endphp

@section('content')
    <div class="max-w-xl">
        <a href="/admin/kategori" class="text-sm text-ink-soft hover:text-ink">&larr; Kembali ke daftar kategori</a>

        <h1 class="mt-4 text-3xl">{{ $judul }}</h1>
        <p class="mt-1 text-sm text-ink-soft">Isi data kategori masalah.</p>

        <form action="/admin/kategori" method="post" class="mt-8 space-y-5">
            <div>
                <label for="nama" class="field-label">Nama kategori</label>
                <input type="text" id="nama" name="nama" class="field-input" value="{{ $kategori['nama'] ?? '' }}" placeholder="Contoh: Kebocoran air">
            </div>

            <div>
                <label for="deskripsi" class="field-label">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" class="field-input" placeholder="Penjelasan singkat kategori">{{ $kategori['deskripsi'] ?? '' }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">Simpan</button>
                <a href="/admin/kategori" class="btn-ghost">Batal</a>
            </div>
        </form>
    </div>
@endsection
