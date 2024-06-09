<!-- start navbar -->
<div
    class="relative w-full flex flex-row flex-wrap items-center px-4 py-2 border-b border-gray-300">

    <!-- navbar content toggle -->
    <button id="navbarToggle" class="md:hidden block fixed right-0 mr-6">
        <i class="fad fa-chevron-double-down"></i>
    </button>
    <!-- end navbar content toggle -->

    <!-- navbar content -->
    <div id="navbar"
         class="animated hidden md:block md:top-0 border-t border-b md:border-0 border-gray-200 bg-white pl-3 justify-between items-center  md:items-center">
        <!-- left -->
        <div class="text-gray-600 md:flex md:flex-row md:justify-evenly gap-6">
            <a class="mr-2 transition duration-500 ease-in-out hover:text-gray-900" href="{{url('/')}}"
               title="email">  <i class="fas fa-home text-gray-700"></i></a>
            <a class="mr-2 transition duration-500 ease-in-out hover:text-gray-900" href="{{url('admin')}}"
               title="email"> Панель администратора</a>
            <a class="mr-2 transition duration-500 ease-in-out hover:text-gray-900" href="{{ route('news.create') }}"
               title="email"> Создать новость</a>
            <a class="mr-2 transition duration-500 ease-in-out hover:text-gray-900" href="{{route('admin.project')}}"
               title="email"> Проекты</a>
        </div>
        <!-- end left -->


    </div>
    <!-- end navbar content -->

</div>
<!-- end navbar -->
