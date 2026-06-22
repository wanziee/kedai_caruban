@extends('admin.layout')

@section('page-title', 'Dashboard')

@section('content')
<div x-data="{ showRecentOrders: true, showStatistics: true }">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Total Pesanan</p>
                    <p class="text-3xl font-bold text-primary">{{ App\Models\Order::count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Pesanan Selesai</p>
                    <p class="text-3xl font-bold text-primary">{{ App\Models\Order::where('order_status', 'done')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Pending</p>
                    <p class="text-3xl font-bold text-blue-600">{{ App\Models\Order::where('order_status', 'pending')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Total Menu</p>
                    <p class="text-3xl font-bold text-purple-600">{{ App\Models\MenuItem::count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Orders Section -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">Pesanan Terbaru</h2>
                {{-- <button @click="showRecentOrders = !showRecentOrders" 
                    class="px-3 py-1 rounded-lg text-sm font-medium transition"
                    :class="showRecentOrders ? 'bg-blue-500 hover:bg-blue-600 text-white' : 'bg-gray-300 hover:bg-gray-400 text-gray-800'">
                    <span x-show="showRecentOrders">Sembunyikan</span>
                    <span x-show="!showRecentOrders">Tampilkan</span>
                </button> --}}
            </div>
            <div x-show="showRecentOrders" x-transition class="space-y-4">
                @php $recentOrders = App\Models\Order::with('orderItems')->orderBy('created_at', 'desc')->take(5)->get() @endphp
                @if($recentOrders->count() > 0)
                    @foreach($recentOrders as $order)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $order->order_code }}</p>
                                <p class="text-sm text-gray-500">Meja {{ $order->table_number }}</p>
                            </div>
                            <div class="text-right">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'cooking' => 'bg-blue-100 text-blue-800',
                                        'done' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                    ];
                                    $classes = $statusClasses[$order->order_status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $classes }}">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                                <p class="text-sm text-gray-500 mt-1">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500 text-center py-4">Belum ada pesanan</p>
                @endif
            </div>
        </div>

        <!-- Statistics Section -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">Statistik Pesanan</h2>
                {{-- <button @click="showStatistics = !showStatistics" 
                    class="px-3 py-1 rounded-lg text-sm font-medium transition"
                    :class="showStatistics ? 'bg-blue-500 hover:bg-blue-600 text-white' : 'bg-gray-300 hover:bg-gray-400 text-gray-800'">
                    <span x-show="showStatistics">Sembunyikan</span>
                    <span x-show="!showStatistics">Tampilkan</span>
                </button> --}}
            </div>
            <div x-show="showStatistics" x-transition class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Pending</span>
                    <span class="font-bold text-yellow-600">{{ App\Models\Order::where('order_status', 'pending')->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Paid</span>
                    <span class="font-bold text-green-600">{{ App\Models\Order::where('order_status', 'paid')->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Cooking</span>
                    <span class="font-bold text-blue-600">{{ App\Models\Order::where('order_status', 'cooking')->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Done</span>
                    <span class="font-bold text-green-600">{{ App\Models\Order::where('order_status', 'done')->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Cancelled</span>
                    <span class="font-bold text-red-600">{{ App\Models\Order::where('order_status', 'cancelled')->count() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
