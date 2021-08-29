<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EmailFamily extends Model
{
    protected $primaryKey = 'email_id';
    
    protected $fillable = [
        'email_id',
        ];
    
    public function delete()
    { 
        DB::table('email_families')->where('email_id', $this->email_id)->delete();
    }
    
}
