<div class="col-span-6 card flex flex-col">
    <x-title class="ml-6">Блоки и карусели</x-title>
    <div class="flex-1 flex flex-col">
        <!-- news -->
        @foreach($blocks as $item)
            <div class="flex items-center  shadow-xs transition-all duration-300 ease-in-out p-5 hover:shadow-md">
                <a class="flex-1" href="{{route('blocks.edit', ['block' => $item->id])}}">
                    <p class="ml-6 font-medium">{{$item->name}}</p>
                </a>

                <div class="px-3">
                    <a href="{{ route('blocks.edit', ['block' => $item->id]) }}">
                        <button class="btn-edit">
                            изменить
                        </button>
                    </a>
                </div>
            </div>
    @endforeach
    <!-- news -->
    </div>

    <div class="card-footer flex">
        {{ $blocks->links() }}
    </div>

</div>
