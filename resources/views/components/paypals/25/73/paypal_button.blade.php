@props([
'amountduenet',
'eventversion',
'registrant',
'school',
])

{{-- PAYPAL CUSTOM BUTTON WITH IPN--}}
<section class="mt-4">

    <div class="px-4">
        <h4 class="font-bold mb-4 px-4" style="background-color: rgba(0,0,0,0.1); text-align: center;">PayPal Payment Amount Due: ${{ number_format($amountduenet, 2) }}</h4>
       {{-- @if($amountduenet > 0) --}}
            <div class="m-auto" style="width: 12rem;">
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" >
                    <!-- Identify your business so that you can collect the payments. -->
                    <input type="hidden" name="business" value="morrisareahonorchoir@gmail.com" >
                    <input type="hidden" name="notify_url" value="https://thedirectorsroom.com/update_account" >
                    <input type="hidden" name="custom" value="{{ auth()->id().'*'.$registrant->id.'*'.$eventversion->id.'*'.$school->id.'*'.$amountduenet.'*2' }}" >
                    <!-- Specify a subscribe button -->
                    <input type="hidden" name="cmd" value="_xclick" >
                    <!-- Identify the registrant -->
                    <input type="hidden" name="item_name" value="{{ $eventversion->name }}" >
                    <input type="hidden" name="item_number" value="{{ $eventversion->id }}" >
                    <input type="hidden" name="on0" value="{{ auth()->user()->name }}" >
                    <input type="hidden" name="email" value="{{ auth()->user()->email }}" >
                    <input type="hidden" name="currency_code" value="USD" >
                    <input type="hidden" name="amount" value="{{ $amountduenet }}" >
                    <!-- display the payment button -->
                    <input class="rounded-full" type="image" name="submit" src="/assets/images/pp.png">

                </form>

            </div>
        {{-- @endif --}}
    </div>

</section>
