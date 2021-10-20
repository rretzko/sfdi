@extends('layouts.page')

@section('title')
Registration Profile
@endsection

@section('content')

    @auth

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header d-flex ">
                             <div class="card-header-title">
                                {{ $page_title }}
                             </div>
                        </div>

                        <div class="card-body">
                            @if (session()->has('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session()->get('success') }}
                                </div>
                            @endif

                            @if($self_registration_open || ($isRegistered && $video_registration_open) ||
                                (($eventversion->id === 66) || ($eventversion->id === 67)) ||
            (auth()->id() === 8457)) {{-- SYDNEY VOLLMAR --}}
                            {{$test}}
                                @include('forms.fregistrantprofile')
                            @else

                                <div class="text-black">
                                   {{ $self_registration_open }} Self-registration for {{ $eventversion->name }} will
                                    open on {{ $self_registration_open_date }}.<br />
                                    @if($eventversion->id === 69) {{-- NJ All-Shore Chorus --}}
                                        Pitch files for this year's auditions can be found <a href="https://allshorechorusnj.com/auditions" target="_BLANK">here</a>!
                                    @else
                                        Pitch files for this year's auditions can be found <a href="{{ route('pitchfiles',[$eventversion]) }}">here</a>!
                                    @endif

                                </div>
                            @endif

                        </div><!-- card-body -->
                    </div><!-- card -->
                </div><!-- col-md-8 -->
            </div><!-- row justify-content-center -->
        </div><!-- container -->
    @endauth
@endsection

