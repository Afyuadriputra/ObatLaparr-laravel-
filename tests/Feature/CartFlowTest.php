<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_product_to_cart(): void
    {
        $product = Product::factory()->create(['stock' => 10, 'is_active' => true]);

        $res = $this->post('/cart/add', [
            'product_id' => $product->id,
            'qty' => 2,
            'note' => 'tanpa pedas',
        ]);

        $res->assertRedirect('/cart');

        $this->assertTrue(session()->has('cart'));
        $cart = session('cart');
        $this->assertEquals(2, $cart[$product->id]['qty']);
        $this->assertEquals('tanpa pedas', $cart[$product->id]['note']);
    }

    public function test_user_can_update_cart_qty(): void
    {
        $product = Product::factory()->create(['stock' => 10, 'is_active' => true]);

        $this->post('/cart/add', ['product_id' => $product->id, 'qty' => 1]);

        $res = $this->post('/cart/update', [
            'product_id' => $product->id,
            'qty' => 5,
        ]);

        $res->assertStatus(302);

        $cart = session('cart');
        $this->assertEquals(5, $cart[$product->id]['qty']);
    }

    public function test_user_can_remove_item_from_cart(): void
    {
        $product = Product::factory()->create(['stock' => 10, 'is_active' => true]);

        $this->post('/cart/add', ['product_id' => $product->id, 'qty' => 1]);

        $res = $this->post('/cart/remove', ['product_id' => $product->id]);
        $res->assertStatus(302);

        $cart = session('cart', []);
        $this->assertArrayNotHasKey($product->id, $cart);
    }

    public function test_user_can_clear_cart(): void
    {
        $p1 = Product::factory()->create(['stock' => 10]);
        $p2 = Product::factory()->create(['stock' => 10]);

        $this->post('/cart/add', ['product_id' => $p1->id, 'qty' => 1]);
        $this->post('/cart/add', ['product_id' => $p2->id, 'qty' => 1]);

        $res = $this->post('/cart/clear');
        $res->assertStatus(302);

        $this->assertEmpty(session('cart', []));
    }
}
