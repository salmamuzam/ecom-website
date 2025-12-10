
        <!-- Modal content -->
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            <!-- Modal header -->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add Product</h3>
                <button wire:navigate href="{{ route('products') }}" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="createProductModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form wire:submit.prevent="saveProduct">
                <div class="grid gap-4 mb-4 sm:grid-cols-2">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product Name</label>
                        <input type="text" wire:model="name" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Type product name" >
@error('name')
   <p class="mt-2 text-[#822659]">
        {{$message}}
   </p>
@enderror
                    </div>
                    <div><label for="category"  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label><select name="category" wire:model="category" id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"><option selected="">Select category</option><option value="Abaya">Abaya</option><option value="Dress">Dress</option><option value="Hijab">Hijab</option><option value="Accessory">Accessory</option></select>            @error('category')
   <p class="mt-2  text-[#822659]"">
        {{$message}}
   </p>
@enderror
             </div>

                </div>

 <div class="mb-4">
                    <div>
                        <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                        <input type="number" wire:model="price" name="price" id="price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="LKR 2999" >
                                        @error('price')
   <p class="mt-2  text-[#822659]"">
        {{$message}}
   </p>
@enderror


                    </div>

                    <div class="sm:col-span-2 mt-4"><label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label><textarea id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" wire:model="description" placeholder="Write product description here"></textarea></div>
                        @error('description')
   <p class="mt-2  text-[#822659]"">
        {{$message}}
   </p>
@enderror

</div>
                <div class="mb-4">

<label class="block mb-2.5 text-sm font-medium text-heading" for="image">Product Image</label>
<input class="cursor-pointer bg-gray-50 border border-default-medium text-heading text-sm rounded-lg focus:ring-brand focus:border-brand block w-full shadow-xs placeholder:text-body" id="image" type="file" wire:model="image">


         {{-- Preview image --}}
                    @if($image)
                    <div class="my-2">
                    <img src="{{ $image->temporaryUrl() }}" class="" >
                    </div>
                    @endif
                    @error('image')
   <p class="mt-2  text-[#822659]"">
        {{$message}}
   </p>
@enderror

                </div>
                <div class="items-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                    <button type="submit"  class=" w-full sm:w-auto justify-center text-white inline-flex bg-[#3E5641] hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Add product</button>

                    <button data-modal-toggle="createProductModal" type="button" class="w-full justify-center sm:w-auto text-white inline-flex items-center bg-[#822659] hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        <svg class="mr-1 -ml-1 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                        Discard
                    </button>
                </div>
            </form>
        </div>

