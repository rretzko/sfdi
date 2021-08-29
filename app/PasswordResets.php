<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordResets extends Model
{
    protected $fillable = [
        'token', 
        'user_id'
    ];
    
    protected $primaryKey = 'user_id';
}
