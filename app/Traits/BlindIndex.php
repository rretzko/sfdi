<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait BlindIndex 
{
    /**
     * Create a blind index to be used for searching
     * 
     * NOTE: BlindIndex is case agnostic; all $str values = strtolower($str)
     * @param string $str
     * @return string
     */
    private function BlindIndex($str) : string
    {
        $hashable = strlen($str) ? strtolower($str) : '';
        
        return hash_hmac('sha256', $hashable, config('app.hashkey'));
        //return hash_hmac('sha256', $hashable, env('HASH_KEY', '19July1954'));
    }
    
    
}
