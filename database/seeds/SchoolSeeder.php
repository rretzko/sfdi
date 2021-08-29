<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SchoolSeeder extends Seeder
{
    private $seeds;
    
    public function __construct()
    {    
        //instantiate var
        $this->seeds = [];
        
        //populate $this->seeds with student data
        self::build_Schools();
    
    }
    
    /* Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->seeds AS $seed){
            DB::table('schools')->insert([
                'id' => $seed['id'],
                'name' => ucwords(strtolower($seed['name'])),
                'address_01' => ucwords(strtolower($seed['address_01'])),
                'address_02' => ucwords(strtolower($seed['address_02'])),
                'city' => ucwords(strtolower($seed['city'])),
                'geo_state_id' => $seed['geo_states_id'],
                'postal_code' => $seed['postal_code'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        } 
    }
    
/** END OF PUBLIC FUNCTIONS ***************************************************/

    private function build_Schools()
    {
        $res = fopen('resources/docs/schools.csv', 'rb');
        
        if(is_resource($res)){ 
            
            $first_row = true;
        
            while(($data = fgetcsv($res)) !== false){

                if($first_row){ //skip first row of labels
                    
                    $first_row = false;
                }else{
                
                    $this->seeds[] = [
                        'id' => $data[0],
                        'name' => $data[1],
                        'address_01' => self::format_Address($data[2]),
                        'address_02' => self::format_Address($data[3]),
                        'city' => self::format_Address($data[4]),
                        'geo_states_id' => $data[5],
                        'postal_code' => self::calc_Postal_Code($data[6]),
                    ];
                }
            }

            fclose($res);
        }
    }
        
    private function calc_Postal_Code($str) : string
    {
        if(strlen($str) === 5){ //expected length ex.07924
            
            return $str;
            
        }elseif(strlen($str) === 4){ //truncated value 7924
            
            return '0'.$str;
            
        }elseif(strlen($str) > 5){ //expanded zip 07924-1234
            
            return substr($str, 0,5);
            
        }else{ //unexpected value
            
            return '00000';
        }
    }
    
    /**
     * Ensure that address fields (address_01, address_02, city) have standard
     * format of capitalized words
     * 
     * @param type $str
     * @return string
     */
    private function format_Address($str) : string 
    {
        $lc = strtolower($str);
        
        return ucwords($lc);
    }
}
