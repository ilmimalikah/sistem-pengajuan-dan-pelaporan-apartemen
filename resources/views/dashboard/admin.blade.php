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
            <dd class="mt-1.5 text-4xl font-semibold tabular-nums">4</dd>
        </div>
        <div class="sm:px-7">
            <dt class="text-[11px] font-semibold uppercase tracking-[0.06em] text-ink-soft">Diproses</dt>
            <dd class="mt-1.5 text-4xl font-semibold tabular-nums">3</dd>
        </div>
        <div class="sm:px-7">
            <dt class="text-[11px] font-semibold uppercase tracking-[0.06em] text-ink-soft">Selesai</dt>
            <dd class="mt-1.5 text-4xl font-semibold tabular-nums">9</dd>
        </div>
        <div class="sm:px-7">
            <dt class="text-[11px] font-semibold uppercase tracking-[0.06em] text-ink-soft">Ditolak</dt>
            <dd class="mt-1.5 text-4xl font-semibold tabular-nums">2</dd>
        </div>
    </dl>

    <div class="mt-12 grid gap-10 md:grid-cols-2">
        <div>
            <h2 class="text-xl">Laporan per kategori</h2>
            <div class="mt-5 space-y-4">
                @foreach ($perKategori as $item)
                    <div>
                        <div class="flex items-baseline justify-between text-sm">
                            <span>{{ $item['nama'] }}</span>
                            <span class="text-ink-soft tabular-nums">{{ $item['jumlah'] }}</span>
                        </div>
                        <div class="mt-1.5 h-1 rounded-xs bg-line-soft">
                            <div class="h-full rounded-xs bg-brand" style="width: {{ $item['persen'] }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div>
            <h2 class="text-xl">Laporan per fasilitas</h2>
            <div class="mt-5 space-y-4">
                @foreach ($perFasilitas as $item)
                    <div>
                        <div class="flex items-baseline justify-between text-sm">
                            <span>{{ $item['nama'] }}</span>
                            <span class="text-ink-soft tabular-nums">{{ $item['jumlah'] }}</span>
                        </div>
                        <div class="mt-1.5 h-1 rounded-xs bg-line-soft">
                            <div class="h-full rounded-xs bg-brand" style="width: {{ $item['persen'] }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="mt-12 flex items-baseline justify-between">
        <h2 class="text-xl">Laporan masuk terbaru</h2>
        <a href="/admin/laporan" class="btn-text">Lihat semua</a>
    </div>

    <div class="card mt-4">
        @foreach ($laporan as $item)
            <a href="/admin/laporan/{{ $item['id'] }}" class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 transition-colors hover:bg-[#faf9f6] @if (!$loop->last) border-b border-line-soft @endif">
                <div>
                    <p class="text-sm font-medium">{{ $item['judul'] }}</p>
                    <p class="mt-1 text-xs text-ink-soft">{{ $item['pelapor'] }} &middot; {{ $item['tanggal'] }}</p>
                </div>
                <x-status :status="$item['status']" />
            </a>
        @endforeach
    </div>
@endsection
