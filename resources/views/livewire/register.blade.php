<div style=" font-size: 1.3rem; padding:0 4px;">
    <div style="border: 1px solid darkred; padding: .5rem; margin-top: 1rem;">
        <div style="text-align:center;">
            <u>Please Do Not Create Multiple Accounts.</u>
        </div>
        <div>
            If you have previously auditioned for NJ All-State Chorus, an SJCDA Chorus, CJMEA Chorus or All-Shore chorus,
            you already have an account in StudentFolder.info.
        </div>
        <div>
            If you forgot your username or password, <a href="{{ route('sfdi.password_request.create') }}">please click here</a>!
        </div>
    </div>

    <div style="padding: 0.25rem;">
        <h4 class="text-muted text-center mt-4">{{ __('Register') }}</h4>
        <h6>
            <span style="color: darkred;">
            {{__('All fields are required. If you do not have an email address, your Director can create an account for you.')}}
            </span>
        </h6>
    </div>

    <div class="p-2">

        <form wire:submit.prevent="store" method="POST" class="form-horizontal m-t-20">
            @csrf
            <div class="form-group row">
                <div class="col-12">

                    {!! $duplicates !!}

                    {{-- FIRST & LAST NAME --}}
                    <div class="form-group row">
                        <div class="col-6">
                            <input wire:model.lazy="first" id="first" type="text" class="form-control @error('first') is-invalid @enderror" value="{{ old('first') }}" required autocomplete="first" autofocus placeholder="{{ __('First Name') }}">
                            @error('first')
                            <span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
								</span>
                            @enderror
                        </div>
                        <div class="col-6">
                            <input wire:model.lazy="last" id="last" type="text" class="form-control @error('last') is-invalid @enderror" name="last" value="{{ old('last') }}" required autocomplete="last" placeholder="{{ __('Last Name') }}">
                            @error('last')
                            <span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
								</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- EMAIL ADDRESS --}}
            <div class="form-group row">
                <div class="col-12">
                    <input wire:model="email" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="{{ __('Email Address') }}" >
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            {{-- TEACHER --}}
            <div class="form-group row">
                <div class="col-12">
                    @if(strlen($teacherandschool))
                        <div class="row">
                            <div class="col-12">
                                <h6>Teacher and School</h6>
                                <div style="font-size: 1rem; margin-left: 1rem;">
                                    {{ $teacherandschool }}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row">

                            <div class="col-12">
                                <input wire:model="teacherlast" id="teacher_last" type="text" class="form-control @error('teacher_last') is-invalid @enderror" name="teacher_last" value="{{ old('teacher_last') }}" required autocomplete="teacher_last" placeholder="{{ __("Enter your teacher's Last Name") }}">
                                @error('teacher_last')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @if($teachers && count($teachers))
                                <div style="display: flex; flex-direction: column; font-size: .8rem; padding: 1rem;">
                                    <div>Select Teacher and School</div>
                                    @forelse($teachers AS $teacher)
                                        @if(! strpos($teacher->name,'Studio'))
                                            <div wire:click="teacherAndSchool({{ $teacher->user_id }},{{ $teacher->id }})" style="color: blue; cursor: pointer;">
                                                {{ $teacher->last.','.$teacher->first.': '.$teacher->name.' ('.$teacher->postalcode.')' }}
                                            </div>
                                        @endif
                                    @empty
                                    @endforelse
                                </div>
                            @endif
                        </div>
                    @endif

                </div>
            </div>

            {{-- GRADE --}}
            <div class="form-group row">
                <div class="col-12">
                    <!-- {{-- <input wire:model="grade" id="grade" type="grade" class="form-control @error('grade') is-invalid @enderror" name="grade" value="{{ old('grade') }}" autocomplete="grade" placeholder="{{ __('Grade') }}" > --}} -->
                    <select wire:model="grade" id="grade" class="form-control @error('grade') is-invalid @enderror">
                        @for($i=12;$i>3;$i--)
                            <option value="{{ $i }}">Grade: {{ $i }}</option>
                        @endfor
                    </select>
                    @error('grade')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            {{-- VOICE PART --}}
            <div class="form-group row">
                <div class="col-12">
                    <input wire:model="voicepart" id="voicepart" type="text" class="form-control @error('voicepart') is-invalid @enderror" name="voicepart" value="{{ old('voicepart') }}" autocomplete="voicepart" placeholder="{{ __('Voice part') }}" >
                    @error('voicepart')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <div class="advisory d-none text-dark visible border border-danger p-2 m-5">
                We found this email in the database.  There are generally two reasons for this:
                <ol>
                    <li>You have an existing account on StudentFolder.info.
                        <ul>
                            <li>Please <b>DO NOT</b> create duplicate accounts.</li>
                            <li>Check with your teacher or use the '<a href="{{ route('usernameRequest.edit') }}">Forgot Your Username?</a>' from the <a href="{{ route('login') }}">Log In</a> page.</li>
                        </ul>
                    </li>
                    <li>You use a shared/family email address.
                        <ul>
                            <li>Your teacher can create an account for you using your shared email address.</li>
                        </ul>
                    </li>
                </ol>
            </div>

            {{-- EMERGENCY CONTACT --}}
            <div id="emergency-contact" style="font-size: 1rem;padding-top: 0.25rem; padding-bottom: 0.25rem; border-top: 1px solid darkred; border-bottom: 1px solid darkred; margin-bottom: 1rem;">
                <div style="padding-top: .25rem;">
                    <header style="color: darkred; ">Emergency Contact Information</header>
                </div>

                <div class="flex mb-2 relative pt-2">

                    <label for="parent-first" class="block text-sm font-medium leading-5 text-gray-700 pt-2"
                           style="width: 8rem;">
                        Parent Name
                    </label>

                    <div id="parent-names" class="flex flex-col">
                        <div class="mt-1 relative rounded-md">
                            <input wire:model.lazy="parentfirst" class="rounded" type="text" id="parentfirst" value=""
                                   style="border: 1px solid lightgrey; width: 100%;"
                                   placeholder="First"
                                   required
                            />

                            @error('parentfirst')
                            <p class="mt-2 text-sm text-red-600" id="parentfirst-error">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="mt-1 relative rounded-md">
                            <input wire:model.lazy="parentlast" class="rounded" type="text" id="parentlast" value=""
                                   style="border: 1px solid lightgrey; width: 100%;"
                                   placeholder="Last"
                                   required
                            />

                            @error('parentlast')
                            <p class="mt-2 text-sm text-red-600" id="parentlast-error">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex mb-2 relative pt-2">

                    <label for="parentemail" class="block text-sm font-medium leading-5 text-gray-700 pt-2"
                           style="width: 8rem;">
                        Parent Email
                    </label>

                    <div class="mt-1 relative rounded-md ">
                        <input wire:model.lazy="parentemail" class="rounded" type="email" id="parentemail" value=""
                               style="border: 1px solid lightgrey; width: 100%;"
                               required
                        />

                        @error('parentemail')
                        <p class="mt-2 text-sm text-red-600" id="parentemail-error">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>

                <div class="flex mb-2 relative pt-2">
                    <label for="parentcell" class="block text-sm font-medium leading-5 text-gray-700 pt-2"
                           style="width: 8rem;">Parent Cell</label>

                    <div class="mt-1 relative rounded-md">
                        <input wire:model="parentcell" class="rounded" type="text" id="parentcell" value=""
                               style="border: 1px solid lightgrey; width: 100%;"
                               required
                        />

                        @error('parentcell')
                        <p class="mt-2 text-sm text-red-600" id="parentcell-error">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- PASSWORD --}}
            <div class="form-group row">
                <div class="col-12">
                    <input wire:model="password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="{{ __('Password') }}">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12">
                    <input wire:model="passwordconfirmation" id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Confirm Password') }}">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12">
                    <div class="custom-control custom-checkbox">
                        <input class="form-check-input custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label custom-control-label" for="remember">{{ __('Remember Me') }}</label>
                    </div>
                </div>
            </div>
            <div class="form-group text-center row m-t-20">
                <div class="col-12">
                    <button class="btn btn-primary btn-block waves-effect waves-light" id="register_btn" type="submit" >{{ __('Register') }}</button>
                </div>
            </div>

            <div class="form-group m-t-10 mb-0 row">
                <div class="col-sm-7 m-t-20">
                    @if (Route::has('login'))
                        <a class="text-muted" href="{{ route('login') }}">
                            <i class="mdi mdi-arrow-left"></i> {{ __('Back to login') }}
                        </a>
                    @endif
                </div>
            </div>

        </form>
    </div>
</div>
