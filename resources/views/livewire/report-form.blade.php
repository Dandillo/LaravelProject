<div class="w-3/4 mx-auto mt-5">
    <x-title>Жалоба {{ $project_title }}</x-title>
    <form wire:submit.prevent="send">
        <div class="mb-3">
            @if (session()->has('scs_msg'))
                <x-success-alert :message="session('scs_msg')"></x-success-alert>
            @endif
        </div>
        <div class="mb-4">
            <x-input-label>Почта *</x-input-label>
            <x-input wire:model.defer="email" type="email"
                     class="w-full px-3 py-2 text-sm focus:outline-none focus:shadow-outline"
                     placeholder="Почта"></x-input>
            @error('email')
            <div class="text-right"><small class="text-red-900">{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            <x-input-label>Текст жалобы</x-input-label>
            <textarea rows="14" placeholder="Напишите вашу жалобу" wire:model.defer="report_text"
                      class="w-full px-3 py-2 text-sm leading-tight text-gray-400 border-gray-400 focus:outline-none focus:shadow-outline">
                </textarea>
            @error('report_text')
            <div class="text-right"><small class="text-red-900">{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            <button type="submit" class="w-40 text-xs px-3 py-2 btn-save">
                Отправить
            </button>
        </div>
    </form>
</div>
