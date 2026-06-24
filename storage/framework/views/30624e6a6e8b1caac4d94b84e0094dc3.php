<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran - Kedai Caruban</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-lg max-w-md w-full p-6">
        <!-- Success Header -->
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Pembayaran Berhasil!</h1>
            <p class="text-gray-600">Terima kasih atas pesanan Anda</p>
        </div>

        <!-- Order Info -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600">Kode Pesanan</span>
                <span class="font-bold text-gray-800"><?php echo e($order->order_code); ?></span>
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600">Nomor Meja</span>
                <span class="font-bold text-gray-800"><?php echo e($order->table_number); ?></span>
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600">Nama Pelanggan</span>
                <span class="font-bold text-gray-800"><?php echo e($order->customer_name ?? '-'); ?></span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Status</span>
                <span class="px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                    Lunas
                </span>
            </div>
        </div>

        <!-- Order Items -->
        <div class="mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-3">Detail Pesanan</h3>
            <div class="space-y-3">
                <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800"><?php echo e($item->menuItem->name); ?></p>
                            <p class="text-sm text-gray-600"><?php echo e($item->qty); ?> x Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?></p>
                            <?php if($item->notes): ?>
                                <p class="text-xs text-gray-500 mt-1">Catatan: <?php echo e($item->notes); ?></p>
                            <?php endif; ?>
                        </div>
                        <p class="font-bold text-gray-800">Rp <?php echo e(number_format($item->price * $item->qty, 0, ',', '.')); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- Total -->
        <div class="border-t pt-4 mb-6">
            <div class="flex justify-between items-center">
                <span class="text-xl font-bold text-gray-800">Total</span>
                <span class="text-2xl font-bold text-primary">Rp <?php echo e(number_format($order->total_price, 0, ',', '.')); ?></span>
            </div>
        </div>

        <!-- Screenshot Warning -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <div>
                    <p class="font-semibold text-yellow-800 mb-1">Penting!</p>
                    <p class="text-sm text-yellow-700">Silakan screenshot halaman ini sebagai bukti pembayaran yang valid. Tunjukkan screenshot ini kepada kasir jika diperlukan.</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-3">
            <button onclick="window.print()" class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary-dark transition flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Cetak / Simpan PDF
            </button>
            <a href="<?php echo e(route('home')); ?>" class="block w-full bg-gray-200 text-gray-800 py-3 rounded-lg font-semibold hover:bg-gray-300 transition text-center">
                Pesan Menu Lain
            </a>
        </div>
    </div>
</body>
</html>
<?php /**PATH /Applications/MAMP/htdocs/kedai-caruban/resources/views/payment/receipt.blade.php ENDPATH**/ ?>