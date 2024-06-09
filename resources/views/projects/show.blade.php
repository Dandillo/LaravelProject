@extends('layouts.app')

@section('content')
    <div id="main-project-info">
        <div class=" mt-3">
            <a href="#popular-projects">
                <x-button class="border-progress text-progress">Дом</x-button>
            </a>
            <a href="#relevant-projects">
                <x-button class="border-progress text-progress">Москва</x-button>
            </a>
        </div>
        <x-title>
            Герой России космонавт Сергей Рязанский рассказал студентам о командной работе
        </x-title>
        <small class="font-semibold uppercase border-progress border p-1 text-progress"> идет сбор</small>

        <div class="w-full mt-3">
            <div>
                <p class="text-sm mb-3 text-gray-800">
                    Российская делегация сообщила о возросшей доле женщин-ученых в РАН
                    В рамках II Международной научно-практической конференции «Наука. Лидерство. Общество 2050» Центра
                    развития компетенций Западно-Сибирского межрегионального научно-образовательного центра мирового
                    уровня при поддержке Правительства Тюменской области в Тюменском государственном университете прошла
                    встреча с космонавтом Сергеем Рязанским.
                </p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3">
            <div class="bg-cover bg-center h-72 p-4 md:col-span-2"
                 style="background-image: url(https://images.unsplash.com/photo-1475855581690-80accde3ae2b?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=750&q=80)">
            </div>
            <div class="p-4">
                <div class="mb-2">
                    <p class="text-3xl text-gray-900">150000$</p>
                </div>
                <div>
                    <div class="relative w-full bg-gray-200 rounded">
                        <div style="width: 60%" class="relative top-0 h-4 rounded bg-progress"></div>
                    </div>
                    <div class="mt-2 uppercase font-semibold">
                        Собрано 110 руб
                        <div class="float-right">
                            55%
                        </div>
                    </div>
                </div>
                <div class="text-gray-400 mt-3">
                    <div>
                        Поддержали
                        <div class="text-gray-700 font-medium float-right">10 000 раз</div>
                    </div>
                    <div>
                        Стартовал
                        <div class="text-gray-700 font-medium float-right">10 ноября</div>
                    </div>
                    <div>
                        Осталось
                        <div class="text-gray-700 font-medium float-right"> 25 дней</div>
                    </div>
                </div>
                <div class="mt-6 text-center">
                    <a href="#">
                    <button class="w-full border-progress border-2 px-6 text-progress py-4
                    text-center hover:bg-progress hover:text-white">
                        Поддержать
                    </button>
                    </a>
                </div>
            </div>
        </div>
        <div id="author-block" class="mt-5 py-3 border-b border-t border-gray-300">
            <div class="flex">
                <img class="object-cover w-20 h-20 shadow-lg"
                     src="https://images.ctfassets.net/2lkzb2q71pmj/AQKz1EM0Bww96ROcbLuDr/243023a253283c7ba73c2d20bdfb3259/front__1_.png">
                <div class="pl-2">
                    <p class="uppercase text-gray-400 text-sm">Автор</p>
                    <p class="font-semibold">Имя автора</p>
                </div>
            </div>
        </div>
    </div>

    <div x-data="setup()" class="mt-3">
        <div class="flex">
            <template x-for="(tab, index) in tabs" :key="index">
                <button class="border-2 hover:bg-tab-inactive mr-3
            transtition-all duration-150 hover:text-white px-3 py-2 items-center font-bold"
                    :class="activeTab===index ? ' border-accent-blue text-accent-blue' : ''" @click="activeTab = index"
                    x-text="tab"></button>
            </template>
        </div>
        <div class="grid grid-cols-3 mt-3">
            <div id="block-info" class="col-span-2">
                    <div x-show="activeTab===0">Описание</div>
                    <div x-show="activeTab===1">FAQ</div>
                    <div x-show="activeTab===2">Новости</div>
                    <div x-show="activeTab===3">Комментарии</div>
                    <div x-show="activeTab===4">Участники</div>
            </div>
            <div id="awards">
                <p class="text-2xl">Вознаграждение</p>
                <div class="award-item border-2 p-4 mt-2">
                    <p class="font-medium">Поддержать проект</p>
                    <small> Поддержать проект, без получения вознаграждения</small>

                    <a href="#">
                        <button class="w-full mt-3 transition duration-150 border-progress border-2 px-6 text-progress py-2
                    text-center hover:bg-progress hover:text-white">
                            От 100 руб
                        </button>
                    </a>
                </div>
                <div class="award-item border-2 p-4 mt-2">
                    <div class="font-medium">Светильник для дома
                        <div class="float-right font-sans text-gray-400">Осталось 10</div>
                    </div>
                    <small>Получите новый светильник IKEA для дома</small>

                    <a href="#">
                        <button class="w-full mt-3 transition duration-150 border-progress border-2 px-6 text-progress py-2
                    text-center hover:bg-progress hover:text-white">
                            600 руб
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setup() {
            return {
                activeTab: 0,
                tabs: [
                    "Описание",
                    "FAQ",
                    "Новости",
                    "Комментарии",
                    "Поддержавшие проект",
                ]
            };
        };
    </script>


@endsection
