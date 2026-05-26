<?php $__env->startSection('content'); ?>
<div>
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Pesanan</h1>

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Pesanan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Meja</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pembayaran</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900"><?php echo e($order->order_code); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900"><?php echo e($order->table_number); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900"><?php echo e($order->customer_name ?? '-'); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900">Rp <?php echo e(number_format($order->total_price, 0, ',', '.')); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                <?php if($order->order_status == 'pending'): ?> bg-yellow-100 text-yellow-800
                                <?php elseif($order->order_status == 'paid'): ?> bg-green-100 text-green-800
                                <?php elseif($order->order_status == 'cooking'): ?> bg-blue-100 text-blue-800
                                <?php elseif($order->order_status == 'done'): ?> bg-green-100 text-green-800
                                <?php elseif($order->order_status == 'cancelled'): ?> bg-red-100 text-red-800
                                <?php endif; ?>">
                                <?php echo e(ucfirst($order->order_status)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                <?php if($order->payment_status == 'unpaid'): ?> bg-gray-100 text-gray-800
                                <?php elseif($order->payment_status == 'paid'): ?> bg-green-100 text-green-800
                                <?php elseif($order->payment_status == 'expired'): ?> bg-red-100 text-red-800
                                <?php elseif($order->payment_status == 'failed'): ?> bg-red-100 text-red-800
                                <?php endif; ?>">
                                <?php echo e(ucfirst($order->payment_status)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($order->created_at->format('d M Y H:i')); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="text-amber-600 hover:text-amber-900">Detail</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <?php if($orders->count() === 0): ?>
            <div class="text-center py-8 text-gray-500">
                Belum ada pesanan
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/kedai-caruban/resources/views/admin/orders/index.blade.php ENDPATH**/ ?>