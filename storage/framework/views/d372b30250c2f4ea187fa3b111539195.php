<?php $__env->startSection('content'); ?>
<div>
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Kategori Menu</h1>
        <button onclick="toggleCreateForm()" class="bg-primary hover:bg-primary-light text-white px-6 py-2 rounded-lg transition flex items-center gap-2 shadow-md">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Kategori Baru
        </button>
    </div>

    <?php if($errors->any()): ?>
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <ul class="text-red-700">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 text-green-700">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    
    <!-- Form Tambah Kategori -->
    <div id="createForm" class="bg-white rounded-xl shadow-md p-6 mb-6 hidden">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Tambah Kategori Baru</h2>
        <form action="<?php echo e(route('admin.categories.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori *</label>
                    <input 
                        type="text" 
                        name="name" 
                        required
                        value="<?php echo e(old('name')); ?>"
                        placeholder="Masukkan nama kategori"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea 
                        name="description" 
                        rows="3"
                        placeholder="Masukkan deskripsi kategori (opsional)"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                    ><?php echo e(old('description')); ?></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Kategori</label>
                    <div class="flex items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-primary/30 rounded-lg cursor-pointer bg-primary/5 hover:bg-primary/10 transition">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 text-primary mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-sm text-primary"><span class="font-semibold">Klik untuk upload</span> atau drag gambar</p>
                                <p class="text-xs text-primary/70">PNG, JPG, GIF (Max. 2MB)</p>
                            </div>
                            <input type="file" name="image" class="hidden" accept="image/*" onchange="previewImage(this)">
                        </label>
                    </div>
                    <div id="imagePreview" class="mt-2"></div>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-primary hover:bg-primary-light text-white px-6 py-2 rounded-lg transition font-medium">
                        Simpan Kategori
                    </button>
                    <button type="button" onclick="toggleCreateForm()" class="flex-1 bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition font-medium">
                        Batal
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Daftar Kategori -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <?php if($categories->count() > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-gray-50 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                        <!-- Gambar Kategori -->
                        <div class="w-full h-48 bg-gray-200 overflow-hidden">
                            <?php if($category->image): ?>
                                <img src="<?php echo e(asset('storage/' . $category->image)); ?>" alt="<?php echo e($category->name); ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary/10 to-primary/20">
                                    <svg class="w-16 h-16 text-primary/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Informasi Kategori -->
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2"><?php echo e($category->name); ?></h3>
                            
                            <?php if($category->description): ?>
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2"><?php echo e($category->description); ?></p>
                            <?php endif; ?>

                            <div class="text-xs text-gray-500 mb-4">
                                <?php echo e($category->menuItems()->count()); ?> item menu
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="flex gap-2">
                                <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" class="flex-1 bg-primary text-white px-3 py-2 rounded-lg hover:bg-primary-light transition text-sm font-medium flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit
                                </a>
                                <form action="<?php echo e(route('admin.categories.destroy', $category)); ?>" method="POST" class="flex-1">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="w-full bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition text-sm font-medium flex items-center justify-center gap-2" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <p class="text-gray-500 text-lg">Belum ada kategori menu</p>
                <p class="text-gray-400 text-sm mt-1">Mulai dengan membuat kategori baru</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function toggleCreateForm() {
        const form = document.getElementById('createForm');
        form.classList.toggle('hidden');
    }

    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-full h-32 object-cover rounded-lg';
                preview.appendChild(img);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/kedai-caruban-2/resources/views/admin/categories/index.blade.php ENDPATH**/ ?>