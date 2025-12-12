<?php

namespace App\Livewire;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\Attributes\Title;


class ProductList extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $searchProduct = null;
    public $activePageNumber = 1;

    public function fetchProducts()
    {
        $products = Product::where('title', 'like', '%' . $this->searchProduct . '%')->orderBy('id', 'DESC')->paginate(5);
        return $products;
    }
    #[Title('Admin Dashboard | Products')]
    public function render()
    {
        $products = $this->fetchProducts();
        return view('livewire.product-list', compact('products'));
    }



    public function deleteProduct(Product $product)
    {
        if ($product) {
            # Remove image from storage
            if (Storage::exists($product->image)) {
                Storage::delete($product->image);
            }
            ;
            $deleteResponse = $product->delete();
            if ($deleteResponse) {
                session()->flash('success', 'Product deleted successfully!');
            } else {
                session()->flash('error', 'Unable to delete product, please try again!');
            }
        } else {
            session()->flash('error', 'Product not found, please try again!');
        }
        $products = $this->fetchProducts();
        if ($products->isEmpty() && $this->activePageNumber > 1) {
            $this->gotoPage($this->activePageNumber - 1);
            //return $this->redirect('/products', navigate: true);
        } else {
            $this->gotoPage($this->activePageNumber);
        }
    }
    // Track active page from pagination
    public function updatingPage($pageNumber)
    {
        $this->activePageNumber = $pageNumber;
    }
}
