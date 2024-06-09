<div>
    <x-title>{{$is_update? 'Изменить': 'Создать'}} новость для проекта:
        <a class="underline hover:text-indigo-500"
           href="{{route('project.show', ['project'=> $project->id])}}">{{$project->title}}</a></x-title>
    <form wire:submit.prevent={{($is_update)? 'update': 'store'}}>
        <div class="my-5">
            <x-input-label>Заголовок новости</x-input-label>
            <x-input class="w-full" wire:model.defer="news_title" type="text"
                     placeholder="Заголовок"></x-input>
            @error('news_title')
            <div class="text-right"><small class="text-red-900">{{ $message }}</small></div>
            @enderror
        </div>
        <div class="mb-4" wire:ignore>
            <x-input-label>Текст новости</x-input-label>
            <textarea class="w-full news_desc border-gray-400 text-sm"
                      wire:model.debounce.99999ms="news_desc"
                      wire:key="news_desc"
                      placeholder="Введите текст новости"
                      rows="20"> </textarea>
        </div>
        @error('news_desc')
        <div class="text-right"><small class="text-red-900">{{ $message }}</small></div>
        @enderror
        <div class="flex items-center">
            <input wire:model.defer="is_pinned" type="checkbox"
                   class="form-checkbox w-4 h-4 text-accent-blue"/>
            <label for="is_pinned" class="block ml-2 text-sm text-gray-900 leading-5">
                Закрепить новость
            </label>
        </div>
        <div class="text-right">
            <button type="submit" class="btn-save">
                {{$is_update? 'Изменить': 'Сохранить'}}
            </button>
        </div>
    </form>
    @push('scripts')
        <script src="{{ asset('js/tinymce/tinymce.js') }}"></script>
        <x-tinymce :textname="'news_desc'"></x-tinymce>
    @endpush
</div>
