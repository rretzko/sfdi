@extends('layouts.formCenter')
@extends('navs.navGuest')
@extends('headers.headerSite')

@section('content')
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
            <div class="nav_guest links">
                @auth
                    <a href="{{ url('/home') }}">Home</a>
                @else
                    <a href="{{ route('login') }}">Login</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            </div>
        @endif
        <div class="content">
            <!-- no content -->
        </div>
    </div>
@endsection  
