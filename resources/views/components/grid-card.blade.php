{{-- Таблица карточек--}}
<div {{ $attributes->merge(['class' => 'grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6']) }}>
    {{$slot}}
</div>
