@extends('layouts.auth')
@extends('navs.navGuest')
@extends('headers.headerSite')

@section('title')
Reset Username
@endsection

@section('content')
<div class="card-body">
	<div class="">
		<h4 class="text-muted text-center font-18 mt-4">{{ __('Reset Username') }}</h4>
	</div>

	<div class="p-2">
		@if (session('status'))
			<div class="alert alert-success" role="alert">
				{{ session('status') }}
			</div>
		@endif
                @if (session('err'))
			<div class="alert alert-danger text-dark" role="alert">
				{{ session('err') }}
			</div>
		@endif

		Enter your email address below to have your username emailed to you.

		<form method="POST" action="{{ route('usernameRequest.update') }}" class="form-horizontal m-t-20">
			@csrf
			<div class="form-group row">
				<div class="col-12 mb-1">
					<input id="email" type="string" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email address">

					@error('email')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror
				</div>
                <div class="col-12 ">
                    <button DISABLED class="btn btn-primary btn-block waves-effect waves-light" type="submit">{{ __('Send Username') }}</button>
                </div>

			</div>
<!-- {{--
			<div class="form-group text-center row m-t-20">
				<div class="col-12">
					<button DISABLED class="btn btn-primary btn-block waves-effect waves-light" type="submit">{{ __('Send Username') }}</button>
					<div  style="border: 1px solid darkred; color: darkred; padding: .5rem;">
						The Username reset is temporarily disabled while we get the next release ready.<br />
						Please click on the Chat button at the bottom-right-hand corner of this page and
						we'll send this information to you.  Please include your name, school and teacher name.
					</div>
				</div>
			</div>
--}} -->
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
