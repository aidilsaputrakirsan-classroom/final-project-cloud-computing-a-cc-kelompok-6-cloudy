<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $products = Product::latest()->take(5)->get();

        return view('dashboard', compact('totalProducts', 'products'));
    }
}
