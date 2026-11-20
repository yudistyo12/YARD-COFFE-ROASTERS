<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('admin.products.index', [
            'products' => Product::with('category')->latest()->paginate(8),
        ]);
    }

    public function create(): View
    {
        return view('admin.products.create', ['categories' => Category::orderBy('name')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        $validated['slug'] = $this->uniqueSlug($validated['name']);
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        $validated['slug'] = $this->uniqueSlug($validated['name'], $product->id);
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            if ($product->image_path && ! Str::startsWith($product->image_path, ['http://', 'https://'])) {
                Storage::disk('public')->delete($product->image_path);
            }

            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->image_path && ! Str::startsWith($product->image_path, ['http://', 'https://'])) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')],
            'name' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string', 'max:2000'],
            'price' => ['required', 'numeric', 'min:0', 'max:999999999'],
            'stock' => ['required', 'integer', 'min:0', 'max:999999'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'is_featured' => ['nullable', 'boolean'],
        ];
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $suffix = 2;

        while (Product::where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->exists()) {
            $slug = "{$baseSlug}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }
}
