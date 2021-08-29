<?php

namespace App\Traits;

use App\Email;
use Illuminate\Support\Facades\DB;


trait StoreEmails 
{
    /**
     * Create a blind index to be used for searching
     * 
     * NOTE: BlindIndex is case agnostic; all $str values = strtolower($str)
     * @param string $str
     * @return string
     */
    private function StoreEmails(\App\Person $person, array $emails)
    {
        $str = '';
        $types = ['primary', 'alternate'];
        
        //detach all current relationships
        $person->emails()->detach();
        
        //remove empty string
        $filtered = array_values(array_filter($emails, function($email){
            
            return strlen($email);
        }));
        
        if(count($filtered)){
            
            //remove duplicate strtolower() values
            if(array_key_exists(1, $filtered) && 
                    (strtolower($filtered[0]) === strtolower($filtered[1]))){

                array_pop($filtered);
            }

            foreach($filtered AS $key => $email){

                $blind_index = self::BlindIndex($email);

                $obj = (Email::where('blind_index', '=', $blind_index)->exists()) 
                ? Email::where('blind_index', '=', $blind_index)->first()
                : Email::create([
                    'email' => $email,
                    'blind_index' => $blind_index
                    ]);

                $person->emails()->attach($obj->id, ['type' => $types[$key]]);
            }
        }
    }
}
