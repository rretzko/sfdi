<?php

namespace App\Http\Controllers;

use App\Eapplication;
use App\Eventversion;
use App\Registrant;
use App\Userconfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EapplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $student = \App\Student::find(auth()->id());

        return view('pages.eapplication', [
            'student' => $student,
            'page_title' => 'All-Shore Chorus eApplication',
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Geostate  $geoState
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $student = \App\Student::find(auth()->id());

        return view('pages.eapplication', [
            'student' => $student,
            'page_title' => 'All-Shore Chorus eApplication',
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Registrant $registrant
     * @return \Illuminate\Http\Response
     */
    public function edit(Registrant $registrant)
    {
        $eventversion = Eventversion::find(substr($registrant->auditionnumber,0,2));

        return view('pages.eapplications.'.$eventversion->event->id.'.'.$eventversion->id.'.eapplication', [
            'eventversion' => $eventversion,
            'student' => $registrant->student,
            'registrant' => $registrant,
            'page_title' => $eventversion->name.' eApplication',
            'path_audit' => 'forms.eapplications.'.$eventversion->event->id.'.'.$eventversion->id.'.feapplication_audit',
            'path_update' => 'forms.eapplications.'.$eventversion->event->id.'.'.$eventversion->id.'.feapplication_update',
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Registrant  $registrant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Registrant $registrant)
    {
        $eventversion = Eventversion::find(substr($registrant->auditionnumber,0,2));

        $request->validate([
            'absences' => ['required', 'numeric'],
            'courtesy' => ['required', 'numeric'],
            'dressrehearsal' => ['required', 'numeric'],
            'eligibility' => ['required', 'numeric'],
            'imageuse' => ['required', 'numeric'],
            'lates' => ['required', 'numeric'],
            'parentread' => ['required', 'numeric'],
            'rulesandregs' => ['required', 'numeric'],
            'signatureparent' => ['required', 'string'],
            'signaturestudent' => ['required', 'string'],
            'videouse' => ['required', 'numeric'],
        ]);

        Eapplication::updateOrCreate(['auditionnumber' => $registrant->auditionnumber],
                [
                    'absences' => $request['absences'],
                    'courtesy' => $request['courtesy'],
                    'dressrehearsal' => $request['dressrehearsal'],
                    'eligibility' => $request['eligibility'],
                    'eventversion_id' => $eventversion->id,
                    'imageuse' => $request['imageuse'],
                    'lates' => $request['lates'],
                    'parentread' => $request['parentread'],
                    'rulesandregs' => $request['rulesandregs'],
                    'signatureparent' => $request['signatureparent'],
                    'signaturestudent' => $request['signaturestudent'],
                    'updated_by' => auth()->id(),
                    'user_id' => $registrant->user_id,
                    'videouse' => $request['videouse'],
                ]);

        $registrant->auditiondetail->applied();

        Session::flash('status', 'Your application has been accepted!');

        $registration_fee = $eventversion->eventversionconfig->registrationfee;

        $vs = new \App\Videoserver;
        $vs->set_Registrant($registrant);

        /** @todo build video titles into Auditionforms.com configuration */
        $video_titles = [
            62 => [
                6 => 'The Defining Moment',
                9 => 'I Sing Because I\'m Happy'
            ],
            63 => [
                6 => 'Stand Together',
                8 => 'Wana Baraka',
                9 => 'I Sing Because I\'m Happy'
            ],
            64 => [
                6 => 'Make Them Hear You',
                8 => 'Wana Baraka',
                9 => 'I Sing Because I\'m Happy'
            ],
        ];


        return view('pages.registrants.profile', [
            'registrant' => $registrant,
            'eventversion' => $eventversion,
            'page_title' => $registrant->student->person->full_Name.' information for '.$eventversion->name,
            'shirt_sizes' => \App\Shirtsize::all(),
            'chorals' => $eventversion->event->ensembletypes->first()->instrumentations,//\App\Instrumentation::orderBy('descr')->where('branch', 'choral')->get(),
            'registrant_chorals' => $registrant->chorals(),
            'choral' => $eventversion->event->isChoral(),
            'instrumental' => $eventversion->event->isInstrumental(),
            'auditioncount' => $eventversion->event->auditioncount,
            'requiredheight' => $eventversion->event->requiredheight,
            'requiredshirtsize' => $eventversion->event->requiredshirtsize,
            'pronoun' => $registrant->student->person->pronounDescr,
            'registration_fee' => $registration_fee,
            'videoserver' => $vs,
            'registration_fee' => $eventversion->eventversionconfig->registrationfee,
            'epayment_fee' => ($eventversion->eventversionconfig->registrationfee + $eventversion->eventversionconfig->epaymentsurcharg),
            'registrant_paid' => $registrant->paid(),
            'registrant_due' => $registrant->due(),
            'self_registration_open' => $eventversion->isSelfRegistrationOpen,
            'video_titles' => $video_titles,
            'payment_hints' => '('.$registrant->auditionnumber.')',
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Geostate  $geoState
     * @return \Illuminate\Http\Response
     */
    public function destroy(GeoState $geoState)
    {
        //
    }
}
