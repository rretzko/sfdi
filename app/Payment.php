<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
    protected $fillable = [
        'eventversion_id',
        'paymenttype_id',
        'school_id',
        'user_id',
        'vendor_id',
        'amount',
        'updated_by',
        'created_at',
        'updated_at',
        ];
    
    public function eventversion()
    {
        return $this->hasOne(Eventversion::class);
    }
    
    public function paymenttype_Descr()
    {
        return \App\Paymenttype::find($this->paymenttype_id)->descr;
    }
    
    public function eventversion_Payments($eventversion_id=0, $school_id=0) : float
    {
        $ev_id = $eventversion_id ?: \App\Userconfig::eventversionValue();
        $s_id = $school_id ?: \App\Userconfig::schoolValue();
        
        return DB::table('payments')
                ->where('eventversion_id', '=', $ev_id)
                ->where('school_id', '=', $s_id)
                ->get()->sum('amount');
    }
    
    public function person()
    {
        return $this->hasOne(Person::class, 'user_id', 'user_id');
    }
    
    public function school()
    {
        return $this->belongsTo(School::class);
    }
    
}
