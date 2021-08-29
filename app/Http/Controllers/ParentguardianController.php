<?php

namespace App\Http\Controllers;

use App\Email;
use App\Emailtype;
use App\Guardian;
use App\Nonsubscriberemail;
use App\Person;
use App\Phone;
use App\Phonetype;
use App\Traits\StoreEmails;
use App\Traits\StorePhones;
use App\Traits\UserName;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ParentguardianController extends Controller
{
    use StoreEmails;
    use StorePhones;
    use UserName;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, \App\Parentguardian $parentguardian)
    {
        $user = Auth::user();

        return view('pages.addeditparents',
                [
                    'parentguardian' => $parentguardian,
                    'person' => $parentguardian->person,
                    'parentguardiantypes' =>
                        \App\Parentguardiantype::orderBy('order_by')->get(),
                   'user' => $user,
                    'guardian' => $parentguardian,
                ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.addeditparents', self::arguments(0));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $search = new \App\SearchForPerson($request->all()); //returns collection of Person objects

        $guardian = (is_null($search->collection()) || (! $search->collection()->count()))
            ? $this->addParentguardian($request)
            : $this->attachViaDB(Guardian::find($search->collection()->first()->user_id), $request);

        /** @todo Add Guardian notification email */
        //event(new \App\Events\ParentAttachedEvent($parent, \App\Student::find(auth()->id())));

        return view('pages.parents', self::arguments($guardian->user_id));
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
    public function edit(Request $request, \App\Guardian $parentguardian)
    {//dd(self::arguments($parentguardian->user_id));
        return view('pages.addeditparents',
                self::arguments($parentguardian->user_id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\StudentAddParentguardianStoreRequest
            $request,\App\Guardian $parentguardian)
    {
        //update parentguardian type for user student
        DB::table('guardian_student')
                ->where('guardian_user_id', '=', $parentguardian->user_id)
                ->where('student_user_id', '=', auth()->id())
                ->update([
                    'guardiantype_id' => $request['parentguardiantype']
                ]);

        $person = $parentguardian->person;
        $person->first = $request->first;
        $person->middle = $request->middle;
        $person->last = $request->last;
        $person->save();

        self::update_Emails($request, $person);

        self::update_Phones($request, $person);

        $student = \App\Student::find(Auth::user()->id);
        $table_parents = new \App\Table_Parents($student);

        return view('pages.parents', [
            'table_parents' => $table_parents->table(),
        ]);
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

/** END OF PUBLIC FUNCTIONS ***************************************************/

    private function addParentguardian($request)
    {
        $user = \App\User::create([
                    'username' => self::CreateUserName($request['first'], $request['last']),
                    'password' => Hash::make('Password1!'),
                    ]);

        \App\Person::create([
           'user_id' => $user->id,
            'first' => $request['first'],
            'middle' => $request['middle'],
            'last' => $request['last'],
        ]);

        //create parentguardian record
        \App\Guardian::create([
            'user_id' => $user->id,
            //'guardiantype_id' => $request['parentguardiantype'],
        ]);

        $guardian = Guardian::find($user->id);

        $this->emails($guardian, $request);

        $this->phones($guardian, $request);

        return $this->attachViaDB($guardian, $request);
    }
/*
    private function attachParentguardian(\App\Person $person, $parentguardiantype, $request)
    {
        //parent is using the same email as the student
        if($person->user_id == auth()->id()){
            return $this->addParentguardian($request);
        }

        //ATTACH PARENT
        $student = \App\Student::find(auth()->id());

        /**
         * @todo test for parentguardian existance before attaching
         *
         * [2020-11-22 23:20:55] production.ERROR: SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry '7056-7056-1' for key 'PRIMARY' (SQL: insert into `parentguardian_student` (`parentguardian_user_id`, `parentguardiantype_id`, `student_user_id`) values (7056, 1, 7056)) {"userId":7056,"exception":"[object] (Illuminate\\Database\\QueryException(code: 23000): SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry '7056-7056-1' for key 'PRIMARY' (SQL: insert into `parentguardian_student` (`parentguardian_user_id`, `parentguardiantype_id`, `student_user_id`) values (7056, 1, 7056)) at /home/ds66z4exc9ht/public_html/studentfolder.info/vendor/laravel/framework/src/Illuminate/Database/Connection.php:671)[stacktrace]
         * #0 /home/ds66z4exc9ht/public_html/studentfolder.info/vendor/laravel/framework/src/Illuminate/Database/Connection.php(631): Illuminate\\Database\\Connection->runQueryCallback('insert into `pa...', Array, Object(Closure))
         * #1 /home/ds66z4exc9ht/public_html/studentfolder.info/vendor/laravel/framework/src/Illuminate/Database/Connection.php(465): Illuminate\\Database\\Connection->run('insert into `pa...', Array, Object(Closure))
         * #2 /home/ds66z4exc9ht/public_html/studentfolder.info/vendor/laravel/framework/src/Illuminate/Database/Connection.php(417): Illuminate\\Database\\Connection->statement('insert into `pa...', Array)
         * #3 /home/ds66z4exc9ht/public_html/studentfolder.info/vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php(2785): Illuminate\\Database\\Connection->insert('insert into `pa...', Array)
         * #4 /home/ds66z4exc9ht/public_html/studentfolder.info/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Relations/Concerns/InteractsWithPivotTable.php(254): Illuminate\\Database\\Query\\Builder->insert(Array)
         * #5 /home/ds66z4exc9ht/public_html/studentfolder.info/app/Http/Controllers/ParentguardianController.php(178): Illuminate\\Database\\Eloquent\\Relations\\BelongsToMany->attach('7056', Array)
         * #6 /home/ds66z4exc9ht/public_html/studentfolder.info/app/Http/Controllers/ParentguardianController.php(63): App\\Http\\Controllers\\ParentguardianController->attachParentguardian(Object(App\\Person), '1')
         * ...


        $student->parentguardians()->attach($person->user_id, ['parentguardiantype_id' => $parentguardiantype]);

        return $person;
    }
*/

/**
     * Build arguments list for view
     *
     * @return array
     */
    private function arguments($parentguardian_id) : array
    {
        $arg = [];
        $user = Auth::user();
        $user_id = $user->id;

        $person = \App\Person::findOrNew($parentguardian_id);
        $guardian = \App\Guardian::findOrNew($parentguardian_id);

        $student = \App\Student::find(Auth::user()->id);
        $table_parents = new \App\Table_Parents($student);

        return [
                'student' => $student,
                'table_parents' => $table_parents->table(),
                'parentguardian' => \App\Guardian::find($parentguardian_id),
                'parentguardiantypes' => \App\Guardiantype::get(),
                'person' => $person,
                'guardian' => $guardian,
                ];
    }

    /**
     * WORKAROUND for nonfunctioning:
     * $guardian->students()->attach(auth()->id(), ['guardiantype_id' => $request['parentguardiantype']])
     * @param Guardian $guardian
     */
    private function attachViaDB(Guardian $guardian, $request)
    {
         DB::table('guardian_student')
            ->updateOrInsert([
                'guardian_user_id' => $guardian->user_id,
                'student_user_id' => auth()->id(),
                'guardiantype_id' => $request['parentguardiantype'],
            ]);

         return $guardian;
    }

    private function emails(Guardian $guardian, Request $request)
    {
        $types = ['email_guardian_alternate', 'email_guardian_primary'];

        foreach($types AS $type) {

            if (strlen($request[$type])) {

                Nonsubscriberemail::updateOrCreate(
                    [
                        'user_id' => $guardian->user_id,
                        'emailtype_id' => Emailtype::where('descr', $type)->first()->id,
                    ],
                    [
                        'email' => $request[$type],
                    ]
                );
            }
        }
    }

    private function phones(Guardian $guardian, Request $request)
    {
        $types = ['phone_guardian_home', 'phone_guardian_mobile', 'phone_guardian_work'];

        foreach($types AS $type) {

            if (strlen($request[$type])) {

                Phone::updateOrCreate(
                    [
                        'user_id' => $guardian->user_id,
                        'phonetype_id' => Phonetype::where('descr', $type)->first()->id,
                    ],
                    [
                        'phone' => $request[$type],
                    ]
                );
            }
        }
    }

    private function update_Emails(Request $request, Person $person)
    {
        //2021-08-28
        $types = ['email_guardian_alternate', 'email_guardian_primary'];

        foreach($types AS $type) {
            Nonsubscriberemail::updateOrCreate(
                [
                    'user_id' => $person->user_id,
                    'emailtype_id' => Emailtype::where('descr', $type)->first()->id,
                ],
                [
                    'email' => $request[$type],
                ]
            );
        }
        /*
            $emailprimary = new Email;
            $emailprimary->clearAllLinks($person); //do this once
            $emailprimary->add(($emails[0] ?? ''), $person, 'primary');

            $emailalternate = new Email;
            $emailalternate->add(($emails[1] ?? ''), $person, 'alternate');
        */
    }

    private function update_Phones(Request $request, Person $person)
    {
        //2021-08-28
        $types = ['phone_guardian_home', 'phone_guardian_mobile', 'phone_guardian_work'];

        foreach($types AS $type) {
            Phone::updateOrCreate(
                [
                    'user_id' => $person->user_id,
                    'phonetype_id' => Phonetype::where('descr', $type)->first()->id,
                ],
                [
                    'phone' => $request[$type],
                ]
            );
        }
        /*
            $mobile = new Phone;
            $mobile->clearAllLinks($person); //do this once
            $mobile->add(($phones[0] ?? ''), $person, 'mobile');

            $home = new Phone;
            $home->add(($phones[1] ?? ''), $person, 'home');

            $work = new Phone;
            $work->add(($phones[2] ?? ''), $person, 'work');
        */
    }
}
