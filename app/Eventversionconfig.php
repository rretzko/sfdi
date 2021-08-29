<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eventversionconfig extends Model
{
    public function eventversion()
    {
        return $this->belongsTo(Eventversion::class);
    }
}
