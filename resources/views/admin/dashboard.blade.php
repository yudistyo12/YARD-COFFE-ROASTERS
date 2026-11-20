@extends('layouts.app')

@section('title', 'Dashboard — YARD & COFFEE ROASTERS')

@section('content')
<main class="admin-page section-pad">
    <div class="container">
        <div class="admin-heading"><div><span class="eyebrow">RINGKASAN KEDAI</span><h1>Selamat datang, <em>{{ auth()->user()->name }}.</em></h1><p>Pantau pesanan dan koleksi YARD &amp; COFFEE ROASTERS.</p></div><a class="button button-dark" href="{{ route('admin.products.create') }}">＋ Tambah produk</a></div>
        <div class="dashboard-stats"><a href="{{ route('admin.products.index') }}"><span>Produk aktif</span><strong>{{ $productCount }}</strong><small>Kelola katalog ↗</small></a><a href="{{ route('admin.orders.index', ['status' => 'pending']) }}"><span>Perlu dikonfirmasi</span><strong>{{ $pendingCount }}</strong><small>Lihat pesanan ↗</small></a><a href="{{ route('admin.orders.index') }}"><span>Total pesanan</span><strong>{{ $orderCount }}</strong><small>Semua pesanan ↗</small></a><div><span>Pendapatan selesai</span><strong>Rp {{ number_format((float) $revenue, 0, ',', '.') }}</strong><small>Pesanan berstatus selesai</small></div></div>
        <section class="dashboard-orders"><div class="section-heading"><div><span class="eyebrow">AKTIVITAS TERBARU</span><h2>Pesanan <em>terkini.</em></h2></div><a class="text-link" href="{{ route('admin.orders.index') }}">Semua pesanan ↗</a></div><div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>NOMOR PESANAN</th><th>PELANGGAN</th><th>TANGGAL</th><th>TOTAL</th><th>STATUS</th><th></th></tr></thead><tbody>@forelse($recentOrders as $order)<tr><td><a class="order-number-link" href="{{ route('admin.orders.show', $order) }}">{{ $order->order_number }}</a></td><td>{{ $order->customer_name }}</td><td>{{ $order->created_at->format('d M Y, H:i') }}</td><td>Rp {{ number_format((float) $order->total_price, 0, ',', '.') }}</td><td><span class="status-pill status-{{ $order->status }}">{{ \App\Models\Order::STATUSES[$order->status] }}</span></td><td><a class="text-link" href="{{ route('admin.orders.show', $order) }}">Detail ↗</a></td></tr>@empty<tr><td colspan="6" class="table-empty">Belum ada pesanan masuk. Pesanan pelanggan akan tampil di sini.</td></tr>@endforelse</tbody></table></div></section>
    </div>
</main>
@endsection
