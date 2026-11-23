@extends('layouts.app')

@section('title', 'Buat Laporan')

@section('content')
    <div class="max-w-xl">
        <a href="/laporan" class="text-sm text-ink-soft hover:text-brand">&larr; Kembali ke Laporan Saya</a>

        <h1 class="mt-4 text-[30px] leading-tight">Buat laporan</h1>
        <p class="mt-1 text-sm text-ink-soft">Sampaikan permasalahan fasilitas yang Anda temui.</p>

        @if ($errors->any())
            <div class="mt-6 border-l-2 border-brand bg-brand-soft px-4 py-3 text-sm text-ink">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/laporan" method="post" class="mt-8 space-y-5">
            @csrf

            <div>
                <label for="id_fasilitas" class="field-label">Fasilitas</label>
                <select id="id_fasilitas" name="id_fasilitas" class="field-input">
                    <option value="">Pilih fasilitas</option>
                    @foreach ($fasilitas as $f)
                        <option value="{{ $f->id_fasilitas }}" @if (old('id_fasilitas') == $f->id_fasilitas) selected @endif>{{ $f->nama_fasilitas }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="id_lokasi" class="field-label">Lokasi</label>
                <select id="id_lokasi" name="id_lokasi" class="field-input">
                    <option value="">Pilih fasilitas terlebih dahulu</option>
                </select>
            </div>

            <div>
                <label for="id_kategori" class="field-label">Kategori masalah</label>
                <select id="id_kategori" name="id_kategori" class="field-input">
                    <option value="">Pilih kategori</option>
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id_kategori }}" @if (old('id_kategori') == $k->id_kategori) selected @endif>{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="deskripsi" class="field-label">Deskripsi permasalahan</label>
                <textarea id="deskripsi" name="deskripsi" rows="5" class="field-input" placeholder="Jelaskan permasalahan yang Anda temui">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">Kirim laporan</button>
                <a href="/laporan" class="btn-ghost">Batal</a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('id_fasilitas').addEventListener('change', function () {
            const pilihLokasi = document.getElementById('id_lokasi');

            if (!this.value) {
                pilihLokasi.innerHTML = '<option value="">Pilih fasilitas terlebih dahulu</option>';
                return;
            }

            pilihLokasi.innerHTML = '<option value="">Memuat lokasi...</option>';

            fetch('/laporan/lokasi/' + this.value)
                .then(function (res) { return res.json(); })
                .then(function (daftar) {
                    let html = '<option value="">Pilih lokasi</option>';
                    for (const lokasi of daftar) {
                        html += '<option value="' + lokasi.id_lokasi + '">' + lokasi.lantai + ' - ' + lokasi.detail_lokasi + '</option>';
                    }
                    pilihLokasi.innerHTML = html;
                });
        });
    </script>
@endsection