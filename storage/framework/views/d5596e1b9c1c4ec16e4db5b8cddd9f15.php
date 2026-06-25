<?php $__env->startSection('content'); ?>
<div>
    <div class="mb-8">
        <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-amber-600 hover:text-amber-800">← Kembali ke Pesanan</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Details -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-4">Detail Pesanan #<?php echo e($order->order_code); ?></h1>
                
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-gray-500 text-sm">Nomor Meja</p>
                        <p class="font-semibold text-gray-800"><?php echo e($order->table_number); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Nama Pelanggan</p>
                        <p class="font-semibold text-gray-800"><?php echo e($order->customer_name ?? '-'); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Status Pesanan</p>
                        <?php
                            $statusClasses = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'diproses' => 'bg-blue-100 text-blue-800',
                                'done' => 'bg-green-100 text-green-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                            ];
                            $classes = $statusClasses[$order->order_status] ?? 'bg-gray-100 text-gray-800';
                        ?>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($classes); ?>">
                            <?php echo e(ucfirst($order->order_status)); ?>

                        </span>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Status Pembayaran</p>
                        <?php
                            $paymentClasses = [
                                'unpaid' => 'bg-gray-100 text-gray-800',
                                'paid' => 'bg-green-100 text-green-800',
                                'expired' => 'bg-red-100 text-red-800',
                                'failed' => 'bg-red-100 text-red-800',
                            ];
                            $paymentClass = $paymentClasses[$order->payment_status] ?? 'bg-gray-100 text-gray-800';
                        ?>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($paymentClass); ?>">
                            <?php echo e(ucfirst($order->payment_status)); ?>

                        </span>
                    </div>
                </div>

                <div class="border-t pt-4">
                    <h3 class="font-semibold text-gray-800 mb-4">Item Pesanan</h3>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800"><?php echo e($item->menuItem->name); ?></p>
                                    <p class="text-sm text-gray-500">Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?> x <?php echo e($item->qty); ?></p>
                                    <?php if($item->notes): ?>
                                        <p class="text-sm text-gray-600 mt-1">Catatan: <?php echo e($item->notes); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-gray-800">Rp <?php echo e(number_format($item->subtotal, 0, ',', '.')); ?></p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="mt-6 pt-4 border-t">
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-gray-800">Total:</span>
                            <span class="text-2xl font-bold text-amber-600">Rp <?php echo e(number_format($order->total_price, 0, ',', '.')); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Status -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Update Status Pesanan</h3>
                <form action="<?php echo e(route('admin.orders.updateStatus', $order)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="flex gap-4">
                        <select name="order_status" required class="flex-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                            <option value="pending" <?php echo e($order->order_status == 'pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="diproses" <?php echo e($order->order_status == 'diproses' ? 'selected' : ''); ?>>Diproses</option>
                            <option value="done" <?php echo e($order->order_status == 'done' ? 'selected' : ''); ?>>Done</option>
                            <option value="cancelled" <?php echo e($order->order_status == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
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
                        <p class="font-semibold text-gray-800"><?php echo e($order->order_code); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Tanggal Pesanan</p>
                        <p class="font-semibold text-gray-800"><?php echo e($order->created_at->format('d M Y H:i')); ?></p>
                    </div>
                    <?php if($order->midtrans_order_id): ?>
                        <div>
                            <p class="text-gray-500 text-sm">Midtrans Order ID</p>
                            <p class="font-semibold text-gray-800"><?php echo e($order->midtrans_order_id); ?></p>
                        </div>
                    <?php endif; ?>
                    <?php if($order->midtrans_transaction_id): ?>
                        <div>
                            <p class="text-gray-500 text-sm">Midtrans Transaction ID</p>
                            <p class="font-semibold text-gray-800"><?php echo e($order->midtrans_transaction_id); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/kedai-caruban/resources/views/admin/orders/show.blade.php ENDPATH**/ ?>