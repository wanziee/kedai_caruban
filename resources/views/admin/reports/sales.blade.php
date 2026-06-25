@extends('admin.layout')

@section('page-title', 'Laporan Penjualan')

@section('content')
<div class="bg-white rounded-xl shadow-md p-6 mb-6">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Filter Laporan</h3>
    
    <form method="GET" action="{{ route('admin.reports.sales') }}" class="flex gap-4 items-end flex-wrap">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Bulan</label>
            <select name="month" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                @foreach($months as $num => $name)
                    <option value="{{ $num }}" {{ (int)$month === $num ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun</label>
            <select name="year" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                @for($y = now()->year - 5; $y <= now()->year; $y++)
                    <option value="{{ $y }}" {{ (int)$year === $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
        
        <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition font-semibold">
            Tampilkan
        </button>
        
        <a href="{{ route('admin.reports.sales.print', ['month' => $month, 'year' => $year]) }}" target="_blank" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
            🖨️ Cetak
        </a>
    </form>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl shadow-md p-6">
        <p class="text-sm font-semibold opacity-90">Total Penjualan</p>
        <p class="text-3xl font-bold mt-2">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
        <p class="text-sm mt-2">{{ $months[$month] }} {{ $year }}</p>
    </div>
    
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl shadow-md p-6">
        <p class="text-sm font-semibold opacity-90">Total Pesanan Selesai</p>
        <p class="text-3xl font-bold mt-2">{{ $totalOrders }}</p>
        <p class="text-sm mt-2">Pesanan</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Top Selling Items -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">10 Menu Terlaris</h3>
        
        @if($topItems->count())
            <div class="space-y-3">
                @foreach($topItems as $idx => $item)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center justify-center w-6 h-6 bg-primary text-white text-xs font-bold rounded-full">
                                {{ $idx + 1 }}
                            </span>
                            <div>
                                <p class="font-semibold text-gray-800">{{ $item->name }}</p>
                                <p class="text-xs text-gray-500">{{ $item->total_quantity }} terjual</p>
                            </div>
                        </div>
                        <p class="font-semibold text-gray-800">Rp {{ number_format($item->total_price, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">Tidak ada data</p>
        @endif
    </div>

    <!-- Sales by Category -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Penjualan Berdasarkan Kategori</h3>
        
        @if($salesByCategory->count())
            <div class="space-y-3">
                @foreach($salesByCategory as $category)
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <div class="flex justify-between items-start mb-1">
                            <p class="font-semibold text-gray-800">{{ $category->name }}</p>
                            <p class="text-sm font-bold text-primary">Rp {{ number_format($category->total, 0, ',', '.') }}</p>
                        </div>
                        <p class="text-xs text-gray-500">{{ $category->quantity }} item terjual</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">Tidak ada data</p>
        @endif
    </div>
</div>

<!-- Orders Table -->
<div class="bg-white rounded-xl shadow-md mt-6 overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-xl font-bold text-gray-800">Detail Pesanan Bulan {{ $months[$month] }} {{ $year }}</h3>
    </div>

    @if($orders->count())
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">ID Pesanan</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Total Item</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Total Harga</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-semibold text-gray-800">#{{ $order->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $order->orderItems->count() }} item</td>
                            <td class="px-6 py-4 text-sm text-gray-800 font-semibold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm">
                                @php
                                    $paymentClasses = [
                                        'paid' => 'bg-green-100 text-green-800',
                                        'unpaid' => 'bg-gray-100 text-gray-800',
                                        'expired' => 'bg-red-100 text-red-800',
                                        'failed' => 'bg-red-100 text-red-800',
                                    ];
                                    $classes = $paymentClasses[$order->payment_status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $classes }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="p-6 text-center">
            <p class="text-gray-500">Tidak ada pesanan untuk periode ini.</p>
        </div>
    @endif
</div>

@endsection
