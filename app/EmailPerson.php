<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailPerson extends Model
{
    protected $fillable = [
        'email_id', 
        'user_id',
        'type',
    ];
    
    protected $table = 'email_person';
    
    
}
