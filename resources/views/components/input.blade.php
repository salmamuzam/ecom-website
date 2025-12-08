@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-[#1A1A1A] dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#3E5641] dark:focus:border-indigo-600 focus:ring-[#004D61] dark:focus:ring-indigo-600 rounded-md shadow-xs']) !!}>
