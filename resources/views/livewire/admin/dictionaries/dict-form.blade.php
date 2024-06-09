<div class="mx-auto bg-white p-4 rounded">
    <x-title>{{$model_name}}</x-title>

    <form id="dict-form" wire:submit.prevent={{$is_update? "update" : "store"}}>
        <div class="mb-3">
{{--            Форма ввода--}}
            <small>Добавить новый элемент</small>
            <div class="flex items-center ">
                <x-input wire:model.defer="name" type="text" placeholder="Название" class="flex-1"></x-input>
                <button type="submit" class="btn-save text-sm py-2">
                    {{$is_update? "Изменить" : "Добавить"}}
                </button>
            </div>
            @error('name')
            <div class="text-right"><small class="text-red-900">{{ $message }}</small></div>@enderror
        </div>
    </form>

    <div class="border-b">
        <div class="flex">
            <input class="p-3 flex-1 border-0 border-l-2" type="search" placeholder="Поиск по заголовку"
                   wire:model="search">
        </div>
    </div>

    <div class="flex-1 flex flex-col">
        <!-- pages -->
        <table class="w-full">
            <thead>
            <tr class="text-left text-gray-900 border-b text-sm">
                <th class="px-4 py-3">Название</th>
                <th class="px-4 py-3">Управление</th>
            </tr>
            </thead>
            <tbody class="bg-white">
            @foreach($items as $item)
                <tr class="text-gray-700 hover:shadow-md">
                    <td class="px-4 py-3">
                            <p class="ml-6 font-medium">{{$item->name}}</p>
                    </td>
                    <td class="px-4 py-3 flex-1 text-sm">
                        <div class="px-3 flex" x-data="{ confirmDelete:false }">
                            <a href="#dict-form">
                                <button type="submit" wire:click="edit({{ $item->id }})"
                                        class="btn-edit mr-2">
                                    изменить
                                </button>
                            </a>
                            <x-delete-button wire:click="delete({{ $item->id }})"></x-delete-button>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

    <div class="card-footer flex">
        {{ $items->links() }}
    </div>
</div>
