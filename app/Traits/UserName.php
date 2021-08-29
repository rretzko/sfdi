<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait UserName
{
    public function createUserName($first_name, $last_name) : string
    {
        $join = strtolower(substr($first_name,0,1).$last_name);
        $strip1 = str_replace(' ', '', $join);
        $strip2 = str_replace('-', '', $strip1);
        $strip3 = str_replace("'", '', $strip2);
        $strip4 = str_replace("&#39;", '', $strip3);
        $strip5 = str_replace("&#039;", '', $strip4);
        $test = $strip5;

        //while(DB::select('select id FROM users WHERE name=?',[$test])){
        while(DB::table('users')
                ->select('id')
                ->where('username',$test)
                ->value('id') ?? false){

            $suffix = random_int(10, 999);

            $test = $strip2.$suffix;
        }

        return $test;
    }
}
