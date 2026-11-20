@extends('layouts.app')

@section('title', $product->name.' — YARD & COFFEE ROASTERS')

@section('content')
<main class="detail-page section-pad">
    <div class="container">
        <div class="breadcrumbs"><a href="{{ route('home') }}">Beranda</a><span>/</span><a href="{{ route('home') }}#koleksi">Koleksi</a><span>/</span><span>{{ $product->name }}</span></div>
        <div class="detail-grid">
            <div class="detail-image"><img src="{{ $product->image_url }}" alt="{{ $product->name }}"><span class="product-badge">A Yard house favorite</span></div>
            <div class="detail-copy">
                <span class="eyebrow">{{ $product->category->name }} · INDONESIA</span>
                <h1>{{ $product->name }}</h1>
                <div class="detail-price">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</div>
                <p class="detail-description">{{ $product->description }}</p>
                <div class="detail-facts"><div><span>Ketersediaan</span><strong>{{ $product->stock > 0 ? 'Tersedia' : 'Habis' }}</strong></div><div><span>Stok saat ini</span><strong>{{ $product->stock }} unit</strong></div><div><span>Kategori</span><strong>{{ $product->category->name }}</strong></div></div>
                <form action="{{ route('cart.add', $product) }}" method="POST" class="detail-add-form">@csrf<label for="quantity">Jumlah</label><input id="quantity" type="number" name="quantity" min="1" max="{{ min(99, $product->stock) }}" value="1" required @disabled($product->stock < 1)><button type="submit" class="button button-dark" @disabled($product->stock < 1)>{{ $product->stock > 0 ? 'Tambah ke keranjang' : 'Stok habis' }} <span>↗</span></button></form>
                <p class="detail-note">Ingin bertanya dulu? <a href="mailto:hello@yardcoffeeroasters.id">Hubungi kami</a>, kami dengan senang hati membantu.</p>
            </div>
        </div>
        @if ($relatedProducts->isNotEmpty())
            <div class="related-products"><div class="section-heading"><div><span class="eyebrow">MUNGKIN KAMU SUKA</span><h2>Teman <em>seduhanmu.</em></h2></div><a class="text-link" href="{{ route('home') }}#koleksi">Lihat semua <span>↗</span></a></div>
                <div class="product-grid">@foreach ($relatedProducts as $related)<article class="product-card"><a class="product-image" href="{{ route('products.show', $related) }}"><img src="{{ $related->image_url }}" alt="{{ $related->name }}" loading="lazy"><span class="image-arrow">↗</span></a><div class="product-meta"><span>{{ $related->category->name }}</span><span>{{ $related->stock > 0 ? 'Ready to order' : 'Sold out' }}</span></div><a class="product-name" href="{{ route('products.show', $related) }}"><h3>{{ $related->name }}</h3></a><div class="product-bottom"><strong>Rp {{ number_format((float) $related->price, 0, ',', '.') }}</strong><a href="{{ route('products.show', $related) }}">Lihat detail <span>→</span></a></div></article>@endforeach</div>
            </div>
        @endif
    </div>
</main>
@endsection
