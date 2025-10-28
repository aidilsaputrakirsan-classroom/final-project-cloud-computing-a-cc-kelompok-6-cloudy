@extends('layouts.app')

@section('title', 'Product Management')

@section('content')
<!-- Top -->
<form method="GET" action="{{ route('products.index') }}" 
      class="mb-4 flex flex-wrap items-center gap-2">

    <!-- Search Bar -->
    <div class="flex items-center flex-grow border border-gray-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500 transition">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search product..."
               class="px-4 py-2 w-full outline-none border-none">
        <button type="submit" 
                class="flex items-center justify-center px-3 py-2 bg-white hover:bg-gray-100 transition">
            <span>🔍</span>
        </button>
    </div>

    <!-- Filter -->
    <div class="relative inline-block">
    <select name="category"
            onchange="this.form.submit()"
            class="appearance-none border border-gray-300 rounded-lg px-4 py-2 pr-10 bg-white text-gray-700 cursor-pointer 
                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
        <option value="">All Categories</option>
        <option value="fashion" {{ request('category') == 'fashion' ? 'selected' : '' }}>Pria</option>
        <option value="food" {{ request('category') == 'food' ? 'selected' : '' }}>Wanita</option>
            </select>
        </div>
</form>


<div class="flex items-center justify-between mb-6">
    <a href="{{ route('products.create') }}" 
       class="bg-[#0E5DA5] text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
        Add Product ➕
    </a>
</div>

<!-- Tabel Produk -->
<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="min-w-full border-collapse">
        <thead>
            <tr class="bg-blue-70 border-b">
                <th class="px-4 py-5 text-left text-sm font-semibold text-black">No. Produk</th>
                <th class="px-4 py-5 text-left text-sm font-semibold text-black">Kategori</th>
                <th class="px-4 py-5 text-left text-sm font-semibold text-black">Nama Produk</th>
                <th class="px-4 py-5 text-left text-sm font-semibold text-black">Detail Produk</th>
                <th class="px-4 py-5 text-left text-sm font-semibold text-black">Harga</th>
                <th class="px-4 py-5 text-left text-sm font-semibold text-black">Diskon</th>
                <th class="px-4 py-5 text-left text-sm font-semibold text-black">Harga Jual</th>
                <th class="px-4 py-5 text-left text-sm font-semibold text-black">Stok</th>
                <th class="px-4 py-5 text-left text-sm font-semibold text-black text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $index => $product)
                <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-white' }} border-b hover:bg-blue-50 transition">
                    <td class="px-4 py-2 text-gray-700">
                        {{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}
                    </td>
                    <td class="px-4 py-2 text-gray-700">
                        {{ $product->category->name ?? '-' }}
                    </td>
                    <td class="px-4 py-2 text-gray-700">
                        {{ $product->name }}
                    </td>
                    <td class="px-4 py-2 text-blue-600 underline">
                        <a href="#">Lihat details...</a>
                    </td>
                    <td class="px-4 py-2 text-gray-700">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="px-4 py-2 text-gray-700">{{ $product->discount ?? '0' }}%</td>
                    <td class="px-4 py-2 text-gray-700">Rp {{ number_format($product->sale_price ?? $product->price, 0, ',', '.') }}</td>
                    <td class="px-4 py-2 text-center">
                        <span class="bg-green-400 text-white px-3 py-1 rounded-full text-sm shadow">Tersedia</span>
                    </td>
                    <td class="px-4 py-2 flex items-center justify-center gap-2">
                        <a href="{{ route('products.edit', $product->id) }}"
                        class="text-[#0E5DA5] bg-white border border-[#0E5DA5] rounded-lg p-2 hover:bg-[#0E5DA5] hover:text-white transition">
                            ✏️
                        </a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure to delete this product?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-red-600 bg-white border border-red-600 rounded-lg p-2 hover:bg-red-600 hover:text-white transition">
                                🗑️
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center py-4 text-gray-500">No products found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $products->links() }}
</div>
@endsection
