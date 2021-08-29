<?php

namespace App\Listeners;

use App\Events\StudentRequestTeacher;
use App\Mail\StudentRequestTeacher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class EmailTeacherNewStudent
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
     * @param  StudentRequestTeacher  $event
     * @return void
     */
    public function handle(StudentRequestTeacher $event)
    {
        Log::info('Email sent to: '.$event->teacher->person->full_name);
        
        //Mail::to('rretzko@hotmail.com')->send('proxy text');
        Mail::send('welcome', [], function ($message){
           $message->to('rretzko@hotmail.com')->subject('laravel test'); 
        });
    }
}
