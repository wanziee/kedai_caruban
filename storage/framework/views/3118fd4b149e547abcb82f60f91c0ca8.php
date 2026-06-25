<?php $__env->startSection('content'); ?>
    <div x-data="initCart()" x-init="console.log('Cart initialized:', cart);
    $watch('cart', value => localStorage.setItem('cart', JSON.stringify(value)))" class="min-h-screen">

        <script>
            function initCart() {
                return {
                    selectedCategory: 'all',
                    cart: JSON.parse(localStorage.getItem('cart') || '[]'),
                    bannerSlide: 0,
                    banners: [
                        { image: '/images/banners/banner1.jpg' },
                        { image: '/images/banners/banner1.jpg' },
                        { image: '/images/banners/banner1.jpg' },
                        { image: '/images/banners/banner1.jpg' }
                    ],
                    showModal: false,
                    selectedMenuItem: null,
                    quantity: 1,
                    notes: '',
                    showNotification: false,
                    notificationMessage: '',
                    nextSlide() {
                        this.bannerSlide = (this.bannerSlide + 1) % this.banners.length;
                    },
                    prevSlide() {
                        this.bannerSlide = (this.bannerSlide - 1 + this.banners.length) % this.banners.length;
                    },
                    openModal(id, name, price, image) {
                        this.selectedMenuItem = { id, name, price, image };
                        this.quantity = 1;
                        this.notes = '';
                        this.showModal = true;
                    },
                    closeModal() {
                        this.showModal = false;
                        this.selectedMenuItem = null;
                        this.quantity = 1;
                        this.notes = '';
                    },
                    increaseQuantity() {
                        this.quantity++;
                    },
                    decreaseQuantity() {
                        if (this.quantity > 1) {
                            this.quantity--;
                        }
                    },
                    showSuccessNotification(message) {
                        this.notificationMessage = message;
                        this.showNotification = true;
                        setTimeout(() => {
                            this.showNotification = false;
                        }, 2000);
                    },
                    confirmAddToCart() {
                        if (!this.selectedMenuItem) return;
                        
                        const { id, name, price, image } = this.selectedMenuItem;
                        const existingItem = this.cart.find(item => item.id === id);
                        
                        if (existingItem) {
                            existingItem.qty += this.quantity;
                            if (this.notes) {
                                existingItem.notes = this.notes;
                            }
                        } else {
                            this.cart.push({
                                id,
                                name,
                                price,
                                image,
                                qty: this.quantity,
                                notes: this.notes
                            });
                        }
                        
                        localStorage.setItem('cart', JSON.stringify(this.cart));
                        window.dispatchEvent(new Event('cart-updated'));
                        this.closeModal();
                        this.showSuccessNotification('Berhasil ditambahkan ke keranjang!');
                    }
                }
            }
        </script>

        <!-- Success Notification -->
        <div x-show="showNotification" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-4" class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2" style="display: none;">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span x-text="notificationMessage" class="font-semibold"></span>
        </div>

        <!-- Banner Carousel -->
        <div class="relative text-white mx-4 md:mx-0 md:mt-0 md:rounded-none mt-4 rounded-2xl overflow-hidden">
            <div x-init="setInterval(() => nextSlide(), 5000)">
                <template x-for="(banner, index) in banners" :key="index">
                    <div x-show="bannerSlide === index" class="h-[250px] md:h-[500px] transition-opacity duration-1000 flex items-center md:rounded-none rounded-2xl relative">
                        <!-- Banner Image -->
                        <img :src="banner.image" :alt="'Banner ' + (index + 1)" class="absolute inset-0 w-full h-full object-cover">
                        <!-- Overlay - Solid Green for Banner 1, Gradient for others -->
                        <div class="absolute inset-0 bg-green-900/50"></div>
                        <!-- Text Content -->
                        <div class="relative z-10 max-w-7xl mx-auto text-center px-4 text-white">
                            <h1 class="text-3xl md:text-5xl font-bold mb-4">Selamat Datang di Kedai Caruban</h1>
                            <p class="text-lg md:text-xl">Nikmati hidangan lezat kami dengan kualitas terbaik</p>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Banner Indicators -->

            <!-- Banner Indicators -->
            <div class="absolute top-0 left-0 right-0 flex gap-2 px-8 py-4 z-10">

                <template x-for="(banner, index) in banners" :key="index">

                    <div class="flex-1 h-[4px] bg-white/30 rounded-full overflow-hidden">

                        <div x-show="bannerSlide === index"
                            class="h-full bg-white rounded-full origin-left animate-[progress_5s_linear_forwards]">
                        </div>

                    </div>

                </template>

            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 mb-8 ">

            <!-- Categories -->

            <div class="max-w-7xl mx-auto py-6 mb-4">
                <h3 class="text-2xl font-bold mb-4">Kategori Produk</h3>

                <div
                    class="flex overflow-x-auto justify-around whitespace-nowrap gap-4 md:justify-center items-start scrollbar-hide pb-2 mb-5 px-1">

                    <!-- Semua -->
                    <button type="button" @click="selectedCategory = 'all'"
                        class="flex flex-col items-center gap-2 focus:outline-none group w-20 md:w-24 flex-shrink-0">

                        <div :class="selectedCategory === 'all'
                            ?
                            'scale-105 shadow-md' :
                            'border-2 border-transparent hover:scale-105'"
                            class="w-18 h-18 md:w-20 md:h-20 rounded-full overflow-hidden bg-gray-50 p-2 flex items-center justify-center transition-all duration-200">

                            <img src="<?php echo e(asset('images/category-all.png')); ?>" alt="Semua"
                                class="w-full h-full object-cover">
                        </div>

                        <span
                            :class="selectedCategory === 'all'
                                ?
                                'text-green-800 font-bold' :
                                'text-gray-700 font-medium group-hover:text-green-600'"
                            class="text-xs md:text-base transition-colors text-center truncate w-full">

                            Semua
                        </span>
                    </button>

                    <!-- Category Loop -->
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button type="button" @click="selectedCategory = '<?php echo e(strtolower($category->name)); ?>'"
                            class="flex flex-col items-center gap-2 focus:outline-none group w-20 md:w-24 flex-shrink-0">

                            <div :class="selectedCategory === '<?php echo e(strtolower($category->name)); ?>'
                                ?
                                'scale-105 shadow-md' :
                                'border-2 border-transparent hover:scale-105'"
                                class="w-18 h-18 md:w-20 md:h-20 rounded-full overflow-hidden bg-gray-50 p-2 flex items-center justify-center transition-all duration-200">

                                <img src="<?php echo e(asset('storage/' . $category->image)); ?>" alt="<?php echo e($category->name); ?>"
                                    class="w-full h-full object-cover">
                            </div>

                            <span
                                :class="selectedCategory === '<?php echo e(strtolower($category->name)); ?>'
                                    ?
                                    'text-green-800 font-bold' :
                                    'text-gray-700 font-medium group-hover:text-green-600'"
                                class="text-xs md:text-base transition-colors text-center truncate w-full">

                                <?php echo e($category->name); ?>

                            </span>
                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
                            class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition flex flex-col">

                            <?php if($item->image): ?>
                                <img src="<?php echo e(asset('storage/' . $item->image)); ?>" alt="<?php echo e($item->name); ?>"
                                    class="w-full h-48 object-cover">
                            <?php else: ?>
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400">No Image</span>
                                </div>
                            <?php endif; ?>

                            <div class="p-4 flex flex-col flex-1">

                                <span class="text-xs text-primary font-semibold">
                                    <?php echo e($item->category->name); ?>

                                </span>

                                <h3 class="text-lg font-bold text-gray-800 mt-1">
                                    <?php echo e($item->name); ?>

                                </h3>

                                <p class="text-gray-600 text-sm mt-2 line-clamp-2 min-h-[40px]">
                                    <?php echo e($item->description); ?>

                                </p>

                                <!-- Desktop -->
                                <div class="mt-auto pt-4 hidden md:block">
                                    <button type="button"
                                        @click="openModal(<?php echo e($item->id); ?>, '<?php echo e($item->name); ?>', <?php echo e($item->price); ?>, '<?php echo e(asset('storage/' . $item->image)); ?>')"
                                        class="w-full bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-light transition">
                                        + Add - Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?>

                                    </button>
                                </div>

                                <!-- Mobile -->
                                <div class="mt-auto pt-4 md:hidden">
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-bold text-primary">
                                            Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?>

                                        </span>
                                        <button type="button"
                                            @click="openModal(<?php echo e($item->id); ?>, '<?php echo e($item->name); ?>', <?php echo e($item->price); ?>, '<?php echo e(asset('storage/' . $item->image)); ?>')"
                                            class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-light transition">
                                            <svg width="15px" height="15px" viewBox="0 0 36 36"
                                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                aria-hidden="true" role="img" class="iconify iconify--twemoji"
                                                preserveAspectRatio="xMidYMid meet">
                                                <path fill="white"
                                                    d="M31 15H21V5a3 3 0 1 0-6 0v10H5a3 3 0 1 0 0 6h10v10a3 3 0 1 0 6 0V21h10a3 3 0 1 0 0-6z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>

                <!-- Go to Order Button -->
                
            </div>

        <!-- Modal Popup -->
        <div x-show="showModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">
            <!-- Backdrop -->
            <div x-show="showModal" @click="closeModal()" class="absolute inset-0 bg-black/50"></div>
            
            <!-- Modal Content -->
            <div x-show="showModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
                <!-- Close Button -->
                <button @click="closeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- Menu Item Info -->
                <div class="flex items-center gap-4 mb-6">
                    <img :src="selectedMenuItem?.image" :alt="selectedMenuItem?.name" class="w-20 h-20 object-cover rounded-lg">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800" x-text="selectedMenuItem?.name"></h3>
                        <p class="text-primary font-semibold">Rp <span x-text="selectedMenuItem?.price?.toLocaleString('id-ID')"></span></p>
                    </div>
                </div>

                <!-- Quantity Controls -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Jumlah</label>
                    <div class="flex items-center gap-4">
                        <button @click="decreaseQuantity()" class="w-10 h-10 bg-gray-200 rounded-full hover:bg-gray-300 flex items-center justify-center font-bold text-lg">-</button>
                        <span class="text-xl font-bold w-12 text-center" x-text="quantity"></span>
                        <button @click="increaseQuantity()" class="w-10 h-10 bg-gray-200 rounded-full hover:bg-gray-300 flex items-center justify-center font-bold text-lg">+</button>
                    </div>
                </div>

                <!-- Message/Notes Field -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Pesan (Opsional)</label>
                    <textarea x-model="notes" rows="3" placeholder="Contoh: Pedas, tanpa bawang, dll." class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent resize-none"></textarea>
                </div>

                <!-- Total Price -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total:</span>
                        <span class="text-xl font-bold text-primary">Rp <span x-text="(selectedMenuItem?.price * quantity)?.toLocaleString('id-ID')"></span></span>
                    </div>
                </div>

                <!-- Confirm Button -->
                <button @click="confirmAddToCart()" class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary-light transition">
                    Tambah ke Keranjang
                </button>
            </div>
        </div>
        <?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/kedai-caruban/resources/views/frontend/home.blade.php ENDPATH**/ ?>