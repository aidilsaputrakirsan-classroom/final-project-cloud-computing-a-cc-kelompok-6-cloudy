<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filter = $request->input('filter');

        $products = \App\Models\Product::when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%");
        })
        ->when($filter, function ($query, $filter) {
            switch ($filter) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'stock_asc':
                    $query->orderBy('stock', 'asc');
                    break;
                case 'stock_desc':
                    $query->orderBy('stock', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        }, function ($query) {
            $query->orderBy('created_at', 'desc');
        })
        ->paginate(8);

        return view('products.index', compact('products'));
    }

    public function create(){ return view('products.create'); }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);
        Product::create($request->all());
        return redirect()->route('products.index');
    }

    public function edit(Product $product){ return view('products.edit', compact('product')); }

    public function update(Request $request, Product $product){
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);
        $product->update($request->all());
        return redirect()->route('products.index');
    }

    public function destroy(Product $product){
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
   }
   
}
