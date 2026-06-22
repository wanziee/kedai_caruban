@extends('cashier.layout')

@section('page-title', 'Detail Pesanan #' . $order->id)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Order Details -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Informasi Pesanan</h3>
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <p class="text-sm text-gray-500">ID Pesanan</p>
                    <p class="text-lg font-semibold text-gray-800">#{{ $order->id }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tanggal Pesanan</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Item</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $order->items->count() }} item</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Jumlah Pembayaran</p>
                    <p class="text-lg font-semibold text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Detail Item</h3>
            
            @if($order->orderItems->count())
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Menu</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Harga</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Qty</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    <td class="px-4 py-2 text-sm text-gray-800">
                                        {{ $item->menuItem->name ?? 'Menu Dihapus' }}
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-600">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-600">
                                        {{ $item->qty }}
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-800 font-semibold">
                                        Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Status Update -->
    <div>
        <div class="bg-white rounded-xl shadow-md p-6 sticky top-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Update Status</h3>
            
            <form method="POST" action="{{ route('cashier.orders.updateStatus', $order) }}">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status Pesanan</label>
                    <select name="order_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                        <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="done" {{ $order->order_status === 'done' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Batal</option>
                    </select>
                </div>
                
                <button type="submit" class="w-full px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition font-semibold">
                    Simpan Perubahan
                </button>
            </form>

            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600">
                    <strong>Status Saat Ini:</strong> <br>
                    <span class="capitalize font-semibold text-gray-800">
                        @if($order->order_status === 'pending')
                            <span class="text-yellow-600">Pending</span>
                        @elseif($order->order_status === 'done')
                            <span class="text-green-600">Selesai</span>
                        @else
                            <span class="text-red-600">Batal</span>
                        @endif
                    </span>
                </p>
            </div>

            <a href="{{ route('cashier.orders') }}" class="block mt-4 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition font-semibold text-center">
                ← Kembali
            </a>
        </div>
    </div>
</div>

@endsection
