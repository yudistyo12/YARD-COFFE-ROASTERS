<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['category' => 'kopi-nusantara', 'name' => 'Arunika Gayo', 'description' => 'Arabika Gayo dengan karakter citrus yang segar, body lembut, dan sentuhan akhir cokelat. Dipetik selektif dan diproses dengan penuh perhatian.', 'price' => 89000, 'stock' => 24, 'image_path' => 'https://images.unsplash.com/photo-1559525839-b184a4d698c7?auto=format&fit=crop&w=1000&q=85', 'is_featured' => true],
            ['category' => 'kopi-nusantara', 'name' => 'Senja Kintamani', 'description' => 'Kopi Bali dengan acidity cerah dan aroma buah jeruk. Tumbuh di dataran tinggi Kintamani dan cocok untuk dinikmati sebagai pour over.', 'price' => 95000, 'stock' => 18, 'image_path' => 'https://images.unsplash.com/photo-1442512595331-e89e73853f31?auto=format&fit=crop&w=1000&q=85', 'is_featured' => true],
            ['category' => 'kopi-nusantara', 'name' => 'Lembah Toraja', 'description' => 'Arabika Toraja dengan body penuh, aroma rempah yang hangat, dan rasa akhir manis yang bertahan lama.', 'price' => 92000, 'stock' => 15, 'image_path' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=1000&q=85', 'is_featured' => false],
            ['category' => 'kopi-siap-seduh', 'name' => 'Drip Bag Pagi', 'description' => 'Lima sachet kopi single-serve untuk pagi yang lebih tenang. Cukup tuang air panas, tanpa alat seduh tambahan.', 'price' => 45000, 'stock' => 32, 'image_path' => 'https://images.unsplash.com/photo-1511920170033-f8396924c348?auto=format&fit=crop&w=1000&q=85', 'is_featured' => true],
            ['category' => 'teman-ngopi', 'name' => 'Cookies Gula Aren', 'description' => 'Cookies renyah dengan manis legit gula aren lokal. Dibuat dalam batch kecil, tanpa pengawet, dan pas untuk teman minum kopi.', 'price' => 38000, 'stock' => 21, 'image_path' => 'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?auto=format&fit=crop&w=1000&q=85', 'is_featured' => false],
            ['category' => 'kopi-siap-seduh', 'name' => 'House Blend Purnama', 'description' => 'Perpaduan biji pilihan dari Jawa dan Sumatra dengan rasa karamel, kacang panggang, dan cokelat yang seimbang.', 'price' => 78000, 'stock' => 19, 'image_path' => 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?auto=format&fit=crop&w=1000&q=85', 'is_featured' => false],
            ['category' => 'espresso-milk', 'name' => 'Yard Signature Latte', 'description' => 'Double espresso house blend dengan susu segar dan sentuhan gula aren. Seimbang, creamy, dan jadi cerita khas dari Yard.', 'price' => 38000, 'stock' => 40, 'image_path' => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?auto=format&fit=crop&w=1000&q=85', 'is_featured' => true],
            ['category' => 'espresso-milk', 'name' => 'Cappuccino Klasik', 'description' => 'Espresso dengan tekstur susu lembut dan foam halus. Disajikan dengan taburan cokelat pilihan.', 'price' => 34000, 'stock' => 36, 'image_path' => 'https://images.unsplash.com/photo-1572442388796-11668a67e53d?auto=format&fit=crop&w=1000&q=85', 'is_featured' => false],
            ['category' => 'espresso-milk', 'name' => 'Brown Sugar Oat Latte', 'description' => 'Espresso dingin, susu oat yang lembut, dan brown sugar dengan aroma karamel. Pilihan plant-based yang menyegarkan.', 'price' => 42000, 'stock' => 28, 'image_path' => 'https://images.unsplash.com/photo-1517701604599-bb29b565090c?auto=format&fit=crop&w=1000&q=85', 'is_featured' => true],
            ['category' => 'espresso-milk', 'name' => 'Sea Salt Caramel Latte', 'description' => 'Latte dingin dengan karamel buatan rumah dan sedikit sea salt untuk rasa manis-gurih yang pas.', 'price' => 41000, 'stock' => 30, 'image_path' => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?auto=format&fit=crop&w=1000&q=85', 'is_featured' => false],
            ['category' => 'manual-brew', 'name' => 'V60 Gayo Reserve', 'description' => 'Diseduh manual untuk membuka rasa citrus, gula merah, dan cokelat dari biji Gayo pilihan. Tanyakan pilihan biji hari ini.', 'price' => 36000, 'stock' => 20, 'image_path' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=1000&q=85', 'is_featured' => false],
            ['category' => 'manual-brew', 'name' => 'V60 Kintamani', 'description' => 'Seduhan ringan dengan aroma jeruk dan acidity cerah dari perkebunan Kintamani, Bali.', 'price' => 38000, 'stock' => 18, 'image_path' => 'https://images.unsplash.com/photo-1442512595331-e89e73853f31?auto=format&fit=crop&w=1000&q=85', 'is_featured' => false],
            ['category' => 'manual-brew', 'name' => 'Cold Brew Citrus', 'description' => 'Kopi seduh dingin selama 18 jam dengan kulit jeruk lokal. Ringan, segar, dan cocok untuk siang hari.', 'price' => 39000, 'stock' => 25, 'image_path' => 'https://images.unsplash.com/photo-1517701604599-bb29b565090c?auto=format&fit=crop&w=1000&q=85', 'is_featured' => true],
            ['category' => 'non-coffee', 'name' => 'Matcha Cloud', 'description' => 'Matcha Jepang dengan susu segar dan lapisan foam lembut. Rasa earthy yang halus tanpa kopi.', 'price' => 42000, 'stock' => 24, 'image_path' => 'https://images.unsplash.com/photo-1515823064-d6e0c04616a7?auto=format&fit=crop&w=1000&q=85', 'is_featured' => false],
            ['category' => 'non-coffee', 'name' => 'Cokelat Hazelnut', 'description' => 'Cokelat pekat dengan susu dan aroma hazelnut panggang. Tersedia hangat atau dingin.', 'price' => 36000, 'stock' => 25, 'image_path' => 'https://images.unsplash.com/photo-1542990253-0b8be8b6a8a6?auto=format&fit=crop&w=1000&q=85', 'is_featured' => false],
            ['category' => 'pastry-dessert', 'name' => 'Butter Croissant', 'description' => 'Croissant berlapis dengan butter pilihan, dipanggang setiap pagi sampai keemasan dan renyah.', 'price' => 28000, 'stock' => 20, 'image_path' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&w=1000&q=85', 'is_featured' => true],
            ['category' => 'pastry-dessert', 'name' => 'Cinnamon Roll', 'description' => 'Roti gulung kayu manis yang lembut, dilapisi glaze tipis. Paling nikmat disantap selagi hangat.', 'price' => 32000, 'stock' => 16, 'image_path' => 'https://images.unsplash.com/photo-1509365465985-25d11c17e812?auto=format&fit=crop&w=1000&q=85', 'is_featured' => false],
            ['category' => 'pastry-dessert', 'name' => 'Basque Cheesecake', 'description' => 'Cheesecake panggang dengan permukaan karamelisasi dan bagian tengah yang lembut. Potongan dibuat fresh setiap hari.', 'price' => 39000, 'stock' => 14, 'image_path' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&w=1000&q=85', 'is_featured' => false],
        ];

        foreach ($products as $data) {
            $category = Category::where('slug', $data['category'])->firstOrFail();
            unset($data['category']);
            $slug = Str::slug($data['name']);

            Product::updateOrCreate(
                ['slug' => $slug],
                [...$data, 'category_id' => $category->id, 'slug' => $slug],
            );
        }
    }
}
