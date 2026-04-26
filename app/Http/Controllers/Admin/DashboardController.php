<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $completedOrders = Order::where('status', 'completed');
        $completedOrdersCount = (clone $completedOrders)->count();
        $totalRevenue = (clone $completedOrders)->sum('total_price');

        return view('admin.dashboard.index', [
            'totalUsers' => User::count(),
            'totalProducts' => Product::count(),
            'totalOrders' => Order::count(),
            'totalRevenue' => $totalRevenue,
            'completedOrdersCount' => $completedOrdersCount,
            'pendingOrdersCount' => Order::where('status', '!=', 'completed')->count(),
            'averageOrderValue' => $completedOrdersCount > 0 ? ($totalRevenue / $completedOrdersCount) : 0,
            'latestOrders' => Order::with('user')->latest()->take(6)->get(),
            'recentUsers' => User::latest()->take(5)->get(),
            'featuredProductsCount' => Product::where('is_featured', true)->count(),
            'topProducts' => OrderItem::query()
                ->select('product_id', DB::raw('COUNT(*) as total_sales'))
                ->with('product')
                ->groupBy('product_id')
                ->orderByDesc('total_sales')
                ->take(5)
                ->get(),
        ]);
    }
}
