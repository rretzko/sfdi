<?php

namespace App\Http\Controllers\Pdfs;

use App\Application;
use App\Http\Controllers\Controller;
use App\Applicationpplication;
use App\Teacher;
use App\Registrant;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    public function __invoke(\App\Registrant $registrant)
    {
        //2021-08-28
        $teacher = Teacher::find(auth()->id());
        $school = $registrant->student->person->user->schools->first();
        $schoolname = $school->name;

        $eventversion = $registrant->eventversion;
        $filename = self::build_Filename($eventversion, $registrant); //ex: "2021_NJASC_2021_BhargavaV.pdf"
        $me = auth()->user();

        $registrantfullname = $registrant->student->person->fullName;
        $registrantfirstname = $registrant->student->person->first;

        $resource = 'pages.pdfs.applications.'//9.65.2021_22_application',
            . $eventversion->event->id
            .'.'
            . $eventversion->id
            . '.application';

        //ex. pages.pdfs.applications.12.64.application
        $pdf = Pdf::loadView($resource,
            compact('registrant','eventversion', 'teacher', 'school','me','schoolname',
            'registrantfirstname','registrantfullname'));

        //log application printing
        Application::create([
            'registrant_id' => $registrant->id,
            'updated_by' => auth()->id(),
        ]);


        //update registrant status
        $registrant->resetRegistrantType('applied');

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
                    . $eventversion->senior_class_of
                    . '_'
                    . $registrant->student->person->last
                    . substr($registrant->student->person->first, 0, 1)
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

            //dd($base.DIRECTORY_SEPARATOR.'default');
            return 'default';
        }

    }
}
