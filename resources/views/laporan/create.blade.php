@extends('layouts.app')

@section('title', 'Buat Laporan')

@section('content')
    <div class="max-w-xl">
        <a href="/laporan" class="text-sm text-ink-soft hover:text-ink">&larr; Kembali ke Laporan Saya</a>

        <h1 class="mt-4 text-3xl">Buat laporan</h1>
        <p class="mt-1 text-sm text-ink-soft">Sampaikan permasalahan fasilitas yang Anda temui.</p>

        <form action="/laporan" method="post" class="mt-8 space-y-5">
            <div>
                <label for="fasilitas" class="field-label">Fasilitas</label>
                <select id="fasilitas" name="fasilitas" class="field-input">
                    <option value="">Pilih fasilitas</option>
                    @foreach ($fasilitas as $f)
                        <option value="{{ $f['id'] }}">{{ $f['nama'] }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="lokasi" class="field-label">Lokasi</label>
                <select id="lokasi" name="lokasi" class="field-input">
                    <option value="">Pilih fasilitas terlebih dahulu</option>
                </select>
            </div>

            <div>
                <label for="kategori" class="field-label">Kategori masalah</label>
                <select id="kategori" name="kategori" class="field-input">
                    <option value="">Pilih kategori</option>
                    @foreach ($kategori as $k)
                        <option>{{ $k['nama'] }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="deskripsi" class="field-label">Deskripsi permasalahan</label>
                <textarea id="deskripsi" name="deskripsi" rows="5" class="field-input" placeholder="Jelaskan permasalahan yang Anda temui"></textarea>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">Kirim laporan</button>
                <a href="/laporan" class="btn-ghost">Batal</a>
            </div>
        </form>
    </div>

    <script>
        const lokasiPerFasilitas = @json($lokasiPerFasilitas);

        document.getElementById('fasilitas').addEventListener('change', function () {
            const pilihLokasi = document.getElementById('lokasi');
            pilihLokasi.innerHTML = '';

            if (!this.value) {
                pilihLokasi.innerHTML = '<option value="">Pilih fasilitas terlebih dahulu</option>';
                return;
            }

            const opsiKosong = document.createElement('option');
            opsiKosong.value = '';
            opsiKosong.textContent = 'Pilih lokasi';
            pilihLokasi.appendChild(opsiKosong);

            const daftar = lokasiPerFasilitas[this.value] || [];
            for (const lokasi of daftar) {
                const opsi = document.createElement('option');
                opsi.value = lokasi;
                opsi.textContent = lokasi;
                pilihLokasi.appendChild(opsi);
            }
        });
    </script>
@endsection
