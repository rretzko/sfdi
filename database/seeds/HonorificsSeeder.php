<?php

use Illuminate\Database\Seeder;

class HonorificsSeeder extends Seeder
{
    private $seeds;
    
    public function __construct()
    {
        $this->seeds = [
            [
                'descr' => 'Ms.',
                'abbr' => 'Ms.',
                'order_by' => 1
            ],
            [
              'descr' => 'Misses',
              'abbr' => 'Mrs.',
              'order_by' => 2
            ],
            [
                'descr' => 'Mister',
                'abbr' => 'Mr.',
                'order_by' => 3
            ],
            [
              'descr' => 'Doctor',
              'abbr' => 'Dr.',
              'order_by' => 4
            ],
            [
              'descr' => 'Sister',
              'abbr' => 'Sr.',
              'order_by' => 5
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
            DB::table('honorifics')->insert([
                'descr' => $seed['descr'],
                'abbr' => $seed['abbr'],
                'order_by' => $seed['order_by']
            ]);
        } 
    }
}
