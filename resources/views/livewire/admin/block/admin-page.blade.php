<div class="grid md:grid-cols-2 grid-cols-1 gap-6">
    <div>
        @if (session()->has('err_msg'))
            <x-error-alert :message="session('err_msg')"></x-error-alert>
        @endif
{{--        Список последних измененных проектов--}}
        <x-title>Проекты</x-title>
        <table class="w-full bg-white">
            <thead>
            <tr class="text-left text-gray-900 border-b text-sm">
                <th class="px-4 py-3">Название</th>
                <th class="px-4 py-3 sm:block hidden">Автор</th>
            </tr>
            </thead>
            <tbody class="bg-white">
            @foreach($projects as $project)
                <tr class="text-gray-700">
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
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div>
        {{--        Список последних измененных новостей--}}
        <x-title>Новости</x-title>
        <table class="w-full bg-white">
            <thead>
            <tr class="text-left text-gray-900 border-b text-sm">
                <th class="px-4 py-3">Название</th>
                <th class="px-4 py-3 sm:block hidden">Дата создания</th>
            </tr>
            </thead>
            <tbody class="bg-white">
            @foreach($news as $item)
                <tr class="text-gray-700">
                    <td class="px-4 py-3 border ">
                        <a href="{{ route('news.show', ['news'=> $item->id]) }}"
                           class="hover:underline hover:text-indigo-500 items-center text-sm">
                            {{ $item->title }}
                        </a>
                    </td>
                    <td class="px-4 py-3 text-sm sm:table-cell hidden border">
                        {{ $item->created_at->format('d.m.Y') }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div>
        {{--        Список последних операций с Юкассой--}}
        <x-title>Платежи</x-title>
        <table class="w-full bg-white">
            <thead>
            <tr class="text-left text-gray-900 border-b text-sm">
                <th class="px-4 py-3">Название</th>
                <th class="px-4 py-3">Сумма</th>
                <th class="px-4 py-3 sm:block hidden">Автор</th>
            </tr>
            </thead>
            <tbody class="bg-white">
            @foreach($payments as $item)
                <tr class="text-gray-700">
                    <td class="px-4 py-3 border ">
                        <div class="items-center text-sm">
                            {{ $item->description }}
                            <x-payment-status-label :status="$item->status"></x-payment-status-label>
                            @if($item->getRefundedAmount() != null && $item->getRefundedAmount()->getValue() != 0)
                                <x-project-status-label class="ml-2">Платеж возвращен</x-project-status-label>
                            @endif
                        </div>
                    </td>
                    <td class="px-4 py-3 text-sm border">
                        {{ $item->getAmount()->getValue() }} руб.
                    </td>
                    <td class="px-4 py-3 text-sm sm:table-cell hidden border">
                        {{ $item->created_at->format('d.m.Y') }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

