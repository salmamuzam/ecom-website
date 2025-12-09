<x-app-layout>
    {{-- Hero Section --}}
    @section('hero')
<section class="w-full py-5 bg-[#F8F2EA] lg:py-10">
  <div class="grid lg:grid-cols-2 items-center justify-items-center gap-5">
    <div class="order-2 lg:order-1 flex flex-col justify-center items-center">
      <p class="text-4xl font-bold md:text-7xl text-[#822659]">25% Off</p>
      <p class="text-4xl font-bold md:text-7xl text-[#1A1A1A]">RAMADAN SALE</p>
      <p class="mt-2 text-sm md:text-lg text-[#1A1A1A]">Ramadan Collection Just Dropped.</p>
      <button class="rounded-lg text-lg md:text-2xl bg-[#3E5641] text-[#F0F0F0] py-2 px-5 mt-10 hover:bg-[#004D61]">Shop Now</button>
    </div>
    <div class="order-1 lg:order-2">
      <img class="rounded-lg h-80 w-80 object-cover lg:w-[500px] lg:h-[500px]" src="{{ asset('images/hero_image.jpg') }}" alt="Hero Image">
    </div>
  </div>
</section>
@endsection
<div class="bg-gray-100 rounded-[20px] sm:p-8 p-6">
          <div class="max-w-screen-xl mx-auto">
              <h2 class="text-slate-900 text-xl font-bold mb-6">Our Collection</h2>

              <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-4">
                  <div class="shadow-sm bg-white p-1.5 rounded-md overflow-hidden cursor-pointer relative hover:shadow-md">
                      <a href="javascript:void(0);" class="block">
                          <div class="bg-gray-200 aspect-square">
                              <img src='{{ asset('images/abaya_category.png') }}' class="w-full h-full object-cover object-top" />
                          </div>
                          <div class="p-3 pb-1.5 text-center">
                              <h6 class="text-slate-900 text-sm font-bold truncate">Abayas</h6>
                          </div>
                      </a>
                  </div>

                
              </div>
          </div>
      </div>
</x-app-layout>
