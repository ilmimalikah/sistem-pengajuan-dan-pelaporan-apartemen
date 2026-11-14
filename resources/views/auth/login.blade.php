@extends('layouts.guest')

@section('title', 'Masuk')

@section('content')
    <h1 class="text-[26px] leading-tight">Masuk</h1>
    <p class="mt-1.5 text-sm text-ink-soft">Gunakan akun penghuni atau admin untuk melanjutkan.</p>

    <form action="/dashboard" method="get" class="mt-7 space-y-5">
        <div>
            <label for="email" class="field-label">Email</label>
            <input type="email" id="email" name="email" class="field-input" placeholder="nama@email.com">
        </div>

        <div>
            <label for="password" class="field-label">Kata sandi</label>
            <input type="password" id="password" name="password" class="field-input" placeholder="Kata sandi">
        </div>

        <div class="flex items-center justify-between pt-1">
            <label class="flex items-center gap-2 text-sm text-ink-soft">
                <input type="checkbox" class="h-4 w-4 rounded-xs border-line text-brand focus:ring-brand">
                Ingat saya
            </label>
            <a href="/masuk" class="text-sm text-ink-soft underline decoration-line underline-offset-4 hover:text-brand">Lupa sandi?</a>
        </div>

        <button type="submit" class="btn-primary w-full">Masuk</button>
    </form>

    <p class="mt-6 text-sm text-ink-soft">
        Belum punya akun?
        <a href="/daftar" class="text-ink underline decoration-line underline-offset-4 hover:text-brand">Daftar sebagai penghuni</a>
    </p>

    <div class="mt-8 border-t border-line-soft pt-4 text-xs text-ink-soft">
        <p><strong class="font-medium text-ink">Akun demo</strong></p>
        <p class="mt-1">Penghuni: dimas@example.com</p>
        <p>Admin: rina@example.com</p>
        <p>Sandi: password</p>
    </div>
@endsection
