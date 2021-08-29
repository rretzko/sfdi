<?php

use Illuminate\Database\Seeder;

class DateTypeSeeder extends Seeder
{
     private $seeds;
    
    public function __construct() {
        
        $this->seeds=[
            'admin_open',
            'admin_closed',
            'membership_open',
            'membership_closed',
            'student_open',
            'student_closed',
            'voice_change_open',
            'voice_change_closed',
            'signature_open',
            'signature_close',
            'score_open',
            'score_closed',
            'tab_closed',
            'results_released',
            'applications_closed',
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
            DB::table('date_types')->insert([
                'descr' => $seed,
            ]);
        } 
    }
}
