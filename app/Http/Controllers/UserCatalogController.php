<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class UserCatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ILIKE', '%' . $search . '%')
                  ->orWhere('description', 'ILIKE', '%' . $search . '%');
            });
        }

        // Filter only products with stock > 0
        $query->where('stock', '>', 0);

        // Get products with pagination and preserve query parameters
        $products = $query->orderBy('created_at', 'desc')
            ->paginate(12)
            ->appends($request->query());

        // Get all active categories for filter
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('user.catalog', compact('products', 'categories'));
    }
}