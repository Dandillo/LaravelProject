<!-- start navbar -->
<div
    class="relative w-full flex flex-row flex-wrap items-center px-4 py-2 border-b border-gray-300">
    <!-- navbar content -->
    <div id="navbar"
         class="animated block md:top-0 bg-white pl-3 justify-between items-center md:items-center">
        <!-- left -->
        <div class="text-gray-600 md:flex md:flex-row md:justify-evenly gap-6">
            <a class="mr-2 transition duration-500 ease-in-out hover:text-gray-900" href="{{route('main')}}">
                <i class="fas fa-home text-gray-700"></i></a>
            <a class="mr-2 transition duration-500 ease-in-out hover:text-gray-900" href="{{url('admin')}}">
                Панель администратора</a>
            <a class="mr-2 transition duration-500 ease-in-out hover:text-gray-900" href="{{ route('admin.news') }}">
                Новости</a>
            <a class="mr-2 transition duration-500 ease-in-out hover:text-gray-900" href="{{route('admin.project')}}">
                Проекты</a>
            <a class="mr-2 transition duration-500 ease-in-out hover:text-gray-900" href="{{route('admin.users')}}">
                Пользователи</a>
        </div>
        <!-- end left -->
    </div>
    <!-- end navbar content -->

</div>
<!-- end navbar -->
