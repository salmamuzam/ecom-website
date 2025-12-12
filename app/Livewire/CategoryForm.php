<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
class CategoryForm extends Component
{
    #[Title('Admin Dashboard | Manage Categories')]
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

    public function mount(Category $category)
    {
        $this->isView = request()->routeIs('categories.view');
        if ($category->id) {
            $this->name = $category->name;

            $this->category = $category;
        }

    }
    public function saveCategory()
    {
        $errors = [];

        // Validate name
        $nameRules = [
            'name' => 'required|min:3|max:150',
        ];

        $nameMessages = [
            'name.required' => 'Category name is required!',
            'name.min' => 'Category name must have at least 3 characters!',
            'name.max' => 'Category name must not be more than 150 characters long!',
        ];

        try {
            $this->validate($nameRules, $nameMessages);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = array_merge($errors, $e->validator->errors()->toArray());
        }

        // Validate image - make it optional for updates if category already has an image
        $rules = [
            'image' => $this->category && $this->category->image ? 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048' :
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
        if ($this->category) {
            $this->category->name = $this->name;


            if ($imagePath) {
                $this->category->image = $imagePath;
            }

            $updateCategory = $this->category->save();

            if ($updateCategory) {
                session()->flash('success', 'Category has been updated successfully!');

            } else {
                session()->flash('error', 'Unable to update category, please try again!');
            }
        }
        // Create Functionality
        else {
            // Store in the database
            $category = Category::create([
                'name' => $this->name,

                'image' => $imagePath,
            ]);

            if ($category) {
                session()->flash('success', 'Category has been added successfully!');
                // Reset form fields
                $this->reset(['name', 'image']);
            } else {
                session()->flash('error', 'Unable to create category, please try again!');
            }
        }

        // Used for navigate to ensure there is no page refresh
        return $this->redirect('/categories', navigate: true);
    }

    public function render()
    {
        return view('livewire.category-form');
    }
}
