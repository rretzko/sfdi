<div id="tdr_form">
    <- <a href="{{ route('registrant.profile.edit', ['eventversion' => $eventversion->id]) }}"
          class="" >Back to Registration Profile
    </a>
    @if(isset($registrant))
        <form class="" method="post" action="{{route('eapplication.update', ['registrant' => $registrant])}}">
    @else <!-- used for demo purposes only -->
        <form class="" method="post" action="{{route('eapplication.show', ['student' => $student])}}">
    @endif
        @csrf

        @if(count($errors))
            <div class="form-group row ml-1 col-10 border border-danger pl-1 pr-1 text-danger">
                Errors have been found and are highlighted in red.
            </div>
        @endif

        <div class="card m-t-40 mb-2">
            <div class="card-body">
                <h4 class="mt-0 header-title">eApplication</h4>

                <!-- EMAIL ADDRESS -->
                <div class="form-group row">
                    <div class="col-11 ml-2 d-flex row">
                        <div class="col-11 ml-2 d-flex row">
                            <label class="col-3 text-right">Email</label>
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
                        <div class="col-11 ml-2 d-flex row">
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
                        <div class="col-11 ml-2 d-flex row">
                            <label class="col-3 text-right">School</label>
                            <div class="col-9"><strong>
                                {{ $student->schools()->first()->name }}
                            </strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TEACHER -->
                <div class="form-group row">
                    <div class="col-11 ml-2 d-flex row">
                        <div class="col-11 ml-2 d-flex row">
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
                        <div class="col-11 ml-2 d-flex row">
                            <label class="col-3 text-right">Voice Part</label>
                            <div class="col-9 text-danger"><strong>
                                {{ $registrant->auditiondetail->auditionVoicingDescrString }}
                            </strong>
                            </div>
                        </div>
                    </div>
                </div>

                <style>.error_text{color: red; font-weight: bold;}</style>
                <div class="form-group row">
                    <div class="col-11 ml-2 d-flex row">
                        <div class="col-11 ml-2 d-flex row">
                            <h6>Eligibility Requirements</h6>
                            <label class="col-12">
                                Please read through the {{ $eventversion->name }} Eligibility Requirements by <a href="https://www.allshorechorusnj.com/copy-of-eligibility-requirements" target="_NEW">clicking here</a>!
                            </label>
                            <div class="col-12">
                                <input type="checkbox" name="eligibility" id="eligibility" value="1"
                                       @if(old('eligibility') && (old('eligibility') == 1)) CHECKED @endif >
                                <label>I have read them.</label>
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
                                Please read through the {{ $eventversion->name }} Student Rules and Regulations by <a href="https://www.allshorechorusnj.com/copy-of-eligibility-requirements" target="_NEW">clicking here</a>!
                            </label>
                            <div class="col-12">
                                <input type="checkbox" name="rulesandregs" id="rulesandregs" value="1"
                                       @if(old('rulesandregs') && (old('rulesandregs') == 1)) CHECKED @endif >
                                <label>I have read them carefully.</label>
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
                                I understand that my photograph may be taken during rehearsal or performance, and possibly posted on the {{ $eventversion->name }} social media account.
                            </label>
                            <div class="col-12">
                                <input type="checkbox" name="imageuse" id="imageuse" value="1"
                                       @if(old('imageuse') && (old('imageuse') == 1)) CHECKED @endif >
                                <label>I have read them carefully.</label>
                                @error('imageuse')
                                    <div class="error_text">Please confirm that you understand that your photograph may be taken during rehearsal or performance, and possibly posted on the {{ $eventversion->name }} social media account.</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-11 ml-2 d-flex row">
                        <div class="col-11 ml-2 d-flex row">
                            <h6>Absences</h6>
                            <label class="col-12">
                                <p>While reading these documents, I took note of the fact that all members are allowed two absences. If a student is absent a 3rd time, they are automatically dismissed from the chorus.</p>
                                <p><i>There is one exception. If a student in 12th grade can provide documentation of a music college audition, a 3rd absence will be allowed upon review of the {{ $eventversion->name }} committee.</i></p>
                            </label>
                            <div class="col-12">
                                <input type="checkbox" name="absences" id="absences" value="1"
                                       @if(old('absences') && (old('absences') == 1)) CHECKED @endif >
                                <label>I understand and agree.</label>
                                @error('absences')
                                    <div class="error_text">Please confirm that you understand the absence rules.</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-11 ml-2 d-flex row">
                        <div class="col-11 ml-2 d-flex row">
                            <h6>Lates</h6>
                            <label class="col-12">
                                <p>I took note of the fact that any 3 "lates" to a rehearsal will count as one absence. </p>
                                <p><i>And yes, one minute late is considered late.</i></p>
                            </label>
                            <div class="col-12">
                                <input type="checkbox" name="lates" id="lates" value="1"
                                       @if(old('lates') && (old('lates') == 1)) CHECKED @endif >
                                <label>I understand and agree.</label>
                                @error('lates')
                                    <div class="error_text">Please confirm that you understand the lateness rules.</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-11 ml-2 d-flex row">
                        <div class="col-11 ml-2 d-flex row">
                            <h6>Dress Rehearsal</h6>
                            <label class="col-12">
                                <p>I am aware that attendance at the Friday Dress Rehearsal is mandatory. No exceptions. If I miss the dress rehearsal, I will be automatically dismissed from the chorus.</p>
                            </label>
                            <div class="col-12">
                                <input type="checkbox" name="dressrehearsal" id="dressrehearsal" value="1"
                                       @if(old('dressrehearsal') && (old('dressrehearsal') == 1)) CHECKED @endif >
                                <label>I understand and agree.</label>
                                @error('dressrehearsal')
                                    <div class="error_text">Please confirm that you understand that the Friday Dress Rehearsal is mandatory.</div>
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
                                <input type="text" name="signaturestudent" id="signaturestudent" value="{{ old('signaturestudent', '') }}">
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
                                <input type="text" name="signatureparent" id="signatureparent" value="{{ old('signatureparent', '') }}">
                                @error('signatureparent')
                                    <div class="error_text">A parent/guardian signature is required for this application to be accepted.</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
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

                <div><a href="{{ route('pdf.eapplication', ['registrant' => $registrant]) }}" class="text-danger">Print eApplication</a></div>

            </div><!-- card-body -->
        </div>
        </form>

</div><!-- tdr_form -->
