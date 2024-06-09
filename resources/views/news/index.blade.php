@extends('layouts.app')

@section('content')
        <x-title class="pl-2">Новости</x-title>
        @if($news->count() == 0)
            <h3 class="text-center text-xl text-gray-400">В этом разделе пока нет новостей</h3>
        @endif
        <x-grid-card>
            @foreach($news as $item)
                <div class="w-full py-3 px-3">
                    <a href="{{url("news/$item->id")}}">
                        <div class="bg-white shadow-xl overflow-hidden">
                            <div class="bg-cover bg-center h-56 p-4"
                                 style="background-image: url('{{ \Illuminate\Support\Facades\Storage::url($item->image_card) }}')">
                            </div>
                            <div class="p-4">
                                <p class="text-sm float-right pl-1 pb-1 text-gray-400">{{ $item->created_at->format('d.m.Y') }}</p>
                                <p class="tracking-wide text-sm font-bold text-gray-700">
                                    {{$item->title}}
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </x-grid-card>

        <div class="card-footer flex">
            {{ $news->links() }}
        </div>
@endsection
