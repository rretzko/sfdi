<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instrumentation extends Model
{
    public function formattedDescr()
    {
        return $this->formatStringWithRomanNumerals($this->descr);
    }

    public function getUcwordsDescriptionAttribute() : string
    {
        return ucwords($this->descr);
    }

    public function students()
    {
        return $this->belongsToMany('App\Student', 'instrumentation_student',
            'instrumentation_id', 'student_user_id');
    }

    public function chorals()
    {
        return Instrumentation::orderBy('descr')
                ->where('branch', 'choral')
                ->get();
    }

    public function instrumentals()
    {
        return Instrumentation::orderBy('descr')
                ->where('branch', 'instrumental')
                ->get();
    }

    public function registrants()
    {
        return $this->belongsToMany(Registrant::class, 'instrumentation_registrant');
    }

    /**
     * Capitalize all words and uppercase all roman numerals
     * @param $str
     */
    private function formatStringWithRomanNumerals($str)
    {
        $fstr = '';

        foreach(explode(' ', $str) AS $item){

            $fstr .= ($this->isRomanNumeral($item))
                ? strtoupper($item).' '
                : ucwords($item).' ';
        }

        return trim($fstr);
    }

    private function isRomanNumeral($str) : bool
    {
        $rns = ['i', 'ii', 'iii', 'iv', 'v', 'vi', 'vii', 'viii', 'ix', 'x'];

        return in_array(strtolower($str), $rns);
    }
}
