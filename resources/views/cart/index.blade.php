@extends('layouts.app')

@section('title', 'Keranjang — YARD & COFFEE ROASTERS')

@section('content')
<main class="admin-page section-pad">
    <div class="container cart-container">
        <div class="cart-title"><span class="eyebrow">PILIHAN HARI INI</span><h1>Keranjang <em>belanja.</em></h1><p>Periksa kembali pesananmu sebelum melanjutkan.</p></div>
        @if ($items->isEmpty())
            <div class="cart-empty"><span>☕</span><h2>Belum ada yang menemani.</h2><p>Yuk, pilih kopi dan kudapan favoritmu.</p><a class="button button-dark" href="{{ route('home') }}#koleksi">Jelajahi koleksi <span>↗</span></a></div>
        @else
            <div class="cart-layout"><div class="cart-items">
                @foreach ($items as $item)
                    <article class="cart-row">
                        <img src="{{ $item['product']->image_url }}" alt="{{ $item['product']->name }}">
                        <div class="cart-product-info"><span>{{ $item['product']->category->name }}</span><a href="{{ route('products.show', $item['product']) }}"><strong>{{ $item['product']->name }}</strong></a><small>Rp {{ number_format((float) $item['product']->price, 0, ',', '.') }} / item</small></div>
                        <form class="cart-quantity-form" action="{{ route('cart.update', $item['product']) }}" method="POST">@csrf @method('PATCH')<label class="sr-only" for="qty-{{ $item['product']->id }}">Jumlah {{ $item['product']->name }}</label><input id="qty-{{ $item['product']->id }}" type="number" name="quantity" min="1" max="{{ min(99, $item['product']->stock) }}" value="{{ $item['quantity'] }}"><button type="submit">Perbarui</button></form>
                        <strong class="cart-subtotal">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</strong>
                        <form action="{{ route('cart.remove', $item['product']) }}" method="POST">@csrf @method('DELETE')<button class="remove-item" type="submit" aria-label="Hapus {{ $item['product']->name }}">×</button></form>
                    </article>
                @endforeach
                <a class="back-link" href="{{ route('home') }}#koleksi">← Lanjut belanja</a>
            </div><aside class="cart-summary"><span class="eyebrow">RINGKASAN</span><div><span>Subtotal</span><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></div><div><span>Pengantaran</span><span>Dihitung saat checkout</span></div><div class="summary-total"><span>Total sementara</span><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></div><a class="button button-dark" href="{{ route('checkout') }}">Lanjut checkout <span>↗</span></a><small>Pembayaran dilakukan saat pengambilan atau pesanan tiba.</small></aside></div>
        @endif
    </div>
</main>
@endsection
