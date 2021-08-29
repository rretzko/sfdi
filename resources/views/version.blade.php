@extends('layouts.main')
@extends('headers.headerSite')
@extends('navs.navSubMain')

@section('content')
    <div class="container text-white bg-secondary">
        <div class="row">
                         
            <div class="col-12" id="version">Version
            <form class="bg-white text-dark version" method="post" action="{{action('VersionController@store')}}">
                    @csrf
                    
                    <div class="container">
                        <fieldset class="form-group">
                           <legend>{{$version->version_name}} Registration </legend>
                            
                            <!-- AUDITION INSTRUMENTATION -->
                            <div class="form-group d-flex flex-column">
                                <label class="form-control-label" for="instrumentation_id">Auditioning For</label>
                                <select name="instrumentation_id" id="instrumentation_Id" 
                                        class="col-6 col-sm-4 col-lg-3">
                                    @foreach($instrumentations AS $instrumentation)                                              
                                        <option value="{{$instrumentation->id}}"
                                                 {{$instrumentation->id == $student->user_id ? "SELECTED" : "" }}
                                            >{{$instrumentation->descr}}</option>
                                    @endforeach  
                                </select>
                                @if($errors->has('instrumentation_id'))
                                            <p class="help text-danger">{{$errors->first('instrumentation_id')}}</p>
                                @endif 
                            </div><!-- form-group -->
                        
                            <!-- SUBMIT --> 
                            <div class="form-group">
                                <div class="form-row" >
                                    
                                    <!-- ADD/UPDATE -->
                                    <button class="btn btn-primary mr-1" type="submit">
                                        Update  
                                    </button>
                                    
                                </div>
                                
                            <!-- Advisory -->
                            <div class="advisory permanent text-info">
                                Your event application will be downloaded 
                                immediately after you click 'Update'.
                            </div>
                            
                        </fieldset>
                    </div><!-- container -->
                </form>
                
            </div><!-- class id=version -->
        </div><!-- row --> 
    </div><!-- container -->
@endsection
