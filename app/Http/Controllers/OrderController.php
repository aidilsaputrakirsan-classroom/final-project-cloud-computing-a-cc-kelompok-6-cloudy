<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class OrderController extends Controller
{
    // FORM PESANAN
    public function create($id)
    {
        $product = Product::findOrFail($id);

        return view('user.order.form', compact('product'));
    }

    // SIMPAN PESANAN
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required'],
            'quantity'   => ['required', 'integer', 'min:1'],
            'proof'      => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        $product = Product::findOrFail($request->product_id);

        // Hitung total langsung dari server!
        $total = $product->price * $request->quantity;

        // Upload bukti bayar
        $proofPath = $request->file('proof')->store('payment_proofs', 'public');

        Order::create([
            'product_id' => $product->id,
            'quantity'   => $request->quantity,
            'total'      => $total,
            'proof'      => $proofPath,
        ]);

        return back()->with('success', 'Terima kasih, pesanan Anda sedang kami proses.');
    }
}
