<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $orders = Order::query()
            ->when($status, fn ($q) => $q->where('status', $status))
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('admin.orders.index', compact('orders', 'status'));
    }

    public function show(Order $order)
    {
        $order->load('items.product');
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:30'],
            'fulfillment_type' => ['required', 'in:' . Order::FULFILLMENT_DELIVERY . ',' . Order::FULFILLMENT_PICKUP],
            'address' => ['nullable', 'string', 'max:255'],
            'note' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string'],
        ]);

        // kalau pickup, alamat harus null
        if ($data['fulfillment_type'] === Order::FULFILLMENT_PICKUP) {
            $data['address'] = null;
        }

        $order->update($data);

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Pesanan berhasil diperbarui.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', 'string'],
        ]);

        $order->update(['status' => $data['status']]);

        return back()->with('success', 'Status pesanan diperbarui.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Pesanan berhasil dihapus.');
    }
}
