{{-- нав линки для мобилок--}}
@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex px-1 py-2 border-l-4 font-medium text-indigo-700 bg-indigo-50'
            : 'flex px-1 py-2 border-l-4 border-transparent font-medium text-gray-500 hover:text-gray-600 hover:bg-gray-100';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <div class="mr-1.5 block w-0 border-2 h-5 @if($active ?? false)border-accent-blue bg-accent-blue @else border-transparent @endif"></div>
    {{ $slot }}
</a>
