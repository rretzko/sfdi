<?php

use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    private $seeds;
    
    public function __construct() {
        $this->seeds = [
            [3, 'Central Jersey Music Educators Association', 'CJMEA', '', 'cjmeaLogo.png', 'CHMEA Region II MIxed and Treble Chorus'],
            [5, 'New Jersey - American Choral Directors Association', 'NJ ACDA', '', '', ''],
            [4, 'New Jersey Music Educators Association', 'NJMEA', '', 'njmeaLogo_Transparent.png', 'NJMEA Logo'],
            [0, 'National Association for Music Education', 'NAfME', '', 'NAfME_cropped.jpg', 'NAfME Logo'],
            [0, 'American Choral Directors Association', 'ACDA', '', '', ''],
            [3, 'North Jersey School Music Association', 'NJSMA', '', '', ''],
            [3, 'South Jersey Band and Orchestra Directors Association', 'SJBODA', '', '', ''],
            [3, 'South Jersey Choral Directors Association', 'SJCDA', '', 'sjcdaLogo_transparent.png', 'SJCDA Logo'],
            [0, 'New Jersey All-Shore Chorus', 'NJASC', '', 'logo_all_shore.png', 'NJ All-Shore Chorus'],
            [3, 'Massachusetts Music Educators Association', 'MMEA', '', '', '']
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
            DB::table('organizations')->insert([
                'parent_id' => $seed[0],
                'organization_name' => $seed[1],
                'abbr' => $seed[2],
                'bio' => $seed[3],
                'logo_file' => $seed[4],
                'logo_file_alt' => $seed[5],
            ]);
        } 
    }
}
