@extends('layouts.page')

@section('title')
Profile
@endsection

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="page-title m-0">
                        Profile
                    </h1>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

@if(config('app.url') === 'http://localhost')
    <form class="" method="post" action="{{route('profile.update')}}">
@else
    <form class="" method="post" action="https://studentfolder.info/profile/update">
@endif

    @csrf

    @if($errors->any())
            <div class="errors" style="background-color: rgba(255,0,0,.1); border:1px solid darkred; color: darkred; padding: 3px;">
                Error count: {{ $errors->count() }}
                <div class="">{{ implode('',$errors->all(':message')) }}</div>
                <ul>
                @foreach($errors AS $key => $error)
                     <li>{{ $key.': '.serialize($error) }}</li>
                @endforeach
                </ul>
            </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Required Fields</h4>
                    <p class="text-muted m-b-30 font-14">The following fields are required:</p>
            <!-- {--         <div class="form-group row">
                        <label for="example-search-input" class="col-sm-2 col-form-label">User ID </label>
                        <div class="col-sm-10">
                            <span class="text-muted">{{$user->id}}</span>
                        </div>
                    </div>
            --} -->
                    <div class="form-group row">
                        <label for="example-search-input" class="col-sm-2 col-form-label">Username <span>*</span></label>
                        <div class="col-sm-10">
                            <span class="text-muted" title="Sys.Id. {{ $user->id }}">{{$user->username}}</span>
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label for="first" class="col-sm-2 col-form-label">Name <span>*</span></label>
                        <div class="col-sm-4 col-multi-column">
                            <input class="form-control" type="text"
                                   id="first" name="first"
                                   placeholder="First"
                                   value="{{$student->person->first}}">
                            @if($errors->has('first'))
                                <p class="help text-danger">{{$errors->first('first')}}</p>
                            @endif
                        </div>
                        <div class="col-sm-2 col-multi-column">
                            <input class="form-control" type="text"
                                   id="middle" name="middle"
                                   placeholder="Middle"
                                   value="{{$student->person->middle}}">
                        </div>
                        <div class="col-sm-4 col-multi-column">
                            <input class="form-control" type="text"
                                   id="last" name="last"
                                   placeholder="Last"
                                   value="{{$student->person->last}}">
                            @if($errors->has('last'))
                                <p class="help text-danger">{{$errors->first('last')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="pronoun_id">Preferred Pronoun <span>*</span></label>
                        <div class="col-sm-10">
                            <select class="form-control" name="pronoun_id" id="pronoun_id">
                                @foreach($pronouns AS $pronoun)
                                    <option value="{{$pronoun->id}}"
                                        {{$pronoun->id == $person->pronoun_id ? "SELECTED" : ""}}
                                        >{{$pronoun->descr}}</option>
                                @endforeach
                            </select>
                            @if($errors->has('pronoun_id'))
                                    <p class="help text-danger">{{$errors->first('pronoun_id')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="birthday" class="col-sm-2 col-form-label">Date of Birth <span>*</span></label>
                        <div class="col-sm-10">
                            <input class="form-control calculate_age" type="date"
                                   id="birthday" name="birthday"
                                   placeholder="02-01-2006"
                                   value="{{$student->birthdate}}">
                            @if($errors->has('birthday'))
                                <p class="help text-danger">{{$errors->first('birthday')}}</p>
                            @endif
                            <span class="font-13 text-muted age_result" style="display: block; margin: 7px 2px 0; ">Around <span>18 years</span></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Grade/Class <span>*</span></label>
                        <div class="col-sm-10">
                            <select name="classof" id="classof"
                                    class="form-control">
                                @foreach($grades_class_ofs AS $class_of => $value)
                                    <option value="{{$class_of}}"
                                            {{$class_of == $student->classof ? "SELECTED" : ""}}
                                        >{{$value}}</option>
                                @endforeach
                            </select>
                            @if($errors->has('classof'))
                                <p class="help text-danger">{{$errors->first('classof')}}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- ADDRESS -->
            <div class="card m-t-40">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Home Address</h4>

                    <!-- ADDRESS_01, 02 -->
                    <div class="form-group row">
                        <label for="address_01" class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-8">
                            <input class="form-control col-11"
                                   type="text"
                                   id="address01" name="address01"
                                   placeholder=""
                                   value="{{$student->person->address && $student->person->address->user_id ? $student->person->address->address01 : ''}}">
                            @if($errors->has('address01'))
                                <p class="help text-danger">{{$errors->first('address01')}}</p>
                            @endif
                            @if(Session::has('address01'))
                                <p class="help text-info">{{Session::get('address01')}}</p>
                            @endif
                        </div>

                    </div>

                    <div class="form-group row" style="margin-top: -1rem;">
                        <label for="address_02" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-8">
                            <input class="form-control col-11"
                                   type="text"
                                   id="address02" name="address02"
                                   placeholder=""
                                   value="{{$student->person->address && $student->person->address->user_id ? $student->person->address->address02 : ''}}">
                            @if($errors->has('address02'))
                                <p class="help text-danger">{{$errors->first('address02')}}</p>
                            @endif
                            @if(Session::has('address02'))
                                <p class="help text-info">{{Session::get('address02')}}</p>
                            @endif
                        </div>
                    </div>

                    <!-- CITY, STATE ZIP -->
                    <div class="form-group row" >
                        <label for="city" class="col-sm-2 col-form-label">City, ST Zip</label>
                        <div class="col-sm-8 col-12 form-row">
                            <input class="form-control col-sm-5 col-6 mr-1"
                                   type="text"
                                   id="city" name="city"
                                   placeholder=""
                                   value="{{ $student->person->address && $student->person->address->user_id ? $student->person->address->city : '' }}">
                            @if($errors->has('city'))
                                <p class="help text-danger">{{$errors->first('city')}}</p>
                            @endif
                            @if(Session::has('city'))
                                <p class="help text-info">{{Session::get('city')}}</p>
                            @endif

                            <select name="geostate_id" class="col-sm-3 col-2 mr-1">
                                @foreach($geostates ?? '' AS $geo)
                                <option value="{{ $geo->id }}" @if(($student->person->address->geostate_id ?? 0) == $geo->id) SELECTED @endif>{{ $geo->abbr }}</option>
                                @endforeach
                            </select>

                            <input class="form-control col-3"
                                type="text"
                                id="postalcode" name="postalcode"
                                placeholder=""
                                value="{{ $student->person->address && $student->person->address->user_id ? $student->person->address->postalcode : '' }}">
                                @if($errors->has('postalcode'))
                                    <p class="help text-danger">{{$errors->first('postalcode')}}</p>
                                @endif
                                @if(Session::has('postalcode'))
                                    <p class="help text-info">{{Session::get('postalcode')}}</p>
                                @endif
                        </div>

                    </div>

                </div>
            </div>

            <!-- COMMUNICATIONS -->
            <div class="card m-t-40">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Optional Contact Information</h4>
                    <p class="text-muted m-b-30 font-14">The following contact fields are optional:</p>

                    <!-- SCHOOL EMAIL -->
                    <div class="form-group row">
                        <label for="email_student_school" class="col-sm-2 col-form-label">School Email</label>
                        <div class="col-sm-8">
                            <input class="form-control col-11"
                                   type="email"
                                   id="email_student_school" name="email_student_school"
                                   placeholder="email@school.org"
                                   value="{{$student->emailSchool}}">
                            @if($errors->has('emails_student_school'))
                                <p class="help text-danger">{{$errors->first('email_student_school')}}</p>
                            @endif
                            @if(Session::has('email_student_school'))
                                <p class="help text-info">{{Session::get('email_student_school')}}</p>
                            @endif
                        </div>
                        <div class="col-sm-2">
                        <!-- {{-- @if((!$student->emailPersonal))
                             @elseif ($student->emailPersonal && $student->person->emailPrimaryVerified)<div class="text-success">VERIFIED</div>
                            @else <div><a href="{{url('verifyEmail', ['id' => $student->person->emailPrimaryId])}}" class="btn btn-danger">VERIFY</a></div>
                            @endif --}} -->
                        </div>
                    </div>

                    <!-- PERSONAL EMAIL -->
                    <div class="form-group row">
                        <label for="email_student_personal" class="col-sm-2 col-form-label">Personal Email</label>
                        <div class="col-sm-8">
                            <input class="form-control col-11" type="text"
                                   id="email_student_personal" name="email_student_personal"
                                   placeholder="personal@email.com"
                                   value="{{$student->emailPersonal}}">
                            @if($errors->has('email_student_personal'))
                                <p class="help text-danger">{{$errors->first('email_student_personal')}}</p>
                            @endif
                            @if(Session::has('email_student_personal_advisory'))
                                <p class="help text-info">{{Session::get('email_student_personal_advisory')}}</p>
                            @endif
                        </div>

                        <div class="col-sm-2">
                        <!-- {{--
                            @if((!$student->person->emailAlternate))
                            @elseif ($student->person->emailAlternate && $student->person->emailAlternateVerified)<div class="text-success">VERIFIED</div>
                            @else <div id="emailAlternateVerifyButton"><a href="{{url('verifyEmail', ['id' => $student->person->emailAlternateId])}}" class="btn btn-danger" role="button">VERIFY</a></div>
                            @endif
                        --}} -->
                        </div>
                    </div>

                    <!-- PHONES -->
                    <div class="form-group row">
                        <label for="mobile" class="col-sm-2 col-form-label">Cell Phone</label>
                        <div class="col-sm-10">
                            <input class="form-control"
                                   type="phone"
                                   id="phone_student_mobile" name="phone_student_mobile"
                                   placeholder="(123) 456-7890"
                                   value="{{$student->phoneMobile}}">
                            @if($errors->has('phone_student_mobile'))
                                <p class="help text-danger">{{$errors->first('phone_student_mobile')}}</p>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="home" class="col-sm-2 col-form-label">Home Phone</label>
                        <div class="col-sm-10">
                            <input class="form-control col-11" type="phone"
                                   id="phone_student_home" name="phone_student_home"
                                   placeholder="(123) 456-7890"
                                   value="{{$student->phoneHome}}">
                            @if($errors->has('phone_student_home'))
                                <p class="help text-danger">{{$errors->first('phone_student_home')}}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card m-t-40">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Optional Profile Information</h4>
                    <p class="text-muted m-b-30 font-14">The following profile fields are optional:</p>
                    <div class="form-group row">
                        <label for="height" class="col-sm-2 col-form-label">Height <small>(inches)</small></label>
                        <div class="col-sm-10">
                            <input class="form-control calculate_height" type="number"
                                   id="height" name="height"
                                   placeholder="Height in inches"
                                   value="{{$student->height}}">
                            <span class="font-13 text-muted height_result" style="display: block; margin: 7px 2px 0; ">That's roughly <span>5&#39;11&#34;</span></span>
                            @if($errors->has('height'))
                                <p class="help text-danger">{{$errors->first('height')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Shirt Size</label>
                        <div class="col-sm-10">
                            <select name="shirtsize_id" id="shirtsize_id"
                                    class="form-control">
                                @foreach($shirt_sizes AS $shirt_size)
                                    <option value="{{$shirt_size->id}}"
                                            {{$shirt_size->id == $student->shirtsize_id ? "SELECTED" : ""}}
                                        >{{$shirt_size->abbr}}</option>
                                @endforeach
                            </select>
                            @if($errors->has('shirt_size'))
                                <p class="help text-danger">{{$errors->first('shirt_size')}}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card m-t-40">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Voicings and Instruments </h4>
                    <p class="text-muted m-b-30 font-14">In the classroom, I sing and/or play...</p>

                    <div class="form-group row" style="margin-top: 45px;">
                        <label class="col-sm-2 col-form-label">Voice Parts</label>
                        <div class="col">
                            <span class="font-13 text-muted col-form-sublabel">Primary</span>
                            <select name="chorals[]" id="chorals_0"
                                    class="form-control">
                                <option value="0">Select</option>
                                @foreach($choral AS $part)
                                    <option value="{{$part->id}}"
                                    {{($part->id == $student_chorals[0]) ? 'SELECTED' : ''}}
                                        >{{$part->ucwordsDescription}}</option>
                                @endforeach
                            </select>
                        </div>
            <!-- {--            <div class="col">
                            <span class="font-13 text-muted col-form-sublabel">Secondary</span>
                            <select name="chorals[]" id="chorals_1"
                                    class="form-control">
                                <option value="0">Select</option>
                                @foreach($choral AS $part)
                                    <option value="{{$part->id}}"
                                    {{($part->id == $student_chorals[1]) ? 'SELECTED' : ''}}
                                        >{{$part->ucwordsDescription}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <span class="font-13 text-muted col-form-sublabel">Alternate</span>
                            <select name="chorals[]" id="chorals_2"
                                    class="form-control">
                                <option value="0">Select</option>
                                @foreach($choral AS $part)
                                    <option value="{{$part->id}}"
                                    {{($part->id == $student_chorals[2]) ? 'SELECTED' : ''}}
                                        >{{$part->ucwordsDescription}}</option>
                                @endforeach
                            </select>
                        </div>
        --} -->


                    </div>
        <!-- {{-- HIDING INSTRUMENTS FOR THE MOMENT
                    <div class="form-group row" style="margin-top: 45px;">
                        <label class="col-sm-2 col-form-label">Instruments</label>
                        <div class="col">
                            <span class="font-13 text-muted col-form-sublabel">Primary</span>
                            <select name="instrumentals[]" id="instrumentals_0"
                                    class="form-control">
                                <option value="0">Select</option>
                                @foreach($instrumental AS $part)
                                    <option value="{{$part->id}}"
                                    {{($part->id == $student_instrumentals[0]) ? 'SELECTED' : ''}}
                                        >{{$part->ucwordsDescription}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <span class="font-13 text-muted col-form-sublabel">Secondary</span>
                            <select name="instrumentals[]" id="instrumentals_1"
                                    class="form-control">
                                <option value="0">Select</option>
                                @foreach($instrumental AS $part)
                                    <option value="{{$part->id}}"
                                    {{($part->id == $student_instrumentals[1]) ? 'SELECTED' : ''}}
                                        >{{$part->ucwordsDescription}}</option>
                                @endforeach
                            </select>
                            @if($errors->has('instrumentals'))
                                <p class="help text-danger">{{$errors->first('instrumentals')}}</p>
                            @endif
                        </div>
                        <div class="col">
                            <span class="font-13 text-muted col-form-sublabel">Alternate</span>
                            <select name="instrumentals[]" id="instrumentals_2"
                                    class="form-control">
                                <option value="0">Select</option>
                                @foreach($instrumental AS $part)
                                    <option value="{{$part->id}}"
                                    {{($part->id == $student_instrumentals[2]) ? 'SELECTED' : ''}}
                                        >{{$part->ucwordsDescription}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
    --}} -->
                </div>
            </div>

            <div class="m-b-30">
                <div class="form-group">
                    @if (\Session::has('message'))
                        <div class="alert alert-success alert-success-black">
                            <ul>
                                <li>{!! \Session::get('message') !!}</li>
                            </ul>
                        </div>
                    @endif
                    <div>
                        <button type="submit" class="card-link btn btn-primary waves-effect waves-light">
                            Save Changes
                        </button>
                        <a href="#" class="card-link">Cancel Changes</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<div class="row">
    <div class="col-12">

    </div>
</div>


@endsection

@section('pagescripts')
<script type="text/javascript">
    $(document).ready(function() {
        calculate_age($('.calculate_age'))
        calculate_height($('.calculate_height'))
    })
</script>
@endsection
