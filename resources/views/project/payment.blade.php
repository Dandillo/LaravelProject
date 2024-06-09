@extends('layouts.app')

@section('content')

    <div class="py-2">
        <x-title>
            <a href="{{ route('project.show', ['project' =>$project->id]) }}"
               class="hover:underline"
               target="_blank">Поддержать проект: {{$project->title}}</a>
        </x-title>
        <div class="w-full mt-3">
            <div>
                <p class="text-sm mb-3 text-gray-800">
                    {!! $project->short_desc !!}
                </p>
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
        {{-- End Автор проекта--}}
    </div>
    @if (session()->has('err_msg'))
        <x-error-alert :message="session('err_msg')"></x-error-alert>
    @endif
    <div class="mx-auto md:grid-cols-2 grid-cols-1 grid mt-5">
        <div class="radio" x-data="{ activeTab: {{$checked_award ?? '-1'}}  }">
            <form method="POST" action="{{route('projects.payment.yoo', ['project' =>$project->id])}}">
                {{ csrf_field() }}
                @error('amount')
                <div class="py-2">
                    <x-error-alert :message="$message"></x-error-alert>
                </div>
                @enderror
                <input type="radio" id="award" class="radio-input" value="" name="award_id" @click="activeTab = -1"
                       @if($checked_award == null) checked @endif>
                <label for="award"
                       class="block mb-2 text-center px-4 py-3 bg-white border-grey border-solid border-4">
                    <div class="font-medium mb-1">Поддержать на любую сумму</div>
                    <small class="mb-2">Отправка пожертвования без вознаграждения</small>
                    <div class="w-full mx-auto">
                        <small class="text-gray-400">минимальная сумма 100 руб.</small>
                    </div>
                    <div x-show="activeTab===-1" x-collapse.duration.500ms>
                        <x-input min="100" type="number" class="md:w-1/2 w-full" name="amount[-1]"
                                 placeholder="Введити сумму, от 100 руб."></x-input>
                        <button type="submit" class="btn-save text-sm py-2">Оплатить</button>
                    </div>
                </label>

                @foreach($awards as $item)
                    <input type="radio" id="award-{{$item->id}}" value="{{$item->id}}" class="radio-input"
                           @click="activeTab = {{$item->id}}" name="award_id"
                           @if($checked_award == $item->id) checked @endif>
                    <label for="award-{{$item->id}}"
                           class="block mb-2 text-center px-4 py-3 bg-white border-grey border-solid border-4">
                        <div class="font-medium mb-1">{{ $item->title }}</div>
                        <small class="mb-2">{{ $item->description }}</small>
                        <div class="w-full mx-auto">
                            <small class="text-gray-400">минимальная стоммость от {{$item->min_cost}} руб.</small>
                        </div>
                        <div x-show="activeTab==={{$item->id}}" x-collapse.duration.500ms>
                            <x-input min="{{$item->min_cost}}" type="number" name="amount[{{$item->id}}]"
                                     class="md:w-1/2 w-full"
                                     placeholder="Введити сумму"></x-input>
                            <button type="submit" class="btn-save text-sm py-2">Оплатить</button>
                        </div>
                    </label>
                @endforeach
            </form>

        </div>


        <div class="w-full">
            <div class="px-4 pb-4">
                <div>
                    <div class="mt-2 uppercase font-semibold">
                        Собрано {{$project->sum}} руб
                        <div class="float-right">
                            {{$project->percent}} %
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
            </div>

            <div class="text-center text-xl w-full pt-4">Доступные способы оплаты:</div>
            <div class="flex gap-4 justify-center">
                <img width="80" src="{{ asset('payment/mir.svg') }}"/>
                <img width="80" src="{{ asset('payment/Maestro.svg') }}"/>
                <img width="80" src="{{ asset('payment/Mastercard.svg') }}"/>
                <img width="80" src="{{ asset('payment/Visa.svg') }}"/>
                <img width="80" src="{{ asset('payment/JCB.svg') }}"/>
            </div>
        </div>
    </div>
    <style>
        .radio .radio-input {
            visibility: hidden;
            position: absolute;
        }

        .radio label:hover {
            cursor: pointer;
        }

        .radio input:checked + label {
            border-color: rgba(19, 15, 229, 1);
        }
    </style>
@endsection
