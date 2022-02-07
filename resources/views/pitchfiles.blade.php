@extends('layouts.formCenter')
@extends('navs.navGuest')
@extends('headers.headerSite')

<div style="margin-top: 6rem;">
    @section('title')
        Pitches, sheet music and accompaniments for
        <strong>2022-23 NJ All-State Chorus</strong>
    @endsection

    @section('content')

     @guest
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header d-flex flex-column">

                            <div class="card-header-title">
                                Pitches, sheet music and accompaniments for
                                <strong>2022-23 NJ All-State Chorus</strong>
                            </div>

                        </div>

                        <div class="card-body">
                            @if (session('errors'))
                                <div class="alert alert-danger" role="alert">
                                    {!! session('errors')->first() !!}
                                </div>
                            @endif

                        <!-- STATUS MESSAGE -->
                            @if (Session::has('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('status') }}
                                </div>
                            @endif

                            <section class="pitchfiles_wrapper col-9" style="display: flex; justify-content: center; ">

                                @include('partials.pitches')

                            </section>

                        </div><!-- end card-body -->
                    </div><!-- end card -->
                </div><!-- end col-md-8 -->
            </div>
        </div>
    @endguest

@endsection
</div>
