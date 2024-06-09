@extends('layouts.app')

@section('content')
    <x-title>{{$page->title}}</x-title>
    <div>
        {!! $page->text !!}
    </div>
@endsection
