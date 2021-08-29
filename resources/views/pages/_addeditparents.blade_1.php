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
                        <label class="col-sm-2 col-form-label" for="parentguardiantype">Parent/Guardian Type</label>
                        <div class="col-sm-10">
                            <select class="form-control col-12 parentguardiantype focus" id="parentguardiantype" name="parentguardiantype" placeholder="" autofocus>
                                 <option value='-1'>Select</option>
                                 @foreach($parentguardiantypes AS $type)

                                     <option value="{{$type->id}}" 
                                         @if(
                                                ($type->id == old('id')) ||
                                                (
                                                    isset($parentguardian) && 
                                                    ($type->id == $parentguardian->parentguardiantype_Id($student->user_id))
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
                                   id="first_name" name="first_name" 
                                   placeholder="First"
                                   value="@if($person->user_id) {{$person->first_name}} @endif" >
                                   
                            @if($errors->has('first_name'))
                                <p class="help text-danger">{{$errors->first('first_name')}}</p>
                            @endif 
                        </div>
                        <div class="col-sm-2">
                            <input class="form-control" type="text" 
                                   id="middle_name" name="middle_name" 
                                   placeholder="Middle" 
                                   value="@if($person->user_id) {{$person->middle_name}} @endif">
                            
                        </div>
                        <div class="col-sm-4">
                            <input class="form-control" type="text" 
                                   id="last_name" name="last_name" 
                                   placeholder="Last" 
                                   value="@if($person->user_id) {{$person->last_name}} @endif">
                            @if($errors->has('last_name'))
                                <p class="help text-danger">{{$errors->first('last_name')}}</p>
                            @endif 
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="primary" class="col-sm-2 col-form-label">Primary Email</label>
                        <div class="col-sm-10">
                            <input class="form-control" 
                                   type="email" 
                                   id="primary" name="emails[]" 
                                   placeholder="primary@email.com" 
                                   value="{{$person->emailPrimary}}">                            
                            @if($errors->has('emails.0'))
                                <p class="help text-danger">{{$errors->first('emails.0')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="alternate" class="col-sm-2 col-form-label">Secondary Email</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="email" 
                                   id="alternate" name="emails[]" 
                                   placeholder="alternate@email.com" 
                                   value="{{$person->emailAlternate}}">
                            @if($errors->has('emails.1'))
                                <p class="help text-danger">{{$errors->first('emails.1')}}</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="mobile" class="col-sm-2 col-form-label">Cell Phone</label>
                        <div class="col-sm-10">
                            <input class="form-control" 
                                   type="phone" 
                                   id="mobile" name="phones[]" 
                                   placeholder="(123) 456-7890" 
                                   value="{{$person->phoneMobile}}">
                            @if($errors->has('phones.0'))
                                <p class="help text-danger">{{$errors->first('phones.0')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="home" class="col-sm-2 col-form-label">Home Phone</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="phone" 
                                   id="home" name="phones[]" 
                                   placeholder="(123) 456-7890" 
                                   value="{{$person->phoneHome}}">
                            @if($errors->has('phones.1'))
                                <p class="help text-danger">{{$errors->first('phones.1')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="work" class="col-sm-2 col-form-label">Work Phone</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="phone" 
                                   id="work" name="phones[]" 
                                   placeholder="(123) 456-7890" 
                                   value="{{$person->phoneWork}}">
                            @if($errors->has('phones.2'))
                                <p class="help text-danger">{{$errors->first('phones.2')}}</p>
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