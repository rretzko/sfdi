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
    {dd(__METHOD__);
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

    public function updatedFirst()
    {
        $this->first = $this->first.'*';
    }

    private function findDuplicates()
    {
        //early exit
        if(! (strlen($this->last) && strlen($this->first))){ return collect(); }

        return DB::table('students')
            ->join('people', 'students.user_id', '=', 'people.user_id')
            ->join('school_user', 'students.user_id', '=', 'school_user.user_id')
            ->join('schools','school_user.school_id','=', 'schools.id')
            ->where('people.last', '=', $this->last)
            ->where('people.first', 'LIKE', '%'.$this->first.'%')
            ->where('students.classof', '>=', date('Y'))
            ->orderBy('people.last')
            ->orderBy('people.first')
            ->select('people.first','people.last', 'students.classof','schools.name')
            ->get();

    }
}
