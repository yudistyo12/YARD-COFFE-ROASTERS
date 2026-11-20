@extends('layouts.app')

@section('content')
<main>
    <section class="hero" id="cerita">
        <div class="container hero-grid">
            <div class="hero-copy">
                <div class="eyebrow"><span class="eyebrow-line"></span> EST. 2026 · ARTISANAL COFFEE</div>
                <h1>Good coffee.<br><em>Good things grow.</em></h1>
                <p>From thoughtfully sourced Indonesian beans to your daily ritual. Small-batch roasted, carefully brewed, and always better shared.</p>
                <div class="hero-actions"><a class="button button-dark" href="#koleksi">Explore the menu <span>↗</span></a><span class="small-note">Roasted with intention since 2026.</span></div>
                <div class="hero-proof"><div class="avatar-stack"><span>Y</span><span>✳</span><span>☕</span></div><div><strong>Small batch. Always fresh.</strong><small>Indonesian origins, roasted in-house.</small></div></div>
            </div>
            <div class="hero-visual">
                <div class="hero-photo"></div>
                <div class="photo-caption"><span>01 / 03</span><span>YOUR NEIGHBORHOOD COFFEE ROASTERS</span></div>
                <div class="hero-seal"><span>ROASTED<br>WITH CARE</span><b>✳</b><span>SERVED<br>WITH SOUL</span></div>
                <span class="hero-vertical">GOOD COFFEE · GOOD THINGS GROW</span>
            </div>
        </div>
    </section>

    <section class="values-strip" aria-label="Nilai kami">
        <div class="container values-inner"><span>☼ &nbsp; Responsibly sourced</span><i></i><span>✳ &nbsp; Small-batch roasted</span><i></i><span>♡ &nbsp; Made for your daily ritual</span></div>
    </section>

    <section class="collection section-pad" id="koleksi">
        <div class="container">
            <div class="section-heading">
                <div><span class="eyebrow">FROM OUR BAR</span><h2>Your next <em>favorite.</em></h2></div>
                <p>Espresso, slow brews, house-made favorites and little treats. Find a new ritual, one cup at a time.</p>
            </div>
            <div class="category-pills"><a class="category-pill {{ $selectedCategory ? '' : 'active' }}" href="{{ route('home') }}#koleksi">Semua <span>{{ $categories->sum('products_count') }}</span></a>@foreach ($categories as $category)<a class="category-pill {{ $selectedCategory?->id === $category->id ? 'active' : '' }}" href="{{ route('home', ['category' => $category->slug]) }}#koleksi">{{ $category->name }} <span>{{ $category->products_count }}</span></a>@endforeach</div>
            <div class="product-grid">
                @forelse ($products as $product)
                    <article class="product-card">
                        <a class="product-image" href="{{ route('products.show', $product) }}">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
                            @if ($product->is_featured)<span class="product-badge">Pilihan kami</span>@endif
                            <span class="image-arrow">↗</span>
                        </a>
                        <div class="product-meta"><span>{{ $product->category->name }}</span><span>{{ $product->stock > 0 ? 'Ready to order' : 'Sold out' }}</span></div>
                        <a class="product-name" href="{{ route('products.show', $product) }}"><h3>{{ $product->name }}</h3></a>
                        <p class="product-description">{{ \Illuminate\Support\Str::limit($product->description, 92) }}</p>
                        <div class="product-bottom"><strong>Rp {{ number_format((float) $product->price, 0, ',', '.') }}</strong><form action="{{ route('cart.add', $product) }}" method="POST">@csrf<input type="hidden" name="quantity" value="1"><button type="submit" class="quick-add" @disabled($product->stock < 1)>{{ $product->stock > 0 ? '+ Keranjang' : 'Habis' }}</button></form></div>
                    </article>
                @empty
                    <div class="empty-state">Koleksi sedang disiapkan. Silakan kembali lagi nanti.</div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="story-band" id="cerita">
        <div class="container story-grid">
            <div class="story-image"><img src="https://images.unsplash.com/photo-1445116572660-236099ec97a0?auto=format&fit=crop&w=1200&q=85" alt="Suasana kedai kopi hangat" loading="lazy"><span class="story-photo-note">CATATAN DARI KEBUN · NO. 01</span></div>
            <div class="story-copy"><span class="eyebrow">A LITTLE ABOUT YARD</span><h2>Good coffee.<br><em>Good things grow.</em></h2><p>YARD &amp; COFFEE ROASTERS is a neighborhood coffee house built around the good things: honest ingredients, considered roasting, and the kind of coffee that makes you want to stay a little longer. Proudly part of PT Yudistyo Pangan Nusantara.</p><a class="text-link" href="#kontak">Come say hello <span>↗</span></a><div class="story-signature"><span class="signature-mark">Y</span><span><strong>YARD &amp; COFFEE ROASTERS</strong><small>Est. 2026 · Artisanal coffee.</small></span></div></div>
        </div>
    </section>
    <section class="newsletter"><div class="container newsletter-inner"><span class="eyebrow">A NOTE FROM THE ROASTERY</span><h2>Make room for <em>good coffee.</em></h2><p>Questions, collaborations, or just want to say hi? Our coffee's always on.</p><a class="button button-light" href="mailto:hello@yardcoffeeroasters.id">Say hello <span>↗</span></a></div></section>
</main>
@endsection
