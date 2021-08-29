<div class="card">
                
    <div class="card-header" role="tab" id="credentialsheading">
        <h3>
            <a data-toggle="collapse" data-parent="testaccordion" 
               href="#credentials" aria-expanded="true" 
               aria-controls="credentials">Credentials</a>
        </h3>
    </div><!-- card-header -->

    <div id="credentials" class="collapse {{$nav_links['credentials']}}" role="tabpanel"
         aria-labelledby="credentialsheading">
        <div class="card-block">

            <form class="bg-white text-dark" method="post" action="credentials/{{$user->id}}">
                @csrf
                @method('PATCH')
                
                <!--<input type="hidden" name="userid" id="userid" value="{{$user->id}}" >-->
                
                <div class="container">
                    <fieldset class="form-group">

                        <div class="form-row"> 
                            
                            <!-- USER NAME -->
                            <div class="form-group col-12">
                                <label class="form-control-label">User-Name: {{$user->name}}</label>
                            </div>
                            
                            <!-- CURRENT PASSWORD --> 
                            <div class="col-12"> 
                                <div class="form-group d-flex flex-column">
                                    <label class="form-control-label" for="password">
                                        Current Password</label>
                                    <input class="form-control col-12 col-sm-4" type="password" 
                                           id="current_password" name="current_password" 
                                           placeholder="" 
                                           value="" >
                                    @if($errors->has('current_password'))
                                        <p class="help text-danger">{{$errors->first('current_password')}}</p>
                                    @endif 
                                </div><!-- form-group -->
                            </div>

                            <!-- NEW PASSWORD --> 
                            <div class="col-12"> 
                                <div class="form-group d-flex flex-column">
                                    <label class="form-control-label" for="password">
                                        Change Password<br />
                                    <input class="form-control col-12 col-sm-4" type="password" 
                                           id="password" name="password" 
                                           placeholder="" 
                                           value="" >
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
                                    </label>
                                </div><!-- form-group -->
                            </div>
                            
                            <!-- CONFIRM PASSWORD --> 
                            <div class="col-12"> 
                                <div class="form-group">
                                    <label class="form-control-label" for="password_confirmation">
                                        Confirm Password</label>
                                    <input class="form-control col-12 col-sm-4" type="password" 
                                           id="password_confirmation" name="password_confirmation" 
                                           placeholder="" 
                                           value="">
                                    @if($errors->has('password_confirmation'))
                                        <p class="help text-danger">{{$errors->first('password_confirmation')}}</p>
                                    @endif 
                                </div><!-- form-group -->
                            </div>

                            

                        <!-- SUBMIT --> 
                         <div class="form-group d-flex flex-column col-12">
                            <div class="form-row">
                                <div class="col">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </div>
                            @if(session()->has('message-credentials'))
                                <p class="help text-success">{{session()->get('message-credentials')}}</p>
                            @else
                                <p class="help invisible">placeholder</p>
                            @endif
                        </div>

                    </fieldset>
                </div>
            </form>

        </div>

    </div>

</div><!-- card --> 
            

