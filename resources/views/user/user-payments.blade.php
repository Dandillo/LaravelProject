@extends('layouts.app')

@section('content')
    <div class="flex-1 mt-5 grid">

        <div class="col-span-4  flex flex-col">
            <x-title>История платежей</x-title>
            <table class="w-full">
                <thead>
                <tr class="text-left text-gray-900 border-b text-sm">
                    <th class="px-2 py-3">№</th>
                    <th class="px-4 py-3">Проект</th>
                    <th class="px-4 py-3 sm:block hidden">Сумма</th>
                    <th class="px-4 py-3">Дата оплаты</th>
                    <th class="px-4 py-3 sm:block hidden">Статус</th>
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
                            <a href="{{ route('project.show', ['project' =>$payment->project->id]) }}"
                               class="cursor-pointer hover:underline hover:text-indigo-500">
                                {{ $payment->project->title }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-sm sm:table-cell hidden border">
                            {{ $payment->amount }} руб.
                        </td>
                        <td class="px-4 py-3 text-sm border">
                            {{ $payment->payment_created ? \Carbon\Carbon::parse($payment->payment_created)->format('d.m.Y') : 'Неизвестно'}}
                        </td>
                        <td class="px-4 py-3 text-sm border">
                            @if(!isset($payment->refund_status))
                                <x-payment-status-label :status="$payment->status"></x-payment-status-label>
                            @else
                                <x-project-status-label>Возвращен</x-project-status-label>
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
@endsection
