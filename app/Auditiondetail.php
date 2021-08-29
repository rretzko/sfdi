<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Auditiondetail extends Model
{
    protected $primaryKey = 'auditionnumber';
    
    public $incrementing = false;
    
    protected $guarded = [];
    
    /**
     * @since 2020.08.10
     * 
     * increment $this status for the number of applications downloaded
     */
    public function applied()
    {
        self::add_Application();
        
        $st = new Statustype;
        $st_id = $st->get_Id_From_Descr('applied');
        $this->update(['statustype_id' => $st_id]);
        
        /**
         * @todo statustype_id should be in one place?
         */
        $r = Registrant::find($this->auditionnumber);
        $r->statustype_id = $st_id;
        $r->save();
    }
    
    public function getAuditionVoicingDescrStringAttribute() : string
    {
        $descrs = [];
        $voicings = explode(',', $this->voicings);
        
        foreach($voicings AS $instrumentation_id){
            
            if($instrumentation_id){
                
                $i = Instrumentation::find($instrumentation_id);

                $descrs[] = $i->ucwordsDescription;
            }
        }
        
        return implode(',', $descrs);
    }
    
    /**
     * If no voicing has been selected, array_sum will equal 0,
     * else array_sum > 0
     * 
     * @return bool
     */
    public function getHasVoicingAttribute() : bool
    {
        $parts = explode(',', $this->voicings);
        
        return array_sum($parts);
    }
    
    public function registrant()
    {
        return $this->belongsTo(Registrant::class, 'auditionnumber', 'auditionnumber');
    }
    
    public function self_Registration(\App\Registrant $registrant)
    {
        $instrumentation = new Instrumentation;
        $chorals = $instrumentation->chorals();
    
        $student = Student::find($registrant->user_id);
        $student_chorals = $student->chorals();
        
        $this->auditionnumber = $registrant->auditionnumber;
        $this->user_id = $registrant->user_id;
        $this->eventversion_id = $registrant->eventversion_id;
        $this->programname = $student->person->fullName;
        //must be six csvs
        $this->voicings = ($student_chorals && ($student_chorals[0] > 0)) 
                ? $student_chorals[0].',0,0,0,0,0'  
                : $chorals->first()->id.',0,0,0,0,0';
        $this->statustype_id = $registrant->statustype_id;
        
        $this->save();
    }
    
    public function statustype_Descr() : string
    {
        $st = Statustype::find($this->statustype_id);
        return $st->descr;
    }
    
/** END OF PUBLIC FUNCTIONS ***************************************************/

    private function add_Application()
    {
        DB::table('applications')
            ->insert([
                'auditionnumber' => $this->auditionnumber,
                'created_at' => Carbon::now()]);
    }
}
