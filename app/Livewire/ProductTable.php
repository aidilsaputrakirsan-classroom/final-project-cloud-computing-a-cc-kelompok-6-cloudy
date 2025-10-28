<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductTable extends Component
{
    public $products;
    public $productId, $name, $description, $price, $stock;

    public function mount()
    {
        $this->products = Product::all();
    }

    // Method untuk edit
    public function edit($id)
    {
        $product = Product::find($id);
        $this->productId = $product->id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->stock = $product->stock;
    }

    // Method untuk hapus
    public function delete($id)
    {
        Product::find($id)->delete();
        $this->mount(); // Refresh data
    }

    // Method untuk simpan (update atau create)
    public function save()
    {
        Product::updateOrCreate(
            ['id' => $this->productId],
            [
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
                'stock' => $this->stock,
            ]
        );

        // Reset form dan refresh data
        $this->reset(['productId','name','description','price','stock']);
        $this->mount();
    }

    public function render()
    {
        return view('livewire.product-table');
    }
}
