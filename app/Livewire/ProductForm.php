<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;

class ProductForm extends Component
{
    use WithFileUploads;


    #[Title('Admin Dashboard | Manage Products ')]
    public $isView = false;

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

    public $image;

    public $product = null;

    public $imagePath;

    public function mount(Product $product)
    {

        $this->isView = request()->routeIs('products.view');
        if ($product->id) {
            $this->name = $product->title;
            $this->category = $product->category_id;
            $this->description = $product->description;
            $this->price = $product->price;
            $this->product = $product;
        }

    }

    public function saveProduct()
    {
        $errors = [];

        // Validates the form title, description, category, price
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = array_merge($errors, $e->validator->errors()->toArray());
        }

        // Dynamic validation rule for create and update
        // For update, image is not required
        $rules = [
            'image' => $this->product && $this->product->image ? 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048' :
                'required|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
        ];

        // Error messages
        $messages = [
            'image.required' => 'Please upload an image!',
            'image.image' => 'Please upload a valid image format!',
            'image.mimes' => 'Valid image formats: jpg, jpeg, png, webp, svg',
            'image.max' => 'Image must not be larger than 2MB!',
        ];

        // Rules are validated
        try {
            $this->validate($rules, $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = array_merge($errors, $e->validator->errors()->toArray());
        }

        // If there are any errors, throw them all together
        if (!empty($errors)) {
            throw \Illuminate\Validation\ValidationException::withMessages($errors);
        }

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
        // Update Functionality
        if ($this->product) {
            $this->product->title = $this->name;
            $this->product->category_id = $this->category;
            $this->product->description = $this->description;
            $this->product->price = $this->price;

            if ($imagePath) {
                $this->product->image = $imagePath;
            }

            $updateProduct = $this->product->save();

            if ($updateProduct) {
                session()->flash('success', 'Product has been updated successfully!');

            } else {
                session()->flash('error', 'Unable to update product, please try again!');
            }
        }
        // Create Functionality
        else {
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
