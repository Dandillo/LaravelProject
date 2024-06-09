<div class="px-3">
    @push('scripts')
        {{--        Подключение select2--}}
        <script src="{{ url('js/select2.js') }}"></script>
    @endpush
    @if($carousel_projects->count() > 0)
        <x-carousel :projects="$carousel_projects"></x-carousel>
    @endif
    <div>
        <x-title>Проекты</x-title>

        <div class="sm:flex grid grid-cols-2">
            <div class="inline-block relative w-48 pr-1">
                <x-select2-list :modelname="'category_id'" :dict="$categories"
                                :label="'по категории'" :valId="$category_id"/>
            </div>
            <div class="inline-block relative w-56 pr-1">
                <x-select2-list :modelname="'region_id'" :dict="$regions"
                                :label="'по региону'" :valId="$region_id"/>
            </div>
            <div class="inline-block relative w-40 pr-1 sm:mt-0 mt-1">
                <x-select2-list :modelname="'tag_id'" :dict="$tags"
                                :label="'по тэгу'" :valId="$tag_id"/>
            </div>
            <input class="py-1 border-0 flex-1 sm:mt-0 mt-1" type="search" placeholder="Поиск по заголовку..."
                   wire:model.defer="query">
            <div wire:click="$emitUp('search')" class="px-2 col-span-2 text-right mr-2 my-auto cursor-pointer"><i
                    class="fas fa-search hover:text-blue-500"></i></div>
        </div>

    </div>

    <div id="projects">
        @if($projects->count() == 0)
            <h3 class="text-center text-xl text-gray-400 mt-5">В этом разделе пока нет новых проектов</h3>
        @endif
        <x-grid-card>
            @foreach($projects as $project)
                <x-project-card :project="$project"></x-project-card>
            @endforeach
        </x-grid-card>

        <div class="card-footer flex">
            {{ $projects->links() }}
        </div>
    </div>
</div>
