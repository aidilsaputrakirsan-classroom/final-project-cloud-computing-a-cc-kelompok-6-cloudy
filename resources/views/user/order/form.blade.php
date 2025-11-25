@extends('layouts.app')

@section('title', 'Form Pesanan - Cloudywear')

{{-- Header --}}
@section('header')
<header class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="container mx-auto px-8 py-4 flex items-center justify-between">
        <a href="{{ route('user.catalog') }}">
            <img src="{{ asset('images/cloudywear-logo1.png') }}" class="h-10 w-auto">
        </a>

        <!-- Optional navigation/search bisa ditambahkan di sini -->
    </div>
</header>
@endsection

{{-- Content --}}
@section('content')
<div class="max-w-4xl mx-auto p-6 relative">
    
    {{-- Judul + Tombol Close --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Pesan Produk</h1>
        <a href="{{ route('user.catalog') }}" 
            class="text-gray-500 hover:text-gray-800 p-1 rounded-full hover:bg-gray-200 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </a>
    </div>

    {{-- Popup sukses --}}
    @if(session('success'))
    <div id="successModal" 
        class="fixed inset-0 flex items-center justify-center bg-black/50 backdrop-blur-sm animate-fadeIn z-50">
        <div class="bg-white rounded-2xl shadow-2xl p-7 w-80 text-center animate-scaleIn">
            <img src="/images/cloudywear-logo1.png" alt="Logo Cloudywear" class="w-20 mx-auto mb-4 opacity-90">

            <div class="checkmark-wrapper mx-auto mb-3">
                <svg class="checkmark" viewBox="0 0 52 52">
                    <circle class="checkmark-circle" cx="26" cy="26" r="24" fill="none"/>
                    <path class="checkmark-check" fill="none" d="M16 27l8 8 14-14"/>
                </svg>
            </div>

            <h2 class="text-xl font-semibold mb-1 text-gray-800">Pesanan Berhasil!</h2>
            <p class="text-gray-600 mb-2">{{ session('success') }}</p>
            <p class="text-xs text-gray-500" id="orderDate"></p>
        </div>
    </div>

    <script>
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'};
        document.getElementById("orderDate").innerText = now.toLocaleDateString("id-ID", options);

        setTimeout(() => {
            window.location.href = "{{ route('user.catalog') }}"; 
        }, 3000);
    </script>

    <style>
    @keyframes fadeIn { from { opacity:0 } to { opacity:1 } }
    .animate-fadeIn { animation: fadeIn .35s ease-out; }

    @keyframes scaleIn { 0%{transform:scale(.85);opacity:0;} 60%{transform:scale(1.05);opacity:1;} 100%{transform:scale(1);} }
    .animate-scaleIn { animation: scaleIn .35s ease-out; }

    .checkmark-wrapper { width:80px;height:80px; }
    .checkmark { width:80px;height:80px; stroke:#22c55e; stroke-width:4; stroke-linecap:round; stroke-linejoin:round; }
    .checkmark-circle { stroke-dasharray:166; stroke-dashoffset:166; animation: strokeCircle .6s ease-out forwards; }
    .checkmark-check { stroke-dasharray:48; stroke-dashoffset:48; animation: strokeCheck .35s ease-out .6s forwards, bounce .3s ease-out .85s; }

    @keyframes strokeCircle { to{ stroke-dashoffset:0; } }
    @keyframes strokeCheck { to{ stroke-dashoffset:0; } }
    @keyframes bounce { 0%{transform:scale(1);} 50%{transform:scale(1.18);} 100%{transform:scale(1);} }
    </style>
    @endif

    {{-- Form Pesanan --}}
    <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">

        {{-- Nama Produk --}}
        <div class="mb-4">
            <label class="font-semibold">Nama Produk</label>
            <input type="text" value="{{ $product->name }}" disabled class="w-full border-gray-300 rounded mt-1">
        </div>

        {{-- Harga --}}
        <div class="mb-4">
            <label class="font-semibold">Harga</label>
            <input type="text" value="Rp {{ number_format($product->price, 0, ',', '.') }}" disabled class="w-full border-gray-300 rounded mt-1">
        </div>

        {{-- Jumlah --}}
        <div class="mb-4">
            <label class="font-semibold">Jumlah Barang</label>
            <input type="number" name="quantity" id="qty" value="1" min="1" class="w-full border-gray-300 rounded mt-1">
        </div>

        {{-- Total --}}
        <div class="mb-4">
            <label class="font-semibold">Total Harga</label>
            <input type="text" id="totalView" readonly class="w-full border-gray-300 rounded mt-1">
            <input type="hidden" name="total" id="totalHidden">
        </div>

        {{-- Bukti Pembayaran --}}
        <div class="mb-4">
            <label class="font-semibold">Upload Bukti Pembayaran *</label>
            <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG, PDF - Maksimal 2 MB.</p>
            <p class="text-xs text-gray-500">Transfer ke: <b>Bank BNI - 123456789 a.n. cloudywear</b></p>
            <input type="file" name="proof" id="proofInput" class="w-full border-gray-300 rounded mt-1">
            <p id="proofError" class="text-red-600 text-sm mt-1 hidden"></p>
        </div>

        <button class="bg-[#0E5DA5] text-white px-4 py-2 rounded-md hover:bg-[#0c508f] text-sm">
            Kirim Pesanan
        </button>
    </form>
</div>

<script>
const qty = document.getElementById("qty");
const totalView = document.getElementById("totalView");
const totalHidden = document.getElementById("totalHidden");
const price = {{ $product->price }};

function updateTotal() {
    let total = price * qty.value;
    totalView.value = "Rp " + total.toLocaleString("id-ID");
    totalHidden.value = total;
}

qty.addEventListener('input', updateTotal);
updateTotal();
</script>
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
