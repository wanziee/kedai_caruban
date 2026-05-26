<?php $__env->startSection('content'); ?>
<div>
    <div class="mb-8">
        <a href="<?php echo e(route('admin.menu.index')); ?>" class="text-amber-600 hover:text-amber-800">← Kembali ke Menu</a>
    </div>

    <h1 class="text-3xl font-bold text-gray-800 mb-8">Edit Menu</h1>

    <div class="bg-white rounded-xl shadow-md p-6">
        <form action="<?php echo e(route('admin.menu.update', $menuItem)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Kategori *</label>
                    <select name="category_id" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        <option value="">Pilih Kategori</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" <?php echo e($menuItem->category_id == $category->id ? 'selected' : ''); ?>><?php echo e($category->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Nama Menu *</label>
                    <input type="text" name="name" required value="<?php echo e($menuItem->name); ?>" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent" placeholder="Masukkan nama menu">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-2">Deskripsi</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent" placeholder="Masukkan deskripsi menu"><?php echo e($menuItem->description); ?></textarea>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Harga *</label>
                    <input type="number" name="price" required step="0.01" min="0" value="<?php echo e($menuItem->price); ?>" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent" placeholder="Masukkan harga">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Gambar</label>
                    <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    <?php if($menuItem->image): ?>
                        <p class="mt-2 text-sm text-gray-500">Gambar saat ini: <img src="<?php echo e(asset('storage/' . $menuItem->image)); ?>" alt="<?php echo e($menuItem->name); ?>" class="w-20 h-20 object-cover rounded mt-1"></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Status</label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_available" value="1" <?php echo e($menuItem->is_available ? 'checked' : ''); ?> class="mr-2">
                        <span>Tersedia</span>
                    </label>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-amber-600 text-white px-6 py-2 rounded-lg hover:bg-amber-700 transition">
                    Update Menu
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/kedai-caruban/resources/views/admin/menu/edit.blade.php ENDPATH**/ ?>