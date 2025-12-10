<?php

namespace App\Livewire;
use App\Models\Product;
use Livewire\Component;

class ProductList extends Component
{
    public function render()
    {
        $products = Product::with('category')->get();
        return view('livewire.product-list', compact('products'));
    }
}
