@extends('layouts.app')

@section('title')
    {{ $eventversion->name }} eApplication
@endsection

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex ">
                        <div class="card-header-title">
                            {{$page_title}}!
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- STATUS MESSAGE -->
                        @if (session()->has('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session()->get('status') }}
                            </div>
                        @endif

                        @if(isset($audit))
                            @include($path_audit)
                        @else
                            @include($path_update)
                        @endif

                    </div><!-- card-body -->
                </div><!-- card -->
            </div><!-- col-md-8 -->
        </div><!-- row justify-content-center -->
    </div><!-- container -->

@endsection

