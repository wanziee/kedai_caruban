<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div x-data="{ showRecentOrders: true, showStatistics: true }">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Total Pesanan</p>
                    <p class="text-3xl font-bold text-primary"><?php echo e(App\Models\Order::count()); ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Pesanan Selesai</p>
                    <p class="text-3xl font-bold text-primary"><?php echo e(App\Models\Order::where('order_status', 'done')->count()); ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Pending</p>
                    <p class="text-3xl font-bold text-blue-600"><?php echo e(App\Models\Order::where('order_status', 'pending')->count()); ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Total Menu</p>
                    <p class="text-3xl font-bold text-purple-600"><?php echo e(App\Models\MenuItem::count()); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Orders Section -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">Pesanan Terbaru</h2>
                
            </div>
            <div x-show="showRecentOrders" x-transition class="space-y-4">
                <?php $recentOrders = App\Models\Order::with('orderItems')->orderBy('created_at', 'desc')->take(5)->get() ?>
                <?php if($recentOrders->count() > 0): ?>
                    <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-semibold text-gray-800"><?php echo e($order->order_code); ?></p>
                                <p class="text-sm text-gray-500">Meja <?php echo e($order->table_number); ?></p>
                            </div>
                            <div class="text-right">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold 
                                    <?php if($order->order_status == 'pending'): ?> bg-yellow-100 text-yellow-800
                                    <?php elseif($order->order_status == 'cooking'): ?> bg-blue-100 text-blue-800
                                    <?php elseif($order->order_status == 'done'): ?> bg-green-100 text-green-800
                                    <?php elseif($order->order_status == 'cancelled'): ?> bg-red-100 text-red-800
                                    <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                                    <?php echo e(ucfirst($order->order_status)); ?>

                                </span>
                                <p class="text-sm text-gray-500 mt-1">Rp <?php echo e(number_format($order->total_price, 0, ',', '.')); ?></p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <p class="text-gray-500 text-center py-4">Belum ada pesanan</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Statistics Section -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">Statistik Pesanan</h2>
                
            </div>
            <div x-show="showStatistics" x-transition class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Pending</span>
                    <span class="font-bold text-yellow-600"><?php echo e(App\Models\Order::where('order_status', 'pending')->count()); ?></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Paid</span>
                    <span class="font-bold text-green-600"><?php echo e(App\Models\Order::where('order_status', 'paid')->count()); ?></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Cooking</span>
                    <span class="font-bold text-blue-600"><?php echo e(App\Models\Order::where('order_status', 'cooking')->count()); ?></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Done</span>
                    <span class="font-bold text-green-600"><?php echo e(App\Models\Order::where('order_status', 'done')->count()); ?></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Cancelled</span>
                    <span class="font-bold text-red-600"><?php echo e(App\Models\Order::where('order_status', 'cancelled')->count()); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/kedai-caruban/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>