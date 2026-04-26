<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.orders.index', [
            'orders' => Order::with(['user', 'items.product'])->latest()->get(),
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $order->update($request->validate([
            'status' => ['required', 'in:pending,paid,completed,cancelled'],
        ]));

        return back()->with('success', 'Đã cập nhật trạng thái đơn hàng.');
    }
}
