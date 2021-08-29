<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StoreEmailTeacherAboutNewStudentListener
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
     *@todo add verified condition
     * Store the text of the email into the database as a Missive object
     *
     * @param  StudentAddedSchoolEvent  $event
     *  contains $school, $student, [$teachers]
     * @return void
     */
    public function handle(\App\Events\StudentAddedSchoolEvent $event)
    {
        foreach($event->teachers AS $teacher){

            foreach($teacher->person->emails AS $email){
                if(strlen($email->email)){ //&& ($email->verified === "1"){
                    $missive = new \App\Missive;
                    $missive->person = $teacher->person;
                    $missive->school = $event->school;
                    $missive->sent_to = $email->pivot->type;
                    $missive->student = $event->student;
                    $missive->template = 'sendEmailTeacherAboutNewStudent';
                    $missive->add();
                    $missive->save();
                }
            }
        }
    }
}
