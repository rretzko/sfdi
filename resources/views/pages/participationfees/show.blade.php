@extends('layouts.page')

@section('title')
   Participation Fees for {{ $eventversion->name }}
@endsection

@section('content')

    @auth
        <div style="margin-top: 1rem;">
            <div style="background-color: white; padding: 1rem; padding-bottom: 3rem; margin-top: 1rem;" >
                <h2>
                    Congratulation on your acceptance into the {{ $eventversion->name }}!
                </h2>

                <h3 style="text-align: center;">
                    @if(auth()->user()->currentRegistrant($eventversion)->participationFeePaid())
                        Thank you for paying your ${{ $eventversion->eventversionconfig->participation_fee_amount }}
                        participation fee!
                    @else
                        Please click the PayPal button below to pay your
                        ${{ $eventversion->eventversionconfig->participation_fee_amount }}
                        participation fee for this year's event.
                        <div style="margin: auto;">
                            <x-paypals.25.73.paypal_button
                                amountduenet="{{ $eventversion->eventversionconfig->participation_fee_amount }}"
                                :eventversion="$eventversion"
                                :registrant="auth()->user()->currentRegistrant($eventversion)"
                                :school="auth()->user()->currentSchool($eventversion)"
                            />
                        </div>
                    @endif
                </h3>
            </div>
        </div>

    @endauth
@endsection
