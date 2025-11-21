<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class PemesananController extends Controller
{
    public function index()
    {
        $orders = Order::with('product')->latest()->get();
        $categories = Category::all();
        $products = Product::all(); 

        return view('admin.pemesanan.index', compact('orders', 'categories', 'products'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $order->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return back()->with('success', 'Pesanan berhasil dihapus!');
    }
}
