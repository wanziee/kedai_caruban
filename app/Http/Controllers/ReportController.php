<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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
            ->where('payment_status', 'paid')
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
            ->where('orders.payment_status', 'paid')
            ->groupBy('menu_items.category_id', 'menu_categories.name')
            ->get();

        // Get top selling items - include all completed orders
        $topItems = OrderItem::query()
            ->select('menu_items.name', 'menu_items.id', DB::raw('SUM(order_items.qty) as total_quantity'), DB::raw('SUM(order_items.price * order_items.qty) as total_price'))
            ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereYear('orders.created_at', $year)
            ->whereMonth('orders.created_at', $month)
            ->where('orders.payment_status', 'paid')
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
            ->where('payment_status', 'paid')
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
            ->where('orders.payment_status', 'paid')
            ->groupBy('menu_items.category_id', 'menu_categories.name')
            ->get();

        // Get top selling items - include all completed orders
        $topItems = OrderItem::query()
            ->select('menu_items.name', 'menu_items.id', DB::raw('SUM(order_items.qty) as total_quantity'), DB::raw('SUM(order_items.price * order_items.qty) as total_price'))
            ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereYear('orders.created_at', $year)
            ->whereMonth('orders.created_at', $month)
            ->where('orders.payment_status', 'paid')
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

    /**
     * Export laporan penjualan ke Excel
     */
    public function salesExport(Request $request)
    {
        $month = (int) $request->input('month', now()->month);
        $year = (int) $request->input('year', now()->year);

        // Get sales data for the month
        $orders = Order::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('payment_status', 'paid')
            ->with('orderItems.menuItem')
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate totals
        $totalSales = $orders->sum('total_price');
        $totalOrders = $orders->count();

        // Get top selling items
        $topItems = OrderItem::query()
            ->select('menu_items.name', DB::raw('SUM(order_items.qty) as total_quantity'), DB::raw('SUM(order_items.price * order_items.qty) as total_price'))
            ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereYear('orders.created_at', $year)
            ->whereMonth('orders.created_at', $month)
            ->where('orders.payment_status', 'paid')
            ->groupBy('menu_items.id', 'menu_items.name')
            ->orderBy('total_quantity', 'desc')
            ->limit(10)
            ->get();

        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        // Create new Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set document properties
        $spreadsheet->getProperties()
            ->setCreator('Kedai Caruban')
            ->setLastModifiedBy('Kedai Caruban')
            ->setTitle('Laporan Penjualan')
            ->setSubject('Laporan Penjualan')
            ->setDescription('Laporan Penjualan Kedai Caruban');

        // Title
        $sheet->setCellValue('A1', 'LAPORAN PENJUALAN');
        $sheet->setCellValue('A2', 'Kedai Caruban');
        $sheet->setCellValue('A3', 'Periode: ' . $months[$month] . ' ' . $year);
        $sheet->mergeCells('A1:E1');
        $sheet->mergeCells('A2:E2');
        $sheet->mergeCells('A3:E3');

        // Style title
        $sheet->getStyle('A1:A3')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1:A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Summary
        $sheet->setCellValue('A5', 'RINGKASAN');
        $sheet->setCellValue('A6', 'Total Penjualan:');
        $sheet->setCellValue('B6', 'Rp ' . number_format($totalSales, 0, ',', '.'));
        $sheet->setCellValue('A7', 'Total Pesanan:');
        $sheet->setCellValue('B7', $totalOrders . ' pesanan');

        $sheet->getStyle('A5')->getFont()->setBold(true);
        $sheet->getStyle('A6:B7')->getFont()->setBold(true);

        // Top Selling Items
        $sheet->setCellValue('A9', '10 MENU TERLARIS');
        $sheet->getStyle('A9')->getFont()->setBold(true);

        $sheet->setCellValue('A10', 'No');
        $sheet->setCellValue('B10', 'Nama Menu');
        $sheet->setCellValue('C10', 'Jumlah Terjual');
        $sheet->setCellValue('D10', 'Total Pendapatan');

        // Style header
        $headerStyle = [
            'font' => ['bold' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '4CAF50']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ];
        $sheet->getStyle('A10:D10')->applyFromArray($headerStyle);
        $sheet->getStyle('A10:D10')->getFont()->getColor()->setRGB('FFFFFF');

        $row = 11;
        foreach ($topItems as $index => $item) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $item->name);
            $sheet->setCellValue('C' . $row, $item->total_quantity);
            $sheet->setCellValue('D' . $row, 'Rp ' . number_format($item->total_price, 0, ',', '.'));
            $row++;
        }

        // Border for items
        $sheet->getStyle('A11:D' . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Orders Detail
        $row += 2;
        $sheet->setCellValue('A' . $row, 'DETAIL PESANAN');
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        $row++;

        $sheet->setCellValue('A' . $row, 'ID');
        $sheet->setCellValue('B' . $row, 'Kode Pesanan');
        $sheet->setCellValue('C' . $row, 'Tanggal');
        $sheet->setCellValue('D' . $row, 'Total Item');
        $sheet->setCellValue('E' . $row, 'Total Harga');
        $sheet->setCellValue('F' . $row, 'Status Pembayaran');

        $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray($headerStyle);
        $sheet->getStyle('A' . $row . ':F' . $row)->getFont()->getColor()->setRGB('FFFFFF');

        $row++;
        foreach ($orders as $order) {
            $sheet->setCellValue('A' . $row, $order->id);
            $sheet->setCellValue('B' . $row, $order->order_code);
            $sheet->setCellValue('C' . $row, $order->created_at->format('d/m/Y H:i'));
            $sheet->setCellValue('D' . $row, $order->orderItems->count());
            $sheet->setCellValue('E' . $row, 'Rp ' . number_format($order->total_price, 0, ',', '.'));
            $sheet->setCellValue('F' . $row, ucfirst($order->payment_status));
            $row++;
        }

        // Border for orders
        $sheet->getStyle('A' . ($row - count($orders)) . ':F' . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Auto size columns
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Generate filename
        $filename = 'Laporan_Penjualan_' . $months[$month] . '_' . $year . '.xlsx';

        // Create Excel file
        $writer = new Xlsx($spreadsheet);

        // Set headers
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
