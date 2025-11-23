<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;

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

    // Ambil tanggal dari filter (kalender)
    $filterDate = request('date');

    // Tabel transaksi terbaru (filter by date jika dipilih)
    $latestOrders = Order::where('status', 'completed')
    ->orderBy('created_at', 'desc')
    ->get();

    return view('admin.dashboard', [
        'totalProducts' => $totalProducts,
        'totalCompletedOrders' => $totalCompletedOrders,
        'totalProductValue' => $totalProductValue,
        'totalValue' => $totalValue,
        'latestOrders' => $latestOrders,
    ]);
}
}
