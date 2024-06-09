<div x-data="{faq_open:false}">
    @if($project->user_id == Auth::id())
        <div class="add-news-block">
            <a class="btn text-center cursor-pointer w-40"
               href="{{ route('project.faqs',[ 'project' => $project->id]) }}"> Вопросы пользователей
            </a>
        </div>
    @endif
    <div class="mt-5">
        @foreach($project_faq as $faq)
            <div x-data="{ expanded: false }" class="border-b-2  p-2 border-gray-200">
                <div @click="expanded = !expanded"
                     class="cursor-pointer duration-300 rounded-lg flex justify-between">
                    <div class="text-xl font-medium text-gray-700">{{$faq->question}}</div>
                    <button type="button">
                        <i :class="expanded ? 'fas fa-chevron-up mt-1' : 'fas fa-chevron-down'"></i>
                    </button>
                </div>
                <div class="mb-5" x-show="expanded"
                     x-collapse.duration.500ms>{!! $faq->answer !!}</div>
            </div>
        @endforeach
    </div>
{{--    Вопросы пользователей--}}
    <div class="w-full">
        @guest
            <div class="text-center font-medium py-3">
                Для того чтобы задать свой вопрос,
                <a class="text-accent-blue hover:underline" href="{{ route('login') }}"> войдите в
                    аккаунт</a> или
                <a class="text-accent-blue hover:underline" href="{{ route('register') }}">
                    зарегистрируйтесь</a>
            </div>
        @endguest
        @auth
            <div x-show="!faq_open" class="w-1/2 mx-auto p-4 mt-2">
                <p class="font-medium">Остались вопросы?</p>
                <small>Вы можете задать вопрос автору проекта и получить интересующую вас
                    информацию</small>
                <div class="w-full" @keydown.escape="faq_open = false">
                    <div @click="faq_open = true"
                         class="ask-question w-full btn-save hover:bg-blue-50 hover:text-blue-400 mx-auto cursor-pointer py-2 px-2">
                        Задать вопрос
                    </div>
                </div>
            </div>
    </div>
    @if (session()->has('faq_msg'))
        <x-success-alert :message="session('faq_msg')"></x-success-alert>
    @endif
{{--    Форма для вопроса--}}
    <div class="w-full" x-show="faq_open" x-transition.duration.500ms>
        <form wire:submit.prevent="saveFaq" class="p-4 mx-auto shadow-lg mt-5">
            <div class="mb-2">
                <x-input-label>Напишите ваш вопрос или предложение к автору:</x-input-label>
                <textarea wire:model.defer="faq_text" class="description shadow-sm mt-1 block w-full"
                          rows="5"></textarea>
                @error('faq_text')
                <div class="text-right">
                    <small class="text-red-900">{{ $message }}</small>
                </div>
                @enderror
            </div>
            <div class="justify-between flex">
                <div @click="faq_open = false"
                     class="btn-save py-2 text-gray-400 cursor-pointer hover:text-gray-700 hover:bg-gray-50 px-2 border-gray-400">
                    Закрыть
                </div>
                <button type="submit" class="btn-save py-2 px-2">Отправить
                </button>
            </div>
        </form>
        @endauth

    </div>
</div>
