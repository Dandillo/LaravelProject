{{--modelname - название в контроллере,
    dict - словарь массив id, name
    label - placeholder для поля
    valId - значение поля
    --}}
<div wire:ignore>
    <select class="{{$modelname}} w-full" id="{{$modelname}}" wire:model:lazy={{$modelname}}
    @isset($isMultiple) multiple='multiple'@endisset>
        <option value=""></option>
        @foreach($dict as $item)
            <option value="{{$item->id}}">{{$item->name}}</option>
        @endforeach
    </select>
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.{{$modelname}}').select2({
                placeholder: '{{$label ?? 'Выберите значение'}}',
                allowClear: true,
            });
            $('.{{$modelname}}').on('change', function (e) {
                let elementName = $(this).attr('id');
                var data = $(this).select2("val");
            @this.set(elementName, data);
            });
            @isset($valId)
            @if(is_array($valId))
                $('.{{$modelname}}').val({{json_encode($valId)}});// format ['1','2']
            @else
                $('.{{$modelname}}').val('{{$valId ?? 0}}'); // Select the option with a value of '1'
            @endif
                $('.{{$modelname}}').trigger('change'); // Notify any JS components that the value changed
            @endisset
        });
    </script>
@endpush
