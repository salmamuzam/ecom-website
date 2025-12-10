<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

class ProductForm extends Component
{

    use WithFileUploads;

    #[Validate('required', message: 'Product name is required!')]
    #[Validate('min:3', message: 'Product name must have at least 3 characters!')]
    #[Validate('max:150', message: 'Product name must not have more than 150 characters!')]

    public $name;
    #[Validate('required', message: 'Please select a category!')]


    public $category;

    #[Validate('required', message: 'Product price is required!')]


    public $price;

    #[Validate('required', message: 'Product description is required!')]
    #[Validate('min:10', message: 'Product name must have at least 10 characters!')]


    public $description;
    #[Validate('required', message: 'Please upload an image!')]
    #[Validate('image', message: 'Please upload a valid image format!')]
    #[Validate('mimes:jpg,jpeg,png,webp,svg', message: 'Valid image formats: jpg, jpeg, png, webp, svg')]
    #[Validate('max:2048', message: 'Image must not be larger than 2MB!')]
    public $image;
    public $imagePath;

    public function saveProduct(){
       $this->validate();
       $imagePath = null;
       if($this->image){
        // Timestamp name
        $imageName = time().'.'.$this->image->extension();
        $imagePath = $this->image->storeAs('public/uploads', $imageName);
       }

       // Store in the database
       Product::create([
        'title' => $this->name,
        'description' => $this->description,
        'category_id' => $this->category,
        'price' => $this->price,
        'image' => $this->imagePath,
       ]);

       if($product){
session()->flash('success', 'Product has been added successfully!');
       }
       else{
        session()->flash('error', 'Unable to create product, please try again!');
       }
       // Used for navigate to ensure there is no page refresh
       return $this->redirect('/products', navigate:true);
    }

    public function render()
    {
        return view('livewire.product-form');
    }
}
