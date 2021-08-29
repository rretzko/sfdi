<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Statustype extends Model
{
    public function get_Id_From_Descr($descr) : int
    {
        return DB::table('statustypes')
                ->select('id')
                ->where('descr', '=', $descr)
                ->value('id') ?? 0;
    }
    
    public function missive()
    {
        return $this->belongsTo(Missive::class);
    }
}
