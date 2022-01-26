<?php

namespace App\Listeners;

use App\Events\EmailDuplicateStudentNoticeEvent;
use App\Teacher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EmailDuplicateStudentNoticeListener
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
     * @param  EmailDuplicateStudentNoticeEvent  $event
     * @return void
     */
    public function handle(EmailDuplicateStudentNoticeEvent $event)
    {
        $teacher = Teacher::findTeacherByLastnameSchool($event->input['teacher_last'], $event->input['school']);

        dd($teacher);
    }
}
