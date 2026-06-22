<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class CashierController extends Controller
{
    /**
     * Tampilkan dashboard cashier
     */
    public function index()
    {
        $todayOrders = Order::whereDate('created_at', today())->count();
        $pendingOrders = Order::where('order_status', 'pending')->count();
        $completedOrders = Order::where('order_status', 'done')->whereDate('created_at', today())->count();
        $todaySales = Order::where('order_status', 'done')->whereDate('created_at', today())->sum('total_price');

        return view('cashier.dashboard', compact('todayOrders', 'pendingOrders', 'completedOrders', 'todaySales'));
    }

    /**
     * Tampilkan daftar pesanan untuk cashier
     */
    public function orders()
    {
        $orders = Order::with('orderItems.menuItem')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('cashier.orders.index', compact('orders'));
    }

    /**
     * Tampilkan detail pesanan
     */
    public function showOrder(Order $order)
    {
        $order->load('orderItems.menuItem');
        return view('cashier.orders.show', compact('order'));
    }

    /**
     * Update status pesanan
     */
    public function updateOrderStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'order_status' => 'required|in:pending,done,cancelled',
        ]);

        $order->update($validated);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
