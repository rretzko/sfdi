<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Email;
use App\EmailPerson;
use App\Grades_Class_Ofs;
use App\Instrumentation;
use App\InstrumentationStudent;
use App\Student;
use App\Person;
use App\PersonPhone;
use App\Phone;
use App\Pronoun;
use App\Shirtsize;
use App\Table_Events;
use App\Table_Parents;
use App\Table_Schools;

class ParentguardiansController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        self::nav_Links();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.parents', self::arguments());
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
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\StudentStoreRequest $request)
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

/** END OF PUBLIC METHODS *****************************************************/

    /**
     * Build arguments list for view
     *
     * @return array
     */
    private function arguments() : array
    {
        $user = Auth::user();
        $user_id = $user->id;

        $student = Student::find(Auth::user()->id);
        $table_parents = new Table_Parents($student);

        return [
                'table_parents' => $table_parents->table(),
                ];

    }

    /**
     * Initialize $this->nav_links array
     */
    private function nav_Links()
    {
        $this->nav_links = [
            'credentials' => '',
            'event' => 'active',
            'parent' => '',
            'profile' => '',
            'school' => '',
            'student' => '',
        ];
    }
}
