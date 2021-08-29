<?php

use Illuminate\Database\Seeder;

class PronounsTableSeeder extends Seeder
{
    private $seeds;
    
    public function __construct() {
        
        $this->seeds = [
            [
                'descr' => 'she/her/hers/herself',
                'intensive' => 'herself',
                'personal' => 'she',
                'possessive' => 'her',
                'object' => 'her',
                'order_by' => 1
            ],
            [
                'descr' => 'he/him/his/himself',
                'intensive' => 'himself',
                'personal' => 'he',
                'possessive' => 'his',
                'object' => 'hem',
                'order_by' => 2
            ],
            [
                'descr' => '(f)ae/(f)aer/(f)aers/(f)aerself',
                'intensive' => '(f)aerself',
                'personal' => '(f)ae',
                'possessive' => '(f)aers',
                'object' => '(f)aers',
                'order_by' => 3
            ],
            [
                'descr' => 'e/ey/em/eir/eirs/eirself',
                'intensive' => 'eirself',
                'personal' => 'e',
                'possessive' => 'eirs',
                'object' => 'eirs',
                'order_by' => 4
            ],
            [
                'descr' => 'per/pers/perself',
                'intensive' => 'perself',
                'personal' => 'per',
                'possessive' => 'pers',
                'object' => 'pers',
                'order_by' => 5
            ],
            [
                'descr' => 'they/them/their/theirs/themself',
                'intensive' => 'themself',
                'personal' => 'they',
                'possessive' => 'theirs',
                'object' => 'theirs',
                'order_by' => 6
            ],
            [
                'descr' => 've/ver/vis/verself',
                'intensive' => 'verself',
                'personal' => 've',
                'possessive' => 'vis',
                'object' => 'vis',
                'order_by' => 7
            ],
            [
                'descr' => 'xe/xem/xyr/xyrs/xemself',
                'intensive' => 'xemself',
                'personal' => 'xem',
                'possessive' => 'xyrs',
                'object' => 'xyrs',
                'order_by' => 8
            ],
            [
                'descr' => 'ze/zie/hir/hirs/hirself',
                'intensive' => 'hirself',
                'personal' => 'ze',
                'possessive' => 'hirs',
                'object' => 'hirs',
                'order_by' => 9
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
            DB::table('pronouns')->insert([
                'descr' => $seed['descr'],
                'intensive' => $seed['intensive'],
                'personal' => $seed['personal'],
                'possessive' => $seed['possessive'],
                'object' => $seed['object'],
                'order_by' => $seed['order_by']
            ]);
        } 
    }
}
