@extends('layouts.app')

@section('title', $judul)

@section('content')
    <div class="max-w-xl">
        <a href="{{ route('admin.lokasi.index') }}" class="text-sm text-ink-soft hover:text-ink">
            &larr; Kembali ke daftar lokasi
        </a>

        <h1 class="mt-4 text-[30px] leading-tight">{{ $judul }}</h1>
        <p class="mt-1 text-sm text-ink-soft">Isi data lokasi fasilitas.</p>

        <form action="{{ isset($lokasi) ? route('admin.lokasi.update', $lokasi['id']) : route('admin.lokasi.store') }}"
            method="POST" class="mt-8 space-y-5">
            @csrf

            <div>
                <label for="id_fasilitas" class="field-label">Fasilitas</label>
                <select id="id_fasilitas" name="id_fasilitas" class="field-input" required>
                    <option value="">Pilih fasilitas</option>

                    @foreach ($fasilitas as $f)
                        <option value="{{ $f['id'] }}" @selected(old('id_fasilitas', $lokasi['id_fasilitas'] ?? '') == $f['id'])>
                            {{ $f['nama'] }}
                        </option>
                    @endforeach
                </select>

                @error('id_fasilitas')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="lantai" class="field-label">Lantai</label>
                <input type="text" id="lantai" name="lantai" class="field-input"
                    value="{{ old('lantai', $lokasi['lantai'] ?? '') }}" placeholder="Contoh: Lantai 3" required>

                @error('lantai')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="detail_lokasi" class="field-label">Detail lokasi</label>
                <input type="text" id="detail_lokasi" name="detail_lokasi" class="field-input"
                    value="{{ old('detail_lokasi', $lokasi['detail'] ?? '') }}" placeholder="Contoh: Sisi dekat lift">

                @error('detail_lokasi')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">Simpan</button>
                <a href="{{ route('admin.lokasi.index') }}" class="btn-ghost">Batal</a>
            </div>
        </form>
    </div>
@endsection