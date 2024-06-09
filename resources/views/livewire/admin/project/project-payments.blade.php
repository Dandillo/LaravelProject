<div class="bg-gray-100 flex-1 grid">
    <div class="col-span-4 card flex flex-col">
        <x-title class="ml-6">Платежи по проекту</x-title>
        <h3 class="font-medium ml-6">Проект: <a href="{{ route('project.show', ['project' =>$project->id]) }}"
                                                class="text-accent-blue hover:underline"
                                                target="_blank">{{$project->title}}</a> /
            <x-project-status-label>{{ $project->status->name?? 'Не определен' }}</x-project-status-label>
        </h3>
        @error('payment')
        <div class="mt-2">
            <x-error-alert :message="$message"></x-error-alert>
        </div>
        @enderror
        <table class="w-full">
            <thead>
            <tr class="text-left text-gray-900 border-b text-sm">
                <th class="px-2 py-3">№</th>
                <th class="px-4 py-3">Пользователь</th>
                <th class="px-4 py-3">Стоимость</th>
                <th class="px-4 py-3 sm:table-cell hidden">Дата создания</th>
                <th class="px-4 py-3 sm:block hidden">Статус</th>
                <th class="px-4 py-3 sm:table-cell hidden">Отмена</th>
            </tr>
            </thead>
            <tbody class="bg-white">
            @foreach($payments as $index=>$payment)
                <tr class="text-gray-700">
                    <td class="pl-2 border">
                        <div class="flex items-center text-sm">
                            {{ $index+1 }}
                        </div>
                    </td>
                    <td class="px-4 py-3 border ">
                        {{ $payment->user->name }}
                    </td>
                    <td class="px-4 py-3 text-sm sm:table-cell hidden border">
                        {{ $payment->amount }} руб.
                    </td>
                    <td class="px-4 py-3 text-sm border">
                        {{ $payment->payment_created ? \Carbon\Carbon::parse($payment->payment_created)->format('d.m.Y') : 'Неизвестно'}}
                    </td>
                    <td class="px-4 py-3 text-sm border">
                        <x-payment-status-label :status="$payment->status"></x-payment-status-label>
                    </td>
                    <td class="px-4 py-3 text-sm border">
                        @if(isset($payment->id) &&
                                ($payment->refund_status == null || $payment->refund_status == 'canceled')
                                       && ($payment->status =='succeeded'))
                            <div x-data="{ confirmRefund:false }" class="mt-2">
                                <button x-show="!confirmRefund" x-on:click="confirmRefund=true"
                                        class="btn-delete">Оформить возврат
                                </button>
                                <a x-show="confirmRefund" x-on:click="confirmRefund=false"
                                   href="{{ route('admin.payment.refund', ['payment' => $payment->id]) }}"
                                   class="btn-success">Вернуть
                                </a>
                                <button x-show="confirmRefund" x-on:click="confirmRefund=false"
                                        class="btn border-gray-400 text-gray-400">Нет
                                </button>
                            </div>
                        @endif
                        @if($payment->refund_status == 'succeeded')
                            <x-project-status-label>Платеж возвращен</x-project-status-label>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="card-footer flex">
            {{ $payments->links() }}
        </div>
    </div>
</div>
