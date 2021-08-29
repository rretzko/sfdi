<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pronoun extends Model
{
    public function persons()
    {
        return $this->hasMany(App\Person::class, 'id', 'user_id');
    }
    
    public function getGenderProxyAttribute() : string
    {
        $proxies = [1 => 'female', 'male'];
        
        return (array_key_exists($this->id, $proxies))
                ? $this->descr.' ('.$proxies[$this->id].')'
                : $this->descr.' (non-cis)';
    }
}
