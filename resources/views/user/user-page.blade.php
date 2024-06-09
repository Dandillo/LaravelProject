@extends('layouts.app')

@section('content')
    {{--User block--}}
    <div id="author-block" class="mt-5 py-3 border-b border-t border-gray-300">
        <div class="flex text-gray-400">
            <img class="object-cover w-20 h-20 rounded-full shadow-lg"
                 src="{{ isset($user->photo)?
                            \Illuminate\Support\Facades\Storage::url($user->photo) : asset('def-user.svg') }}">
            <div class="pl-2">
                <p class="uppercase text-gray-400 text-sm">Пользователь</p>
                <p class="font-semibold">{{ $user->name }}</p>
                <p>На сайте с {{$user->created_at->format('m.Y')}}</p>
                @isset($user->about)
                    <div>
                        <small class="text-sm">О себе</small>
                        <div class="text-gray-500">
                            {{$user->about}}
                        </div>
                    </div>
                @endisset
            </div>
        </div>

    </div>
    {{--tabs block--}}
    <div x-data="setup()" class="mt-3">
        <div class=" sm:grid-cols-2 md:grid-cols-4 gap-6 grid">
            <template x-for="(tab, index) in tabs" :key="index">
                <button class="hover:bg-gray-50 shadow" @click="activeTab = index">
                    <div class="hover:bg-dropdown-blue p-3 flex">
                        <div class="mr-1.5 block w-0 border-2 h-5"
                             :class="activeTab===index  ? ' border-accent-blue bg-accent-blue ' : ''"></div>
                        <div x-text="tab[0]"></div>
                    </div>
                    <div class="p-3 text-sm text-gray-400" x-text="tab[1]"></div>
                </button>
            </template>
        </div>
        <div class="w-full mt-3">
            <div id="block-info" class="col-span-2 mr-2">
                {{--Supported Projects--}}
                <div x-show="activeTab===0">
                    @if($supported_projects->count() == 0)
                        <h3 class="text-center text-xl text-gray-400">Нет проектов</h3>
                    @else
                        <x-grid-card>
                            @foreach($supported_projects as $project)
                                <x-project-card :project="$project" :nosum="true"></x-project-card>
                            @endforeach
                        </x-grid-card>
                    @endif

                </div>

                {{--Created projects--}}
                <div x-show="activeTab===1">
                    @if($created_projects->count() == 0)
                        <h3 class="text-center text-xl text-gray-400">Нет проектов</h3>
                    @else
                        <x-grid-card>
                            @foreach($created_projects as $project)
                                <x-project-card :project="$project" :nosum="true"></x-project-card>
                            @endforeach
                        </x-grid-card>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <script>
        function setup() {
            return {
                activeTab: 0,
                tabs: [
                    ["Поддержанные проекты", "Список поддержанных проектов"],
                    ["Созданные проекты", "Список созданных проектов"],
                ]
            };
        };
    </script>
@endsection
