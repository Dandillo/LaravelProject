<div>
    @if($project->user_id == Auth::id())
        <div class="add-news-block">
            <a class="btn text-center cursor-pointer w-40"
               href="{{ route('project.news.create',[ 'project' => $project->id]) }}"> Добавить новость
            </a>
        </div>
    @endif
    {{-- Project news block--}}
    <div class="mt-5">
        @foreach($project_news as $news)
            <div
                class="border-b-2 p-2 border-gray-200 relative overflow-hidden transition-all ease-in duration-1000"
                x-data="{ expanded: false }">
                <div @click="expanded = !expanded"
                     class="cursor-pointer duration-300 rounded-lg flex justify-between">
                    <div class="text-xl font-medium text-gray-700">  {{$news->title}}</div>

                    <button type="button">
                        <i :class="expanded ? 'fas fa-chevron-up mt-1' : 'fas fa-chevron-down'"></i>
                    </button>

                </div>
                <small class="text-gray-400">{{$news->created_at->format('d.m.Y')}}</small>
                @if($project->user_id == Auth::id())
                    <a class="float-right"
                       href="{{ route('project.news.edit', ['project' => $project->id, 'news' => $news->id]) }}">
                        изменить <i class="fa fa-pen"></i>
                    </a>
                @endif
                <div class="mb-5" x-show="expanded"
                     x-collapse.duration.500ms>{!! $news->description !!}</div>
            </div>
        @endforeach
    </div>
    <div class="text-center">
        <div wire:loading class="animate-spin rounded-full h-10 w-10 border-b-4 border-accent-blue"></div>
    </div>

    @if((($news_count > 1) && ($news_on_page != $news_count))  && ($project_news->count() > 2))
        <div class="mt-2 text-center">
            <button wire:click="loadMoreNews" class="shadow-lg p-2 border-2 rounded">Загрузить еще</button>
        </div>
    @endif
    {{-- Project news block--}}
</div>
