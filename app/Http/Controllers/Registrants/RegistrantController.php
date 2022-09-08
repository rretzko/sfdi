<?php

namespace App\Http\Controllers\Registrants;

use App\Eventversionteacherconfig;
use App\Http\Controllers\Controller;
use App\Fileserver;
use App\Registrant;
use App\Eventversion;
use App\Videoserver;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RegistrantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Registrant  $registrant
     * @return \Illuminate\Http\Response
     */public function edit(Eventversion $eventversion)
    {
        //check if user is currently a registrant in $eventversion
        $registrant = Registrant::where([
            'user_id' => auth()->id(),
            'eventversion_id' => $eventversion->id,
        ])->first();

        //else, create registrant record
        if(! is_a($registrant, 'App\Registrant')){

            $registrant = new \App\Registrant();
            $registrant->self_Registration($eventversion);
        }

        $vs = new Videoserver;
        $vs->set_Registrant($registrant);

        $registration_fee = $eventversion->eventversionconfig->registrationfee;

        $isRegistered = $registrant->registranttype_id == 16;

        /** @todo build video titles into Auditionforms.com configuration */
        $video_titles = [
            62 => [
                6 => 'I Sing Because I\'m Happy',
                9 => 'The Defining Moment'
            ],
            63 => [
                6 => 'Stand Together',
                8 => 'Wana Baraka',
                9 => 'The Defining Moment'
            ],
            64 => [
                6 => 'Make Them Hear You',
                8 => 'Wana Baraka',
                9 => 'The Defining Moment'
            ],
            65 => [
                1 => 'Scales',
                4 => 'The Silver Swan',
                5 => 'Shenandoah',
            ],
            71 => [
                1 => 'Scales',
                4 => 'The Silver Swan',
                5 => 'Deep River',
            ],
            73 => [
                1 => 'Scales',
                5 => 'Velvet Shoes (MS)/Ash Grove (HS)',
            ],
        ];

        //2021-08-28
        /*
        $folder_id = \App\Fileuploadfolder::where('eventversion_id', $eventversion->id)
                ->where('instrumentation_id', $registrant->primaryAuditionVoicingId)
                ->first()->id ?? 0;
        $folders = \App\Fileuploadfolder::where('eventversion_id', $eventversion->id)
                ->where('instrumentation_id', $registrant->primaryAuditionVoicingId)
                ->get() ?? [];

        $fileserver = new Fileserver($registrant);
        */
        //sprout video folder id
        /*$folder_id = \App\Sv_folder::where('eventversion_id', $eventversion->id)
                ->where('instrumentation_id', $registrant->primaryAuditionVoicingId)
                ->first()->id ?? 0;
        $folders = \App\Sv_folder::where('eventversion_id', $eventversion->id)
            ->where('instrumentation_id', $registrant->primaryAuditionVoicingId)
            ->get() ?? [];
        */
//dd($eventversion->studentRegistrationDate('videos_student_open'));
        $self_registration_open_date = Carbon::parse($eventversion->studentRegistrationDate('videos_student_open'))->format('F jS');
        $self_registration_close_date = Carbon::parse($eventversion->studentRegistrationDate('student_close'))->format('F jS');

        $video_close_date = Carbon::parse($eventversion->studentRegistrationDate('videos_student_close'))->format('F jS');
        //Carbon\Carbon::parse($eventversion->eventversiondates->where('datetype_id', \App\Datetype::where('descr', 'videos_student_open')->first()->id)->first()->dt)->format('F jS');

        $iseapplication = $eventversion->eventversionconfig->eapplication;

        $sjcdaapplicationclosed = Carbon::now() > $eventversion->studentRegistrationDate('student_close');

        $videosubmissionclosed = Carbon::now() > $eventversion->date_raw('videos_student_close');

        return view('pages.registrants.profile', [
            'registrant' => $registrant,
            'eventversion' => $eventversion,
            'page_title' => $registrant->student->person->full_Name.' information for '.$eventversion->name,
            'shirt_sizes' => \App\Shirtsize::all(),
            'chorals' => ($registrant->eventversion->id == 73) ? $this->MAHC_instrumentations() : $registrant->eventversion->eventensembles[0]->instrumentations() ,
            //'chorals' => $registrant->eventversion->eventensembles[0]->instrumentations(),
            //'chorals' => $eventversion->event->ensembletypes->first()->instrumentations,//\App\Instrumentation::orderBy('descr')->where('branch', 'choral')->get(),
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
            'video_registration_open' => $eventversion->isVideoRegistrationOpen,
            'videosubmissionclosed' => $videosubmissionclosed,
            'video_titles' => $video_titles,
            'select_elem' => ($eventversion->id === 62) ? 'SELECTED' : '',
            'select_jrsr' => ($eventversion->id !== 62) ? 'SELECTED' : '',
            'payment_hints' => '('.$registrant->auditionnumber.')',
            'isRegistered' => $isRegistered,
            'folder_id' => '', //$folder_id,
            'folders' => '', //$folders,
            'self_registration_open_date' => $self_registration_open_date,
            'self_registration_close_date' => $self_registration_close_date,
            'video_close_date' => $video_close_date,
            'fileserver' =>  '', //$fileserver,
            'filename' => '', //$fileserver->buildFilename($registrant),
            'iseapplication' => $iseapplication,
            'test' => $sjcdaapplicationclosed,
            'sjacdaapplicationclosed' => $sjcdaapplicationclosed,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Eventversion $eventversion
     * @return \Illuminate\Http\Response
     */
    public function show(Registrant $registrant)
    {
        //
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
        //$voicings = implode(',',
        //        array_merge($request['chorals'], $request['instrumentals']));

        $registrant->update([
            'programname' => $request['programname'],
        ]);

        DB::table('instrumentation_registrant')
            ->where('registrant_id', '=', $registrant->id)
            ->update(['instrumentation_id'=> $request['chorals'][0]]);

        //$ad = \App\Auditiondetail::find($registrant->auditionnumber);
        //$ad->update([
        //    'programname' => $request['programname'],
        //    'voicings' => $request['chorals'],
        //    ]);

        return redirect(route('registrant.profile.edit', ['eventversion' => $registrant->eventversion]))
                ->with('success', $request['programname']
                    .' audition information is successfully saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Registrant  $registrant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Registrant $registrant)
    {
        //
    }
    
    /**
     * Workaround to return instrumentations for all Morris Area Honor Choirs
     * @return Collection
     */
    private function MAHC_instrumentations()
    {
        $instrumentationids = [5,1,72,73,63,64,65,66,67,68,69,70];

        return Instrumentation::find($instrumentationids);
    }
}
