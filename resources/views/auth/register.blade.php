@extends('layouts.guest')

@section('title', 'Daftar')

@section('content')
    <h1 class="text-[26px] leading-tight">Daftar penghuni</h1>
    <p class="mt-1.5 text-sm text-ink-soft">Buat akun untuk melaporkan permasalahan fasilitas.</p>

    @if ($errors->any())
        <div class="mt-5 border-l-2 border-brand bg-brand-soft px-4 py-3 text-sm text-ink">
            <ul class="space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/daftar" method="post" class="mt-7 space-y-5">
        @csrf

        <div>
            <label for="nama" class="field-label">Nama lengkap</label>
            <input type="text" id="nama" name="nama" class="field-input" placeholder="Nama sesuai KTP" value="{{ old('nama') }}">
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="email" class="field-label">Email</label>
                <input type="email" id="email" name="email" class="field-input" placeholder="nama@email.com" value="{{ old('email') }}">
            </div>
            <div>
                <label for="nomor_telepon" class="field-label">Nomor telepon</label>
                <input type="tel" id="nomor_telepon" name="nomor_telepon" class="field-input" placeholder="08xx" value="{{ old('nomor_telepon') }}">
            </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="password" class="field-label">Kata sandi</label>
                <input type="password" id="password" name="password" class="field-input" placeholder="Minimal 8 karakter">
            </div>
            <div>
                <label for="password_confirmation" class="field-label">Ulangi kata sandi</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="field-input" placeholder="Ulangi kata sandi">
            </div>
        </div>

        <button type="submit" class="btn-primary w-full">Daftar</button>
    </form>

    <p class="mt-6 text-sm text-ink-soft">
        Sudah punya akun?
        <a href="/masuk" class="text-ink underline decoration-line underline-offset-4 hover:text-brand">Masuk</a>
    </p>
@endsection
