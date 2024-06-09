@props(['value'])

<h2 {{ $attributes->merge(['class' => 'mb-3 mt-6']) }}>
    {{ $value ?? $slot }}
</h2>
