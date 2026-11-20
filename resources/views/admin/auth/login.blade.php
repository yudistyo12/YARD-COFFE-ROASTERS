@extends('layouts.app')

@section('title', 'Login admin — YARD & COFFEE ROASTERS')

@section('content')
<main class="login-page">
    <div class="login-card">
        <img src="{{ asset('images/yard-coffee-roasters-mark.png') }}" alt="" class="login-mark">
        <span class="eyebrow">AREA TERBATAS</span>
        <h1>Selamat <em>datang.</em></h1>
        <p>Masuk untuk mengelola produk dan pesanan YARD &amp; COFFEE ROASTERS.</p>
        @if ($errors->any())<div class="alert-error">{{ $errors->first() }}</div>@endif
        <form action="{{ route('admin.login.store') }}" method="POST" class="login-form">
            @csrf
            <label class="form-field">Email admin<input type="email" name="email" value="{{ old('email') }}" autocomplete="username" required autofocus></label>
            <label class="form-field">Kata sandi<input type="password" name="password" autocomplete="current-password" required></label>
            <label class="remember-option"><input type="checkbox" name="remember" value="1"> Ingat saya di perangkat ini</label>
            <button type="submit" class="button button-dark">Masuk ke dashboard <span>↗</span></button>
        </form>
        <a class="back-link" href="{{ route('home') }}">← Kembali ke toko</a>
    </div>
</main>
@endsection
