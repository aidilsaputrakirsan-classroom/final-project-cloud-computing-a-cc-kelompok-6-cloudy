@extends('layouts.app')

@section('title', 'Product Management')

@section('content')
<!-- Search Filter -->
<form method="GET" action="{{ route('products.index') }}" class="mb-4 flex items-center gap-2">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Search product..." 
           class="border border-gray-300 rounded-lg px-3 py-2 w-1/3 focus:ring-2 focus:ring-blue-500">
    <button type="submit" 
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
        🔍 Search
    </button>
</form>

<div class="flex items-center justify-between mb-6">
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
