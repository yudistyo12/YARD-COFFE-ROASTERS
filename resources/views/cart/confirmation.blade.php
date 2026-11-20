@extends('layouts.app')

@section('title', 'Pesanan diterima — YARD & COFFEE ROASTERS')

@section('content')
<main class="confirmation-page">
    <div class="confirmation-card">
        <span class="confirmation-icon">✓</span><span class="eyebrow">PESANAN DITERIMA</span>
        <h1>Terima kasih, <em>{{ $order->customer_name }}.</em></h1>
        <p>Pesananmu sudah masuk ke kedai kami. Simpan nomor pesanan ini untuk mengecek statusnya.</p>
        <div class="order-number"><span>NOMOR PESANAN</span><strong>{{ $order->order_number }}</strong></div>
        <div class="confirmation-summary">@foreach ($order->items as $item)<div><span>{{ $item->product_name }} × {{ $item->quantity }}</span><strong>Rp {{ number_format((float) $item->subtotal, 0, ',', '.') }}</strong></div>@endforeach<div class="summary-total"><span>Total pesanan</span><strong>Rp {{ number_format((float) $order->total_price, 0, ',', '.') }}</strong></div><div><span>Status</span><strong>{{ \App\Models\Order::STATUSES[$order->status] }}</strong></div><div><span>Pengambilan</span><strong>{{ $order->fulfillment_method === 'pickup' ? 'Ambil di kedai' : 'Antar ke alamat' }}</strong></div></div>
        <p class="confirmation-note">Admin akan menghubungi nomor WhatsApp yang dicantumkan untuk konfirmasi.</p>
        <a class="button button-dark" href="{{ route('home') }}">Kembali ke beranda <span>↗</span></a>
    </div>
</main>
@endsection
