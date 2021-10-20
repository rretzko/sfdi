@extends('layouts.page')

@section('title')
Profile
@endsection

@section('content')
    @auth
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header d-flex ">

                             <div class="card-header-title">
                                Event Rosters
                             </div>
                        </div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @csrf

                            @forelse($eventversions AS $eventversion)
                                {{-- display buttons for eventversion where the results have NOT been released--}}
                                @if($eventversion->dates('results_release')=== 'not found')
                                    <div class="mb-1 col-12 text-center">
                                        <a href="{{route('registrant.profile.edit', ['eventversion' => $eventversion->id])}}" class="btn btn-info col-8 text-white">{{$eventversion->name}}</a>
                                    </div>
                                @endif
                            @empty
                                No active events found.<br />
                                If you have been told that events are open,
                                please advise your teacher that no open events
                                were found.
                            @endforelse


                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endauth

@endsection
