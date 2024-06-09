{{-- Alert об успешной обработке--}}
<div class="flex w-full overflow-hidden rounded-sm shadow-md mb-2">
    <div class="flex items-center justify-center w-12 bg-green-500">
        <i class="fas fa-check-square  text-white mx-auto"></i>
    </div>

    <div class="px-4 py-2 -mx-3">
        <div class="mx-3">
            <span class="font-semibold text-green-500 dark:text-red-400">Успешно</span>
            <p class="text-sm text-gray-600 dark:text-gray-200">
                {{ $message }}
            </p>
        </div>
    </div>
</div>
