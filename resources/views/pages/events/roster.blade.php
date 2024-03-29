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

                            <div style="border: 1px solid black; padding: 0.25rem; background-color: rgba(0,0,0,0.1); width: 50%;">
                                <h3>Please Note: Student self-registration for the NJ All-State Chorus is now closed.</h3>
                                <p>
                                    Please direct all questions regarding your registration for NJ All-State Chorus to your Choir Director.
                                </p>
                                <div>
                                    <a href="{{ route('pitchfiles',75) }}">If needed the 2023-24 NJ All-State Chorus pitch files are here.</a>
                                </div>
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
                                @if(($eventversion->dates('results_release')=== 'not found') || ($eventversion->id == 73))
                                    <div class="mb-1 col-12 text-center">
                                        <a href="{{route('registrant.profile.edit', ['eventversion' => $eventversion->id])}}" class="btn btn-info col-8 text-white">{{$eventversion->name}}</a>
                                    </div>
                                @endif

                                {{-- Events with participation fees --}}
                                @if($eventversion->eventversionconfig->participation_fee && $teacher_allows_paypal_participation_fee_payments)
                                    @if(auth()->user()->isAccepted($eventversion))
                                        <div class="mb-1 col-12 text-center" style="padding: 1rem; margin-top: 1rem;">
                                            <a href="{{ route('participationfee.show', ['eventversion' => $eventversion]) }}" style="background-color: lemonchiffon; color: darkred; border: 1px solid darkred; border-radius: 1rem; padding: 0.25rem 1rem; text-decoration: none;">
                                                {{ $eventversion->name }} Participation Fee Payment
                                            </a>
                                        </div>
                                    @endif
                                @endif

                            @empty
                                No active events found.<br />
                                If you have been told that events are open,
                                please advise your teacher that no open events
                                were found.
                            @endforelse
<div id="not-found">
<p>If an expected event is not listed, please ask your Director to check their 'Auditions' page
at TheDirectorsRoom.com.  If your name is listed on their page, return here and you should find
the appropriate Event botton.
</p>
<p>If this does not work, please reach out using the green chat button at the bottom-right-hand corner of this page.
Please include your name, school, and your Director's name in the Chat message.
</p>
</div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endauth

@endsection
