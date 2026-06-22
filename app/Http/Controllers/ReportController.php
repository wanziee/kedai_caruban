<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Tampilkan laporan penjualan
     */
    public function sales(Request $request)
    {
        $month = (int) $request->input('month', now()->month);
        $year = (int) $request->input('year', now()->year);

        // Get sales data for the month - include all completed orders (not pending, not cancelled)
        $orders = Order::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereNotIn('order_status', ['pending', 'cancelled'])
            ->with('orderItems.menuItem')
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate totals
        $totalSales = $orders->sum('total_price');
        $totalOrders = $orders->count();
        
        // Get sales by category - include all completed orders
        $salesByCategory = OrderItem::query()
            ->select('menu_items.category_id', 'menu_categories.name', DB::raw('COUNT(*) as quantity'), DB::raw('SUM(order_items.price * order_items.qty) as total'))
            ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->join('menu_categories', 'menu_items.category_id', '=', 'menu_categories.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereYear('orders.created_at', $year)
            ->whereMonth('orders.created_at', $month)
            ->whereNotIn('orders.order_status', ['pending', 'cancelled'])
            ->groupBy('menu_items.category_id', 'menu_categories.name')
            ->get();

        // Get top selling items - include all completed orders
        $topItems = OrderItem::query()
            ->select('menu_items.name', 'menu_items.id', DB::raw('SUM(order_items.qty) as total_quantity'), DB::raw('SUM(order_items.price * order_items.qty) as total_price'))
            ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereYear('orders.created_at', $year)
            ->whereMonth('orders.created_at', $month)
            ->whereNotIn('orders.order_status', ['pending', 'cancelled'])
            ->groupBy('menu_items.id', 'menu_items.name')
            ->orderBy('total_quantity', 'desc')
            ->limit(10)
            ->get();

        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        return view('admin.reports.sales', compact('orders', 'totalSales', 'totalOrders', 'salesByCategory', 'topItems', 'month', 'year', 'months'));
    }

    /**
     * Print laporan penjualan
     */
    public function salesPrint(Request $request)
    {
        $month = (int) $request->input('month', now()->month);
        $year = (int) $request->input('year', now()->year);

        // Get sales data for the month - include all completed orders (not pending, not cancelled)
        $orders = Order::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereNotIn('order_status', ['pending', 'cancelled'])
            ->with('orderItems.menuItem')
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate totals
        $totalSales = $orders->sum('total_price');
        $totalOrders = $orders->count();
        
        // Get sales by category - include all completed orders
        $salesByCategory = OrderItem::query()
            ->select('menu_items.category_id', 'menu_categories.name', DB::raw('COUNT(*) as quantity'), DB::raw('SUM(order_items.price * order_items.qty) as total'))
            ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->join('menu_categories', 'menu_items.category_id', '=', 'menu_categories.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereYear('orders.created_at', $year)
            ->whereMonth('orders.created_at', $month)
            ->whereNotIn('orders.order_status', ['pending', 'cancelled'])
            ->groupBy('menu_items.category_id', 'menu_categories.name')
            ->get();

        // Get top selling items - include all completed orders
        $topItems = OrderItem::query()
            ->select('menu_items.name', 'menu_items.id', DB::raw('SUM(order_items.qty) as total_quantity'), DB::raw('SUM(order_items.price * order_items.qty) as total_price'))
            ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereYear('orders.created_at', $year)
            ->whereMonth('orders.created_at', $month)
            ->whereNotIn('orders.order_status', ['pending', 'cancelled'])
            ->groupBy('menu_items.id', 'menu_items.name')
            ->orderBy('total_quantity', 'desc')
            ->limit(10)
            ->get();

        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        return view('admin.reports.sales-print', compact('orders', 'totalSales', 'totalOrders', 'salesByCategory', 'topItems', 'month', 'year', 'months'));
    }
}
