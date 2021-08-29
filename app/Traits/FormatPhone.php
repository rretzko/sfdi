<?php

namespace App\Traits;

trait FormatPhone  
{
    /**
     * Return (###) ###-#### [x##n] formatted phone number from $str
     * 
     * @param string $str
     * @return string
     */
    private function FormatPhone($str) : string
    {
        //early exit 1
        if((!strlen($str)) || (strlen($str) < 7)){return '';}
        
        //early exit 2
        if((strpos($str, '(') === 0) && 
           (strpos($str, ')') === 4) && 
           (strpos($str, ' ') === 5) &&
           (strpos($str, '-') === 9)){ //properly formatted string
            
            return $str;
        }
        
        $stripped = self::stripPhone($str);
        
        switch(strlen($stripped)){
         
            case '0': //just in case
                return '';
                
            case '7':
                return substr($stripped, 0, 3).'-'.substr($stripped, 3); //###-####
            
            case '10':
                return '('.substr($stripped, 0, 3).') '
                    .substr($stripped, 3, 3).'-'
                    .substr($stripped, 6); //(###) ###-####
                
            default:
                return '('.substr($stripped, 0, 3).') '
                    .substr($stripped, 3, 3).'-'
                    .substr($stripped, 6, 4)
                    .' x'.substr($stripped, 10); //(###) ###-#### x###
        }
        
        return $stripped;
    }
    
    //strip non-numeric characters from $phone
    private function stripPhone($phone) : string
    {
        $str = '';
        
        if(strlen($phone)){
        
            foreach(str_split($phone) AS $char){
            
                if(is_int($char) || ctype_digit($char)){

                    $str .= $char;
                }
            }
        }
        
        return $str;
    }
}
