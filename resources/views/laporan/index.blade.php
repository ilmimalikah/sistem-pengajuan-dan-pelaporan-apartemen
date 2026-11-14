@extends('layouts.app')

@section('title', 'Laporan Saya')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-[30px] leading-tight">Laporan Saya</h1>
            <p class="mt-1 text-sm text-ink-soft">Daftar laporan permasalahan yang pernah Anda buat.</p>
        </div>
        <a href="/laporan/buat" class="btn-primary">Buat Laporan</a>
    </div>

    <form class="mt-8 flex flex-wrap items-end gap-3">
        <div>
            <label for="cari" class="field-label">Cari</label>
            <input type="text" id="cari" name="cari" class="field-input sm:w-64" placeholder="Kata kunci deskripsi">
        </div>
        <div>
            <label for="status" class="field-label">Status</label>
            <select id="status" name="status" class="field-input">
                <option value="">Semua status</option>
                <option>Menunggu</option>
                <option>Diproses</option>
                <option>Selesai</option>
                <option>Ditolak</option>
            </select>
        </div>
        <div>
            <label for="kategori" class="field-label">Kategori</label>
            <select id="kategori" name="kategori" class="field-input">
                <option value="">Semua kategori</option>
                @foreach ($kategori as $k)
                    <option>{{ $k['nama'] }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn-ghost">Terapkan</button>
    </form>

    <div class="card mt-6 overflow-x-auto">
        <table class="w-full min-w-[680px]">
            <thead>
                <tr>
                    <th class="table-th">Tanggal</th>
                    <th class="table-th">Fasilitas</th>
                    <th class="table-th">Kategori</th>
                    <th class="table-th">Lokasi</th>
                    <th class="table-th">Status</th>
                    <th class="table-th w-24"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporan as $item)
                    <tr class="transition-colors hover:bg-[#faf9f6]">
                        <td class="table-td text-ink-soft">{{ $item['tanggal'] }}</td>
                        <td class="table-td font-medium">{{ $item['fasilitas'] }}</td>
                        <td class="table-td text-ink-soft">{{ $item['kategori'] }}</td>
                        <td class="table-td text-ink-soft">{{ $item['lokasi'] }}</td>
                        <td class="table-td"><x-status :status="$item['status']" /></td>
                        <td class="table-td">
                            <a href="/laporan/{{ $item['id'] }}" class="text-sm text-ink-soft underline decoration-line underline-offset-4 hover:text-brand">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <p class="mt-3 text-xs text-ink-soft">Data contoh untuk tampilan.</p>
@endsection
