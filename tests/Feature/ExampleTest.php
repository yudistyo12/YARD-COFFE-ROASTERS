<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('intro-splash')
            ->assertSee('yard-coffee-roasters-full.jpg');
    }

    public function test_seeded_menu_has_more_than_six_products_and_three_categories(): void
    {
        $this->assertGreaterThan(6, Product::count());
        $this->assertGreaterThan(3, Category::count());
    }

    public function test_a_seeded_product_has_a_public_detail_page(): void
    {
        $response = $this->get('/produk/arunika-gayo');

        $response->assertOk()->assertSee('Arunika Gayo');
    }

    public function test_category_filter_shows_only_matching_products(): void
    {
        $this->get('/?category=teman-ngopi')
            ->assertOk()
            ->assertSee('Cookies Gula Aren')
            ->assertDontSee('Arunika Gayo');
    }

    public function test_admin_can_open_the_product_catalog(): void
    {
        $this->signInAsAdmin();
        $response = $this->get('/admin/products');

        $response->assertOk()->assertSee('Arunika Gayo');
        $this->get('/admin/categories')->assertOk()->assertSee('Kopi Nusantara');
        $this->get('/admin/orders')->assertOk()->assertSee('Daftar');
        $this->get('/admin/products/create')->assertOk()->assertSee('Tambah produk');
        $this->get(route('admin.products.edit', Product::firstOrFail()))
            ->assertOk()
            ->assertSee('Simpan perubahan');
    }

    public function test_admin_pages_require_a_signed_in_administrator(): void
    {
        $this->get('/admin/products')->assertRedirect('/admin/login');

        $this->actingAs(User::factory()->create())
            ->get('/admin')
            ->assertForbidden();
    }

    public function test_admin_can_sign_in_with_seeded_credentials(): void
    {
        $this->post('/admin/login', [
            'email' => env('ADMIN_EMAIL', 'admin@yudistyocoffee.id'),
            'password' => env('ADMIN_PASSWORD', 'Yudistyo123!'),
        ])->assertRedirect('/admin');

        $this->assertAuthenticatedAs(User::where('is_admin', true)->firstOrFail());
        $this->get('/admin')->assertOk()->assertSee('Selamat datang');
    }

    public function test_admin_can_create_a_product_with_an_uploaded_image(): void
    {
        $this->signInAsAdmin();
        Storage::fake('public');
        $category = Category::where('slug', 'kopi-nusantara')->firstOrFail();

        $response = $this->post('/admin/products', [
            'category_id' => $category->id,
            'name' => 'Kopi Uji',
            'description' => 'Kopi lokal untuk pengujian.',
            'price' => 50000,
            'stock' => 12,
            'image' => UploadedFile::fake()->image('kopi.jpg'),
        ]);

        $response->assertRedirect('/admin/products');
        $product = Product::where('slug', 'kopi-uji')->firstOrFail();
        $this->assertSame($category->id, $product->category_id);
        Storage::disk('public')->assertExists($product->image_path);
    }

    public function test_product_creation_requires_validated_fields(): void
    {
        $this->signInAsAdmin();
        $response = $this->from('/admin/products/create')->post('/admin/products', [
            'name' => str_repeat('x', 121),
            'description' => 'Deskripsi',
            'price' => 'bukan angka',
            'stock' => 2,
        ]);

        $response->assertRedirect('/admin/products/create')
            ->assertSessionHasErrors(['category_id', 'name', 'price']);
    }

    public function test_admin_can_update_and_delete_a_product(): void
    {
        $this->signInAsAdmin();
        $product = Product::where('slug', 'arunika-gayo')->firstOrFail();

        $this->put(route('admin.products.update', $product), [
            'category_id' => $product->category_id,
            'name' => 'Arunika Gayo Spesial',
            'description' => 'Versi pilihan terbaru.',
            'price' => 99000,
            'stock' => 10,
        ])->assertRedirect('/admin/products');

        $updated = Product::where('slug', 'arunika-gayo-spesial')->firstOrFail();
        $this->assertSame('99000.00', $updated->price);

        $this->delete(route('admin.products.destroy', $updated))
            ->assertRedirect('/admin/products');
        $this->assertDatabaseMissing('products', ['id' => $updated->id]);
    }

    public function test_admin_can_manage_categories_without_deleting_categories_in_use(): void
    {
        $this->signInAsAdmin();
        $this->delete(route('admin.categories.destroy', Category::where('slug', 'kopi-nusantara')->firstOrFail()))
            ->assertSessionHasErrors('category');

        $this->post(route('admin.categories.store'), [
            'name' => 'Minuman Musiman',
            'description' => 'Menu sesuai musim.',
        ])->assertRedirect('/admin/categories');

        $category = Category::where('slug', 'minuman-musiman')->firstOrFail();
        $this->put(route('admin.categories.update', $category), [
            'name' => 'Minuman Spesial',
            'description' => 'Pilihan spesial kedai.',
        ])->assertRedirect('/admin/categories');

        $category = $category->fresh();
        $this->assertSame('minuman-spesial', $category->slug);
        $this->delete(route('admin.categories.destroy', $category))
            ->assertRedirect('/admin/categories');
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_customer_can_update_and_remove_cart_items(): void
    {
        $product = Product::where('slug', 'arunika-gayo')->firstOrFail();
        $this->post(route('cart.add', $product), ['quantity' => 1]);
        $this->patch(route('cart.update', $product), ['quantity' => 3])
            ->assertSessionHas('cart', [$product->id => 3]);
        $this->delete(route('cart.remove', $product))
            ->assertSessionHas('cart', []);
    }

    public function test_customer_can_place_an_order_and_stock_is_reserved(): void
    {
        $product = Product::where('slug', 'arunika-gayo')->firstOrFail();
        $this->post(route('cart.add', $product), ['quantity' => 2])
            ->assertRedirect();
        $this->get('/keranjang')->assertOk()->assertSee('Arunika Gayo');
        $this->get('/checkout')->assertOk()->assertSee('Detail');

        $response = $this->post('/checkout', [
            'customer_name' => 'Pelanggan Uji',
            'phone' => '08123456789',
            'fulfillment_method' => 'pickup',
        ]);

        $response->assertRedirectContains('/pesanan/');
        $order = Order::with('items')->firstOrFail();
        $this->assertSame('pending', $order->status);
        $this->assertSame(2, $order->items->first()->quantity);
        $this->assertSame(22, $product->fresh()->stock);
        $this->get(route('orders.confirmation', $order))->assertOk()->assertSee($order->order_number);
    }

    public function test_delivery_checkout_requires_an_address(): void
    {
        $product = Product::where('slug', 'arunika-gayo')->firstOrFail();
        $this->post(route('cart.add', $product), ['quantity' => 1]);

        $this->post('/checkout', [
            'customer_name' => 'Pelanggan Uji',
            'phone' => '08123456789',
            'fulfillment_method' => 'delivery',
        ])->assertSessionHasErrors('delivery_address');

        $this->assertDatabaseCount('orders', 0);
    }

    public function test_admin_cancelling_an_order_returns_reserved_stock(): void
    {
        $product = Product::where('slug', 'arunika-gayo')->firstOrFail();
        $product->decrement('stock', 2);
        $order = Order::create([
            'order_number' => 'YDTEST123456',
            'customer_name' => 'Pelanggan Uji',
            'phone' => '08123456789',
            'fulfillment_method' => 'pickup',
            'total_price' => 178000,
            'status' => 'pending',
        ]);
        $order->items()->create([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'unit_price' => $product->price,
            'quantity' => 2,
            'subtotal' => 178000,
        ]);
        $this->signInAsAdmin();

        $this->patch(route('admin.orders.update', $order), ['status' => 'cancelled'])
            ->assertRedirect(route('admin.orders.show', $order));

        $this->assertSame(24, $product->fresh()->stock);
        $this->assertSame('cancelled', $order->fresh()->status);
    }

    private function signInAsAdmin(): void
    {
        $this->actingAs(User::where('is_admin', true)->firstOrFail());
    }
}
