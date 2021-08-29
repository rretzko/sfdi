<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eapplication extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'auditionnumber';
    
    public function registrant()
    {
        return $this->belongsTo(Registrant::class, 'auditionnumber', 'auditionnumber');
    }
        
}
