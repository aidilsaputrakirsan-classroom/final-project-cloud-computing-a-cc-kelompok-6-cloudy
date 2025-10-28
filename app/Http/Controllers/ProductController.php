<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $productsPria = Product::where('category', 'pria')->get();
        $productsWanita = Product::where('category', 'wanita')->get();
        
        return view('admin.products.index', [
            'productsPria' => $productsPria,
            'productsWanita' => $productsWanita
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'category' => 'required|in:pria,wanita'
            ]);

            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('products', 'public');
            }

            Product::create($validated);

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'category' => 'required|in:pria,wanita'
            ]);

            if ($request->hasFile('image')) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $validated['image'] = $request->file('image')->store('products', 'public');
            }

            $product->update($validated);

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            // Soft-disable delete functionality while keeping the UI and route.
            // We still verify the product exists to show meaningful feedback.
            Product::findOrFail($id);

            return redirect()->route('admin.products.index')
                ->with('info', 'Fitur hapus sementara dinonaktifkan. Tidak ada data yang dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
