<div>
    <div class="mx-auto bg-white p-4 rounded">
        <x-title>Новости проектов</x-title>
        <div class="flex">
            <div class="inline-block relative w-40 pr-1">
                <x-select wire:model="status">
                    <option value="">На проверку</option>
                    <option value="1">Заблокированые</option>
                    <option value="0">Проверенные</option>
                </x-select>
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
                    <th class="px-4 py-3">Новость</th>
                    <th class="px-4 py-3">Проект</th>
                    <th class="px-4 py-3">Статус</th>
                </tr>
                </thead>
                <tbody class="bg-white">
                @foreach($project_news as $item)
                    <tr class="text-gray-700 hover:shadow-md">
                        <td class="px-4 py-3 text-sm">
                            <div
                                class="p-2 relative overflow-hidden transition-all ease-in duration-1000"
                                x-data="{ expanded: false }">
                                <div @click="expanded = !expanded"
                                     class="cursor-pointer duration-300 rounded-lg flex justify-between">
                                    <div class="text-xl font-medium text-gray-700">
                                        {{$item->title}}
                                        @if($item->is_banned)
                                            <small
                                                class="font-semibold text-sm uppercase border-red-400 border p-1 text-red-500">Заблокирован</small>
                                        @endif
                                    </div>
                                    <button type="button">
                                        <i :class="expanded ? 'fas fa-chevron-up mt-1' : 'fas fa-chevron-down'"></i>
                                    </button>

                                </div>
                                <small class="text-gray-400">{{$item->created_at->format('d.m.Y')}}</small>
                                <div class="mb-5" x-show="expanded"
                                     x-collapse.duration.500ms>{!! $item->description !!}</div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <p class="ml-6 font-medium">
                                <a class="hover:text-indigo-500 hover:underline"
                                   href="{{ route('project.show', ['project'=> $item->project_id])}}">{{ __("Ссылка на проект") }} </a>
                            </p>
                        </td>
                        <td class="px-4 py-3 flex-1 text-sm">
                            @if(!isset($item->is_banned) || $item->is_banned != false)
                                <div x-data="{ confirmUnban:false }">
                                    <button x-show="!confirmUnban" x-on:click="confirmUnban=true"
                                            class="btn-success">Разрешить
                                    </button>
                                    <button x-show="confirmUnban" x-on:click="confirmUnban=false"
                                            wire:click="checked_project_part({{ $item->id }})" class="btn-success">Да
                                    </button>
                                    <button x-show="confirmUnban" x-on:click="confirmUnban=false"
                                            class="btn border-gray-400 text-gray-400">Нет
                                    </button>
                                </div>
                            @endif
                            @if($item->is_banned != true)
                                <div class="mt-2">
                                    <x-delete-button wire:click="block_project_part({{ $item->id }})">Заблокировать
                                    </x-delete-button>
                                </div>
                            @endif

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer flex">
            {{ $project_news->links() }}
        </div>
    </div>
</div>
