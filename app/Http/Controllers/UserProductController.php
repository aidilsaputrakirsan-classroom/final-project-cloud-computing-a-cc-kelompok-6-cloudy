<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class UserProductController extends Controller
{
    // Halaman Catalog Produk User
    public function catalog()
    {
        $products = Product::all();
        return view('user.catalog', compact('products'));
    }

    // Halaman Detail Produk
    public function detail($id)
    {
        $product = Product::findOrFail($id);
        return view('user.product-detail', compact('product'));
    }
}