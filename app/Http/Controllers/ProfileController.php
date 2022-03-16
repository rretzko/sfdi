<?php

namespace App\Http\Controllers;

use App\Address;
use App\Emailtype;
use App\Nonsubscriberemail;
use App\Phonetype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Email;
use App\EmailPerson;
use App\Grades_Class_Ofs;
use App\Instrumentation;
use App\InstrumentationStudent;
use App\Student;
use App\Person;
use App\Phone;
use App\Pronoun;
use App\Shirtsize;
use App\Traits\BlindIndex;
use App\Traits\FormatPhone;

class ProfileController extends Controller
{
    use BlindIndex;
    use FormatPhone;

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
        //identify and resolve any student user with a NULL address
        $address = new Address;
        $address->resolveNullAddressFields(auth()->id());

        //Used by domain owner to see student record
        //6706 = fake student: arron casey
        $faux = 6706;
        if((auth()->id() == $faux)){ //6706 = acasey734

            //reset authorized user to another in
            //3615 Ardolina, Jessica (Middletown HS  Peter Isherwood)
            //7584 Beatty, Sophia (Nicole Snodgrass)
            //7360 Beecroft, Julia (Melissa Manzano)
            //7760 Brown, Keyanna (Amy Gigliotti)
            //7530 Camburn, Lindsey (Beth Moore)
            //2514 Cass-Adams-Johnson, Kailen (Amy Melson)
            //1434 Chien, Julia (Burjis Cooper)
            // 724 Claveria, Angela (Amy Melson)
            //7438 Concordia, G (Melissa Manzano)
            // 922 Cox, Erica
            //7484 DelQuadro, Francesca (Melissa Manzano)
            //7357 Fobare', Christine (Melissa Manzano)
            //7749 Green, Lucy (Polly Murray)
            //7358 Gross, Michaela (Melissa Manzano)
            //2854 Gulati, Arya (David Taylor)
            //6691 Harris, A ()
            //7684 Hassler, Sam (Linda Wardell)
            //2708 Hitchner, Elizabeth (Paula Gorman)
            //7751 Hollingsworth, Emma (Polly Murray)
            //7469 Inzerrillo, Baily (Kathy Drachowski)
            //1970 Jones, Matthew (Kathy Drachowski)
            //7639 Lamaina, (Catherine Chambers)
            //1899 Leonard, Katie (Amy Melson)
            //7519 Mahone, Lily
            //6824 Mahone, Lilianna
            //6826 McNally, Miya (Melissa Manzano)
            //2902 Messick, Virginia (Paula Gorman)
            //7434 Nguyen, Anthony (Melissa Manzano)
            //1743 Pacanowski, Molle (Amy Melson)
            //2712 Riegel, Nicholas
            //3266 Riley, Cassidy (Chelsea Bader)
            //2603 Seals, Audrey (Marybeth McGrath -> Amy Melson)
            //7540 Sempier,
            //7578 Strang, Madison (Paula Gorman)
            //7556 Tamagno, Lily (Lauren Delfing)
            //7455 Teh,Shem (Kathy Drachowski)
            //7458 Teh,Shem (Kathy Drachowski)
            //7491 Torchia, Maria (Sergey Tchenko -> Amy Melson)
            //3337 Wesley, Megan (Amy Melson)
            //1369 Yeary, Matt (Heather Lockart)


            //7415 Ailana Potts; Mellisa Manzano

            $user = \App\User::find(6706); //$faux = 6706 = acasey734
            Auth::login($user);
        }

        return view('pages.profile', self::arguments());
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
        //STUDENT
        $student = Student::findOrFail(auth()->id());
        $student->birthday = request('birthday');
        $student->classof = request('classof');
        $student->height = request('height');
        $student->shirtsize_id = request('shirtsize_id');
        $student->save();

        //PERSON
        $student->person->first = request('first');
        $student->person->middle = request('middle');
        $student->person->last = request('last');
        $student->person->pronoun_id = request('pronoun_id');
        $student->person->save();

        //ADDRESS
        /*$address = Address::updateOrCreate(
            [
                'user_id' => auth()->id(),
            ],
            [
                'address01' => $request['address01'],
                'address02' => $request['address02'],
                'city' => $request['city'],
                'geostate_id' => $request['geostate_id'],
                'postalcode' => $request['postalcode'],
            ]
        );*/

        Address::updateOrCreate(
            [
                  'user_id' => auth()->id(),
            ],
            [
                'address01' => $request['address01'],
                'address02' => $request['address02'],
                'city' => $request['city'],
                'geostate_id' => $request['geostate_id'],
                'postalcode' => $request['postalcode'],
            ]
        );
        /*
        $address = is_null($student->person->address)
                ? self::setAddress($student) //create a dummy address
                : $student->person->address;

        $address->address01 = $request['address01'];
        $address->address02 = $request['address02'];
        $address->city = $request['city'];
        $address->geostate_id = $request['geostate_id'];
        $address->postalcode = $request['postalcode'];
        $address->save();
        */

        /** EMAILS ARE NOT MANDATORY VALUES FOR STUDENTS */
        $this->emails($request);

        //PERSON: PHONES
        $this->phones($request);

        //STUDENT: INSTRUMENTATIONS: CHORALS
        $this->instrumentations($request);

        return redirect('profile')->with('message', 'Successful update!');
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
                'nav_links' => $this->nav_links,
                'choral' => Instrumentation::orderBy('descr')->where('instrumentationbranch_id', 1)->get(), //choral
                'instrumental' => \App\Instrumentation::orderBy('descr')->where('instrumentationbranch_id', 2)->get(), //instrumental
                'student_chorals' => $student->chorals(),
                'student_instrumentals' => $student->instrumentals(),
                ];

    }

    private function emails($request)
    {
        //$types = ['primary', 'alternate'];

        //detach all current relationships
        //$student->person->emails()->detach();

        $emails = [];
        if($request['email_student_personal'] && strlen($request['email_student_personal'])){
            $emails['email_student_personal'] = $request['email_student_personal'];

        }else{ //delete currently existing record
            $personal = Nonsubscriberemail::where('user_id', auth()->id())
                ->where('emailtype_id', Emailtype::where('descr', 'email_student_personal')->first()->id)
                ->first();

            if($personal){ $personal->destroy();}
        }

        if($request['email_student_school'] && strlen($request['email_student_school'])){
            $emails['email_student_school'] = $request['email_student_school'];
        }else{ //delete currently existing record
            $school = Nonsubscriberemail::where('user_id', auth()->id())
                ->where('emailtype_id', Emailtype::where('descr', 'email_student_school')->first()->id)
                ->first();

            if($school){ $school->destroy();}
        }

        //remove empty string
        //$filtered = array_values(array_filter($request, function($email){

        //    return strlen($email);
       // }));

        //remove duplicate strtolower() values
        if((count($emails) === 2) &&
                (strtolower($emails['email_student_school']) === strtolower($emails['email_student_personal']))){

            array_pop($emails);
        }

        //update and attach remaining emails
        foreach($emails AS $key => $email) {

            Nonsubscriberemail::updateOrCreate(
                [
                'user_id' => auth()->id(),
                'emailtype_id' => Emailtype::where('descr', $key)->first()->id,
                ],
                [
                'email' => $email,
                ]
            );
        }

        //remove rows

        /**
         * EMAILS ARE NOT MANDATORY BUT EACH STUDENT MUST HAVE A
         * PRIMARY AND ALTERNATE EMAIL ROW IN THE DATABASE
         */
        //$blank = Email::where('blind_index', '=', self::BlindIndex(''))->first();
        //for($i=count($filtered); $i<2;$i++){

         //   $student->person->emails()->attach($blank->id, ['type' => $types[$i]]);
        //}
    }

    private function instrumentations($request)
    {
        //$cntr = 0;
        auth()->user()->instrumentations()->detach();

        if((! isset($request['chorals'])) || ($request['chorals'][0] < 1)){
            auth()->user()->instrumentations()->sync(1); //force selection of Alto
        }else{
            auth()->user()->instrumentations()->sync($request['chorals']);
        }


        /*
        foreach($request['chorals'] AS $instrumentation_id){

            if($instrumentation_id &&
                (!$student->has_Instrumentation($instrumentation_id))){

                $choral = InstrumentationStudent::firstOrNew([
                    'student_user_id' => $student->user_id,
                    'order_by' => $cntr
                ]);
                $choral->instrumentation_id = $instrumentation_id;
                $choral->order_by = $cntr;
                $choral->save();

                $cntr++;
            }
        }

        //STUDENT: INSTRUMENTATIONS: INSTRUMENTALS
        foreach($request['instrumentals'] AS $instrumentation_id){

            if($instrumentation_id &&
                (!$student->has_Instrumentation($instrumentation_id))){

                $instrumental = InstrumentationStudent::firstOrNew([
                    'student_user_id' => $student->user_id,
                    'order_by' => $cntr
                ]);
                $instrumental->instrumentation_id = $instrumentation_id;
                $instrumental->order_by = $cntr;
                $instrumental->save();

                $cntr++;
            }
        }
        */
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
            'profile' => 'active',
            'school' => '',
            'student' => '',
        ];
    }

    private function phones($request)
    {
        $types = [
            'phone_student_home' => Phonetype::where('descr', 'phone_student_home')->first()->id,
            'phone_student_mobile' => Phonetype::where('descr', 'phone_student_mobile')->first()->id,
        ];
        $phones = [];

        //provide universal phone formats
        foreach($types AS $type => $phonetypeid){
            if($request[$type] && strlen($request[$type])){

                $phones[$type] = $this->FormatPhone($request[$type]);
            }else{
                $phone = Phone::where('user_id', auth()->id())
                    ->where('phonetype_id', $phonetypeid)
                    ->first() ?? null;

                //remove blanked phone records
                if($phone){ $phone->destroy(); }
            }
        }

        foreach($phones AS $type => $phone){

            Phone::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'phonetype_id' => $types[$type],
                ],
                [
                    'phone' => $phone,
                ]
            );
        }
/*
        $mphone = self::FormatPhone(request('phones')[0]);

        $mobile = Phone::firstOrNew([
            'blind_index' => self::BlindIndex($mphone),
        ]);
        $mobile->phone = $mphone;
        $mobile->save();

        //PERSON: PHONES: HOME
        $hphone = self::FormatPhone(request('phones')[1]);

        $home = Phone::firstOrNew([
            'blind_index' => self::BlindIndex($hphone),
        ]);
        $home->phone = $hphone;
        $home->save();

        //PHONE PIVOT TABLES
        $student->person->phones()->sync([
            $mobile->id => ['type' => 'mobile'],
            $home->id => ['type' => 'home']
        ]);
*/
    }

    private function setAddress(\App\Student $student) : \App\Address
    {
        $address = new \App\Address;
        $address->user_id = $student->user_id;
        $address->geostate_id = 37; //default = NJ
        $address->save();

        return $address;
    }

    private function verifyEmail(Email $email, Student $student, $type)
    {
        if(!($email->verified === '1')){

            \App\VerifyUser::create([
                'user_id' => $student->user_id,
                'token' => sha1(time()),
            ]);

            event(new \App\Events\EmailAddedEvent(
                   $student->person, $type));
        }//else do nothing
    }
}
