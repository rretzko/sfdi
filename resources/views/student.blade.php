@extends('layouts.main')
@extends('headers.headerSite')
@extends('navs.navStudent')

@section('content')
    <div class="container text-white bg-secondary">
        <div class="row">
            <div class="col-12" id="events">Event(s)</div>
            <div class="col-12" id="profile">My Profile
                 
                <form class="bg-white text-dark" method="post" action="student/{{$student->user_id}}">
                    @csrf
                    @method('PUT')
                    
                    <div class="container">
                        <fieldset class="form-group">
                            <legend>Profile Information</legend>
                            <!-- SYS.ID -->
                            <div class="form-group">
                                <label class="form-control-label">Sys.Id. {{$student->user_id}}</label>
                            </div>
                            <!-- NAME -->
                            <div class="form-group">
                                <label class="form-control-label sr-only" for="first_name">Name</label>
                                <div class="form-row"> 
                                    <div class="col-3"> 
                                        <input class="form-control" type="text" 
                                               id="first_name" name="first_name" 
                                               placeholder="First" 
                                               value="{{$person->first_name}}">
                                    </div>
                                    <div class="col-3"> 
                                        <input class="form-control" type="text" 
                                               id="middle_name" name="middle_name" 
                                               placeholder="Middle" 
                                               value="{{$person->middle_name}}">
                                    </div>
                                    <div class="col-3"> 
                                        <input class="form-control" type="text" 
                                               id="last_name" name="last_name" 
                                               placeholder="Last" 
                                               value="{{$person->last_name}}">
                                    </div>
                                </div><!-- form-row --> 
                            </div><!-- form-group --> 
                            
                             <!-- CLASS -->
                            <div class="form-group">
                                <label class="form-control-label" for="class_of">
                                    @if($student->is_Alum()) Class @else Grade @endif</label>
                                <div class="form-row"> 
                                    <div class="col-3 col-md-2 col-lg-2 col-xl-1"> 
                                        <input class="form-control" type="number" 
                                               id="class_of" name="class_of" 
                                               placeholder="" 
                                               value="{{$student->grade_class_of}}">
                                    </div>
                                </div><!-- form-row --> 
                            </div><!-- form-group -->
                            
                             <!-- HEIGHT -->
                            <div class="form-group">
                                <label class="form-control-label" for="height">
                                    Height in inches</label>
                                <div class="form-row"> 
                                    <div class="col-2 col-lg-1"> 
                                        <input class="form-control" type="number" 
                                               id="height" name="height" 
                                               placeholder="Height in inches" 
                                               value="{{$student->height}}">
                                    </div>
                                    <div class="col-1 hint pt-1" id="ft_in">
                                        {{$student->height_Foot_Inches}}
                                    </div>
                                </div><!-- form-row -->
                            </div><!-- form-group -->
                                
                            <!-- BIRTHDAY -->
                            <div class="form-group">
                                <label class="form-control-label" for="birthday">
                                    Birthday</label>
                                <div class="form-row"> 
                                    <div class="col-5 col-md-4 col-lg-3 col-xl-2"> 
                                        <input class="form-control" type="date" 
                                               id="birthday" name="birthday" 
                                               placeholder="Birthday" 
                                               value="{{$student->birthday}}">
                                    </div>
                                </div><!-- form-row -->
                            </div><!-- form-group -->
                            
                            <!-- SHIRT SIZE -->                           
                            <div class="form-group">
                                <label class="form-control-label" for="shirt_size">
                                    Shirt Size</label>
                                <div class="form-row"> 
                                    <div class="col-5 col-md-4 col-lg-3 col-xl-2">
                                        <select name="shirt_size" id="shirt_size">
                                            @foreach($shirt_sizes AS $shirt_size)                                              
                                                <option value="{{$shirt_size->id}}"
                                                        {{$shirt_size->id == $student->shirt_size ? "SELECTED" : ""}}
                                                    >{{$shirt_size->abbr}}</option>
                                            @endforeach  
                                        </select>
                                    </div>
                                </div><!-- form-row -->
                            </div><!-- form-group -->
                            
                            <!-- SUBMIT --> 
                             <div class="form-group">
                                <div class="form-row">
                                    <div class="col">
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                            
                        </fieldset>
                    </div>
                </form>
                
            </div>
            <div class="col-12" id="parent">Parent Profile</div>
            <div class="col-12" id="school">School</div>
            <div class="col-12" id="history">History</div>
        </div><!-- row --> 
    </div><!-- container -->
@endsection
