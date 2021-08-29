<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VerifyUser extends Model
{
    protected $guarded = [];
    
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function getLastTokenAttribute()
    {
        return DB::table('verify_users')
                ->select('token')
                ->orderBy('created_at', 'desc')
                ->value('token');
    }
}
