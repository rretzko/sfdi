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
                                            <div class="font-bold text-center">SOUTH JERSEY Jr. & SR. HIGH CHORUS APPLICATION</div>
                                            <div class="text-center">{{ $eventversion->name }}</div>
                                            <div class="text-center text-sm">
                                                All signatures must be written clearly in ink and every category must
                                                be filled or the student will not be permitted to audition.
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
                                            <label>Choral Director:</label>
                                            <div class="data">{{ auth()->user()->person->fullName }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <label>Phones:</label>
                                            <div class="data">{{ auth()->user()->person->subscriberPhoneCsv }}</div>
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

                                    {{-- ENDORSEMENT --}}
                                    <div class="mb-4">
                                        <div class="sectionheader" >
                                            Endorsements - Signatures Required
                                        </div>
                                        <div class=" justify-self-stretch mx-4 mb-4">
                                            We, the undersigned, recommend <b>{{ $registrant->student->person->fullName }}</b>
                                            to audition for the {{ $eventversion->name }}.  <b>{{ $registrant->student->person->first }}</b>
                                            is aware of the fact that {{ $registrant->student->person->pronoun->personal }}
                                            must remain an active member in good standing of the school performing group
                                            throughout {{ $registrant->student->person->pronoun->possessive }} South
                                            Jersey experience.  {{ ucwords($registrant->student->person->pronoun->personal) }}
                                            is a qualified student, and is now enrolled in Grade {{ $registrant->student->grade }}
                                            at <b>{{ $registrant->student->person->user->schools()->first()->name }}</b>.
                                            In the event that <b>{{ $registrant->student->person->fullName }}</b> is
                                            accepted for membership in this chorus, we will use our influence to see that
                                            {{ $registrant->student->person->pronoun->personal }} is properly prepared,
                                            and all whose signatures appear on this application will adhere to the Rules
                                            and Regulations of the South Jersey Chorus.  We agree to the stated
                                            attendance policy and all relevant policies stated in the SJCDA Choral
                                            auditions packet.  Students will be removed from the chorus at any time if a
                                            jury of choral directors selected by the Festival Coordinator determines the
                                            student cannot capably perform their music, or if the student failes to meet
                                            the requirements outlined in this packet.
                                        </div>

                                    </div>

                                    {{-- SIGNATURES --}}
                                    <div class="w-4/12 mx-auto">
                                        @if(config('app.url') === 'http://localhost')
                                            <form method="post" action="{{ route('registrant.eapplication', ['registrant' => $registrant]) }}">
                                        @else
                                            <form method="post" action="https://studentfolder.info/registrants/{{ $registrant->id }}/eapplication">
                                        @endif
                                            @csrf
                                            <div class="input-group">
                                                <input type="checkbox" name="signaturestudent" value="1"
                                                    {{ $eapplication && $eapplication->signaturestudent == 1 ? 'CHECKED' : ''  }}
                                                >
                                                <label style="margin-left: .5rem;" for="student">{{ $registrant->student->person->fullName }} Signature</label>
                                            </div>
                                            <div class="input-group">
                                                <input type="checkbox" name="signatureguardian" value="1"
                                                    {{ $eapplication && $eapplication->signatureguardian == 1 ? 'CHECKED' : ''  }}
                                                >
                                                <label style="margin-left: .5rem;" for="student">Parent/Guardian Signature</label>
                                            </div>
                                            <div class="input-group mt-8">

                                                <input type="submit" name="submit" value="Submit"
                                                       style="background-color: black; color: white; border-radius: .5rem;  padding:.25rem .5rem;"
                                                />
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>

            </div>
        </div>
    </div>
@endsection




