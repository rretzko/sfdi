<?php

namespace App;

use App\Filecontenttype;
use App\Fileupload;
use App\Utility\Fileviewport;
use App\Video;
use App\Videotype;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Registrant extends Model
{
    //protected $primaryKey = 'auditionnumber';

    public $incrementing = false;

    protected $guarded = [];


    public function auditiondetail()
    {
        return $this->hasOne(Auditiondetail::class, 'auditionnumber', 'auditionnumber');
    }

    public function canPaypal() : bool
    {
        return false;
        /** @todo build teacher approval functionality for students to use PayPal */
        $can = false;

        foreach($this->student->teachers AS $teacher){

            if($teacher->paypalApproved($this->eventversion,
                    $this->student->schools)){

                $can = true;
            }
        }

        return $can;
    }

    public function chorals() : array
    {
        //2021-08-28
        /** WORKAROUND $this->instrumentations not working */
        return DB::table('instrumentation_registrant')
            ->select('instrumentation_id')
            ->where('registrant_id', $this->id)
            ->get()
            ->toArray();
        /*
        $parts = explode(',', $this->auditiondetail->voicings);

        return [$parts[0], $parts[1], $parts[2],];
        */
    }

    public function due() : float
    {
        return $this->registration_Fee()- $this->paid();
    }

    public function eapplication()
    {
        return $this->hasOne(Eapplication::class, 'auditionnumber', 'auditionnumber');
    }

    public function paid() : float
    {
        return DB::table('payments')
                ->where('user_id', '=', $this->user_id)
                ->where('school_id', '=', $this->school_id)
                ->where('eventversion_id', '=', $this->eventversion->id)
                ->get()->sum('amount');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function eventversion()
    {
        return $this->belongsTo(Eventversion::class);
    }

    public function fileuploadapproved($filecontenttype) : bool
    {
        return (bool)Fileupload::where('registrant_id', $this->id)
            ->where('filecontenttype_id', $filecontenttype->id)
            ->first()
            ->approved;
    }

    /**
     * Return the embed code for the requested videotype
     *
     * NOTE: self::hasVideoType($videotype) should be run BEFORE this function.
     *
     * @param \App\Models\Videotype $videotype
     * @return string
     */
    public function fileviewport(Filecontenttype $filecontenttype)
    {
        $viewport = new Fileviewport($this,$filecontenttype);

        return $viewport->viewport();
    }

    public function getPrimaryAuditionVoicingAbbrAttribute() : string
    {
        if(! is_null($this->auditiondetail->voicings)){

            $voicings = explode(',', $this->auditiondetail->voicings);

            $choral = \App\Instrumentation::find($voicings[0]) ?? null;
            $instrumental = \App\Instrumentation::find($voicings[3]) ?? null;

            $primary = ($choral) ?: $instrumental;

            return $primary->abbr;
        }

        return $this->auditionnumber;
    }

    public function getPrimaryAuditionVoicingDescriptionAttribute() : string
    {
        if(! is_null($this->auditiondetail->voicings)){

            $voicings = explode(',', $this->auditiondetail->voicings);

            $choral = \App\Instrumentation::find($voicings[0]) ?? null;
            $instrumental = \App\Instrumentation::find($voicings[3]) ?? null;

            $primary = ($choral) ?: $instrumental;

            return $primary->ucwordsDescription;
        }

        return $this->auditionnumber;
    }

    public function getPrimaryAuditionVoicingIdAttribute() : string
    {
        //2021-08-28
        //WORKAROUND as belongsToMany(Instrumentation) isn't working
        return DB::table('instrumentation_registrant')
           ->where('registrant_id', $this->id)
            ->value('instrumentation_id');
        /*
        if(! is_null($this->auditiondetail->voicings)){

            $voicings = explode(',', $this->auditiondetail->voicings);

            return $voicings[0];
        }

        return $this->auditionnumber; //default unfindable value
        */
    }

    public function getRegistranttypeDescrAttribute() : string
    {
        return Registranttype::find($this->registranttype_id)->descr;
    }

    public function getTeacherStringAttribute() : string
    {
        $teachers = [];

        foreach($this->student->teachers AS $teacher){

            $teachers[] = $teacher->person->fullName;
        }

        return implode(', ', $teachers);
    }

    public function getStatusDescrAttribute()
    {
        $statustype = Statustype::find($this->auditiondetail->statustype_id);

        return $statustype->descr;
    }

    public function hasApplication() : bool
    {
        return (bool)Application::where('registrant_id', $this->id)->get();
    }

    public function hasFileUploaded(Filecontenttype $filecontenttype): bool
    {
        return (bool)Fileupload::where('registrant_id', $this->id)
            ->where('filecontenttype_id', $filecontenttype->id)
            ->first();
    }

    public function hasVideotype(Videotype $videotype) : bool
    {
        return DB::table('videos')
                ->select('id')
                ->where('auditionnumber', $this->auditionnumber)
                ->where('videotype_id', $videotype->id)
                ->value('id') ?? false;
    }

    public function instrumentals() : array
    {
        $parts = explode(',', $this->auditiondetail->voicings);

        return [$parts[3], $parts[4], $parts[5],];
    }

    public function instrumentations()
    {
        return $this->belongsToMany(Instrumentation::class, 'instrumentation_registrant');
    }

    public function registration_Fee() : float
    {
        return $this->eventversion->eventversionconfig->registrationfee;
    }

    public function resetRegistrantType($descr)
    {
        $currenttype = Registranttype::find($this->registranttype_id);
        $newtype = Registranttype::where('descr', $descr)->first();

        switch($descr){
            case 'applied': //do not update record if applied, prohibited or registered
                if(
                    ($currenttype->id === Registranttype::ELIGIBLE) ||
                    ($currenttype->id === Registranttype::HIDDEN) ||
                    ($currenttype->id === Registranttype::NOAPP)
                ){
                    $this->registranttype_id = $newtype->id;
                    $this->save();
                }
                break;

            default:
                $this->registranttype_id = $newtype->id;
                $this->save();
        }
    }

    public function school() : \App\School
    {
        return ($this->school_id)
            ? School::find($this->school_id)
            : self::invited_School();
    }

    public function self_Registration(\App\Eventversion $eventversion) : Registrant
    {
        $st = new Statustype;
        $ad = new Auditiondetail;

        //create registrant record
        $this->auditionnumber = Auditionnumber::create($eventversion);
        $this->user_id = auth()->user()->id;
        $this->eventversion_id = $eventversion->id;
        $this->statustype_id = $st->get_Id_From_Descr('pending');
        $this->school_id = self::school()->id;

        $this->save();

        $ad->self_Registration($this);

        return $this;
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'user_id', 'user_id');
    }

    /**
     * Return the embed code for the requested videotype
     *
     * NOTE: self::hasVideoType($videotype) should be run BEFORE this function.
     *
     * @param Videotype $videotype
     * @return string
     */
    public function video(Videotype $videotype)
    {
        $vs = new Videoserver;
        $server_id = DB::table('videos')
                ->select('server_id')
                ->where('auditionnumber', '=', $this->auditionnumber)
                ->where('videotype_id', '=', $videotype->id)
                ->value('server_id');

        $assets = $vs->assets($server_id);

        $assets['fembed_code'] = self::resetHeightWidth($assets['embed_code']);
        $assets['approved'] = self::getApprovedStatus($assets, $videotype);

        return $assets;
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'auditionnumber', 'auditionnumber');
    }

/** END OF PUBLIC FUNCTIONS ***************************************************/

    private function getApprovedStatus(array $assets, Videotype $videotype)
    {
        return Video::where('server_id', $assets['id'])
                //->where('videotype_id', $videotype->id)
                ->value('approved') ?? false;
    }

    /**
     * Return the first school found where:
     * - The teacher is in the collection of $this registrants teachers, AND
     * - The teacher's school is in $this->eventversion's list of members
     *
     * @to-do create additional organization or event relationship to schools
     * as well as teachers
     *
     * @return \App\School
     */
    private function invited_School() : \App\School
    {
        $members = $this->eventversion->event->organization->members;

        foreach($this->student->teachers AS $teacher){

            if($members->contains($teacher->person)){

                $school = $teacher->schools->first();

                //ensure record includes identified school_id
                $this->school_id = $school->id;
                $this->save();

                return $school;
            }
        }

        return new School;
    }

    private function matchedTeachersEventversions()
    {
        $teachers = $this->teachers;

        return $teachers;
    }

    /**
     * REMOVE height AND width SETTING FROM embeded code
     *
     * $parts = array:7 [▼
     * 0 => "<iframe"
     * 1 => "class='sproutvideo-player'"
     * 2 => "src='https://videos.sproutvideo.com/embed/709cd9bb1711e3c9f9/32ea18c38bf1f651'"
     * 3 => "width='630'"
     * 4 => "height='354'"
     * 5 => "frameborder='0'"
     * 6 => "allowfullscreen></iframe>"
     * ]
     *
     * @param string $str
     * @return string
     */
    private function resetHeightWidth($str) : string
    {
         $parts = explode(' ', $str);
         $resets = [];

         foreach($parts AS $part){

             $resets[] = (strstr($part, 'height') || strstr($part, 'width'))
                     ? ((strstr($part, 'width')) ? "width='100%'" : '')
                     : $part;
         }

         return implode(' ', $resets);
    }

}
