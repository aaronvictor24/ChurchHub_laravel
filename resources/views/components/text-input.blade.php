@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge([
        'class' => '
                w-full rounded-md border border-gray-700 bg-gray-900 
                text-gray-100 placeholder-gray-400 
                focus:border-indigo-500 focus:ring focus:ring-indigo-500/50 
                shadow-sm transition-colors duration-200
                disabled:opacity-60 disabled:cursor-not-allowed
            ',
    ]) }}>
