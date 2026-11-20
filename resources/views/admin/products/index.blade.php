@extends('layouts.app')

@section('title', 'Kelola produk — YARD & COFFEE ROASTERS')

@section('content')
<main class="admin-page section-pad">
    <div class="container">
        <div class="admin-heading"><div><span class="eyebrow">RUANG PENGELOLA</span><h1>Kelola <em>koleksi.</em></h1><p>Atur produk yang tampil di etalase YARD &amp; COFFEE ROASTERS.</p></div><a class="button button-dark" href="{{ route('admin.products.create') }}">＋ Tambah produk</a></div>
        <div class="admin-stats"><div><span>Total produk</span><strong>{{ $products->total() }}</strong></div><div><span>Halaman</span><strong>{{ $products->currentPage() }}<small> / {{ max(1, $products->lastPage()) }}</small></strong></div><a href="{{ route('home') }}" class="text-link">Lihat etalase publik ↗</a></div>
        <div class="admin-table-wrap">
            <table class="admin-table"><thead><tr><th>PRODUK</th><th>KATEGORI</th><th>HARGA</th><th>STOK</th><th>STATUS</th><th>AKSI</th></tr></thead><tbody>
                @forelse ($products as $product)
                    <tr><td><div class="table-product"><img src="{{ $product->image_url }}" alt=""><span><strong>{{ $product->name }}</strong><small>SKU-{{ str_pad((string) $product->id, 4, '0', STR_PAD_LEFT) }}</small></span></div></td><td>{{ $product->category->name }}</td><td>Rp {{ number_format((float) $product->price, 0, ',', '.') }}</td><td>{{ $product->stock }} unit</td><td><span class="status-pill {{ $product->stock > 0 ? 'status-available' : 'status-empty' }}">{{ $product->stock > 0 ? 'Tersedia' : 'Habis' }}</span></td><td><div class="table-actions"><a href="{{ route('products.show', $product) }}" aria-label="Lihat {{ $product->name }}">↗</a><a href="{{ route('admin.products.edit', $product) }}" aria-label="Ubah {{ $product->name }}">Ubah</a><form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk {{ $product->name }}?')">@csrf @method('DELETE')<button type="submit">Hapus</button></form></div></td></tr>
                @empty
                    <tr><td colspan="6" class="table-empty">Belum ada produk. Tambahkan produk pertama Anda.</td></tr>
                @endforelse
            </tbody></table>
        </div>
        <div class="pagination-wrap">{{ $products->links() }}</div>
    </div>
</main>
@endsection
