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
            --primary-color: #1B4434;
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
            <div class="flex justify-between items-center py-3">

                <div class="flex items-center">
                    <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo" class="h-12 w-auto object-contain">
                </div>

                <div class="flex space-x-1">
                    <a href="<?php echo e(route('home')); ?>"
                        class="px-4 py-2 rounded-lg hover:bg-primary-light transition <?php echo e(request()->routeIs('home') ? 'bg-primary-light' : ''); ?>">
                        Home
                    </a>

                    <a href="<?php echo e(route('company')); ?>"
                        class="px-4 py-2 rounded-lg hover:bg-primary-light transition <?php echo e(request()->routeIs('company') ? 'bg-primary-light' : ''); ?>">
                        Company
                    </a>

                    <a href="<?php echo e(route('order')); ?>"
                        class="px-4 py-2 rounded-lg hover:bg-primary-light transition <?php echo e(request()->routeIs('order') ? 'bg-primary-light' : ''); ?>">
                        Order
                    </a>
                </div>

            </div>
        </div>
    </nav>
    <!-- Mobile Navbar (Bottom) -->
    <nav class="md:hidden fixed bottom-1 width-full inset-x-4 text-white h-20 z-50 flex gap-2 justify-around">
        <div class="flex justify-around w-full h-full bg-primary items-center rounded-full shadow-lg p-2">
            <a href="<?php echo e(route('home')); ?>"
                class="flex flex-col items-center space-y-1 px-4 py-2 w-full h-full rounded-full  <?php echo e(request()->routeIs('home') ? 'bg-primary-light' : ''); ?>">
                <svg fill="white" class="w-8 h-8" viewBox="0 0 24 24" id="home" data-name="Flat Line"
                    xmlns="http://www.w3.org/2000/svg" class="icon flat-line">
                    <path id="secondary"
                        d="M19,10V20.3a.77.77,0,0,1-.83.7H14.3V14.1H9.7V21H5.83A.77.77,0,0,1,5,20.3V10l7-7Z"
                        style="<?php echo e(request()->routeIs('home') ? 'fill: white' : 'fill: none '); ?>"></path>
                    <path id="primary" d="M19,10V20.3a.77.77,0,0,1-.83.7H14.3V14.1H9.7V21H5.83A.77.77,0,0,1,5,20.3V10"
                        style="fill: none; stroke: white; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;">
                    </path>
                    <polyline id="primary-2" data-name="primary" points="21 12 12 3 3 12"
                        style="fill: none; stroke: white; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;">
                    </polyline>
                </svg>
                <span class="text-xs <?php echo e(request()->routeIs('home') ? 'font-bold' : ''); ?>">Home</span>
            </a>
            <a href="<?php echo e(route('company')); ?>"
                class="flex flex-col items-center space-y-1 px-4 py-2 w-full h-full rounded-full  <?php echo e(request()->routeIs('company') ? 'bg-primary-light' : ''); ?>">
                <svg class="w-8 h-8" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">

                    <path fill="<?php echo e(request()->routeIs('company') ? 'white' : 'none'); ?>" stroke="white"
                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" stroke="white"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />

                    <circle cx="12" cy="9" r="3"
                        fill="<?php echo e(request()->routeIs('company') ? 'var(--primary-color)' : 'white'); ?>" />
                </svg>
                <span class="text-xs <?php echo e(request()->routeIs('company') ? 'font-bold' : ''); ?>">Company</span>
            </a>
            <a href="<?php echo e(route('order')); ?>"
                class="flex flex-col items-center space-y-1 px-4 py-2 w-full h-full rounded-full  <?php echo e(request()->routeIs('order') ? 'bg-primary-light' : ''); ?>">
                <svg fill="#000000" class="w-8 h-8" viewBox="0 0 24 24" id="cart" data-name="Flat Line"
                    xmlns="http://www.w3.org/2000/svg" class="icon flat-line">
                    <polygon id="secondary" points="21 7 19 15 8 16 6.62 7 21 7"
                        style="fill: <?php echo e(request()->routeIs('order') ? 'white' : 'var(--primary-color)'); ?>;"></polygon>
                    <path id="primary-upstroke" d="M11,20.5h.1m5.9,0h.1"
                        style="fill: none; stroke: white; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2.5;">
                    </path>
                    <path id="primary" d="M3,3H5.14a1,1,0,0,1,1,.85L6.62,7,8,16l11-1,2-8H6.62"
                        style="fill: none; stroke: white; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;">
                    </path>
                </svg>
                <span class="text-xs <?php echo e(request()->routeIs('order') ? 'font-bold' : ''); ?>">Order</span>
            </a>
        </div>
        <div
            class="flex justify-center bg-primary w-20 h-20 items-center rounded-full shadow-lg p-2 <?php echo e(request()->routeIs('search') ? 'bg-primary-light' : 'bg-primary'); ?>">
            <a href="<?php echo e(route('search')); ?>"
                class="flex  items-center space-y-1 px-4 py-2 w-full h-full rounded-full  ">
                <svg fill="#000000"  viewBox="0 0 24 24" id="search"
                    data-name="Flat Line" xmlns="http://www.w3.org/2000/svg" class="icon flat-line h-8 w-8">
                    <circle id="secondary" cx="10" cy="10" r="7"
                        style="fill: <?php echo e(request()->routeIs('search') ? '' : 'var(--primary-color)'); ?>; stroke-width: 2;"></circle>
                    <path id="primary" d="M21,21l-6-6M10,3a7,7,0,1,0,7,7A7,7,0,0,0,10,3Z"
                        style="fill: none; stroke: white; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;">
                    </path>
                </svg>
                
            </a>
        </div>
    </nav>
    <!-- Floating Search Button -->


    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="bg-primary-dark text-white py-6 mt-12 hidden md:block">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; 2024 Kedai Caruban. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>

</html>
<?php /**PATH /Applications/MAMP/htdocs/kedai-caruban/resources/views/frontend/layout.blade.php ENDPATH**/ ?>