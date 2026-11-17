@extends('layouts.app')

@section('title', 'Lokasi Fasilitas')

@php $role = 'admin'; @endphp

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-[30px] leading-tight">Lokasi Fasilitas</h1>
            <p class="mt-1 text-sm text-ink-soft">Daftar lokasi tiap fasilitas gedung apartemen.</p>
        </div>
        <a href="/admin/lokasi/tambah" class="btn-primary">Tambah lokasi</a>
    </div>

    @if (session('success'))
        <div class="card mt-6 px-5 py-3 text-sm">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="card mt-6 px-5 py-3 text-sm text-brand">{{ session('error') }}</div>
    @endif

    <div class="card mt-8 overflow-x-auto">
        <table class="w-full min-w-[640px]">
            <thead>
                <tr>
                    <th class="table-th w-12">No</th>
                    <th class="table-th">Fasilitas</th>
                    <th class="table-th">Lantai</th>
                    <th class="table-th">Detail lokasi</th>
                    <th class="table-th w-40">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lokasi as $item)
                    <tr class="transition-colors hover:bg-[#faf9f6]">
                        <td class="table-td text-ink-soft">{{ $loop->iteration }}</td>
                        <td class="table-td font-medium">{{ $item['fasilitas'] }}</td>
                        <td class="table-td text-ink-soft">{{ $item['lantai'] }}</td>
                        <td class="table-td text-ink-soft">{{ $item['detail'] }}</td>
                        <td class="table-td">
                            <a href="/admin/lokasi/{{ $item['id'] }}/ubah" class="text-sm text-ink-soft underline decoration-line underline-offset-4 hover:text-brand">Ubah</a>
                            <form action="/admin/lokasi/{{ $item['id'] }}/hapus" method="post" class="inline" onsubmit="return confirm('Yakin hapus lokasi ini?')">
                                @csrf
                                <button type="submit" class="ml-4 text-sm text-ink-soft underline decoration-line underline-offset-4 hover:text-brand">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="table-td text-center text-ink-soft">Belum ada lokasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection