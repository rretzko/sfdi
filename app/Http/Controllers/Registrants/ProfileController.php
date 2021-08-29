<?php

namespace App\Http\Controllers\Registrants;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('/');
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
     * @param  Student $student
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Registrant $registrant
     * @return \Illuminate\Http\Response
     */
    public function edit(\App\Registrant $registrant)
    {
        $grades_class_ofs = new \App\Grades_Class_Ofs;

        $calc_age = (date('Y') - substr($registrant->student->birthDate, 0, 4));

        return view('pages.dossiers.profile', [
            'registrant' => $registrant,
            'student' => $registrant->student,
            'calc_age' => $calc_age,
            'page_title' => 'Profile',
            'pronouns' => \App\Pronoun::all(),
            'grades_class_ofs' => $grades_class_ofs->structure(),
            'auditionnumber' => $registrant->auditionnumber,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student $student
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\DossierProfileRequest $request, \App\Registrant $registrant)
    {
        $student = $registrant->student;

        $student->person->first_name = $request['first_name'];
        $student->person->middle_name = $request['middle_name'];
        $student->person->last_name = $request['last_name'];
        $student->person->pronoun_id = $request['pronoun_id'];
        $student->person->save();

        $student->birthday = $request['birthday'];
        $student->class_of = $request['class_of'];
        $student->save();

        return redirect()->route('registrant.show', ['registrant' => $registrant]);
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
