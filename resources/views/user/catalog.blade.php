<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Katalog Produk - cloudywear</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .product-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .product-image {
            height: 300px;
            object-fit: cover;
        }
    </style>
</head>

<body class="bg-white">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="container mx-auto px-8 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <a href="{{ route('user.catalog') }}" class="flex items-center">
                    <img src="{{ asset('images/cloudywear-logo1.png') }}" 
                        class="h-10 w-auto">
                </a> 

                <!-- Navigation -->
                <nav class="flex space-x-6">
                    <!-- Semua -->
                    <a href="{{ route('user.catalog') }}"
                    class="{{ request('category') ? 'text-gray-700' : 'font-bold text-[#0E5DA5]' }}">
                        Semua
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('user.catalog', ['category' => $category->slug]) }}"
                        class="{{ request('category') == $category->slug ? 'font-bold text-[#0E5DA5]' : 'text-gray-700' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </nav>
                
            <div class="flex items-center space-x-4">
                {{-- Search --}}
                <div class="relative block">
                    <input 
                        type="text" 
                        placeholder="Yuk, cari fashion kamu..." 
                        class="border border-gray-300 rounded-full px-4 py-2 pr-10 w-64 focus:outline-none focus:ring-2 focus:ring-[#0E5DA5]"
                        id="searchInput"
                        value="{{ request('search') }}">
                    <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>

                {{-- ✅ AUTH BUTTONS MODERN --}}
                @guest
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}"
                            class="text-sm font-semibold text-[#0E5DA5] hover:text-[#094879] transition">
                            Login
                        </a>

                        <a href="{{ route('register') }}"
                            class="text-sm font-semibold bg-[#0E5DA5] text-white px-4 py-2 rounded-full
                                shadow hover:bg-[#094879] transition">
                            Register
                        </a>
                    </div>
                @endguest

                @auth
                    <div class="relative group">
                        <button class="flex items-center gap-2 bg-white border border-gray-200 px-4 py-2 rounded-full shadow-sm hover:shadow-md transition">
                            <div class="w-7 h-7 bg-[#0E5DA5] text-white flex items-center justify-center rounded-full text-xs font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="text-sm font-semibold text-gray-700">
                                {{ Auth::user()->name }}
                            </span>
                            <i class="bi bi-caret-down-fill text-xs text-gray-500"></i>
                        </button>

                        {{-- Dropdown --}}
                        <div class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition">
                            <a href="/activity-log" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Manage Profile
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 md:px-8">

        <!-- HERO BANNER -->
        <section class="mt-10">
            <div class="relative w-full h-[340px] md:h-[450px] lg:h-[520px] rounded-2xl overflow-hidden shadow-lg">

                <!-- IMAGE (AUTO-SLIDER) -->
                <img id="heroImage"
                    src="{{ asset('images/banner1.jpg') }}"
                    class="w-full h-full object-cover transition-all duration-700">

                <!-- BLACK OVERLAY -->
                <div class="absolute inset-0 bg-black/30"></div>

                <!-- TEXT -->
                <div class="absolute left-1/2 -translate-x-1/2 top-[70%] -translate-y-1/2 text-center text-white w-full px-4">
                    <h1 class="text-3xl md:text-5xl font-light mb-1">Temukan Fashion Anda!</h1>
                    <p class="text-lg md:text-2xl mb-3">Koleksi 2025</p>

                    <button id="scrollToProducts" class="bg-[#0E5DA5] text-white px-6 py-3 rounded-md font-medium hover:bg-gray-200 transition">
                        Belanja Sekarang
                    </button>
                </div>
            </div>
        </section>

        <script>
            // HERO BANNER AUTO SLIDER
            const heroImages = [
                "{{ asset('images/banner1.jpg') }}",
                "{{ asset('images/banner2.jpg') }}",
                "{{ asset('images/banner3.jpg') }}",
            ];

            let currentIndex = 0;
            const heroEl = document.getElementById('heroImage');

            setInterval(() => {
                currentIndex = (currentIndex + 1) % heroImages.length;
                heroEl.src = heroImages[currentIndex];
            }, 4000);
        </script>


        <!-- CATEGORY ICON LIST -->
        <section class="container mx-auto px-6 mt-12">
            <h2 class="text-xl font-semibold mb-6 text-center">Kategori</h2>
                <div class="grid grid-cols-4 md:grid-cols-8 gap-6 text-center">
                <div><img src="/images/cat3.png" class="mx-auto h-16"><p class="mt-2 text-sm">Topi</p></div>
                <div><img src="/images/cat8.png" class="mx-auto h-16"><p class="mt-2 text-sm">Kemeja</p></div>
                <div><img src="/images/cat5.png" class="mx-auto h-16"><p class="mt-2 text-sm">Kaos</p></div>
                <div><img src="/images/cat6.png" class="mx-auto h-16"><p class="mt-2 text-sm">Jaket</p></div>
                <div><img src="/images/cat4.png" class="mx-auto h-16"><p class="mt-2 text-sm">Celana Panjang</p></div>
                <div><img src="/images/cat7.png" class="mx-auto h-16"><p class="mt-2 text-sm">Celana Pendek</p></div>
                <div><img src="/images/cat1.png" class="mx-auto h-16"><p class="mt-2 text-sm">Sepatu</p></div>
                <div><img src="/images/cat2.png" class="mx-auto h-16"><p class="mt-2 text-sm">Ikat Pinggang</p></div>
            </div>
        </section>

        <!-- PRODUCT GRID -->
        <section id="productsSection" class="mt-12 mb-10">
            <h2 class="text-xl font-semibold mb-6 text-center">Produk</h2>
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($products as $product)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden product-card">

                            <!-- Product Image -->
                            <div class="relative">
                            <a href="{{ route('user.product.detail', $product->id) }}">
                                @if($product->image)
                                    @if(str_starts_with($product->image, 'http'))
                                        <img src="{{ $product->image }}" class="w-full h-[280px] object-cover">
                                    @else
                                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-[280px] object-cover">
                                    @endif
                                @else
                                    <img src="https://via.placeholder.com/400x300?text=No+Image" class="w-full h-[280px] object-cover">
                                @endif
                            </a>

                                @if($product->stock <= 10 && $product->stock > 0)
                                    <span class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded text-xs">
                                        Stok Terbatas
                                    </span>
                                @endif
                            </div>

                            <!-- Info -->
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-1 line-clamp-2">{{ $product->name }}</h3>

                                @if($product->category)
                                    <p class="text-sm text-gray-500 mb-3">{{ $product->category->name }}</p>
                                @endif

                                <p class="text-xl font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                                <div class="mt-4 flex items-center justify-between">
                                    <span class="text-sm text-gray-600">
                                        Stok:
                                        <span class="font-semibold {{ $product->stock > 10 ? 'text-green-600' : ($product->stock > 0 ? 'text-yellow-600' : 'text-red-600') }}">
                                            {{ $product->stock > 0 ? $product->stock : 'Habis' }}
                                        </span>
                                    </span>

                                    @if($product->stock > 0)                                     
                                        <a href="{{ route('order.create', $product->id) }}" 
                                            class="bg-[#0E5DA5] text-white px-4 py-2 rounded-md hover:bg-[#0c508f] text-sm">
                                            Pesan Sekarang
                                        </a>

                                    @else
                                        <button disabled class="bg-gray-300 text-gray-500 px-4 py-2 rounded-md text-sm">
                                            Habis
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            @else
                <div class="text-center py-16 text-gray-500">
                    Tidak ada produk untuk kategori ini.
                </div>
            @endif
        </section>
    </main>

    {{-- Footer --}}
    @section('footer')
    <footer class="bg-[rgba(14,93,165,0.1)] border-t border-gray-200 mt-5">
        <div class="container mx-auto px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4">SHOP BY</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li><a href="#" class="hover:text-blue-600">Women</a></li>
                        <li><a href="#" class="hover:text-blue-600">Men</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4">CORPORATE INFO</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li><a href="#" class="hover:text-blue-600">About Us</a></li>
                        <li><a href="#" class="hover:text-blue-600">Delivery Information</a></li>
                        <li><a href="#" class="hover:text-blue-600">Terms and Conditions</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4">CUSTOMER SERVICE</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li><a href="#" class="hover:text-blue-600">Contact Us</a></li>
                        <li><a href="#" class="hover:text-blue-600">FAQs</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4">NEWSLETTER</h3>
                    <p class="text-gray-600 text-sm mb-4">Be the first to know about our newest arrivals, special offers and store events.</p>
                    <div class="flex">
                        <input type="email" placeholder="Enter your email" class="flex-1 border border-gray-300 rounded-l-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#0E5DA5]">
                        <button class="bg-[#0E5DA5] text-white px-6 py-2 rounded-r-md hover:bg-blue-700">SIGN UP</button>
                    </div>
                </div>
            </div>
            <div class="mt-8 pt-5 border-t border-gray-300 text-center text-gray-600 text-sm">
                <p>&copy; {{ date('Y') }} cloudywear. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const search = this.value;
                const url = new URL(window.location.href);
                
                if (search) {
                    url.searchParams.set('search', search);
                } else {
                    url.searchParams.delete('search');
                }
                
                window.location.href = url.toString();
            }
        });
    </script>
    <script>
    document.getElementById('scrollToProducts').addEventListener('click', function() {
        const productsSection = document.getElementById('productsSection');
        productsSection.scrollIntoView({ behavior: 'smooth' });
    });
    </script>
</body>
</html>