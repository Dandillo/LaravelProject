<div class="w-3/4 mx-auto bg-white p-4 rounded">
    @if($is_update)
        <x-title>Изменить страницу</x-title>
    @else
        <x-title>Создать страницу</x-title>
    @endif
    <form wire:submit.prevent=@if($is_update) "update" @else "store" @endif>
    <div class="mb-3">
        <x-input-label>Заголовок страницы *</x-input-label>
        <x-input wire:model.defer="title" type="text" placeholder="Заголовок" class="w-full"></x-input>
        @error('title')
        <div class="text-right"><small class="text-red-900">{{ $message }}</small></div>
        @enderror
    </div>

    <div class="mb-3">
        <x-input-label>Адрес страницы *</x-input-label>
        <small>Впишите название латинскими буквами, без пробелов, вместо них используйте "-"</small>
        <x-input wire:model.defer="link" type="text" placeholder="Пример: about, new-events"
                 class="w-full"></x-input>
        @error('link')
        <div class="text-right"><small class="text-red-900">{{ $message }}</small></div>
        @enderror
    </div>
    <div class="mb-3" wire:ignore>
        <x-input-label>Текст страницы *</x-input-label>
        <textarea wire:model.debounce.9999999ms="description"
                  class="w-full description"
                  rows="15"></textarea>
    </div>
    <div class="flex items-center">
        <input wire:model.defer="is_public" type="checkbox"
               class="form-checkbox w-4 h-4 text-accent-blue"/>
        <label for="remember" class="block ml-2 text-sm text-gray-900 leading-5">
            Опубликовать
        </label>
    </div>

    <div class="text-right">
        <button type="submit" class="w-40 text-xs px-3 py-2 btn-save">
            Сохранить
        </button>
    </div>
    </form>
</div>
@push('scripts')
    <script src="{{ asset('js/tinymce/tinymce.js') }}"></script>
    <x-tinymce></x-tinymce>
@endpush
