<?php $__env->startSection('content'); ?>
    <div x-data="initCart()" class="min-h-screen">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <!-- Search Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Cari Menu</h1>
                
                <!-- Search Form -->
                <form method="GET" action="<?php echo e(route('search')); ?>" class="mb-8">
                    <div class="flex gap-2">
                        <input type="text" name="q" value="<?php echo e($query); ?>" 
                            placeholder="Cari nama menu atau deskripsi..." 
                            class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-primary transition">
                        <button type="submit" class="bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary-light transition font-semibold">
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            <!-- Search Results -->
            <?php if($query): ?>
                <div class="mb-6">
                    <p class="text-gray-600">
                        Hasil pencarian untuk "<strong><?php echo e($query); ?></strong>": 
                        <strong><?php echo e(count($menuItems)); ?></strong> menu ditemukan
                    </p>
                </div>

                <?php if(count($menuItems) > 0): ?>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <?php $__currentLoopData = $menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
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
                <?php else: ?>
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <p class="text-gray-500 text-lg">Menu tidak ditemukan</p>
                        <p class="text-gray-400 text-sm mt-2">Coba dengan kata kunci lain</p>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <p class="text-gray-500 text-lg">Mulai pencarian</p>
                    <p class="text-gray-400 text-sm mt-2">Ketik nama menu atau deskripsi yang ingin dicari</p>
                </div>
            <?php endif; ?>

            <!-- Go to Order Button -->
            <div class="mt-12 text-center pb-24">
                <a href="<?php echo e(route('order')); ?>"
                    class="inline-block bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-light transition">
                    Lihat Pesanan (<span x-text="cart.length"></span>)
                </a>
            </div>
        </div>
    </div>

    <script>
        function initCart() {
            return {
                cart: JSON.parse(localStorage.getItem('cart') || '[]'),
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/kedai-caruban/resources/views/frontend/search.blade.php ENDPATH**/ ?>