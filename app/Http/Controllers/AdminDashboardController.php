<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order; // ✅ tambahkan ini

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();

        // Total pendapatan dari pesanan yang selesai
        $totalValue = Order::where('status', 'completed')->sum('total');

        // Total nilai seluruh produk (stok × harga)
    $totalProductValue = Product::selectRaw('SUM(price * stock) as total_value')->value('total_value');

        // Total pesanan yang selesai
        $totalCompletedOrders = Order::where('status', 'completed')->count();

        return view('admin.dashboard', [
            'totalProducts' => $totalProducts,
            'totalCompletedOrders' => $totalCompletedOrders,
            'totalProductValue' => $totalProductValue,
            'totalValue' => $totalValue,
        ]);
    }
}
