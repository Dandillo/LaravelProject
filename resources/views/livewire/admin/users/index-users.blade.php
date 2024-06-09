<div>
    <div class="mx-auto bg-white p-4 rounded">
        <x-title>Пользователи</x-title>
        <div class="border-b">
            <div class="flex">
                <input class="p-3 flex-1 border-0" type="search" placeholder="Поиск по имени или почте"
                       wire:model.defer="search">
                <div wire:click="getUsers()" class="px-2 my-auto cursor-pointer"><i
                        class="fas fa-search hover:text-blue-500"></i></div>
            </div>
        </div>
        <div class="py-2">
            @if (session()->has('scs_msg'))
                <x-success-alert :message="session('scs_msg')"></x-success-alert>
            @endif
        </div>
        <div class="flex-1 flex flex-col">
            <table class="w-full">
                <thead>
                <tr class="text-left text-gray-900 border-b text-sm">
                    <th class="px-4 py-3">Имя</th>
                    <th class="px-4 py-3">Почта</th>
                    <th class="px-4 py-3">Статус</th>
                </tr>
                </thead>
                <tbody class="bg-white">
                @foreach($users as $user)
                    <tr class="text-gray-700 hover:shadow-md">
                        <td class="px-4 py-3">
                            <p class="ml-6 font-medium">
                                <a class="hover:text-indigo-500 hover:underline"
                                   href="{{ route('user.page', ['user'=> $user->id])}}">{{ $user->name }} </a>
                                @if($user->is_banned)
                                    <small class="font-semibold uppercase border-red-400 border p-1 text-red-500">Заблокирован</small>
                                @endif</p>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <p class="ml-6 font-medium">{{ $user->email }}</p>
                        </td>
                        <td class="px-4 py-3 flex-1 text-sm">
                            @if($user->is_banned)
                                <div x-data="{ confirmUnban:false }">
                                    <button x-show="!confirmUnban" x-on:click="confirmUnban=true"
                                            class="btn-success">Разблокировать</button>
                                    <button x-show="confirmUnban" x-on:click="confirmUnban=false"
                                            wire:click="get_unban({{ $user->id }})" class="btn-success">Да</button>
                                    <button x-show="confirmUnban" x-on:click="confirmUnban=false"
                                            class="btn border-gray-400 text-gray-400">Нет</button>
                                </div>
                            @else
                                <div x-data="{ confirmBan:false }">
                                    <button x-show="!confirmBan" x-on:click="confirmBan=true"
                                            class="btn-delete">Заблокировать</button>
                                    <x-input x-show="confirmBan" wire:model.defer="ban_desc" placeholder="Укажите причину"></x-input>
                                    <button x-show="confirmBan" x-on:click="confirmBan=false"
                                            wire:click="get_ban({{ $user->id }})" class="btn-success">Да</button>
                                    <button x-show="confirmBan" x-on:click="confirmBan=false"
                                            class="btn border-gray-400 text-gray-400">Нет</button>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer flex">
            {{ $users->links() }}
        </div>
    </div>

</div>
