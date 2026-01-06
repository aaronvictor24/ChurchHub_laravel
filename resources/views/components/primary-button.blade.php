<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' => '
                inline-flex items-center justify-center
                px-4 py-2 rounded-md font-semibold text-sm
                bg-indigo-600 text-white
                hover:bg-indigo-500 active:bg-indigo-700
                focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 focus:ring-offset-gray-900
                transition-all duration-200
                disabled:opacity-60 disabled:cursor-not-allowed
            ',
    ]) }}>
    {{ $slot }}
</button>
