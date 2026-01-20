<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $category = $request->query('category'); // slug

        $categories = Category::orderBy('name')->get();

        $products = Product::query()
            ->where('is_active', true)
            ->when($category, function ($query) use ($category) {
                $query->whereHas('category', fn($q) => $q->where('slug', $category));
            })
            ->when($q, function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('name', 'like', "%{$q}%")
                       ->orWhere('description', 'like', "%{$q}%");
                });
            })
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('menu.index', compact('categories', 'products', 'q', 'category'));
    }

    public function show(string $slug)
    {
        $product = Product::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('menu.show', compact('product'));
    }
}
