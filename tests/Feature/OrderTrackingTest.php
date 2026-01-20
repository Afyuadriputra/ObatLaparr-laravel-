<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTrackingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_track_order_by_code_and_phone(): void
    {
        $product = Product::factory()->create(['price' => 10000, 'stock' => 10]);

        $order = Order::create([
            'code' => 'ORD-2026-0001',
            'customer_name' => 'A',
            'phone' => '08123',
            'fulfillment_type' => 'pickup',
            'address' => null,
            'note' => null,
            'subtotal' => 10000,
            'status' => Order::STATUS_MENUNGGU_KONFIRMASI,
            'tracking_token' => null,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'qty' => 1,
            'price' => 10000,
            'note_item' => null,
        ]);

        $res = $this->post('/order/track', [
            'code' => 'ORD-2026-0001',
            'phone' => '08123',
        ]);

        $res->assertStatus(200); // view track tampil
    }
}
