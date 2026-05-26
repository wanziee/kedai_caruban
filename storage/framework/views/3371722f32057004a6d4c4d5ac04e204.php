<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Kedai Caruban</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md">
            <!-- Logo Section -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-6">
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-primary mb-2">Kedai Caruban</h1>
                    <p class="text-gray-600">Admin Panel</p>
                </div>

                <!-- Login Form -->
                <form method="POST" action="<?php echo e(route('auth.login')); ?>">
                    <?php echo csrf_field(); ?>

                    <!-- Email Field -->
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                        <input 
                            type="email" 
                            id="email"
                            name="email" 
                            value="<?php echo e(old('email')); ?>"
                            required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="admin@kedaicabruban.com"
                        >
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Password Field -->
                    <div class="mb-6">
                        <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
                        <input 
                            type="password" 
                            id="password"
                            name="password" 
                            required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="••••••••"
                        >
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full bg-primary text-white py-2 rounded-lg font-semibold hover:bg-primary-light transition"
                    >
                        Login
                    </button>
                </form>
            </div>

            <!-- Demo Credentials -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-gray-700 font-semibold mb-3">Demo Credentials:</h3>
                <div class="space-y-2 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span><strong>Owner:</strong></span>
                        <span>owner@kedaicabruban.com</span>
                    </div>
                    <div class="flex justify-between">
                        <span><strong>Admin:</strong></span>
                        <span>admin@kedaicabruban.com</span>
                    </div>
                    <div class="flex justify-between">
                        <span><strong>Cashier:</strong></span>
                        <span>cashier@kedaicabruban.com</span>
                    </div>
                    <div class="flex justify-between border-t pt-2 mt-2">
                        <span><strong>Password:</strong></span>
                        <span>password123</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH /Applications/MAMP/htdocs/kedai-caruban/resources/views/auth/login.blade.php ENDPATH**/ ?>