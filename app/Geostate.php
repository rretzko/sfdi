<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Geostate extends Model
{
    public function addresses()
    {
        return $this->belongsToMany(Address::class);
    }

}
