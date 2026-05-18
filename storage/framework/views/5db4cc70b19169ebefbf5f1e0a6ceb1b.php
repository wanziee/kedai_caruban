<?php $__env->startSection('content'); ?>
<div>
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Kategori Menu</h1>
    
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <form action="<?php echo e(route('admin.categories.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="flex gap-4">
                <input 
                    type="text" 
                    name="name" 
                    required
                    placeholder="Nama Kategori"
                    class="flex-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                >
                <button type="submit" class="bg-amber-600 text-white px-6 py-2 rounded-lg hover:bg-amber-700 transition">
                    Tambah Kategori
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <span class="font-semibold text-gray-800"><?php echo e($category->name); ?></span>
                    <form action="<?php echo e(route('admin.categories.destroy', $category)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php if($categories->count() === 0): ?>
            <p class="text-gray-500 text-center py-8">Belum ada kategori</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/wanzie/Downloads/kedai-caruban-2/resources/views/admin/categories/index.blade.php ENDPATH**/ ?>