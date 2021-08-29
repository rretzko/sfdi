<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eventensemble extends Model
{
    public function eventversions()
    {
        return $this->belongsToMany(Eventversion::class, 'eventensemble_eventversion');
    }

    public function instrumentations()
    {
        $eventensembletype = Eventensembletype::find($this->eventensembletype_id);

        return $eventensembletype->instrumentations;
    }
}
