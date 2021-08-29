<?php

namespace App\Http\Controllers;

use App\Registrant;
use App\Eventversion;
use App\Videoserver;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
     * Display the specified resource.
     *
     * @param  \App\Eventversion $eventversion
     * @return \Illuminate\Http\Response
     */
    public function show(Eventversion $eventversion)
    {
        //check if user is currently a registrant in $eventversion
        $registrant = Registrant::where([
            'user_id' => auth()->user()->id,
            'eventversion_id' => $eventversion->id,
        ])->first();

        //else, create registrant record
        if(! is_a($registrant, 'App\Registrant')){

            $registrant = new \App\Registrant();
            $registrant->self_Registration($eventversion);
        }

        $vs = new Videoserver;
        $vs->set_Registrant($registrant);

        return view('pages.registrants.profile', [
            'registrant' => $registrant,
            'eventversion' => $eventversion,
            'page_title' => $registrant->student->person->full_Name.' information for '.$eventversion->name,
            'shirt_sizes' => \App\Shirtsize::all(),
            'chorals' => \App\Instrumentation::orderBy('descr')->where('branch', 'choral')->get(),
            'registrant_chorals' => $registrant->chorals(),
            'choral' => $eventversion->event->isChoral(),
            'instrumental' => $eventversion->event->isInstrumental(),
            'auditioncount' => $eventversion->event->auditioncount,
            'requiredheight' => $eventversion->event->requiredheight,
            'requiredshirtsize' => $eventversion->event->requiredshirtsize,
            'pronoun' => $registrant->student->person->pronounDescr,
            'videoserver' => $vs,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Registrant  $registrant
     * @return \Illuminate\Http\Response
     */
    public function edit(Registrant $registrant)
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
        $voicings = implode(',',
                array_merge($request['chorals'], $request['instrumentals']));

        $ad = \App\Auditiondetail::find($registrant->auditionnumber);
        $ad->update([
            'programname' => $request['programname'],
            'voicings' => $voicings,
            ]);

        return redirect(url('event/students/roster/'.\App\Userconfig::eventversionValue()))
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
}
