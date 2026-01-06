@props(['value'])

<label
    {{ $attributes->merge([
        'class' =>
            'block font-medium text-xl text-gray-200 transition-colors duration-150 group-focus-within:text-blue-400',
    ]) }}>
    {{ $value ?? $slot }}
</label>
