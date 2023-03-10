<?php

namespace App\Http\Controllers\Admin;

use App\Grades_Class_Ofs;
use App\Http\Controllers\Controller;
use App\Instrumentation;
use App\Person;
use App\Pronoun;
use App\Shirtsize;
use App\Student;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admins.index');
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
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $inputs = $request->validate(
            [
                'username' => ['required','exists:users,username'],
            ]
        );

        $user = User::where('username', $inputs['username'])->first();

        auth()->loginUsingId($user->id);

        return view('pages.profile', self::arguments($user));
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

    /**
     * Build arguments list for view
     *
     * @return array
     */
    private function arguments($user) : array
    {
        $user_id = $user->id;

        $grades_class_ofs = new Grades_Class_Ofs();

        $student = Student::find($user_id);

        if(is_null($student->person->address)){

            self::setAddress($student);

            $student = Student::find($user_id);
        }

        return [
            'age' => $student->age(),
            'geostates' => \App\Geostate::all(),
            'grades_class_ofs' => $grades_class_ofs->structure(),
            'user' => $user,
            'student' => $student,
            'person' => Person::firstOrCreate(['user_id' => $user_id]),
            'pronouns' => Pronoun::orderBy('order_by')->get(),
            'shirt_sizes' => Shirtsize::orderBy('order_by')->get(),
            'nav_links' => $this->nav_links(),
            'choral' => Instrumentation::orderBy('descr')->where('instrumentationbranch_id', 1)->get(), //choral
            'instrumental' => \App\Instrumentation::orderBy('descr')->where('instrumentationbranch_id', 2)->get(), //instrumental
            'student_chorals' => $student->chorals(),
            'student_instrumentals' => $student->instrumentals(),
        ];

    }

    /**
     * Initialize $this->nav_links array
     */
    private function nav_Links()
    {
        return [
            'credentials' => '',
            'event' => '',
            'parent' => '',
            'profile' => 'active',
            'school' => '',
            'student' => '',
        ];
    }
}
