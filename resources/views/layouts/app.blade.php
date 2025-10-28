<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    {{-- Hubungkan Tailwind --}}
    @vite('resources/css/app.css')

    {{-- Alpine.js (cukup satu) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 flex h-screen">
    <div x-data="{ open: true }" class="flex w-full">
        <!-- Sidebar -->
        <div 
        :class="open ? 'w-59' : 'w-25'" 
            class="bg-[#0E5DA5] text-white transition-all duration-300 flex flex-col 
                shadow-lg overflow-hidden">

            <!-- Logo / Toggle -->
            <div class="flex items-center justify-between px-3 py-4 border-b border-white-700">
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <!-- Logo saat sidebar terbuka -->
                    <img src="{{ asset('images/logoputih.png') }}" 
                        x-show="open"
                        class="h-10 w-auto transition-all duration-300">

                    <!-- Logo kecil saat sidebar tertutup -->
                    <img src="{{ asset('images/logoputih.png') }}" 
                        x-show="!open"
                        class="h-6 w-auto transition-all duration-300">
                </a>

                <!-- Tombol toggle (muncul hanya saat sidebar terbuka) -->
                <button @click="open = !open" 
                        x-show="open"
                        class="text-white focus:outline-none transition-opacity duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                        stroke-width="1.5" stroke="currentColor" class="w-9 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                              d="M3.75 5.75h16.5M3.75 12h16.5M3.75 18.25h16.5" />
                    </svg>
                </button>
            </div>

            <!-- Sidebar Menu -->
            <nav class="flex-1 p-3 space-y-2">
                <a href="{{ route('products.index') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-600 transition">
                    <span class="text-2xl">📦</span>
                    <span x-show="open" class="text-sm font-medium">Products</span>
                </a>
            </nav>

        <!-- Alert Script -->
        <script>
            function confirmLogout() {
                if (confirm('Apakah Anda yakin ingin logout?')) {
                    document.getElementById('logoutForm').submit();
                }
            }
        </script>

        </div>

        <!-- Main Area -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow-md px-6 py-5 flex justify-between items-center relative z-10">
                <h1 class="text-xl font-bold text-gray-800">@yield('title')</h1>
                
                <!-- User Dropdown -->
                <div x-data="{ dropdownOpen: false }" class="relative">
                    <button @click="dropdownOpen = !dropdownOpen" class="flex items-center gap-2 text-gray-700 font-medium focus:outline-none">
                        <span>👤 Andi Mira</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="dropdownOpen" 
                        @click.outside="dropdownOpen = false"
                        x-transition
                        class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg py-2">
                        <a href="" 
                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition">
                            ⚙️ Atur Profil
                        </a>

                        <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="button" 
                                    onclick="confirmLogout()"
                                    class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 transition">
                                🚪 Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

        <!-- Main Content -->
        <div class="flex-1 p-6 overflow-y-auto">
            @yield('content')
        </div>
    </div>
</body>
</html>
