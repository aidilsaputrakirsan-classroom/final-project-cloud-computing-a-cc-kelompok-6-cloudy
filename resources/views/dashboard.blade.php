@extends('layouts.app')

@section('title', 'Welcome to Dashboard!')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <div class="bg-white shadow rounded-lg p-5">
        <h2 class="text-xl font-bold mb-2">📦 Total Products</h2>
        <p class="text-3xl font-semibold">{{ \App\Models\Product::count() }}</p>
    </div>
    <div class="bg-white shadow rounded-lg p-5">
        <h2 class="text-xl font-bold mb-2">💰 Total Value</h2>
        <p class="text-3xl font-semibold">
            Rp {{ number_format(\App\Models\Product::sum('price')) }}
        </p>
    </div>
    <div class="bg-white shadow rounded-lg p-5">
        <h2 class="text-xl font-bold mb-2">🧾 Reports</h2>
        <p class="text-gray-500">View reports and analytics.</p>
    </div>
</div>
@endsection
