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

    @if (session('success'))
        <div class="card mt-6 px-5 py-3 text-sm">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="card mt-6 px-5 py-3 text-sm text-brand">{{ session('error') }}</div>
    @endif

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
                @forelse ($kategori as $item)
                    <tr class="transition-colors hover:bg-[#faf9f6]">
                        <td class="table-td text-ink-soft">{{ $loop->iteration }}</td>
                        <td class="table-td font-medium">{{ $item['nama'] }}</td>
                        <td class="table-td text-ink-soft">{{ $item['deskripsi'] }}</td>
                        <td class="table-td text-ink-soft">{{ $item['jumlah_laporan'] }}</td>
                        <td class="table-td whitespace-nowrap">
                            <a href="/admin/kategori/{{ $item['id'] }}/ubah" class="text-sm text-ink-soft underline decoration-line underline-offset-4 hover:text-brand">Ubah</a>
                            <form action="/admin/kategori/{{ $item['id'] }}/hapus" method="post" class="ml-4 inline" onsubmit="return confirm('Yakin hapus kategori ini?')">
                                @csrf
                                <button type="submit" class="text-sm text-ink-soft underline decoration-line underline-offset-4 hover:text-brand">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="table-td text-center text-ink-soft">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection