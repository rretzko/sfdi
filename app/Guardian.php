<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Guardian extends Model
{
    protected $fillable = ['user_id'];
    protected $primaryKey = 'user_id';

    public function getEmailAlternateAttribute() : string
    {
        return Nonsubscriberemail::where('user_id', $this->user_id)
                ->where('emailtype_id', 6) //email_guardian_alternate
                ->first()
                ->email ?? '';
    }

    public function getEmailBlockAttribute() : string
    {
        $str = '<ul style="list-style-type: none;">';

        $str .= (strlen($this->getEmailPrimaryAttribute()))
            ? '<li>'.$this->getEmailPrimaryAttribute().'</li>'
            : '';

        $str .= (strlen($this->getEmailAlternateAttribute()))
            ? '<li>'.$this->getEmailAlternateAttribute().'</li>'
            : '';

        $str .= '</ul>';

        return $str;
    }

    public function getEmailPrimaryAttribute()
    {
        return Nonsubscriberemail::where('user_id', $this->user_id)
                ->where('emailtype_id', 7) //email_guardian_primary
                ->first()
                ->email ?? '';
    }

    public function getGuardiantypeDescriptionAttribute()
    {
        return Guardiantype::find($this->pivot->guardiantype_id)->first()->descr;
    }

    public function getPhoneBlockAttribute() : string
    {
        $str = '<ul style="list-style-type: none;">';

        $str .= (strlen($this->getPhoneMobileAttribute()))
            ? '<li>'.$this->getPhoneMobileAttribute().' (c)</li>'
            : '';

        $str .= (strlen($this->getPhoneHomeAttribute()))
            ? '<li>'.$this->getPhoneHomeAttribute().' (h)</li>'
            : '';

        $str .= (strlen($this->getPhoneWorkAttribute()))
            ? '<li>'.$this->getPhoneWorkAttribute().' (w)</li>'
            : '';

        $str .= '</ul>';

        return $str;
    }

    public function getPhoneHomeAttribute() : string
    {
        $phone = Phone::where('user_id', $this->user_id)
                ->where('phonetype_id', Phonetype::where('descr','phone_guardian_home')->first()->id) //phone_guardian_home
                ->first();

        return $phone ? $phone->formatPhoneNumber() : '';
    }

    public function getPhoneCellAttribute()
    {
        $phone = Phone::where('user_id', $this->user_id)
            ->where('phonetype_id', Phonetype::where('descr','phone_guardian_mobile')->first()->id)
            ->first();

        return $phone ? $phone->formatPhoneNumber() : '';
    }

    public function getPhoneMobileAttribute() : string
    {//dd($this->user_id);dd(Phone::where('user_id', $this->user_id)->get());
        return Phone::where('user_id', $this->user_id)
                ->where('phonetype_id', 6) //phone_guardian_mobile
                ->first()
                ->phone ?? '';
    }

    public function getPhoneWorkAttribute() : string
    {
        $phone = Phone::where('user_id', $this->user_id)
                ->where('phonetype_id', 7) //phone_guardian_work
                ->first();

        return $phone ? $phone->formatPhoneNumber() : '';
    }

    public function person()
    {
        return $this->belongsTo(Person::class, 'user_id', 'user_id');
    }

    public function students(){

        return $this->belongsToMany(Student::class, 'guardian_student', 'user_id', 'user_id')
            ->withPivot('guardiantype_id');
    }

    public function guardiantype_id($user_id)
    {
        return DB::table('guardian_student')
            ->select('guardiantype_id')
            ->where('guardian_user_id', $this->user_id)
            ->where('student_user_id', $user_id)
            ->value('guardiantype_id');
    }


}
