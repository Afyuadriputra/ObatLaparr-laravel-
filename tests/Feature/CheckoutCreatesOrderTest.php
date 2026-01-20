<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutCreatesOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_creates_order_and_items_delivery_requires_address(): void
    {
        $product = Product::factory()->create(['price' => 15000, 'stock' => 10, 'is_active' => true]);

        // add to cart via session
        $this->post('/cart/add', ['product_id' => $product->id, 'qty' => 2]);

        // delivery without address should fail
        $res = $this->post('/checkout', [
            'customer_name' => 'Radit',
            'phone' => '08123456789',
            'fulfillment_type' => 'delivery',
            'address' => '',
            'note' => 'cepat ya',
        ]);

        $res->assertStatus(302);

        // now with address
        $res2 = $this->post('/checkout', [
            'customer_name' => 'Radit',
            'phone' => '08123456789',
            'fulfillment_type' => 'delivery',
            'address' => 'Jl. Mawar No. 1',
            'note' => 'cepat ya',
        ]);

        $res2->assertStatus(302);

        $this->assertDatabaseHas('orders', [
            'customer_name' => 'Radit',
            'phone' => '08123456789',
            'fulfillment_type' => 'delivery',
            'status' => Order::STATUS_MENUNGGU_KONFIRMASI,
            'subtotal' => 30000,
        ]);

        $order = Order::first();
        $this->assertNotNull($order);
        $this->assertTrue(str_starts_with($order->code, 'ORD-'));

        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'qty' => 2,
            'price' => 15000,
        ]);
    }
}
