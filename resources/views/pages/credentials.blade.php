@extends('layouts.page')

@section('title')
Credentials
@endsection

@section('content')

@if(session()->has('message-credentials'))
<div class="row"><div class="col-12">
    <div class="alert alert-success alert-dismissible fade show m-t-40" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    {{session()->get('message-credentials')}}
</div>
</div></div>
@endif


<form method="post" action="credentials/{{$user->id}}">
    @csrf
    @method('PATCH')

    <div class="row">
        <div class="col-12">
            <div class="card m-t-40">
                <div class="card-body">

                    <h4 class="mt-0 header-title">Change Password</h4>
                    <p class="text-muted m-b-30 font-14">You can update your credentials using the below form:</p>

                    <div class="form-group row">
                        <label for="current_password" class="col-sm-2 col-form-label">Current Password</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="password" id="current_password" name="current_password" placeholder="Current Password" value="" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">New Password</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="password" id="password" name="password" placeholder="New Password" value="" >
                            <br>
                            @if($errors->has('password'))
                                <p class="help text-danger">{{$errors->first('password')}}</p>
                            @endif 

                            Must be at least 8-characters and contain:
                                <ul>
                                    <li>One UPPER-CASE</li>
                                    <li>One lower-case</li>
                                    <li>One number</li>
                                    <li>One special character (!@#$%^&*()-_=+)</li>
                                </ul>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password_confirmation" class="col-sm-2 col-form-label">Confirm Password</label>
                        <div class="col-sm-10">
                            <input class="form-control col-12 col-sm-4" type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" value="">
                            <br>
                            @if($errors->has('password_confirmation'))
                                <p class="help text-danger">{{$errors->first('password_confirmation')}}</p>
                            @endif 
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div>
                            <button type="submit" class="card-link btn btn-primary waves-effect waves-light">
                                Update Password
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection