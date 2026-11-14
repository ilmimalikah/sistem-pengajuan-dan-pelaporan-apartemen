@extends('layouts.app')

@section('title', 'Detail Laporan')

@section('content')
    <div class="max-w-2xl">
        <a href="/laporan" class="text-sm text-ink-soft hover:text-brand">&larr; Kembali ke Laporan Saya</a>

        <div class="mt-5 flex flex-wrap items-start justify-between gap-3">
            <div>
                <h1 class="text-[30px] leading-tight">{{ $laporan['judul'] }}</h1>
                <p class="mt-1 text-sm text-ink-soft">Dibuat {{ $laporan['tanggal'] }}</p>
            </div>
            <x-status :status="$laporan['status']" />
        </div>

        <dl class="mt-9 rounded-xs border border-line bg-white">
            <div class="flex items-baseline justify-between gap-6 border-b border-line-soft px-5 py-3.5">
                <dt class="text-[11px] font-semibold uppercase tracking-[0.06em] text-ink-soft">Fasilitas</dt>
                <dd class="text-right text-sm">{{ $laporan['fasilitas'] }}</dd>
            </div>
            <div class="flex items-baseline justify-between gap-6 border-b border-line-soft px-5 py-3.5">
                <dt class="text-[11px] font-semibold uppercase tracking-[0.06em] text-ink-soft">Lokasi</dt>
                <dd class="text-right text-sm">{{ $laporan['lokasi'] }}</dd>
            </div>
            <div class="flex items-baseline justify-between gap-6 border-b border-line-soft px-5 py-3.5">
                <dt class="text-[11px] font-semibold uppercase tracking-[0.06em] text-ink-soft">Kategori</dt>
                <dd class="text-right text-sm">{{ $laporan['kategori'] }}</dd>
            </div>
            <div class="flex items-baseline justify-between gap-6 px-5 py-3.5">
                <dt class="text-[11px] font-semibold uppercase tracking-[0.06em] text-ink-soft">Pelapor</dt>
                <dd class="text-right text-sm">{{ $laporan['pelapor'] }}</dd>
            </div>
        </dl>

        <div class="mt-10">
            <h2 class="text-lg">Deskripsi</h2>
            <p class="mt-3 text-sm leading-relaxed text-ink-soft">{{ $laporan['deskripsi'] }}</p>
        </div>

        <div class="mt-10">
            <h2 class="text-lg">Riwayat status</h2>
            <div class="mt-5">
                <x-riwayat :riwayat="$laporan['riwayat']" />
            </div>
        </div>
    </div>
@endsection
