{{--Сообщение об ошибке--}}
<div class="flex w-full overflow-hidden rounded-sm shadow-md">
    <div class="flex items-center justify-center w-12 bg-red-500">
        <i class="fas fa-exclamation-triangle text-white mx-auto"></i>
    </div>

    <div class="px-4 py-2 -mx-3">
        <div class="mx-3">
            <span class="font-semibold text-red-500 dark:text-red-400">Ошибка</span>
            <p class="text-sm text-gray-600 dark:text-gray-200">
                {{ $message }}
            </p>
        </div>
    </div>
</div>
