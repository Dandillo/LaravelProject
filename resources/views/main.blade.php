@extends('layouts.app')
@section('content')
    @if($carousel_projects->count() > 0)
        <x-carousel :projects="$carousel_projects"></x-carousel>
    @endif
    @if($popular_projects!= [] && $popular_projects->count() !=0)
        <div id="popular-projects">
            <h2 class="mb-3 mt-6 pl-2">Популярные проекты</h2>
            <x-grid-card>
                @foreach($popular_projects as $project)
                    <x-project-card :project="$project"></x-project-card>
                @endforeach
            </x-grid-card>
        </div>
    @endif
    @if($relevant_projects !=[] && $relevant_projects->count() !=0)
        <div id="relevant-projects">
            <h2 class="mb-3 mt-6 pl-2">Рекомендуемые проекты</h2>

            <x-grid-card>
                @foreach($relevant_projects as $project)
                    <x-project-card :project="$project"></x-project-card>
                @endforeach
            </x-grid-card>
        </div>
    @endif
@endsection
