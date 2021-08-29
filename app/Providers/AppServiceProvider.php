<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
    	 * since FJR 2020.01.03
    	 * added per https:/laravel-news.com/laravel-5-4-key-too-long-error
    	 * to correct problem with Maria db max length
    	 *
    	 * edit inclues adding: use Illuminate\Support\Facades\Schema;
    	 */
	    Schema::defaultStringLength(191);
        
        //phone number validator
        Validator::extend('phone_number', function($attribute, $value, $parameters){
        
            $strip = self::strip_Phone($value);
           
            return ((strlen($strip) > 9) && ctype_digit($strip));
            
        }, 'Please include your area code; the system expects at least 10 digits.');
    }
   

    private function strip_Phone($phone) : string
    {
        $str = '';
        
        if(strlen($phone)){
        
            foreach(str_split($phone) AS $char){
            
                if(is_int($char) || ctype_digit($char)){

                    $str .= $char;
                }
            }
        }
        
        return $str;
    }
}
