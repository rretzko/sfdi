<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
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
    public function store(Request $request, Student $student)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\StudentStoreRequest $request, Student $student)
    {
        $student->birthday = request('birthday');
        $student->class_of = request('class_of');
        $student->height = request('height');
        $student->shirt_size = request('shirt_size');
        $student->save();
   
        self::update_Instrumentation($request, $student);
        
        return redirect('student')->with('message', 'Successful update!');
    }
    
    private function update_Instrumentation(
            \App\Http\Requests\StudentStoreRequest $request, 
            \App\Student $student)
    {
        //remove all existing attachments
        $student->instrumentations()->detach();
        
        $this->update_Instrumentation_All($request->input('chorals'), $student);
        
        $this->update_Instrumentation_All($request->input('instrumentals'), $student);
    }
    
    private function update_Instrumentation_All(array $a, \App\Student $student)
    { 
        foreach($a AS $key => $instrumentation){

            if($instrumentation){

                //attach student to instrumentation
                $student->instrumentations()->attach(
                        $instrumentation, ['order_by' => $key]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }
}
