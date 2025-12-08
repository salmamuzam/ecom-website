<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-4 py-2 bg-[#822659] border border-transparent rounded-md font-semibold text-xs text-[#F0F0F0] uppercase tracking-widest hover:bg-[#004D61] hover:text-[#F0F0F0] active:bg-[#3E5641] active:text-[#F0F0F0] focus:outline-none focus:ring-2 focus:ring-[#004D61] focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
