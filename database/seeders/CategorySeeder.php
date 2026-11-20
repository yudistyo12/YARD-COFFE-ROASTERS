<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Kopi Nusantara', 'slug' => 'kopi-nusantara', 'description' => 'Biji kopi pilihan dari kebun terbaik Indonesia.'],
            ['name' => 'Kopi Siap Seduh', 'slug' => 'kopi-siap-seduh', 'description' => 'Kopi praktis dengan rasa yang tetap istimewa.'],
            ['name' => 'Teman Ngopi', 'slug' => 'teman-ngopi', 'description' => 'Pilihan kudapan untuk menemani setiap cangkir.'],
            ['name' => 'Espresso & Milk', 'slug' => 'espresso-milk', 'description' => 'Espresso house blend dengan susu segar dan racikan khas Yard.'],
            ['name' => 'Manual Brew', 'slug' => 'manual-brew', 'description' => 'Seduhan manual yang menonjolkan karakter single origin.'],
            ['name' => 'Non-Coffee', 'slug' => 'non-coffee', 'description' => 'Minuman segar tanpa kopi, dibuat dengan bahan pilihan.'],
            ['name' => 'Pastry & Dessert', 'slug' => 'pastry-dessert', 'description' => 'Pastry dan dessert untuk teman menikmati kopi.'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
