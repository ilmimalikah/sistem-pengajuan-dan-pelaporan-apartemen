@extends('layouts.app')

@section('title', 'Dashboard Penghuni')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-[32px] leading-tight">Halo, {{ auth()->user()->nama }}</h1>
            <p class="mt-1 text-sm text-ink-soft">Ringkasan laporan permasalahan fasilitas Anda.</p>
        </div>
        <a href="/laporan/buat" class="btn-primary">Buat Laporan</a>
    </div>

    <dl class="mt-10 grid grid-cols-2 gap-y-8 border-y border-line py-7 sm:grid-cols-4 sm:divide-x sm:divide-line">
        <div class="sm:px-7 sm:pl-0">
            <dt class="text-[11px] font-semibold uppercase tracking-[0.06em] text-ink-soft">Menunggu</dt>
            <dd class="mt-1.5 text-4xl font-semibold tabular-nums">{{ $jumlah['Menunggu'] }}</dd>
        </div>
        <div class="sm:px-7">
            <dt class="text-[11px] font-semibold uppercase tracking-[0.06em] text-ink-soft">Diproses</dt>
            <dd class="mt-1.5 text-4xl font-semibold tabular-nums">{{ $jumlah['Diproses'] }}</dd>
        </div>
        <div class="sm:px-7">
            <dt class="text-[11px] font-semibold uppercase tracking-[0.06em] text-ink-soft">Selesai</dt>
            <dd class="mt-1.5 text-4xl font-semibold tabular-nums">{{ $jumlah['Selesai'] }}</dd>
        </div>
        <div class="sm:px-7">
            <dt class="text-[11px] font-semibold uppercase tracking-[0.06em] text-ink-soft">Ditolak</dt>
            <dd class="mt-1.5 text-4xl font-semibold tabular-nums">{{ $jumlah['Ditolak'] }}</dd>
        </div>
    </dl>

    <div class="mt-12 flex items-baseline justify-between">
        <h2 class="text-xl">Laporan terbaru</h2>
        <a href="/laporan" class="btn-text">Lihat semua</a>
    </div>

    @if ($laporan->isEmpty())
        <div class="card mt-4 px-6 py-12 text-center">
            <p class="text-sm text-ink-soft">Belum ada laporan. Mulai dengan membuat laporan pertama.</p>
            <a href="/laporan/buat" class="btn-ghost mt-5">Buat laporan</a>
        </div>
    @else
        <div class="card mt-4">
            @foreach ($laporan as $item)
                <a href="/laporan/{{ $item->id_laporan }}" class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 transition-colors hover:bg-[#faf9f6] @if (!$loop->last) border-b border-line-soft @endif">
                    <div>
                        <p class="text-sm font-medium">{{ $item->kategori->nama_kategori }} — {{ $item->fasilitas->nama_fasilitas }}</p>
                        <p class="mt-1 text-xs text-ink-soft">{{ $item->created_at->format('d M Y') }}</p>
                    </div>
                    <x-status :status="$item->status" />
                </a>
            @endforeach
        </div>
    @endif
@endsection