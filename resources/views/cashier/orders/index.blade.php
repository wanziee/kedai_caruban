@extends('cashier.layout')

@section('page-title', 'Daftar Pesanan')

@section('content')
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-xl font-bold text-gray-800">Semua Pesanan</h3>
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
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-800">
                                <span class="font-semibold">#{{ $order->id }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $order->orderItems->count() }} item
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800 font-semibold">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <form method="POST" action="{{ route('cashier.orders.updateStatus', $order) }}" class="inline-flex items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="order_status" class="px-3 py-1 text-sm border border-gray-300 rounded-lg transition" onchange="this.form.submit()">
                                        <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="done" {{ $order->order_status === 'done' ? 'selected' : '' }}>Selesai</option>
                                        <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Batal</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <a href="{{ route('cashier.orders.show', $order) }}" class="text-primary hover:text-primary-dark font-semibold transition">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $orders->links() }}
        </div>
    @else
        <div class="p-6 text-center">
            <p class="text-gray-500">Tidak ada pesanan.</p>
        </div>
    @endif
</div>

@endsection
