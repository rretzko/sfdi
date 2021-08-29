@extends('layouts.auth')
@extends('navs.navGuest')
@extends('headers.headerSite')

@section('title')
Reset Password
@endsection

@section('content')
<div class="card-body">
	<div class="">
		<h4 class="text-muted text-center font-18 mt-4">Reset Password</h4>
                 @if(Session::has('warning'))<div class='alert alert-danger text-dark'>{{Session('warning')}}</div>@endif
	</div>

	<div class="p-2">

		<form method="POST" action="{{ route('password.update') }}">
			@csrf
			<input type="hidden" name="token" value="{{ $token }}">

			<div class="form-group row">
				<div class="col-12">
					<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="Email Address">
					@error('email')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
			</div>

			<div class="form-group row">
				<div class="col-12">
					<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="New Password">
					@error('password')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
			</div>

			<div class="form-group row">
				<div class="col-12">
					<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
				</div>
			</div>

			<div class="form-group text-center row m-t-20">
				<div class="col-12">
					<button class="btn btn-primary btn-block waves-effect waves-light" type="submit">{{ __('Reset Password') }}</button>
				</div>
			</div>

		</form>
	</div>
</div>
@endsection
