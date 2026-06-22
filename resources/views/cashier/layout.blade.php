<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier - Kedai Caruban</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-primary text-white sticky top-0 h-screen flex flex-col">
            <div class="p-6 border-b border-primary-light">
                <h1 class="text-2xl font-bold">Cashier</h1>
                <p class="text-green-200 text-sm mt-1">Kedai Caruban</p>
            </div>
            <nav class="mt-6 flex-1 overflow-hidden">
                <a href="{{ route('cashier.dashboard') }}" class="block px-6 py-3 hover:bg-primary-light transition {{ request()->routeIs('cashier.dashboard') ? 'bg-primary-light' : '' }}">
                    📊 Beranda
                </a>
                <a href="{{ route('cashier.orders') }}" class="block px-6 py-3 hover:bg-primary-light transition {{ request()->routeIs('cashier.orders*') ? 'bg-primary-light' : '' }}">
                    📦 Pesanan
                </a>
                <a href="{{ route('cashier.menu.index') }}" class="block px-6 py-3 hover:bg-primary-light transition {{ request()->routeIs('cashier.menu*') ? 'bg-primary-light' : '' }}">
                    🍽️ Menu
                </a>
                <a href="{{ route('cashier.reports.sales') }}" class="block px-6 py-3 hover:bg-primary-light transition {{ request()->routeIs('cashier.reports*') ? 'bg-primary-light' : '' }}">
                    📈 Laporan Penjualan
                </a>
                <hr class="my-4 border-primary-light">
                <a href="{{ route('home') }}" class="block px-6 py-3 hover:bg-primary-light transition">
                    👁️ Lihat Website
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Navbar -->
            <div class="bg-white shadow">
                <div class="px-8 py-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <p class="text-gray-700 font-semibold">{{ Auth::user()->name }}</p>
                            <p class="text-sm text-gray-500 capitalize">{{ Auth::user()->role }}</p>
                        </div>
                        <form method="POST" action="{{ route('auth.logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <main class="flex-1 p-8">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 flex justify-between items-center">
                        <span>{{ session('success') }}</span>
                        <button type="button" onclick="this.parentElement.style.display='none'" class="text-green-700 hover:text-green-800">
                            ✕
                        </button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
