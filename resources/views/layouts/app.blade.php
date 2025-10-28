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
        :class="open ? 'w-55' : 'w-20'" 
            class="bg-[#0E5DA5] text-white transition-all duration-300 flex flex-col 
                rounded-r-3xl shadow-lg overflow-hidden">

            <!-- Logo / Toggle -->
            <div class="flex items-center justify-between px-4 py-3 border-b border-blue-700">
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
                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                              d="M3.75 5.75h16.5M3.75 12h16.5M3.75 18.25h16.5" />
                    </svg>
                </button>
            </div>

            <!-- Sidebar Menu -->
            <nav class="flex-1 p-3 space-y-2">
                <a href="{{ route('products.index') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-600 transition">
                    <span>📦</span>
                    <span x-show="open" class="text-sm font-medium">Products</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-600 transition">
                    <span>📊</span>
                    <span x-show="open" class="text-sm font-medium">Reports</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-600 transition">
                    <span>⚙️</span>
                    <span x-show="open" class="text-sm font-medium">Settings</span>
                </a>
            </nav>
            
            <!-- Logout -->
        <div class="p-3 border-t border-blue-600">
            <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="button" 
                        onclick="confirmLogout()"
                        class="flex items-center gap-3 w-full px-3 py-2 text-left hover:bg-blue-600 rounded-lg transition">
                    <span>🚪</span>
                    <span x-show="open" class="text-sm font-medium">Logout</span>
                </button>
            </form>
        </div>

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
            <header class="bg-white shadow-md px-6 py-4 flex justify-between items-center">
                <h1 class="text-xl font-bold text-gray-800">@yield('title')</h1>
                <div class="flex items-center gap-4">
                    <!-- Notification Icon -->
                    <button class="relative text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                             stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                  d="M14.25 18.75a1.5 1.5 0 01-3 0m8.25-4.5V9A6.75 6.75 0 006 9v5.25L3.75 18h16.5L19.5 14.25z" />
                        </svg>
                        <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full px-1">3</span>
                    </button>

                    <!-- User info -->
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/avatar.png') }}" alt="User Avatar" class="w-8 h-8 rounded-full">
                        <span class="text-gray-700 font-medium">Andi Mira</span>
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
