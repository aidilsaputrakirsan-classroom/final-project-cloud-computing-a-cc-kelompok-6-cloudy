<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;

class PemesananController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q; // konsisten dengan controller lain

        $query = Order::with('product.category');

        // Filter kategori
        if ($q) {
            $query->where(function($sub) use ($q) {
                $sub->whereHas('product', function($p) use ($q) {
                    $p->where('name', 'LIKE', "%{$q}%")
                      ->orWhereHas('category', function($c) use ($q) {
                          $c->where('name', 'ILIKE', "%{$q}%");
                      });
                });
            });
        }

        // Pagination + tetap bawa parameter
        $orders = $query->latest()->paginate(10)->appends(request()->query());
        $categories = Category::all(); // optional, kalau mau dropdown filter kategori

        return view('admin.pemesanan.index', compact('orders', 'categories', 'q'));
    }
    
    public function update(Request $request, $id)
    {
        // Validasi request (misal status wajib ada)
        $request->validate([
            'status' => 'required|string|in:pending,completed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->route('admin.pemesanan.index')->with('success', 'Status pesanan berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.pemesanan.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}
