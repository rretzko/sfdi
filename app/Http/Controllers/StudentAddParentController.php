<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Person;
use App\Student;
use App\Traits\BlindIndex;
use App\Traits\UserName;

use Illuminate\Http\Request;

class StudentAddParentController extends Controller
{
    use BlindIndex;
    use UserName;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //build dummy object to avoid 'invalid pay load' error
        //caused by encryption of a non-value
        //ex. [2020-04-28 19:38:18] local.ERROR: The payload is invalid. {"userId":6,"exception":"[object] (Illuminate\\Contracts\\Encryption\\DecryptException(code: 0): The payload is invalid. at C:\\xampp\\htdocs\\dev\\dStudentFolder\\vendor\\laravel\\framework\\src\\Illuminate\\Encryption\\Encrypter.php:195)
        $p = new Person;
        $p->first_name = '';
        $p->middle_name = '';
        $p->last_name = '';
        $user = Auth::user();

        return view('pages.addeditparents', [
            'student' => Student::findOrFail(Auth::user()->id),
            'person' => $p, //new Person,
            'parentguardiantypes' => \App\Parentguardiantype::orderBy('order_by')->get(),
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
    public function store(\App\Http\Requests\StudentAddParentguardianStoreRequest $request)
    {
        $mssg = [];
        $mssg[] = 'Successful update';

        //StudentAddSchoolStoreRequest handles validation and error processing
        $student = Student::find(auth()->user()->id);

        //add User
        $parent_id = self::add_User($request);

        //add/update parent
        if($parent_id){ //update Parentguardian

            //person
            $p = \App\Person::firstOrNew(['user_id' => $parent_id]);
            $p->first_name = $request->first_name;
            $p->middle_name = $request->middle_name;
            $p->last_name = $request->last_name;
            $p->save();

            //parent type
            $pg = \App\Parentguardian::firstOrNew(['user_id' => $parent_id]);
            $pg->parentguardiantype = $request->input('parentguardiantype');
            $pg->save();

            //attach parent to student
            $student->parentguardians()->attach($parent_id);

            //emails
            $this->update_Emails($p, $request->input('emails'));

            //phones
            $this->update_Phones($p, $request->input('phones'));
        }

        return redirect('parent')->with('message', implode('<br />',$mssg));
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
    public function update(\App\Http\Requests\StudentAddParentguardianStoreRequest $request)
    {
        $mssg = [];
        $mssg[] = 'Successful update';

        //add User
        $parent_id = $request->input('parent_user_id');

        //update parent
        if($parent_id){ //update Parentguardian

            //person
            $p = \App\Person::find($parent_id);
            $p->first_name = $request->first_name;
            $p->middle_name = $request->middle_name;
            $p->last_name = $request->last_name;
            $p->save();

            //parent type
            $pg = \App\Parentguardian::find($parent_id);
            $pg->parentguardiantype = $request->input('parentguardiantype');
            $pg->save();

            //attach parent to student
            //$student->parentguardians()->attach($parent_id);

            //emails
            $this->update_Emails($p, $request->input('emails'));

            //phones
            $this->update_Phones($p, $request->input('phones'));
        }

        return redirect('parent')->with('message', implode('<br />',$mssg));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = 0;

        $person = \App\Person::find($id);

        //emails
        foreach($person->emails AS $email){

            $res += \App\Email::destroy($email->id);
        }

        //phones
        foreach($person->phones AS $phone){

            $res += \App\Phone::destroy($phone->id);
        }

        //extended objects
        $res += \App\Parentguardian::destroy($id);
        $res += \App\Person::destroy($id);
        $res += \App\User::destroy($id);

        $student = Student::find(Auth::user()->id);
        $table_parents = new \App\Table_Parents($student);

        return view('pages.parents', [
            'table_parents' => $table_parents->table(),
        ]);
    }

    /**
     * Add row to user table
     */
    private function add_User($request) : int
    {
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $u = new \App\User;
        $u->password = bcrypt(strtotime('NOW')); //default
        $u->name = self::createUserName($first_name, $last_name);
        $u->save();

        return $u->id;
    }

    private function update_Emails(Person $person, array $emails)
    {
        $types = ['primary', 'alternate'];

        for($i=0; $i<count($emails); $i++){
            $email = \App\Email::firstOrNew([
                        'user_id' => $person->user_id,
                        'type' => $types[$i],
                    ]);
            $email->email = $emails[$i];
            $email->blind_index = self::BlindIndex($emails[$i]);
            $email->save();
        }
    }

    private function update_Phones(Person $person, array $phones)
    {
        $types = ['mobile', 'home', 'work'];

        for($i=0; $i<count($phones); $i++){
            $phone = \App\Phone::firstOrNew([
                        'user_id' => $person->user_id,
                        'type' => $types[$i]
                    ]);
            $phone->phone = $phones[$i];
            $phone->save();
        }
    }


}
