<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran QRIS - Kedai Caruban</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo e(env('MIDTRANS_CLIENT_KEY')); ?>"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-lg max-w-md w-full p-6">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Pembayaran QRIS</h1>
            <p class="text-gray-600">Order #<?php echo e($order->id); ?></p>
        </div>

        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600">Total Pembayaran</span>
                <span class="text-xl font-bold text-primary">Rp <?php echo e(number_format($order->total_price, 0, ',', '.')); ?></span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Status Order</span>
                <span class="px-3 py-1 rounded-full text-sm font-semibold 
                    <?php if($order->order_status === 'pending'): ?> bg-yellow-100 text-yellow-800
                    <?php elseif($order->order_status === 'paid'): ?> bg-green-100 text-green-800
                    <?php elseif($order->order_status === 'cancelled'): ?> bg-red-100 text-red-800
                    <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                    <?php echo e(ucfirst($order->order_status)); ?>

                </span>
            </div>
        </div>

        <?php if($order->order_status === 'pending'): ?>
            <button id="pay-button" class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary-dark transition mb-4">
                Bayar Sekarang
            </button>

            <div class="text-center text-sm text-gray-500 mb-4">
                <p>Pembayaran akan expired dalam 30 menit</p>
            </div>

            <div id="payment-status" class="hidden bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                <p class="text-blue-800 text-sm">Menunggu pembayaran...</p>
            </div>
        <?php elseif($order->order_status === 'paid'): ?>
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                <p class="text-green-800 font-semibold text-center">Pembayaran Berhasil!</p>
            </div>
            <a href="<?php echo e(route('payment.receipt', $order->id)); ?>" class="block w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary-dark transition text-center">
                Lihat Struk Pembayaran
            </a>
        <?php else: ?>
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                <p class="text-red-800 font-semibold text-center">Pembayaran Gagal/Expired</p>
            </div>
            <a href="<?php echo e(route('home')); ?>" class="block w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary-dark transition text-center">
                Kembali ke Beranda
            </a>
        <?php endif; ?>

        <script type="text/javascript">
            <?php if($order->order_status === 'pending'): ?>
                const payButton = document.getElementById('pay-button');
                const paymentStatus = document.getElementById('payment-status');

                payButton.addEventListener('click', function() {
                    payButton.disabled = true;
                    payButton.textContent = 'Memproses...';
                    paymentStatus.classList.remove('hidden');

                    snap.pay('<?php echo e($snapToken); ?>', {
                        onSuccess: function(result) {
                            console.log('Payment success:', result);
                            paymentStatus.innerHTML = '<p class="text-green-800 font-semibold">Pembayaran Berhasil! Mengalihkan...</p>';
                            // Redirect immediately without delay
                            window.location.href = '/payment/receipt/<?php echo e($order->id); ?>';
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
                    fetch('/payment/status/<?php echo e($order->id); ?>')
                        .then(response => response.json())
                        .then(data => {
                            console.log('Payment status check:', data);
                            if (data.order_status === 'paid' || data.payment_status === 'success') {
                                console.log('Payment successful, redirecting to receipt');
                                window.location.href = '/payment/receipt/<?php echo e($order->id); ?>';
                            }
                        })
                        .catch(error => {
                            console.error('Error checking payment status:', error);
                        });
                }, 5000);
            <?php endif; ?>
        </script>
    </div>
</body>
</html>
<?php /**PATH /Applications/MAMP/htdocs/kedai-caruban/resources/views/payment/qris.blade.php ENDPATH**/ ?>