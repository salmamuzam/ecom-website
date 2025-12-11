<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
class CategoryForm extends Component
{
    public $isView = false;
    use WithFileUploads;
    #[Validate('required', message: 'Category name is required!')]
    #[Validate('min:3', message: 'Category name must have at least 3 characters!')]
    #[Validate('max:150', message: 'Category name must not be more than 150 characters long!')]
    public $name;

    #[Validate('required', message: 'Category  image is required!')]
    #[Validate('image', message: 'Category image must be a valid image!')]
    #[Validate('mimes:jpg,jpeg,jpg,png,svg,webp', message: 'Valid Image Formats; jpg, jpeg, jpg, png, svg, webp.')]
    #[Validate('max:2048', message: 'Image must not be bigger than 2MB')]
    public $image;
public $category = null;

    public function mount(Category $category){
        $this->isView = request()->routeIs('categories.view');
        if($category->id){
            $this->name = $category ->name;

       $this->category=$category;
        }

    }
    public function saveCategory()
    {
        $this->validate();
        $imagePath = null;
        if ($this->image) {
            $imageName = time() . '.' . $this->image->extension();
            $imagePath = $this->image->storeAs('uploads', $imageName, 'public');
        }
        $category = Category::create([
            'name' => $this->name,
            'image' => $imagePath

        ]);

        if ($category) {
            session()->flash('success', 'Category has been created successfully!');
        } else {
            session()->flash('error', 'Unable to create category, please try again!');
        }
        return $this->redirect('/categories', navigate: true);
    }
    public function render()
    {
        return view('livewire.category-form');
    }
}
