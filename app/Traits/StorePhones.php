<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use App\Phone;
use App\Traits\BlindIndex;
use App\Traits\FormatPhone;

trait StorePhones 
{
    use BlindIndex;
    use FormatPhone;
    
    /**
     * Create a blind index to be used for searching
     * 
     * NOTE: BlindIndex is case agnostic; all $str values = strtolower($str)
     * @param string $str
     * @return string
     */
    private function StorePhones(\App\Person $person, array $phones)
    {
        //PERSON: PHONES: MOBILE
        $mphone = (array_key_exists(0, $phones))
                ? self::FormatPhone($phones[0])
                : 0;  

        $mobile = Phone::firstOrNew([
            'blind_index' => self::BlindIndex($mphone),
                ]);
            $mobile->phone = $mphone;           
            $mobile->save();
        
        //PERSON: PHONES: HOME
        $hphone = (array_key_exists(1, $phones)) 
                ? self::FormatPhone($phones[1])
                : '';  

        $home = Phone::firstOrNew([
            'blind_index' => self::BlindIndex($hphone),
                ]);
            $home->phone = $hphone;           
            $home->save();
   
        //PERSON: PHONES: WORK (only @ non-student entities)
        if(array_key_exists(2, $phones)){
        
            $wphone = self::FormatPhone($phones[2]);  

            $work = Phone::firstOrNew([
                'blind_index' => self::BlindIndex($wphone),
                    ]);
                $work->phone = $wphone;           
                $work->save();
        }
   
        //PHONE PIVOT TABLES
        if(array_key_exists(2, $phones)){
            $person->phones()->sync([
                $mobile->id => ['type' => 'mobile'],
                $home->id => ['type' => 'home'],
                $work->id => ['type' => 'work'],
             ]);
        }else{
            $person->phones()->sync([
                $mobile->id => ['type' => 'mobile'],
                $home->id => ['type' => 'home']
            ]);
        }
    }
    
    
}
