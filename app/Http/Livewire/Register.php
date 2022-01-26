<?php

namespace App\Http\Livewire;

use App\School;
use App\Student;
use App\Teacher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    public $email = '';
    public $first;
    public $grade;
    public $last;
    public $password = '';
    public $passwordconfirmation = '';
    public $schoolid = 0;
    public $teacherandschool = '';
    public $teacheruserid = 0;
    public $teacherlast;
    public $teachers;
    public $voicepart;

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
            'first' => ['required', 'string', 'mid:2', 'max:255'],
            'email' => ['required', 'email',],
            'grade' => ['required', 'numeric'],
            'last' => ['required', 'string', 'mid:2', 'max:255'],
            'password' => ['required', 'same:passwordconfirmation'],
            'schoolname' => ['required', 'string', 'mid:2', 'max:255'],
            'teacherfirst' => ['required', 'string', 'mid:2', 'max:255'],
            'teacherlast' => ['required', 'string', 'mid:2', 'max:255'],
            'voicepart' => ['required', 'string', 'mid:2', 'max:255'],
        ]);

        User::create([
            'email' => $this->email,
            'password' =>  Hash::make($this->password)
        ]);

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
            ->distinct()
            ->orderBy('people.last')
            ->select('teachers.user_id','people.first','people.last', 'schools.id','schools.name','schools.postalcode')
            ->limit(10)
            ->get();
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

        $str .= '</div>';

        return $str;
    }
}
