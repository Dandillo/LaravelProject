<nav x-data="{ open: false }" class="border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('main') }}">
                        <x-logo class="block h-10 w-auto fill-current text-gray-600"/>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden ml-2 lg:ml-10 sm:flex">
                    <x-nav-link :href="route('main')" :active="request()->routeIs('main')">
                        {{ __('Главная') }}
                    </x-nav-link>
                </div>
                <!-- Navigation Links -->
                <div class="hidden ml-2 lg:ml-10 sm:flex">
                    <x-nav-link :href="route('project.index')" :active="request()->routeIs('project.*')">
                        {{ __('Список проектов') }}
                    </x-nav-link>
                </div>
                <!-- Navigation Links -->
                <div class="hidden ml-2 lg:ml-10 sm:flex">
                    <x-nav-link :href="route('news.index')" :active="request()->routeIs('news.*')">
                        {{ __('Новости') }}
                    </x-nav-link>
                </div>
                <!-- Navigation Links -->
                <div class="hidden ml-2 lg:ml-10 sm:flex">
                    <x-nav-link :href="route('page',['page' =>'about'])" :active="request()->routeIs('page')">
                        {{ __('О нас') }}
                    </x-nav-link>
                </div>
            </div>
            <div class="sm:flex py-3 hidden text-sm font-bold">
                <a href="{{ route('project.create') }}" class="mr-3 my-auto text-gray-500  hover:text-gray-700">Создать
                    проект</a>
                @auth
                    <a class="my-auto hover:text-indigo-500 text-accent-blue whitespace-nowrap overflow-hidden w-24 "
                       href="{{ route('user.profile') }}">
                        {{ Auth::user()->name }}
                    </a>
                    <div x-data="{ dropdownOpen: false }" class="relative">
                        <button @click="dropdownOpen = !dropdownOpen"
                                class="relative text-accent-blue block hover:text-indigo-500 p-2 focus:outline-none">
                            <i class="fas fa-chevron-down"></i>
                        </button>

                        <div x-show="dropdownOpen" @click="dropdownOpen = false"
                             class="fixed inset-0 h-full w-full z-10"></div>

                        <div x-show="dropdownOpen"
                             class="absolute right-0 mt-2 py-2 w-48 bg-white rounded-md shadow-xl z-20">
                            <a href="{{ route('user.profile') }}"
                               class="block px-4 py-2 text-sm text-gray-500 hover:bg-dropdown-blue hover:text-gray-700">
                                Профиль
                            </a>
                            <a href="{{ route('user.profile.edit') }}"
                               class="block px-4 py-2 text-sm text-gray-500 hover:bg-dropdown-blue hover:text-gray-700">
                                Редактировать
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <a href="{{route('logout')}}"
                                   class="block px-4 py-2 text-sm text-gray-500 hover:bg-dropdown-blue hover:text-gray-700"
                                   onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                    {{ __('Выход') }}
                                </a>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}">
                        <div class="btn">
                            Войти
                        </div>
                    </a>
                @endauth

            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">


        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <a href="{{ route('user.profile') }}">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name ?? '' }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email ?? '' }}</div>
                </div>
            </a>
            <div class="mt-3">
                <x-responsive-nav-link :active="request()->routeIs('main')" href="{{url('/')}}">Главная</x-responsive-nav-link>
                <x-responsive-nav-link :active="request()->routeIs('project.create')" href="{{ route('project.create') }}">Создать проект</x-responsive-nav-link>
                <x-responsive-nav-link :active="request()->routeIs('project.index')" href="{{ route('project.index') }}">Список проектов</x-responsive-nav-link>
                <x-responsive-nav-link :active="request()->routeIs('news.*')" href="{{ route('news.index') }}">Новости</x-responsive-nav-link>
                <x-responsive-nav-link :active="request()->routeIs('page')" href="{{ url('pages/about') }}">О нас</x-responsive-nav-link>
            </div>
            <div class="mt-2">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Выйти') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
