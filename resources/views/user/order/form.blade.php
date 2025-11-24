@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Form Pesanan</h1>

    {{-- POPUP SUKSES --}}
    @if(session('success'))
    <div id="successModal" 
        class="fixed inset-0 flex items-center justify-center bg-black/50 backdrop-blur-sm animate-fadeIn z-50">

        <div class="bg-white rounded-2xl shadow-2xl p-7 w-80 text-center animate-scaleIn">

            {{-- LOGO CLOUDYWEAR --}}
            <img src="/images/cloudywear-logo1.png" 
                alt="Logo Cloudywear" 
                class="w-20 mx-auto mb-4 opacity-90">

            {{-- ANIMASI CENTANG --}}
            <div class="checkmark-wrapper mx-auto mb-3">
                <svg class="checkmark" viewBox="0 0 52 52">
                    <circle class="checkmark-circle" cx="26" cy="26" r="24" fill="none"/>
                    <path class="checkmark-check" fill="none" d="M16 27l8 8 14-14"/>
                </svg>
            </div>

            <h2 class="text-xl font-semibold mb-1 text-gray-800">Pesanan Berhasil!</h2>

            <p class="text-gray-600 mb-2">{{ session('success') }}</p>

            {{-- TANGGAL --}}
            <p class="text-xs text-gray-500" id="orderDate"></p>

        </div>
    </div>

    {{-- Script tanggal + redirect --}}
    <script>
        // tanggal
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'};
        document.getElementById("orderDate").innerText = now.toLocaleDateString("id-ID", options);

        // auto redirect
        setTimeout(() => {
            window.location.href = "{{ route('user.catalog') }}"; 
        }, 3000);
    </script>

    {{-- STYLE ANIMASI --}}
    <style>
    /* Fade-in untuk overlay */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    .animate-fadeIn {
        animation: fadeIn .35s ease-out;
    }

    /* Scale-in untuk popup */
    @keyframes scaleIn {
        0% { transform: scale(.85); opacity: 0; }
        60% { transform: scale(1.05); opacity: 1; }
        100% { transform: scale(1); }
    }
    .animate-scaleIn {
        animation: scaleIn .35s ease-out;
    }

    /* CHECKMARK ANIMATION */
    .checkmark-wrapper {
        width: 80px;
        height: 80px;
    }

    .checkmark {
        width: 80px;
        height: 80px;
        stroke: #22c55e;
        stroke-width: 4;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    /* Lingkaran */
    .checkmark-circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        animation: strokeCircle .6s ease-out forwards;
    }

    /* Centang */
    .checkmark-check {
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        animation: strokeCheck .35s ease-out .6s forwards,
                bounce .3s ease-out .85s;
    }

    /* Animasi menggambar */
    @keyframes strokeCircle {
        to { stroke-dashoffset: 0; }
    }
    @keyframes strokeCheck {
        to { stroke-dashoffset: 0; }
    }

    /* Bounce kecil */
    @keyframes bounce {
        0% { transform: scale(1); }
        50% { transform: scale(1.18); }
        100% { transform: scale(1); }
    }
    </style>
    @endif

    <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="product_id" value="{{ $product->id }}">

        {{-- Produk --}}
        <div class="mb-4">
            <label class="font-semibold">Nama Produk</label>
            <input type="text" value="{{ $product->name }}" disabled
                class="w-full border-gray-300 rounded mt-1">
        </div>

        {{-- Harga --}}
        <div class="mb-4">
            <label class="font-semibold">Harga</label>
            <input type="text" value="Rp {{ number_format($product->price, 0, ',', '.') }}" disabled
                class="w-full border-gray-300 rounded mt-1">
        </div>

        {{-- Jumlah --}}
        <div class="mb-4">
            <label class="font-semibold">Jumlah Barang</label>
            <input type="number" name="quantity" id="qty" value="1" min="1"
                class="w-full border-gray-300 rounded mt-1">
        </div>

        {{-- Total Harga Otomatis --}}
        <div class="mb-4">
            <label class="font-semibold">Total Harga</label>

            {{-- tampil di layar --}}
            <input type="text" id="totalView" readonly
                class="w-full border-gray-300 rounded mt-1">

            {{-- dikirim ke server --}}
            <input type="hidden" name="total" id="totalHidden">
        </div>

        {{-- Bukti Pembayaran --}}
        <div class="mb-4">
            <label class="font-semibold">Upload Bukti Pembayaran *</label>
            <p class="text-xs text-gray-500 mt-1">
                Format yang diterima: JPG, JPEG, PNG, PDF - Maksimal 2 MB.
            </p>
            <p class="text-xs text-gray-500">
                Silakan transfer ke: <b>Bank BNI - 123456789 a.n. cloudywear</b>
            </p>

            <input type="file" name="proof" id="proofInput"
                class="w-full border-gray-300 rounded mt-1">

            <p id="proofError" class="text-red-600 text-sm mt-1 hidden"></p>
        </div>


        <button class="bg-[#0E5DA5] text-white px-4 py-2 rounded-md hover:bg-[#0c508f] text-sm">
            Kirim Pesanan
        </button>
    </form>
</div>

{{-- Script Hitung Total --}}
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
