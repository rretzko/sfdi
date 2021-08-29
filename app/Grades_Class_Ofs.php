<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grades_Class_Ofs extends Model
{
    private $a;
    private $sr_year;
    
    public function __construct()
    {
        self::init();
    }
    
    public function structure() : array
    {
        return $this->a;
    }
    
/******************************************************************************/
    private function build_Array()
    {
        $this->a = (self::build_Array_Grades() + self::build_Array_Class_Ofs());   
    }
    
    private function build_Array_Grades() : array
    {
        $a = [];
        $min = 1;
        $max = 12;
        
        for($i = $min; $i <= $max; $i++){
            
            $a[($this->sr_year + ($max - $i))] = $i;
        }
        
        return $a;
    }
    
    private function build_Array_Class_Ofs() : array
    {
        $a = [];
        
        $min = 1980;
        $max = self::calc_Senior_Year();
        
        for($i = $max; $i>$min; $i--){
            
            $a[$i] = $i;
        }
             
        return $a;
    }
    
    private function calc_Senior_Year() : int
    {
        return (date('n') < 7) ? date('Y') : (date('Y') + 1);
    }
    
    private function init()
    {
        $this->a = [];
        
        $this->sr_year = self::calc_Senior_Year();
        
        self::build_Array();
    }
}
