{{-- @props(['category']) --}}
<div class="shadow-sm bg-white p-1.5 rounded-lg overflow-hidden cursor-pointer relative hover:shadow-md">
    <a href="javascript:void(0);" class="block">
        <div class="bg-gray-200 aspect-square">
            <img src='{{ $category->image }}' class="w-full h-full object-cover object-top" />
        </div>
        <div class="p-3 pb-1.5 text-center">
            <h6 class="text-slate-900 text-sm font-bold truncate">{{ $category->name }}</h6>
        </div>
    </a>
</div>
