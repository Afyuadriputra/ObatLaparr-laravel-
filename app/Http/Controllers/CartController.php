<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function cart(): array
    {
        return session()->get('cart', []);
    }

    private function saveCart(array $cart): void
    {
        session()->put('cart', $cart);
    }

    public function index()
    {
        $cart = $this->cart();
        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['qty']);

        return view('cart.index', compact('cart', 'subtotal'));
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer'],
            'qty' => ['nullable', 'integer', 'min:1'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        $product = Product::query()
            ->where('id', $data['product_id'])
            ->where('is_active', true)
            ->firstOrFail();

        if ($product->stock <= 0) {
            return back()->with('error', 'Stok habis.');
        }

        $qty = $data['qty'] ?? 1;
        $cart = $this->cart();

        $existingQty = $cart[$product->id]['qty'] ?? 0;
        $newQty = $existingQty + $qty;

        if ($newQty > $product->stock) {
            $newQty = $product->stock;
        }

        $cart[$product->id] = [
            'product_id' => $product->id,
            'name' => $product->name,
            'price' => (int) $product->price,
            'qty' => (int) $newQty,
            'note' => $data['note'] ?? ($cart[$product->id]['note'] ?? null),
            'photo_path' => $product->photo_path,
        ];

        $this->saveCart($cart);

        return redirect()->route('cart.index')->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer'],
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        $cart = $this->cart();

        if (!isset($cart[$data['product_id']])) {
            return back()->with('error', 'Item tidak ditemukan di keranjang.');
        }

        $product = Product::findOrFail($data['product_id']);
        $qty = min((int) $data['qty'], (int) $product->stock);

        $cart[$data['product_id']]['qty'] = $qty;

        $this->saveCart($cart);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer'],
        ]);

        $cart = $this->cart();
        unset($cart[$data['product_id']]);

        $this->saveCart($cart);

        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Keranjang dikosongkan.');
    }
}
