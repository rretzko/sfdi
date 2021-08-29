<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use App\School;
use App\Student;
use App\Teacher;
use App\User;
use Illuminate\Http\Request;

class StudentAddSchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view('pages.addeditschools', [
            'schools' => School::with('teachers')
                ->has('teachers', '>', 0)
                ->orderBy('name')
                ->get(),
            'teachers' => [],
            'user' => $user
            ]);
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
     * $request->parameters[
     *      "id" => "1042" //school_id
     *      "teachers" => [
     *          "253", "352"   //user_id for teacher(s) selected
     *      ]
     *  ]
     * 
     * 1. link student to school
     * 2. link student to teacher
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\StudentAddSchoolStoreRequest $request)
    {
        $cntr = 0;
        $mssg = [];
        $mssg[] = 'Successful update';
        
        //StudentAddSchoolStoreRequest handles validation and error processing
        $student = Student::find(auth()->user()->id);
        
        //attach student to school
        $student->schools()->attach($request->id, ['status' => 'pending']);
        
        //attach student to teacher
        foreach($request->teachers AS $teacher_id){
            
            $teacher = Teacher::find($teacher_id);
            $student->teachers()->attach($teacher_id, ['status' => 'pending']);
            
            $to = 'rick@mfrholdings.com';
            Mail::to($to)->send(new \App\Mail\NewStudentRequest($student, $teacher));
            
            Mail::failures() 
                    ? Log::info('Email failure to: '.$to.' @ '.date('d-F-Y G:i:s', strtotime('NOW')))
                    : $mssg[] = $teacher->person->full_name.' has been notified.';
            
        }        
        
        return redirect('school')->with('message', implode('<br />',$mssg));
    }
    
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
