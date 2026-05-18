@extends('frontend.layout')

@section('content')
<div x-data="initCart()" x-init="console.log('Cart initialized:', cart); $watch('cart', value => localStorage.setItem('cart', JSON.stringify(value)))" class="min-h-screen">
    
    <script>
        function initCart() {
            return {
                selectedCategory: 'all',
                cart: JSON.parse(localStorage.getItem('cart') || '[]'),
                bannerSlide: 0,
                banners: [
                    {
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
                    }
                ],
                nextSlide() {
                    this.bannerSlide = (this.bannerSlide + 1) % this.banners.length;
                },
                prevSlide() {
                    this.bannerSlide = (this.bannerSlide - 1 + this.banners.length) % this.banners.length;
                },
                addToCart(id, name, price) {
                    console.log('Adding to cart:', { id, name, price });
                    const existingItem = this.cart.find(item => item.id === id);
                    if (existingItem) {
                        existingItem.qty++;
                    } else {
                        this.cart.push({ id, name, price, qty: 1, notes: '' });
                    }
                    localStorage.setItem('cart', JSON.stringify(this.cart));
                    console.log('Cart after add:', this.cart);
                    alert('Item added to cart!');
                }
            }
        }
    </script>
    
    <!-- Banner Carousel -->
    <div x-init="setInterval(() => nextSlide(), 5000)" class="relative text-white overflow-hidden">
       <template x-for="(banner, index) in banners" :key="index">
    <div 
        x-show="bannerSlide === index"
        :class="`bg-gradient-to-r ${banner.gradient}`"
        class="h-[300px] md:h-[500px] px-4 transition-opacity duration-1000 flex items-center"
    >
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4" x-text="banner.title"></h1>
            <p class="text-lg md:text-xl" x-text="banner.subtitle"></p>
        </div>
    </div>
</template>
        
        <!-- Banner Controls -->
        <div class="absolute bottom-4 left-0 right-0 flex justify-center items-center gap-4 z-10">
            <button 
                type="button"
                @click="prevSlide()"
                class="bg-white/30 hover:bg-white/50 text-white p-2 rounded-full transition"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            
            <div class="flex gap-2">
                <template x-for="(banner, index) in banners" :key="index">
                    <button 
                        type="button"
                        @click="bannerSlide = index"
                        :class="bannerSlide === index ? 'bg-white' : 'bg-white/50'"
                        class="w-3 h-3 rounded-full transition hover:bg-white"
                    ></button>
                </template>
            </div>
            
            <button 
                type="button"
                @click="nextSlide()"
                class="bg-white/30 hover:bg-white/50 text-white p-2 rounded-full transition"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Categories -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex flex-wrap gap-2 justify-center mb-8">
            <button 
                type="button"
                @click="selectedCategory = 'all'"
                :class="selectedCategory === 'all' ? 'bg-primary text-white' : 'bg-white text-gray-700 hover:bg-green-50'"
                class="px-6 py-2 rounded-full font-medium transition"
            >
                Semua
            </button>
            @foreach($categories as $category)
                <button 
                    type="button"
                    @click="selectedCategory = '{{ strtolower($category->name) }}'"
                    :class="selectedCategory === '{{ strtolower($category->name) }}' ? 'bg-primary text-white' : 'bg-white text-gray-700 hover:bg-green-50'"
                    class="px-6 py-2 rounded-full font-medium transition"
                >
                    {{ $category->name }}
                </button>
            @endforeach
        </div>

        <!-- Menu Items -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-6">
            @foreach($menuItems as $item)
                <div 
                    x-show="selectedCategory === 'all' || selectedCategory === '{{ strtolower($item->category->name) }}'"
                    class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition"
                >
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-48 object-cover">
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
                            <span class="text-xl font-bold text-primary">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                            <button 
                                type="button"
                                @click="addToCart({{ $item->id }}, '{{ $item->name }}', {{ $item->price }})"
                                class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-light transition"
                            >
                                + Add
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Go to Order Button -->
        <div class="mt-12 text-center pb-8">
            <a href="{{ route('order') }}" class="inline-block bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-light transition">
                Lihat Pesanan (<span x-text="cart.length"></span>)
            </a>
        </div>
    </div>
@endsection
