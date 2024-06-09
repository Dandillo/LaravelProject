<div class="col-span-6 card flex flex-col">

    <x-title class="ml-6">Новости</x-title>
    <div class="px-3 border-b">
        <div class="flex">
            <a href="{{ route('news.create') }}" class="p-3 text-accent-blue hover:text-indigo-500">
                <i class="fa fa-plus"></i> Создать
            </a>
            <input class="p-3 flex-1 border-0 border-l-2" type="search" placeholder="Поиск по заголовку"
                   wire:model="search">
        </div>
    </div>
    <div class="flex-1 flex flex-col">
        <!-- news -->
        @foreach($news as $item)
            <div class="flex items-center  shadow-xs transition-all duration-300 ease-in-out p-5 hover:shadow-md">
                <a class="flex-1" href="{{url("news/$item->id")}}">
                    <p class="ml-6 font-medium">{{$item->title}}</p>
                </a>

                <p class="text-gray-900">Дата: {{$item->created_at->format('d.m.Y')}}</p>
                <div class="px-3 flex"  x-data="{ confirmDelete:false }">
                    <a href="{{ route('news.edit', ['news' => $item->id]) }}">
                        <button class="btn-edit mr-2">
                            изменить
                        </button>
                    </a>
                    <x-delete-button wire:click="delete({{ $item->id }})"></x-delete-button>
                </div>
            </div>
    @endforeach
    <!-- news -->
    </div>

    <div class="card-footer flex">
        {{ $news->links() }}
    </div>

</div>
