@extends('layouts.app')

@section('title', 'Kategori — YARD & COFFEE ROASTERS')

@section('content')
<main class="admin-page section-pad">
    <div class="container">
        <div class="admin-heading"><div><span class="eyebrow">AREA ADMIN</span><h1>Kelola <em>kategori.</em></h1><p>Kategori membantu pelanggan menjelajahi koleksi kedai.</p></div></div>
        @if ($errors->any())<div class="alert-error">{{ $errors->first() }}</div>@endif
        <form class="category-create-form" action="{{ route('admin.categories.store') }}" method="POST">@csrf<label class="form-field">Nama kategori<input type="text" name="name" maxlength="100" value="{{ old('name') }}" required placeholder="Contoh: Minuman dingin"></label><label class="form-field">Deskripsi singkat<input type="text" name="description" maxlength="500" value="{{ old('description') }}" placeholder="Deskripsi kategori (opsional)"></label><button class="button button-dark" type="submit">＋ Tambah kategori</button></form>
        <div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>KATEGORI</th><th>JUMLAH PRODUK</th><th>UBAH NAMA / DESKRIPSI</th><th>AKSI</th></tr></thead><tbody>@forelse($categories as $category)<tr><td><strong>{{ $category->name }}</strong><small class="table-subtext">{{ $category->slug }}</small></td><td>{{ $category->products_count }}</td><td><form class="category-edit-form" action="{{ route('admin.categories.update', $category) }}" method="POST">@csrf @method('PUT')<input type="text" name="name" value="{{ $category->name }}" maxlength="100" required aria-label="Nama {{ $category->name }}"><input type="text" name="description" value="{{ $category->description }}" maxlength="500" placeholder="Deskripsi" aria-label="Deskripsi {{ $category->name }}"><button type="submit">Simpan</button></form></td><td><form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Hapus kategori {{ $category->name }}?')">@csrf @method('DELETE')<button class="delete-link" type="submit">Hapus</button></form></td></tr>@empty<tr><td colspan="4" class="table-empty">Belum ada kategori.</td></tr>@endforelse</tbody></table></div>
    </div>
</main>
@endsection
