@extends('layouts.app')

@section('title', 'Fasilitas')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-[30px] leading-tight">Fasilitas</h1>
            <p class="mt-1 text-sm text-ink-soft">Daftar fasilitas yang tersedia di lingkungan apartemen.</p>
        </div>
        @if ($role == 'admin')
            <a href="/admin/fasilitas/tambah" class="btn-primary">Tambah fasilitas</a>
        @endif
    </div>

    <div class="card mt-8 overflow-x-auto">
        <table class="w-full min-w-[640px]">
            <thead>
                <tr>
                    <th class="table-th w-12">No</th>
                    <th class="table-th">Nama fasilitas</th>
                    <th class="table-th">Deskripsi</th>
                    <th class="table-th">Jumlah lokasi</th>
                    @if ($role == 'admin')
                        <th class="table-th w-40">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($fasilitas as $item)
                    <tr class="transition-colors hover:bg-[#faf9f6]">
                        <td class="table-td text-ink-soft">{{ $loop->iteration }}</td>
                        <td class="table-td font-medium">{{ $item->nama_fasilitas }}</td>
                        <td class="table-td text-ink-soft">{{ $item->deskripsi }}</td>
                        <td class="table-td text-ink-soft">{{ $item->lokasi_count }} lokasi</td>
                        @if ($role == 'admin')
                            <td class="table-td">
                                <a href="/admin/fasilitas/{{ $item->id_fasilitas }}/ubah"
                                    class="text-ink-soft hover:text-brand" title="Ubah">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('admin.fasilitas.destroy', $item->id_fasilitas) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    <button type="submit" class="ml-4 text-ink-soft hover:text-red-600" title="Hapus">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
