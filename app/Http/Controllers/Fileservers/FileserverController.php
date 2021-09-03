<?php

namespace App\Http\Controllers\Fileservers;

use App\Http\Controllers\Controller;
use App\Eventversion;
use App\Filecontenttype;
use App\Fileserver;
use App\Fileupload;
use App\Fileuploadfolder;
use App\Person;
use App\Registrant;
use App\Userconfig;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FileserverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request, Registrant $registrant,
                          Filecontenttype $filecontenttype, Person $person,
                            $folder_id)
    {
        //fileserver/confirmation/651347/5/351/3595dabd1a1aedb8?successful=true&video_id=069dd9b01c1ee0c28f
        //fileserver/confirmation/$this->registrant->id.'/'.$filecontenttype->id.'/'.auth()->id().'/'.$folder_Id
        Fileupload::updateOrCreate([
           'registrant_id' => $registrant->id,
           'filecontenttype_id' => $filecontenttype->id,
           'server_id' => $request['video_id'],
           'folder_id' => $folder_id,
           'uploaded_by' => $person->user_id,
        ]);

        $eventversion = $registrant->eventversion;
        $fileserver = new Fileserver($registrant);

        $folders = Fileuploadfolder::where('eventversion_id', $eventversion->id)
            ->where('instrumentation_id', $registrant->instrumentations->first()->id)
            ->get();

        $self_registration_open_date = Carbon::parse($eventversion->studentRegistrationDate('videos_student_open'))->format('F jS');
        $self_registration_close_date = Carbon::parse($eventversion->studentRegistrationDate('student_close'))->format('F jS');

        $video_close_date = Carbon::parse($eventversion->studentRegistrationDate('videos_student_close'))->format('F jS');

        return view('pages.registrants.profile', [
        'eventversion' => Eventversion::find($registrant->eventversion_id),
        'filename' => $fileserver->buildFilename($registrant),
        'fileserver' => $fileserver,
        'folders' => $folders,
        'registrant' => $registrant,
        'page_title' => $registrant->student->person->full_Name.' information for '.$eventversion->name,
        'self_registration_open_date' => $self_registration_open_date,
        'self_registration_close_date' => $self_registration_close_date,
        'video_close_date' => $video_close_date,
        'fileserver' => $fileserver,
        'filename' => $fileserver->buildFilename($registrant),
        'self_registration_open' => $eventversion->isSelfRegistrationOpen,
        'video_registration_open' => $eventversion->isVideoRegistrationOpen,
        'requiredheight' => $eventversion->event->requiredheight,
        'requiredshirtsize' => $eventversion->event->requiredshirtsize,
        'pronoun' => $registrant->student->person->pronounDescr,
        'registration_fee' => $eventversion->eventversionconfig->registration_fee,
        'chorals' => $registrant->eventversion->eventensembles[0]->instrumentations(),
        'registrant_chorals' => $registrant->chorals(),
        'choral' => $eventversion->event->isChoral(),
        'registrant_paid' => $registrant->paid(),
        'registrant_due' => $registrant->due(),
    ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
