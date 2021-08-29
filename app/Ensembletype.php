<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ensembletype extends Model
{
    public function events()
    {
        return $this->belongsToMany(\App\Event::class);
    }
    
    public function instrumentations()
    {
        return $this->belongsToMany(\App\Instrumentation::class)
                ->orderBy('order_by');
    }
   
}
