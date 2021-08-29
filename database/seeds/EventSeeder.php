<?php

use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    private $seeds;
    
    public function __construct() {
        
        $this->seeds=[
            [1,'CJMEA High School Chorus','Region II Chorus',1,1,'annual',2017,'cjmeaLogo.png','CJMEA Region II MIxed and Treble Chorus','active', '9,10,11,12'],
            [9,'NJ All-State Chorus','NJ A-S Chorus',3,1,'annual',1958,'njmeaLogo_transparent.png','NJMEA logo','active','9,10,11'],
            [11,'South Jersey Junior High School Chorus','SJCDA Jr.HS',8,6,'annual',1961,'sjcdaLogo_transparent.png','SJCDA logo','active','7,8,9'],
            [12,'South Jersey Senior High School Chorus','SJCDA Sr.HS',8,1,'annual',1957,'sjcdaLogo_transparent.png','SJCDA logo','active','10,11,12'],
            [14,'AE Demo','AE Demo',3,1,'annual',1935,'','','inactive','9,10,11,12'],
            [17,'New Jersey All-State Orchestra','NJ A-S Orchestra',3,4,'annual',2017,'logo_beta.png','NJ All-Shore Chorus','inactive','9,10,11'],
            [18,'NJ All-State Jazz Ensemble','NJ A-S Jazz Ens',3,2,'annual',2017,'','','inactive','9,10,11'],
            [19,'All-Shore Chorus','All-Shore Chorus',9,1,'annual',2017,'','','active','9,10,11,12'],
            [20,'NJ All-State Honors Jazz Chorus','NJ A-S Jazz Chr',3,3,'annual',2017,'','','inactive','9,10,11'],
            [21,'NJ All-State Housing: Chorus &amp; Orchestra','NJ A-S Hsng C&amp;O',3,5,'annual',2017,'','','inactive','9,10,11'],
            [22,'NJ All-State Housing: Jazz Ensemble &amp; Honors Chorus','NJ A-S Hsng Jazz',3,5,'annual',2017,'','','inactive','9,10,11'],
            [23,'South Jersey Elementary School Choir','SJCDA Elem',8,7,'annual',2020,'sjcdaLogo_transparent.png','sjcda logo','active','4,5,6'],
            [24,'Mass All-State','MMEA AS',4,8,'annual',2020,'','','sandbox','9,10,11,12'],
        ];
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->seeds AS $seed){
            DB::table('events')->insert([
                'id' => $seed[0],
                'event_name' => $seed[1],
                'short_name' => $seed[2],
                'organization_id' => $seed[3],
                'eventinstrumentation_id' => $seed[4],
                'frequency' => $seed[5],
                'first_event' => $seed[6],
                'logo_file' => $seed[7],
                'logo_file_alt' => $seed[8],
                'status' => $seed[9],
                'grades' => $seed[10],
            ]);
        } 
    }
}
