<?php

namespace App\Livewire;
use App\Models\Product;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination as SupportPaginationWithoutUrlPagination;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;


class ProductList extends Component
{
    use WithPagination, SupportPaginationWithoutUrlPagination;

    public function render()
    {
        $products = Product::paginate(2);
        return view('livewire.product-list', compact('products'));
    }
}
