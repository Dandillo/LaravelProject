<div class="w-3/4 mx-auto mt-5">

    <x-title>Редактировать профиль</x-title>
    <form wire:submit.prevent="save">
        <div class="mb-3">
            @if (session()->has('scs_msg'))
                <x-success-alert :message="session('scs_msg')"></x-success-alert>
            @endif
        </div>
        <div class="mb-3 grid-cols-2 grid gap-6">
            <div class="mb-4 mb-0">
                <x-input-label>Имя *</x-input-label>
                <x-input wire:model.defer="name"
                         class="w-full px-3 py-2 text-sm focus:outline-none focus:shadow-outline"
                         placeholder="Имя"></x-input>
                @error('name')
                <div class="text-right"><small class="text-red-900">{{ $message }}</small></div>
                @enderror
            </div>
            <div class="mb-4">
                <x-input-label>Телефон</x-input-label>
                <x-input wire:model.defer="phone"
                         class="w-full px-3 py-2 text-sm focus:outline-none focus:shadow-outline"
                         placeholder="7 900 000 00 00"></x-input>
                @error('phone')
                <div class="text-right"><small class="text-red-900">{{ $message }}</small></div>
                @enderror
            </div>

        </div>

        <div class="mb-3 grid-cols-4 grid gap-6">
            <div class="mb-4 mb-0">
                <x-input-label>Дата рождения</x-input-label>
                <x-input wire:model.defer="birthdate"
                         class="w-full px-3 py-2 text-sm focus:outline-none focus:shadow-outline"
                         type="date"></x-input>
                @error('birthdate')
                <div class="text-right"><small class="text-red-900">{{ $message }}</small></div>
                @enderror
            </div>

            <div class="mb-4">
                <x-input-label>Пол</x-input-label>
                <select wire:model.defer="sex"
                        class="w-full px-3 py-2 text-sm text-black outline-none shadow-sm border-gray-300">
                    <option value="">Не выбрано</option>
                    <option value="female">Женский</option>
                    <option value="male">Мужской</option>
                </select>
                @error('sex')
                <div class="text-right"><small class="text-red-900">{{ $message }}</small></div>
                @enderror
            </div>


            <div class="mb-4 col-span-2">
                <x-input-label>Регион</x-input-label>
                <x-select2-list :modelname="'region_id'" :dict="$regions" :valId="$region_id"/>
                @error('region')
                <div class="text-right"><small class="text-red-900">{{ $message }}</small></div>
                @enderror
            </div>

        </div>
        <div class="grid gap-6 grid-cols-4">
            <div class="col-span-3">
                <x-input-label>О себе</x-input-label>
                <textarea rows="14" placeholder="Напишите несколько предложений о себе" wire:model.defer="about"
                          class="w-full px-3 py-2 text-sm leading-tight text-gray-400 border-gray-400 focus:outline-none focus:shadow-outline">
                </textarea>
                @error('about')
                <div class="text-right"><small class="text-red-900">{{ $message }}</small></div>
                @enderror
            </div>
            <div>
                <x-input-label>Фото</x-input-label>
                <div class="px-4 py-2 text-center w-48 h-48">
                    <div id="image-clear" class="btn-delete w-8 px-2 py-1">
                        <i class="fa fa-trash text-red-500"></i>
                    </div>
                    <div class="mb-4" wire:ignore>

                        <img id="photo-preview" class="w-auto mx-auto rounded-full object-cover object-center"
                             src="{{ isset($cur_photo)? \Illuminate\Support\Facades\Storage::url($cur_photo) : asset('def-user.svg') }}"
                             alt="Avatar Upload"/>
                    </div>
                    <label class="cursor-pointer mt-6">
                        <span class="btn-edit">Загрузить фото</span>
                        <input type='file' class="hidden" id="photo" wire:model.defer="photo"/>
                    </label>
                </div>
            </div>

        </div>
        <div class="text-left mt-3">
            <button type="submit" class="btn-save">Сохранить</button>
        </div>
    </form>
    @push('scripts')
        <script src="{{ url('js/select2.js') }}"></script>
        <script>
            $(document).ready(function (e) {
                $('#image-clear').on('click', function () {
                    $('#photo').val('');
                    $('#photo-preview').attr('src', '{{ asset('def-user.svg') }}');
                });
                $('#photo').change(function () {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        $('#photo-preview').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                });
            });
        </script>
    @endpush
</div>
