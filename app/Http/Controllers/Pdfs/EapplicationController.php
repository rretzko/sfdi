<?php

namespace App\Http\Controllers\Pdfs;

use App\Registrant;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;

class EapplicationController extends Controller
{
    public function __invoke(Registrant $registrant)
    {
        $eApplication = $registrant->eapplication;

        $eventversion = \App\Eventversion::find($registrant->eventversion->id);
        $filename = self::build_Filename($eventversion, $registrant);
        $teacher = $registrant->student->teachers->first();
        $school = $registrant->school()->name;

        //ex. pages.pdfs.applications.12.64.application
        $pdf = PDF::loadView('pages.pdfs.eapplications.'
            . self::default_Or_Id($eventversion)
            . '.eapplication',
            compact('registrant','eventversion','teacher','school'));

        return $pdf->download($filename);
    }

    /** END OF PUBLIC FUNCTIONS ***************************************************/

    /**
     * @since 2020.08.08
     *
     * @param \App\Http\Controllers\Pdfs\Eventversion $eventversion
     * @param \App\Http\Controllers\Pdfs\Registrant $registrant
     * @return string ex: SJCDA_Sr_High_2021_RetzkoF.pdf
     */
    private function build_Filename(\App\Eventversion $eventversion,
                                    \App\Registrant $registrant) : string
    {
        return str_replace(' ', '_',
                str_replace('.', '', $eventversion->short_name))
            . '_'
            . 'eApplication_'
            . $registrant->student->person->last_name
            . substr($registrant->student->person->first_name, 0, 1)
            . '.pdf';
    }

    /**
     * @since 2020.08.08
     *
     * @param \App\Eventversion $eventversion
     * @return string
     */
    private function default_Or_Id(\App\Eventversion $eventversion) : string
    {
        if(\App::environment('local')){

            $root = 'C:\xampp\htdocs\dev\dTdr\resources\views\pages\pdfs\applications';

        }else{

            $root = 'resources/views/pages/pdfs/applications';
        }

        $base = $root.DIRECTORY_SEPARATOR;
//echo is_dir($base).': '.$base.'<br />';
//echo is_dir($base.DIRECTORY_SEPARATOR.$eventversion->event->id).': '.$base.DIRECTORY_SEPARATOR.$eventversion->event->id.'<br />';
//echo is_dir($base.DIRECTORY_SEPARATOR.$eventversion->event->id.DIRECTORY_SEPARATOR.$eventversion->id).': '.$base.DIRECTORY_SEPARATOR.$eventversion->event->id.DIRECTORY_SEPARATOR.$eventversion->id.'<br />';exit();
        if(is_dir($base.DIRECTORY_SEPARATOR.$eventversion->event->id.DIRECTORY_SEPARATOR.$eventversion->id)){ //default eventversion application

            //dd($base.DIRECTORY_SEPARATOR.$eventversion->event->id.DIRECTORY_SEPARATOR.$eventversion->id);
            return $eventversion->event->id.'.'.$eventversion->id;

        }elseif(is_dir($base.DIRECTORY_SEPARATOR.$eventversion->event->id)){ //default event application

            //dd($base.DIRECTORY_SEPARATOR.$eventversion->event->id);
            return $eventversion->event->id;
        }else{ //default application

            dd($base.DIRECTORY_SEPARATOR.'default');
            return 'default';
        }

    }
}
