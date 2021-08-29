@extends('layouts.auth')
@extends('navs.navGuest')
@extends('headers.headerSite')


@section('title')
Login
@endsection

@section('content')
<div class="card-body">
	<div class="">
		<h4 class="text-muted text-center font-18 mt-4">{{ __('StudentFolder.info Login') }}</h4>
                @if(Session::has('warning'))<div class='alert alert-danger text-dark'>{{Session('warning')}}</div>@endif
                @if(Session::has('status'))<div class="alert alert-success">{{Session('status')}}</div>@endif
                @if(session()->has('message'))
                    <div class="alert alert-danger text-center">
                        {{ session()->get('message') }}
                    </div>
                @endif
	</div>

	<div class="p-2">

        @if(config('app.url') == 'http://localhost')
		    <form method="POST" action="{{ route('tdr.login.update') }}" class="form-horizontal m-t-20">
        @else
            <form method="POST" action="/tdr/login" class="form-horizontal m-t-20">
        @endif
			@csrf
			<div class="form-group row">
				<div class="col-12">
					<input id="name" type="string" class="form-control @error('User name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="{{ __('Username (NOT your email address)') }}">

					@error('name')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
			</div>

			<div class="form-group row">
				<div class="col-12">
					<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">

					@error('password')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
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
					<button class="btn btn-primary btn-block waves-effect waves-light" type="submit">{{ __('Login') }}</button>
				</div>
			</div>

			<div class="form-group m-t-10 mb-0 row">
				<div class="col-sm-7 m-t-20">
					@if (Route::has('usernameRequest.edit') )
					<a class="text-muted" href="{{ route('usernameRequest.edit') }}">
						<i class="mdi mdi-clipboard-account"></i> {{ __('Forgot Your Username?') }}
					</a>
					@endif
				</div>
				<div class="col-sm-5 m-t-20 text-right">
					@if (Route::has('register'))
					<a class="text-muted" href="{{ route('register') }}">
						<i class="mdi mdi-account-circle"></i> {{ __('Create an account') }}
					</a>
					@endif
				</div>
			</div>

                        <div class="form-group m-t-0 mb-0 row">
				<div class="col-sm-7 m-t-0">
					@if (Route::has('password.request'))
					<a class="text-muted" href="{{ route('password.request') }}">
						<i class="mdi mdi-lock"></i> {{ __('Forgot Your Password?') }}
					</a>
					@endif
				</div>
			</div>
		</form>
	</div>
</div>


@endsection
