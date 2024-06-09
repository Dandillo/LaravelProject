{{-- add attributes on component for Yes button, wire:click--}}
<div x-data="{ confirmDelete:false }">
    <button x-show="!confirmDelete" x-on:click="confirmDelete=true"
            class="btn">{{$slot}}</button>
    <button x-show="confirmDelete" x-on:click="confirmDelete=false"
        {{ $attributes->merge(['class' => 'btn-success']) }}>Да
    </button>
    <button x-show="confirmDelete" x-on:click="confirmDelete=false"
            class="btn border-gray-400 text-gray-400">Нет
    </button>
</div>
