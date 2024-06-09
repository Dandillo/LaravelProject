  <!-- start sidebar -->
{{--  <div id="sideBar" class="relative flex flex-col flex-wrap bg-white border-r border-gray-300 p-6 flex-none w-64 md:-ml-64 md:fixed md:top-0 md:z-30 md:h-screen md:shadow-xl animated faster">--}}
  <div id="sideBar" class="fixed md:relative flex flex-col flex-wrap bg-white border-r border-gray-300 p-6 flex-none w-64 md:ml-0 -ml-64  md:top-0 md:z-30 animated faster">


    <!-- sidebar content -->
    <div class="flex flex-col">

      <!-- sidebar toggle -->
      <div class="text-right md:hidden block mb-4">
        <button id="sideBarHideBtn">
          <i class="fad fa-times-circle"></i>
        </button>
      </div>
      <!-- end sidebar toggle -->

      <p class="uppercase text-xs text-gray-600 mb-4 tracking-wider">Основные</p>

      <!-- link -->
      <a href="{{ url('admin') }}" class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
        <i class="fad fa-chart-pie text-xs mr-2 {{Request::is('admin')? 'text-accent-blue' : ''}}"></i>
        Панель администратора
      </a>
      <!-- end link -->

      <!-- link -->
{{--      <a href="./index-1.html" class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">--}}
{{--        <i class="fad fa-shopping-cart text-xs mr-2"></i>--}}
{{--        ecommerce dashboard--}}
{{--      </a>--}}
      <!-- end link -->

      <p class="uppercase text-xs text-gray-600 mb-4 mt-4 tracking-wider">разделы</p>

      <!-- link -->
      <a href="{{ url('admin/news') }}" class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
          <i class="fad fa-envelope-open-text {{Request::is('*news*')? 'text-accent-blue' : ''}} text-xs mr-2"></i>
          Новости
      </a>
      <!-- end link -->

      <!-- link -->
      <a href="{{ url('admin/project') }}" class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
        <i class="fad fa-comments {{Route::is('*project*')? 'text-accent-blue' : ''}} text-xs mr-2"></i>
        Проекты
      </a>
      <!-- end link -->


      <p class="uppercase text-xs text-gray-600 mb-4 mt-4 tracking-wider">Словари</p>

      <!-- link -->
      <a href="{{ route('admin.region') }}" class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
          <i class="fas fa-map-marker-alt {{Request::is('*region*')? 'text-accent-blue' : ''}} text-xs mr-2"></i>
        Регионы
      </a>
      <!-- end link -->

      <!-- link -->
      <a href="{{ route('admin.tag') }}" class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
          <i class="fas fa-tag {{Request::is('*project-tag*')? 'text-accent-blue' : ''}}"></i> Тэги проекта
      </a>
      <!-- end link -->


      <!-- link -->
      <a href="{{ route('admin.status') }}" class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
        <i class="fad fa-cricket text-xs mr-2  {{Request::is('*project-status*')? 'text-accent-blue' : ''}}"></i>Статус проекта
      </a>
      <!-- end link -->

      <!-- link -->
      <a href="{{ route('admin.theme') }}" class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
        <i class="fad fa-box-open text-xs mr-2  {{Request::is('*project-theme*')? 'text-accent-blue' : ''}}"></i>Тема проекта
      </a>
      <!-- end link -->

    </div>
    <!-- end sidebar content -->

  </div>
  <!-- end sidbar -->
