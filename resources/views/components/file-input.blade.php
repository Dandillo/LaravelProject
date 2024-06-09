<label class="sm:w-64 w-full flex flex-col items-center px-2 py-2 bg-white shadow-md uppercase cursor-pointer hover:bg-dropdown-blue
                text-accent-blue ease-linear transition-all duration-150">
    <i class="fas fa-cloud-upload-alt fa-3x"></i>
    <span class="mt-2 text-base text-center leading-normal">выберите файл</span>
    <input type="file" {{ $attributes->merge(['class' => 'hidden' ]) }}/>
    {{$slot}}
</label>
