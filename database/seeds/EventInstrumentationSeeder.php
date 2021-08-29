<?php

use Illuminate\Database\Seeder;

class EventInstrumentationSeeder extends Seeder
{
    private $seeds;
    
    public function __construct() {
        $this->seeds = [
            'choral',
            'jazz band',
            'jazz choir',
            'orchestra',
            'none',
            'jr choral',
            'elementary',
            'mixes',
            'band',
            'wind ensemble',
            'instrumental'
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
            DB::table('eventinstrumentations')->insert([
                'descr' => $seed,
            ]);
        } 
    }
}
