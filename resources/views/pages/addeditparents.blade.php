@extends('layouts.page')

@section('title')
   @if($person->user_id > 0) Update @else Add @endif Parent/Guardian
@endsection

@section('content')
<div class="row">
    <div class="col-12">

        <form class="parentguardian_add  m-t-40" method="post" action="@if($person->user_id > 0) {{route('updateParent', [$person->user_id])}} @else {{route('storeParent')}}@endif">
            @csrf

            <div class="card">
                <div class="card-body">

                    <h4 class="mt-0 header-title">
                         @if($person->user_id > 0) Update @else Add @endif Parent/Guardian
                    </h4>
                    <p class="text-muted m-b-30 font-14">You can add Parents/Guardian details here:</p>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="parentguardiantype" title="{{ $guardian->user_id }}">Parent/Guardian Type</label>
                        <div class="col-sm-10">
                            <select class="form-control col-12 parentguardiantype focus" id="parentguardiantype" name="parentguardiantype" placeholder="" autofocus>
                                 <option value='-1'>Select</option>
                                 @foreach($parentguardiantypes AS $type)

                                     <option value="{{$type->id}}"
                                         @if(
                                                ($type->id == old('id')) ||
                                                (
                                                    isset($parentguardian) &&
                                                    ($type->id == $guardian->guardiantype_id(auth()->id()))
                                                )
                                            )
                                            SELECTED
                                         @endif

                                     >
                                         {{$type->descr}}
                                     </option>
                                 @endforeach
                             </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="first_name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-4">
                            <input class="form-control" type="text"
                                   id="first" name="first"
                                   placeholder="First"
                                   value="@if($person->user_id) {{$person->first}} @endif" >

                            @if($errors->has('first'))
                                <p class="help text-danger">{{$errors->first('first')}}</p>
                            @endif
                        </div>
                        <div class="col-sm-2">
                            <input class="form-control" type="text"
                                   id="middle" name="middle"
                                   placeholder="Middle"
                                   value="@if($person->user_id) {{$person->middle}} @endif">

                        </div>
                        <div class="col-sm-4">
                            <input class="form-control" type="text"
                                   id="last" name="last"
                                   placeholder="Last"
                                   value="@if($person->user_id) {{$person->last}} @endif">
                            @if($errors->has('last'))
                                <p class="help text-danger">{{$errors->first('last')}}</p>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="guardian_email_primary" class="col-sm-2 col-form-label">Primary Email</label>
                        <div class="col-sm-10">
                            <input class="form-control"
                                   type="email"
                                   id="primary" name="email_guardian_primary"
                                   placeholder="primary@email.com"
                                   value="{{$guardian->user_id ? $guardian->emailPrimary : ''}}">
                            @if($errors->has('email_guardian_primary'))
                                <p class="help text-danger">{{$errors->first('email_guardian_primary')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email_guardian_alternate" class="col-sm-2 col-form-label">Alternate Email</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="email"
                                   id="email_guardian_alternate" name="email_guardian_alternate"
                                   placeholder="alternate@email.com"
                                   value="{{$guardian->emailAlternate}}">
                            @if($errors->has('email_guardian_alternate'))
                                <p class="help text-danger">{{$errors->first('email_guardian_alternate')}}</p>
                            @endif
                        </div>
                    </div>
{{$guardian->user_id}}
                    <div class="form-group row">
                        <label for="mobile" class="col-sm-2 col-form-label">Cell Phone</label>
                        <div class="col-sm-10">
                            <input class="form-control"
                                   type="phone"
                                   id="phone_guardian_mobile" name="phone_guardian_mobile"
                                   placeholder="(123) 456-7890"
                                   value="{{$guardian->phoneCell}}">
                            @if($errors->has('phone_guardian_mobile'))
                                <p class="help text-danger">{{$errors->first('phone_guardian_mobile')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="home" class="col-sm-2 col-form-label">Home Phone</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="phone"
                                   id="phone_guardian_home" name="phone_guardian_home"
                                   placeholder="(123) 456-7890"
                                   value="{{$guardian->phoneHome}}">
                            @if($errors->has('phone_guardian_home'))
                                <p class="help text-danger">{{$errors->first('phone_guardian_home')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="work" class="col-sm-2 col-form-label">Work Phone</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="phone"
                                   id="phone_guardian_work" name="phone_guardian_work"
                                   placeholder="(123) 456-7890"
                                   value="{{$guardian->phoneWork}}">
                            @if($errors->has('phone_guardian_work'))
                                <p class="help text-danger">{{$errors->first('phone_guardian_work')}}</p>
                            @endif
                        </div>
                    </div>
                </div>

                 <div class="card-body">
                    <div class="form-group">
                        <div>
                            <!-- ADD/UPDATE -->
                            <button class="card-link btn btn-primary waves-effect waves-light" type="submit">
                                @if($person->user_id > 0) Update @else Add @endif Parent/Guardian
                            </button>
                            <a href="{{route('parent')}}"
                               title="Go Back" class="card-link">
                                @if($person->user_id > 0) Cancel Changes @else Go Back @endif
                            </a>

                            <!-- DELETE -->
                            @if($person->user_id > 0)
                                <a href="{{action('StudentAddParentController@destroy',['id' => $person->user_id])}}"
                                   title="Delete {{$person->fullName}}'s record" class="card-link text-danger">
                                    -- Delete Record --
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
