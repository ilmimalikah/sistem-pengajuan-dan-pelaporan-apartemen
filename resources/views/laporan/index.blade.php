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

    <form class="card mt-8 flex flex-wrap items-end gap-4 p-4" method="get" action="/laporan">
        <div class="grow sm:max-w-[260px]">
            <label for="cari" class="field-label">Cari</label>
            <input type="text" id="cari" name="cari" class="field-input" placeholder="Kata kunci deskripsi" value="{{ request('cari') }}">
        </div>
        <div>
            <label for="status" class="field-label">Status</label>
            <select id="status" name="status" class="field-input">
                <option value="">Semua status</option>
                @foreach (['Menunggu', 'Diproses', 'Selesai', 'Ditolak'] as $status)
                    <option value="{{ $status }}" @if (request('status') == $status) selected @endif>{{ $status }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="kategori" class="field-label">Kategori</label>
            <select id="kategori" name="kategori" class="field-input">
                <option value="">Semua kategori</option>
                @foreach ($kategoriList as $k)
                    <option value="{{ $k->id_kategori }}" @if (request('kategori') == $k->id_kategori) selected @endif>{{ $k->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="btn-ghost">Terapkan</button>
            @if (request()->hasAny(['cari', 'status', 'kategori']))
                <a href="/laporan" class="btn-text">Reset</a>
            @endif
        </div>
    </form>

    @if ($laporan->isEmpty())
        <div class="card mt-8 px-6 py-14 text-center">
            <p class="text-sm text-ink-soft">Belum ada laporan yang cocok.</p>
            <a href="/laporan/buat" class="btn-ghost mt-5">Buat laporan pertama</a>
        </div>
    @else
        <div class="card mt-6 overflow-x-auto">
            <table class="w-full min-w-[720px]">
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
                        <tr>
                            <td class="table-td text-ink-soft">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="table-td font-medium">{{ $item->fasilitas->nama_fasilitas }}</td>
                            <td class="table-td text-ink-soft">{{ $item->kategori->nama_kategori }}</td>
                            <td class="table-td text-ink-soft">
                                {{ $item->lokasi ? $item->lokasi->lantai . ' - ' . $item->lokasi->detail_lokasi : '-' }}
                            </td>
                            <td class="table-td"><x-status :status="$item->status" /></td>
                            <td class="table-td">
                                <a href="/laporan/{{ $item->id_laporan }}" class="text-sm text-ink-soft underline decoration-line underline-offset-4 hover:text-brand">Detail</a>
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