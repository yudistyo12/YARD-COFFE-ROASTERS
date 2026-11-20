<main class="admin-page section-pad">
    <div class="container admin-form-container">
        <a class="back-link" href="{{ route('admin.products.index') }}">← Kembali ke koleksi</a>
        <div class="admin-heading form-heading"><div><span class="eyebrow">RUANG PENGELOLA</span><h1>{{ $product->exists ? 'Ubah' : 'Tambah' }} <em>produk.</em></h1><p>Lengkapi detail agar ceritanya sampai kepada pelanggan.</p></div></div>
        @if ($errors->any())
            <div class="alert-error"><strong>Periksa kembali data berikut:</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif
        <form class="product-form" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($product->exists) @method('PUT') @endif
            <div class="form-section-title"><span>01</span><div><strong>Identitas produk</strong><small>Nama, kategori, dan cerita produk.</small></div></div>
            <div class="form-grid">
                <label class="form-field form-full">Nama produk <input type="text" name="name" value="{{ old('name', $product->name) }}" maxlength="120" required placeholder="Contoh: Arunika Gayo"></label>
                <label class="form-field form-full">Kategori <select name="category_id" required><option value="">Pilih kategori</option>@foreach ($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>@endforeach</select></label>
                <label class="form-field form-full">Deskripsi <textarea name="description" rows="5" maxlength="2000" required placeholder="Ceritakan karakter dan keistimewaan produk...">{{ old('description', $product->description) }}</textarea><small>Maksimal 2.000 karakter.</small></label>
            </div>
            <div class="form-section-title"><span>02</span><div><strong>Harga &amp; ketersediaan</strong><small>Informasi untuk pelanggan.</small></div></div>
            <div class="form-grid">
                <label class="form-field">Harga (Rp) <input type="number" name="price" value="{{ old('price', $product->price) }}" min="0" max="999999999" step="1" required placeholder="89000"></label>
                <label class="form-field">Stok (unit) <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" max="999999" step="1" required placeholder="24"></label>
                <label class="form-field form-full">Foto produk <input class="file-input" type="file" name="image" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"><small>JPG, PNG, atau WebP. Maksimal 4 MB. {{ $product->exists ? 'Kosongkan jika tidak ingin mengganti foto.' : '' }}</small></label>
                <label class="featured-toggle form-full"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured))><span><strong>Tandai sebagai pilihan kami</strong><small>Tampilkan lencana khusus di etalase.</small></span></label>
            </div>
            <div class="form-actions"><a class="button button-outline" href="{{ route('admin.products.index') }}">Batal</a><button type="submit" class="button button-dark">{{ $product->exists ? 'Simpan perubahan' : 'Simpan produk' }} <span>↗</span></button></div>
        </form>
    </div>
</main>
