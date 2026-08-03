<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran QRIS - Kedai Caruban</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-lg max-w-md w-full p-6">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Pembayaran QRIS</h1>
            <p class="text-gray-600">{{ $order->order_code }}</p>
        </div>

        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600">Total Pembayaran</span>
                <span class="text-xl font-bold text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Status Order</span>
                <span class="px-3 py-1 rounded-full text-sm font-semibold 
                    @if($order->order_status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($order->order_status === 'diproses') bg-blue-100 text-blue-800
                    @elseif($order->order_status === 'done') bg-green-100 text-green-800
                    @elseif($order->order_status === 'cancelled') bg-red-100 text-red-800
                    @else bg-gray-100 text-gray-800 @endif">
                    {{ ucfirst($order->order_status) }}
                </span>
            </div>
        </div>

        <!-- Order Details -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <h3 class="font-semibold text-gray-800 mb-3">Detail Pesanan</h3>
            <div class="space-y-3">
                @foreach($order->orderItems as $item)
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-800">{{ $item->menuItem->name }}</p>
                            <p class="text-sm text-gray-500">{{ $item->qty }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                        <p class="font-semibold text-gray-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        @if($order->order_status === 'pending')
            <button id="pay-button" class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary-dark transition mb-4">
                Bayar Sekarang
            </button>

            <div class="text-center text-sm text-gray-500 mb-4">
                <p>Pembayaran akan expired dalam 30 menit</p>
            </div>

            <div id="payment-status" class="hidden bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                <p class="text-blue-800 text-sm">Menunggu pembayaran...</p>
            </div>
        @elseif($order->order_status === 'diproses')
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                <p class="text-green-800 font-semibold text-center">Pembayaran Berhasil!</p>
            </div>
            <a href="{{ route('payment.receipt', $order->id) }}" class="block w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary-dark transition text-center">
                Lihat Struk Pembayaran
            </a>
        @else
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                <p class="text-red-800 font-semibold text-center">Pembayaran Gagal/Expired</p>
            </div>
            <a href="{{ route('home') }}" class="block w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary-dark transition text-center">
                Kembali ke Beranda
            </a>
        @endif

        <script type="text/javascript">
            @if($order->order_status === 'pending')
                const payButton = document.getElementById('pay-button');
                const paymentStatus = document.getElementById('payment-status');

                payButton.addEventListener('click', function() {
                    if (typeof snap === 'undefined') {
                        console.error('Snap.js is not loaded');
                        paymentStatus.innerHTML = '<p class="text-red-800">Error: Payment gateway tidak tersedia. Silakan refresh halaman.</p>';
                        payButton.disabled = false;
                        payButton.textContent = 'Coba Lagi';
                        return;
                    }

                    payButton.disabled = true;
                    payButton.textContent = 'Memproses...';
                    paymentStatus.classList.remove('hidden');

                    console.log('Snap token:', '{{ $snapToken }}');

                    snap.pay('{{ $snapToken }}', {
                        onSuccess: function(result) {
                            console.log('Payment success:', result);
                            paymentStatus.innerHTML = '<p class="text-green-800 font-semibold">Pembayaran Berhasil! Mengalihkan...</p>';
                            // Redirect immediately without delay
                            window.location.href = '/payment/receipt/{{ $order->id }}';
                        },
                        onPending: function(result) {
                            console.log('Payment pending:', result);
                            paymentStatus.innerHTML = '<p class="text-yellow-800">Menunggu pembayaran...</p>';
                        },
                        onError: function(result) {
                            console.log('Payment error:', result);
                            paymentStatus.innerHTML = '<p class="text-red-800">Pembayaran Gagal!</p>';
                            payButton.disabled = false;
                            payButton.textContent = 'Coba Lagi';
                        },
                        onClose: function() {
                            console.log('Payment closed');
                            paymentStatus.innerHTML = '<p class="text-gray-800">Pembayaran ditutup</p>';
                            payButton.disabled = false;
                            payButton.textContent = 'Bayar dengan QRIS';
                        }
                    });
                });

                // Auto check payment status every 5 seconds
                setInterval(function() {
                    fetch('/payment/status/{{ $order->id }}')
                        .then(response => response.json())
                        .then(data => {
                            console.log('Payment status check:', data);
                            if (data.order_status === 'diproses' || data.payment_status === 'paid') {
                                console.log('Payment successful, redirecting to receipt');
                                window.location.href = '/payment/receipt/{{ $order->id }}';
                            }
                        })
                        .catch(error => {
                            console.error('Error checking payment status:', error);
                        });
                }, 5000);
            @endif
        </script>
    </div>
</body>
</html>
