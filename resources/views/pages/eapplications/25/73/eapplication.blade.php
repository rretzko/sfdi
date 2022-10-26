@extends('layouts.page')

@section('content')

    <div class="bg-white" style="padding: .5rem;">

        <h4>
            {{ __($eventversion->name.' Application for: '.$registrant->student->person->fullName) }}
        </h4>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

            <div>

                {{-- ACTION LINKS --}}
                <div class="flex justify-between">
                    {{-- BACK TO REGISTRANT PAGE --}}
                    <div class="flex text-red-700">

                        @if(config('app.url') === 'http://localhost')
                            <a href="{{ route('registrant.profile.edit', [$eventversion]) }}"
                               class="text-red-700 ml-2 pb-4">
                                Return to Profile
                            </a>
                        @else
                            <a href="https://studentfolder.info/registrant/profile/{{ $eventversion->id }}"
                               class="text-red-700 ml-2 pb-4">
                                Return to Profile
                            </a>
                        @endif
                    </div>

                </div>

                <style>
                    .sectionheader{background-color: lightgray; padding-left: .5rem; font-weight: bold;}
                </style>
                <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="flex text-xl my-4" >

                                        <div class="justify-self-center w-full">
                                            <div class="font-bold text-center" style="font-size: 1.5rem;">Morris Area Honor Choir - Middle and High School</div>
                                            <div class="text-center" style="font-size: 1rem;" >{{ $eventversion->name }}</div>

                                            <div class="text-center text-sm">
                                                eApplications are accepted through: <span color="red">Friday, Nov 04,2022 11:59:59 PM</span>
                                            </div>

                                            <div class="text-center text-sm">
                                                PLEASE NOTE: Morris Area Choral Directors Association reserved the right
                                                to require masks at any time, based on current health guidelines and
                                                host school requirements.
                                            </div>
                                        </div>

                                    </div>

                                    {{-- STUDENT DETAIL DECLARATION --}}
                                    <div class="mb-4">
                                        <style>
                                            .detail-row{display:flex; width: 90%;}
                                            .detail-row label{width: 25%;}
                                            .detail-row .data{font-weight: bold; margin-left: .5rem;}
                                        </style>
                                        <div class="detail-row">
                                            <label>Student Name:</label>
                                            <div class="data">{{ $registrant->student->person->fullName }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <label>Address:</label>
                                            <div class="data">{{ $registrant->student->person->user->address ? $registrant->student->person->user->address->addressCsv : '' }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <label>Height (in shoes):</label>
                                            <div class="data">{{ $registrant->student->heightFootInch }}</div>
                                        </div>

                                        <div class="detail-row mt-4">
                                            <label>Home Phone:</label>
                                            <div class="data">{{ strlen($registrant->student->phoneHome) ? $registrant->student->phonHome : '' }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <label>Cell Phone:</label>
                                            <div class="data">{{ strlen($registrant->student->phoneMobile) ? $registrant->student->phoneMobile : ''}}</div>
                                        </div>

                                        <div class="detail-row mt-4">
                                            <label>Email Personal:</label>
                                            <div class="data">{{ strlen($registrant->student->emailPersonal) ? $registrant->student->emailPersonal :  '' }}</div>
                                        </div>

                                        <div class="detail-row">
                                            <label>Email School:</label>
                                            <div class="data">{{ strlen($registrant->student->emailSchool)  ? $registrant->student->emailSchool : '' }}</div>
                                        </div>
                                    </div>

                                    {{-- EMERGENCY CONTACT INFORMATION --}}
                                    <div class="mb-4">
                                        <div class="sectionheader" >
                                            Emergency Contact Information
                                        </div>
                                        <div class="detail-row">
                                            <label>Parent Name:</label>
                                            <div class="data">{{ $registrant->student->guardians->count() ? $registrant->student->guardians->first()->person->fullName : '' }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <label>Parent Phone:</label>
                                            <div class="data">{{ $registrant->student->guardians->count() ? $registrant->student->guardians->first()->phoneCsv : '' }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <label>Parent Email:</label>
                                            <div class="data">{{ $registrant->student->guardians->count() ? $registrant->student->guardians->first()->emailCsv : '' }}</div>
                                        </div>
                                    </div>

                                    {{-- CHORAL DIRECTOR INFORMATION --}}
                                    <div class="mb-4">
                                        <div class="sectionheader" >
                                            Choral Director Information
                                        </div>
                                        <div class="detail-row">
                                            <label>School:</label>
                                            <div class="data">{{ $registrant->student->currentSchoolname }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <label>Choral Director:</label>
                                            <div class="data">{{ $registrant->student->currentTeachername }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <label>Phones:</label>
                                            <div class="data">_____________</div>
                                        </div>
                                    </div>

                                    {{-- AUDITION INFORMATION --}}
                                    <div class="mb-4">
                                        <div class="sectionheader" >
                                            Audition Information
                                        </div>
                                        <div class="detail-row">
                                            <label>Grade:</label>
                                            <div class="data">{{ $registrant->student->gradeClassof }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <label>Preferred Pronoun:</label>
                                            <div class="data">{{ $registrant->student->person->pronoun->descr }}</div>
                                        </div>

                                        <div class="detail-row">
                                            <label>Voice Part:</label>
                                            <div class="data">{{ $registrant->instrumentations->first()->formattedDescr() }}</div>
                                        </div>
                                    </div>

                                    {{-- PAYMENT INFORMATION --}}
                                    <div class="mb-4">
                                        <div class="sectionheader" >
                                            Payment Record
                                        </div>
                                        <div class="detail-row" style="display: flex; flex-direction: column;">
                                            <div class="data" style="font-weight: normal;">
                                                An audition fee of $15.00 per student will be charged.  In addition, chorus
                                                students accepted will be assessed a participation fee of $30.00.  The
                                                music will be theirs to keep.
                                            </div>
                                            <div style="display: flex; flex-direction: row;">
                                                <label>Payment Method: </label>
                                                <div class="data">
                                                    TBD
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- REHEARSAL SCHEDULE --}}
                                    <div class="mb-4">
                                        <div class="sectionheader" >
                                            Morris Area Honor Choir Schedule
                                        </div>
                                        <div style="font-size: small; text-align: center;">
                                            ** All students will be given learning tracks and will be expected to learn
                                            their music before the first rehearsal **
                                        </div>
                                        <div>
                                            <style>
                                                .date{width: 12rem;}
                                                .time{width: 9rem; text-align: center;}
                                            </style>
                                            <div class="schedule">
                                                <header style="display: flex; flex-direction: row;">
                                                    <div class="date font-bold">Date</div>
                                                    <div class="time font-bold">Middle School</div>
                                                    <div class="time font-bold">High School</div>
                                                    <div class="type font-bold">Event</div>
                                                </header>
                                                <div style="display: flex; flex-direction: row;">
                                                    <div class="date">Thursday, January 5th</div>
                                                    <div class="time">4:00 - 8:00pm</div>
                                                    <div class="time">4:00 - 8:15pm</div>
                                                    <div class="type">Rehearsal</div>
                                                </div>
                                                <div style="display: flex; flex-direction: row;">
                                                    <div class="date">Monday, January 9th</div>
                                                    <div class="time">4:00 - 8:00pm</div>
                                                    <div class="time">4:00 - 8:15pm</div>
                                                    <div class="type">Rehearsal</div>
                                                </div>
                                                <div style="display: flex; flex-direction: row;">
                                                    <div class="date">Tuesday, January 10th</div>
                                                    <div class="time">4:00 - 8:00pm</div>
                                                    <div class="time">4:00 - 8:15pm</div>
                                                    <div class="type">SNOW DATE</div>
                                                </div>
                                                <div style="display: flex; flex-direction: row;">
                                                    <div class="date">Wednesday, January 11th</div>
                                                    <div class="time">4:00 - 8:00pm</div>
                                                    <div class="time">4:00 - 8:15pm</div>
                                                    <div class="type">Rehearsal</div>
                                                </div>
                                                <div style="display: flex; flex-direction: row;">
                                                    <div class="date">Friday, January 13th</div>
                                                    <div class="time">9:00am - 3:00pm</div>
                                                    <div class="time">9:00am - 3:00pm</div>
                                                    <div class="type">All-Day Rehearsal</div>
                                                </div>
                                                <br />
                                                <div style="display: flex; flex-direction: row;">
                                                    <div class="date">Saturday, January 14th</div>
                                                    <div class="time">1:00 - 4:00pm</div>
                                                    <div class="time">1:00 - 4:00pm</div>
                                                    <div class="type">Rehearsal</div>
                                                </div>
                                                </header>
                                                <div style="display: flex; flex-direction: row;">
                                                    <div class="date">Saturday, January 14th</div>
                                                    <div class="time">4:00 pm</div>
                                                    <div class="time">4:00 pm</div>
                                                    <div class="type">Concert</div>
                                                </div>
                                                <div style="display: flex; flex-direction: row;">
                                                    <div class="date">Sunday, January 15th</div>
                                                    <div class="time">1:00pm </div>
                                                    <div class="time">1:00pm </div>
                                                    <div class="type">Call</div>
                                                </div>
                                                <div style="display: flex; flex-direction: row;">
                                                    <div class="date">Sunday, January 15th</div>
                                                    <div class="time">4:00pm</div>
                                                    <div class="time">4:00pm</div>
                                                    <div class="type">SNOW DATE</div>
                                                </div>
                                        </div>

                                    </div>

                                        {{-- EXPECTATIONS AND POLICIES --}}
                                        <div class="mb-4">
                                            <div class="sectionheader" >
                                                Ensemble Expectations and Policies
                                            </div>
                                            <div class=" justify-self-stretch mx-4 mb-4">
                                                <ol style="margin-left: 1rem; list-style-type: decimal; font-size: smaller;">
                                                    <li style="margin-bottom: 0.5rem;">
                                                        Participants are required to attend all rehearsals and performances for their full duration.
                                                    </li>
                                                    <li style="margin-bottom: 0.5rem;">
                                                        A single absence due to illness may be allowed, provided such absence
                                                        is explained to the satisfaction of the student's director, who in
                                                        turn will notify the chorus manager as to the nature of the absence.
                                                        Absence for other extenuating circumstances of a serious nature,
                                                        beyond the student's control, will be permitted provided the absence
                                                        is approved by BOTH the student's school director and the chorus manager.
                                                        In any event, only ONE evening absence for whatever reason may be
                                                        excused. (If either the director or manager finds the absence unexcused,
                                                        the student's membership will be terminated.)
                                                    </li>
                                                    <li style="margin-bottom: 0.5rem;">
                                                        Any student who misses more than one evening rehearsal for ANY reason,
                                                        or who misses the all-day rehearsal before the concert (Friday, January 13th)
                                                        or rehearsal the morning of the concert (Saturday, January 14th) will
                                                        not be allowed to participate.
                                                    </li>
                                                    <li style="margin-bottom: 0.5rem;">
                                                        An audition fee of $15.00 per student will be charged.  In addition,
                                                        chorus students accepted will be assessed a participation fee of $30.00.
                                                        The music will be theirs to keep.
                                                    </li>
                                                </ol>
                                            </div>
                                        </div>

                                        {{-- ENDORSEMENTS --}}
                                        <div class="mb-4">
                                            <div class="sectionheader" >
                                                Endorsements - Checkmarks Required
                                            </div>
                                            @if(config('app.url') === 'http://localhost')
                                                <form method="post" action="{{ route('registrant.eapplication', ['registrant' => $registrant]) }}">
                                            @else
                                                <form method="post" action="https://studentfolder.info/registrant/{{ $registrant->id }}/eapplication">
                                            @endif
                                                @csrf
                                            <div>
                                                <div class=" justify-self-stretch mx-4 mb-4" style="display: flex; flex-direction: row;">
                                                    <label style="width: 24rem;">Student Certification:</label>

                                                    <div style="display: flex; flex-direction: row;">
                                                        <div class="data" style="margin-left: 0.5rem;">
                                                            I certify that I will accept the decisions of the judges and
                                                            conductors as binding and if selected will accept membership in this
                                                            organization. I understand that membership in this organization will be terminated
                                                            if I fail to perform satisfactorily within my own school group or if I
                                                            fail to adhere to the rules set forth above. (Please check the box below.)
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class=" justify-self-stretch mx-4 mb-4" style="display: flex; flex-direction: row;">
                                                    <div style="display: flex; flex-direction: row;">
                                                        <label style="width: 7rem;"></label>
                                                        <input type="checkbox" name="signaturestudent" value="1" style="margin-top: 0.25rem; "
                                                            {{ $eapplication && $eapplication->signaturestudent == 1 ? 'CHECKED' : ''  }}
                                                        />
                                                        <div style="margin-left: 1rem; font-weight: bold;">
                                                            {{ $registrant->student->person->fullname }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <div class=" justify-self-stretch mx-4 mb-4" style="display: flex; flex-direction: row;">
                                                    <label style="width: 24rem;">Parent or Guardian Endorsement:</label>

                                                    <div style="display: flex; flex-direction: row;">
                                                        <div class="data" style="margin-left: 0.5rem;">
                                                            As parent or legal guardian of <b>{{ $registrant->student->person->fullname }}</b>,
                                                            I give my permission for {{ $registrant->student->person->pronoun->possessive }}
                                                            to be an applicant for this organization.  I understand that neither
                                                            {{ $registrant->student->currentSchoolname }} nor {{ $eventversion->event->organization->name }} assumes responsibility
                                                            for illness or accident.  I further attest the statement signed by
                                                            <b>{{ $registrant->student->person->fullname }}</b> and will assist
                                                            {{ $registrant->student->person->pronoun->possessive }} in fulfilling
                                                            the obligations incurred. (Please check the box below.)
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class=" justify-self-stretch mx-4 mb-4" style="display: flex; flex-direction: row;">
                                                    <div style="display: flex; flex-direction: row;">
                                                        <label style="width: 7rem;"></label>
                                                        <input type="checkbox" name="signatureguardian" value="1" style="margin-top: 0.25rem; "
                                                            {{ $eapplication && $eapplication->signatureguardian == 1 ? 'CHECKED' : ''  }}
                                                        />
                                                        <div style="margin-left: 1rem; font-weight: bold;">
                                                            {{ $registrant->student->guardians->first()->person->fullname }}
                                                        </div>

                                                    </div>

                                                </div>

                                                {{-- SUBMIT --}}
                                                <div class="input-group mt-8" >
                                                    <input type="submit" name="submit" value="Submit"
                                                           style="background-color: black; color: white; border-radius: .5rem;  padding:.25rem .5rem; margin-left: 8rem;"
                                                    />
                                                </div>
                                            </div>
                                        </form>

                                
                            </div>
                        </div>

            </div>
        </div>
    </div>
@endsection




