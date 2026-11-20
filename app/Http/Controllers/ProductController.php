<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::withCount('products')->orderBy('name')->get();
        $selectedCategory = $categories->firstWhere('slug', $request->query('category'));

        return view('products.index', [
            'products' => Product::with('category')
                ->when($selectedCategory, fn ($query) => $query->where('category_id', $selectedCategory->id))
                ->latest()
                ->get(),
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
        ]);
    }

    public function show(Product $product): View
    {
        $product->load('category');
        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->whereKeyNot($product->id)
            ->take(3)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
