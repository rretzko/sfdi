<?php

use Illuminate\Database\Seeder;

class ShirtSizeSeeder extends Seeder
{
    private $seeds;
    public function __construct() {
        
        $this->seeds = [
            ['medium', 'M', 4],
            ['double extra small', 'XXS', 1],
            ['extra small', 'XS', 2],
            ['small', 'S', 3],
            ['large', 'L', 5],
            ['extra large', 'XL', 6],
            ['double extra large', 'XXL', 7]
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
            DB::table('shirt_sizes')->insert([
                'descr' => $seed[0],
                'abbr' => $seed[1],
                'order_by' => $seed[2]
            ]);
        } 
    }
}
