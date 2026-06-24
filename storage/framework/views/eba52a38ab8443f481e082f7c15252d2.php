<?php $__env->startSection('content'); ?>
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header dengan Back Button -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <a href="<?php echo e(route('admin.categories')); ?>" class="inline-flex items-center gap-2 text-primary hover:text-primary-light font-medium mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali
                </a>
                <h1 class="text-4xl font-bold text-gray-900">Edit Kategori</h1>
                <p class="text-gray-600 mt-2">Perbarui informasi dan gambar kategori menu Anda</p>
            </div>
            <div class="text-right hidden sm:block">
                <div class="bg-primary/10 rounded-lg p-4 border border-primary/20">
                    <p class="text-sm text-gray-600">Total Menu Items</p>
                    <p class="text-3xl font-bold text-primary"><?php echo e($category->menuItems()->count()); ?></p>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        <?php if($errors->any()): ?>
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-red-800 font-semibold mb-2">Ada kesalahan dalam form:</h3>
                        <ul class="text-red-700 text-sm space-y-1">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>• <?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Main Form Container -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <!-- Form Content -->
            <form action="<?php echo e(route('admin.categories.update', $category)); ?>" method="POST" enctype="multipart/form-data" class="p-8 lg:p-10">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <!-- Section 1: Informasi Dasar -->
                <div class="mb-10">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        Informasi Dasar
                    </h2>

                    <div class="space-y-6">
                        <!-- Nama Kategori -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                            <input 
                                type="text" 
                                id="name"
                                name="name" 
                                required
                                value="<?php echo e(old('name', $category->name)); ?>"
                                placeholder="Contoh: Makanan Utama, Minuman, Dessert"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition bg-gray-50 hover:bg-white"
                            >
                            <p class="text-xs text-gray-500 mt-1">Nama kategori akan ditampilkan di menu utama</p>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi (Opsional)</label>
                            <textarea 
                                id="description"
                                name="description" 
                                rows="3"
                                placeholder="Jelaskan jenis-jenis makanan atau minuman dalam kategori ini..."
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition bg-gray-50 hover:bg-white"
                            ><?php echo e(old('description', $category->description)); ?></textarea>
                            <p class="text-xs text-gray-500 mt-1">Deskripsi membantu pelanggan memahami kategori dengan lebih baik</p>
                        </div>
                    </div>
                </div>

                <hr class="my-8 border-gray-200">

                <!-- Section 2: Manajemen Gambar -->
                <div class="mb-10">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        Manajemen Gambar Kategori
                    </h2>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Kolom Kiri: Gambar Saat Ini -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-700 mb-4">Gambar Saat Ini</h3>
                            <?php if($category->image): ?>
                                <div class="relative bg-gray-100 rounded-xl overflow-hidden border-2 border-gray-200 shadow-md">
                                    <img 
                                        src="<?php echo e(asset('storage/' . $category->image)); ?>" 
                                        alt="<?php echo e($category->name); ?>" 
                                        class="w-full h-64 object-cover"
                                    >
                                    <div class="absolute top-3 right-3 bg-primary text-white text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        Aktif
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="bg-gray-100 rounded-xl h-64 flex items-center justify-center border-2 border-dashed border-gray-300">
                                    <div class="text-center">
                                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-gray-500 text-sm">Belum ada gambar</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Kolom Kanan: Upload Area -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-700 mb-4">Upload Gambar Baru</h3>
                            <label class="flex flex-col items-center justify-center w-full h-64 border-2 border-dashed border-primary/30 rounded-xl cursor-pointer bg-primary/5 hover:bg-primary/10 transition group">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6 w-full h-full">
                                    <svg class="w-12 h-12 text-primary mb-3 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <p class="text-sm text-primary font-medium">Drag & drop gambar di sini</p>
                                    <p class="text-xs text-primary/70 mt-1">atau klik untuk memilih</p>
                                    <p class="text-xs text-primary/60 mt-3">PNG, JPG, GIF (Maks. 2MB)</p>
                                </div>
                                <input type="file" name="image" class="hidden" accept="image/*" onchange="previewImage(this)">
                            </label>

                            <!-- Preview Upload Baru -->
                            <div id="imagePreview" class="mt-4"></div>
                        </div>
                    </div>

                    <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex gap-3">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd" />
                            </svg>
                            <p class="text-sm text-blue-800">
                                <span class="font-semibold">Tip:</span> Gunakan gambar berukuran persegi untuk hasil terbaik. Gambar baru akan menggantikan gambar lama.
                            </p>
                        </div>
                    </div>
                </div>

                <hr class="my-8 border-gray-200">

                <!-- Section 3: Kategori Info -->
                <div class="mb-10">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        Informasi Kategori
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gradient-to-br from-primary/10 to-primary/5 rounded-lg p-6 border border-primary/20">
                            <p class="text-sm text-gray-600 font-medium">Total Item Menu</p>
                            <p class="text-4xl font-bold text-primary mt-2"><?php echo e($category->menuItems()->count()); ?></p>
                            <p class="text-xs text-gray-600 mt-2">item tersedia dalam kategori ini</p>
                        </div>
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-6 border border-gray-200">
                            <p class="text-sm text-gray-600 font-medium">Dibuat pada</p>
                            <p class="text-2xl font-bold text-gray-800 mt-2"><?php echo e($category->created_at->format('d M Y')); ?></p>
                            <p class="text-xs text-gray-600 mt-2"><?php echo e($category->created_at->format('H:i')); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 pt-8 border-t border-gray-200">
                    <button 
                        type="submit" 
                        class="flex-1 bg-gradient-to-r from-primary to-primary-light hover:from-primary-dark hover:to-primary text-white px-6 py-3 rounded-lg transition font-semibold flex items-center justify-center gap-2 shadow-md hover:shadow-lg"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Perubahan
                    </button>
                    <a 
                        href="<?php echo e(route('admin.categories')); ?>" 
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-3 rounded-lg transition font-semibold flex items-center justify-center gap-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const container = document.createElement('div');
                container.className = 'relative bg-primary/5 rounded-xl overflow-hidden border-2 border-primary/30 shadow-md';
                
                const label = document.createElement('p');
                label.className = 'text-sm text-primary font-semibold px-4 pt-4';
                label.textContent = '✓ Preview Gambar Baru';
                
                const imgWrapper = document.createElement('div');
                imgWrapper.className = 'mt-2';
                
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-full h-64 object-cover';
                
                imgWrapper.appendChild(img);
                container.appendChild(label);
                container.appendChild(imgWrapper);
                preview.appendChild(container);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/kedai-caruban/resources/views/admin/categories/edit.blade.php ENDPATH**/ ?>