<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberType extends Model
{
    /**
     * Get the users who belong to a member_type
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
