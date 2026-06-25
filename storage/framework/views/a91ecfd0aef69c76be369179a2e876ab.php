<?php $__env->startSection('page-title', 'Laporan Penjualan'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-xl shadow-md p-6 mb-6">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Filter Laporan</h3>
    
    <form method="GET" action="<?php echo e(route('admin.reports.sales')); ?>" class="flex gap-4 items-end flex-wrap">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Bulan</label>
            <select name="month" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($num); ?>" <?php echo e((int)$month === $num ? 'selected' : ''); ?>><?php echo e($name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun</label>
            <select name="year" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                <?php for($y = now()->year - 5; $y <= now()->year; $y++): ?>
                    <option value="<?php echo e($y); ?>" <?php echo e((int)$year === $y ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                <?php endfor; ?>
            </select>
        </div>
        
        <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition font-semibold">
            Tampilkan
        </button>
        
        <a href="<?php echo e(route('admin.reports.sales.print', ['month' => $month, 'year' => $year])); ?>" target="_blank" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
            🖨️ Cetak
        </a>
    </form>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl shadow-md p-6">
        <p class="text-sm font-semibold opacity-90">Total Penjualan</p>
        <p class="text-3xl font-bold mt-2">Rp <?php echo e(number_format($totalSales, 0, ',', '.')); ?></p>
        <p class="text-sm mt-2"><?php echo e($months[$month]); ?> <?php echo e($year); ?></p>
    </div>
    
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl shadow-md p-6">
        <p class="text-sm font-semibold opacity-90">Total Pesanan Selesai</p>
        <p class="text-3xl font-bold mt-2"><?php echo e($totalOrders); ?></p>
        <p class="text-sm mt-2">Pesanan</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Top Selling Items -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">10 Menu Terlaris</h3>
        
        <?php if($topItems->count()): ?>
            <div class="space-y-3">
                <?php $__currentLoopData = $topItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center justify-center w-6 h-6 bg-primary text-white text-xs font-bold rounded-full">
                                <?php echo e($idx + 1); ?>

                            </span>
                            <div>
                                <p class="font-semibold text-gray-800"><?php echo e($item->name); ?></p>
                                <p class="text-xs text-gray-500"><?php echo e($item->total_quantity); ?> terjual</p>
                            </div>
                        </div>
                        <p class="font-semibold text-gray-800">Rp <?php echo e(number_format($item->total_price, 0, ',', '.')); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <p class="text-gray-500">Tidak ada data</p>
        <?php endif; ?>
    </div>

    <!-- Sales by Category -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Penjualan Berdasarkan Kategori</h3>
        
        <?php if($salesByCategory->count()): ?>
            <div class="space-y-3">
                <?php $__currentLoopData = $salesByCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <div class="flex justify-between items-start mb-1">
                            <p class="font-semibold text-gray-800"><?php echo e($category->name); ?></p>
                            <p class="text-sm font-bold text-primary">Rp <?php echo e(number_format($category->total, 0, ',', '.')); ?></p>
                        </div>
                        <p class="text-xs text-gray-500"><?php echo e($category->quantity); ?> item terjual</p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <p class="text-gray-500">Tidak ada data</p>
        <?php endif; ?>
    </div>
</div>

<!-- Orders Table -->
<div class="bg-white rounded-xl shadow-md mt-6 overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-xl font-bold text-gray-800">Detail Pesanan Bulan <?php echo e($months[$month]); ?> <?php echo e($year); ?></h3>
    </div>

    <?php if($orders->count()): ?>
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
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-semibold text-gray-800">#<?php echo e($order->id); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($order->created_at->format('d/m/Y H:i')); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($order->orderItems->count()); ?> item</td>
                            <td class="px-6 py-4 text-sm text-gray-800 font-semibold">Rp <?php echo e(number_format($order->total_price, 0, ',', '.')); ?></td>
                            <td class="px-6 py-4 text-sm">
                                <?php
                                    $paymentClasses = [
                                        'paid' => 'bg-green-100 text-green-800',
                                        'unpaid' => 'bg-gray-100 text-gray-800',
                                        'expired' => 'bg-red-100 text-red-800',
                                        'failed' => 'bg-red-100 text-red-800',
                                    ];
                                    $classes = $paymentClasses[$order->payment_status] ?? 'bg-gray-100 text-gray-800';
                                ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($classes); ?>">
                                    <?php echo e(ucfirst($order->payment_status)); ?>

                                </span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="p-6 text-center">
            <p class="text-gray-500">Tidak ada pesanan untuk periode ini.</p>
        </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/kedai-caruban/resources/views/admin/reports/sales.blade.php ENDPATH**/ ?>