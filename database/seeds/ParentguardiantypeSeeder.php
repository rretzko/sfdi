<?php

use Illuminate\Database\Seeder;

class ParentguardiantypeSeeder extends Seeder
{
    private $seeds;
    
    public function __construct(){
    
        $this->seeds = [
            ['mother', 1, 1],
            ['father', 2, 2],
            ['grandmother', 1, 3],
            ['grandfather', 2, 4],
            ['aunt', 1, 5],
            ['uncle', 2, 6],
            ['guardian_mother', 1, 7],
            ['guardian_father', 2, 8],
            ['step-mother', 1, 9],
            ['step-father', 2, 10],
            ['foster mother', 1, 11],
            ['foster father', 2, 12]
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
            DB::table('parentguardiantypes')->insert([
                'descr' => $seed[0],
                'pronoun_id' => $seed[1],
                'order_by' => $seed[2]
            ]);
        } 
    }
}
