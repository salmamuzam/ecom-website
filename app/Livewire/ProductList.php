<?php

namespace App\Livewire;
use App\Models\Product;
use App\Models\Category;
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

    // Sorting properties
    public $sortColumn = 'id';
    public $sortOrder = 'desc';

    // Filtering properties
    public $selectedCategories = [];
    public $priceFrom = null;
    public $priceTo = null;

    // Checkbox selection properties
    public $selectedProducts = [];
    public $selectAll = false;
    public function sortBy($columnName)
    {
        if ($this->sortColumn === $columnName) {
            $this->sortOrder = $this->sortOrder === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn = $columnName;
            $this->sortOrder = 'asc';
        }
        $this->resetPage();
    }

    public function fetchProducts()
    {
        $query = Product::query();

        // Search filter
        if ($this->searchProduct) {
            $query->where('title', 'like', '%' . $this->searchProduct . '%');
        }

        // Category filter
        if (!empty($this->selectedCategories)) {
            $query->whereIn('category_id', $this->selectedCategories);
        }

        // Price range filter
        if ($this->priceFrom !== null && $this->priceFrom !== '') {
            $query->where('price', '>=', $this->priceFrom);
        }
        if ($this->priceTo !== null && $this->priceTo !== '') {
            $query->where('price', '<=', $this->priceTo);
        }

        // Sorting
        $products = $query->orderBy($this->sortColumn, $this->sortOrder)->paginate(5);

        return $products;
    }

    // Reset pagination when search changes
    public function updatedSearchProduct()
    {
        $this->resetPage();
    }

    // Reset pagination when filters change
    public function updatedSelectedCategories()
    {
        $this->resetPage();
    }


    // Clear all filters
    public function clearFilters()
    {
        $this->selectedCategories = [];
        $this->priceFrom = null;
        $this->priceTo = null;
        $this->searchProduct = null;
        $this->resetPage();
    }

    // Apply price filter manually
    public function applyPriceFilter()
    {
        $this->resetPage();
    }
    #[Title('Admin Dashboard | Products')]
    public function render()
    {
        $products = $this->fetchProducts();
        $categories = Category::all();
        return view('livewire.product-list', compact('products', 'categories'));
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

    // Toggle select all checkboxes
    public function updatedSelectAll($value)
    {
        if ($value) {
            // Select all products on current page
            $this->selectedProducts = $this->fetchProducts()->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            // Deselect all
            $this->selectedProducts = [];
        }
    }

    // Delete only selected products
    public function deleteSelected()
    {
        try {
            if (empty($this->selectedProducts)) {
                session()->flash('error', 'No products selected!');
                return;
            }

            // Get selected products
            $products = Product::whereIn('id', $this->selectedProducts)->get();

            $deletedCount = 0;

            // Delete each selected product and its image
            foreach ($products as $product) {
                // Remove image from storage
                if ($product->image && Storage::exists($product->image)) {
                    Storage::delete($product->image);
                }

                if ($product->delete()) {
                    $deletedCount++;
                }
            }

            if ($deletedCount > 0) {
                session()->flash('success', "Successfully deleted {$deletedCount} product(s)!");
                $this->selectedProducts = [];
                $this->selectAll = false;
                $this->resetPage();
            } else {
                session()->flash('error', 'Unable to delete products, please try again!');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting products: ' . $e->getMessage());
        }
    }
    // Track active page from pagination
    public function updatingPage($pageNumber)
    {
        $this->activePageNumber = $pageNumber;
    }
}
