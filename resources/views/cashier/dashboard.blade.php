@extends('cashier.layout')

@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Today's Orders -->
    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-full">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Pesanan Hari Ini</p>
                <p class="text-3xl font-bold text-blue-600">{{ $todayOrders }}</p>
            </div>
        </div>
    </div>

    <!-- Pending Orders -->
    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-100 rounded-full">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Pesanan Pending</p>
                <p class="text-3xl font-bold text-yellow-600">{{ $pendingOrders }}</p>
            </div>
        </div>
    </div>

    <!-- Completed Today -->
    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-full">
                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Selesai Hari Ini</p>
                <p class="text-3xl font-bold text-primary">{{ $completedOrders }}</p>
            </div>
        </div>
    </div>

    <!-- Today's Sales -->
    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
        <div class="flex items-center">
            <div class="p-3 bg-purple-100 rounded-full">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Penjualan Hari Ini</p>
                <p class="text-3xl font-bold text-purple-600">Rp {{ number_format($todaySales, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-xl font-bold mb-4 text-gray-800">Aksi Cepat</h3>
        <div class="space-y-2">
            <a href="{{ route('cashier.orders') }}" class="block px-4 py-3 bg-primary text-white rounded-lg hover:bg-primary-dark transition text-center font-semibold">
                📦 Kelola Pesanan
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-xl font-bold mb-4 text-gray-800">Informasi</h3>
        <p class="text-gray-600">Sebagai cashier, Anda dapat mengelola pesanan dan memantau status pesanan dari sini.</p>
    </div>
</div>

@endsection
