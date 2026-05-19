<?php $__env->startSection('content'); ?>
    <div x-data="initCart()" x-init="console.log('Cart initialized:', cart);
    $watch('cart', value => localStorage.setItem('cart', JSON.stringify(value)))" class="min-h-screen">

        <script>
            function initCart() {
                return {
                    selectedCategory: 'all',
                    cart: JSON.parse(localStorage.getItem('cart') || '[]'),
                    bannerSlide: 0,
                    banners: [{
                            title: 'Selamat Datang di Kedai Caruban',
                            subtitle: 'Nikmati hidangan lezat kami dengan kualitas terbaik',
                            gradient: 'from-primary to-primary-light'
                        },
                        {
                            title: 'Cita Rasa Autentik',
                            subtitle: 'Resep tradisional dengan sentuhan modern',
                            gradient: 'from-primary-light to-primary'
                        },
                        {
                            title: 'Pesan Sekarang',
                            subtitle: 'Dapatkan pengalaman kuliner terbaik Anda',
                            gradient: 'from-primary to-[#2d7a2f]'
                        },
                        {
                            title: 'Pesan Sekarang',
                            subtitle: 'Dapatkan pengalaman kuliner terbaik Anda',
                            gradient: 'from-primary to-[#2d7a2f]'
                        }
                    ],
                    nextSlide() {
                        this.bannerSlide = (this.bannerSlide + 1) % this.banners.length;
                    },
                    prevSlide() {
                        this.bannerSlide = (this.bannerSlide - 1 + this.banners.length) % this.banners.length;
                    },
                    addToCart(id, name, price) {
                        console.log('Adding to cart:', {
                            id,
                            name,
                            price
                        });
                        const existingItem = this.cart.find(item => item.id === id);
                        if (existingItem) {
                            existingItem.qty++;
                        } else {
                            this.cart.push({
                                id,
                                name,
                                price,
                                qty: 1,
                                notes: ''
                            });
                        }
                        localStorage.setItem('cart', JSON.stringify(this.cart));
                        console.log('Cart after add:', this.cart);
                        alert('Item added to cart!');
                    }
                }
            }
        </script>

        <!-- Banner Carousel -->
        <div class="relative text-white px-4 rounded-2xl overflow-hidden">
            <div x-init="setInterval(() => nextSlide(), 5000)">
                <template x-for="(banner, index) in banners" :key="index">
                    <div x-show="bannerSlide === index" :class="`bg-gradient-to-r ${banner.gradient}`"
                        class="h-[250px] md:h-[500px] px-4 transition-opacity duration-1000 flex items-center rounded-2xl">
                        <div class="max-w-7xl mx-auto text-center">
                            <h1 class="text-4xl md:text-5xl font-bold mb-4" x-text="banner.title"></h1>
                            <p class="text-lg md:text-xl" x-text="banner.subtitle"></p>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Banner Indicators -->

            <div class="absolute top-0 left-0 right-0 flex gap-2 px-8 py-4 z-10">
                <template x-for="(banner, index) in banners" :key="index">
                    <div :class="bannerSlide === index ?
                        'bg-white opacity-100' :
                        'bg-white/40 opacity-70'"
                        class="flex-1 min-h-[4px] rounded-full transition-all duration-500">
                    </div>
                </template>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4  ">

            <!-- Categories -->

            <div class="max-w-7xl mx-auto py-6 mb-4">
                <h3 class="text-2xl font-bold mb-4">Kategori Produk</h3>
                <div class="flex flex-wrap justify-between items-center  ">

                    <button type="button" @click="selectedCategory = 'all'"
                        class="flex flex-col items-center gap-2 focus:outline-none group w-24 md:w-24">
                        <div :class="selectedCategory === 'all' ? 'scale-105 shadow-md' :
                            'border-2 border-transparent hover:scale-105'"
                            class="  md:w-20 md:h-20 rounded-full overflow-hidden bg-gray-50 p-3 flex items-center justify-center transition-all duration-200">
                            <img src="<?php echo e(asset('images/category-all.png')); ?>" alt="Semua"
                                class="w-full h-full md:w-20 md:h-20 object-cover">
                        </div>
                        <span
                            :class="selectedCategory === 'all' ? 'text-green-800 font-bold' :
                                'text-gray-700 font-medium group-hover:text-green-600'"
                            class="text-sm md:text-base transition-colors text-center truncate w-full">
                            Semua
                        </span>
                    </button>

                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button type="button" @click="selectedCategory = '<?php echo e(strtolower($category->name)); ?>'"
                            class="flex flex-col items-center gap-2 focus:outline-none group w-24 md:w-24">
                            <div :class="selectedCategory === '<?php echo e(strtolower($category->name)); ?>' ?
                                ' scale-105 shadow-md' :
                                'border-2 border-transparent hover:scale-105'"
                                class="md:w-20 md:h-20 rounded-full overflow-hidden bg-gray-50 p-2 flex items-center justify-center transition-all duration-200">
                                <img src="<?php echo e(asset('storage/' . $category->image)); ?>" alt="<?php echo e($category->name); ?>"
                                    class="w-full h-full object-cover">
                            </div>
                            <span
                                :class="selectedCategory === '<?php echo e(strtolower($category->name)); ?>' ? 'text-green-800 font-bold' :
                                    'text-gray-700 font-medium group-hover:text-green-600'"
                                class="text-sm md:text-base transition-colors text-center truncate w-full">
                                <?php echo e($category->name); ?>

                            </span>
                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
            </div>

            <h3 class="text-2xl font-bold mb-4"
                x-text="selectedCategory === 'all' 
        ? 'Semua' 
        : selectedCategory.charAt(0).toUpperCase() + selectedCategory.slice(1)">
            </h3>
            <!-- Menu Items -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-4">

                <?php $__currentLoopData = $menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div x-show="selectedCategory === 'all' || selectedCategory === '<?php echo e(strtolower($item->category->name)); ?>'"
                        class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                        <?php if($item->image): ?>
                            <img src="<?php echo e(asset('storage/' . $item->image)); ?>" alt="<?php echo e($item->name); ?>"
                                class="w-full h-48 object-cover">
                        <?php else: ?>
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-400">No Image</span>
                            </div>
                        <?php endif; ?>
                        <div class="p-4">
                            <span class="text-xs text-primary font-semibold"><?php echo e($item->category->name); ?></span>
                            <h3 class="text-lg font-bold text-gray-800 mt-1"><?php echo e($item->name); ?></h3>
                            <p class="text-gray-600 text-sm mt-2 line-clamp-2"><?php echo e($item->description); ?></p>
                            <div class="flex justify-between items-center mt-4">
                                <span class="text-xl font-bold text-primary">Rp
                                    <?php echo e(number_format($item->price, 0, ',', '.')); ?></span>
                                <button type="button"
                                    @click="addToCart(<?php echo e($item->id); ?>, '<?php echo e($item->name); ?>', <?php echo e($item->price); ?>)"
                                    class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-light transition">
                                    + Add
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Go to Order Button -->
            <div class="mt-12 text-center pb-8">
                <a href="<?php echo e(route('order')); ?>"
                    class="inline-block bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-light transition">
                    Lihat Pesanan (<span x-text="cart.length"></span>)
                </a>
            </div>
        </div>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/kedai-caruban/resources/views/frontend/home.blade.php ENDPATH**/ ?>