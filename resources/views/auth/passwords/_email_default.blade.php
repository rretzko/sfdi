@extends('layouts.auth')

@section('title')
Reset Password
@endsection

@section('content')
<div class="card-body">
	<div class="">
		<h4 class="text-muted text-center font-18 mt-4">{{ __('Reset Password') }}</h4>
	</div>
	
	<div class="p-2">
		@if (session('status'))
			<div class="alert alert-success" role="alert">
				{{ session('status') }}
			</div>
		@endif

		Enter your email address below to get the instructions to reset the password. 

		<form method="POST" action="{{ route('password.email') }}" class="form-horizontal m-t-20">
			@csrf
			<div class="form-group row">
				<div class="col-12">
					<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email Address">

					@error('email')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror
				</div>
			</div>
			<div class="form-group text-center row m-t-20">
				<div class="col-12">
					<button class="btn btn-primary btn-block waves-effect waves-light" type="submit">{{ __('Send Password Reset Link') }}</button>
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
@endsection