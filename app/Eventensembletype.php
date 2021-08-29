<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eventensembletype extends Model
{
    public function instrumentations()
    {
        return $this->belongsToMany(Instrumentation::class, 'eventensembletype_instrumentation');
    }
}
