@extends('layouts.app')

@section('title', $judul)

@section('content')
    <div class="max-w-xl">
        <a href="{{ route('admin.kategori.index') }}" class="text-sm text-ink-soft hover:text-ink">
            &larr; Kembali ke daftar kategori
        </a>

        <h1 class="mt-4 text-[30px] leading-tight">{{ $judul }}</h1>
        <p class="mt-1 text-sm text-ink-soft">Isi data kategori masalah.</p>

        <form
            action="{{ isset($kategori) ? route('admin.kategori.update', $kategori['id']) : route('admin.kategori.store') }}"
            method="POST" class="mt-8 space-y-5">
            @csrf

            <div>
                <label for="nama_kategori" class="field-label">Nama kategori</label>
                <input type="text" id="nama_kategori" name="nama_kategori" class="field-input"
                    value="{{ old('nama_kategori', $kategori['nama'] ?? '') }}" placeholder="Contoh: Kebocoran air"
                    required>

                @error('nama_kategori')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="deskripsi" class="field-label">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" class="field-input" placeholder="Penjelasan singkat kategori">{{ old('deskripsi', $kategori['deskripsi'] ?? '') }}</textarea>

                @error('deskripsi')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">Simpan</button>
                <a href="{{ route('admin.kategori.index') }}" class="btn-ghost">Batal</a>
            </div>
        </form>
    </div>
@endsection
