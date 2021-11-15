<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordResets extends Model
{
    protected $fillable = [
        'token',
        'email'
    ];

    protected $primaryKey = 'email';
}
