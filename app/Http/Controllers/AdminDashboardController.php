<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order; // ✅ tambahkan ini

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();

        // ✅ hitung total pendapatan dari pemesanan
        $totalValue = Order::where('status', 'completed')->sum('total');

        return view('admin.dashboard', [
            'totalProducts' => $totalProducts,
            'totalValue' => $totalValue,
        ]);
    }
}
