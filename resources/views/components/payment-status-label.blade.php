@php
    if($status == 'pending'){
        $classes = "ml-2 font-semibold uppercase border-yellow-400 border p-1 text-yellow-400";
        $name = 'Ожидает подтверждения';
    } elseif ($status == 'succeeded'){
        $classes = "ml-2 font-semibold uppercase border-green-400 border p-1 text-green-400";
        $name = 'Оплачен';
    } elseif ($status == 'canceled'){
        $classes = "ml-2 font-semibold uppercase border-red-500 text-red-500 border p-1";
        $name = 'Отменен';
    } else{
        $classes = "ml-2 font-semibold uppercase border-progress border p-1 text-progress";
        $name = 'В обработке';
    }
@endphp
<small {{ $attributes->merge(['class' => $classes]) }}>
    {{ $name }}
</small>
