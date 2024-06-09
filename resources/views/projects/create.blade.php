@extends('layouts.app')

@section('content')
    <div class=" w-3/4 mx-auto">
        <x-title>Создать проект</x-title>

        <form>
            <div class="flex items-center mb-5">
                <x-input-label>Название проекта</x-input-label>
                <x-input type="text" id="name" name="name" placeholder="Название" class="flex-1"></x-input>
            </div>
            <div class="flex items-center mb-5">
                <x-input-label>Краткое описание проекта</x-input-label>
                <textarea class="flex-1" rows="6"></textarea>
            </div>
            <div class="flex items-center mb-5">
                <x-input-label>Фото для карточки проекта</x-input-label>
                <x-input type="file" class="flex-1"></x-input>
            </div>
            <div class="flex items-center mb-5">
                <x-input-label>Ссылка на промо видео</x-input-label>
                <x-input class="flex-1"></x-input>
            </div>
            <div class="flex items-center mb-5">
                <x-input-label>Финансовая цель</x-input-label>
                <x-input type="number" class="flex-1"></x-input>
            </div>
            <div class="flex items-center mb-5">
                <x-input-label>Тема проекта</x-input-label>
                <select class="flex-1">
                    <option>Тема 1</option>
                    <option>Тема 2</option>
                    <option>Тема 3</option>
                </select>
            </div>
            <div class="flex items-center mb-5">
                <x-input-label>Тэги проекта</x-input-label>
                <select class="flex-1">
                    <option>Тэг 1</option>
                    <option>Тэг 2</option>
                    <option>Тэг 3</option>
                </select>
            </div>
            <div class="flex items-center mb-5">
                <x-input-label>Регион</x-input-label>
                <select class="flex-1">
                    <option>Томск</option>
                    <option>США</option>
                    <option>Япония</option>
                </select>
            </div>

            <div class="flex items-center mb-5">
                <x-input-label>Подробное описание проекта</x-input-label>
                <textarea class="flex-1" rows="12"></textarea>
            </div>
            <div class="border-t-2 py-5">

                <div class="flex items-center mb-5">
                    <x-input-label>Заголовок вознаграждения</x-input-label>
                    <x-input type="text" id="name" name="name" placeholder="Название" class="flex-1"></x-input>
                </div>
                <div class="flex items-center mb-5">
                    <x-input-label>Краткое описание проекта</x-input-label>
                    <textarea class="flex-1" rows="6"></textarea>
                </div>
                <div class="flex items-center mb-5">
                    <x-input-label>Количество вознаграждений</x-input-label>
                    <x-input type="number" id="name" name="name" placeholder="Название" class="flex-1"></x-input>
                </div>
                <a class="border-accent-blue border-2 p-2" href="#">Добавить вознаграждение</a>

            </div>
            <div class="text-right">
                <button class="w-40 border-progress border-2 px-6 text-progress py-4
                    text-center hover:bg-progress hover:text-white">
                    Продолжить
                </button>
            </div>

        </form>
    </div>
@endsection
