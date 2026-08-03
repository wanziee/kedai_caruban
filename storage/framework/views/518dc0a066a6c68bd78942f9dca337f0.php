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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
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
                        <td class="px-6 py-4 text-gray-900">
                            <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div><?php echo e($item->menuItem->name ?? 'N/A'); ?> x<?php echo e($item->qty); ?></div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900">Rp <?php echo e(number_format($order->total_price, 0, ',', '.')); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <select onchange="updateOrderStatus(<?php echo e($order->id); ?>, this.value)"
                                class="px-2 py-1 text-xs leading-5 font-semibold rounded-full border-0 cursor-pointer
                                <?php if($order->order_status == 'pending'): ?> bg-yellow-100 text-yellow-800
                                <?php elseif($order->order_status == 'diproses'): ?> bg-blue-100 text-blue-800
                                <?php elseif($order->order_status == 'done'): ?> bg-green-100 text-green-800
                                <?php elseif($order->order_status == 'cancelled'): ?> bg-red-100 text-red-800
                                <?php endif; ?>">
                                <option value="pending" <?php if($order->order_status == 'pending'): ?> selected <?php endif; ?>>Pending</option>
                                <option value="diproses" <?php if($order->order_status == 'diproses'): ?> selected <?php endif; ?>>Diproses</option>
                                <option value="done" <?php if($order->order_status == 'done'): ?> selected <?php endif; ?>>Done</option>
                                <option value="cancelled" <?php if($order->order_status == 'cancelled'): ?> selected <?php endif; ?>>Cancelled</option>
                            </select>
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

<!-- Custom Modal -->
<div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-sm w-full mx-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Ubah Status Pesanan</h3>
        <p class="text-gray-600 mb-4">Apakah Anda yakin ingin mengubah status pesanan ini?</p>
        <div class="flex gap-3 justify-end">
            <button onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                Batal
            </button>
            <button onclick="confirmStatusChange()" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition">
                Ya, Ubah
            </button>
        </div>
    </div>
</div>

<script>
    let currentOrderId = null;
    let currentNewStatus = null;

    function updateOrderStatus(orderId, newStatus) {
        currentOrderId = orderId;
        currentNewStatus = newStatus;
        document.getElementById('confirmModal').classList.remove('hidden');
        document.getElementById('confirmModal').classList.add('flex');
    }

    function closeModal() {
        document.getElementById('confirmModal').classList.add('hidden');
        document.getElementById('confirmModal').classList.remove('flex');
        currentOrderId = null;
        currentNewStatus = null;
    }

    function confirmStatusChange() {
        closeModal();

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        console.log('Updating order status:', {
            orderId: currentOrderId,
            newStatus: currentNewStatus,
            csrfToken: csrfToken
        });

        // Use window.location to get the full URL including port
        const url = window.location.origin + `/admin/orders/${currentOrderId}/status`;
        console.log('Request URL:', url);
        console.log('Window location:', window.location.origin);

        fetch(url, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                order_status: currentNewStatus
            })
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error('HTTP error! status: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal mengubah status: ' + (data.message || 'Unknown error'));
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan: ' + error.message);
            location.reload();
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/kedai-caruban/resources/views/admin/orders/index.blade.php ENDPATH**/ ?>