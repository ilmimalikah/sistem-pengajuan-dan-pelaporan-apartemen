@extends('layouts.app')

@section('title', $judul)

@php
    $role = 'admin';
    $aksi = isset($kategori) ? '/admin/kategori/' . $kategori['id'] . '/ubah' : '/admin/kategori';
@endphp

@section('content')
    <div class="max-w-xl">
        <a href="/admin/kategori" class="text-sm text-ink-soft hover:text-ink">&larr; Kembali ke daftar kategori</a>

        <h1 class="mt-4 text-3xl">{{ $judul }}</h1>
        <p class="mt-1 text-sm text-ink-soft">Isi data kategori masalah.</p>

        <form action="{{ $aksi }}" method="post" class="mt-8 space-y-5">
            @csrf

            <div>
                <label for="nama_kategori" class="field-label">Nama kategori</label>
                <input type="text" id="nama_kategori" name="nama_kategori" class="field-input" value="{{ old('nama_kategori', $kategori['nama'] ?? '') }}" placeholder="Contoh: Kebocoran air">
                @error('nama_kategori')
                    <p class="mt-1 text-xs text-brand">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="deskripsi" class="field-label">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" class="field-input" placeholder="Penjelasan singkat kategori">{{ old('deskripsi', $kategori['deskripsi'] ?? '') }}</textarea>
                @error('deskripsi')
                    <p class="mt-1 text-xs text-brand">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">Simpan</button>
                <a href="/admin/kategori" class="btn-ghost">Batal</a>
            </div>
        </form>
    </div>
@endsection