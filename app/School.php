<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class School extends Model
{
    /*public function getCountTeachers()
    {
        $cntr = 0;
        foreach(self::teachers() AS $teacher){

            $cntr++;
        }

        return $cntr;
    }
    */
    public function getGeoStatesAttribute() : string
    {
        return DB::table('geostates')
                ->where('id', $this->geostate_id)
                ->value('abbr') ?? 'ZZ';
    }

    public function getGradesArrayAttribute() : array
    {
        $grades = DB::table('gradetype_school_user')
            ->where('school_id', '=', $this->id)
            ->distinct()
            ->pluck('gradetype_id')
            ->toArray();

        //if(is_null($grades)){ self::setDefaultGrades();}

        return (count($grades))
            ? $grades
            : $this->setDefaultGrades();

    }

    /**
     * @since 2020.02.18
     *
     * @return string formatted as: School_name, city state_abbr
     */
    public function getNameCityStateAttribute() : string
    {
        return $this->name.', '.$this->city.' '.self::getGeoStatesAttribute();
    }

    /**
     * @since 2020.05.28
     *
     * abbreviate common terms
     *
     * @return string
     */
    public function getShortNameAttribute() : string
    {
        $abbrs = [
            'High School' => 'HS',
            'Regional High School' => 'RHS',
            'International' => 'Int\'l',
            'University' => 'U',
        ];

        $haystack = $this->name; //avoid repeated downstream calls
        $str = $haystack;   //initialize $str value

        foreach($abbrs AS $descr => $abbr){

            if(strstr($haystack, $descr)){

                $str = str_replace($descr, $abbr, $haystack);
            }
        }

        return $str;
    }

    public function getStudentStatus($student_id) : string
    {
        $statustype_id = DB::table('school_student')
                ->select('statustype_id')
                ->where('school_id', '=', $this->id)
                ->where('student_user_id', '=', $student_id)
                ->value('statustype_id') ?? 0;

        //early exit
        if(! $statustype_id){return 'none';}

        $statustype =  \App\Statustype::find($statustype_id);
        return $statustype->descr;
    }

    /**
     * School_Student is a many-to-many relationship
     */
    public function students()
    {
        return $this->belongsToMany('App\Student', 'school_student',
                'school_id', 'student_user_id')
                ->withPivot('statustype_id');
    }

    /**
     * School_User is a many-to-many relationship
     */
    public function teachers()
    {
        $teachers = $this->users->filter(function($user){
            return Teacher::find($user->id);
        });

        return $teachers;
        /**
        return $this->belongsToMany('App\Teacher', 'school_teacher',
                'school_id', 'teacher_user_id')
                ->withPivot('statustype_id');
         */
    }

    /**
     * @since 2020.02.18
     */
    public function scopeAlphaOrder($query)
    {
        return $query->orderBy('name', 'ASC');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /** END OF PUBLIC FUNCTIONS ***************************************************/

    private function setDefaultGrades()
    {
        $this->grades = '9,10,11,12';
        $this->save();

        return $this->grades;
    }

}
