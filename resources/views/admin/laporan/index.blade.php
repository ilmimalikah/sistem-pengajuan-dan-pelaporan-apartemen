@extends('layouts.app')

@section('title', 'Kelola Laporan')

@php $role = 'admin'; @endphp

@section('content')
    <div>
        <h1 class="text-[30px] leading-tight">Kelola Laporan</h1>
        <p class="mt-1 text-sm text-ink-soft">Seluruh laporan permasalahan yang masuk dari penghuni.</p>
    </div>

    <form class="mt-8 flex flex-wrap items-end gap-3">
        <div>
            <label for="cari" class="field-label">Cari</label>
            <input type="text" id="cari" name="cari" class="field-input sm:w-64" placeholder="Nama pelapor atau deskripsi">
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
            <label for="fasilitas" class="field-label">Fasilitas</label>
            <select id="fasilitas" name="fasilitas" class="field-input">
                <option value="">Semua fasilitas</option>
                @foreach ($fasilitas as $f)
                    <option>{{ $f['nama'] }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn-ghost">Terapkan</button>
    </form>

    <div class="card mt-6 overflow-x-auto">
        <table class="w-full min-w-[760px]">
            <thead>
                <tr>
                    <th class="table-th">Tanggal</th>
                    <th class="table-th">Pelapor</th>
                    <th class="table-th">Fasilitas</th>
                    <th class="table-th">Kategori</th>
                    <th class="table-th">Status</th>
                    <th class="table-th w-24"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporan as $item)
                    <tr class="transition-colors hover:bg-[#faf9f6]">
                        <td class="table-td text-ink-soft">{{ $item['tanggal'] }}</td>
                        <td class="table-td font-medium">{{ $item['pelapor'] }}</td>
                        <td class="table-td text-ink-soft">{{ $item['fasilitas'] }}</td>
                        <td class="table-td text-ink-soft">{{ $item['kategori'] }}</td>
                        <td class="table-td"><x-status :status="$item['status']" /></td>
                        <td class="table-td">
                            <a href="/admin/laporan/{{ $item['id'] }}" class="text-sm text-ink-soft underline decoration-line underline-offset-4 hover:text-brand">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <p class="mt-3 text-xs text-ink-soft">Data contoh untuk tampilan.</p>
@endsection
