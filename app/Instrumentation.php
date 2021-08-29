<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instrumentation extends Model
{
    public function getUcwordsDescriptionAttribute() : string
    {
        return ucwords($this->descr);
    }

    public function students()
    {
        return $this->belongsToMany('App\Student', 'instrumentation_student',
            'instrumentation_id', 'student_user_id');
    }

    public function chorals()
    {
        return Instrumentation::orderBy('descr')
                ->where('branch', 'choral')
                ->get();
    }

    public function instrumentals()
    {
        return Instrumentation::orderBy('descr')
                ->where('branch', 'instrumental')
                ->get();
    }

    public function registrants()
    {
        return $this->belongsToMany(Registrant::class, 'instrumentation_registrant');
    }
}
