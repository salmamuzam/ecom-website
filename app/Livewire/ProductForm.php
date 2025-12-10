<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;

use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

class ProductForm extends Component
{

    use WithFileUploads;

    public $categories;

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

    public function saveProduct()
    {
        $this->validate();
        $imagePath = null;

        if ($this->image) {
            try {
                // Check if image is a valid UploadedFile
                if (!$this->image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                    throw new \Exception('Invalid image file object');
                }

                // Check if file exists
                if (!$this->image->exists()) {
                    throw new \Exception('Uploaded file does not exist');
                }

                // Timestamp name
                $imageName = time() . '.' . $this->image->extension();

                // Store in the 'public' disk under 'uploads' folder
                // This will save to storage/app/public/uploads and return 'uploads/filename.ext'
                $imagePath = $this->image->storeAs('uploads', $imageName, 'public');

                if (!$imagePath) {
                    throw new \Exception('Failed to store file');
                }
            } catch (\Exception $e) {
                session()->flash('error', 'Image upload failed: ' . $e->getMessage());
                return;
            }
        }

        // Store in the database
        $product = Product::create([
            'title' => $this->name,
            'description' => $this->description,
            'category_id' => $this->category,
            'price' => $this->price,
            'image' => $imagePath,
        ]);

        if ($product) {
            session()->flash('success', 'Product has been added successfully!');
            // Reset form fields
            $this->reset(['name', 'category', 'price', 'description', 'image']);
        } else {
            session()->flash('error', 'Unable to create product, please try again!');
        }
        // Used for navigate to ensure there is no page refresh
        return $this->redirect('/products', navigate: true);
    }

    public function render()
    {
        $this->categories = Category::all();
        return view('livewire.product-form');
    }
}
