@extends('frontend.layout')

@section('content')
    <div x-data="initCart()" class="min-h-screen">
        <!-- Success Notification -->
        <div x-show="showNotification" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-4" class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2" style="display: none;">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span x-text="notificationMessage" class="font-semibold"></span>
        </div>

        <div class="max-w-7xl mx-auto px-4 py-8">
            <!-- Search Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Cari Menu</h1>
                
                <!-- Search Form -->
                <form method="GET" action="{{ route('search') }}" class="mb-8">
                    <div class="flex gap-2">
                        <input type="text" name="q" value="{{ $query }}" 
                            placeholder="Cari nama menu atau deskripsi..." 
                            class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-full focus:outline-none focus:border-primary transition">
                        {{-- <button type="submit" class="bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary-light transition font-semibold">
                            Cari
                        </button> --}}
                    </div>
                </form>
            </div>

            <!-- Search Results -->
            @if ($query)
                <div class="mb-6">
                    <p class="text-gray-600">
                        Hasil pencarian untuk "<strong>{{ $query }}</strong>": 
                        <strong>{{ count($menuItems) }}</strong> menu ditemukan
                    </p>
                </div>

                @if (count($menuItems) > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach ($menuItems as $item)
                            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                                @if ($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                                        class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-400">No Image</span>
                                    </div>
                                @endif
                                <div class="p-4">
                                    <span class="text-xs text-primary font-semibold">{{ $item->category->name }}</span>
                                    <h3 class="text-lg font-bold text-gray-800 mt-1">{{ $item->name }}</h3>
                                    <p class="text-gray-600 text-sm mt-2 line-clamp-2">{{ $item->description }}</p>
                                    <div class="flex justify-between items-center mt-4">
                                        <span class="text-xl font-bold text-primary">Rp
                                            {{ number_format($item->price, 0, ',', '.') }}</span>
                                        <button type="button"
                                            @click="addToCart({{ $item->id }}, '{{ $item->name }}', {{ $item->price }})"
                                            class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-light transition">
                                            + Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <p class="text-gray-500 text-lg">Menu tidak ditemukan</p>
                        <p class="text-gray-400 text-sm mt-2">Coba dengan kata kunci lain</p>
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <p class="text-gray-500 text-lg">Mulai pencarian</p>
                    <p class="text-gray-400 text-sm mt-2">Ketik nama menu atau deskripsi yang ingin dicari</p>
                </div>
            @endif

        </div>
    </div>

    <script>
        function initCart() {
            return {
                cart: JSON.parse(localStorage.getItem('cart') || '[]'),
                showNotification: false,
                notificationMessage: '',
                showSuccessNotification(message) {
                    this.notificationMessage = message;
                    this.showNotification = true;
                    setTimeout(() => {
                        this.showNotification = false;
                    }, 2000);
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
                    window.dispatchEvent(new Event('cart-updated'));
                    this.showSuccessNotification('Berhasil ditambahkan ke keranjang!');
                    console.log('Cart after add:', this.cart);
                }
            }
        }
    </script>
@endsection
