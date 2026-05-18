<?php $__env->startSection('content'); ?>
<div x-data="initOrder()" x-init="$watch('cart', value => localStorage.setItem('cart', JSON.stringify(value)))" class="min-h-screen">

    <script>
        function initOrder() {
            return {
                cart: JSON.parse(localStorage.getItem('cart') || '[]'),
                tableNumber: '',
                customerName: '',
                showSuccess: false,
                orderCode: '',
                totalPrice: 0,
                async submitOrder() {
                    console.log('Submitting order with cart:', this.cart);
                    
                    if (this.cart.length === 0) {
                        alert('Keranjang kosong!');
                        return;
                    }

                    const items = this.cart.map(item => ({
                        menu_item_id: item.id,
                        qty: item.qty,
                        notes: item.notes || ''
                    }));

                    try {
                        const response = await fetch('<?php echo e(route('orders.store')); ?>', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                table_number: this.tableNumber,
                                customer_name: this.customerName,
                                items: items
                            })
                        });
                        const data = await response.json();
                        console.log('Order response:', data);
                        
                        if (data.success) {
                            this.showSuccess = true;
                            this.orderCode = data.order_code;
                            this.totalPrice = data.total_price;
                            this.cart = [];
                            localStorage.removeItem('cart');
                            setTimeout(() => {
                                window.location.href = '<?php echo e(route('home')); ?>';
                            }, 3000);
                        } else {
                            alert('Gagal membuat pesanan: ' + (data.message || 'Unknown error'));
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat membuat pesanan: ' + error.message);
                    }
                }
            }
        }
    </script>
  

    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Success Message -->
        <div x-show="showSuccess" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <strong class="font-bold">Pesanan Berhasil!</strong>
            <span class="block sm:inline">Kode pesanan Anda: <span x-text="orderCode"></span></span>
            <span class="block sm:inline mt-2">Total: Rp <span x-text="totalPrice.toLocaleString('id-ID')"></span></span>
        </div>

        <!-- Cart Items -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Item Pesanan</h2>
            
            <div x-show="cart.length === 0" class="text-center py-8 text-gray-500">
                Keranjang Anda kosong. <a href="<?php echo e(route('home')); ?>" class="text-primary hover:underline">Pesan menu sekarang</a>
            </div>

            <div x-show="cart.length > 0">
                <template x-for="(item, index) in cart" :key="item.id">
                    <div class="flex items-center justify-between py-4 border-b">
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-800" x-text="item.name"></h3>
                            <p class="text-primary">Rp <span x-text="item.price.toLocaleString('id-ID')"></span></p>
                            <input 
                                type="text" 
                                x-model="item.notes" 
                                placeholder="Catatan (opsional)"
                                class="mt-2 w-full px-3 py-2 border rounded-lg text-sm"
                            >
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center space-x-2">
                                <button 
                                    type="button"
                                    @click="item.qty > 1 ? item.qty-- : cart.splice(index, 1)"
                                    class="w-8 h-8 bg-gray-200 rounded-full hover:bg-gray-300"
                                >-</button>
                                <span class="font-semibold" x-text="item.qty"></span>
                                <button 
                                    type="button"
                                    @click="item.qty++"
                                    class="w-8 h-8 bg-gray-200 rounded-full hover:bg-gray-300"
                                >+</button>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-800">Rp <span x-text="(item.price * item.qty).toLocaleString('id-ID')"></span></p>
                            </div>
                        </div>
                    </div>
                </template>

                <div class="mt-6 pt-4 border-t">
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-bold text-gray-800">Total:</span>
                        <span class="text-2xl font-bold text-primary">Rp <span x-text="cart.reduce((sum, item) => sum + (item.price * item.qty), 0).toLocaleString('id-ID')"></span></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Form -->
        <div x-show="cart.length > 0" class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Informasi Pesanan</h2>
            <form @submit.prevent="submitOrder()">
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Nomor Meja *</label>
                        <input 
                            type="number" 
                            x-model="tableNumber" 
                            required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="Masukkan nomor meja"
                        >
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Nama Pelanggan (Opsional)</label>
                        <input 
                            type="text" 
                            x-model="customerName"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="Masukkan nama Anda"
                        >
                    </div>
                </div>

                <button 
                    type="submit"
                    class="w-full mt-6 bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary-light transition"
                >
                    Buat Pesanan
                </button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/kedai-caruban-2/resources/views/frontend/order.blade.php ENDPATH**/ ?>