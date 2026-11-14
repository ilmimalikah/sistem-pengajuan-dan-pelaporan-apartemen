@extends('layouts.app')

@section('title', 'Dashboard Penghuni')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-[32px] leading-tight">Selamat pagi, Dimas</h1>
            <p class="mt-1 text-sm text-ink-soft">Ringkasan laporan permasalahan fasilitas Anda.</p>
        </div>
        <a href="/laporan/buat" class="btn-primary">Buat Laporan</a>
    </div>

    <dl class="mt-10 grid grid-cols-2 gap-y-8 border-y border-line py-7 sm:grid-cols-4 sm:divide-x sm:divide-line">
        <div class="sm:px-7 sm:pl-0">
            <dt class="text-[11px] font-semibold uppercase tracking-[0.06em] text-ink-soft">Menunggu</dt>
            <dd class="mt-1.5 text-4xl font-semibold tabular-nums">1</dd>
        </div>
        <div class="sm:px-7">
            <dt class="text-[11px] font-semibold uppercase tracking-[0.06em] text-ink-soft">Diproses</dt>
            <dd class="mt-1.5 text-4xl font-semibold tabular-nums">1</dd>
        </div>
        <div class="sm:px-7">
            <dt class="text-[11px] font-semibold uppercase tracking-[0.06em] text-ink-soft">Selesai</dt>
            <dd class="mt-1.5 text-4xl font-semibold tabular-nums">2</dd>
        </div>
        <div class="sm:px-7">
            <dt class="text-[11px] font-semibold uppercase tracking-[0.06em] text-ink-soft">Ditolak</dt>
            <dd class="mt-1.5 text-4xl font-semibold tabular-nums">0</dd>
        </div>
    </dl>

    <div class="mt-12 flex items-baseline justify-between">
        <h2 class="text-xl">Laporan terbaru</h2>
        <a href="/laporan" class="btn-text">Lihat semua</a>
    </div>

    <div class="card mt-4">
        @foreach ($laporan as $item)
            <a href="/laporan/{{ $item['id'] }}" class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 transition-colors hover:bg-[#faf9f6] @if (!$loop->last) border-b border-line-soft @endif">
                <div>
                    <p class="text-sm font-medium">{{ $item['judul'] }}</p>
                    <p class="mt-1 text-xs text-ink-soft">{{ $item['fasilitas'] }} &middot; {{ $item['tanggal'] }}</p>
                </div>
                <x-status :status="$item['status']" />
            </a>
        @endforeach
    </div>
@endsection
