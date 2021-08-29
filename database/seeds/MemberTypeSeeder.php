<?php

use Illuminate\Database\Seeder;

class MemberTypeSeeder extends Seeder
{
    private $seeds;
    
    public function __construct() 
    {
        $this->seeds = [];
        
        $this->seeds = [
            [
                'descr' => 'member'
            ],
            [
                'descr' => 'director'
            ],
            [
                'descr' => 'student'
            ],
            [
                'descr' => 'parent'
            ],
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
            DB::table('member_types')->insert([
                'descr' => $seed['descr']
            ]);
        } 
    }
}
