<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Kedai Caruban</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-primary text-white">
            <div class="p-6 border-b border-primary-light">
                <h1 class="text-2xl font-bold">Admin Panel</h1>
                <p class="text-green-200 text-sm mt-1">Kedai Caruban</p>
            </div>
            <nav class="mt-6">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="block px-6 py-3 hover:bg-primary-light transition <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-primary-light' : ''); ?>">
                    📊 Dashboard
                </a>
                <a href="<?php echo e(route('admin.categories')); ?>" class="block px-6 py-3 hover:bg-primary-light transition <?php echo e(request()->routeIs('admin.categories*') ? 'bg-primary-light' : ''); ?>">
                    📁 Kategori
                </a>
                <a href="<?php echo e(route('admin.menu.index')); ?>" class="block px-6 py-3 hover:bg-primary-light transition <?php echo e(request()->routeIs('admin.menu*') ? 'bg-primary-light' : ''); ?>">
                    🍽️ Menu
                </a>
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="block px-6 py-3 hover:bg-primary-light transition <?php echo e(request()->routeIs('admin.orders*') ? 'bg-primary-light' : ''); ?>">
                    📦 Pesanan
                </a>
                <hr class="my-4 border-primary-light">
                <a href="<?php echo e(route('home')); ?>" class="block px-6 py-3 hover:bg-primary-light transition">
                    👁️ Lihat Website
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Navbar -->
            <div class="bg-white shadow">
                <div class="px-8 py-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h2>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <p class="text-gray-700 font-semibold"><?php echo e(Auth::user()->name); ?></p>
                            <p class="text-sm text-gray-500 capitalize"><?php echo e(Auth::user()->role); ?></p>
                        </div>
                        <form method="POST" action="<?php echo e(route('auth.logout')); ?>" class="inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <main class="flex-1 p-8">
                <?php if(session('success')): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 flex justify-between items-center">
                        <span><?php echo e(session('success')); ?></span>
                        <button type="button" onclick="this.parentElement.style.display='none'" class="text-green-700 hover:text-green-800">
                            ✕
                        </button>
                    </div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>• <?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
<?php /**PATH /Users/wanzie/Downloads/kedai-caruban-2/resources/views/admin/layout.blade.php ENDPATH**/ ?>