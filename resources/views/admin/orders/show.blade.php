@extends('admin.layout')

@section('content')
<div>
    <div class="mb-8">
        <a href="{{ route('admin.orders.index') }}" class="text-amber-600 hover:text-amber-800">← Kembali ke Pesanan</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Details -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-4">Detail Pesanan #{{ $order->order_code }}</h1>
                
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-gray-500 text-sm">Nomor Meja</p>
                        <p class="font-semibold text-gray-800">{{ $order->table_number }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Nama Pelanggan</p>
                        <p class="font-semibold text-gray-800">{{ $order->customer_name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Status Pesanan</p>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($order->order_status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->order_status == 'paid') bg-green-100 text-green-800
                            @elseif($order->order_status == 'cooking') bg-blue-100 text-blue-800
                            @elseif($order->order_status == 'done') bg-green-100 text-green-800
                            @elseif($order->order_status == 'cancelled') bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Status Pembayaran</p>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($order->payment_status == 'unpaid') bg-gray-100 text-gray-800
                            @elseif($order->payment_status == 'paid') bg-green-100 text-green-800
                            @elseif($order->payment_status == 'expired') bg-red-100 text-red-800
                            @elseif($order->payment_status == 'failed') bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>

                <div class="border-t pt-4">
                    <h3 class="font-semibold text-gray-800 mb-4">Item Pesanan</h3>
                    <div class="space-y-4">
                        @foreach($order->orderItems as $item)
                            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800">{{ $item->menuItem->name }}</p>
                                    <p class="text-sm text-gray-500">Rp {{ number_format($item->price, 0, ',', '.') }} x {{ $item->qty }}</p>
                                    @if($item->notes)
                                        <p class="text-sm text-gray-600 mt-1">Catatan: {{ $item->notes }}</p>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-gray-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 pt-4 border-t">
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-gray-800">Total:</span>
                            <span class="text-2xl font-bold text-amber-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Status -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Update Status Pesanan</h3>
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="flex gap-4">
                        <select name="order_status" required class="flex-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                            <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $order->order_status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="cooking" {{ $order->order_status == 'cooking' ? 'selected' : '' }}>Cooking</option>
                            <option value="done" {{ $order->order_status == 'done' ? 'selected' : '' }}>Done</option>
                            <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="bg-amber-600 text-white px-6 py-2 rounded-lg hover:bg-amber-700 transition">
                            Update Status
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Order Info -->
        <div>
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Informasi Pesanan</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-gray-500 text-sm">Kode Pesanan</p>
                        <p class="font-semibold text-gray-800">{{ $order->order_code }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Tanggal Pesanan</p>
                        <p class="font-semibold text-gray-800">{{ $order->created_at->format('d M Y H:i') }}</p>
                    </div>
                    @if($order->midtrans_order_id)
                        <div>
                            <p class="text-gray-500 text-sm">Midtrans Order ID</p>
                            <p class="font-semibold text-gray-800">{{ $order->midtrans_order_id }}</p>
                        </div>
                    @endif
                    @if($order->midtrans_transaction_id)
                        <div>
                            <p class="text-gray-500 text-sm">Midtrans Transaction ID</p>
                            <p class="font-semibold text-gray-800">{{ $order->midtrans_transaction_id }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
