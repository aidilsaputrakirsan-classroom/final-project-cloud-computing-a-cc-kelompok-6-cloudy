<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

Class PemesananController extends Controller
{
    public function index(Request $request)
    {
        $searchKeyword = trim((string) $request->query('q', ''));

        $products = Product::with('category')
            ->when($searchKeyword !== '', function ($query) use ($searchKeyword) {
                $like = '%' . $searchKeyword . '%';
                // Use ILIKE for PostgreSQL case-insensitive search
                $query->where(function ($subQuery) use ($like) {
                    $subQuery->where('name', 'ILIKE', $like)
                        ->orWhere('description', 'ILIKE', $like);
                })
                ->orWhereHas('category', function ($catQuery) use ($like) {
                    $catQuery->where('name', 'ILIKE', $like);
                });
            })
            ->orderBy('name')
            ->get();

        $categories = Category::where('is_active', true)->orderBy('name')->get();
        
        return view('admin.pemesanan.index', [
            'products' => $products,
            'categories' => $categories,
            'q' => $searchKeyword,
        ]);
    }
}