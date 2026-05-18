<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kedai Caruban</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <style>
        :root {
            --primary-color: #0E3A0F;
            --primary-dark: #092807;
            --primary-light: #1a5a1c;
        }
        body {
            padding-bottom: 80px;
        }
        @media (max-width: 768px) {
            body {
                padding-bottom: 80px;
            }
        }
        @media (min-width: 769px) {
            body {
                padding-bottom: 0;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Desktop Navbar -->
    <nav class="hidden md:block bg-primary text-white shadow-lg sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-2">
                    <h1 class="text-2xl font-bold">Kedai Caruban</h1>
                </div>
                <div class="flex space-x-1">
                    <a href="<?php echo e(route('home')); ?>" class="px-4 py-2 rounded-lg hover:bg-primary-light transition <?php echo e(request()->routeIs('home') ? 'bg-primary-light' : ''); ?>">
                        Home
                    </a>
                    <a href="<?php echo e(route('company')); ?>" class="px-4 py-2 rounded-lg hover:bg-primary-light transition <?php echo e(request()->routeIs('company') ? 'bg-primary-light' : ''); ?>">
                        Company
                    </a>
                    <a href="<?php echo e(route('order')); ?>" class="px-4 py-2 rounded-lg hover:bg-primary-light transition <?php echo e(request()->routeIs('order') ? 'bg-primary-light' : ''); ?>">
                        Order
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Navbar (Bottom) -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-primary text-white shadow-lg z-50">
        <div class="flex justify-around items-center py-3">
            <a href="<?php echo e(route('home')); ?>" class="flex flex-col items-center space-y-1 px-4 py-2 rounded-lg <?php echo e(request()->routeIs('home') ? 'bg-primary-light' : ''); ?>">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l-5-5m0 0l-2-2m2 2l2-2m0 0l5 5m0 0l2 2m-2-2l-2 2"></path>
                </svg>
                <span class="text-xs">Home</span>
            </a>
            <a href="<?php echo e(route('company')); ?>" class="flex flex-col items-center space-y-1 px-4 py-2 rounded-lg <?php echo e(request()->routeIs('company') ? 'bg-primary-light' : ''); ?>">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <span class="text-xs">Company</span>
            </a>
            <a href="<?php echo e(route('order')); ?>" class="flex flex-col items-center space-y-1 px-4 py-2 rounded-lg <?php echo e(request()->routeIs('order') ? 'bg-primary-light' : ''); ?>">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span class="text-xs">Order</span>
            </a>
        </div>
    </nav>

    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="bg-primary-dark text-white py-6 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; 2024 Kedai Caruban. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
<?php /**PATH /Users/wanzie/Desktop/kedai-caruban-2/resources/views/frontend/layout.blade.php ENDPATH**/ ?>