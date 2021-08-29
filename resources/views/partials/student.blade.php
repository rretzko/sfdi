<div class="card">
                
    <div class="card-header" role="tab" id="studentheading">
        <h3>
            <a data-toggle="collapse" data-parent="testaccordion" 
               href="#student" aria-expanded="true" 
               aria-controls="tstudent">Student</a>
        </h3>
    </div><!-- card-header -->

    <div id="student" class="collapse {{$nav_links['student']}}" role="tabpanel"
         aria-labelledby="studentheading">
        <div class="card-block">

            <form class="bg-white text-dark" method="post" 
                  action="students/{{$user->id}}">
                @csrf
                @method('PATCH')    

                <div class="container">
                    <fieldset class="form-group">

                        <div class="form-row"> 
                            
                            <!-- CLASS --> 
                            <div class="col-6 col-md-4 col-xl-3"> 
                                <div class="form-group d-flex flex-column">
                                    <label class="form-control-label" for="class_of">
                                        Grade/Class
                                    </label>
                                    <select name="class_of" id="class_of" 
                                            class="col-6  col-lg-5">
                                        @foreach($grades_class_ofs AS $class_of => $value)                                              
                                            <option value="{{$class_of}}"
                                                    {{$class_of == $student->class_of ? "SELECTED" : ""}}
                                                >{{$value}}</option>
                                        @endforeach  
                                    </select>
                                    @if($errors->has('class_of'))
                                        <p class="help text-danger">{{$errors->first('class_of')}}</p>
                                    @endif 
                                </div><!-- form-group -->
                            </div>

                             <!-- HEIGHT -->
                            <div class="col-6 col-md-3 col-xl-2">
                                <div class="form-group">
                                    <label class="form-control-label" for="height">
                                        Height in inches</label>
                                    <!-- keep input+hint together --> 
                                    <div class="form-row"> 
                                        <div class="col-6 " >
                                            <input class="form-control " type="number" 
                                                   id="height" name="height" 
                                                   placeholder="Height in inches" 
                                                   value="{{$student->height}}">
                                        </div >
                                        <div class="col-6  hint pt-1 " id="ft_in">
                                            {{$student->height_Foot_Inches}}
                                        </div>
                                        @if($errors->has('height'))
                                        <p class="help text-danger">{{$errors->first('height')}}</p>
                                    @endif
                                    </div><!-- form-row -->
                                </div><!-- form-group -->
                            </div>

                            <!-- BIRTHDAY -->
                            <div class="col-6 col-md-4 col-lg-3 col-xl-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="birthday">
                                        Birthday</label>
                                    <input class="form-control col-10 col-sm-12 col-md-10" type="date" 
                                           id="birthday" name="birthday" 
                                           placeholder="Birthday" 
                                           value="{{$student->birthday}}">
                                    @if($errors->has('birthday'))
                                        <p class="help text-danger">{{$errors->first('birthday')}}</p>
                                    @endif
                                </div><!-- form-group -->
                            </div>

                            <!-- SHIRT SIZE -->                           
                            <div class="col-6 col-lg-3 ">
                                <div class="form-group d-flex flex-column">
                                    <label class="form-control-label" for="shirt_size">Shirt Size</label>
                                    <select name="shirt_size" id="shirt_size" 
                                            class="col-6 col-sm-4 col-lg-5">
                                        @foreach($shirt_sizes AS $shirt_size)                                              
                                            <option value="{{$shirt_size->id}}"
                                                    {{$shirt_size->id == $student->shirt_size ? "SELECTED" : ""}}
                                                >{{$shirt_size->abbr}}</option>
                                        @endforeach  
                                    </select>
                                    @if($errors->has('shirt_size'))
                                        <p class="help text-danger">{{$errors->first('shirt_size')}}</p>
                                    @endif
                                </div><!-- form-group -->
                            </div>    
                        </div><!-- form-row -->
                        
                        <!-- VOICING AND INSTRUMENTS -->
                        <section class="col-12" id="voicings-And-Instruments">
                            <h5>Voicings and Instruments (I sing and/or play...)</h5> 
                            <div class="col-12 col-12 voicings-and-instruments">
                                <div class="col-4">
                                    <h5>Voice Parts</h5>
                                    <div class="instrumentations">
                                        <label class="form-control-label col-5" for="choral">Primary</label>
                                        <select name="chorals[]" id="chorals_0" 
                                                class="col-6 col-sm-4 col-lg-5">
                                            <option value="0">Select</option>
                                            @foreach($choral AS $part)                                              
                                                <option value="{{$part->id}}"
                                                {{$student->is_Instrumentation($part->id, 0) ? 'SELECTED' : ''}}
                                                    >{{$part->ucwordsDescription}}</option>
                                            @endforeach  
                                        </select>
                                    </div>
                                    <div class="instrumentations">
                                        <label class="form-control-label col-5" for="choral">Secondary</label>
                                        <select name="chorals[]" id="chorals_1" 
                                                class="col-6 col-sm-4 col-lg-5">
                                            <option value="0">Select</option>
                                            @foreach($choral AS $part)                                              
                                                <option value="{{$part->id}}"
                                                {{$student->is_Instrumentation($part->id, 1) ? 'SELECTED' : ''}}
                                                    >{{$part->ucwordsDescription}}</option>
                                            @endforeach  
                                        </select>
                                    </div>
                                    <div class="instrumentations">
                                        <label class="form-control-label col-5" for="chorals">Alternate</label>
                                        <select name="chorals[]" id="chorals_2" 
                                                class="col-6 col-sm-4 col-lg-5">
                                            <option value="0">Select</option>
                                            @foreach($choral AS $part)                                              
                                                <option value="{{$part->id}}"
                                                {{$student->is_Instrumentation($part->id, 2) ? 'SELECTED' : ''}}
                                                    >{{$part->ucwordsDescription}}</option>
                                            @endforeach  
                                        </select>
                                        @if($errors->has('chorals'))
                                            <p class="help text-danger">{{$errors->first('chorals')}}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-8">
                                    <h5>Instruments</h5>
                                    <div class="instrumentations">
                                        <label class="form-control-label col-2" for="instrumental">Primary</label>
                                        <select name="instrumentals[]" id="instrumentals_0" 
                                                class="col-6 col-sm-4 col-lg-5">
                                            <option value="0">Select</option>
                                            @foreach($instrumental AS $part)                                              
                                                <option value="{{$part->id}}"
                                                {{$student->is_Instrumentation($part->id, 0) ? 'SELECTED' : ''}}
                                                    >{{$part->ucwordsDescription}}</option>
                                            @endforeach  
                                        </select>
                                        @if($errors->has('instrumentals'))
                                            <p class="help text-danger">{{$errors->first('instrumentals')}}</p>
                                        @endif
                                    </div>
                                    <div class="instrumentations">
                                        <label class="form-control-label col-2" for="instrumentals">Secondary</label>
                                        <select name="instrumentals[]" id="instrumentals_1" 
                                                class="col-6 col-sm-4 col-lg-5">
                                            <option value="0">Select</option>
                                            @foreach($instrumental AS $part)                                              
                                                <option value="{{$part->id}}"
                                                {{$student->is_Instrumentation($part->id, 1) ? 'SELECTED' : ''}}
                                                    >{{$part->ucwordsDescription}}</option>
                                            @endforeach  
                                        </select>
                                        @if($errors->has('instrumentals'))
                                            <p class="help text-danger">{{$errors->first('instrumentals')}}</p>
                                        @endif
                                    </div>
                                    <div class="instrumentations">
                                        <label class="form-control-label col-2" for="instrumentals">Alternate</label>
                                        <select name="instrumentals[]" id="instrumentals_2" 
                                                class="col-6 col-sm-4 col-lg-5">
                                            <option value="0">Select</option>
                                            @foreach($instrumental AS $part)                                              
                                                <option value="{{$part->id}}"
                                                {{$student->is_Instrumentation($part->id, 2) ? 'SELECTED' : ''}}
                                                    >{{$part->ucwordsDescription}}</option>
                                            @endforeach  
                                        </select>
                                        @if($errors->has('instrumentals'))
                                            <p class="help text-danger">{{$errors->first('instrumentals')}}</p>
                                        @endif
                                    </div> 
                                </div>
                            </div>
                        </section>
                        
                        <!-- SUBMIT --> 
                         <div class="form-group d-flex flex-column">
                            <div class="form-row">
                                <div class="col">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </div>
                            @if(session()->has('message'))
                                <p class="help text-success">{{session()->get('message')}}</p>
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
            

