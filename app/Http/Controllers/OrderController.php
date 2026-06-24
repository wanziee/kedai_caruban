<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('orderItems.menuItem')->orderBy('created_at', 'desc')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('orderItems.menuItem');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'order_status' => 'required|in:pending,paid,cooking,done,cancelled',
        ]);

        $order->update($validated);
        return redirect()->route('admin.orders.show', $order)->with('success', 'Order status updated successfully.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'table_number' => 'required|integer',
            'customer_name' => 'nullable|string|max:255',
            'items' => 'required|array',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.notes' => 'nullable|string',
        ]);

        $orderCode = 'ORD-' . strtoupper(Str::random(8));
        $totalPrice = 0;

        $order = Order::create([
            'table_number' => $validated['table_number'],
            'order_code' => $orderCode,
            'customer_name' => $validated['customer_name'] ?? null,
            'total_price' => 0,
            'order_status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        foreach ($validated['items'] as $item) {
            $menuItem = MenuItem::find($item['menu_item_id']);
            $subtotal = $menuItem->price * $item['qty'];
            $totalPrice += $subtotal;

            OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $item['menu_item_id'],
                'qty' => $item['qty'],
                'price' => $menuItem->price,
                'notes' => $item['notes'] ?? null,
                'subtotal' => $subtotal,
            ]);
        }

        $order->update(['total_price' => $totalPrice]);

        return response()->json([
            'success' => true,
            'order_id' => $order->id,
            'order_code' => $orderCode,
            'total_price' => $totalPrice,
        ]);
    }
}
