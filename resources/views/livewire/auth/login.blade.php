@section('title', 'Sign in to your account')
<div>
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <a href="{{ route('main') }}">
            <x-logo class="w-auto h-16 mx-auto text-indigo-600"/>
        </a>

        <h2 class="mt-5 text-3xl font-extrabold text-center text-gray-900 leading-9">
            Войдите в свой аккаунт
        </h2>
        @if (Route::has('register'))
            <p class="mt-2 text-sm text-center text-gray-600 leading-5 max-w">
                или
                <a href="{{ route('register') }}"
                   class="font-medium text-accent-blue hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                    создайте новый
                </a>
            </p>
        @endif
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            @if (session()->has('message'))
                <x-error-alert :message="session('message')"></x-error-alert>
            @endif
            <form wire:submit.prevent="authenticate">
                <x-input-label>Почта</x-input-label>
                    <x-input wire:model.lazy="email" id="email" name="email" type="email" class="w-full shadow-sm" required
                             autofocus></x-input>
                @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <div class="mt-5">
                    <x-input-label>Пароль</x-input-label>
                        <x-input wire:model.lazy="password" id="password" type="password" required
                                 class="w-full shadow-sm"></x-input>
                    @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between mt-5">
                    <div class="flex items-center">
                        <input wire:model.lazy="remember" id="remember" type="checkbox"
                               class="form-checkbox w-4 h-4 text-accent-blue transition duration-150 ease-in-out"/>
                        <x-input-label class="ml-2 pt-2">Запомнить меня</x-input-label>
                    </div>

                    <div class="text-sm leading-5">
                        <a href="{{ route('password.request') }}"
                           class="font-medium text-accent-blue hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                            Забыли свой пароль?
                        </a>
                    </div>
                </div>

                <div class="mt-5">
                    <button type="submit" class="btn w-full text-sm">
                        Войти
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
