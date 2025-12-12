<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class CategoryList extends Component
{
    use WithPagination, WithoutUrlPagination;
    
    #[Title('Admin Dashboard | Categories')]
    public $searchCategory = null;

    public function fetchCategory()
    {
        $query = Category::query();
        
        if (!empty($this->searchCategory)) {
            $query->where('name', 'like', '%' . $this->searchCategory . '%');
        }
        
        return $query->orderBy('id', 'DESC')->paginate(10);
    }
    
    public function updatedSearchCategory()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $categories = $this->fetchCategory();
        return view('livewire.category-list', compact('categories'));
    }

    public function deleteCategory(category $category)
    {
        if ($category) {
            # Remove image from storage
            if (Storage::exists($category->image)) {
                Storage::delete($category->image);
            }
            ;
            $deleteResponse = $category->delete();
            if ($deleteResponse) {
                session()->flash('success', 'Category deleted successfully!');
            } else {
                session()->flash('error', 'Unable to delete category, please try again!');
            }
        } else {
            session()->flash('error', 'Category not found, please try again!');
        }
        return $this->redirect('/categories', navigate: true);

    }
}

