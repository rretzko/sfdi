<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Paymenttype extends Model
{
   
    
    static public function getId($type) : int
    {
        return DB::table('paymenttypes')
                ->select('id')
                ->where('descr', '=', $type)
                ->value('id') ?? 0;
    }
}
