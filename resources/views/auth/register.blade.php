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
            Use the Chat button at the bottom-right-hand corner of the page to send us a message and we will send
            you an email with your username and password.
        </div>
    </div>

    <div class="">
        <h4 class="text-muted text-center font-18 mt-4">{{ __('Register') }}</h4>
        <h6>{{__('All fields are required. If you do not have an email address, your Director can create an account for you.')}}</h6>
    </div>

	<div class="p-2">

        @if(config('app.url') === 'http://localhost')
		    <form method="POST" action="{{ route('register') }}" class="form-horizontal m-t-20">
        @else
            <form method="POST" action="https://studentfolder.info/register" class="form-horizontal m-t-20">
        @endif
			@csrf
			<div class="form-group row">
				<div class="col-12">
						<div class="form-group row">
							<div class="col-6">
								<input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus placeholder="{{ __('First Name') }}" onblur="studentDuplicate();">
								@error('first_name')
								<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
							<div class="col-6">
								<input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" placeholder="{{ __('Last Name') }}">
								@error('last_name')
								<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-12">
					<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="{{ __('Email Address') }}" >
					@error('email')
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
