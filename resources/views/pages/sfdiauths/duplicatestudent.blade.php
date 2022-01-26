@extends('layouts.auth')
@extends('navs.navGuest')
@extends('headers.headerSite')

@section('title')
    Register
@endsection

@section('content')
    <div class="card-body">

        <div style="border: 1px solid darkred; padding: .5rem;">
            <div style="text-align:center;">
                <u>Please Do Not Create Multiple Accounts.</u>
            </div>
            <div>
                If you have previously auditioned for NJ All-State Chorus, an SJCDA Chorus, CJMEA Chorus or All-Shore chorus,
                <b>you already have an account in StudentFolder.info</b>.
            </div>
            <div>
                If you forgot your username or password, <a href="{{ route('sfdi.password_request.create') }}">please click here</a>!
            </div>
        </div>

        <div class="">
            <h4 class="text-muted text-center font-18 mt-4">{{ __('Register') }}</h4>
            <h6>{{__('All fields are required. If you do not have an email address, your Director can create an account for you.')}}</h6>
        </div>

        <div class="p-2">
        <!-- {{--
        @if(config('app.url') === 'http://localhost')
		    <form method="POST" action="{{ route('register') }}" class="form-horizontal m-t-20">
        @else
            <form method="POST" action="https://studentfolder.info/register" class="form-horizontal m-t-20">
        @endif
--}} -->
            <section style="border: 1px solid black; padding: .25rem; background-color: rgba(255,0,0,.1);">
                <header style="text-align: center; color: darkred; font-weight: bold;">
                    DUPLICATE RECORDS
                </header>
                <div>
                    <div>
                        Duplicate record(s) have been found for:
                        <b>{{ ($inputs) ? $inputs['first_name'].' '.$inputs['last_name'] : ''}}</b> in grade <b>{{ $inputs ? $inputs['grade'] : ''}}</b>.
                    </div>
                    <div>
                        <ul>

                            <li>If you forgot your username or password,
                                <a href="{{ route('sfdi.password_request.create') }}">please click here</a>
                                to have this information mailed to you!
                            </li>
                            <li>
                                If you are transferring from one school to another (for example: from middle school to high school)
                                your previous teacher can look up your username and the email address in our records.
                            </li>
                            <li>
                                Otherwise, please work with your teacher, {{ $inputs ? $inputs['teacher_first'].' '.$inputs['teacher_last'] : '' }},
                                to create a new record or to get your current username.
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <form method="POST" action="{{ route('sfdi.register') }}" class="form-horizontal m-t-20">
                @csrf
                <div class="form-group row">
                    <div class="col-12">
                        <div class="form-group row">
                            <div class="col-6">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ $inputs ? $inputs['first_name'] : '' }}" required autocomplete="first_name" autofocus placeholder="{{ __('First Name') }}" onblur="studentDuplicate();">
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
								</span>
                                @enderror
                            </div>
                            <div class="col-6">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ $inputs ?  $inputs['last_name'] : '' }}" required autocomplete="last_name" placeholder="{{ __('Last Name') }}">
                                @error('last_name')
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
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $inputs ? $inputs['email'] : '' }}" autocomplete="email" placeholder="{{ __('Email Address') }}" >
                        @error('email')
                        <span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
                        @enderror
                    </div>
                </div>

                {{-- SCHOOL --}}
                <div class="form-group row">
                    <div class="col-12">
                        <input id="school" type="text" class="form-control @error('school') is-invalid @enderror" name="school" value="{{ $inputs ? $inputs['school'] : '' }}" autocomplete="school" placeholder="{{ __('School Name') }}" >
                        @error('school')
                        <span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
                        @enderror
                    </div>
                </div>

                {{-- TEACHER --}}
                <div class="form-group row">
                    <div class="col-12">

                        <div class="row">
                            <div class="col-6 ">
                                <input id="teacher_first" type="text" class="form-control @error('teacher_first') is-invalid @enderror" name="teacher_first" value="{{ $inputs ? $inputs['teacher_first'] : ''}}" required autocomplete="teacher_first" placeholder="{{ __('Teacher First Name') }}" onblur="studentDuplicate();">
                                @error('teacher_first')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-6">
                                <input id="teacher_last" type="text" class="form-control @error('teacher_last') is-invalid @enderror" name="teacher_last" value="{{ $inputs ? $inputs['teacher_last'] : '' }}" required autocomplete="teacher_last" placeholder="{{ __('Teacher Last Name') }}">
                                @error('teacher_last')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>

                {{-- GRADE --}}
                <div class="form-group row">
                    <div class="col-12">
                        <input id="grade" type="grade" class="form-control @error('grade') is-invalid @enderror" name="grade" value="{{ $inputs ? $inputs['grade'] : '' }}" autocomplete="grade" placeholder="{{ __('Grade') }}" >
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
                        <input id="voicepart" type="grade" class="form-control @error('voicepart') is-invalid @enderror" name="voicepart" value="{{ $inputs ? $inputs['voicepart'] : ''}}" autocomplete="voicepart" placeholder="{{ __('Voice part') }}" >
                        @error('voicepart')
                        <span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="{{ __('Password') }}">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Confirm Password') }}">
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
    @push('scripts')
        <script src="https://studentfolder.info/public/assets/js/tdr_main.js"></script>
    @endpush

@endsection

