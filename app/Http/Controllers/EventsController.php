<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Student;
use App\Person;
use App\Table_Events;

class EventsController extends Controller
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
        $student = Student::find(auth()->user()->id);

        return view('pages.events.roster', [
            'eventversions' => $student->eventversionsOpen(),
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

        $student = (Student::find($user_id))
                ? Student::find($user_id)
                : Student::create(['user_id' => $user_id, 'class_of' => (date('Y') + 3)]);

        $table_events = new Table_Events($student);

        return [
                'user' => $user,
                'student' => $student,
                'table_events' => $table_events->table(),
                'person' => Person::firstOrCreate(['user_id' => $user_id]),
                'nav_links' => $this->nav_links,
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
