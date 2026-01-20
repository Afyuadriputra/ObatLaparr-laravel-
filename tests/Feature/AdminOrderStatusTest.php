<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminOrderStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_routes_require_auth(): void
    {
        $res = $this->get('/admin');
        $res->assertRedirect(); // redirect to login
    }

    public function test_admin_can_update_order_status_after_login(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'),
        ]);

        $order = Order::create([
            'code' => 'ORD-2026-0009',
            'customer_name' => 'B',
            'phone' => '08199',
            'fulfillment_type' => 'pickup',
            'address' => null,
            'note' => null,
            'subtotal' => 10000,
            'status' => Order::STATUS_MENUNGGU_KONFIRMASI,
            'tracking_token' => null,
        ]);

        $res = $this->actingAs($admin)->patch("/admin/orders/{$order->id}/status", [
            'status' => Order::STATUS_DIPROSES,
        ]);

        $res->assertStatus(302);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => Order::STATUS_DIPROSES,
        ]);
    }
}
