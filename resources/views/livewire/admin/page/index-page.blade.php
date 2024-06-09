<div class="col-span-6 card flex flex-col">

    <x-title class="ml-6">Страницы</x-title>
    <div class="px-3 border-b">
        <div class="flex">
            <a href="{{ route('page.create') }}" class="p-3 text-accent-blue hover:text-indigo-500">
                <i class="fa fa-plus"></i> Создать
            </a>
            <input class="p-3 flex-1 border-0 border-l-2" type="search" placeholder="Поиск по заголовку"
                   wire:model="search">
            <button type="submit" class="text-accent-blue p-3">
                <i class="fad fa-search"></i>
            </button>
        </div>
    </div>
    <div class="flex-1 flex flex-col">
        <!-- pages -->
        <table class="w-full">
            <thead>
            <tr class="text-left text-gray-900 border-b text-sm">
                <th class="px-4 py-3">Название</th>
                <th class="px-4 py-3">Дата создания</th>
                <th class="px-4 py-3">Статус</th>
                <th class="px-4 py-3">Управление</th>
            </tr>
            </thead>
            <tbody class="bg-white">
            @foreach($pages as $item)
                <tr class="text-gray-700">
                    <td class="px-4 py-3 border ">
                        <a class="flex-1" href="{{ route('page.edit', ['page' => $item->id]) }}">
                            <p class="ml-6 font-medium">{{$item->title}}</p>
                        </a>
                    </td>
                    <td class="px-4 py-3 text-sm border">
                        {{$item->created_at->format('d.m.Y')}}
                    </td>
                    <td class="px-4 py-3 text-sm border">
                        {{$item->is_public? 'Опубликована': 'Не опубликована'}}
                    </td>
                    <td class="px-4 py-3 flex-1 text-sm border">
                        <div class="px-3 flex">

                        <a href="{{  route('page.edit', ['page' => $item->id]) }}">
                                <button class="btn-edit mr-2">
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
    <!-- pages -->
    </div>

    <div class="card-footer flex">
        {{ $pages->links() }}
    </div>

</div>
