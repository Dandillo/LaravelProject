{{--Карточка проекта для вывода списков--}}
<div class="w-full py-3 px-3">
    <a href="{{ route('project.show', ['project'=> $project->id]) }}">
        <div class="bg-white shadow-xl relative overflow-hidden h-full flex flex-col relative">
            <div class="bg-cover bg-center h-56 p-4 relative"
                 style="background-image: url('{{$project->image_card? \Illuminate\Support\Facades\Storage::url($project->image_card)
                                        : "https://source.unsplash.com/1600x900/?cat-" .$project->id}}')">
            </div>
            <div class="p-4">
                @if($project->category) <small
                    class="border-2 p-2 text-accent-blue  border-accent-blue">Тема
                    проекта - {{ $project->category->name ?? '' }}</small>
                @endif
            </div>
            <div class="p-4 max-h-40 relative flex flex-col">
                <p class="uppercase tracking-wide text-sm font-bold text-gray-700">{{ $project->title }}</p>
                <small>{{$project->short_desc}} </small>
            </div>
            @if(!($nosum ?? false))
                <div class="p-4 relative flex flex-col mt-auto">
                    <div class="my-2 uppercase font-semibold text-right ">
                        Сумма: {{ $project->amount }} руб
                    </div>
                    @php
                        $sum = $project->suc_payments->pluck('amount')->sum();
                        $percent = round(($sum * 100) / $project->amount, 1);
                    @endphp
                    <div class="relative w-full bg-gray-200 rounded">
                        <div style="width: {{($percent >= 100)? 100: $percent}}%"
                             class="relative top-0 h-4 rounded bg-progress"></div>
                    </div>


                    <div class="mt-2 uppercase font-semibold">
                        {{ $sum }} руб
                        <div class="float-right">
                            {{ $percent }}%
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </a>
</div>
