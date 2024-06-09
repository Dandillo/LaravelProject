<div class="bg-gray-100 flex-1 grid">

    <div class="col-span-4 card flex flex-col">
        <x-title class="ml-6">Проекты</x-title>
        <div class="px-3 border-b pb-3">
            <div class="flex">
                <div class="inline-block relative w-40 pr-1">
                    <x-select wire:model="category_id">
                        <option value="">По категории</option>
                        @foreach($categories as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </x-select>
                </div>
                <div class="inline-block relative w-40 pr-1">
                    <x-select wire:model="region_id">
                        <option value="">По региону</option>
                        @foreach($regions as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </x-select>
                </div>
                <div class="inline-block relative w-40 pr-1">
                    <x-select wire:model="status_id">
                        <option value="">По статусу</option>
                        @foreach($statuses as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </x-select>
                </div>
            </div>
        </div>

        <div class="px-3 border-b">
            <div class="flex">
                <input class="p-3 flex-1 border-0 border-l-2" type="search" placeholder="Поиск по заголовку"
                       wire:model="search">
            </div>
        </div>

        <table class="w-full">
            <thead>
            <tr class="text-left text-gray-900 border-b text-sm">
                <th class="px-2 py-3">№</th>
                <th class="px-4 py-3">Название</th>
                <th class="px-4 py-3 sm:block hidden">Автор</th>
                <th class="px-4 py-3">Дата создания</th>
                <th class="px-4 py-3 sm:block hidden">Платежи</th>
            </tr>
            </thead>
            <tbody class="bg-white">
            @foreach($projects as $index=>$project)
                <tr class="text-gray-700">
                    <td class="pl-2 border">
                        <div class="flex items-center text-sm">
                            {{ $index+1 }}
                        </div>
                    </td>
                    <td class="px-4 py-3 border ">
                        <a href="{{ route('project.show', ['project'=> $project->id]) }}"
                           class="hover:underline hover:text-indigo-500 items-center text-sm">
                            {{ $project->title }}
                            <x-project-status-label>{{ $project->status->name?? 'Создается' }}</x-project-status-label>
                        </a>
                    </td>
                    <td class="px-4 py-3 text-sm sm:table-cell hidden border">
                        <a class="hover:text-indigo-500 hover:underline"
                           href="{{ route('user.page', ['user'=> $project->author->id])}}">{{ $project->author->name }} </a>
                    </td>
                    <td class="px-4 py-3 text-sm border">
                        {{$project->created_at->format('d.m.Y')}}
                    </td>
                    <td class="px-4 py-3 text-sm sm:table-cell hidden border">
                        <a class="hover:text-indigo-500 hover:underline"
                           href="{{ route('admin.project.payments', ['project'=> $project->id])}}">История платежей </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="card-footer flex">
            {{ $projects->links() }}
        </div>
    </div>
</div>
