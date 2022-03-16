<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use App\Grades_Class_Ofs;
use App\Instrumentation;
use App\Student;
use App\Person;
use App\Pronoun;
use App\Shirtsize;
use App\Table_Events;
use App\Table_Parents;
use App\Table_Schools;
use App\Teacher;

class HomeController extends Controller
{
    private $nav_links;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');

        self::nav_Links();
    }

    /**
     * Display confirm-password form
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function confirmPassword()
    {
        return view('pages.confirm');
    }

    /**
     * Show the application dashboard with profile form exposed
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function credentials()
    {
        return view('pages.credentials', self::arguments());
    }

    /**
     * Show the application dashboard with event form exposed.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function event()
    {
        // $this->nav_links['event'] = 'show';
        // return self::default_View();
        return view('pages.profile', self::arguments());
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //identify and resolve any student user with a NULL address
        $address = new Address;
        $address->resolveNullAddressFields(auth()->id());

        return (auth()->user())
            ? view('pages.profile', self::arguments())
            : view('welcome');
        //$student = Student::find(auth()->user()->id);

        //return view('pages.events.roster', ['eventversions' => $student->eventversionsOpen()]);
    }

    /**
     * Show the application dashboard with school form exposed.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function parent()
    {
        // $this->nav_links['parent'] = 'show';
        // return self::default_View();
        return view('pages.parents', self::arguments());
    }

    /**
     * Show the application dashboard with profile form exposed
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        //configure $this->nav_links array
        // $this->nav_links['profile'] = 'show';
        // return self::default_View();
        return view('pages.profile', self::arguments());
    }

     /**
     * Show the application dashboard with school form exposed.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function school()
    {
        // $this->nav_links['school'] = 'show';
        // return self::default_View();
        return view('pages.schools', self::arguments());
    }

    /**
     * Show the application dashboard with student form exposed.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function student()
    {
        // $this->nav_links['student'] = 'show';
        // return self::default_View();
        return view('pages.profile', self::arguments());
    }

/** PRIVATE METHODS ***********************************************************/

    /**
     * Build arguments list for view
     *
     * @return array
     */
    private function arguments() : array
    {
        $user = Auth::user();
        $user_id = $user->id;

        $grades_class_ofs = new Grades_Class_Ofs();

        $student = Student::findOrFail($user_id);
        $table = new Table_Schools($student);

        $table_events = new Table_Events($student);
        $table_parents = new Table_Parents($student);

        return [
            'age' => $student->age(),
            'geostates' => \App\Geostate::all(),
            'grades_class_ofs' => $grades_class_ofs->structure(),
            'user' => $user,
            'schools' => $student->schools,
            'student' => $student,
            'student_chorals' => $student->chorals(),
            'student_instrumentals' => $student->instrumentals(),
            'table' => $table->table(),
            'table_events' => $table_events->table(),
            'table_parents' => $table_parents->table(),
            'myteachers' => $student->teachers,
            'person' => Person::findOrFail($user_id),
            'pronouns' => Pronoun::orderBy('order_by')->get(),
            'shirt_sizes' => Shirtsize::orderBy('order_by')->get(),
            'nav_links' => $this->nav_links,
            'choral' => Instrumentation::orderBy('descr')->where('instrumentationbranch_id', 1)->get(), //choral
            'instrumental' => \App\Instrumentation::orderBy('descr')->where('instrumentationbranch_id', 2)->get(), //instrumental
            ];


    }

    private function default_View()
    {
        return view('home', self::arguments());
    }

    /**
     * Initialize $this->nav_links array
     */
    private function nav_Links()
    {
        $this->nav_links = [
            'credentials' => '',
            'event' => '',
            'parent' => '',
            'profile' => '',
            'school' => '',
            'student' => '',
        ];

    }
}
