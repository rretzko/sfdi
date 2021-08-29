@extends('layouts.main')
@extends('headers.headerSite')
@extends('navs.navSubMain')

@section('content')
    <div class="container text-white bg-secondary">
        <div class="row">

            <div class="col-12" id="school">School
            <form class="bg-white text-dark school_add" method="post" action="{{action('School_AddController@store')}}" >
                    @csrf
                    @method('PUT')

                    <div class="container">
                        <fieldset class="form-group">
                            <legend>Add School</legend>

                            <div class="form-row">
                                <!-- School -->
                                <div class="col-12 ">
                                    <div class="form-group">
                                        <label class="form-control-label" for="id">
                                            School</label>
                                            <select class="form-control col-12 school_id focus"
                                                   id="id" name="id"
                                                   placeholder="" >
                                                <option value='-1'>Select</option>
                                                @foreach($schools AS $school)
                                                    <option value='{{$school->id}}'>
                                                        {{$school->nameCityState}}
                                                    </option>
                                                @endforeach
                                            </select>
                                    </div><!-- form-group -->
                                </div>

                            </div><!-- form-row -->

                            <div class="form-row">
                                <!-- Teachers -->
                                <div class="col-12 ">
                                    <div class="form-group">
                                        <label class="form-control-label" for="user_id">
                                            Teachers</label>
                                        <div class="custom-control custom-checkbox"></div>
                                        @if($errors->has('teachers'))
                                            <p class="help text-danger">{{$errors->first('teachers')}}</p>
                                        @endif
                                            <!--form-control col-12 checkboxes d-none
                                            <select class="form-control col-12"
                                                   id="user_id" name="user_id"
                                                   placeholder="" >
                                                <option value='-1'>SELECT</option>
                                                @foreach($teachers AS $teacher)
                                                    <option value="{{$teacher->user_id}}">{{$teacher->fullNameAlpha}}</option>
                                                //@endforeach
                                            </select>-->
                                    </div><!-- form-group -->
                                </div>

                            </div><!-- form-row -->

                            <!-- SUBMIT -->
                             <div class="form-group">
                                <div class="form-row">
                                    <div class="col">
                                        <button class="btn btn-primary" type="submit">Add</button>
                                    </div>
                                </div>
                            </div>

                        </fieldset>
                    </div><!-- container -->
                </form>

            </div><!-- class id=school -->
        </div><!-- row -->
    </div><!-- container -->
@endsection
