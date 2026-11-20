<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        [$items, $total] = $this->cartItems($request);

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate(['quantity' => ['required', 'integer', 'min:1', 'max:99']]);
        $cart = $request->session()->get('cart', []);
        $quantity = ($cart[$product->id] ?? 0) + $validated['quantity'];

        if ($quantity > $product->stock) {
            return back()->withErrors(['cart' => 'Jumlah yang dipilih melebihi stok tersedia.']);
        }

        $cart[$product->id] = $quantity;
        $request->session()->put('cart', $cart);

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate(['quantity' => ['required', 'integer', 'min:1', 'max:99']]);

        if ($validated['quantity'] > $product->stock) {
            return back()->withErrors(['cart' => 'Jumlah yang dipilih melebihi stok tersedia.']);
        }

        $cart = $request->session()->get('cart', []);
        $cart[$product->id] = $validated['quantity'];
        $request->session()->put('cart', $cart);

        return back()->with('success', 'Jumlah produk diperbarui.');
    }

    public function remove(Request $request, Product $product): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        unset($cart[$product->id]);
        $request->session()->put('cart', $cart);

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function checkout(Request $request): View|RedirectResponse
    {
        [$items, $total] = $this->cartItems($request);

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Keranjang masih kosong.']);
        }

        return view('cart.checkout', compact('items', 'total'));
    }

    public function placeOrder(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:32'],
            'email' => ['nullable', 'email', 'max:120'],
            'fulfillment_method' => ['required', 'in:pickup,delivery'],
            'delivery_address' => ['required_if:fulfillment_method,delivery', 'nullable', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);
        $cart = $request->session()->get('cart', []);

        if ($cart === []) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Keranjang masih kosong.']);
        }

        $order = DB::transaction(function () use ($cart, $validated) {
            $products = Product::whereIn('id', array_keys($cart))
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');
            $total = 0;

            foreach ($cart as $productId => $quantity) {
                $product = $products->get($productId);

                if (! $product || $quantity > $product->stock) {
                    throw ValidationException::withMessages([
                        'cart' => 'Stok produk berubah. Periksa kembali keranjang sebelum memesan.',
                    ]);
                }

                $total += (float) $product->price * $quantity;
            }

            do {
                $orderNumber = 'YD'.now()->format('ymd').Str::upper(Str::random(10));
            } while (Order::where('order_number', $orderNumber)->exists());

            $order = Order::create([
                ...$validated,
                'delivery_address' => $validated['fulfillment_method'] === 'delivery'
                    ? $validated['delivery_address']
                    : null,
                'order_number' => $orderNumber,
                'total_price' => $total,
                'status' => 'pending',
            ]);

            foreach ($cart as $productId => $quantity) {
                $product = $products->get($productId);
                $subtotal = (float) $product->price * $quantity;
                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'unit_price' => $product->price,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ]);
                $product->decrement('stock', $quantity);
            }

            return $order;
        });

        $request->session()->forget('cart');

        return redirect()->route('orders.confirmation', $order);
    }

    public function confirmation(Order $order): View
    {
        $order->load('items');

        return view('cart.confirmation', compact('order'));
    }

    private function cartItems(Request $request): array
    {
        $cart = $request->session()->get('cart', []);
        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
        $cart = array_intersect_key($cart, $products->all());
        $request->session()->put('cart', $cart);
        $items = collect($cart)->map(function ($quantity, $productId) use ($products) {
            $product = $products->get($productId);

            return $product ? [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => (float) $product->price * $quantity,
            ] : null;
        })->filter()->values();

        return [$items, $items->sum('subtotal')];
    }
}
