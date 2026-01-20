<?php

namespace App\Http\Controllers;
use App\Models\Setting;


use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
public function success(string $code)
{
    $order = Order::with('items.product')->where('code', $code)->firstOrFail();

    $adminPhone = \App\Models\Setting::get('admin_phone', '62812XXXXXXX');

    $waText = $this->buildWhatsAppText($order);
    $waLink = "https://wa.me/{$adminPhone}?text=" . urlencode($waText);

    return view('order.success', compact('order', 'waLink'));
}


    public function trackForm()
    {
        return view('order.track');
    }

    public function trackResult(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'string'],
            'phone' => ['required', 'string'],
        ]);

        $order = Order::with('items.product')
            ->where('code', $data['code'])
            ->where('phone', $data['phone'])
            ->first();

        if (!$order) {
            return back()->withInput()->with('error', 'Pesanan tidak ditemukan. Pastikan kode & nomor WA benar.');
        }

        return view('order.track', compact('order'));
    }

    private function buildWhatsAppText(Order $order): string
    {
        $lines = [];
        $lines[] = "Halo kak, saya mau konfirmasi pesanan:";
        $lines[] = "Kode: {$order->code}";
        $lines[] = "Nama: {$order->customer_name}";
        $lines[] = "WA: {$order->phone}";
        $lines[] = "Tipe: {$order->fulfillment_type}";
        if ($order->fulfillment_type === 'delivery') {
            $lines[] = "Alamat: {$order->address}";
        }
        $lines[] = "Item:";
        foreach ($order->items as $it) {
            $lines[] = "- {$it->product->name} x{$it->qty}";
        }
        $lines[] = "Total: Rp{$order->subtotal}";
        if ($order->note) {
            $lines[] = "Catatan: {$order->note}";
        }
        return implode("\n", $lines);
    }
}
