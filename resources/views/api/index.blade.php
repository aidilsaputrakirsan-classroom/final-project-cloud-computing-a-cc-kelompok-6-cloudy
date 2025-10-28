@extends('layouts.app')

@section('title', 'Product Management')

@section('content')
<!-- Toolbar -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">

    <!-- Search + Filter -->
    <form method="GET" action="{{ route('products.index') }}" class="flex flex-wrap items-center gap-2">
        <!-- Search -->
        <div class="relative">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search product..."
                   class="border border-gray-300 rounded-lg pl-10 pr-4 py-2 focus:ring-2 focus:ring-blue-500">
            <span class="absolute left-3 top-2.5 text-gray-400">🔍</span>
        </div>

        <!-- Filter -->
        <div class="relative">
            <select name="filter"
                    class="border border-gray-300 rounded-lg pl-10 pr-8 py-2 bg-white focus:ring-2 focus:ring-blue-500">
                <option value="">⚙️ Filter</option>
                <option value="price_asc" {{ request('filter') == 'price_asc' ? 'selected' : '' }}>💰 Price: Low → High</option>
                <option value="price_desc" {{ request('filter') == 'price_desc' ? 'selected' : '' }}>💰 Price: High → Low</option>
                <option value="stock_asc" {{ request('filter') == 'stock_asc' ? 'selected' : '' }}>📦 Stock: Low → High</option>
                <option value="stock_desc" {{ request('filter') == 'stock_desc' ? 'selected' : '' }}>📦 Stock: High → Low</option>
            </select>
            <span class="absolute left-3 top-2.5 text-gray-400">🎛️</span>
        </div>

        <!-- Submit -->
        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            Apply
        </button>
    </form>

    <!-- Add Product -->
    <a href="{{ route('products.create') }}" 
       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
        ➕ Add Product
    </a>
</div>

<!-- Product Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full border-collapse">
        <thead>
            <tr class="bg-gray-100 border-b">
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">#</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Name</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Price</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Stock</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $index => $product)
            <tr class="border-b hover:bg-gray-50 transition">
                <td class="px-6 py-3 text-gray-700">{{ $index + 1 }}</td>
                <td class="px-6 py-3 text-gray-700">{{ $product->name }}</td>
                <td class="px-6 py-3 text-gray-700">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="px-6 py-3 text-gray-700">{{ $product->stock }}</td>
                <td class="px-6 py-3 text-center flex justify-center gap-2">
                    <a href="{{ route('products.edit', $product->id) }}" 
                       class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-lg text-sm">✏️</a>

                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" 
                          onsubmit="return confirm('Are you sure to delete this product?')">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-sm">🗑️</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-4 text-gray-500">No products found.</td>
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
