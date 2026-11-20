@extends('layouts.app')

@section('title', 'Pesanan '.$order->order_number.' — YARD & COFFEE ROASTERS')

@section('content')
<main class="admin-page section-pad">
    <div class="container order-detail-container">
        <a class="back-link" href="{{ route('admin.orders.index') }}">← Kembali ke pesanan</a>
        <div class="admin-heading"><div><span class="eyebrow">DETAIL PESANAN</span><h1>{{ $order->order_number }}</h1><p>Dibuat {{ $order->created_at->format('d F Y, H:i') }}</p></div><span class="status-pill status-{{ $order->status }}">{{ \App\Models\Order::STATUSES[$order->status] }}</span></div>
        @if ($errors->any())<div class="alert-error">{{ $errors->first() }}</div>@endif
        <div class="order-detail-grid"><section class="order-panel"><span class="eyebrow">ITEM PESANAN</span>@foreach ($order->items as $item)<div class="order-line"><div><strong>{{ $item->product_name }}</strong><small>{{ $item->quantity }} × Rp {{ number_format((float) $item->unit_price, 0, ',', '.') }}</small></div><strong>Rp {{ number_format((float) $item->subtotal, 0, ',', '.') }}</strong></div>@endforeach<div class="order-total"><span>Total pesanan</span><strong>Rp {{ number_format((float) $order->total_price, 0, ',', '.') }}</strong></div></section>
            <section class="order-panel"><span class="eyebrow">INFORMASI PELANGGAN</span><div class="customer-info"><span>Nama</span><strong>{{ $order->customer_name }}</strong><span>WhatsApp</span><strong>{{ $order->phone }}</strong><span>Email</span><strong>{{ $order->email ?: 'Tidak dicantumkan' }}</strong><span>Metode</span><strong>{{ $order->fulfillment_method === 'pickup' ? 'Ambil di kedai' : 'Antar ke alamat' }}</strong>@if($order->delivery_address)<span>Alamat</span><strong>{{ $order->delivery_address }}</strong>@endif<span>Catatan</span><strong>{{ $order->notes ?: 'Tidak ada catatan' }}</strong><span>Pembayaran</span><strong>Tunai saat pesanan diterima</strong></div></section>
        </div>
        @if (count($allowedStatuses))
            <form class="status-update-form" action="{{ route('admin.orders.update', $order) }}" method="POST">@csrf @method('PATCH')<label class="form-field">Perbarui status<select name="status" required>@foreach($allowedStatuses as $nextStatus)<option value="{{ $nextStatus }}">{{ \App\Models\Order::STATUSES[$nextStatus] }}</option>@endforeach</select></label><button class="button button-dark" type="submit">Simpan status <span>↗</span></button></form>
        @else
            <p class="terminal-status">Pesanan ini sudah berstatus akhir dan tidak dapat diubah lagi.</p>
        @endif
    </div>
</main>
@endsection
