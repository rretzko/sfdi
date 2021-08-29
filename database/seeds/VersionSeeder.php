<?php

use Illuminate\Database\Seeder;

class VersionSeeder extends Seeder
{
    private $seed;
    
    public function __construct() {
        
        $this->seeds=[
            [1,12,'59th Annual Senior High Chorus','SJCDA Sr. HS Chorus',2018],
            [2,11,'55th Annual Junior High Chorus','SJCDA Jr. HS Chorus',2017],
            [3,9,'2017 All-State Chorus Auditions','2017 NJ All-State Chorus',2017],
            [4,1,'2017 Region II Chorus Auditions','2017 RII Chorus',2017],
            [5,14,'81th Annual Event Demo','81st Demo Chorus',2017],
            [6,16,'2017 All-State Treble Chorus Auditions','2017 NJ All-State Treble',2017],
            [7,12,'60th Annual Senior High Chorus','60th Sr HS Chorus',2018],
            [8,18,'2017 All-State Jazz Ensemble Auditions','2017 NJ All-State Jazz',2017],
            [9,11,'56th Annual Junior High Chorus','56th Jr. HS Chorus',2018],
            [10,20,'2017 All-State Honors Jazz Chorus Auditions','2017 NJ All-State Jazz Chorus',2017],
            [22,19,'2017 New Jersey All-Shore Chorus','2017 NJ All-Shore Chorus',2018],
            [23,9,'2018 All-State Chorus Auditions','2018 NJ All-State Chorus',2018],
            [24,1,'2018 Region II Chorus','2018 RII Chorus',2018],
            [25,19,'2018 New Jersey All-Shore Chorus','2018 NJ All-Shore Chorus',2018],
            [26,21,'2017 All-State Housing Chorus &amp; Orchestra','2017 Housing Chorus/Orch',2017],
            [27,22,'2017 All-State Housing Jazz','2017 Housing Jazz',2017],
            [28,1,'2017 Region II Treble Chorus Auditions','2017 Region II Treble Chorus',2017],
            [29,1,'2018 Region II Treble Chorus Auditions','2018 Region II Treble Chorus',2018],
            [30,9,'2016 All-State Chorus Auditions','2016 NJ All-State Chorus',2016],
            [31,9,'2008 All-State Chorus Auditions','2008 NJ All-State Chorus',2008],
            [32,9,'2009 All-State Chorus Auditions','2009 NJ All-State Chorus',2009],
            [33,9,'2010 All-State Chorus Auditions','2010 NJ All-State Chorus',2010],
            [34,9,'2011 All-State Chorus Auditions','2011 NJ All-State Chorus',2011],
            [35,9,'2012 All-State Chorus Auditions','2012 NJ All-State Chorus',2012],
            [36,9,'2013 All-State Chorus Auditions','2013 NJ All-State Chorus',2013],
            [37,9,'2014 All-State Chorus Auditions','2014 NJ All-State Chorus',2014],
            [38,9,'2015 All-State Chorus Auditions','2014 NJ All-State Chorus',2015],
            [39,16,'2018 All-State Treble Chorus Auditions','2018 NJ All-State Treble',2018],
            [43,19,'2019 New Jersey All-Shore Chorus','2019 All-Shore',2019],
            [44,12,'61st Annual Senior High Chorus','61st Senior',2019],
            [45,11,'57th Annual Junior High Chorus','57th Junior',2019],
            [46,1,'2019 Region II Chorus','2019 Region II Mixed',2019],
            [47,1,'2019 Region II Treble Chorus Auditions','2019 Treble Chorus',2019],
            [48,9,'2019 All-State Chorus','2019 All-State Chorus',2019],
            [49,9,'2019 All-State Treble Chorus','2019 All-State Treble',2019],
            [50,23,'2019-20 SJCDA Elementary Chorus','SJCDA Elem',2020],
            [51,11,'58th Annual Junior High Chorus','SJCDA Jr. High',2020],
            [52,12,'62nd Annual Senior High Chorus','SJCDA Sr. High',2020],
            [55,19,'2020 New Jersey All-Shore Chorus','2020 All-Shore',2020],
            [56,1,'2020 Region II Chorus','2020 Region II Mixed',2020],
            [57,1,'2020 Region II Treble Chorus Auditions','2020 Region II Treble',2020],
            [58,9,'2020 All-State Chorus','2020 All-State Chorus',2020],
            [59,9,'2020 All-State Treble Chorus','2020 All-State Treble Chorus',2020],
            [60,24,'Mass All-State','MMEA A-S',2020],
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
            DB::table('eventversions')->insert([
                'id' => $seed[0],
                'event_id' => $seed[1],
                'name' => $seed[2],
                'short_name' => $seed[3],
                'senior_class_of' => $seed[4],
                'created_at' => date('Y-m-d G:i:s', strtotime('NOW'))
            ]);
        } 
    }
}
