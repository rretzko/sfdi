@extends('layouts.reset')
@extends('navs.navGuest')
@extends('headers.headerSite')

@section('title')
    Forgot Password
@endsection

@section('content')
    <div class="card-body">
        <div class="">
            <h4 class="text-muted text-center font-18 mt-4">{{ __('Reset Password') }}</h4>
            @if(Session::has('warning'))<div class='alert alert-danger text-dark'>{{Session('warning')}}</div>@endif
            @if(Session::has('status'))<div class="alert alert-success">{{Session('status')}}</div>@endif
            @if(session()->has('message'))
                <div class="alert alert-danger text-center">
                    {{ session()->get('message') }}
                </div>
            @endif
        </div>

        <div class="p-2">
            Enter your email below to receive the reset-password instructions
        </div>

        <form method="post" action="{{ route('sfdi.password_request.update') }}">

            @csrf

            <div class="form-group row">
                <div class="col-12">
                    <input id="email" type="email" class="form-control" name="email" value required autocomplete="email" autofocus placeholder="email@addr.ess" />
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12">
                    <input class="btn btn-primary btn-block waves-effect waves-light" type="submit" value="Send Password Reset Link" />
                </div>
            </div>
        </form>

        <div class="p-2">
             <a href="{{ route('login') }}" style="color: darkred;">
                 <i class="mdi mdi-arrow-left"></i> Back to Login
             </a>
        </div>
    </div>
@endsection
