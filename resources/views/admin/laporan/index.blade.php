@extends('layouts.app')

@section('title', 'Kelola Laporan')

@php $role = 'admin'; @endphp

@section('content')
    <div>
        <h1 class="text-[30px] leading-tight">Kelola Laporan</h1>
        <p class="mt-1 text-sm text-ink-soft">Seluruh laporan permasalahan yang masuk dari penghuni.</p>
    </div>

    <form class="mt-8 flex flex-wrap items-end gap-3" method="get" action="{{ route('admin.laporan.index') }}">
        <div>
            <label for="cari" class="field-label">Cari</label>
            <input type="text" id="cari" name="cari" value="{{ request('cari') }}" class="field-input sm:w-64" placeholder="Nama, kontak, atau deskripsi">
        </div>
        <div>
            <label for="status" class="field-label">Status</label>
            <select id="status" name="status" class="field-input">
                <option value="">Semua status</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="fasilitas" class="field-label">Fasilitas</label>
            <select id="fasilitas" name="fasilitas" class="field-input">
                <option value="">Semua fasilitas</option>
                @foreach ($fasilitas as $item)
                    <option value="{{ $item->id_fasilitas }}" @selected((string) request('fasilitas') === (string) $item->id_fasilitas)>{{ $item->nama_fasilitas }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="kategori" class="field-label">Kategori</label>
            <select id="kategori" name="kategori" class="field-input">
                <option value="">Semua kategori</option>
                @foreach ($kategoriList as $kategori)
                    <option value="{{ $kategori->id_kategori }}" @selected((string) request('kategori') === (string) $kategori->id_kategori)>{{ $kategori->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="btn-ghost">Terapkan</button>
            @if (request()->hasAny(['cari', 'status', 'fasilitas', 'kategori']))
                <a href="{{ route('admin.laporan.index') }}" class="btn-text">Reset</a>
            @endif
        </div>
    </form>

    @if ($laporan->isEmpty())
        <div class="card mt-6 px-6 py-14 text-center">
            <p class="text-sm text-ink-soft">Belum ada laporan yang cocok.</p>
        </div>
    @else
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
                            <td class="table-td text-ink-soft">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="table-td font-medium">{{ $item->penghuni->nama }}</td>
                            <td class="table-td text-ink-soft">{{ $item->fasilitas->nama_fasilitas }}</td>
                            <td class="table-td text-ink-soft">{{ $item->kategori->nama_kategori }}</td>
                            <td class="table-td"><x-status :status="$item->status" /></td>
                            <td class="table-td">
                                <a href="{{ route('admin.laporan.show', $item->id_laporan) }}" class="text-sm text-ink-soft underline decoration-line underline-offset-4 hover:text-brand">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $laporan->links() }}
        </div>
    @endif
@endsection
