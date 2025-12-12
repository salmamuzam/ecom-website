<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Storage;
class CategoryList extends Component
{
    #[Title('Admin Dashboard | Categories')]
    public $searchCategory = null;

    public function fetchCategory()
    {
        if (empty($this->searchCategory)) {
            return Category::all();
        }
        return Category::where('name', 'like', '%' . $this->searchCategory . '%')->get();
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

