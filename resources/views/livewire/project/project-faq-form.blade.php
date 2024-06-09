{{--Страница модерации FAQ Для автора--}}
<div class="mt-5">
    <x-title>Вопросы проекта:
        <a class="hover:underline hover:text-indigo-500"
           href="{{route('project.show', ['project'=> $project->id])}}">{{$project->title}}</a></x-title>
    @if (session()->has('faq_ans_msg'))
        <x-success-alert :message="session('faq_ans_msg')"></x-success-alert>
    @endif
    <h3 class="text-xl text-gray-400 mt-2">Опубликованные вопросы</h3>
    @foreach($project_faq as $faq)
        <form class="mb-2 border-b-2 pb-2" wire:submit.prevent="store({{$faq->id}})" x-data="{ show_form:false }">
            <div class="cursor-pointer duration-300 rounded-lg flex justify-between">
                <div class="font-medium text-gray-700">{{$faq->question}}</div>
                <div class="flex">
                    <div class="btn" @click="show_form=true" x-show="!show_form">Изменить ответ</div>
                    <div
                        class="btn-save py-2 text-gray-400 cursor-pointer hover:text-gray-700 hover:bg-gray-50 px-2 border-gray-400"
                        @click="show_form=false" x-show="show_form">Отменить
                    </div>
                    <button type="submit"
                            class="btn-save hover:bg-blue-50 hover:text-blue-400 mx-auto cursor-pointer py-2 px-2"
                            x-show="show_form">Изменить
                    </button>
                </div>
            </div>
            <div class="mb-2" x-show="show_form">
                <x-input-label>Напишите ответ на вопрос и нажмите кнопку опубликовать</x-input-label>
                <textarea wire:model.defer="faq_answer"  class="description shadow-sm mt-1 block w-full"
                          rows="5"> {{ $faq->answer }}</textarea>
                @error('faq_answer')
                <div class="text-right">
                    <small class="text-red-900">{{ $message }}</small>
                </div>
                @enderror
            </div>
        </form>
    @endforeach
    <h3 class="text-xl text-gray-400">Новые вопросы пользователей</h3>

    @foreach($faqs_to_moderate as $faq)
        <form  class="mb-2 border-b-2 pb-2" wire:submit.prevent="store({{$faq->id}})" x-data="{ show_form:false }">
            <div class="cursor-pointer duration-300 rounded-lg flex justify-between">
                <div class="font-medium text-gray-700">{{$faq->question}}</div>
                <div class="flex">
                    <div class="btn" @click="show_form=true" x-show="!show_form">Ответить</div>
                    <div
                        class="btn-save py-2 text-gray-400 cursor-pointer hover:text-gray-700 hover:bg-gray-50 px-2 border-gray-400"
                        @click="show_form=false" x-show="show_form">Отменить
                    </div>
                    <button type="submit"
                            class="btn-save hover:bg-blue-50 hover:text-blue-400 mx-auto cursor-pointer py-2 px-2"
                            x-show="show_form">Опубликовать
                    </button>
                </div>
            </div>
            <div class="mb-2" x-show="show_form">
                <x-input-label>Напишите ответ на вопрос и нажмите кнопку опубликовать</x-input-label>
                <textarea wire:model.defer="faq_answer" class="description shadow-sm mt-1 block w-full"
                          rows="5"></textarea>
                @error('faq_answer')
                <div class="text-right">
                    <small class="text-red-900">{{ $message }}</small>
                </div>
                @enderror
            </div>
        </form>
    @endforeach

    <div class="card-footer flex">
        {{ $faqs_to_moderate->links() }}
    </div>
</div>
