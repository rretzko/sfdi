<?php

namespace App\Mail;

use App\School;
use App\Student;
use App\Teacher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class newStudent extends Mailable
{
    use Queueable, SerializesModels;

    private $school;
    private $student;
    private $teacher;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(School $school, Student $student, Teacher $teacher)
    {
        $this->school = $school;
        $this->student = $student;
        $this->teacher = $teacher;
    }

    /**
     * Build the message.
     *
     * uses global MAIL_FROM_ADDRESS and MAIL_FROM_NAME for "From" and "Reply-To"
     * 
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.newstudent')
                ->text('emails.newstudent_plain')
                ->with([
                    'teacher_name' => $this->teacher->person->first_name,
                    'student_name' => $this->student->person->fullName,
                    'school_name' => $this->school->name,
                    'student' => $this->student,
                    'student_user_id' => $this->student->user_id,
                    'teacher_user_id' => $this->teacher->user_id,
                ]);
    }
}
