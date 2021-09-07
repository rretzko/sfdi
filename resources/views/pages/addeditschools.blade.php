@extends('layouts.page')

@section('title')
Add School
@endsection

@section('content')
<div class="row">
    <div class="col-12">

        @if(config('app.url') === 'http://localhost')
            <form class="school_add m-t-40" method="post" action="{{route('storeSchool')}}">
        @else
            <form class="school_add m-t-40" method="post" action="https://studentfolder.info/school/store">
        @endif
                @csrf
            <div class="card">
                <div class="card-body">

                    <h4 class="mt-0 header-title">Add School</h4>
                    <p class="text-muted m-b-30 font-14">You can add your school using the below form:</p>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="id">School Name</label>
                        <div class="col-sm-10">

                            <select class="form-control col-12 school_id "
                                   id="id" name="id"
                                   placeholder=""
                                   style="width: 100%;">
                                <option value='-1'>Enter School Name for search</option>
                                @foreach($schools AS $school)

                                    <option value="{{$school->id}}"
                                        @if($school->id == old('id'))
                                            SELECTED
                                        @endif
                                    >
                                        {{$school->nameCityState}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Teachers</label>
                        <div class="col-sm-10">
                            <div id="teachers">
                                <div class="instruction m-b-10">Please select your School first!</div>
                                <div class="teacherlist" style="display: none;">
                                    <div id="openInstructionTeacher" class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="customCheck7" data-parsley-multiple="groups" data-parsley-mincheck="2"> <label class="custom-control-label" for="customCheck7">My Teacher is not listed here</label></div>
                                </div>
                                <div class="instructionTeacher" style="display: none;">If not listed above, please ask your teacher to sign up at <a target="_blank" href="https://thedirectorsroom.com/" tabindex="-1">TheDirectorsRoom.com</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div>
                            <!-- ADD/UPDATE -->
                            <button class="card-link btn btn-primary waves-effect waves-light" type="submit">
                                Add School
                            </button>
                            <a href="{{route('school')}}"
                               title="Go Back" class="card-link">
                                Go Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection


@section('pagescripts')
<link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('/plugins/select2/select2.min.js') }}"></script>
<!-- <script src="{{asset('/js/teachersFromSchool.js')}}"></script> -->
<script src="https://studentfolder.info/assets/js/teachersFromSchool.js" ></script>
<!-- <script src="http://localhost/dev/sfdi/public/assets/js/teachersFromSchool.js"></script> -->
<script type="text/javascript">

    $(document).ready(function() {

        /*$('#id').select2();*/
        $('#id').focus();
        $('#id').on('change', function() {
            $('.instruction').slideUp();
            teachersFromSchool();
        })

        $('#openInstructionTeacher input').on('change', function() {
            if ($(this).is(':checked')) {
                $('.instructionTeacher').slideDown()
            }
            else {
                $('.instructionTeacher').slideUp()
            }

        })
    })

    function teachersFromSchool()
    {console.log('@ teachersFromSchool');
        //advisories
        var advisory = 'If not listed above, please ask your teacher to sign up at <a href="https:\\TheDirectorsRoom.com" title="Sign up at TheDirectorsRoom.com" target="_blank" tabindex="-1">TheDirectorsRoom.com</a>.';
        var advisory_none = 'Please ask your teacher to sign up at <a href="https:\\TheDirectorsRoom.com" title="Sign up at TheDirectorsRoom.com" target="_blank" tabindex="-1">TheDirectorsRoom.com</a>.';

        //path
        if(location.hostname === 'localhost') {
            var $path = PATH+'TeachersFromSchool';
        }else{
            var $path = 'https://studentfolder.info/TeachersFromSchool';
        }

        console.log('path: '+$path);
        //clear any existing messages
        $('.instructionTeacher').css('display', 'none');
//alert($path);
        $.ajax({
            method: 'POST',
            url: $path,
            data: {
                'school_id' : $('#id').val(),
                '_token' : $("input[name='_token']").val()
            },

            success: function(response){
                console.log('35 success. ');
                var obj = JSON.parse(response); //create json object

                $('.teacherlist').html(obj);

                if(obj.length === 1){$('#customCheck0').attr('checked', true);}

                $('.instructionTeacher').html(obj.length ? advisory : advisory_none);

                $('.teacherlist').slideDown();

                $('.instructionTeacher').css('display', 'block');

            },
            error: function(jqXHR, textStatus, errorThrown){
//console.log('41. '+PATH+'TeachersFromSchool');
                console.log(JSON.stringify(jqXHR));
                console.log("AJAX error: "+textStatus+' : '+errorThrown);
            }
        });

    }


</script>

@endsection
