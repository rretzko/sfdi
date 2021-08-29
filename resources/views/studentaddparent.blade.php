@extends('layouts.main')
@extends('headers.headerSite')
@extends('navs.navSubMain')

@section('content')
    <div class="container text-white bg-secondary">
        <div class="row">
                         
            <div class="col-12" id="parentguardian">Parent
            <form class="bg-white text-dark parentguardian_add" method="post" action="{{action('StudentAddParentController@store')}}">
                    @csrf
                    
                    <div class="container">
                        <fieldset class="form-group">
                           <legend>
                                @if($person->user_id > 0) Update
                                @else Add 
                                @endif 
                                Parent</legend>
                            
                            <!-- SYS.ID -->
                          <div class="form-group">
                                <label class="form-control-label">System Id: {{$person->user_id}}</label>
                                <input type="hidden" name="parent_user_id" 
                                       id="parent_User_Id" 
                                       value="{{$person->user_id}}" >
                            </div>
                            <!-- PARENTGUARDIANTYPE -->
                          <div class="form-group">
                                <label class="form-control-label sr-only" for="id">Type</label>
                                <select class="form-control col-12 parentguardiantype focus"  
                                        id="parentguardiantype" name="parentguardiantype" placeholder="" >
                                     <option value='-1'>Select</option>
                                     @foreach($parentguardiantypes AS $type)

                                         <option value="{{$type->id}}" 
                                             @if(
                                                    ($type->id == old('id')) ||
                                                    (
                                                        isset($parentguardian) && 
                                                        ($type->id == $parentguardian->parentguardiantype)
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
                            <!-- NAME -->
                            <div class="form-group">
                                <label class="form-control-label sr-only" for="first_name">Name</label>
                                <div class="form-row"> 
                                    <!-- FIRST NAME -->
                                    <div class="col-sm-3 col-md-4"> 
                                        <input class="form-control" type="text" 
                                               id="first_name" name="first_name" 
                                               placeholder="First" 
                                               value="{{$person->first_name}}">
                                        @if($errors->has('first_name'))
                                            <p class="help text-danger">{{$errors->first('first_name')}}</p>
                                        @endif 
                                    </div>
                                    <!-- MIDDLE NAME -->
                                    <div class="col-sm-3 col-md-4"> 
                                        <input class="form-control" type="text" 
                                               id="middle_name" name="middle_name" 
                                               placeholder="Middle" 
                                               value="{{$person->middle_name}}">
                                    </div>
                                    <!-- LAST NAME -->
                                    <div class="col-sm-3 col-md-4"> 
                                        <input class="form-control" type="text" 
                                               id="last_name" name="last_name" 
                                               placeholder="Last" 
                                               value="{{$person->last_name ?? ''}}">
                                        @if($errors->has('last_name'))
                                            <p class="help text-danger">{{$errors->first('last_name')}}</p>
                                        @endif 
                                    </div>
                                </div><!-- form-row --> 
                            </div><!-- form-group --> 

                            <!-- EMAILS -->
                            <div class="form-group d-flex flex-column">
                                <label class="form-control-label" for="email">Emails 
                                </label>

                                <div class="form-row"> 
                                    <!-- primary email -->
                                    <div class="col-sm-3 col-md-4" > 
                                        <div style="display: flex; flex-direction: row">
                                            <input class="form-control col-11" 
                                                   type="email" 
                                                   id="primary" name="emails[]" 
                                                   placeholder="primary@email.com" 
                                                   value="{{$person->emailPrimary}}">
                                        </div>
                                        @if($errors->has('emails.0'))
                                            <p class="help text-danger">{{$errors->first('emails.0')}}</p>
                                        @endif
                                    </div>

                                    <!-- alternate email -->
                                    <div class="col-sm-3 col-md-4" > 
                                        <div style="display: flex; flex-direction: row;"> 
                                            <input class="form-control col-11" type="email" 
                                                   id="alternate" name="emails[]" 
                                                   placeholder="alternate@email.com" 
                                                   value="{{$person->emailAlternate}}">
                                        </div>
                                        @if($errors->has('emails.1'))
                                            <p class="help text-danger">{{$errors->first('emails.1')}}</p>
                                        @endif
                                    </div>

                                </div>
                            </div><!-- form-group -->
                            
                            <!-- PHONES -->
                             <div class="form-group d-flex flex-column">
                                <label class="form-control-label" for="phone">Phones 
                                    <span class="small">
                                        (Please use: (123) 456-7890 or (123) 456-7890 x3579 format)
                                    </span>
                                </label>

                                <div class="form-row"> 
                                    <!-- mobile -->
                                    <div class="col-sm-3 col-md-4" > 
                                        <div style="display: flex; flex-direction: row">
                                            <input class="form-control col-11" 
                                                   type="phone" 
                                                   id="mobile" name="phones[]" 
                                                   placeholder="cell phone" 
                                                   value="{{$person->phoneMobile}}">
                                        </div>
                                        @if($errors->has('phones.0'))
                                            <p class="help text-danger">{{$errors->first('phones.0')}}</p>
                                        @endif
                                    </div>

                                    <!-- home -->
                                    <div class="col-sm-3 col-md-4" > 
                                        <div style="display: flex; flex-direction: row;"> 
                                            <input class="form-control col-11" type="phone" 
                                                   id="home" name="phones[]" 
                                                   placeholder="home phone" 
                                                   value="{{$person->phoneHome}}">
                                        </div>
                                        @if($errors->has('phones.1'))
                                            <p class="help text-danger">{{$errors->first('phones.1')}}</p>
                                        @endif
                                    </div>
                                
                                    <!-- work -->
                                    <div class="col-sm-3 col-md-4" > 
                                        <div style="display: flex; flex-direction: row;"> 
                                            <input class="form-control col-11" type="phone" 
                                                   id="home" name="phones[]" 
                                                   placeholder="work phone" 
                                                   value="{{$person->phoneWork}}">
                                        </div>
                                        @if($errors->has('phones.2'))
                                            <p class="help text-danger">{{$errors->first('phones.2')}}</p>
                                        @endif
                                    </div>

                                </div>
                            </div><!-- form-group -->

                            
                            <!-- SUBMIT --> 
                            <div class="form-group">
                                <div class="form-row" >
                                    
                                    <!-- ADD/UPDATE -->
                                    <button class="btn btn-primary mr-1" type="submit">
                                        @if($person->user_id > 0) Update
                                        @else Add 
                                        @endif 
                                    </button>
                                    
                                    <!-- DELETE -->
                                    @if($person->user_id > 0) 
                                        <div class='align-middle my-auto'>
                                            <a href="{{action('StudentAddParentController@destroy',['id' => $person->user_id])}}" 
                                               title="Delete {{$person->fullName}}'s record" class="text-danger">
                                                -- Delete Record --
                                            </a>
                                        </div>
                                    @endif 
                                    
                                </div>
                                
                                <!-- DELETE 
                                </div><div class="form-group">
                                    <div class="form-row">
                                        <div class="col">
                                            <button class="btn btn-primary" type="submit">
                                                @if($person->user_id > 0) 
                                                    Delete 
                                                @endif 
                                            </button>
                                        </div>
                                    </div>
                                </div>-->
                            
                            <!-- Advisory -->
                            <!-- no advisory for this view -->
                            
                        </fieldset>
                    </div><!-- container -->
                </form>
                
            </div><!-- class id=parentguardian -->
        </div><!-- row --> 
    </div><!-- container -->
@endsection
