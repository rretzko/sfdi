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

<form class="" method="post" action="{{route('profile.update')}}">
    @csrf

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Required Fields</h4>
                    <p class="text-muted m-b-30 font-14">The following fields are required:</p>
                    <div class="form-group row">
                        <label for="example-search-input" class="col-sm-2 col-form-label">User ID </label>
                        <div class="col-sm-10">
                            <span class="text-muted">{{$user->id}}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-search-input" class="col-sm-2 col-form-label">Username <span>*</span></label>
                        <div class="col-sm-10">
                            <span class="text-muted">{{$user->name}}</span>
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label for="first_name" class="col-sm-2 col-form-label">Name <span>*</span></label>
                        <div class="col-sm-4 col-multi-column">
                            <input class="form-control" type="text"
                                   id="first_name" name="first_name"
                                   placeholder="First"
                                   value="{{$student->person->first_name}}">
                            @if($errors->has('first_name'))
                                <p class="help text-danger">{{$errors->first('first_name')}}</p>
                            @endif
                        </div>
                        <div class="col-sm-2 col-multi-column">
                            <input class="form-control" type="text"
                                   id="middle_name" name="middle_name"
                                   placeholder="Middle"
                                   value="{{$student->person->middle_name}}">
                        </div>
                        <div class="col-sm-4 col-multi-column">
                            <input class="form-control" type="text"
                                   id="last_name" name="last_name"
                                   placeholder="Last"
                                   value="{{$student->person->last_name}}">
                            @if($errors->has('last_name'))
                                <p class="help text-danger">{{$errors->first('last_name')}}</p>
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
                                   value="{{$student->birthDate}}">
                            @if($errors->has('birthday'))
                                <p class="help text-danger">{{$errors->first('birthday')}}</p>
                            @endif
                            <span class="font-13 text-muted age_result" style="display: block; margin: 7px 2px 0; ">Around <span>18 years</span></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Grade/Class <span>*</span></label>
                        <div class="col-sm-10">
                            <select name="class_of" id="class_of"
                                    class="form-control">
                                @foreach($grades_class_ofs AS $class_of => $value)
                                    <option value="{{$class_of}}"
                                            {{$class_of == $student->class_of ? "SELECTED" : ""}}
                                        >{{$value}}</option>
                                @endforeach
                            </select>
                            @if($errors->has('class_of'))
                                <p class="help text-danger">{{$errors->first('class_of')}}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card m-t-40">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Optional Contact Information</h4>
                    <p class="text-muted m-b-30 font-14">The following contact fields are optional:</p>

                    <!-- PRIMARY EMAIL -->
                    <div class="form-group row">
                        <label for="primary" class="col-sm-2 col-form-label">Primary Email</label>
                        <div class="col-sm-8">
                            <input class="form-control col-11"
                                   type="email"
                                   id="primary" name="emails[]"
                                   placeholder="primary@email.com"
                                   value="{{$student->person->emailPrimary}}">
                            @if($errors->has('emails.0'))
                                <p class="help text-danger">{{$errors->first('emails.0')}}</p>
                            @endif
                            @if(Session::has('primary_email_advisory'))
                                <p class="help text-info">{{Session::get('primary_email_advisory')}}</p>
                            @endif
                        </div>
                        <div class="col-sm-2">
                            @if((!$student->person->emailPrimary))
                            @elseif ($student->person->emailPrimary && $student->person->emailPrimaryVerified)<div class="text-success">VERIFIED</div>
                            @else <div><a href="{{url('verifyEmail', ['id' => $student->person->emailPrimaryId])}}" class="btn btn-danger">VERIFY</a></div>
                            @endif
                        </div>
                    </div>

                    <!-- ALTERNATE EMAIL -->
                    <div class="form-group row">
                        <label for="alternate" class="col-sm-2 col-form-label">Secondary Email</label>
                        <div class="col-sm-8">
                            <input class="form-control col-11" type="text"
                                   id="alternate" name="emails[]"
                                   placeholder="alternate@email.com"
                                   value="{{$student->person->emailAlternate}}">
                            @if($errors->has('emails.1'))
                                <p class="help text-danger">{{$errors->first('emails.1')}}</p>
                            @endif
                            @if(Session::has('alternate_email_advisory'))
                                <p class="help text-info">{{Session::get('alternate_email_advisory')}}</p>
                            @endif
                        </div>
                        <div class="col-sm-2">
                            @if((!$student->person->emailAlternate))
                            @elseif ($student->person->emailAlternate && $student->person->emailAlternateVerified)<div class="text-success">VERIFIED</div>
                            @else <div id="emailAlternateVerifyButton"><a href="{{url('verifyEmail', ['id' => $student->person->emailAlternateId])}}" class="btn btn-danger" role="button">VERIFY</a></div>
                            @endif
                        </div>
                    </div>

                    <!-- PHONES -->
                    <div class="form-group row">
                        <label for="mobile" class="col-sm-2 col-form-label">Cell Phone</label>
                        <div class="col-sm-10">
                            <input class="form-control"
                                   type="phone"
                                   id="mobile" name="phones[]"
                                   placeholder="(123) 456-7890"
                                   value="{{$student->person->phoneMobile}}">
                            @if($errors->has('phones.0'))
                                <p class="help text-danger">{{$errors->first('phones.0')}}</p>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="home" class="col-sm-2 col-form-label">Home Phone</label>
                        <div class="col-sm-10">
                            <input class="form-control col-11" type="phone"
                                   id="home" name="phones[]"
                                   placeholder="(123) 456-7890"
                                   value="{{$student->person->phoneHome}}">
                            @if($errors->has('phones.1'))
                                <p class="help text-danger">{{$errors->first('phones.1')}}</p>
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
                            <select name="shirt_size" id="shirt_size"
                                    class="form-control">
                                @foreach($shirt_sizes AS $shirt_size)
                                    <option value="{{$shirt_size->id}}"
                                            {{$shirt_size->id == $student->shirt_size ? "SELECTED" : ""}}
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
                        <div class="col">
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
                    </div>
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
                </div>
            </div>

        </div>
    </div>
</form>
@endsection

@section('pagescripts')
<script type="text/javascript">
    $(document).ready(function() {
        calculate_age($('.calculate_age'))
        calculate_height($('.calculate_height'))
    })
</script>
@endsection
