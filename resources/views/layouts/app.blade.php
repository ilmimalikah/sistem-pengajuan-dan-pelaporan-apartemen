<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Beranda') - Sistem Pelaporan Apartemen</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @if (!isset($role))
        @php $role = 'penghuni'; @endphp
    @endif

    @if (!isset($userName))
        @php $userName = $role == 'admin' ? 'Rina Kartika' : 'Dimas Prakoso'; @endphp
    @endif

    <header class="border-b border-line bg-white">
        <div class="mx-auto flex h-16 max-w-[1080px] items-center justify-between px-6">
            <div class="flex items-center gap-9">
                @if ($role == 'admin')
                    <a href="/admin/dashboard" class="text-lg font-semibold tracking-[-0.02em] text-ink">
                        Sistem Pelaporan <span class="text-brand">Apartemen</span>
                    </a>
                @else
                    <a href="/dashboard" class="text-lg font-semibold tracking-[-0.02em] text-ink">
                        Sistem Pelaporan <span class="text-brand">Apartemen</span>
                    </a>
                @endif

                <nav class="hidden items-center gap-7 text-sm md:flex">
                    @if ($role == 'admin')
                        <a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'border-b-2 border-brand pb-1 text-ink' : 'text-ink-soft hover:text-ink' }}">Dashboard</a>
                        <a href="/admin/laporan" class="{{ request()->is('admin/laporan*') ? 'border-b-2 border-brand pb-1 text-ink' : 'text-ink-soft hover:text-ink' }}">Laporan</a>
                        <a href="/admin/fasilitas" class="{{ request()->is('admin/fasilitas*') ? 'border-b-2 border-brand pb-1 text-ink' : 'text-ink-soft hover:text-ink' }}">Fasilitas</a>
                        <a href="/admin/kategori" class="{{ request()->is('admin/kategori*') ? 'border-b-2 border-brand pb-1 text-ink' : 'text-ink-soft hover:text-ink' }}">Kategori</a>
                        <a href="/admin/lokasi" class="{{ request()->is('admin/lokasi*') ? 'border-b-2 border-brand pb-1 text-ink' : 'text-ink-soft hover:text-ink' }}">Lokasi</a>
                    @else
                        <a href="/dashboard" class="{{ request()->is('dashboard') ? 'border-b-2 border-brand pb-1 text-ink' : 'text-ink-soft hover:text-ink' }}">Dashboard</a>
                        <a href="/laporan" class="{{ request()->is('laporan') ? 'border-b-2 border-brand pb-1 text-ink' : 'text-ink-soft hover:text-ink' }}">Laporan Saya</a>
                        <a href="/laporan/buat" class="{{ request()->is('laporan/buat') ? 'border-b-2 border-brand pb-1 text-ink' : 'text-ink-soft hover:text-ink' }}">Buat Laporan</a>
                        <a href="/fasilitas" class="{{ request()->is('fasilitas') ? 'border-b-2 border-brand pb-1 text-ink' : 'text-ink-soft hover:text-ink' }}">Fasilitas</a>
                    @endif
                </nav>
            </div>

            <div class="flex items-center gap-4 text-sm">
                <span class="hidden text-ink-soft sm:inline">{{ $userName }}</span>
                <span class="hidden h-4 w-px bg-line sm:inline"></span>
                <a href="/masuk" class="text-sm text-ink-soft hover:text-brand">Keluar</a>
            </div>
        </div>

        <nav class="flex gap-6 overflow-x-auto border-t border-line-soft px-6 py-2.5 text-sm md:hidden">
            @if ($role == 'admin')
                <a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'text-brand' : 'text-ink-soft' }}">Dashboard</a>
                <a href="/admin/laporan" class="{{ request()->is('admin/laporan*') ? 'text-brand' : 'text-ink-soft' }}">Laporan</a>
                <a href="/admin/fasilitas" class="{{ request()->is('admin/fasilitas*') ? 'text-brand' : 'text-ink-soft' }}">Fasilitas</a>
                <a href="/admin/kategori" class="{{ request()->is('admin/kategori*') ? 'text-brand' : 'text-ink-soft' }}">Kategori</a>
                <a href="/admin/lokasi" class="{{ request()->is('admin/lokasi*') ? 'text-brand' : 'text-ink-soft' }}">Lokasi</a>
            @else
                <a href="/dashboard" class="{{ request()->is('dashboard') ? 'text-brand' : 'text-ink-soft' }}">Dashboard</a>
                <a href="/laporan" class="{{ request()->is('laporan') ? 'text-brand' : 'text-ink-soft' }}">Laporan Saya</a>
                <a href="/laporan/buat" class="{{ request()->is('laporan/buat') ? 'text-brand' : 'text-ink-soft' }}">Buat Laporan</a>
                <a href="/fasilitas" class="{{ request()->is('fasilitas') ? 'text-brand' : 'text-ink-soft' }}">Fasilitas</a>
            @endif
        </nav>
    </header>

    <main class="mx-auto w-full max-w-[1080px] px-6 py-12">
        @if (session('status'))
            <div class="mb-6 border-l-2 border-brand bg-brand-soft px-4 py-3 text-sm text-ink">
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="mx-auto w-full max-w-[1080px] border-t border-line px-6 py-8 text-xs text-ink-soft">
        Sistem Pelaporan dan Pengajuan Apartemen
    </footer>
</body>
</html>
