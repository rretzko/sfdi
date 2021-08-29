<style>
    #tdr_form{background-color:white; padding:1rem; color: black; font-weight: 400; }
</style>

<div id="tdr_form">
    <a href="{{ route('registrant.profile.edit', ['eventversion' => $eventversion]) }}"
       class="" >Back to Registration Profile
    </a>
    @if(isset($registrant))
        <form class="" method="post" action="{{route('eapplication.update', ['registrant' => $registrant])}}">
        @else <!-- used for demo purposes only -->
            <form class="" method="post" action="{{route('eapplication.show', ['student' => $student])}}">
            @endif

            @csrf

            <!-- UNUSED/HIDDEN VALUES -->
                <input type="hidden" name="lates" value="-1" />
                <input type="hidden" name="dressrehearsal" value="-1" />

                @if(count($errors) || $errors->any())
                    <div class="form-group row ml-1 col-10 border border-danger pl-1 pr-1 text-danger"
                         style="background-color: rgba(255,0,0,.1); color: darkred; padding: 3px; border: 1px solid darkred; margin-top: .5rem;">
                        Errors have been found and are highlighted in red.
                    </div>
                @endif

                <div class="card m-t-40 mb-2">
                    <div class="card-body" style="border: 1px solid black;margin: 1rem; padding:0 .5rem;padding-bottom: 1rem;">
                        <h4 class="mt-0 header-title">eApplication</h4>

                        <style>
                            label{margin-right: .5rem; min-width: 6rem;}
                            .flex_row{display: flex;}
                        </style>
                        <!-- EMAIL ADDRESS -->
                        <div class="form-group row">
                            <div class="col-11 ml-2 d-flex row">
                                <div class="col-11 ml-2 d-flex row flex_row" >
                                    <label class="col-3 text-right" >Email</label>
                                    <div class="col-9"><strong>
                                            {{ $student->person->emailPrimary }}
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- NAME -->
                        <div class="form-group row">
                            <div class="col-11 ml-2 d-flex row">
                                <div class="col-11 ml-2 d-flex row flex_row">
                                    <label class="col-3 text-right">Name</label>
                                    <div class="col-9"><strong>
                                            {{ $student->person->fullName }}
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SCHOOL -->
                        <div class="form-group row">
                            <div class="col-11 ml-2 d-flex row">
                                <div class="col-11 ml-2 d-flex row flex_row">
                                    <label class="col-3 text-right">School</label>
                                    <div class="col-9"><strong>
                                            {{ $student->activeSchool->name }}
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TEACHER -->
                        <div class="form-group row">
                            <div class="col-11 ml-2 d-flex row">
                                <div class="col-11 ml-2 d-flex row flex_row">
                                    <label class="col-3 text-right">Teacher</label>
                                    <div class="col-9"><strong>
                                            {{ $student->teachers()->first()->person->fullName }}
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- AUDITIONING VOICE PART -->
                        <div class="form-group row">
                            <div class="col-11 ml-2 d-flex row">
                                <div class="col-11 ml-2 d-flex row flex_row">
                                    <label class="col-3 text-right">Voice Part</label>
                                    <div class="col-9 text-danger" style="color: red;"><strong>
                                            {{ $registrant->auditiondetail->auditionVoicingDescrString }}
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <style>
                            h6{font-size: 1rem; font-weight: bold; margin-bottom: 0;}
                            .error_text{color: red; font-weight: bold;}
                            .input_signature{font-family: "Brush Script MT", "Brush Script Std", cursive; font-size: larger;}
                            label{color: black;}
                            label ul li{color: black;}
                        </style>
                        <div class="form-group row">
                            <div class="col-11 ml-2 d-flex row">
                                <div class="col-11 ml-2 d-flex row">
                                    <h6>Eligibility Requirements</h6>
                                    <label class="col-12">
                                        <ul>
                                            <li>I was a member in good standing at the completion of the festival season last year OR I  have been recommended by my current choir director this year.</li>
                                            <li>I am currently enrolled in Grade <b>{{ $registrant->student->gradeClassOf }}</b> at <b>{{ $registrant->student->activeSchool->name }}</b>.</li>
                                        </ul>
                                    </label>
                                    <div class="col-12">
                                        <input type="checkbox" name="eligibility" id="eligibility" value="1"
                                               @if(old('eligibility') && (old('eligibility') == 1)) CHECKED @endif >
                                        <label>I meet all the requirements listed above.</label>
                                        @error('eligibility')
                                        <div class="error_text">Please confirm that you have read through the {{ $eventversion->name }} Eligibility Requirements.</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-11 ml-2 d-flex row">
                                <div class="col-11 ml-2 d-flex row">
                                    <h6>Student Rules and Regulations</h6>
                                    <label class="col-12">
                                        <ul>
                                            <li>I will participate in all Zoom rehearsals with professionalism and courtesy to all teachers, students, and SJCDA Staff.</li>
                                            <li>I will not participate in another activity, game, or social media while in rehearsal.</li>
                                            <li>I will use school appropriate backgrounds if necessary to use one at all.</li>
                                            <li>I will not make inappropriate comments, participate in distracting behaviors, or send private messages to other students while in rehearsal.</li>
                                            <li>I will remain muted unless asked for questions or called upon.</li>
                                            <li>Non-choir members are not allowed to attend rehearsal with you.  You should be in a room by yourself in order to rehearse effectively.</li>
                                        </ul>
                                    </label>
                                    <div class="col-12">
                                        <input type="checkbox" name="rulesandregs" id="rulesandregs" value="1"
                                               @if(old('rulesandregs') && (old('rulesandregs') == 1)) CHECKED @endif >
                                        <label>I meet all of the requirements listed above.</label>
                                        @error('rulesandregs')
                                        <div class="error_text">Please confirm that you have read through the {{ $eventversion->name }} Rules and Regulations.</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-11 ml-2 d-flex row">
                                <div class="col-11 ml-2 d-flex row">
                                    <h6>Use of your image</h6>
                                    <label class="col-12">
                                        My image from any rehearsal may be used in the livestream concert as part of a montage.
                                    </label>
                                    <div class="col-12">
                                        <div>
                                            <input type="radio" name="imageuse" id="imageuse" value="1"
                                                   @if(old('imageuse') && (old('imageuse') == 1)) CHECKED @endif >
                                            <label>I DO allow my image to be used.</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="imageuse" id="imageuse" value="-1"
                                                   @if(old('imageuse') && (old('imageuse') == -1)) CHECKED @endif >
                                            <label>I DO NOT allow my image to be used.</label>
                                        </div>
                                        @error('imageuse')
                                        <div class="error_text">Please confirm your choice of image use.</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-11 ml-2 d-flex row">
                                <div class="col-11 ml-2 d-flex row">
                                    <h6>Use of your video</h6>
                                    <label class="col-12">
                                        I understand that my video of my singing will be used in the SJCDA Virtual Choir 2021 in final production.
                                    </label>
                                    <div class="col-12">
                                        <div>
                                            <input type="radio" name="videouse" id="videouse" value="1"
                                                   @if(old('videouse') && (old('videouse') == 1)) CHECKED @endif >
                                            <label>I DO allow my video to be used in final production.</label>
                                        </div>
                                        <div class="d-flex" style="display: flex; ">
                                            <div>
                                                <input type="radio" class="mr-1"  name="videouse" id="videouse" value="-1"
                                                       @if(old('videouse') && (old('videouse') !== 1)) CHECKED @endif >
                                            </div>
                                            <label style="margin-left: 3px;">I DO NOT allow my video to be used in production. Please ONLY use the audio portion of my submission.</label>
                                        </div>
                                        @error('videouse')
                                        <div class="error_text">Please confirm that your choice of video use.</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-11 ml-2 d-flex row">
                                <div class="col-11 ml-2 d-flex row">
                                    <h6>Rehearsal Attendance</h6>
                                    <label class="col-12">
                                        <h4>Rehearsals: February 13th, 20th, 27th, 10-11am</h4>
                                        <ul>
                                            <li>Rehearsals are mandatory.  If I have a conflict with EITHER February 13th or the 20th, I MUST notify my teacher prior to submitting this application.</li>
                                            <li>If I cannot attend the February 27th rehearsal IN FULL, my video submission will not be accepted.</li>
                                            <li>Attendance will be taken at all rehearsals.   If you are not present for the entire rehearsal, that will be considered an absence that will count against you.</li>
                                            <li>More than one absence will result in dismissal from the choir and you will not be allowed to audition next year.</li>
                                        </ul>
                                    </label>
                                    <div class="col-12">
                                        <input type="checkbox" name="absences" id="absences" value="1"
                                               @if(old('absences') && (old('absences') == 1)) CHECKED @endif >
                                        <label>I understand and agree.</label>
                                        @error('absences')
                                        <div class="error_text">Please confirm that you understand the Rehearsal Attendance rules.</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-11 ml-2 d-flex row">
                                <div class="col-11 ml-2 d-flex row">
                                    <h6>Student Signature</h6>
                                    <label class="col-12">
                                        <p>STUDENT: By typing my name below, I understand and agree that this form of electronic signature has the same legal force and affect as a manual signature.</p>
                                    </label>
                                    <div class="col-12">
                                        <input type="text" class="input_signature" name="signaturestudent" id="signaturestudent" value="{{ old('signaturestudent', '') }}">
                                        @error('signaturestudent')
                                        <div class="error_text">Your signature is required for this application to be accepted.</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-11 ml-2 d-flex row">
                                <div class="col-11 ml-2 d-flex row">
                                    <h6>Parent Agreement</h6>
                                    <label class="col-12">
                                        <p>Please go find your parent/guardian, and have them read through this form. Then, continue. </p>
                                    </label>
                                    <div class="col-12">
                                        <input type="checkbox" name="parentread" id="parentread" value="1"
                                               @if(old('parentread') && (old('parentread') == 1)) CHECKED @endif >
                                        <label>My parents have read this form.</label>
                                        @error('parentread')
                                        <div class="error_text">Please confirm that your parent/guardian has read through this form.</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-11 ml-2 d-flex row">
                                <div class="col-11 ml-2 d-flex row">
                                    <h6>Parent Signature</h6>
                                    <label class="col-12">
                                        <p>PARENT/GUARDIAN: By typing my name below, I understand and agree that this form of electronic signature has the same legal force and affect as a manual signature.</p>
                                    </label>
                                    <div class="col-12">
                                        <input type="text" class="input_signature" name="signatureparent" id="signatureparent" value="{{ old('signatureparent', '') }}">
                                        @error('signatureparent')
                                        <div class="error_text">A parent/guardian signature is required for this application to be accepted.</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row " style="margin-bottom: 1rem;">
                            <div class="col-11 ml-2 d-flex row">
                                <div class="col-11 ml-2 d-flex row">
                                    <h6>Courtesy and Respect</h6>
                                    <label class="col-12">
                                        <p>Finally, I understand that all teachers involved are volunteers, dedicating their time and effort to provide you with this musical experience. I, and my family, will communicate in a courteous and respectful manner at all times. </p>
                                    </label>
                                    <div class="col-12">
                                        <input type="checkbox" name="courtesy" id="courtesy" value="1"
                                               @if(old('courtesy') && (old('courtesy') == 1)) CHECKED @endif >
                                        <label>I understand and agree to this and everything above.</label>
                                        @error('courtesy')
                                        <div class="error_text">Please confirm that you understand and agree to everything above.</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <x-buttonSaveCancelChangesComponent />

                    </div><!-- card-body -->
                </div>


</div><!-- tdr_form -->
