<?php

namespace App\Http\Controllers;

use App\Person;
use App\School;
use App\Shirtsize;
use App\Student;
use App\Table_Schools;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $student = Student::find(Auth::user()->id);
        $table = new Table_Schools($student);
        return view('pages.schools',
                [
                    //'user' => Auth::user(),
                    //'schools' => Auth::user()->schools,
                    //'student' => Student::findOrFail(Auth::user()->id),
                    'table' => $table->table(),
                   // 'person' => Person::findOrFail(Auth::user()->id),
                   // 'shirt_sizes' => ShirtSize::orderBy('order_by')->get(),
                   // 'teachers' => Teacher::orderBy('user_id')->get()
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
        /*return view('school_add', [
            'user' => Auth::user(),
            'person' => Person::findOrFail(Auth::user()->id),
            'student' => Student::findOrFail(Auth::user()->id),
            'shirt_sizes' => ShirtSize::orderBy('order_by')->get(),
            'schools' => School::alphaOrder()->get(),
            'teachers' => Teacher::get(), //$teachers,
            'nav_links' => [
                'credentials' => '',
                'events' => '',
                'history' => '',
                'parent' => '',
                'profile' => '',
                'school' => '',
                'student' => ''
            ]]);*/
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
     * @param  \App\School  $school
     * @return \Illuminate\Http\Response
     */
    public function show(School $school)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\School  $school
     * @return \Illuminate\Http\Response
     */
    public function edit(School $school)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\School  $school
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, School $school)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\School  $school
     * @return \Illuminate\Http\Response
     */
    public function destroy(School $school)
    {
        //
    }
}
