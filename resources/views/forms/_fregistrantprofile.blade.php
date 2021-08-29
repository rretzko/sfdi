<div id="tdr_form">
    <form class="" method="post" action="{{route('registrant.update', ['registrant' => $registrant])}}">
        @csrf

        @if(count($errors))
            <div class="form-group row ml-1 col-10 border border-danger pl-1 pr-1 text-danger">
                Errors have been found and are highlighted in red.
            </div>
        @endif

        <div class="card m-t-40 mb-2">
            <div class="card-body">
                <h4 class="mt-0 header-title">Audition Profile</h4>

                <!-- NAME -->
                <div class="form-group row">
                    <label for="name" class="col-12 ml-1 col-form-label">Name (as it will appear in the program)</label>
                    <div class="row col-sm-12 ml-1">
                        <input name="programname" id="programname" value="{{ $registrant->auditiondetail->programname }}" />
                    </div>

                </div>

                <!-- SCHOOL -->
                <div class="form-group">
                    <div class="col-11 ml-2 ">
                        School:
                        <strong>
                            {{ $registrant->school()->name }}
                        </strong>
                    </div>
                </div>

                <!-- GRADE/CLASS -->
                <div class="form-group">
                    <div class="col-11 ml-2 ">
                        Grade/Class:
                        <strong>
                            {{ $registrant->student->gradeClassOf }}
                            ({{ $registrant->student->class_of }})
                        </strong>
                        <span class="text-small text-muted italic">Change on
                            <a href=" {{ route('profile') }}"
                            >
                                Students Profile
                            </a>
                            if necessary
                        </span>
                    </div>
                </div>

                <!-- HEIGHT -->
                @if($requiredheight)
                    <div class="form-group">
                        <div class="col-11 ml-2 ">
                            Height:
                            <strong>
                                {{ $registrant->student->heightFootInches }}
                            </strong>
                                <span class="text-small text-muted italic">Change on
                            <a href=" {{ route('profile') }}"
                            >
                                Students Profile Options
                            </a>
                            if necessary
                        </span>
                        </div>
                    </div>
                @endif

                <!-- SHIRT SIZE -->
               @if($requiredshirtsize)
                    <div class="form-group">
                        <div class="col-11 ml-2 ">
                            Shirtsize:
                            <strong>
                                {{ $registrant->student->shirtsizeDescr }}
                            </strong>
                                <span class="text-small text-muted italic">Change on
                            <a href=" {{ route('profile') }}"
                            >
                                Students Profile Options
                            </a>
                            if necessary
                        </span>
                        </div>
                    </div>
                @endif

                <!-- PRONOUN -->
                <div class="col-11 ml-2 ">
                    Pronoun:
                    <strong>
                        {{ $pronoun }}
                    </strong>
                        <span class="text-small text-muted italic">Change on
                            <a href=" {{ route('profile') }}"
                            >
                                Students Profile
                            </a>
                            if necessary
                        </span>
                </div>
            </div>
        </div>

        <!-- APPLICATION -->
        <div class="container">

            <!-- ADVISORY -->
            <!-- {-- <div class="border border-danger text-center text-danger">
                @if($self_registration_open) Applications will be accepted through midnight tonight.
                @else Self-registration is closed for {{ $eventversion->name }}.
                @endif
            </div> --} -->

            @if($self_registration_open || ($isRegistered && $video_registration_open) || (auth())->id() === 8457)
                <!-- VOICINGS AND INSTRUMENTS -->
                <div class="card m-t-40 mb-2">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Audition
                            @if($choral && $instrumental)
                                @if($auditioncount < 2) Voice Part and Instrument @else Voice Parts and Instruments @endif
                            @elseif($instrumental)
                                @if ($auditioncount < 2) Instrument @else Instruments @endif
                            @else
                                @if ($auditioncount < 2) Voice Part @else Voice Parts @endif
                            @endif
                        </h4>

                        <div class="form-group row" style="margin-top: 45px;">
                            <div class="col">

                                <!-- OPTIONAL HEADER IF MORE THAN 1 AUDITION ALLOWED -->
                                @if($auditioncount > 1)<span class="font-13 text-muted col-form-sublabel"> Primary</span> @endif

                                <select name="chorals[]" id="chorals_0"
                                        class="form-control">
                                    <option value="0">Select</option>
                                    @foreach($chorals AS $part)
                                        <option value="{{$part->id}}"
                                        {{($part->id == $registrant_chorals[0]) ? 'SELECTED' : ''}}
                                            >{{$part->ucwordsDescription}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if($auditioncount > 1)
                                <div class="col">
                                    <span class="font-13 text-muted col-form-sublabel">Secondary</span>
                                    <select name="chorals[]" id="chorals_1"
                                            class="form-control">
                                        <option value="0">Select</option>
                                        @foreach($chorals AS $part)
                                            <option value="{{$part->id}}"
                                            {{($part->id == $registrant_chorals[1]) ? 'SELECTED' : ''}}
                                                >{{$part->ucwordsDescription}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else <input type="hidden" name="chorals[]" value="0" />
                            @endif

                            @if($auditioncount > 2)
                                <div class="col">
                                    <span class="font-13 text-muted col-form-sublabel">Alternate</span>
                                    <select name="chorals[]" id="chorals_2"
                                            class="form-control">
                                        <option value="0">Select</option>
                                        @foreach($chorals AS $part)
                                            <option value="{{$part->id}}"
                                            {{($part->id == $registrant_chorals[2]) ? 'SELECTED' : ''}}
                                                >{{$part->ucwordsDescription}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else <input type="hidden" name="chorals[]" value="0" />
                            @endif
                        </div><!-- form-group row-->

                        <!-- INSTRUMENTALS PLACEHOLDER -->
                        <input type="hidden" name="instrumentals[]" value="0" />
                        <input type="hidden" name="instrumentals[]" value="0" />
                        <input type="hidden" name="instrumentals[]" value="0" />

                    </div><!-- card-body -->
                </div>

                <!-- SAVE REGISTRATION OPTIONS -->
                <div class="ml-4">
                    @if($registrant->auditiondetail->statustype_Descr() === 'registered')
                        <span style="color: darkred;">
                            Your director has finalized your registration.
                        </span>
                    @else
                        <x-buttonSaveCancelChangesComponent />
                    @endif
                </div>

            </form><!-- Audition qualities -->

            <!-- APPLICATION DOWNLOAD -->
            <div class="card m-t-40 mb-2" style="background-color: rgba(0, 0, 0, .05);">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Application
                        <span class="text-muted italic" >
                            (Save changes BEFORE updating application!)
                        </span>
                    </h4>

                    <div>
                        @if($registrant->auditiondetail->hasVoicing)
                            @if($registrant->eapplication)
                                <span class="color-success">Your application has been approved! </span>
                            @else
                                <a href="{{route('eapplication.edit',['registrant' => $registrant])}}" class="btn btn-primary waves-effect waves-light">eApplication</a>
                            @endif
                        @else
                            <p>The following must be corrected before an application can be printed:</p>
                            <ul>
                                <li>Audition voicings selection is missing</li>
                            </ul>
                        @endif
                    </div>

                </div>
            </div>

            <!-- SHORT-FORM INVOICE -->
            <div id="invoice" class="container border">
                <h4>Payments</h4>
                <table class="text-right">
                    <tbody>
                        <tr>
                            <td>Amount Due</td>
                            <th class="pl-3">${{ number_format($registration_fee, 2) }}</th>
                        </tr>
                        <tr>
                            <td>Amount Paid</td>
                            <th class="pl-3">${{ number_format($registrant_paid, 2) }}</th>
                        </tr>
                        <tr>
                            <td>Amount Due</td>
                            <th class="pl-3">@if( strstr($registrant_due, '-')) Overpayment @endif
                                ${{ number_format($registrant_due, 2) }}
                            </th>
                        </tr>
                    </tbody>
                </table>

            </div>

            <!-- PAYPAL -->
            @if($registrant->canPaypal())
                <div class="card m-t-40 mb-2 border-0" >
                    <div class="card-body">
                        <h4 class="mt-0 header-title">PayPal</h4>

                        <div class="paypalstudent mt-3">

                            <div class="descr m-b-5">
                                You can use PayPal to directly process your ${{ number_format($registration_fee,2) }} application fee.<br />
                                <b>Confirm that the select box below displays the correct option!</b>
                            </div>

        <!-- start code directly from PayPal -->
                            <div id="smart-button-container">
                                <div style="text-align: center;">
                                  <div id="paypal-button-container"></div>
                                </div>
                            </div>

                        <!-- ALL-SHORE CHORUS -->
                        @if($eventversion->id == 61)
                            <script src="https://www.paypal.com/sdk/js?client-id=AVgkHTtHdeKot57GhJ5gBplnqNqR_hJOveftQHxAaWxtBfXhNPJu99bDc2yxFUEQaBx_QOWAgITlJtD2&currency=USD" data-sdk-integration-source="button-factory"></script>
                            <script>
                              function initPayPalButton() {
                                paypal.Buttons({
                                  style: {
                                    shape: 'pill',
                                    color: 'gold',
                                    layout: 'vertical',
                                    label: 'paypal',

                                  },

                                createOrder: function(data, actions) {
                                  return actions.order.create({
                                    purchase_units: [{"description":"All-Shore Chorus 2020 Student Registration","amount":{"currency_code":"USD","value":{{ $registration_fee }}}}]
                                  });
                                },

                                onApprove: function(data, actions) {
                                  return actions.order.capture()
                                      .then(function(details) {
                                          alert('Transaction completed by ' + details.payer.name.given_name + ' for $'+{{$registration_fee }}+'!');
                                          logPaypalPayment(data.orderID, {{ $registration_fee }}, {{ $registrant->auditionnumber }});
                                          $('.paypalstudent').addClass('d-none');
                                        });
                                },

                                onError: function(err) {
                                  console.log(err);
                                }
                              }).render('#paypal-button-container');
                            }
                            initPayPalButton();

                          </script>

                        @endif

                        <!-- SJCDA -->
                        @if(($eventversion->id > 61) && ($eventversion->id < 65))

                                <div id="smart-button-container">
                                    <div style="text-align: center;">
                                        <div style="margin-bottom: 1.25rem;">
                                            <p>SJCDA 2021 Virtual Choruses</p>
                                            <select id="item-options"><option value="Jr or Sr HS Chorus" price="15" @if(isset($select_jrsr)){{ $select_jrsr }} @endif>Jr or Sr HS Chorus - 15 USD</option><option value="Elementary Chorus" price="10" @if(isset($select_elem)){{ $select_elem }} @endif>Elementary Chorus - 10 USD</option></select>
                                            <select style="visibility: hidden" id="quantitySelect"></select>
                                        </div>
                                        <div id="paypal-button-container"></div>
                                    </div>
                                </div>
                                <script src="https://www.paypal.com/sdk/js?client-id=ASQ0S-J8FN0jLmw3GBj4GarsKfa_0-36zIj9NJbaey_FBN0NXMIfl-b1APAoBlo99hqS_ZhDns3Tg6ZB&currency=USD" data-sdk-integration-source="button-factory"></script>
                                <script>
                                    function initPayPalButton() {
                                        var shipping = 0;
                                        var itemOptions = document.querySelector("#smart-button-container #item-options");
                                        var quantity = parseInt();
                                        var quantitySelect = document.querySelector("#smart-button-container #quantitySelect");
                                        if (!isNaN(quantity)) {
                                            quantitySelect.style.visibility = "visible";
                                        }
                                        var orderDescription = 'SJCDA 2021 Virtual Choruses '+{{ $payment_hints }}+" "+{{$registrant->student->activeSchool->id }}+" "+{{ $registrant->user_id }};
                                        if(orderDescription === '') {
                                            orderDescription = 'Item';
                                        }
                                        paypal.Buttons({
                                            style: {
                                                shape: 'rect',
                                                color: 'gold',
                                                layout: 'vertical',
                                                label: 'paypal',

                                            },
                                            createOrder: function(data, actions) {
                                                var selectedItemDescription = itemOptions.options[itemOptions.selectedIndex].value;
                                                var selectedItemPrice = parseFloat(itemOptions.options[itemOptions.selectedIndex].getAttribute("price"));
                                                var tax = (0 === 0) ? 0 : (selectedItemPrice * (parseFloat(0)/100));
                                                if(quantitySelect.options.length > 0) {
                                                    quantity = parseInt(quantitySelect.options[quantitySelect.selectedIndex].value);
                                                } else {
                                                    quantity = 1;
                                                }

                                                tax *= quantity;
                                                tax = Math.round(tax * 100) / 100;
                                                var priceTotal = quantity * selectedItemPrice + parseFloat(shipping) + tax;
                                                priceTotal = Math.round(priceTotal * 100) / 100;
                                                var itemTotalValue = Math.round((selectedItemPrice * quantity) * 100) / 100;

                                                return actions.order.create({
                                                    purchase_units: [{
                                                        description: orderDescription,
                                                        amount: {
                                                            currency_code: 'USD',
                                                            value: priceTotal,
                                                            breakdown: {
                                                                item_total: {
                                                                    currency_code: 'USD',
                                                                    value: itemTotalValue,
                                                                },
                                                                shipping: {
                                                                    currency_code: 'USD',
                                                                    value: shipping,
                                                                },
                                                                tax_total: {
                                                                    currency_code: 'USD',
                                                                    value: tax,
                                                                }
                                                            }
                                                        },
                                                        items: [{
                                                            name: selectedItemDescription,
                                                            unit_amount: {
                                                                currency_code: 'USD',
                                                                value: selectedItemPrice,
                                                            },
                                                            quantity: quantity
                                                        }]
                                                    }]
                                                });
                                            },
                                            onApprove: function(data, actions) {
                                                return actions.order.capture().then(function(details) {
                                                    alert('Transaction completed by ' + details.payer.name.given_name + '!');
                                                });
                                            },
                                            onError: function(err) {
                                                console.log(err);
                                            },
                                        }).render('#paypal-button-container');
                                    }
                                    initPayPalButton();
                                    console.log('Some string '+{{ $registrant->auditionnumber }}+": "+{{ $registrant->user_id }}+": "+{{ $registrant->student->activeSchool->id }});
                                </script>
                        @endif

                        @if(($eventversion->id > 99) && ($eventversion->id < 100))
                                <div id="smart-button-container">
                                    <div style="text-align: center;">
                                        <div id="paypal-button-container"></div>
                                    </div>
                                </div>
                                <script src="https://www.paypal.com/sdk/js?client-id=ASQ0S-J8FN0jLmw3GBj4GarsKfa_0-36zIj9NJbaey_FBN0NXMIfl-b1APAoBlo99hqS_ZhDns3Tg6ZB&components=buttons,funding-eligibility"></script>
                                <script>
                                    var FUNDING_SOURCES = [
                                        paypal.FUNDING.PAYPAL,
                                        paypal.FUNDING.CREDIT,
                                        paypal.FUNDING.CARD
                                    ];
                                    // Loop over each funding source/payment method
                                    FUNDING_SOURCES.forEach(function(fundingSource) {

                                        // Initialize the buttons
                                        var button = paypal.Buttons({
                                            fundingSource: fundingSource
                                        });

                                        // Check if the button is eligible
                                        if (button.isEligible()) {

                                            // Render the standalone button for that funding source
                                            button.render('#paypal-button-container');
                                        }
                                    });

                                    function initPayPalButton() {
                                        paypal.Buttons({
                                            style: {
                                                shape: 'pill',
                                                color: 'blue',
                                                layout: 'vertical',
                                                label: 'paypal',

                                            },

                                            createOrder: function(data, actions) {
                                                return actions.order.create({
                                                    purchase_units: [{"description":"SJCDA 2021 Events","amount":{"currency_code":"USD","value":15}}]
                                                });
                                            },

                                            onApprove: function(data, actions) {
                                                return actions.order.capture().then(function(details) {
                                                    alert('Transaction completed by ' + details.payer.name.given_name + '!');
                                                });
                                            },

                                            onError: function(err) {
                                                console.log(err);
                                            }
                                        }).render('#paypal-button-container');
                                    }
                                    initPayPalButton();
                                </script>
                        @endif

        <!-- end code directly from PayPal -->

                        </div>

                    </div>
                </div>
            @endif

    <!-- PITCH FILES -->
    <div class="text-black" style="margin-top: 1rem;border: 1px solid darkgrey; padding: .5rem;">
        <button class="btn btn-primary waves-effect waves-light">
            <a href="{{ route('pitchfiles',[$eventversion]) }}" style="color: white;"> Pitch files for this year's auditions can be found here!</a>
        </button>
    </div>
            <!-- VIDEO REVIEWS -->
    <div id="advisory" class="text-center border border-lite bg-info text-white mb-2" style="margin: 1rem 0;">
        Student video collection begins on: {{ Carbon\Carbon::parse($eventversion->eventversiondates->where('datetype_id', \App\Datetype::where('descr', 'videos_student_open')->first()->id)->first()->dt)->format('F jS') }}
        <!-- {{--  and ends on {{ Carbon\Carbon::parse($eventversion->eventversiondates->where('datetype_id', \App\Datetype::where('descr', 'videos_student_close')->first()->id)->first()->dt)->format('F jS') }} --}} -->
        and ends on March 8th at midnight.
    </div>
            @if(($eventversion->hasVideos && $eventversion->collectVideos) || (auth()->id() === 8457))
                <div class="card m-t-40 mb-2" style="background-color: rgba(200, 150, 255, .05);">
                    <div class="card-body p-xs-0">
                        <h4 class="mt-0 header-title">Videos
                        </h4>

                        <div class="form-group column" style="margin-top: 45px;">

                            @foreach($eventversion->videos AS $videotype)
                                <div class="form-group " style="border-bottom: 1px solid darkgrey;">
                                    <h5>{{ ucwords($videotype->descr) }}: <b>{{ $video_titles[$eventversion->id][$videotype->id] }}</b></h5>

                                    <div class="video_player" >
<!-- {{--                               @if(($videotype->descr !== "performance") &&
                                            $registrant->hasVideotype($videotype))
                                            <div class="player_stats row col-12" >
                                                <div class="player col-lg-7 " >
                                                    {!! $registrant->video($videotype)['fembed_code'] !!}
                                                </div>
                                                <div class="stats sm-col-12 col-lg-5" >
                                                    <div class="items mb-3">
                                                        <div class="data_row col-12">
                                                            <div class="registrant">{{ $registrant->auditiondetail->programname }}</div>
                                                            <div class="filenname">{{ $registrant->video($videotype)['title'] }}</div>
                                                            <div class="duration">{{ number_format($registrant->video($videotype)['duration'],0) }} seconds</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 " >
                                                        <!-- REMOVE OR APPROVED ACTION -->
                                                        @if($registrant->video($videotype)['approved'])
                                                            <div class="remove col-6">
                                                                <span class="text-info">
                                                                    Approved
                                                                </span>
                                                            </div>
                                                        @else
                                                            <div class="remove col-6 " server_id="{{ $registrant->video($videotype)['id'] }}" >
                                                                <span class="text-danger"
                                                                   style="font-size: .8rem; cursor:pointer;"
                                                                   title="Remove this video"
                                                                   >
                                                                    Remove
                                                                </span>
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($videotype->descr === "performance")
                                            <div>Performance video upload will be available after registration period ends.</div>
                                        @else
--}} -->                                    <form action='https://api.sproutvideo.com/v1/videos'
                                                  method='post'
                                                  enctype='multipart/form-data'
                                                  class="p-3 shadow-lg rounded"
                                                  style="background-color: rgba(255, 0, 0, .05);"
                                            >

                                                @csrf

                                                <input type="hidden" name="token" value="{{ $videoserver->token($videotype) }}" />
                                                <input type="hidden" name="download_sd" value="true" />
                                                <input type="hidden" name="download_hd" value="true" />

    <!-- {{--                                   <input type="hidden" name="folder_id" value="{{ $folders->where('videotype_id', $videotype->id)->first()->id }}" > --}} -->

                                                <div class="form-group">
                                                    <input type="file" id="video_{{ $videotype->id }}" name="video" accept="video/mp4,video/mov"  />
                                                    <div class="text-small text-muted">.mp4 and .mov files accepted</div>
                                                </div>
                                                <x-button-save-changes-component value="Upload {{ ucwords($videotype->descr) }} Video" />
                                            </form>
                            <!-- {{-- @endif --}} -->
                                    </div>

                                </div>
                            @endforeach

                        </div>
                    </div><!-- card-body -->
                </div>
            @endif <!-- if hasVideos() -->

        @endif <!-- self_registration_open -->
    </div><!-- end of APPLICATION -->

</div><!-- tdr_form -->
