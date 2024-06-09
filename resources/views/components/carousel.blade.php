{{--Атрибут :projects коллекция проектов--}}
{{-- Карусель проектов--}}
<article x-data="slider" class="relative w-full hidden md:flex flex-shrink-0 overflow-hidden shadow-2xl">
    <div class="rounded-full bg-gray-600 text-white absolute top-5 right-5 text-sm px-2 text-center z-10">
        <span x-text="currentIndex"></span>/
        <span x-text="projects_length"></span>
    </div>
{{-- Вывод каждого проекта переданного в компонент--}}
    @foreach($projects as $k=>$project)
        <a href="{{ route('project.show', ['project'=> $project->id]) }}">
            <figure class="h-96" x-show="currentIndex == {{$k}} + 1"
                    x-transition:enter="transition transform duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition transform duration-300" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0">
                <img src="{{$project->image_header? \Illuminate\Support\Facades\Storage::url($project->image_header)
                                        : "https://source.unsplash.com/1600x900/?cat-" .$project->id}}" alt="Image"
                     class="absolute inset-0 z-10 h-full w-full object-cover opacity-70"/>
                <figcaption
                    class="absolute bottom-1 z-20 w-96 pl-2 left-0 tracking-widest leading-snug bg-gray-300 bg-opacity-25">
                    <x-title>{{$project->title}}</x-title>
                </figcaption>
            </figure>
        </a>
    @endforeach
    {{-- Кнопка назад--}}
    <button @click="back()"
            class="absolute left-8 top-1/2 -translate-y-1/2 w-11 h-11 flex justify-center items-center z-10">
        <svg
            class="w-14 h-14 font-bold transition duration-500 ease-in-out transform motion-reduce:transform-none text-gray-500 hover:text-gray-700 hover:-translate-x-0.5"
            fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7">
            </path>
        </svg>
    </button>
    {{-- Кнопка вперед--}}
    <button @click="next()"
            class="absolute right-8 top-1/2 translate-y-1/2 w-11 h-11 flex justify-center items-center z-10">
        <svg
            class="w-14 h-14 font-bold transition duration-500 ease-in-out transform motion-reduce:transform-none text-gray-500 hover:text-gray-700 hover:translate-x-0.5"
            fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>
</article>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('slider', () => ({
            currentIndex: 1,
            projects_length: {{$projects->count()}},
            back() {
                if (this.currentIndex > 1) {
                    this.currentIndex = this.currentIndex - 1;
                }
            },
            next() {
                if (this.currentIndex < this.projects_length) {
                    this.currentIndex = this.currentIndex + 1;
                } else if (this.currentIndex <= this.projects_length) {
                    this.currentIndex = this.projects_length - this.currentIndex + 1
                }
            },
        }))
    })
</script>
