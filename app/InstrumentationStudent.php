<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstrumentationStudent extends Model
{
    protected $fillable = [
        'instrumentation_id',
        'order_by',
        'student_user_id'
    ];
    
    protected $table = 'instrumentation_student';
}
