<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#3E5641] dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-[#F0F0F0] dark:text-gray-800 uppercase tracking-widest hover:bg-[#004D61] dark:hover:bg-white focus:bg-[#004D61] dark:focus:bg-white active:bg-[#822659] dark:active:bg-gray-300 focus:outline-hidden focus:ring-2 focus:ring-[#004D61] focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-50 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
