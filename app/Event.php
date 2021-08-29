<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function ensembletypes()
    {
        return $this->belongsToMany(\App\Ensembletype::class);
    }

    public function eventensembles()
    {
        return Eventensemble::where('event_id', $this->id)->get();
    }

    public function eventversions()
    {
        return $this->hasMany(Eventversion::class);
    }

    /**
     * Return versions which are open and for which $obj is qualified
     *
     * @param Object $obj may be Teacher or Student
     * @return array
     */
    public function eventversionsOpenAndQualified($obj) //teacher
    {
        $a = [];
        $ev = 0;

        foreach($this->eventversions AS $eventversion){
            if(($eventversion->eventversiontype_id === Eventversiontype::where('descr', 'open')->first()->id) &&
                    $eventversion->isQualified($obj)){

                $a[] = $eventversion;
            }
        }

        return $a;
        /*
        foreach($this->eventversions AS $eventversion){

            if(($eventversion->statustypeDescr === 'open') &&
                ($eventversion->isQualified($obj))){

                $a[] = $eventversion;
            }
        }

        return $a;
        */
    }

    /**
     * @since 2020.08.07
     *
     * @return boolean if event is choral
     */
    public function isChoral() : bool
    {
        //2021-08-28
        foreach($this->eventensembles() AS $eventensemble){

            $eet = Eventensembletype::find($eventensemble->eventensembletype_id);

            if(Instrumentationbranch::find($eet->instrumentationbranch_id)->descr === 'choral'){

                return true;
            }
        }

        return false;

        //return (strstr($et->branch, 'choral') || strstr($et->branch, 'choir'));

        //$ei = Eventinstrumentation::find($this->eventinstrumentation_id);

        //return (strstr($ei->descr, 'choral') || strstr($ei->descr, 'choir'));
    }

    /**
     * @since 2020.08.07
     *
     * @return boolean if event is instrumental
     */
    public function isInstrumental() : bool
    {
        return (! self::isChoral());



        //$ei = Eventinstrumentation::find($this->eventinstrumentation_id);

        //return (! self::isChoral());
    }
}
