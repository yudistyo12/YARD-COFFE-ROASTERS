<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f3f0e9">
    <meta name="description" content="YARD & COFFEE ROASTERS — artisan coffee, small-batch roasted and thoughtfully brewed.">
    <title>@yield('title', 'YARD & COFFEE ROASTERS — Artisanal Coffee')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/yard-coffee-roasters-mark.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>
<body>
    @if (request()->routeIs('home'))
        <div class="intro-splash" id="intro-splash" hidden>
            <div class="splash-frame">
                <span class="splash-kicker">SMALL BATCH · BIG HEART</span>
                <div class="splash-logo-wrap"><span class="splash-orbit"></span><img src="{{ asset('images/yard-coffee-roasters-full.jpg') }}" alt="YARD & COFFEE ROASTERS — Est. 2026 / Artisanal Coffee"></div>
                <p>Every great day starts with a good cup.</p>
                <div class="splash-loader"><span></span></div>
            </div>
            <button class="splash-skip" type="button">Masuk ke website <span>↗</span></button>
            <span class="splash-side-note">EST. 2026 &nbsp;·&nbsp; ROASTED WITH INTENTION</span>
        </div>
    @endif
    <header class="site-header">
        <div class="container nav-wrap">
            <a class="brand" href="{{ route('home') }}" aria-label="Yard & Coffee Roasters, beranda">
                <img src="{{ asset('images/yard-coffee-roasters-mark.png') }}" alt="" class="brand-mark">
                <span class="brand-copy"><strong>YARD &amp; COFFEE ROASTERS</strong><small>EST. 2026 / ARTISANAL COFFEE</small></span>
            </a>
            <button class="menu-toggle" type="button" aria-label="Buka navigasi" aria-expanded="false">☰</button>
            <nav class="main-nav" aria-label="Navigasi utama">
                <a href="{{ route('home') }}#cerita">Our story</a>
                <a href="{{ route('home') }}#koleksi">Menu</a>
                <a href="{{ route('home') }}#kontak">Kontak</a>
                <a href="{{ route('cart.index') }}" class="nav-cart">Keranjang <span>{{ collect(session('cart', []))->sum() }}</span></a>
                <a href="{{ route('admin.login') }}" class="nav-admin">Admin <span>↗</span></a>
            </nav>
        </div>
    </header>

    @auth
        @if (auth()->user()->is_admin)
            <div class="admin-toolbar"><div class="container admin-toolbar-inner"><span>AREA ADMIN · {{ auth()->user()->name }}</span><nav><a href="{{ route('admin.dashboard') }}">Dashboard</a><a href="{{ route('admin.products.index') }}">Produk</a><a href="{{ route('admin.categories.index') }}">Kategori</a><a href="{{ route('admin.orders.index') }}">Pesanan</a><form action="{{ route('admin.logout') }}" method="POST">@csrf<button type="submit">Keluar ↗</button></form></nav></div></div>
        @endif
    @endauth

    @if (session('success'))
        <div class="container"><div class="alert-success">{{ session('success') }}</div></div>
    @endif
    @if ($errors->has('cart'))
        <div class="container"><div class="alert-error">{{ $errors->first('cart') }}</div></div>
    @endif

    @yield('content')

    <footer class="site-footer" id="kontak">
        <div class="container footer-inner">
            <div class="footer-brand">
                <a class="brand brand-light" href="{{ route('home') }}">
                    <img src="{{ asset('images/yard-coffee-roasters-mark.png') }}" alt="" class="brand-mark">
                    <span class="brand-copy"><strong>YARD &amp; COFFEE ROASTERS</strong><small>EST. 2026 / ARTISANAL COFFEE</small></span>
                </a>
                <p>Artisan coffee, disangrai dalam batch kecil dan diracik dengan penuh perhatian.</p>
            </div>
            <div class="footer-company">
                <span class="eyebrow">PERUSAHAAN</span>
                <p>PT Yudistyo Pangan Nusantara</p>
                <p>Merayakan hasil bumi Indonesia,<br>satu seduhan pada satu waktu.</p>
            </div>
            <div class="footer-contact">
                <span class="eyebrow">SAPA KAMI</span>
                <a href="mailto:hello@yardcoffeeroasters.id">hello@yardcoffeeroasters.id ↗</a>
                <span>Senin – Sabtu, 09.00 – 17.00 WIB</span>
            </div>
        </div>
        <div class="container footer-bottom"><span>© {{ date('Y') }} PT Yudistyo Pangan Nusantara</span><span>Dibuat dengan bangga di Indonesia <b>♥</b></span></div>
    </footer>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
