<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Eventversionteacherconfig extends Model
{
    protected $primaryKey = ['user_id', 'school_id', 'eventversion_id'];

    protected $guarded = [];

    public $incrementing = false;

    public function eventversion()
    {
        return $this->hasOne(Eventversion::class());
    }

    protected function setKeysForSaveQuery($query) //Remove Builder typehint
    {
        return $query
            ->where('user_id', $this->getAttribute('user_id'))
            ->where('school_id', $this->getAttribute('school_id'))
            ->where('eventversion_id', $this->getAttribute('eventversion_id'));
    }
}
