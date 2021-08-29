@extends('layouts.main')
@extends('headers.headerSite')
@extends('navs.navStudent')

@section('content')
    <div class="container text-white " id="container_page">

        <div id="accordion" role="tablist" aria-multiselectable="true">
      <!-- {{--
            <!-- EVENT -->
            @include('partials.event')

            <!-- PROFILE -->
            @include('partials.profile')

            <!-- PARENT -->
            @include('partials.parent')

            <!-- CREDENTIALS -->
            @include('partials.credentials',[
                $nav_links,
                $user
                ])

            <!-- SCHOOL -->
            @include('partials.school',[
                $student,
                $user
                ])

            <!-- STUDENT -->
            @include('partials.student',[
                $nav_links,
                $shirt_sizes,
                $student,
                $user
                ])
            --}} -->
        </div><!-- accordion -->

@endsection
