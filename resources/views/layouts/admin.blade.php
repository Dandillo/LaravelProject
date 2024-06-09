@extends('layouts.base')
@push('scripts')
    <script src="{{ url('js/sidebar.js') }}" defer></script>
@endpush
@section('body')

    @include('admin.navbar')


    <!-- strat wrapper -->
    <div class="h-screen flex flex-row flex-wrap">

    @include('admin.sidebar')

    <!-- strat content -->
        <div class="bg-gray-100 flex-1 p-6">

            @yield('content')
            {{ $slot ?? '' }}
        </div>
        <!-- end content -->

    </div>
    <!-- end wrapper -->


@endsection
