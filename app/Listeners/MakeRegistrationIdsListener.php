<?php

namespace App\Listeners;

use App\Registrant;
use App\Registranttype;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MakeRegistrationIdsListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //get $event->student's teacher
        $teacher = $event->student->teachers->first();

        //get $teacher open events
        $openEvents = $teacher->eventversionsOpenForStudents;

        if(count($openEvents)){
            //make registration ids
            foreach($openEvents AS $item){ //Eventversion model

                $registrantIdMin = $item->id * 10000;
                $registrantIdMax = ($registrantIdMin + 9999);
                $registrantId = rand($registrantIdMin, $registrantIdMax);

                //find a non-existent registrant_id
                while(Registrant::find($registrantId)){

                    $registrantId = rand($registrantIdMin, $registrantIdMax);
                }

                $registrant = Registrant::firstOrCreate(
                    [
                        'user_id' => $event->student->user_id,
                        'eventversion_id' => $item->id,
                        'school_id' => $event->student->schools->first()->id,
                    ],
                    [
                        'id' => $registrantId,
                        'programname' => $event->student->person->fullName,
                        'registranttype_id' => Registranttype::ELIGIBLE,
                    ]
                );

                Log::info('New registrant id: '.$registrant->id.' for '.$item->name.' (id: '.$item->id.')');
            }

        }else{
            Log::info('No open eventversions');
        }
        Log::info(__METHOD__).': student_id = '.$event->student->id;
    }
}
