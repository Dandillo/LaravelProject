@push('scripts')
    <script src="{{ asset('js/tinymce/tinymce.js') }}"></script>
    <script src="{{ url('js/select2.js') }}"></script>
@endpush
<div class=" w-3/4 mx-auto">
    <x-title>Создать проект</x-title>

    <div x-data="setup()" class="mt-3">
        <div class="sm:flex">
            <template x-for="(tab, index) in tabs" :key="index">
                <div class="flex-col flex">
                    <label class="text-gray-400 text-sm" x-text="'Шаг ' + (index+1)"></label>
                    <button class="border-2 mr-3
            transtition-all duration-150 px-3 py-2 items-center font-bold"
                            :class="activeTab===index ? 'hover:bg-dropdown-blue border-accent-blue hover:text-accent-blue text-accent-blue' : 'hover:text-white hover:bg-tab-inactive'"
                            @click="activeTab = index"
                            x-text="tab"></button>
                </div>

            </template>
        </div>
        <div id="block-info" class="mt-5">
            <div x-show="activeTab===0">
                @if (session()->has('project_msg'))
                    <x-success-alert :message="session('project_msg') "></x-success-alert>
                @endif
                <form wire:submit.prevent="save">
                    <div class="mb-4 mt-2">
                        <x-input-label>Название проекта *</x-input-label>
                        <x-input wire:model.lazy="title" class="w-full" type="text" placeholder="Название"
                                 value="{{ old('title') }}"></x-input>
                        @error('title')
                        <div class="text-right"><small class="text-red-900">{{ $message }}</small></div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-input-label>Краткое описание проекта *</x-input-label>
                        <textarea wire:model.defer="short_desc" class="w-full border-gray-400 text-sm"
                                  placeholder="Опишите основную идею проекта"
                                  rows="6"> {{ old('short_desc') }}</textarea>
                        @error('short_desc')
                        <div class="text-right"><small class="text-red-900">{{ $message }}</small></div>
                        @enderror
                    </div>
                    <div class="sm:grid gap-6 md:grid-cols-4 sm:grid-cols-2">
                        <div class="mb-5">
                            <x-input-label>Финансовая цель (в рублях) *</x-input-label>
                            <x-input wire:model.defer="amount" type="number" class="w-full"
                                     value="{{ old('amount') }}"></x-input>
                            @error('amount')
                            <div class="text-right"><small class="text-red-900">{{ $message }}</small></div>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <x-input-label>Дата окончания проекта *</x-input-label>
                            <x-input wire:model.defer="end_date" class="w-full" value="{{ old('end_date') }}"
                                     type="date"></x-input>
                            @error('end_date')
                            <div class="text-right"><small class="text-red-900">{{ $message }}</small></div>
                            @enderror
                        </div>

                        <div class="mb-4 col-span-2">
                            <x-input-label>Регион *</x-input-label>
                            <x-select2-list :modelname="'region_id'" :dict="$regions" :valId="$region_id"/>
                            @error('region_id')
                            <div class="text-right"><small class="text-red-900">{{ $message }}</small></div>
                            @enderror
                        </div>
                    </div>
                    <div class="md:grid md:grid-cols-2 gap-6">
                        <div class="mb-4">
                            <x-input-label>Тема проекта</x-input-label>
                            <x-select2-list :modelname="'category_id'" :dict="$categories" :valId="$category_id"/>
                            @error('category_id')
                            <div class="text-right"><small class="text-red-900">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <x-input-label>Тэги проекта</x-input-label>
                            <x-select2-list :modelname="'project_tags'" :dict="$tags"
                                            :isMultiple="'true'" :valId="$project_tags"/>
{{--                            <x-multiselect wire:model="project_tags" :options='$tags'/>--}}
                        </div>
                    </div>
                    <div class="mb-2" wire:ignore>
                        <x-input-label>Описание проекта *</x-input-label>
                        <textarea class="w-full description border-gray-400 text-sm"
                                  wire:model.debounce.9999999ms="description"
                                  wire:key="description"
                                  placeholder="Напишите подробную инфорамцию о проекте"
                                  rows="20"> </textarea>
                        </textarea>
                    </div>
                    @error('description')
                    <div class="text-right"><small class="text-red-900">{{ $message }}</small></div>
                    @enderror

                    <div class="text-right">
                        <button onclick="topFunction()" type="submit" class="btn-save">
                            Сохранить
                        </button>
                        <button onclick="topFunction()" @if(!isset($project)) disabled
                                class="btn px-6 w-40 py-4 opacity-25 text-base border-gray-400 hover:bg-white font-normal"
                                @else
                                class="btn px-6 w-40 py-4 text-base font-normal"
                                @endif
                                @click="activeTab = 1">
                            Далее
                        </button>
                    </div>
                </form>

            </div>
            <div x-show="activeTab===1">
                <div>
                    @if (session()->has('media_err'))
                        <x-error-alert :message="session('media_err')"></x-error-alert>
                    @endif
                    @if (session()->has('media_scs'))
                        <x-success-alert :message="session('media_scs')"></x-success-alert>
                    @endif
                    <form wire:submit.prevent="saveMedia">
                        <div class="mb-5 mt-2">
                            <x-input-label>Картинка проекта</x-input-label>
                            <div class="grid-cols-2 grid">
                                <x-file-input wire:model="project_card" id="project-card">
                                </x-file-input>
                                <img wire:ignore
                                     src="{{isset($project->image_card)? \Illuminate\Support\Facades\Storage::url($project->image_card) : ''}}"
                                     id="project-card-preview"
                                     class="max-h-40 object-cover">
                            </div>

                            @error('project_card')
                            <div class="text-right"><small class="text-red-900">{{ $message }}</small></div>
                            @enderror
                        </div>

                        <x-input-label>Фото или видео проекта</x-input-label>
                        <div class="mb-5">
                            <small>Загрузить фото</small>
                            <div class="grid-cols-2 grid">
                                <x-file-input wire:model="project_image" id="project-image">
                                </x-file-input>
                                <img wire:ignore
                                     src="{{ isset($project->image_header)? \Illuminate\Support\Facades\Storage::url($project->image_header) : ''}}"
                                     id="project-image-preview"
                                     class="max-h-40 object-cover">
                            </div>

                            @error('project_image')
                            <div class="text-left"><small class="text-red-900">{{ $message }}</small></div>
                            @enderror

                            <small>Или вставьте ссылку на видео с Youtube</small>
                            <x-input wire:model.lazy="project_video" class="w-full" type="text" placeholder="Ссылка Youtube"
                                     value="{{ $project->video ?? old('video') }}"></x-input>

                            @error('video')
                            <div class="text-left"><small class="text-red-900">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="text-right">
                            <button onclick="topFunction()" type="submit" class="btn-save">
                                Сохранить
                            </button>
                            <button onclick="topFunction()" class="btn px-6 w-40 py-4 text-base font-normal"
                                    @click="activeTab = 2">Далее
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div x-show="activeTab===2">
                <div class="grid md:grid-cols-2 grid-cols-1">
                    @foreach($awards as $award)
                        <div class="award-item border-2 p-4 mt-2">
                            <x-delete-button wire:click="deleteAward({{ $award->id }})"></x-delete-button>

                            <div class="float-right ml-3 cursor-pointer" wire:click="editAward({{ $award->id }})"><i
                                    class="fa fa-pen"></i></div>
                            <div class="font-medium">{{ $award->title }}
                                @if($award->quantity)
                                    <div class="float-right font-sans text-gray-400">
                                        Осталось {{ $award->quantity }}</div>
                                @endif
                            </div>
                            <small>{{ $award->description }}</small>
                            <button disabled class="w-full mt-3 transition duration-150 border-progress border-2 px-6 text-progress py-2
                    text-center hover:bg-progress hover:text-white">
                                {{ $award->min_cost }} руб.
                            </button>
                        </div>
                    @endforeach
                </div>

                @if (session()->has('award_err'))
                    <x-error-alert :message="session('award_err')"></x-error-alert>
                @endif
                @if (session()->has('award_msg'))
                    <x-success-alert :message="session('award_msg') "></x-success-alert>
                @endif

                <form wire:submit.prevent="saveAward" class="mt-5">
                    <div class="mb-5">
                        <x-input-label>Заголовок вознаграждения *</x-input-label>
                        <x-input wire:model.defer="award_title" placeholder="Название" class="w-full"></x-input>
                        @error('award_title')
                        <div class="text-right"><small class="text-red-900">{{ $message }}</small></div>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <x-input-label>Описание вознаграждения *</x-input-label>
                        <textarea class="award_desc w-full" wire:model.defer="award_desc" rows="6"></textarea>
                        @error('award_desc')
                        <div class="text-right"><small class="text-red-900">{{ $message }}</small></div>
                        @enderror
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="mb-5">
                            <x-input-label>Количество вознаграждений</x-input-label>
                            <x-input wire:model.defer="award_quantity" type="number" class="w-full"></x-input>
                            @error('award_quantity')
                            <div class="text-right"><small class="text-red-900">{{ $message }}</small></div>
                            @enderror
                            <div class="mt-2">
                                <label class="inline-flex items-center">
                                    <input wire:model.defer="is_unlim" type="checkbox" class="form-checkbox"/>
                                    <span class="ml-2">Не ограничено</span>
                                </label>
                            </div>
                        </div>
                        <div class="mb-5">
                            <x-input-label>Цена вознаграждений (в рублях) *</x-input-label>
                            <x-input type="number" wire:model.lazy="award_cost" class="w-full"></x-input>
                            @error('award_cost')
                            <div class="text-right"><small class="text-red-900">{{ $message }}</small></div>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <div class="mb-5">
                            <x-input-label>Изображение карточки новости</x-input-label>
                            <x-file-input></x-file-input>
                        </div>
                    </div>

                    <div class="flex gap-1 justify-end">
                        <button onclick="topFunction()" type="submit" class="btn-save text-center px-2">
                            Добавить вознаграждение
                        </button>
                        @if(!isset($project) || $project->status_id == 1 || $project->status_id == null)
                            <a href="#" wire:click="sendToModerate()">
                                <div class="btn px-6 w-40 py-4 text-base font-normal text-center">
                                    Отправить на проверку
                                </div>
                            </a>
                        @endif

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script src="{{ asset('js/tinymce/tinymce.js') }}"></script>
    <x-tinymce></x-tinymce>
    <script>
        function setup() {
            return {
                activeTab: 0,
                tabs: [
                    "Основное",
                    "Медиа файлы",
                    "Вознаграждения",
                ]
            };
        };

        $(document).ready(function (e) {
            $('#project-card').change(function () {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#project-card-preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
            $('#project-image').change(function () {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#project-image-preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
@endpush

