<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Teacher extends Model
{
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    public function acceptStudent(\App\Student $student)
    {
        $st = new Statustype;
        $st_id = $st->get_Id_From_Descr('accepted');

        $this->students()
                ->updateExistingPivot($student->user_id, ['statustype_id' => $st_id]);

        self::acceptStudent_Schools($student, $st_id);
    }

    public static function findTeacherByLastnameSchool($lastname, $school)
    {
        $userids = Person::where('last', $lastname)
            ->pluck('user_id')
            ->toArray();

        $teachers = Teacher::find( $userids);
    }

    public function getEventsAttribute()
    {
        $a = [];

        //2021-08-28
        foreach($this->organizationsAuthorized AS $org){

            foreach($org->events AS $event){

                $a[] = $event;
            }
        }

        return $a;
    }

    public function getEventversionsOpenAttribute()
    {
        $a = [];

        //all authorized events
        foreach($this->events AS $event)
        {
            $eventversions = $event->eventversionsOpenAndQualified($this);

            if(count($eventversions)){

                $a = array_merge($a, $eventversions);
            }
        }

        return $a;
    }

    public function getEventversionsOpenForStudentsAttribute()
    {
        $a = [];

        //all authorized events
        foreach($this->events AS $event)
        {
            $eventversions = $event->eventversionsOpenAndQualifiedForStudents($this);

            if(count($eventversions)){

                $a = array_merge($a, $eventversions);
            }
        }

        return $a;
    }

    /**
     * Return those organizations for which $this has been authorized
     *
     * @return collection
     */
    public function getOrganizationsAuthorizedAttribute()
    {
        return $this->organizations();

        /** @todo build authorization routine */
        //$orgs[] = $this->organizations->filter(function ($org){

         //   return $org->pivot->authorized === '1';
        //});

        //return $orgs;
    }

    /**
     * Return array of grades taught.
     * if $school is NULL, return all grades/all schools taught
     * else return grades taught in $school
     *
     * @param App\School $school
     * @return array
     */
    public function gradesTaught(School $school = NULL) : array
    {
        $a = [];

        //2021-08-28

        if($school){
            $a = DB::table('gradetype_school_user')
                ->select('gradetype_id')
                ->where('school_id','=',$school->id)
                ->where('user_id', '=', $this->user_id)
                ->get()
                ->toArray();
        }else{

            $a = DB::table('gradetype_school_user')
                ->select('gradetype_id')
                ->where('user_id', '=', $this->user_id)
                ->get()
                ->toArray();
        }

        return $a;
/*
        if($school){

            $a = $school->gradesArray;

        }else{

            foreach($this->schools AS $school){

                //$school->gradesArray will be NULL if teacher has not
                //updated their School form to indicate the grades taught
                $a = array_merge($a, ($school->gradesArray ?? []));
            }
        }

        return array_unique($a);
*/
    }

    public function organizations()
    {
        /** WORKAROUND: THERE'S A BETTER WAY TO DO THIS */
        //2021-09-01
        $organizations = collect();
        foreach(Membership::where('user_id', $this->user_id)->get() AS $membership){

            $organizations->push(Organization::find($membership->organization_id));
        }

        return $organizations;
        //2021-08-28
        //return $this->belongsToMany(Organization::class, 'organization_user', 'user_id', 'organization_id')
        //    ->withTimestamps();
            //->withPivot('authorized');
        /*
        return $this->belongsToMany(Organization::class, 'organization_person', 'user_id', 'organization_id')
                ->withTimestamps()
                ->withPivot('authorized');
        */
    }

    /**
     * Return boolean on $this teacher's decision to accept paypal payments
     * from their student's for $eventversion @ $schools
     *
     * @param \App\Eventversion $eventversion
     * @param Collection $school
     * @return bool
     */
    public function paypalApproved(\App\Eventversion $eventversion, $schools) : bool
    {
        $paypal = 0;

        //early exit
        if(! $eventversion->eventversionconfig->paypalstudent){ return false;};

        foreach($schools AS $school){

            foreach( Eventversionteacherconfig::where([
                'user_id' => $this->user_id,
                'school_id' => $school->id,
                'eventversion_id' => $eventversion->id
                ])->get() AS $evt){

                if($evt->paypalstudent == 1){

                    return true;
                }
            }
        }

        return (bool)$paypal;
    }

    public function person()
    {
        return $this->belongsTo(Person::class, 'user_id');
    }

    public function rejectStudent(\App\Student $student)
    {
        $st = new Statustype;
        $st_id = $st->get_Id_From_Descr('rejected');

        $this->students()
                ->updateExistingPivot($student->user_id, [
                    'statustype_id' => $st_id,
                    'deleted_at' => now()]);
    }

    public function schools()
    {
        return $this->belongsToMany('App\School', 'school_teacher', 'teacher_user_id', 'school_id')
                ->withPivot('statustype_id');
    }

    /**
     * @since 2020.03.12
     *
     * define student-teacher relationship
     */
    public function students()
    {
        return $this->belongsToMany('App\Student', 'student_teacher', 'teacher_user_id', 'student_user_id')
                ->withPivot('statustype_id');
    }

/** END OF PUBLIC FUNCTIONS ***************************************************/

    private function acceptStudent_Schools(\App\Student $student, $st_id)
    {
        foreach($this->schools AS $school){

            $school->students()
                ->updateExistingPivot($student->user_id, ['statustype_id' => $st_id]);
        }
    }


}
