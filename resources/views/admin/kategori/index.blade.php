@extends('layouts.app')

@section('title', 'Kategori Masalah')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-[30px] leading-tight">Kategori Masalah</h1>
            <p class="mt-1 text-sm text-ink-soft">
                Kategori yang dipakai penghuni saat membuat laporan.
            </p>
        </div>

        <a href="{{ route('admin.kategori.create') }}" class="btn-primary">
            Tambah kategori
        </a>
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
                @forelse ($kategori as $item)
                    <tr class="transition-colors hover:bg-[#faf9f6]">
                        <td class="table-td text-ink-soft">
                            {{ $loop->iteration }}
                        </td>

                        <td class="table-td font-medium">
                            {{ $item['nama'] }}
                        </td>

                        <td class="table-td text-ink-soft">
                            {{ $item['deskripsi'] ?? '-' }}
                        </td>

                        <td class="table-td text-ink-soft">
                            {{ $item['jumlah_laporan'] }}
                        </td>

                        <td class="table-td">
                            <a href="{{ route('admin.kategori.edit', $item['id']) }}" class="text-ink-soft hover:text-brand"
                                title="Ubah">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <form action="{{ route('admin.kategori.destroy', $item['id']) }}" method="POST" class="inline"
                                onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                @csrf

                                <button type="submit" class="ml-4 text-ink-soft hover:text-red-600" title="Hapus">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="table-td py-8 text-center text-ink-soft">
                            Belum ada kategori masalah.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
