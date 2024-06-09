<!-- start sidebar -->
<div id="sideBar"
     class="fixed md:relative flex flex-col flex-wrap bg-white border-r border-gray-300 p-6 flex-none w-64 md:ml-0 -ml-64  md:top-0 md:z-30 animated faster">
    <!-- sidebar content -->
    <div class="flex flex-col">

        <!-- sidebar toggle -->
        <div class="text-right md:hidden block mb-4">
            <button id="sideBarHideBtn">
                <i class="fad fa-times-circle"></i>
            </button>
        </div>
        <!-- end sidebar toggle -->
        @role("admin")
        <p class="uppercase text-xs text-gray-600 mb-4 tracking-wider">Основные</p>

        <!-- link -->
        <a href="{{ url('admin') }}"
           class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fad fa-chart-pie text-xs mr-2 {{Request::is('admin')? 'text-accent-blue' : ''}}"></i>
            Панель администратора
        </a>
        <!-- end link -->

        <!-- link -->
        <a href="{{ route('admin.blocks') }}"
           class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fad fa-th-large text-xs mr-2 {{Request::is('*blocks*')? 'text-accent-blue' : ''}}"></i>
            Блоки и карусели
        </a>
        <!-- end link -->

        <p class="uppercase text-xs text-gray-600 mb-4 mt-4 tracking-wider">разделы</p>

        <!-- link -->
        <a href="{{ url('admin/news') }}"
           class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="far fa-newspaper {{Request::is('*news*')? 'text-accent-blue' : ''}} text-xs mr-2"></i>
            Новости
        </a>
        <!-- end link -->

        <!-- link -->
        <a href="{{ url('admin/project') }}"
           class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fad fa-money-check-alt {{Route::is('*project*')? 'text-accent-blue' : ''}} text-xs mr-2"></i>
            Проекты
        </a>
        <!-- end link -->
        <div class="ml-3 flex flex-col">
            <!-- link -->
            <a href="{{ route('admin.project.applies', ['status_id' => 1]) }}"
               class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
                <i class="fad fa-share-square text-xs mr-2"></i>
                На проверку
            </a>
            <!-- end link -->

            <!-- link -->
            <a href="{{ route('admin.project.applies', ['status_id' => 2]) }}"
               class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
                <i class="fad fa-money-bill text-xs mr-2"></i>
                Идет сбор
            </a>
            <!-- end link -->
            <!-- link -->
            <a href="{{ route('admin.project.applies', ['status_id' => 3]) }}"
               class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
                <i class="fad fa-comments text-xs mr-2"></i>
                Сбор завершен
            </a>
            <!-- end link -->

            <!-- link -->
            <a href="{{ route('admin.project.applies', ['status_id' => 5]) }}"
               class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
                <i class="fad fa-window-close text-xs mr-2"></i>
                Отменены
            </a>
            <!-- end link -->
        </div>

        <!-- link -->
        <a href="{{ url('admin/pages') }}"
           class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fad fa-file {{Route::is('*pages*')? 'text-accent-blue' : ''}} text-xs mr-2"></i>
            Страницы
        </a>
        <!-- end link -->
        @endrole

        <p class="uppercase text-xs text-gray-600 mb-4 mt-4 tracking-wider">Модерация</p>

        <!-- link -->
        <a href="{{ route('admin.moderate.project_news') }}"
           class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fas fa-map-marker-alt {{Request::is('*moderate/news*')? 'text-accent-blue' : ''}} text-xs mr-2"></i>
            Новости проектов
        </a>
        <!-- end link -->

        <!-- link -->
        <a href="{{ route('admin.moderate.comments') }}"
           class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fas fa-map-marker-alt {{Request::is('*moderate/comments*')? 'text-accent-blue' : ''}} text-xs mr-2"></i>
            Комментарии проектов
        </a>
        <!-- end link -->

        <!-- link -->
        <a href="{{ route('admin.moderate.faqs') }}"
           class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fas fa-map-marker-alt {{Request::is('*moderate/faqs*')? 'text-accent-blue' : ''}} text-xs mr-2"></i>
            Faq проектов
        </a>
        <!-- end link -->
        <!-- link -->
        <a href="{{ route('admin.moderate.reports') }}"
           class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fas fa-map-marker-alt {{Request::is('*moderate/reports*')? 'text-accent-blue' : ''}} text-xs mr-2"></i>
            Жалобы
        </a>
        <!-- end link -->

        @role("admin")
        <p class="uppercase text-xs text-gray-600 mb-4 mt-4 tracking-wider">Словари</p>

        <!-- link -->
        <a href="{{ route('admin.region') }}"
           class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fas fa-map-marker-alt {{Request::is('*region*')? 'text-accent-blue' : ''}} text-xs mr-2"></i>
            Регионы
        </a>
        <!-- end link -->

        <!-- link -->
        <a href="{{ route('admin.tag') }}"
           class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fas fa-tag {{Request::is('*project-tag*')? 'text-accent-blue' : ''}}"></i> Тэги проекта
        </a>
        <!-- end link -->


        <!-- link -->
        <a href="{{ route('admin.status') }}"
           class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fad fa-cricket text-xs mr-2  {{Request::is('*project-status*')? 'text-accent-blue' : ''}}"></i>Статус
            проекта
        </a>
        <!-- end link -->

        <!-- link -->
        <a href="{{ route('admin.theme') }}"
           class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fad fa-clone text-xs mr-2  {{Request::is('*project-theme*')? 'text-accent-blue' : ''}}"></i>Тема
            проекта
        </a>
        <!-- end link -->
        @endrole
        <p class="uppercase text-xs text-gray-600 mb-4 mt-4 tracking-wider">Пользователи</p>
        <!-- link -->
        <a href="{{ route('admin.users') }}"
           class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fad fa-users text-xs mr-2  {{Request::is('*user*')? 'text-accent-blue' : ''}}"></i>Управление
            пользователями
        </a>
        <!-- end link -->

    </div>
    <!-- end sidebar content -->
</div>
<!-- end sidbar -->
