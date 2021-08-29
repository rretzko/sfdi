<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    public function events()
    {
        return $this->hasMany(Event::class);
    }
    
    /**
     * Authorized and NON-authorized membership relationships
     * @return Collection
     */
    public function people()
    {
        return $this->belongsToMany(Person::class, 'organization_person', 'organization_id', 'user_id')
                ->withPivot('authorized')
                ->withTimestamps();
    }
    
    public function members()
    {
        return $this->belongsToMany(Person::class, 'organization_person', 'organization_id', 'user_id')
                ->wherePivot('authorized',1)
                ->withTimestamps();
    }
}
