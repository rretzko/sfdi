<?php

namespace App;

use App\Instrumentation;
use App\School;
use App\Teacher;
use App\Traits\SeniorYear;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Student extends Model
{
    use SoftDeletes, SeniorYear;

    protected $fillable = [
        'birthday',
        'classof',
        'height',
        'shirt_size',
        'user_id',
    ];

    protected $primaryKey = 'user_id';

    public $incrementing = false;

    public function age()
    {
        return Carbon::parse($this->birthday)->age;
    }

    public function findaddress($type)
    {
        if($this->person->address) {

            if (! is_null($this->person->address->$type)) {

                return $this->person->address->$type;
            }
        }

        return ''; //default
    }

    /**
     * Calculate $this students contemporaneous grade from any year
     * Used to determine if $this was eligible to participate in an event
     * during that event's version's particular senior_year
     * @see App\Table_Events.php
     *
     * //ex. student senior year (2020) - $year (2019) = 11 (junior)
     *
     * @param int $year
     * @return int
     */

    public function calcGradeFromSeniorYear($year) : int
    {
        return (12 - ($this->classof - $year));
    }

    /**
     * @since 2020.06.17
     *
     * @return array of choral instrumentation by order_by
     */
    public function chorals() : array
    {
        return $this->instrumentation_By_Branch('choral');
    }

    public function eventversionsOpen()
    {
        $a = [];
/*if(auth()->id() == 1900) {
    foreach($this->teachers AS $teacher){
        echo __LINE__.'. this->teachers['.$teacher->user_id.'] = '.$teacher->person->fullName.'<br />';
    }
    echo '===================================<br />';
    foreach($this->teachers AS $teacher){
        echo __LINE__.'. TEACHER: '.$teacher->id.': '.$teacher->person->fullName.'<br />';
        foreach($teacher->eventversionsOpen AS $eventversion){
            echo $teacher->user_id.': '.$eventversion->id.'<br />';
            if($eventversion->isQualified($this)){
                echo 'this is qualified for: '.$eventversion->id.'<br />';
            }else{
                echo 'this is NOT qualified for: '.$eventversion->id.'<br />';
            }
        }
    }
    echo '===================================<br />';
    dd(__LINE__);
}else {*/
        foreach($this->teachers AS $teacher){
          //  if($teacher->user_id === 8708){echo $teacher->user_id.'<br />';}
        }

    foreach ($this->teachers as $teacher) {

        foreach ($teacher->eventversionsOpenForStudents as $eventversion) {

            if ($eventversion->isQualified($this)) { //student

                $a[] = $eventversion;
            }
        }
    }

//}
        //if($this->user_id == 7719){dd($a);}
        return array_unique($a);
    }

    public function getActiveSchoolAttribute()
    {
        foreach($this->schools AS $school){

            $grades = explode(',',$school->grades);

            if(in_array($this->gradeClassOf, $grades)){

                return $school;
            }
        }

        return new School();
    }

    /**
     * Return date value as YYYY-mm-dd
     *
     * @return date
     */
    public function getBirthDateAttribute() : string
    {
        return \Carbon\Carbon::parse($this->birthday)->format('Y-m-d');
    }

    public function getCurrentSchoolAttribute()
    {
       $grade = $this->calc_Grade();

       foreach($this->schools AS $school){

           if($school->gradesArray &&
            in_array($this->calc_Grade(), $school->gradesArray)){

               return $school;
           }
       }
        //$teacherschools = $this->teachers->first()->person->user->schools;

        //$schools = $this->person->user->schools;

        //foreach($schools AS $school){

        //    if($teacherschools->contains($school)){

        //        return $school;
        //    }
        //}

        return new School;
    }


    public function getCurrentSchoolnameAttribute()
    {
        return $this->getCurrentSchoolAttribute()->name;
    }

    /**
     * Return the last teacher created for $this
     *
     * @return Teacher[]|\LaravelIdea\Helper\App\_IH_Teacher_C|mixed
     */
    public function getCurrentTeachernameAttribute()
    {
        return $this->teachers->sortBy('created_at')->last()->person->fullName;

    }

    public function getEmailPersonalAttribute() : string
    {
        return Nonsubscriberemail::where('user_id', $this->user_id)
            ->where('emailtype_id', 5) //email_student_personal
            ->first()
            ->email ?? '';
    }

    public function getEmailSchoolAttribute() : string
    {
        return Nonsubscriberemail::where('user_id', $this->user_id)
                ->where('emailtype_id', 4) //email_student_school
                ->first()
                ->email ?? '';
    }

    public function getGradeClassOfAttribute() : int
    {
        return (self::is_Alum())
            ? $this->classof //alum
            : self::calc_Grade();  //studnt
    }

    public function getHeightFootInchesAttribute() : string
    {
        $ft = intdiv($this->height,12);
        $in = ($this->height % 12);

        return $ft."'".$in.'"';
    }

    public function getPhoneHomeAttribute() : string
    {
        return Phone::where('user_id', $this->user_id)
                ->where('phonetype_id', 5) //phone_student_home
                ->first()
                ->phone ?? '';
    }

    public function getPhoneMobileAttribute() : string
    {
        return Phone::where('user_id', $this->user_id)
                ->where('phonetype_id', 4) //phone_student_mobile
                ->first()
                ->phone ?? '';
    }

    /**
     *
     * @since 2020.08.03
     *
     * @return string description of shirt size
     */
    public function getShirtSizeDescrAttribute() : string
    {
        $ss = Shirtsize::find($this->shirt_size);

        return ($ss) ? ucwords($ss->descr) : 'None found';
    }

    /**
     * @todo develop studenttypes
     * @param $school_id
     * @return string
     */
    public function getStatusAtSchool($school_id) : string
    {   return 'active';
        /*$statustype_id = DB::table('user_student')
                ->select('statustype_id')
                ->where('school_id', '=', $school_id)
                ->where('student_user_id', '=', $this->user_id)
                ->value('statustype_id') ?? 0;

        //early exit
        if(! $statustype_id){return 'none';}

        $statustype =  \App\Statustype::find($statustype_id);

        return $statustype->descr;
        */
    }

    public function guardians()
    {
        return $this->belongsToMany(Guardian::class,'guardian_student',
            'student_user_id',
            'guardian_user_id')
            ->withPivot('guardiantype_id');
        /*
        return $this->belongsToMany(
                Parentguardian::class, 'parentguardian_student',
                'student_user_id', 'parentguardian_user_id')
                ->withPivot('parentguardiantype_id');
        */
    }

    /**
     * @since 2020.06.17
     *
     * @return array of instrumental instrumentation by order_by
     */
    public function instrumentals() : array
    {
        return self::instrumentation_By_Branch('instrumental');
    }

    public function instrumentations()
    {
        return $this->belongsToMany(
          \App\Instrumentation::class,'instrumentation_user','user_id', 'instrumentation_id')
            ->withPivot(['order_by']
        );
        /*return $this->belongsToMany(
                'App\Instrumentation', 'instrumentation_student',
                'student_user_id', 'instrumentation_id')
                ->withPivot(['order_by']);
        */
    }

    public function is_Alum() : bool
    {
        return ($this->classof < self::senior_Year()) ? true : false;
    }

    /**
     * @since 2020.06.17
     *
     * @param int $instrumentation_id
     * @return bool if instrumentation_id exists in pivot table for $this
     */
    public function has_Instrumentation(int $instrumentation_id) : bool
    {
        return DB::table('instrumentation_student')
                ->select('instrumentation_id')
                ->where([
                        ['student_user_id', $this->user_id],
                        ['instrumentation_id', $instrumentation_id],
                    ])
                ->value('instrumentation_id') ?? false;
    }

    public function is_Instrumentation($instrumentation_id, $order_by) : bool
    {
        /*
         * SELECT EXISTS
         * (
         * SELECT a.instrumentation_id
         * FROM instrumentation_student a
         * WHERE a.instrumentation_id=$instrumentation_id
         * AND a.student_user_id=$this->user_id
         * AND a.instrumentation_id=b.id
         * AND a.order_by=$order_by
         * )
         */
        return DB::table('instrumentation_student')
                ->select('instrumentation_id')
                ->where([
                        ['instrumentation_id', $instrumentation_id],
                        ['student_user_id', $this->user_id],
                        ['order_by', $order_by],
                    ])
                ->value('instrumentation_id') ?? false;
    }

    public function nonsubscriberemails()
    {
        return $this->hasMany(Nonsubscriberemail::class, 'user_id', 'user_id');
    }

    public function person()
    {
        return $this->belongsTo(Person::class, 'user_id');
    }

    public function parentguardians()
    {
        return $this->guardians();

        /*
        return $this->belongsToMany(
                Parentguardian::class, 'parentguardian_student',
                'student_user_id', 'parentguardian_user_id')
                ->withPivot('parentguardiantype_id');
        */
    }

    /**
     * School_Student is a many-to-many relationship
     */
    public function schools()
    {
        return $this->person->user->belongsToMany(School::class);

     /**   return $this->belongsToMany(
                School::class, 'school_student', 'student_user_id', 'school_id')
                ->withPivot(['statustype_id']);
      * */
    }

    /**
     * @since 2020.03.12
     *
     * define student-teacher relationship
     */
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'student_teacher', 'student_user_id', 'teacher_user_id' );
                //->withPivot('statustype_id');
    }

/** END OF PUBLIC METHODS ***************************************************/

    private function calc_Grade() : int
    {
        return (12 - ($this->classof - self::seniorYear()));
    }

    /**
     * @since 2020.06.17
     *
     * @param string $branch
     * @return array of instrumentation_id
     */
    private function instrumentation_By_Branch($branch) : array
    {
        $a = [];

        foreach($this->person->user->instrumentations AS $instrumentation){

            if(Instrumentationbranch::find($instrumentation->instrumentationbranch_id)->first()->descr === $branch){

                $a[] = $instrumentation->id;
            }
        }

        //ensure three rows are sent
        for($i = count($a); $i < 3; $i++){$a[] = 0;}

        return $a;
    }

    private function senior_Year() : int
    {
        $month = date('n');
        $year = date('Y');

        return ($month < 7) ? $year : ($year + 1);
    }
}
