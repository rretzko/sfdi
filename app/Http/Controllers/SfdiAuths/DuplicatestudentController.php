<?php

namespace App\Http\Controllers\SfdiAuths;

use App\Events\EmailDuplicateStudentNoticeEvent;
use App\Events\ResetPasswordRequestEvent;
use App\Http\Controllers\Controller;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DuplicatestudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(array $emails)
    {
        return view('pages.sfdiauths.currentstudentreset', ['emails' => $emails]);
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $inputs = Session::get('inputs');
        Session::remove('inputs');

        event(new EmailDuplicateStudentNoticeEvent($inputs));

        return view('pages.sfdiauths.duplicatestudent',
            [
                'inputs' => $inputs,
            ]
        );
    }

    /**
     * Show the form for resetting the specified resource's password.
     *
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id)
    {
        $student = Student::find($user_id);
        $emails = [];

        if(strlen($student->emailPersonal)){ $emails[] = $student->emailPersonal;}
        if(strlen($student->getEmailSchool)){ $emails[] = $student->emailSchool;}

        event(new ResetPasswordRequestEvent($student->nonsubscriberemails));

        return $this->index($emails);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
