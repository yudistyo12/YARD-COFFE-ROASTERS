# YARD & COFFEE ROASTERS

Website **YARD & COFFEE ROASTERS** (est. 2026), artisan coffee dari PT Yudistyo Pangan Nusantara. Pelanggan dapat menjelajahi menu espresso, manual brew, non-coffee, pastry, dan biji kopi; menambahkan produk ke keranjang; lalu checkout untuk diambil atau diantar. Admin mengelola produk, kategori, stok, dan status pesanan.

Identitas menggunakan logo roastery dari referensi, splash intro beranimasi saat kunjungan pertama, dan animasi reveal ringan saat menjelajah halaman.

## Menjalankan aplikasi

Persyaratan: PHP 8.2+ dan Composer.

```bash
composer install
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Database memakai MySQL/MariaDB lokal dengan nama `yard_coffee`, sehingga bisa dilihat di phpMyAdmin. Pada XAMPP, pastikan MySQL berstatus aktif, lalu buka phpMyAdmin dan refresh daftar database. Database `yard_coffee` beserta tabelnya sudah dibuat dan diisi seeder pada komputer ini.

Jika menyiapkan project di komputer lain, buat database `yard_coffee` di phpMyAdmin, sesuaikan `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` di `.env`, lalu jalankan `php artisan migrate --seed`. Pengaturan lokal saat ini menggunakan `root` tanpa kata sandi; sesuaikan `DB_PASSWORD` jika MySQL Anda memakai kata sandi.

## Login admin demo

- URL: `/admin/login`
- Email: `admin@yudistyocoffee.id`
- Kata sandi: `Yudistyo123!`

Kredensial dapat diubah melalui `ADMIN_EMAIL` dan `ADMIN_PASSWORD` di `.env`, lalu jalankan `php artisan db:seed`. Ganti kata sandi demo sebelum aplikasi dipublikasikan.

## Fitur

- **Pelanggan:** katalog dan filter kategori, detail produk, keranjang (ubah jumlah/hapus), checkout ambil di kedai atau pengantaran, konfirmasi pesanan.
- **Admin:** login/logout, dashboard ringkasan, CRUD produk dan kategori, unggah foto, daftar/detail pesanan, dan perubahan status pesanan.
- **Stok:** divalidasi saat keranjang dan checkout; stok dikurangi saat pesanan dibuat dan dikembalikan jika pesanan dibatalkan.
- **Pesanan:** status bergerak dari menunggu konfirmasi → dikonfirmasi → disiapkan → siap diambil → selesai. Pesanan yang sudah selesai/dibatalkan tidak dapat dibuka kembali.
- **Database:** kategori–produk dan pesanan–item pesanan berelasi. Seeder mengisi satu akun admin, tujuh kategori, dan delapan belas produk contoh.

Foto unggahan disimpan di `storage/app/public/products` dan disajikan melalui tautan `public/storage`. Form memvalidasi nama, deskripsi, harga, stok, kategori, serta jenis dan ukuran gambar.

## Tes

```bash
php artisan test
```
