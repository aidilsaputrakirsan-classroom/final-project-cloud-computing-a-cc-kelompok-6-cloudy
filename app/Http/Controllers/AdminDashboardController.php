<?php

namespace App\Http\Controllers;

use App\Models\Product;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalValue = Product::query()
            ->selectRaw('COALESCE(SUM(price * stock), 0) as total')
            ->value('total');

        return view('admin.dashboard', [
            'totalProducts' => $totalProducts,
            'totalValue' => $totalValue,
        ]);
    }
}


