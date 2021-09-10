<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eapplication extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'registrant_id';

    public function registrant()
    {
        return $this->belongsTo(Registrant::class);
    }

}
