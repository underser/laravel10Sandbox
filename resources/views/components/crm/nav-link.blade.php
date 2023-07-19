@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'flex items-center justify-center gap-3 px-3 py-2 rounded-lg font-medium transition bg-primary-500 text-white'
                : 'flex items-center justify-center gap-3 px-3 py-2 rounded-lg font-medium transition hover:bg-gray-500/5 focus:bg-gray-500/5 dark:text-gray-300 dark:hover:bg-gray-700';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
