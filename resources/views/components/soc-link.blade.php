{{--Ссылка на соц. сети--}}
<a {{ $attributes->merge(['target'=>'_blank' ,'class' => 'rounded-full pt-1 text-accent-blue my-auto w-8 h-8 text-center bg-white']) }}>
    {{ $slot }}
</a>
