<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('menu.index')->with('error', 'Keranjang masih kosong.');
        }

        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['qty']);

        return view('checkout.index', compact('cart', 'subtotal'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('menu.index')->with('error', 'Keranjang masih kosong.');
        }

        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:30'],
            'fulfillment_type' => ['required', 'in:delivery,pickup'],
            'address' => ['nullable', 'string', 'max:500'],
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        if ($data['fulfillment_type'] === 'delivery' && empty($data['address'])) {
            return back()->withInput()->with('error', 'Alamat wajib diisi untuk pengantaran.');
        }

        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['qty']);

        $order = DB::transaction(function () use ($data, $cart, $subtotal) {
            // Validasi stok ulang (penting)
            foreach ($cart as $item) {
                $p = Product::lockForUpdate()->find($item['product_id']);
                if (!$p || !$p->is_active || $p->stock < $item['qty']) {
                    throw new \RuntimeException("Stok tidak cukup untuk: {$item['name']}");
                }
            }

            $order = Order::create([
                'code' => $this->generateOrderCode(),
                'customer_name' => $data['customer_name'],
                'phone' => $data['phone'],
                'fulfillment_type' => $data['fulfillment_type'],
                'address' => $data['fulfillment_type'] === 'delivery' ? $data['address'] : null,
                'note' => $data['note'] ?? null,
                'subtotal' => (int) $subtotal,
                'status' => Order::STATUS_MENUNGGU_KONFIRMASI,
                'tracking_token' => Str::random(32), // opsional
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'note_item' => $item['note'] ?? null,
                ]);

                // Kurangi stok
                Product::where('id', $item['product_id'])
                    ->decrement('stock', (int) $item['qty']);
            }

            return $order;
        });

        session()->forget('cart');

        return redirect()->route('order.success', $order->code);
    }

    private function generateOrderCode(): string
    {
        // ORD-YYYY-XXXX (XXXX incremental harian sederhana)
        $year = now()->format('Y');

        $last = Order::whereYear('created_at', $year)->orderByDesc('id')->first();
        $nextNumber = $last ? ($last->id + 1) : 1;

        return 'ORD-' . $year . '-' . str_pad((string) $nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
