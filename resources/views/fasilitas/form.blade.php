@extends('layouts.app')

@section('title', $judul)

@section('content')
    <div class="max-w-xl">
        <a href="{{ route('admin.fasilitas.index') }}" class="text-sm text-ink-soft hover:text-ink">
            &larr; Kembali ke daftar fasilitas
        </a>

        <h1 class="mt-4 text-[30px] leading-tight">{{ $judul }}</h1>
        <p class="mt-1 text-sm text-ink-soft">Isi data fasilitas dengan lengkap.</p>

        <form
            action="{{ isset($data) ? route('admin.fasilitas.update', $data->id_fasilitas) : route('admin.fasilitas.store') }}"
            method="POST" class="mt-8 space-y-5">
            @csrf

            <div>
                <label for="nama_fasilitas" class="field-label">Nama fasilitas</label>
                <input type="text" id="nama_fasilitas" name="nama_fasilitas" class="field-input"
                    value="{{ old('nama_fasilitas', $nama ?? '') }}" placeholder="Contoh: Kolam renang" required>

                @error('nama_fasilitas')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="deskripsi" class="field-label">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" class="field-input" placeholder="Keterangan singkat fasilitas">{{ old('deskripsi', $deskripsi ?? '') }}</textarea>

                @error('deskripsi')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">Simpan</button>
                <a href="{{ route('admin.fasilitas.index') }}" class="btn-ghost">Batal</a>
            </div>
        </form>
    </div>
@endsection
