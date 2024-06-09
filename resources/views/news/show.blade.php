@extends('layouts.app')

@section('content')
    <x-title>{{$news->title}}</x-title>
    <p class="text-sm py-1 text-gray-400">{{ $news->created_at->format('d.m.Y') }}</p>

    <div class="w-full">
        @isset($news->image_header)
            <div class="bg-cover bg-center h-72 p-4"
                 style="background-image: url({{ \Illuminate\Support\Facades\Storage::url($news->image_header) }})">
            </div>
        @endisset
        <div class="p-4">
            <p class="tracking-wide font-medium text-gray-800">
                {!! $news->description  !!}
            </p>
        </div>
    </div>
@endsection
