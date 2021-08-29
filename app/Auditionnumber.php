<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Auditionnumber extends Model
{
    private function __construct(){}
    
    static public function create(Eventversion $eventversion)
    {
        $min = $eventversion->id.'0000';
        $max = $eventversion->id.'9999';
   
        $test = random_int($min, $max);
        
        //continue testing $test until $test is NOT found, i.e. is unique
        while(DB::table('registrants')
                ->select('user_id')
                ->where('auditionnumber', '=', $test)
                ->value('user_id')){
                
            $test = random_int($min, $max);
        }
         
        return $test;
    }
}
