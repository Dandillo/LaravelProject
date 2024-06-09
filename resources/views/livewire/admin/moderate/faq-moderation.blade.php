<div>
    <div class="mx-auto bg-white p-4 rounded">
        <x-title>Faq проектов</x-title>
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
                    <th class="px-4 py-3">Вопрос</th>
                    <th class="px-4 py-3">Ответ</th>
                    <th class="px-4 py-3">Проект</th>
                    <th class="px-4 py-3">Статус</th>
                </tr>
                </thead>
                <tbody class="bg-white">
                @foreach($faqs as $item)
                    <tr class="text-gray-700 hover:shadow-md">
                        <td class="px-4 py-3 text-sm">
                            <div>
                                {{ $item->question }}
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <div>
                                {{ $item->answer }}
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
            {{ $faqs->links() }}
        </div>
    </div>
</div>
