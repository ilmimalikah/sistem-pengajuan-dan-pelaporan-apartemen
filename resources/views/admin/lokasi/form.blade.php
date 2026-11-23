@extends('layouts.app')

@section('title', $judul)

@php $role = 'admin'; @endphp

@section('content')
    <div class="max-w-xl">
        <a href="/admin/lokasi" class="text-sm text-ink-soft hover:text-ink">&larr; Kembali ke daftar lokasi</a>

        <h1 class="mt-4 text-[30px] leading-tight">{{ $judul }}</h1>
        <p class="mt-1 text-sm text-ink-soft">Isi data lokasi fasilitas.</p>

        <form action="/admin/lokasi" method="post" class="mt-8 space-y-5">
            @csrf

            <div>
                <label for="id_fasilitas" class="field-label">Fasilitas</label>
                <select id="id_fasilitas" name="id_fasilitas" class="field-input">
                    <option value="">Pilih fasilitas</option>
                    @foreach ($fasilitas as $f)
                        <option value="{{ $f->id_fasilitas }}" @if (isset($fasilitasTerpilih) && $fasilitasTerpilih == $f->id_fasilitas) selected @endif>{{ $f->nama_fasilitas }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="lantai" class="field-label">Lantai</label>
                <input type="text" id="lantai" name="lantai" class="field-input" value="{{ $lantai ?? '' }}" placeholder="Contoh: Lantai 3">
            </div>

            <div>
                <label for="detail" class="field-label">Detail lokasi</label>
                <input type="text" id="detail" name="detail" class="field-input" value="{{ $detail ?? '' }}" placeholder="Contoh: Sisi dekat lift">
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">Simpan</button>
                <a href="/admin/lokasi" class="btn-ghost">Batal</a>
            </div>
        </form>
    </div>
@endsection