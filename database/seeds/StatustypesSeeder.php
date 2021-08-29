<?php

use Illuminate\Database\Seeder;

class StatustypesSeeder extends Seeder
{
    private $seeds;
    
    public function __construct(){
    
        $this->seeds = [
            'alert',
            'graduated', 
            'inactive', 
            'pending',
            'reviewed',
            'transferred', 
            'uploaded',
            'retired',
            'transferred'
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
            DB::table('statustypes')->insert([
                'descr' => $seed,
            ]);
        } 
    }
}
