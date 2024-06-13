@props(['active'])

@php
$classes = 'inline-flex items-center px-1 pt-1 text-sm leading-5 focus:outline-none transition duration-150 ease-in-out';

if ($active ?? false) {
    $classes .= ' font-bold';
}
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
