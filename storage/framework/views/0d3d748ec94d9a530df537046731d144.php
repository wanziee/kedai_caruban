<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Kedai Caruban</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white">
            <div class="p-6">
                <h1 class="text-2xl font-bold">Admin Panel</h1>
                <p class="text-gray-400 text-sm mt-1">Kedai Caruban</p>
            </div>
            <nav class="mt-6">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="block px-6 py-3 hover:bg-gray-700 <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-gray-700' :); ?>">
                    Dashboard
                </a>
                <a href="<?php echo e(route('admin.categories')); ?>" class="block px-6 py-3 hover:bg-gray-700 <?php echo e(request()->routeIs('admin.categories*') ? 'bg-gray-700' :); ?>">
                    Kategori
                </a>
                <a href="<?php echo e(route('admin.menu.index')); ?>" class="block px-6 py-3 hover:bg-gray-700 <?php echo e(request()->routeIs('admin.menu*') ? 'bg-gray-700' :); ?>">
                    Menu
                </a>
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="block px-6 py-3 hover:bg-gray-700 <?php echo e(request()->routeIs('admin.orders*') ? 'bg-gray-700' :); ?>">
                    Pesanan
                </a>
                <a href="<?php echo e(route('home')); ?>" class="block px-6 py-3 hover:bg-gray-700">
                    Lihat Website
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <main class="p-8">
                <?php if(session('success')): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
<?php /**PATH /Users/wanzie/Desktop/kedai-caruban-2/resources/views/admin/layout.blade.php ENDPATH**/ ?>