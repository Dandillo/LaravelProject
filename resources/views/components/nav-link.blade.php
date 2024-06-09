@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'inline-flex font-bold items-center px-1 pt-1 text-accent-blue font-medium leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
                : 'inline-flex font-bold items-center px-1 pt-1 font-medium leading-5 text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} style="font-size: 16px;">
        <div class="mr-1.5 block w-0 border-2 h-5 @if($active ?? false)border-accent-blue bg-accent-blue @else border-transparent @endif"></div>
    {{ $slot }}
</a>
