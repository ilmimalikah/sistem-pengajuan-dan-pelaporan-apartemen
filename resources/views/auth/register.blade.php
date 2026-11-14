@extends('layouts.guest')

@section('title', 'Daftar')

@section('content')
    <h1 class="text-[26px] leading-tight">Daftar penghuni</h1>
    <p class="mt-1.5 text-sm text-ink-soft">Buat akun untuk melaporkan permasalahan fasilitas.</p>

    <form action="/masuk" method="get" class="mt-7 space-y-5">
        <div>
            <label for="nama" class="field-label">Nama lengkap</label>
            <input type="text" id="nama" name="nama" class="field-input" placeholder="Nama sesuai KTP">
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="email" class="field-label">Email</label>
                <input type="email" id="email" name="email" class="field-input" placeholder="nama@email.com">
            </div>
            <div>
                <label for="telepon" class="field-label">Nomor telepon</label>
                <input type="tel" id="telepon" name="telepon" class="field-input" placeholder="08xx">
            </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="password" class="field-label">Kata sandi</label>
                <input type="password" id="password" name="password" class="field-input" placeholder="Minimal 8 karakter">
            </div>
            <div>
                <label for="password2" class="field-label">Ulangi kata sandi</label>
                <input type="password" id="password2" name="password2" class="field-input" placeholder="Ulangi kata sandi">
            </div>
        </div>

        <div>
            <label for="unit" class="field-label">Unit apartemen</label>
            <input type="text" id="unit" name="unit" class="field-input" placeholder="Contoh: Tower A / 12-03">
        </div>

        <button type="submit" class="btn-primary w-full">Daftar</button>
    </form>

    <p class="mt-6 text-sm text-ink-soft">
        Sudah punya akun?
        <a href="/masuk" class="text-ink underline decoration-line underline-offset-4 hover:text-brand">Masuk</a>
    </p>
@endsection
