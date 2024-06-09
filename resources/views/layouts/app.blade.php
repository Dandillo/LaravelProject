@extends('layouts.base')
@section('body')
    <div class="min-h-screen">
        @role("admin", "moderator")
        @include('admin.navbar')
        @endrole
    @include('layouts.navigation')
    <!-- Page Content -->
        <div style="max-width: 1280px;" class="m-auto w-full">
            @yield('content')
            {{ $slot ?? '' }}
        </div>
    </div>
    @include('layouts.footer')
@endsection
