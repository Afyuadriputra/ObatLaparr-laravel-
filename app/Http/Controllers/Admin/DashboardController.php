<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        $countToday = Order::whereDate('created_at', $today)->count();
        $newOrders = Order::where('status', Order::STATUS_MENUNGGU_KONFIRMASI)->count();

        return view('admin.dashboard', compact('countToday', 'newOrders'));
    }
}
