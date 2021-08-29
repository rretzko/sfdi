<?php

namespace App\Traits;

trait SeniorYear 
{
    /**
     * Calculate the current senior year based on Date('m')
     * 
     * @param string $str
     * @return string
     */
    private function SeniorYear() : string
    {
       return (date('m') < 7) ? date('Y') : (date('Y') + 1);
    }
    
    
}
