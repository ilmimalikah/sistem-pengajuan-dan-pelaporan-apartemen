@extends('layouts.app')

@section('title', 'Detail Laporan')

@php $role = 'admin'; @endphp

@section('content')
    <div class="grid gap-12 lg:grid-cols-[1fr_340px]">
        <div>
            <a href="/admin/laporan" class="text-sm text-ink-soft hover:text-brand">&larr; Kembali ke daftar laporan</a>

            <div class="mt-5 flex flex-wrap items-start justify-between gap-3">
                <div>
                    <h1 class="text-[30px] leading-tight">{{ $laporan['judul'] }}</h1>
                    <p class="mt-1 text-sm text-ink-soft">Dibuat {{ $laporan['tanggal'] }}</p>
                </div>
                <x-status :status="$laporan['status']" />
            </div>

            <dl class="mt-9 rounded-xs border border-line bg-white">
                <div class="flex items-baseline justify-between gap-6 border-b border-line-soft px-5 py-3.5">
                    <dt class="text-[11px] font-semibold uppercase tracking-[0.06em] text-ink-soft">Pelapor</dt>
                    <dd class="text-right text-sm">{{ $laporan['pelapor'] }}</dd>
                </div>
                <div class="flex items-baseline justify-between gap-6 border-b border-line-soft px-5 py-3.5">
                    <dt class="text-[11px] font-semibold uppercase tracking-[0.06em] text-ink-soft">Telepon</dt>
                    <dd class="text-right text-sm">{{ $laporan['telepon'] }}</dd>
                </div>
                <div class="flex items-baseline justify-between gap-6 border-b border-line-soft px-5 py-3.5">
                    <dt class="text-[11px] font-semibold uppercase tracking-[0.06em] text-ink-soft">Fasilitas</dt>
                    <dd class="text-right text-sm">{{ $laporan['fasilitas'] }}</dd>
                </div>
                <div class="flex items-baseline justify-between gap-6 border-b border-line-soft px-5 py-3.5">
                    <dt class="text-[11px] font-semibold uppercase tracking-[0.06em] text-ink-soft">Lokasi</dt>
                    <dd class="text-right text-sm">{{ $laporan['lokasi'] }}</dd>
                </div>
                <div class="flex items-baseline justify-between gap-6 px-5 py-3.5">
                    <dt class="text-[11px] font-semibold uppercase tracking-[0.06em] text-ink-soft">Kategori</dt>
                    <dd class="text-right text-sm">{{ $laporan['kategori'] }}</dd>
                </div>
            </dl>

            <div class="mt-10">
                <h2 class="text-lg">Deskripsi permasalahan</h2>
                <p class="mt-3 text-sm leading-relaxed text-ink-soft">{{ $laporan['deskripsi'] }}</p>
            </div>

            <div class="mt-10">
                <h2 class="text-lg">Riwayat status</h2>
                <div class="mt-5">
                    <x-riwayat :riwayat="$laporan['riwayat']" />
                </div>
            </div>
        </div>

        <aside class="lg:pt-9">
            <div class="card p-6">
                <h2 class="text-lg">Tindak lanjut</h2>
                <form action="/admin/laporan/{{ $laporan['id'] }}" method="post" class="mt-5 space-y-5">
                    <div>
                        <label for="status" class="field-label">Status</label>
                        <select id="status" name="status" class="field-input">
                            <option>Menunggu</option>
                            <option selected>Diproses</option>
                            <option>Selesai</option>
                            <option>Ditolak</option>
                        </select>
                    </div>
                    <div>
                        <label for="catatan" class="field-label">Catatan</label>
                        <textarea id="catatan" name="catatan" rows="4" class="field-input" placeholder="Tindak lanjut yang dilakukan"></textarea>
                    </div>
                    <button type="submit" class="btn-primary w-full">Simpan perubahan</button>
                </form>
            </div>
        </aside>
    </div>
@endsection
