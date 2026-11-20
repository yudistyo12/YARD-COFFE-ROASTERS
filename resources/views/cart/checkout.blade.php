@extends('layouts.app')

@section('title', 'Checkout — YARD & COFFEE ROASTERS')

@section('content')
<main class="admin-page section-pad">
    <div class="container cart-container">
        <a class="back-link" href="{{ route('cart.index') }}">← Kembali ke keranjang</a>
        <div class="cart-title"><span class="eyebrow">SATU LANGKAH LAGI</span><h1>Detail <em>pesanan.</em></h1><p>Isi data penerima dan pilih cara menikmati pesananmu.</p></div>
        @if ($errors->any())<div class="alert-error"><strong>Periksa kembali data pesanan:</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <form action="{{ route('checkout.store') }}" method="POST" class="checkout-layout">@csrf
            <div class="checkout-fields">
                <section class="checkout-section"><div class="form-section-title"><span>01</span><div><strong>Data pelanggan</strong><small>Supaya kami tahu ke mana pesanan akan menuju.</small></div></div><div class="form-grid"><label class="form-field form-full">Nama lengkap<input type="text" name="customer_name" value="{{ old('customer_name') }}" maxlength="120" required autocomplete="name"></label><label class="form-field">Nomor WhatsApp<input type="tel" name="phone" value="{{ old('phone') }}" maxlength="32" required autocomplete="tel" placeholder="08xxxxxxxxxx"></label><label class="form-field">Email (opsional)<input type="email" name="email" value="{{ old('email') }}" maxlength="120" autocomplete="email"></label></div></section>
                <section class="checkout-section"><div class="form-section-title"><span>02</span><div><strong>Cara menerima pesanan</strong><small>Pilih ambil di kedai atau kirim ke alamatmu.</small></div></div><div class="fulfillment-options"><label><input type="radio" name="fulfillment_method" value="pickup" @checked(old('fulfillment_method', 'pickup') === 'pickup')><span><strong>Ambil di kedai</strong><small>Bayar saat pesanan diambil.</small></span></label><label><input type="radio" name="fulfillment_method" value="delivery" @checked(old('fulfillment_method') === 'delivery')><span><strong>Antar ke alamat</strong><small>Biaya pengiriman dikonfirmasi admin.</small></span></label></div><label class="form-field delivery-address" @if(old('fulfillment_method', 'pickup') !== 'delivery') hidden @endif>Alamat pengantaran<textarea name="delivery_address" rows="3" maxlength="1000" placeholder="Nama jalan, nomor rumah, kecamatan...">{{ old('delivery_address') }}</textarea></label><label class="form-field order-notes">Catatan untuk kedai (opsional)<textarea name="notes" rows="3" maxlength="1000" placeholder="Contoh: less sugar, tanpa sedotan...">{{ old('notes') }}</textarea></label></section>
            </div>
            <aside class="cart-summary checkout-summary"><span class="eyebrow">PESANANMU</span>@foreach ($items as $item)<div class="checkout-item"><span>{{ $item['product']->name }} × {{ $item['quantity'] }}</span><strong>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</strong></div>@endforeach<div class="summary-total"><span>Total</span><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></div><p class="payment-note">Pembayaran tunai dilakukan saat pesanan diambil atau diterima. Admin akan menghubungi untuk konfirmasi.</p><button class="button button-dark" type="submit">Buat pesanan <span>↗</span></button></aside>
        </form>
    </div>
</main>
@endsection
