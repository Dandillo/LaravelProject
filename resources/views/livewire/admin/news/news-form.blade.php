<div class="w-3/4 mx-auto bg-white p-4 rounded">
    <x-title>{{$is_update ?"Изменить новость": "Создать новость"}}</x-title>

    <form wire:submit.prevent={{$is_update?"update":"store"}}>
        <div class="mb-3">
            <x-input-label>Название новости *</x-input-label>
            <x-input wire:model.defer="title" type="text" placeholder="Название" class="w-full"></x-input>
            @error('title')
            <div class="text-right"><small class="text-red-900">{{ $message }}</small>
            </div>@enderror
        </div>
        <div class="mb-3" wire:ignore>
            <x-input-label>Текст новости *</x-input-label>
            <textarea wire:model.defer="description"
                      class="w-full description"
                      rows="12"></textarea>
        </div>
        @error('description')
        <div class="text-right"><small class="text-red-900">{{ $message }}</small>
        </div>@enderror
        <div class="mb-5">
            <x-input-label>Изображение карточки новости</x-input-label>
            <x-file-input id="img-card-input" wire:model.defer="image_card"/>
        </div>
        <div class="text-right">
            @error('image_card')
            <small class="text-red-900">{{ $message }}</small>
            @enderror
        </div>
        <img wire:ignore
             src="{{isset($news_item->image_card)? \Illuminate\Support\Facades\Storage::url($news_item->image_card) :''}}"
             id="image-card"
             class="max-h-40 object-cover">

        <div class="mb-5">
            <x-input-label>Изображение в шапке новости</x-input-label>
            <x-file-input id="img-header-input" wire:model.defer="image_header"/>
        </div>
        <div class="text-right mb-5"> @error('image_header')
            <small class="text-red-900">{{ $message }}</small>
            @enderror
        </div>
        <img wire:ignore
             src="{{isset($news_item->image_header)? \Illuminate\Support\Facades\Storage::url($news_item->image_header) : ''}}"
             id="image-header"
             class="max-h-40 object-cover">

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
    <script>
        $(document).ready(function (e) {
            $('#img-card-input').change(function () {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#image-card').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
            $('#img-header-input').change(function () {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#image-header').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
@endpush
