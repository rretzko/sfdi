<?php

namespace App\Http\Livewire;

use App\Emailtype;
use App\Events\MakeRegistrationIdsEvent;
use App\Instrumentation;
use App\Nonsubscriberemail;
use App\Person;
use App\Registrant;
use App\School;
use App\Student;
use App\Studenttype;
use App\Teacher;
use App\Traits\UserName;
use App\Traits\SeniorYear;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    use UserName, SeniorYear;

    public $duplicates='';
    public $email = '';
    public $first;
    public $grade=12;
    public $last;
    public $password = '';
    public $passwordconfirmation = '';
    public $schoolid = 0;
    public $teacherandschool = '';
    public $teacheruserid = 0;
    public $teacherlast;
    public $teachers;
    public $voicepart;
    //emergency contacts
    public $parentcell='';
    public $parentemail='';
    public $parentfirst='';
    public $parentlast='';

    public function mount()
    {
        $this->teachers = collect();
    }
    public function render()
    {
        return view('livewire.register',
        [
            'duplicates' => $this->findDuplicates(),
        ]);
    }

    public function store()
    {
        $clean = $this->validate([
            'first' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'email',],
            'grade' => ['required', 'numeric'],
            'last' => ['required', 'string', 'min:2', 'max:255'],
            'teacherandschool' => ['required', 'string'],
            'password' => ['required', 'min:8', 'max:255', 'same:passwordconfirmation'],
            'voicepart' => ['required', 'string', 'min:2', 'max:255'],
            //emergency contact info
            'parentfirst' => ['required', 'string', 'min:2', 'max:255'],
            'parentlast' => ['required', 'string', 'min:2', 'max:255'],
            'parentemail' => ['required', 'email', 'min:8', 'max:255'],
            'parentcell' => ['required', 'string', 'min:10', 'max:24'],
        ]);

        if($this->teacheruserid && $this->schoolid) {

            $user = User::create([
                'username' => $this->createUserName($clean['first'], $clean['last']),
                'password' => Hash::make($this->password)
            ]);

            $user->schools()->sync($this->schoolid);

            $instrumentationid = $this->translateInstrumentation($clean['voicepart']);
            $user->instrumentations()->sync($instrumentationid);

            $user->fresh();

            Person::create([
                'user_id' => $user->id,
                'first' => $clean['first'],
                'last' => $clean['last'],
                'pronoun_id' => 1, //default
                'honorific_id' => 1, //default
            ]);

            Nonsubscriberemail::create([
               'user_id' => $user->id,
               'emailtype_id' => Emailtype::where('descr','email_student_personal')->first()->id,
               'email' => $clean['email'],
            ]);

            $student = Student::create([
                'user_id' => $user->id,
                'classof' => ($this->SeniorYear() + (12 - $clean['grade'])),
                'height' => 36, //default
                'birthday' => Carbon::now(),
                'shirsize_id' => 1, //default
            ]);

            $student->fresh();

            $student->teachers()->sync([$this->teacheruserid => ['studenttype_id' => Studenttype::where('descr', 'student_added')->first()->id]]);

            /** temporary workaround to finding eligibile open eventversions */
            if(in_array($clean['grade'], [9,10,11])) {

                $registrant = new Registrant;
                $registrant->id = $registrant->createId(71);
                $registrant->user_id = $user->id;
                $registrant->eventversion_id = 71; //default
                $registrant->school_id = $this->schoolid;
                $registrant->teacher_user_id = $this->teacheruserid;
                $registrant->programname = $this->first . ' ' . $this->last;
                $registrant->registranttype_id = 14; //default
                $registrant->save();

                $registrant->instrumentations()->sync($instrumentationid);
            }

            //Emergency Contacts
            $guardianuser = User::create([
                'username' => $this->createUserName($this->first,$this->last),
                'password' => bcrypt('Password1!'),
            ]);

            $guardianuser->fresh();

            //add guardian-person
            \App\Person::create(
                [
                    'user_id' => $guardianuser->id,
                    'first' => $this->parentfirst,
                    'last' => $this->parentlast,
                    'pronoun_id' => 1, //she/her/etc.
                    'honorific_id' => 1, //Ms.
                ]
            );

            //add guardian-email
            \App\Nonsubscriberemail::create(
                [
                    'user_id' => $guardianuser->id,
                    'emailtype_id' => 7, //email_guardian_primary
                    'email' => $this->parentemail,
                ]
            );

            //add guardian-cell
            \App\Phone::create(
                [
                    'user_id' => $guardianuser->id,
                    'phonetype_id' => 6, //phone_guardian_mobile
                    'phone' => $this->parentcell,
                ]
            );

            //Guardian
            \App\Guardian::create(['user_id' => $guardianuser->id]);
            $guardian = \App\Guardian::find($guardianuser->id);

            $guardiansync[$guardian->user_id] = ['guardiantype_id' => 1];

            $student->guardians()->sync($guardiansync);
        }

        Auth::login($user);

        //force creation of registration ids for currently open event registrations
        event(new MakeRegistrationIdsEvent($student));

        return redirect('profile');
    }

    public function teacherAndSchool($user_id, $school_id)
    {
        $this->teacheruserid = $user_id;
        $this->schoolid = $school_id;

        $teacher = Teacher::find($user_id);
        $school = School::find($school_id);

        $this->teacherandschool = $teacher->person->fullnameAlpha.': '.$school->name.' ('.$school->postalcode.')';
    }

    public function updatedTeacherlast()
    {
        $this->teachers = DB::table('teachers')
            ->join('people','teachers.user_id','=','people.user_id')
            ->join('school_user', 'teachers.user_id', '=', 'school_user.user_id')
            ->join('schools','school_user.school_id','=','schools.id')
            ->where('people.last','LIKE','%'.$this->teacherlast.'%')
            ->where('schools.name','NOT LIKE', '%Studio%')
            ->distinct()
            ->orderBy('people.last')
            ->select('teachers.user_id','people.first','people.last', 'schools.id','schools.name','schools.postalcode')
            ->limit(20)
            ->get();
    }

    public function updatedVoicepart()
    {
        $this->duplicates = $this->findDuplicates();
    }

    private function findDuplicates()
    {
        //early exit
        if(! (strlen($this->first) && strlen($this->last))){ return '';}

        $duplicates = DB::table('students')
            ->join('people', 'students.user_id', '=', 'people.user_id')
            ->join('school_user', 'students.user_id', '=', 'school_user.user_id')
            ->join('schools','school_user.school_id','=', 'schools.id')
            ->where('people.last', '=', $this->last)
            ->where('people.first', 'LIKE', '%'.$this->first.'%')
            ->where('students.classof', '>=', date('Y'))
            ->orderBy('people.last')
            ->orderBy('people.first')
            ->select('people.user_id','people.first','people.last', 'students.classof','schools.name')
            ->get();

        //early post-search exit
        if(! $duplicates->count()) { return '';}

        $str = '<style>
            #duplicates{
            background-color: rgba(0,0,0,.1);
            font-size: 1rem;
            display: flex;
            flex-direction: column;
            margin-bottom: 1rem;
            border: 1px solid black;
            padding: 0.25rem;
            }
            </style>';
        $str .= '<div id="duplicates">';
        $str .= '<header style="border-bottom:1px solid lightgrey;">'
                    . 'The following similar student names have been found.<br />'
                    . 'Please click the name if it belongs to you.'
                    . '</header>';

        foreach($duplicates AS $duplicate){

            //{{ $duplicate ? $duplicate->first.' '.$duplicate->last.' ('.(12 - ($duplicate->classof - date('Y'))).') @ '.$duplicate->name : ''}}
            $str .= '<a href="current/student/'.$duplicate->user_id.'">';
                $str .= $duplicate->first.' '.$duplicate->last.': grade '.(12 - ($duplicate->classof - date('Y'))).' @ '.$duplicate->name;
            $str .= '</a>';
        }

        $str .= 'Please note: <b>Duplicate records will be deleted.</b>';

        $str .= '</div>';

        return $str;
    }

    private function translateInstrumentation($descr)
    {
        $romans1 = str_replace(1,'I', strtolower($descr));
        $romans2 = str_replace(2,'II', $romans1);
        $romans3 = str_replace('ii', 'II', $romans2);
        $romans4 = str_replace('i', 'I', $romans3);

        return (Instrumentation::where('descr', 'LIKE', $romans4)->exists())
            ? Instrumentation::where('descr', 'LIKE', $romans4)->first()->id
            : Instrumentation::where('descr', 'Soprano I')->first()->id; //default
    }
}
