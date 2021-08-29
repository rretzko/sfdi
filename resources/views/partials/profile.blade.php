<div class="card">
                
    <div class="card-header" role="tab" id="profileheading">
        <h3>
            <a data-toggle="collapse" data-parent="accordion" 
               href="#profile" aria-expanded="true" 
               aria-controls="profile">My Profile</a>
        </h3>
    </div><!-- card-header -->

    <div id="profile" class="collapse {{$nav_links['profile']}}" role="tabpanel"
         aria-labelledby="profileheading">
        
        <div class="card-block">

            <form class="bg-white text-dark" method="post" 
                  action="{{route('profile', ['id' => $user->id])}}">
                @csrf
                

                <div class="container">

                    <fieldset class="form-group">

                        <!-- SYS.ID -->
                        <div class="form-group">
                            <label class="form-control-label">System Id: {{$user->id}}</label>
                        </div>

                        <!-- NAME -->
                        <div class="form-group">
                            <label class="form-control-label sr-only" for="first_name">Name</label>
                            <div class="form-row"> 
                                <div class="col-sm-3 col-md-4"> 
                                    <input class="form-control" type="text" 
                                           id="first_name" name="first_name" 
                                           placeholder="First" 
                                           value="{{$student->person->first_name}}">
                                    @if($errors->has('first_name'))
                                        <p class="help text-danger">{{$errors->first('first_name')}}</p>
                                    @endif 
                                </div>
                                <div class="col-sm-3 col-md-4"> 
                                    <input class="form-control" type="text" 
                                           id="middle_name" name="middle_name" 
                                           placeholder="Middle" 
                                           value="{{$student->person->middle_name}}">
                                </div>
                                <div class="col-sm-3 col-md-4"> 
                                    <input class="form-control" type="text" 
                                           id="last_name" name="last_name" 
                                           placeholder="Last" 
                                           value="{{$student->person->last_name}}">
                                    @if($errors->has('last_name'))
                                        <p class="help text-danger">{{$errors->first('last_name')}}</p>
                                    @endif 
                                </div>
                            </div><!-- form-row --> 
                        </div><!-- form-group --> 
                         
                        <!-- PRONOUN --> 
                        <div class="form-group d-flex flex-column">
                            <label class="form-control-label" for="pronoun_id">Preferred Pronoun</label>
                            <select name="pronoun_id" id="pronoun_id" 
                                    class="col-6 col-sm-4 col-lg-3">
                                @foreach($pronouns AS $pronoun)                                              
                                    <option value="{{$pronoun->id}}"
                                            {{$pronoun->id == $person->pronoun_id ? "SELECTED" : ""}}
                                        >{{$pronoun->descr}}</option>
                                @endforeach  
                            </select>
                            @if($errors->has('pronoun_id'))
                                        <p class="help text-danger">{{$errors->first('pronoun_id')}}</p>
                            @endif 
                        </div><!-- form-group -->
                        
                        <!-- EMAILS -->
                        <div class="form-group d-flex flex-column">
                            <label class="form-control-label" for="email">Emails 
                                <span class="small">
                                    (Click the checkbox if your email is a 
                                    "family" email and is used by other 
                                    siblings.)
                                </span>
                            </label>
                            
                            <div class="form-row"> 
                                <!-- primary email -->
                                <div class="col-sm-3 col-md-4" > 
                                    <div style="display: flex; flex-direction: row">
                                        <input class="form-control col-11" 
                                               type="email" 
                                               id="primary" name="emails[]" 
                                               placeholder="required@email.com" 
                                               value="{{$student->person->emailPrimary}}">
                                        <input class="custom-control custom-checkbox col-1" 
                                               type="checkbox" 
                                               id="primary_Family" 
                                               name="primary_family" 
                                               {{$student->person->isEmailFamilyPrimary ? 'CHECKED' : ''}}/>
                                    </div>
                                    @if($errors->has('emails.0'))
                                        <p class="help text-danger">{{$errors->first('emails.0')}}</p>
                                    @endif
                                </div>
                                
                                <!-- alternate email -->
                                <div class="col-sm-3 col-md-4" > 
                                    <div style="display: flex; flex-direction: row;"> 
                                        <input class="form-control col-11" type="text" 
                                               id="alternate" name="emails[]" 
                                               placeholder="optional@email.com" 
                                               value="{{$student->person->emailAlternate}}">
                                        <input class="custom-control custom-checkbox col-1" type="checkbox" 
                                               id="alternate_Family" 
                                               name="alternate_family" 
                                               {{$student->person->isEmailFamilyAlternate ? 'CHECKED' : ''}}/>
                                        
                                    </div>
                                    @if($errors->has('emails.1'))
                                        <p class="help text-danger">{{$errors->first('emails.1')}}</p>
                                    @endif
                                    <!--@if($errors->has('emails.*'))
                                        <p class="help text-danger">{{$errors->first('emails.*')}}</p>
                                    @endif-->
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
                                               value="{{$student->person->phoneMobile}}">
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
                                               value="{{$student->person->phoneHome}}">
                                    </div>
                                    @if($errors->has('phones.1'))
                                        <p class="help text-danger">{{$errors->first('phones.1')}}</p>
                                    @endif
                                </div>
                                
                            </div>
                        </div><!-- form-group -->
                        
                        <!-- SUBMIT --> 
                        <div class="form-group d-flex flex-column">
                            <div class="form-row">
                                <div class="col">
                                   <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </div>
                            @if(session()->has('message-persons'))
                                <p class="help text-success">{{session()->get('message-persons')}}</p>
                            @else
                                <p class="help invisible">placeholder</p>
                            @endif
                       </div>

                    </fieldset>

                </div><!-- container --> 
            </form>

        </div>

    </div>

</div><!-- card -->


