<div>
    <div class="mx-auto bg-white p-4 rounded">
        <x-title>Новости проектов</x-title>
        <div class="flex">
            <div class="inline-block relative w-40 pr-1">
                <x-select wire:model="is_checked">
                    <option value="0">Новые</option>
                    <option value="1">Просмотренные</option>
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
                    <th class="px-4 py-3">Жалоба</th>
                    <th class="px-4 py-3">Почта пользователя</th>
                    <th class="px-4 py-3">Ссылка на проект</th>
                </tr>
                </thead>
                <tbody class="bg-white">
                @foreach($reports as $item)
                    <tr class="text-gray-700 hover:shadow-md">
                        <td class="px-4 py-3 text-sm">
                            <div
                                class="p-2 relative overflow-hidden transition-all ease-in duration-1000"
                                x-data="{ expanded: false }">
                                <div @click="expanded = !expanded"
                                     class="cursor-pointer duration-300 rounded-lg flex justify-between">
                                    <div class="text-xl font-medium text-gray-700">
                                         Жалоба {{ $item->project->title ?? '' }}
                                        @if($item->is_checked)
                                            <small
                                                class="font-semibold text-sm uppercase border-green-400 border p-1 text-green-500">Обработана</small>
                                        @endif
                                    </div>
                                    <button type="button">
                                        <i :class="expanded ? 'fas fa-chevron-up mt-1' : 'fas fa-chevron-down'"></i>
                                    </button>

                                </div>
                                <small class="text-gray-400">{{$item->created_at->format('d.m.Y')}}</small>
                                <div class="mb-5" x-show="expanded"
                                     x-collapse.duration.500ms>{!! $item->report_text !!}</div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <p class="font-medium">
                                {{ $item->email }}
                            </p>
                        </td>
                        <td class="px-4 py-3">
                            <p class="font-medium">
                                @isset($item->project_id)
                                    <a class="hover:text-indigo-500 hover:underline"
                                       href="{{ route('project.show', ['project'=> $item->project_id])}}">{{ __("Ссылка на проект") }} </a>
                                @endisset
                            </p>
                        </td>
                        <td class="px-4 py-3 flex-1 text-sm">
                            @if($item->is_checked == false)
                                <div x-data="{ confirmUnban:false }">
                                    <button x-show="!confirmUnban" x-on:click="confirmUnban=true"
                                            class="btn">Просмотрено
                                    </button>
                                    <button x-show="confirmUnban" x-on:click="confirmUnban=false"
                                            wire:click="report_checked({{ $item->id }})" class="btn-success">Да
                                    </button>
                                    <button x-show="confirmUnban" x-on:click="confirmUnban=false"
                                            class="btn border-gray-400 text-gray-400">Нет
                                    </button>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer flex">
            {{ $reports->links() }}
        </div>
    </div>
</div>
