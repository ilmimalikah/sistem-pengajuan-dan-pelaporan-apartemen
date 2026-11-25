@extends('layouts.app')

@section('title', 'Dashboard Admin')

@php $role = 'admin'; @endphp

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-[32px] leading-tight">Dashboard admin</h1>
            <p class="mt-1 text-sm text-ink-soft">Ringkasan laporan permasalahan seluruh penghuni.</p>
        </div>
        <a href="/admin/laporan" class="btn-ghost">Kelola laporan</a>
    </div>

    <dl class="mt-10 grid grid-cols-2 gap-y-8 border-y border-line py-7 sm:grid-cols-4 sm:divide-x sm:divide-line">
        <div class="sm:px-7 sm:pl-0">
            <dt class="text-[11px] font-semibold uppercase tracking-[0.06em] text-ink-soft">Menunggu</dt>
            <dd class="mt-1.5 text-4xl font-semibold tabular-nums">{{ $ringkasan['Menunggu'] }}</dd>
        </div>
        <div class="sm:px-7">
            <dt class="text-[11px] font-semibold uppercase tracking-[0.06em] text-ink-soft">Diproses</dt>
            <dd class="mt-1.5 text-4xl font-semibold tabular-nums">{{ $ringkasan['Diproses'] }}</dd>
        </div>
        <div class="sm:px-7">
            <dt class="text-[11px] font-semibold uppercase tracking-[0.06em] text-ink-soft">Selesai</dt>
            <dd class="mt-1.5 text-4xl font-semibold tabular-nums">{{ $ringkasan['Selesai'] }}</dd>
        </div>
        <div class="sm:px-7">
            <dt class="text-[11px] font-semibold uppercase tracking-[0.06em] text-ink-soft">Ditolak</dt>
            <dd class="mt-1.5 text-4xl font-semibold tabular-nums">{{ $ringkasan['Ditolak'] }}</dd>
        </div>
    </dl>

    <div class="mt-12 grid gap-10 md:grid-cols-2">
        <div>
            <h2 class="text-xl">Laporan per kategori</h2>
            <div class="mt-5 space-y-4">
                @forelse ($perKategori as $item)
                    <div>
                        <div class="flex items-baseline justify-between text-sm">
                            <span>{{ $item['nama'] }}</span>
                            <span class="text-ink-soft tabular-nums">{{ $item['jumlah'] }}</span>
                        </div>
                        <div class="mt-1.5 h-1 rounded-xs bg-line-soft">
                            <div class="h-full rounded-xs bg-brand" style="width: {{ $item['persen'] }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-ink-soft">Belum ada data.</p>
                @endforelse
            </div>
        </div>

        <div>
            <h2 class="text-xl">Laporan per fasilitas</h2>
            <div class="mt-5 space-y-4">
                @forelse ($perFasilitas as $item)
                    <div>
                        <div class="flex items-baseline justify-between text-sm">
                            <span>{{ $item['nama'] }}</span>
                            <span class="text-ink-soft tabular-nums">{{ $item['jumlah'] }}</span>
                        </div>
                        <div class="mt-1.5 h-1 rounded-xs bg-line-soft">
                            <div class="h-full rounded-xs bg-brand" style="width: {{ $item['persen'] }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-ink-soft">Belum ada data.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="mt-12 flex items-baseline justify-between">
        <h2 class="text-xl">Laporan masuk terbaru</h2>
        <a href="/admin/laporan" class="btn-text">Lihat semua</a>
    </div>

    <div class="card mt-4">
        @forelse ($laporan as $item)
            <a href="{{ route('admin.laporan.show', $item->id_laporan) }}" class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 transition-colors hover:bg-[#faf9f6] @if (!$loop->last) border-b border-line-soft @endif">
                <div>
                    <p class="text-sm font-medium">{{ $item->kategori->nama_kategori ?? 'Laporan' }} — {{ $item->fasilitas->nama_fasilitas ?? '-' }}</p>
                    <p class="mt-1 text-xs text-ink-soft">{{ $item->penghuni->nama }} &middot; {{ $item->created_at->format('d M Y') }}</p>
                </div>
                <x-status :status="$item->status" />
            </a>
        @empty
            <p class="px-5 py-4 text-sm text-ink-soft">Belum ada laporan masuk.</p>
        @endforelse
    </div>
@endsection