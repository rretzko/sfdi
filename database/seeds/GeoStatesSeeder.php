<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class GeoStatesSeeder extends Seeder
{
    private $seeds;
    
    public function __construct()
    {    
        //instantiate var
        $this->seeds = [];
        
        //populate $this->seeds with student data
        self::build_States();
    
    }
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->seeds AS $seed){
            DB::table('geo_states')->insert([
                'id' => $seed['id'],
                'country_abbr' => $seed['country_abbr'],
                'descr' => $seed['descr'],
                'abbr' => $seed['abbr'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        } 
    }
    
/** END OF PUBLIC FUNCTIONS ***************************************************/

    private function build_States()
    {
        $res = fopen('resources/docs/geo_states.csv', 'rb');
        
        if(is_resource($res)){ 
            
            $first_row = true;
        
            while(($data = fgetcsv($res)) !== false){

                if($first_row){ //skip first row of labels
                    
                    $first_row = false;
                }else{
                
                    $this->seeds[] = [
                        'id' => $data[0],
                        'country_abbr' => $data[1],
                        'descr' => $data[2],
                        'abbr' => $data[3],
                    ];
                }
            }

            fclose($res);
        }
    }    
}
