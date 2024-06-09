<div>
    <div id="main-project-info" class="mx-3">
        {{--        Тэги проекта--}}
        <div class="mt-3">
            @if($project->category)
                <a href="{{route('project.index', ['category_id'=> $project->category_id])}}">
                    <x-button class="border-progress text-progress capitalize">{{ $project->category->name }}</x-button>
                </a>
            @endif
            @if($project->region)
                <a href="{{route('project.index', ['region_id'=> $project->region_id])}}">
                    <x-button class="border-progress text-progress capitalize">{{ $project->region->name }}</x-button>
                </a>
            @endif
            @foreach($project->tags as $tag)
                <a href="{{route('project.index', ['tag_id'=> $tag->id])}}">
                    <x-button class="border-progress text-progress capitalize">{{ $tag->name }}</x-button>
                </a>
            @endforeach
        </div>
        {{--       End Тэги проекта --}}

        <x-title>
            {{ $project->title }}
        </x-title>

        {{--        Статус проекта --}}
        @if($project->user_id == Auth::id())
            <x-project-status-label>{{ $project->status->name ?? '' }}</x-project-status-label>
        @elseif( $project->status_id == 4)
            <x-project-status-label>{{ \App\Models\Dictionaries\ProjectStatus::find(3)->name ?? '' }}</x-project-status-label>

        @elseif( $project->status_id == 6)
            <x-project-status-label>{{\App\Models\Dictionaries\ProjectStatus::find(5)->name ?? '' }}</x-project-status-label>
        @else
            <x-project-status-label>{{ $project->status->name ?? '' }}</x-project-status-label>
        @endif
        {{--       End Статус проекта --}}

        <div class="w-full mt-3">
            <div>
                <p class="text-sm mb-3 text-gray-800">
                    {!! $project->short_desc !!}
                </p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3">
            @isset($project->video)
                <div id="player" class="md:col-span-2 p-4"></div>
            @else
                <div class="bg-cover bg-center h-72 p-4 md:col-span-2"
                     style="background-image: url('{{$project->image_header? \Illuminate\Support\Facades\Storage::url($project->image_header)
                                        : "https://source.unsplash.com/1600x900/?cat-" .$project->id}}')">
                </div>
            @endisset
            <div class="p-4">
                <div class="mb-2">
                    <p class="text-3xl text-gray-900">{{ $project->amount }} ₽</p>
                </div>
                <div>
                    <div class="relative w-full bg-gray-200 rounded">
                        <div style="width: {{($percent >= 100)? 100: $percent}}%"
                             class="relative top-0 h-4 rounded bg-progress"></div>
                    </div>
                    <div class="mt-2 uppercase font-semibold">
                        Собрано {{ $sum }} руб
                        <div class="float-right">
                            {{$percent}} %
                        </div>
                    </div>
                </div>
                <div class="text-gray-400 mt-3">
                    <div>
                        Поддержали
                        <div
                            class="text-gray-700 font-medium float-right">{{ $project->shareholders->unique()->count() }}
                            чел.
                        </div>
                    </div>
                    <div>
                        Стартовал
                        <div
                            class="text-gray-700 font-medium float-right">{{ $project->created_at->translatedFormat('j F') }}</div>
                    </div>
                    <div>
                        Осталось
                        <div class="text-gray-700 font-medium float-right">
                            {{ \Carbon\Carbon::parse($project->end_date)->diffInDays(now()) }} дн.
                        </div>
                    </div>
                </div>
                {{--    Поддержать проект--}}
                <div class="mt-6 text-center">
                    @if($project->status_id == 2)
                        <a href="{{ route('projects.payment', ['project' => $project->id]) }}">
                            <button class="w-full border-progress border-2 px-6 text-progress py-4
                    text-center hover:bg-progress hover:text-white">
                                Поддержать
                            </button>
                        </a>
                    @elseIf($project->status_id == 3 || $project->status_id == 4)
                        <button class="w-full border-gray-400 border-2 px-6 text-gray-700 py-4
                    text-center">
                            Завершен
                        </button>
                    @elseIf($project->status_id == 5 || $project->status_id == 6)
                        <button class="w-full border-gray-400 border-2 px-6 text-gray-700 py-4
                    text-center">
                            Отменен
                        </button>
                    @endif
                </div>
                {{--   End Поддержать проект--}}

            </div>
        </div>
        {{--    Автор проекта--}}
        <div id="author-block" class="mt-5 py-3 border-b border-t border-gray-300">
            <div class="flex">
                <img class="object-cover w-20 h-20 rounded-full shadow-lg"
                     src="{{ isset($project->author->photo)?
                            \Illuminate\Support\Facades\Storage::url($project->author->photo):asset('def-user.svg') }}">
                <div class="pl-2">
                    <p class="uppercase text-gray-400 text-sm">Автор</p>
                    <a href="{{ route('user.page', ['user'=> $project->author->id]) }}">
                        <p class="font-semibold">{{ $project->author->name }}</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{-- End Автор проекта--}}

    {{--tabs block--}}
    <div x-data="setup()" class="mt-3 mx-3">
        <div class="md:flex">
            <template x-for="(tab, index) in tabs" :key="index">
                <button class="border-2 mt-2 md:mt-0 mr-3 transtition-all duration-150 px-3 py-2 items-center font-bold"
                        :class="activeTab===index ? ' btn text-base hover:bg-dropdown-blue' : 'hover:bg-tab-inactive hover:text-white'"
                        @click="activeTab = index"
                        x-text="tab"></button>
            </template>

            <div class="relative group">
                <div class="relative inline-flex items-center justify-between space-x-2">
                    <div class="inline group py-2 text-gray-400 hover:text-gray-700 cursor-pointer">
                        <a href="{{ route('report', ['project' => $project->id]) }}"><i class="fa fa-ban"></i></a>
                        <div
                            class="invisible group-hover:visible absolute top-0 left-8 z-10 space-y-1 text-sm rounded px-4 py-2 shadow-md"
                            role="tooltip" aria-hidden="true">
                            <p>Пожаловаться на проект</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="grid grid-cols-3 mt-3">
            <div id="block-info" class="sm:col-span-2 col-span-3 mr-2">
                {{-- desc--}}
                <div x-show="activeTab===0">{!! $project->description !!}  </div>

                {{--News--}}
                <div x-show="activeTab===1">
                    @livewire('project.news-block', ['project' => $project])
                </div>
                {{--FAQ--}}
                <div x-show="activeTab===2" class="w-full">
                    @livewire('project.faqs-block', ['project' => $project])

                </div>
                <div x-show="activeTab===3">
                    <div class="mt-5">
                        {{--Create comment form--}}
                        @guest
                            <div class="text-center font-medium py-3">
                                Для того чтобы написать комментарий,
                                <a class="text-accent-blue hover:underline" href="{{ route('login') }}"> войдите в
                                    аккаунт</a> или
                                <a class="text-accent-blue hover:underline" href="{{ route('register') }}">
                                    зарегистрируйтесь</a>
                            </div>
                        @endguest
                        @auth
                            @if (session()->has('com_msg'))
                                <x-success-alert :message="session('com_msg')"></x-success-alert>
                            @endif
                            <form id="dict-form" wire:submit.prevent="saveComment">
                                <div class="mb-3">
                                    <div class="flex items-center ">
                                        <x-input wire:model.defer="comment_text" type="text" placeholder="Комментарий"
                                                 class="flex-1"></x-input>
                                        <button type="submit" class="btn-save py-2 text-sm">
                                            Добавить
                                        </button>
                                    </div>
                                    @error('comment_text')
                                    <div class="text-right"><small class="text-red-900">{{ $message }}</small>
                                    </div>
                                    @enderror
                                </div>
                            </form>
                        @endauth
                        {{--Create comment form--}}

                        {{--Project comments block--}}
                        @foreach($project_comments as $comment)
                            <div
                                class="flex mb-3 border-b-2 pb-1 @if($comment->user->id == $project->user_id) bg-blue-50 @endif">
                                <div>
                                    <img class="w-9 h-10 object-cover rounded-full"
                                         src="{{isset($comment->user->photo)?
                            \Illuminate\Support\Facades\Storage::url($comment->user->photo):asset('def-user.svg')}}">
                                </div>
                                <div class="text-sm ml-2">
                                    <div class="text-gray-700"> {{ $comment->user->name }} <small
                                            class="text-gray-400">{{ $comment->created_at->format('d.m') }}</small>
                                    </div>
                                    <div class="mt-1">
                                        {{ $comment->text }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{-- End Project comments block--}}
                    </div>
                </div>
                <div x-show="activeTab===4">
                    @foreach($shareholders as $user)
                        <a class="flex mb-3 border-b-2 pb-1 cursor-pointer"
                           href="{{ route('user.page', ['user'=> $user->id]) }}">
                            <img class="w-9 h-10 object-cover rounded-full"
                                 src="{{isset($user->photo)?
                            \Illuminate\Support\Facades\Storage::url($user->photo):asset('def-user.svg')}}">
                            <div class="text-sm ml-2 my-auto">
                                <p>{{ $user->name }}</p>
                            </div>
                        </a>
                    @endforeach
                    {{ $shareholders->links() }}
                </div>
            </div>
            {{--    Awards--}}
            <div id="awards" class="hidden sm:block">
                <p class="text-2xl">Вознаграждение</p>
                @if($project->status_id == 2)
                    <div class="award-item border-2 p-4 mt-2">
                        <p class="font-medium">Поддержать проект</p>
                        <small> Поддержать проект, без получения вознаграждения</small>

                        <a href="{{ route('projects.payment', ['project' => $project->id]) }}">
                            <button class="w-full mt-3 transition duration-150 border-progress border-2 px-6 text-progress py-2
                    text-center hover:bg-progress hover:text-white">
                                От 100 руб
                            </button>
                        </a>
                    </div>
                @endif
                @foreach($awards as $award)
                    <div class="award-item border-2 p-4 mt-2">
                        <div class="font-medium">{{ $award->title }}
                            @if($award->quantity)
                                <div class="float-right font-sans text-gray-400">Осталось {{ $award->quantity }}</div>
                            @endif
                        </div>
                        <small>{{ $award->description }}</small>
                        @if($project->status_id == 2 || $project->status_id == 1)
                            <a href="{{ route('projects.payment', ['project' => $project->id, 'award' => $award->id]) }}">
                                <button class="w-full mt-3 transition duration-150 border-progress border-2 px-6 text-progress py-2
                    text-center hover:bg-progress hover:text-white">
                                    {{ $award->min_cost }} руб
                                </button>
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
            {{--  End Awards--}}
        </div>
    </div>
    @push('scripts')
        @isset($project->video)
            <script>
                var tag = document.createElement('script');

                tag.src = "https://www.youtube.com/iframe_api";
                var firstScriptTag = document.getElementsByTagName('script')[0];
                firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                // 3. This function creates an <iframe> (and YouTube player)
                //    after the API code downloads.
                var player;
                @php
                    $video_id = explode('v=', $project->video);

                @endphp
                function onYouTubeIframeAPIReady() {
                    player = new YT.Player('player', {
                        height: '300',
                        width: '837',
                        videoId: '{{ $video_id[1] }}',
                        events: {
                            'onReady': onPlayerReady,
                        }
                    });
                }

                // 4. The API will call this function when the video player is ready.
                function onPlayerReady(event) {
                    event.target.playVideo();
                }

                function stopVideo() {
                    player.stopVideo();
                }
            </script>
        @endisset
        <script type="text/javascript">
            function setup() {
                return {
                    faq_open: false,
                    activeTab: 0,
                    tabs: [
                        "Описание",
                        "Новости",
                        "FAQ",
                        "Комментарии",
                        "Поддержавшие проект",
                    ]
                };
            };


        </script>
    @endpush
</div>
