@section('title', 'Create a new account')

<div>
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <a href="{{ route('main') }}">
            <x-logo class="w-auto h-16 mx-auto text-accent-blue"/>
        </a>
        <h2 class="mt-5 text-3xl font-extrabold text-center text-gray-900 leading-9">
            Создайте новый аккаунт
        </h2>
        <p class="mt-2 text-sm text-center text-gray-600 leading-5 ">
            или
            <a href="{{ route('login') }}"
               class="font-bold text-accent-blue text-accent-blue hover:text-indigo-500 hover:underline">
                войдите в существующий
            </a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <form wire:submit.prevent="register">
                <x-input-label>Имя</x-input-label>
                    <x-input wire:model.lazy="name" id="name" type="text" required autofocus class="w-full shadow-sm"></x-input>
                @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <div class="mt-5">
                    <x-input-label>Почта</x-input-label>
                        <x-input wire:model.lazy="email" id="email" type="email" required class="w-full shadow-sm"></x-input>
                    @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-5">
                    <x-input-label>Пароль</x-input-label>
                        <x-input wire:model.lazy="password" id="password" type="password" required
                                 class="w-full shadow-sm"></x-input>
                    @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-5">
                    <x-input-label>Подтвердите пароль</x-input-label>
                        <x-input wire:model.lazy="passwordConfirmation" id="password_confirmation" type="password"
                                 required class="w-full shadow-sm"></x-input>
                </div>

                <div class="mt-5">
                    <button type="submit" class="btn w-full text-sm">
                        Регистрация
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
