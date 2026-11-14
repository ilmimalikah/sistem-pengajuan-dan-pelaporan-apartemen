@extends('layouts.app')

@section('title', 'Kategori Masalah')

@php $role = 'admin'; @endphp

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-[30px] leading-tight">Kategori Masalah</h1>
            <p class="mt-1 text-sm text-ink-soft">Kategori yang dipakai penghuni saat membuat laporan.</p>
        </div>
        <a href="/admin/kategori/tambah" class="btn-primary">Tambah kategori</a>
    </div>

    <div class="card mt-8 overflow-x-auto">
        <table class="w-full min-w-[560px]">
            <thead>
                <tr>
                    <th class="table-th w-12">No</th>
                    <th class="table-th">Nama kategori</th>
                    <th class="table-th">Deskripsi</th>
                    <th class="table-th">Jumlah laporan</th>
                    <th class="table-th w-40">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kategori as $item)
                    <tr class="transition-colors hover:bg-[#faf9f6]">
                        <td class="table-td text-ink-soft">{{ $loop->iteration }}</td>
                        <td class="table-td font-medium">{{ $item['nama'] }}</td>
                        <td class="table-td text-ink-soft">{{ $item['deskripsi'] }}</td>
                        <td class="table-td text-ink-soft">{{ $item['jumlah_laporan'] }}</td>
                        <td class="table-td">
                            <a href="/admin/kategori/{{ $item['id'] }}/ubah" class="text-sm text-ink-soft underline decoration-line underline-offset-4 hover:text-brand">Ubah</a>
                            <a href="/admin/kategori/{{ $item['id'] }}/hapus" class="ml-4 text-sm text-ink-soft underline decoration-line underline-offset-4 hover:text-brand">Hapus</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <p class="mt-3 text-xs text-ink-soft">Data contoh untuk tampilan.</p>
@endsection
