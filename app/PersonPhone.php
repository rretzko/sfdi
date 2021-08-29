<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonPhone extends Model
{
    protected $primaryKey = ['phone_id', 'user_id'];
    
    protected $fillable = [
        'phone_id', 
        'type',
        'user_id',
    ];
    
    protected $table = 'person_phone';
}
