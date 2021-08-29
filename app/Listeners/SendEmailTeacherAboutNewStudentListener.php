<?php

namespace App\Listeners;

use App\Events\StudentAddedSchoolEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailTeacherAboutNewStudentListener
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
     * @param  StudentAddedSchool  $event
     * @return void
     */
    public function handle(StudentAddedSchoolEvent $event)
    {
        Log::info('New Student Added: '.$event->student->person->fullName);
        
        foreach($event->teachers AS $teacher){
        
            foreach($teacher->person->emails AS $email){
                
                if(strlen($email->email)){ //&& ($email->verified === "1")
                    
                    Mail::to($email)->send(new \App\Mail\newStudent(
                        $event->school, $event->student, $teacher));
                }
            }
            
        }
        
    }
}
