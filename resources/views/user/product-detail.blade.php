@extends('layouts.app')

@section('title', $product->name . ' - Cloudywear')

{{-- Header --}}
@section('header')
<header class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="container mx-auto px-8 py-4 flex items-center justify-between">
        <a href="{{ route('user.catalog') }}">
            <img src="{{ asset('images/cloudywear-logo1.png') }}" class="h-10 w-auto">
        </a>
    </div>
</header>
@endsection

{{-- Content --}}
@section('content')
<div class="max-w-5xl mx-auto p-6 relative">

     {{-- Judul + Tombol Close --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Deskripsi Produk</h1>
        <a href="{{ route('user.catalog') }}" 
            class="text-gray-500 hover:text-gray-800 p-1 rounded-full hover:bg-gray-200 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

        {{-- Gambar Produk --}}
        <div class="text-center">
            <img src="{{ asset('storage/' . $product->image) }}"
                class="rounded-xl w-full max-h-[500px] object-cover shadow-md">
        </div>

        {{-- Detail Produk --}}
        <div>
            <h2 class="text-3xl font-bold mb-2">{{ $product->name }}</h2>

            <p class="text-gray-500 mb-2">
                Kategori: <strong>{{ $product->category->name ?? '-' }}</strong>
            </p>

            <h3 class="text-2xl text-[#0E5DA5] font-bold mb-4">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </h3>

            <hr class="my-4">

            {{-- Deskripsi --}}
            <h5 class="font-semibold mb-2">Deskripsi Produk:</h5>
            <p class="text-gray-700">
                {{ $product->description }}
            </p>

            {{-- Ukuran Dinamis --}}
            <div class="mt-5">
                <h6 class="font-semibold mb-2">Ukuran:</h6>

                @php
                    switch ($product->name) {
                        case 'Kemeja Putih Basic': $size = 'Lebar 45–55 cm, Panjang 65–75 cm'; break;
                        case 'Kemeja Biru Salur': $size = 'Lingkar dada 100–110 cm, Panjang 65–95 cm'; break;
                        case 'Celana Jeans Denim': $size = 'Panjang 97–103 cm, Lingkar pinggang 70–90 cm'; break;
                        case 'Celana Jeans Highwaist': $size = 'Lingkar pinggang 78–100 cm, Panjang 65–105 cm'; break;
                        default: $size = 'All size (lihat deskripsi).'; break;
                    }
                @endphp

                <p class="text-gray-700">{{ $size }}</p>
            </div>

            {{-- Tombol Pesan --}}
            <a href="{{ route('order.create', $product->id) }}" 
                class="inline-block bg-[#0E5DA5] text-white px-5 py-3 rounded-md mt-6 hover:bg-[#0c508f] transition text-sm font-semibold">
                Pesan Sekarang
            </a>
        </div>

    </div>
</div>
@endsection

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
@endsection