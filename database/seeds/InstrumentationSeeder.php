<?php

use Illuminate\Database\Seeder;

class InstrumentationSeeder extends Seeder
{
    private $seeds;
    
    public function __construct() 
    {
        /* @cite https://imslp.org/wiki/IMSLP:Abbreviations_for_Instruments */
        $this->seeds = [
            ['alto', 'alt', 'choral'],
            ['baritone', 'bar', 'choral'],
            ['bass', 'bass', 'choral'],
            ['bass baritone', 'bbar', 'choral'],
            ['soprano', 'sop', 'choral'],
            ['tenor', 'ten', 'choral'],
            ['accordion', 'acc', 'instrumental'],
            ['alto flute', 'afl', 'instrumental'],
            ['bagpipe', 'bag', 'instrumental'],
            ['continuo', 'bc', 'instrumental'],
            ['bass clarinet', 'bcl', 'instrumental'],
            ['bell chimes', 'bell', 'instrumental'],
            ['bass flute', 'bfl', 'instrumental'],
            ['bass guitar', 'bgtr', 'instrumental'],
            ['banjo', 'bjo', 'instrumental'],
            ['bassoon', 'bn', 'instrumental'],
            ['bass oboe', 'bob', 'instrumental'],
            ['bugle', 'bug', 'instrumental'],
            ['contrabass clarinet', 'cbcl', 'instrumental'],
            ['contrabassoon', 'cbn', 'instrumental'],
            ['celesta', 'cel', 'instrumental'],
            ['clarinet', 'cl', 'instrumental'],
            ['cornet', 'crt', 'instrumental'],
            ['double bass', 'db', 'instrumental'],
            ['dulcimer', 'dulc', 'instrumental'],
            ['electric guitar', 'egtr', 'instrumental'],
            ['english horn', 'eh', 'instrumental'],
            ['euphonium', 'euph', 'instrumental'],
            ['flugelhorm', 'fgh', 'instrumental'],
            ['fife', 'fife', 'instrumental'],
            ['flute', 'fl', 'instrumental'],
            ['glockenspiel', 'gl', 'instrumental'],
            ['guitar', 'gtr', 'instrumental'],
            ['harmonica', 'hca', 'instrumental'],
            ['horn', 'hn', 'instrumental'],
            ['harp', 'hp', 'instrumental'],
            ['mandolin', 'mand', 'instrumental'],
            ['marimba', 'mar', 'instrumental'],
            ['oboe', 'ob', 'instrumental'],
            ['organ', 'org', 'instrumental'],
            ['percussion', 'perc', 'instrumental'],
            ['piano', 'pf', 'instrumental'],
            ['piccolo', 'picc', 'instrumental'],
            ['timpani', 'timp', 'instrumental'],
            ['recorder', 'rec', 'instrumental'],
            ['saxophone', 'sax', 'instrumental'],
            ['tuba', 'tba', 'instrumental'],
            ['trombone', 'tbn', 'instrumental'],
            ['theremin', 'thrm', 'instrumental'],
            ['trumpet', 'tpt', 'instrumental'],
            ['ukelele', 'uke', 'instrumental'],
            ['viola', 'va', 'instrumental'],
            ['cello', 'vc', 'instrumental'],
            ['vibraphone', 'vib', 'instrumental'],
            ['violin', 'vn', 'instrumental'],
            ['xlyophone', 'xyl', 'instrumental'],
            ['zither', 'zith', 'instrumental'],
            ['alto saxophone', 'asax', 'instrumental'],
            ['baritone saxophone', 'brsx', 'instrumental'],
            ['bass saxophone', 'basx', 'instrumental'],
            ['tenor saxophone', 'tsax', 'instrumental'],
            ['soprano saxophone', 'ssax', 'instrumental'],
            ['soprano i', 'si', 'choral'],
            ['soprano ii', 'sii', 'choral'],
            ['alto i', 'ai', 'choral'],
            ['alto ii', 'aii', 'choral'],
            ['tenor i', 'ti', 'choral'],
            ['tenor ii', 'tii', 'choral'],
            ['bass i', 'bi', 'choral'],
            ['bass ii', 'bii', 'choral'],
            
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
            DB::table('instrumentations')->insert([
                'descr' => $seed[0],
                'abbr' => $seed[1],
                'branch' => $seed[2]
            ]);
        } 
    }
}
