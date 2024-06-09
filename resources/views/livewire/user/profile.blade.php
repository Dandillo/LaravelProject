<div x-data="setup()" class="mt-5 px-2">
    <div class="flex">
        <div class="bg-cover rounded-full bg-center p-4 w-14 h-14 shadow-2xl"
             style="background-image: url('{{ isset(Auth::user()->photo)?
                    \Illuminate\Support\Facades\Storage::url(Auth::user()->photo): asset('def-user.svg')}}')">
        </div>
        <div class="ml-3">
            <h5 class="font-bold">{{ Auth::user()->name }}</h5>
            <a class="text-sm text-accent-blue hover:underline" href="{{ route('user.profile.edit') }}">Редактировать
                профиль</a>
        </div>
    </div>
    @if (session()->has('project_msg'))
        <div class="mt-2">
            <x-success-alert :message="session('project_msg')"></x-success-alert>
        </div>
    @endif
    @if (session()->has('err_msg'))
        <div class="mt-2">
            <x-error-alert :message="session('err_msg')"></x-error-alert>
        </div>
    @endif
    <div class="mt-6 grid sm:grid-cols-2 md:grid-cols-4 gap-8">
        <div class="shadow hover:bg-gray-50">
            <a href="{{ route('project.create') }}">
                <div class="hover:bg-dropdown-blue p-3">Создать проект</div>
                <div class="p-3 text-sm text-gray-400 text-center">Создайте краудфандинговый проект</div>
            </a>
        </div>
        <template x-for="(tab, index) in tabs" :key="index">
            <button class="hover:bg-gray-50 shadow" @click="activeTab = index">
                {{--                <a href="{{ route('user.profile', 'awards') }}">--}}
                <div class="hover:bg-dropdown-blue p-3 flex">
                    <div class="mr-1.5 block w-0 border-2 h-5"
                         :class="activeTab===index  ? ' border-accent-blue bg-accent-blue ' : ''"></div>
                    <div x-text="tab[0]"></div>
                </div>
                <div class="p-3 text-sm text-gray-400" x-text="tab[1]"></div>
                {{--                </a>--}}
            </button>
        </template>
    </div>
{{--    Блок проектов пользователя--}}
    <div x-show="activeTab===0">
        <div class="mt-5">
            @if($projects->count() == 0)
                <h3 class="text-center text-xl text-gray-400 mt-5">У вас еще нет своих проектов, но можете попробовать
                    прямо сейчас
                    <a href="{{route('project.create')}}" class="text-accent-blue cursor-pointer">создать проект</a>
                </h3>
            @else
                <table class="w-full">
                    <thead>
                    <tr class="text-left text-gray-900 border-b text-sm">
                        <th class="px-4 py-3">№</th>
                        <th class="px-4 py-3">Название</th>
                        <th class="px-4 py-3 sm:block hidden">Необходимая сумма</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                    </thead>
                    <tbody class="bg-white">
                    @foreach($projects as $index=>$project)
                        <tr class="text-gray-700">
                            <td class="px-4 py-3 border">
                                <div class="flex items-center text-sm">
                                    {{ $index+1 }}
                                </div>
                            </td>
                            <td class="px-4 py-3 border ">
                                <a href="{{ route('project.show', ['project'=> $project->id]) }}"
                                   class=" items-center text-sm">
                                    {{ $project->title }}
                                    <x-project-status-label>{{ $project->status->name?? 'Создается' }}</x-project-status-label>

                                </a>
                                <a class="float-right" href="{{ route('project.edit', ['project'=> $project->id]) }}">
                                    <i class="fa fa-pen"></i></a>
                            </td>
                            <td class="px-4 py-3 text-sm sm:table-cell hidden border">{{$project->amount}} руб.</td>
                            <td class="px-4 py-3 text-sm border">
                                <div class="grid grid-cols-1 text-center lg:grid-cols-2">
                                    @if(in_array($project->status_id, [2,3]))
                                        <x-change-button wire:click="end_collect({{$project->id}})">
                                            завершить сбор
                                        </x-change-button>
                                    @endif
                                    @if(in_array($project->status_id, [2,3,5]))
                                        <div x-data="{ confirmDelete:false }" class="lg:mt-0 mt-2">
                                            <button x-show="!confirmDelete" x-on:click="confirmDelete=true"
                                                    class="btn-delete">отменить проект
                                            </button>
                                            <button x-show="confirmDelete" x-on:click="confirmDelete=false"
                                                    wire:click="cancel_collect({{$project->id}})" class="btn-success">Да
                                            </button>
                                            <button x-show="confirmDelete" x-on:click="confirmDelete=false"
                                                    class="btn border-gray-400 text-gray-400">Нет
                                            </button>
                                        </div>
                                    @endif
                                </div>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    {{--   End Блок проектов пользователя--}}
    {{--   Блок поддержанных проектов--}}
    <div x-show="activeTab===1">
        <div class="text-right mt-2">
            <a href="{{ route('user.profile.payments') }}"
               class="font-medium cursor-pointer text-sm text-accent-blue hover:underline hover:text-indigo-500">история платежей</a>
        </div>
        @if($supported_projects->count()==0)
            <h3 class="text-center text-xl text-gray-400 mt-5">Вы не поддержали еще ни одного проекта </h3>
        @else
            <x-grid-card>
                @foreach($supported_projects as $project)
                    <x-project-card :project="$project" :nosum="true"></x-project-card>
                @endforeach
            </x-grid-card>
        @endif
    </div>
    {{--   End Блок поддержанных проектов--}}
    {{--    Блок вознаграждений--}}
    <div x-show="activeTab===2">
        @if($awards->count()==0)
            <h3 class="text-center text-xl text-gray-400 mt-5">Вы еще не приобрели вознаграждения </h3>
        @else
            <table class="w-full">
                <thead>
                <tr class="text-left text-gray-900 border-b text-sm">
                    <th class="px-4 py-3">№</th>
                    <th class="px-4 py-3">Название</th>
                    <th class="px-4 py-3">Проект</th>
                    <th class="px-4 py-3">Статус оплаты</th>
                    <th class="px-4 py-3 sm:block hidden">Стоимость</th>
                </tr>
                </thead>
                <tbody class="bg-white">
                @foreach($awards as $index=>$award)
                    <tr class="text-gray-700">
                        <td class="px-4 py-3 border">
                            <div class="flex items-center text-sm">
                                {{ $index+1 }}
                            </div>
                        </td>
                        <td class="px-4 py-3 border ">
                            <a href="{{ route('project.show', ['project'=> $award->project_id]) }}"
                               class=" items-center text-sm">
                                {{ $award->title }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-sm sm:table-cell hidden border">
                            <a href="{{ route('project.show', ['project'=> $award->project->id]) }}"
                               class=" items-center text-sm">
                                {{ $award->project->title }}
                                <x-project-status-label>{{ $award->project->status->name?? 'Создается' }}</x-project-status-label>
                            </a>
                        </td>
                        <td class="px-4 py-3 text-sm sm:table-cell hidden border">
                            <x-payment-status-label :status="$award->payment_status">
                                {{ $award->payment_status }}
                            </x-payment-status-label>
                        </td>
                        <td class="px-4 py-3 text-sm sm:table-cell hidden border">{{$award->min_cost}} руб.</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
    {{--    End Блок вознаграждений--}}

    <script>
        let tab = 0;
        if (document.location.href.indexOf('awards') != -1) {
            tab = 2;
        }

        function setup() {
            return {
                activeTab: tab,
                tabs: [
                    ["Созданные проекты", "Список ваших проектов"],
                    ["Поддержанные проекты", "Проекты, которые вы поддержали"],
                    ["Вознаграждения", "Ваши возанаграждения за проект"],
                ]
            };
        };
    </script>
</div>
