@props(['disabled' => false, 'test' => false])

@php
    $classes = ($test ?? false)
                ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:ring-red'
                : 'text-black outline-none shadow-sm border-gray-300 px-3 py-2 text-sm';
@endphp
<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['type' => 'text','class' => $classes]) !!}>
