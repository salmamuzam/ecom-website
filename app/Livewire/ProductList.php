<?php

namespace App\Livewire;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;


class ProductList extends Component
{
    use WithPagination, WithoutUrlPagination;

    public function render()
    {
        $products = Product::paginate(5);
        return view('livewire.product-list', compact('products'));
    }
}
