@extends('layouts.app')

@section('title', 'Pesanan — YARD & COFFEE ROASTERS')

@section('content')
<main class="admin-page section-pad">
    <div class="container">
        <div class="admin-heading"><div><span class="eyebrow">AREA ADMIN</span><h1>Daftar <em>pesanan.</em></h1><p>Periksa pesanan pelanggan dan perbarui statusnya.</p></div></div>
        <div class="order-filters"><a class="{{ ! $status ? 'selected' : '' }}" href="{{ route('admin.orders.index') }}">Semua</a>@foreach(\App\Models\Order::STATUSES as $key => $label)<a class="{{ $status === $key ? 'selected' : '' }}" href="{{ route('admin.orders.index', ['status' => $key]) }}">{{ $label }}</a>@endforeach</div>
        <div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>NOMOR PESANAN</th><th>PELANGGAN</th><th>METODE</th><th>TANGGAL</th><th>TOTAL</th><th>STATUS</th><th></th></tr></thead><tbody>@forelse($orders as $order)<tr><td><a class="order-number-link" href="{{ route('admin.orders.show', $order) }}">{{ $order->order_number }}</a></td><td><strong>{{ $order->customer_name }}</strong><small class="table-subtext">{{ $order->phone }}</small></td><td>{{ $order->fulfillment_method === 'pickup' ? 'Ambil di kedai' : 'Antar' }}</td><td>{{ $order->created_at->format('d M Y, H:i') }}</td><td>Rp {{ number_format((float) $order->total_price, 0, ',', '.') }}</td><td><span class="status-pill status-{{ $order->status }}">{{ \App\Models\Order::STATUSES[$order->status] }}</span></td><td><a class="text-link" href="{{ route('admin.orders.show', $order) }}">Buka ↗</a></td></tr>@empty<tr><td colspan="7" class="table-empty">Belum ada pesanan untuk filter ini.</td></tr>@endforelse</tbody></table></div>
        <div class="pagination-wrap">{{ $orders->links() }}</div>
    </div>
</main>
@endsection
