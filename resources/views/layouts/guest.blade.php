<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Masuk') - Sistem Pelaporan Apartemen</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <main class="mx-auto flex min-h-screen w-full max-w-[420px] flex-col justify-center px-6 py-12">
        <a href="/" class="mb-9 block text-center text-lg font-semibold tracking-[-0.02em] text-ink">
            Sistem Pelaporan <span class="text-brand">Apartemen</span>
        </a>

        <div class="rounded-xs border border-line bg-white p-9 shadow-[0_1px_2px_rgba(26,26,26,0.04)]">
            @yield('content')
        </div>

        <p class="mt-7 text-center text-xs text-ink-soft">
            &copy; {{ date('Y') }} Pengelola Apartemen
        </p>
    </main>
</body>
</html>
