<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\School;
use App\Student;
use App\Teacher;
use App\Events\StudentAddedSchoolEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.addeditschools', [
            'schools' => School::alphaOrder()->get(),
            'teachers' => Teacher::get(),
            'nav_links' => [
                'credentials' => '',
                'events' => '',
                'history' => '',
                'parent' => '',
                'profile' => '',
                'schools' => 'active',
                'student' => ''
            ]]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * $request->parameters[
     *      "id" => "1042"
     *      "checkbox_0" => "253"
     *      "checkbox_1" => "352"]
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new_teachers = [];

        //\App\Http\Requests\School_AddStore
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'teachers' => 'required|min:1'

        ]);

        if($validator->fails()){

            //Session::flash('error', $validator->messages()->first());
            return redirect()->back()->withInput();
        }

        $student = Student::find(Auth::user()->id);

        /** ADD SCHOOL IF NOT ALREADY EXISTS */
        //ex: student may be adding a multiple teachers from same school
        $schools = $student->schools;

        if(!$schools->contains(School::find($request['id']))){

            $student->schools()->attach(['school_id' => $request['id']]);
        }

        /** ADD TEACHER(S) IF NOT ALREADY EXISTS */
        //ex. student may have same teacher as public school and studio
        $teachers = $student->teachers;

        foreach($request['teachers'] AS $teacher_user_id){

            if(!$teachers->contains(Teacher::find($teacher_user_id))){

                //$student->teachers()->attach(['teacher_user_id' => $teacher_user_id]);
                $student->teachers()->attach($teacher_user_id, ['studenttype_id' => 7]); //active
            }

            //if either new school or new teacher, add teacher's object to array
            if((!$schools->contains(School::find($request['id']))) ||
                (!$teachers->contains(Teacher::find($teacher_user_id)))){

                $new_teachers[] = Teacher::find($teacher_user_id);
            }
        }

        //email notice to new teachers
        if(count($new_teachers)){
            /** @todo Create new email system around newly added students */
            //event(new StudentAddedSchoolEvent(
            //        School::find($request['id']),$student, $new_teachers));
        }

        return redirect('schools')->with('message', 'Successful update!');
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
