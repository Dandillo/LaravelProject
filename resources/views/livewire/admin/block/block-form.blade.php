<div class="col-span-6 card flex flex-col  p-4 rounded">
    <x-title>{{$block->name}}</x-title>

    <form wire:submit.prevent="save">
        @for($i = 0; $i < $block->count; $i++)
            <div class="mb-4 flex">
                <div class="flex-auto">
                    <x-input-label>Проект {{$i+1}}</x-input-label>
                    <x-select wire:model.defer="pinned_projects.{{$i}}" class="border border-gray-300">
                        <option value="">Не выбрано</option>
                        @foreach($projects as $project)
                            <option value="{{$project->id}}">{{ $project->title }}</option>
                        @endforeach
                    </x-select>
                </div>
                <div class="flex-auto ml-3">
                    <x-input-label>Вес</x-input-label>
                    <x-input type="number" wire:model.defer="weight.{{$i}}" ></x-input>
                </div>
            </div>
            @error("pinned_projects[$i]")
            <div class="text-right"><small class="text-red-900">{{ $message }}</small></div>
            @enderror
        @endfor
        <div class="text-right">
            <button type="submit" class="w-40 text-xs px-3 py-2 btn-save">
                Сохранить
            </button>
        </div>
    </form>

</div>
