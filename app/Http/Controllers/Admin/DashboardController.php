<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'productCount' => Product::count(),
            'pendingCount' => Order::where('status', 'pending')->count(),
            'orderCount' => Order::count(),
            'revenue' => Order::where('status', 'completed')->sum('total_price'),
            'recentOrders' => Order::latest()->take(6)->get(),
        ]);
    }
}
