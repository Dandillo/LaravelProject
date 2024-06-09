@extends('layouts.admin')

@section('content')
    <div class="col-span-6 card flex flex-col">

        <div class="px-3 border-b">
            <form action="" class="flex">
                <a href="{{url('news/create')}}" class="p-3 hover:text-indigo-500">
                    <i class="fa fa-plus"></i> Создать
                </a>
                <input class="p-3 flex-1" type="text" placeholder="search">
                <button type="submit" class="p-3">
                    <i class="fad fa-search"></i>
                </button>
            </form>
        </div>

        <div class="flex-1 flex flex-col">
            <!-- message -->
            <div class="flex items-center  shadow-xs transition-all duration-300 ease-in-out p-5 hover:shadow-md">
                <a class="flex-1" href="{{url('news/1')}}">
                    <p class="ml-6 font-medium">page when looking at its layout looking at its layout The point of using
                        Lorem...</p>
                </a>

                <p class="text-gray-900">Дата: 05.09.2021</p>
                <div class="px-3">
                    <a href="{{url('edit')}}">
                        <button type="submit" class="px-4 py-2 border-2 border-blue-500 text-blue-500 text-xs hover:bg-blue-100 font-bold disabled:opacity-25 transition ease-in-out duration-150">
                            изменить
                        </button>
                    </a>
                    <a href="{{url('edit')}}">
                        <button type="submit" class="px-4 py-2 border-2 border-red-500 text-red-500 text-xs hover:bg-red-100 font-bold disabled:opacity-25 transition ease-in-out duration-150">
                            удалить
                        </button>
                    </a>
                </div>
            </div>
            <!-- message -->
        </div>

        <div class="card-footer flex justify-between">
            <p>4.41 GB (25%) of 17 GB used Manage</p>
            <p>Last account activity: 36 minutes ago</p>
        </div>
    </div>
@endsection
