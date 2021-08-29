<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Userconfig extends Model
{
    static public function breadcrumbsValue()
    {
        self::get_Value('breadcrumbs');
    }

    static public function eventversionValue()
    {
        return self::get_Value('eventversion') ?: self::set_Value('eventversion');
    }

    static public function eventversionFilterValue()
    {
        return self::get_Value('eventversion_filter') ?: self::set_Value('eventversion_filter', 'qualified');
    }

    static public function schoolValue()
    {
        return self::get_Value('school') ?: self::set_Value('school');
    }

    static public function studentRosterFilterValue()
    {
        return self::get_Value('student_roster_filter') ?: self::set_Value('student_roster_filter', 'all');
    }

    static public function unsetBreadcrumbs()
    {
        if(strlen(self::breadcrumbsValue())){

            self::update_Value('breadcrumbs', '');
        }
    }

    static public function update_Value($property, $value)
    {
        return DB::table('userconfigs')
                ->where([
                    'user_id' => auth()->user()->id,
                    'property' => $property,
                    ])
                ->update(['value' => $value,]);
    }

/** END OF PUBLIC FUNCTIONS ***************************************************/

    static private function get_Value($property) : string
    {
        $defaults = [
            'breadcrumbs' => '',
            'eventversion' => 0,
            'eventversion_filter' => 'qualified',
            'school' => 0,
            'student_roster_filter' => 'all',
        ];

        $value = DB::table('userconfigs')->where([
            'user_id' => auth()->user()->id,
            'property' => $property,
        ])->value('value');

        return ($value) ?: self::set_Value($property, $defaults[$property]);

    }

    static private function register_Error($location, $mssg){

        error.log('*** FJR: '.date('Y-n-d G:i:s').': '.$location.': '.$mssg);
    }

    static private function set_Value($property, $value) : string
    {
        $method = __FUNCTION__.'_'.ucwords($property);

        return (method_exists(Userconfig::class, $method))
                ? self::$method()
                : self::set_Value_Default($property, $value);
    }

    /**
     * @since 2020.08.10
     */
    private static function set_Value_Default($property, $value)
    {
        if(auth()->user()->id){

            DB::table('userconfigs')->insert([
                'user_id' => auth()->user()->id,
                'property' => $property,
                'value' => $value,
            ]);

            return self::get_Value($property);

        }else{

            $mssg = 'Unknown user attempting to access restricted settings.';
            self::register_Error(__CLASS__.': '.__FUNCTION__, $mssg);

            return false;
        }
    }

    /**
     * Use 'all' as default value
     */
    private static function Xset_Value_Student_Roster_Filter()
    {
        //ensure user is a teacher
        $teacher = \App\Teacher::find(auth()->user()->id);

        if($teacher->user_id){
            DB::table('userconfigs')->insert([
                'user_id' => $teacher->user_id,
                'property' => 'student_roster_filter',
                'value' => 'all',
            ]);
        }else{

            $mssg = 'Unknown TEACHER attempting to access restricted settings.';
            self::register_Error(__CLASS__.': '.__FUNCTION__, $mssg);
        }

        return true;
    }

    /**
     * Use first school of current user's schools collection as default value
     */
    private static function set_Value_School()
    {
        $teacher = \App\Teacher::find(auth()->user()->id);
        $school_id = 0; //default

        //ensure user is a teacher
        if($teacher->user_id){
            $school = $teacher->schools->first();


            DB::table('userconfigs')->insert([
                'user_id' => $teacher->user_id,
                'property' => 'school',
                'value' => $school->id,
            ]);

            $school_id = $school->id;

        }else{

            $mssg = 'Unknown TEACHER attempting to access restricted settings.';
            self::register_Error(__CLASS__.': '.__FUNCTION__, $mssg);
        }

        return $school_id;
    }

    /**
     * Use version school of current user's versions collection as default value
     */
    private static function set_Value_Eventversion()
    {
        $teacher = \App\Teacher::find(auth()->user()->id);
        $default = 1;

        //ensure user is a teacher
        if($teacher->user_id){

            DB::table('userconfigs')->insert([
                'user_id' => $teacher->user_id,
                'property' => 'eventversion',
                'value' => $default,
            ]);

        }else{

            $mssg = 'Unknown TEACHER attempting to access restricted settings.';
            self::register_Error(__CLASS__.': '.__FUNCTION__, $mssg);
        }

        return $default;
    }
}
