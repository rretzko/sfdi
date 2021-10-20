<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Eventversion extends Model
{
    private $registrants_array;
    private $st;

    public function __construct()
    {
        $this->registrants_array = [];
        $this->st = new Statustype;
    }

    /**
     * Registrant status runs through the same filters at each step of the
     * process:
     * 1. $student population is qualified (qualify_Students())
     * 2. qualified students are tested for applied or registered status= applied
     * 3. applied students are tested for registered status = registered
     *
     * @param type $students
     * @return type
     */
    public function appliedRegistrants($students) //collection
    {
        //qualify $student = $this->registrants_array['qualified']
        $qualifieds = self::qualifiedRegistrants($students);

        $st_applied = $this->st->get_Id_From_Descr('applied');
        $st_registered = $this->st->get_Id_From_Descr('registered');

        foreach($qualifieds AS $qualified){

            if(
                    ((int)$qualified->statustype_id === $st_applied)
                    ||
                    ((int)$qualified->statustype_id === $st_registered)
                ){

                self::addRegistrant($qualified, 'applied');

            }
        }

        return $this->registrants_array['applied'] ?? [];
    }

    public function studentRegistrationDate($descr)
    {
            return DB::table('eventversiondates')
                ->select('dt')
                ->where('eventversion_id', '=', $this->id)
                ->where('datetype_id', \App\Datetype::where('descr', $descr)->first()->id)
                ->value('dt');
    }

    public function dates(string $descr) : string
    {
        $datetype = Datetype::where('descr', $descr)->first();

        $dt = $this->eventversiondates
                ->where('datetype_id',$datetype->id)
                ->first()
                ->dt ?? null;

        //ex: Mon, Jul 19,2021 08:30
        return ($dt)
            ? \Illuminate\Support\Carbon::parse($dt)
                ->format('D, M d,Y H:i',$dt)
            : 'not found';
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function eventversionconfig()
    {
        return $this->hasOne(Eventversionconfig::class);
    }

    public function eventversiondates()
    {
        return $this->hasMany(Eventversiondate::class);
    }

    public function eventversionvideos()
    {
        return $this->hasOne(Eventversionvideo::class);
    }

    public function eventversionteacherconfigs()
    {
        return $this->hasMany(Eventversionteacherconfig::class);
    }

    public function filecontenttypes()
    {
        return $this->belongsToMany(Filecontenttype::class, 'eventversion_filecontenttype')
            ->withPivot('title')
            ->withPivot('order_by')
            ->orderBy('eventversion_filecontenttype.order_by')
            ->withTimestamps();;
    }

    public function getAuditionManagerNameAttribute()
    {
        $managers = [
            63 => 'Cheryl Britzman',
            64 => 'Cristin Introcaso'
        ];

        return $managers[$this->id] ?? 'None found';
    }

    public function getAuditionManagerAddressBlockAttribute()
    {
        $addresses = [
            63 => 'Cheryl\'s house',
            64 => 'Collingswood High School<br />424 Collings Avenue<br />Collingswood, NJ 08108'
        ];

        return $addresses[$this->id] ?? 'None found';
    }

    public function getCollectVideosAttribute() : bool
    {
        $dt_open_id = \App\Datetype::where('descr', 'videos_membership_open')->first()->id;
        $dt_open = $this->eventversiondates->where('datetype_id', $dt_open_id)->first()->dt;

        $dt_close_id = \App\Datetype::where('descr', 'videos_membership_close')->first()->id;
        $dt_close = $this->eventversiondates->where('datetype_id', $dt_close_id)->first()->dt;

        $now = Carbon::now();

        return (($dt_open < $now) && ($dt_close > $now));
    }

    /**
     * @since 2020.08.11
     *
     * @return boolean true if $this requires videos
     */
    public function getHasVideosAttribute() : bool
    {
        return DB::table('eventversionvideos')
                ->where('eventversion_id', '=', $this->id)
                ->value('eventversion_id') ?? false;
    }

    /**
     * @todo DateType model needs to be renamed to Datetype and then
     * app needs retesting to find breakage
     *
     * @todo fix All-Shore workaround
     *
     * @return bool
     */
    public function getIsSelfRegistrationOpenAttribute() : bool
    {
        //2021-08-28
        $dateopen = $this->eventversiondates->where('datetype_id', Datetype::where('descr','student_open')
            ->first()->id)
            ->first()
            ->dt;
        $dateclose = $this->eventversiondates->where('datetype_id', Datetype::where('descr','student_close')
            ->first()->id)
            ->first()
            ->dt;

        return (($dateopen <= Carbon::now()) && ($dateclose > Carbon::now()));

        /** work-around for All-Shore */
        /*
        if($this->id == 61) {
            $now = strtotime('NOW');
            $closed = strtotime('2020-12-03 23:59:59');
            return $now < $closed;
        }

        /** @var work-around for SJCDA
        $sjcdas = [62, 63, 64];
        if(in_array($this->id, $sjcdas)){

            $open_dt = $this->eventversiondates->where('datetype_id', \App\Datetype::where('descr', 'student_open')->first()->id)->first()->dt;
            $close_dt = $this->eventversiondates->where('datetype_id', \App\Datetype::where('descr', 'student_close')->first()->id)->first()->dt;
            $now = Carbon::now();
            //$closed = strtotime('2021-01-29 23:59:59');

            return (($now > $open_dt) && ($now < $close_dt));
        }

        $datetype_id = DB::table('datetypes')
            ->select('id')
            ->where('descr', '=', 'applications_close')
            ->value('id');
        $close_date = $this->eventversionDates()->where('datetype_id', $datetype_id)->first();

        return false;
        */
    }

    /**
     * videos_student_open = 19
     * videos_student_close = 20
     * @return bool
     */
    public function getIsVideoRegistrationOpenAttribute()
    {
        //early exit
        if(! $this->eventversionconfig->virtualaudition){ return false;}

        //2021-08-28
        $dateopen = $this->eventversiondates->where('datetype_id', Datetype::where('descr','videos_student_open')
            ->first()->id)
            ->first()
            ->dt;
        $dateclose = $this->eventversiondates->where('datetype_id', Datetype::where('descr','videos_student_close')
            ->first()->id)
            ->first()
            ->dt;

        return (($dateopen <= Carbon::now()) && ($dateclose > Carbon::now()));
/*
        return (($dateopen <= Carbon::now()) && ($dateclose > Carbon::now()));
        $open = strtotime($this->eventversiondates->where('datetype_id',\App\Datetype::where('descr','videos_student_open')->first()->id)->first()->dt);
        $close = strtotime($this->eventversiondates->where('datetype_id',\App\Datetype::where('descr','videos_student_close')->first()->id)->first()->dt);
        $now = strtotime('NOW');

        return ($now > $open) && ($now < $close);
*/
    }

    public function getStatustypeDescrAttribute() : string
    {
        $st = Statustype::find($this->statustype_id);

        return $st->descr ?? '';
    }

    /**
     * Return array structure for db string property stored in evgrades
     */
    public function getVersionGradesAttribute()
    {
        return self::grades();
    }

    /**
     * @since 2020.08.11
     *
     * @return array structure for $this videos
     */
    public function getVideosAttribute()
    {
        //early exit
        if(! $this->hasVideos){return [];}

        $videos = [];
        $evv = Eventversionvideo::firstWhere('eventversion_id', $this->id);

        $ids = explode(',', $evv->videotype_ids);

        foreach($ids AS $id){
            $obj = \App\Videotype::find($id);

            $videos[] = [
                'sort' => $obj->descr,
                'obj' => $obj,
                    ];
        }

        sort($videos);

        return array_column($videos, 'obj');
    }

    /**
     *
     * @return Collection of Instrumentation objects
     */
    public function getVoicingsAttribute()
    {
        $collection = collect([]);

        $event = $this->event;

        foreach($event->ensembletypes AS $ensembletype){

            $merged = $collection->merge($ensembletype->instrumentations);
        }

       return $merged;
    }

    /**
     * Return true: If $obj is either Student or Teacher
     * AND $obj meets the qualification criteria
     * Else false;
     *
     * @param Object $obj Student or Teacher
     * @return bool
     */
    public function isQualified($obj) : bool
    {
        //quick exit
        if((! is_a($obj, 'App\Student')) &&
                (! is_a($obj, 'App\Teacher'))){
            return false;
        }

        //qualify based on Student or Teacher class
        return (is_a($obj, 'App\Student'))
                ? $this->isQualified_Student($obj)
                : $this->isQualified_Teacher($obj);
    }

    /**
     * Registrant status runs through the same filters at each step of the
     * process:
     * 1. $student population is qualified (qualify_Students())
     * 2. qualified students are tested for applied or registered status= applied
     * 3. applied students are tested for registered status = registered
     *
     * @param type $students
     * @return type
     */
    public function qualifiedRegistrants($students) //collection
    {
        self::qualify_Students($students);

        return $this->registrants_array['qualified'] ?? [];
    }

    /**
     * Registrant status runs through the same filters at each step of the
     * process:
     * 1. $student population is qualified (qualify_Students())
     * 2. qualified students are tested for applied or registered status= applied
     * 3. applied students are tested for registered status = registered
     *
     * @param type $students
     * @return type
     */
    public function prohibitedRegistrants($students) //collection
    {
        self::qualify_Students($students);

        return $this->registrants_array['prohibited'];
    }

    /**
     * Registrant status runs through the same filters at each step of the
     * process:
     * 1. $student population is qualified (qualify_Students())
     * 2. qualified students are tested for applied or registered status= applied
     * 3. applied students are tested for registered status = registered
     *
     * @todo code registered criteria
     *
     * return empty array as a starting point
     *
     * @param Collection $students
     * @return array
     */
    public function registeredRegistrants($students) //collection
    {
        //qualify $student and then filter for statustype_id===applied or better
        $applieds = self::appliedRegistrants($students);

        //statustype_id
        $st_registered = $this->st->get_Id_From_Descr('registered');

        foreach($applieds AS $applied){

            if((int)$applied->statustype_id === $st_registered){

                self::addRegistrant($applied, 'registered');

            }
        }

        return $this->registrants_array['registered'] ?? [];
    }

    public function registrantPayments(School $school)
    {
        $a = [];
        $sql = 'SELECT a.id FROM payments a, registrants b '
                . 'WHERE a.user_id=b.user_id '
                . 'AND a.school_id='.$school->id.' '
                . 'AND a.eventversion_id='.$this->id.' '
                . 'AND a.eventversion_id=b.eventversion_id '
                . 'ORDER by a.updated_at DESC';

        foreach(DB::select($sql) AS $std){

            $a[] = Payment::find($std->id);
        }

        return $a;
    }

    /**
     * Registrant status runs through the same filters at each step of the
     * process:
     * 1. $student population is qualified (qualify_Students())
     * 2. qualified students are tested for applied or registered status= applied
     * 3. applied students are tested for registered status = registered
     *
     * Rookies are registrants who were not accepted to the previous event
     *
     * return empty array as a starting point
     *
     * @param Collection $registrant
     * @return array
     */
    public function rookieRegistrants($registrants) //collection
    {
        /** @todo determine if eventversion predecessor needs to be a table */
        $predecessors = [50,51,52];

        foreach($registrants AS $registrant){

            $veteran = DB::table('accepteds')
                    ->where('user_id', '=', $registrant->user_id)
                    ->whereIn('eventversion_id', $predecessors)
                    ->value('auditionnumber') ?? 0;

            if(! $veteran){

                self::addRegistrant($registrant, 'rookie');
            }
        }

        return $this->registrants_array['rookie'] ?? [];
    }

    /**
     * Return all versions where status===open
     * AND where auth()->user() is a member of the sponsoring organization
     *
     * @param type $query
     */
    public function scopeOpenMembersOnly($query)
    {
       return $this::all()->where(
               'statustype_id', '=',
               DB::table('statustypes')
               ->select('id')
               ->where('descr', '=', 'open')
               ->value('id')
               );
    }

    public function versionDates()
    {
        return $this->hasMany(EventversionDate::class);
    }

/** END OF PUBLIC METHODS *****************************************************/

    /**
     * Construct $this->registrants_array
     */
    private function addRegistrant(Registrant $r, $key)
    {
        $this->registrants_array[$key][] = $r;
    }

    private function auditiondetails($students)
    {
        return Auditiondetail::where('eventversion_id', $this->id)->get();
    }

    public function eventensembles()
    {
        return $this->belongsToMany(Eventensemble::class,'eventensemble_eventversion');
    }



    /**
     * Return array of values from evgrades where
     * - version_id === $this->id, OR
     * - version_id === 0 (i.e. default value)
     */
    private function grades() : array
    {
        //2021-08-28
        return explode(',',$this->eventversionconfig->grades);

        /*
        $vgrades = DB::table('evgrades')
                ->select('grades')
                ->where('event_id', '=', $this->event_id)
                ->where('eventversion_id', '=', $this->id)
                ->value('grades');

        if(is_null($vgrades)){

            $vgrades = DB::table('evgrades')
                ->select('grades')
                ->where('event_id', '=', $this->event_id)
                ->where('eventversion_id', '=', 0)
                ->value('grades');
        }

        return explode(',', $vgrades);
        */
    }

    private function studentIsPending(Student $student, Teacher $teacher) : bool
    {
        $st_id = Studenttype::where('descr', 'pending')->first()->id;
        //$st_id = $st->get_Id_From_Descr('pending');
//if($student->user_id == 6822){dd($student->teachers()->where('teacher_user_id', 404)->first()->pivot->statustype_id);}//343,404
        $student_status = $student->teachers()
                ->where('teacher_user_id', $teacher->user_id)
                ->first()
                ->pivot->statustype_id ?? 0;
//if(($student->user_id == 6822) && (! $student_status)){dd($teacher->user_id);}
/** @todo fix the dual-teacher problem */
if(($teacher->user_id == 362) ||
    ($teacher->user_id == 265) ||
    ($teacher->user_id == 152) || //Gina Kehl
    ($teacher->user_id == 404) || //Sarah Mickle
    ($teacher->user_id = 369) //Rob Joubert
){return false;}
        return ((int)$student_status === $st_id);
    }

    private function isQualified_Student(Student $student) : bool
    {//if((auth()->id() == 2626) && ($this->id == 69)){dd(self::isQualified_Student_Grades($student));}
        //dd($this->isQualified_Student_Not_Prohibited($student));
        //dd($this->isQualified_Student_Is_Approved($student));
        //dd($this->isQualified_Student_Grades($student));
//dd($this->studentRegistrationDate('student_open'));
        //early exit: student registration is not open
        if($this->studentRegistrationDate('student_open') > Carbon::now()){ return false;}
/** WORKAROUND */
//if($this->id == 69){ return false;}

        return ($this->isQualified_Student_Not_Prohibited($student) &&
                $this->isQualified_Student_Is_Approved($student) &&
                $this->isQualified_Student_Grades($student));
    }

    private function isQualified_Student_Grades(Student $student) : bool
    {
        //version grades accepted
        $vgrades = self::grades();

        if(in_array($student->gradeClassOf, $vgrades)){

                return true;
        }

        return false;
    }

    /**
     * i.e. student is NOT in pending status
     * @param Student $student
     * @return bool
     */
    private function isQualified_Student_Is_Approved(Student $student) : bool
    {
        $org = $this->event->organization;
//if(auth()->id() == 6822){dd($student->teachers);}
        foreach($student->teachers AS $teacher){

            if($teacher->organizations()->contains($org) &&
                ($this->studentIsPending($student, $teacher))){

                return false;
            }
        }

        return true;
    }

    private function isQualified_Student_Not_Prohibited(Student $student) : bool
    {
        $registrant = Registrant::where('user_id', $student->user_id)
                ->where('eventversion_id', $this->id)
                ->first();

        if($registrant) {

            $st_id = Registranttype::where('descr', 'prohibited')->first()->id;

            if ($registrant->registranttype_id != $st_id) {

                return true;

            } else {

                self::addRegistrant($registrant, 'prohibited');
            }
        }

        return false;
    }

    private function isQualified_Teacher(Teacher $teacher) : bool
    {
        if(self::isQualified_Teacher_Grades($teacher) &&
            self::isQualified_Teacher_Subjects($teacher)){

            return true;
        }

        return false;
    }

    private function isQualified_Teacher_Grades(Teacher $teacher) : bool
    {
        //version grades accepted
        $vgrades = self::grades();

        foreach($teacher->gradesTaught() AS $grade){

            if(in_array($grade->gradetype_id, $vgrades)){

                return true;
            }
        }

        return false;
    }

    /**
     * @todo Placeholder for future development when subject checkboxes are added
     * to the user's profile page
     *
     * @param \App\Teacher $teacher
     * @return bool
     */
    private function isQualified_Teacher_Subjects(Teacher $teacher) : bool
    {
        return true;
    }

    /**
     * Ensure that a auditiondetail row exists.
     * If none, create row using student default information
     *
     * @param App\Registrant $registrant
     * @return App\Auditiondetail
     */
    private function make_Auditiondetail(Registrant $registrant) : Auditiondetail
    {
        return Auditiondetail::firstOrCreate(
            ['auditionnumber' => $registrant->auditionnumber],
            [
                'user_id' => $registrant->user_id,
                'eventversion_id' => $this->id,
                'programname' => $registrant->student->person->fullName,
                'voicings' => implode(',', array_merge($registrant->student->chorals(), $registrant->student->instrumentals())),
                'created_at' => Carbon::now(),
            ],
        );

    }

    /**
     * Ensure that a registrant row exists.
     * If none, create row using default status of 'qualified'
     *
     * @param Student $student
     * @return App\Registrant
     */
    private function make_Registrant(Student $student) : Registrant
    {
        return Registrant::firstOrCreate(
            ['user_id' => $student->user_id, 'eventversion_id' => $this->id],
            [
                'auditionnumber' => \App\Auditionnumber::create($this),
                'statustype_id' => DB::table('statustypes')
                    ->select('id')
                    ->where('descr', '=', 'qualified')
                    ->value('id'),
                'created_at' => Carbon::now()
            ],
        );
    }

    /**
     * @since 2020.08.07
     *
     * ensure that qualified $students have registration and audition details
     *
     * @param array $students
     * @return void
     */
    private function qualify_Students($students) : void
    {
        foreach($students AS $student){

            if(self::isQualified($student)){

                $registrant = self::make_Registrant($student);

                self::make_Auditiondetail($registrant);

                self::addRegistrant($registrant, 'qualified');
            }
        }

    }
}
