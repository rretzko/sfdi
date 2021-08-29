<?php

namespace App;

use App\Email;
use App\Phone;
use App\Traits\BlindIndex;
use App\Traits\Encryptable;
use App\Traits\FormatPhone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Person extends Model
{
    use BlindIndex;
    use Encryptable;
    use FormatPhone;
    use SoftDeletes;

    protected $primaryKey = 'user_id';
    protected $encryptable = []; //encryptable fields
    /*    'first_name',
        'middle_name',
        'last_name'
        ];
*/
    protected $fillable = [
        'first',
        'last',
        'middle',
        'user_id',
    ];

    public $incrementing = false;

    public function address()
    {
        return $this->hasOne(Address::class, 'user_id', 'user_id');
    }
    public function emails()
    {
        return $this->hasMany(Nonsubscriberemail::class);
        /*
        return $this->belongsToMany(Email::class, 'email_person',
                'user_id', 'email_id')
                ->withTimestamps()
                ->withPivot('type');
        */
    }

    public function getEmailAlternateAttribute() : string
    {
        $email = self::getEmailAlternateObjectAttribute();

        return $email->email ?? '';
    }

    public function getEmailAlternateIdAttribute() : int
    {
        $email = self::getEmailAlternateObjectAttribute();

        return $email->id ?? 0;
    }

    public function getEmailAlternateObjectAttribute() : Email
    {
        return self::email_Object('alternate') ?? new Email;
    }

    public function getEmailAlternateVerifiedAttribute() : bool
    {
        $email = self::getEmailAlternateObjectAttribute();

        return ($email->verified === "1") ?? false;
    }

    public function getEmailBlockAttribute() : string
    {
        $emails = [];

        if(strlen(self::getEmailPrimaryAttribute())){
            $emails[] = self::getEmailPrimaryAttribute();
        }

        if(strlen(self::getEmailAlternateAttribute())){
            $emails[] = self::getEmailAlternateAttribute();
        }

        return implode('<br />', $emails);
    }

    /*public function getEmailFamilyAttribute() : string
    {
        return Email::where([
            ['user_id', $this->user_id],
            ['type', 'family']])->first()->email ?? '';
    }*/

    public function getEmailPrimaryAttribute() : string
    {
        $email = self::getEmailPrimaryObjectAttribute();

        return $email->email ?? '';
    }

    public function getEmailPrimaryIdAttribute() : int
    {
        $email = self::getEmailPrimaryObjectAttribute();

        return $email->id ?? 0;
    }

    public function getEmailPrimaryObjectAttribute() : Email
    {
        return self::email_Object('primary') ?? new Email;
    }

    public function getEmailPrimaryVerifiedAttribute() : bool
    {
        $email = self::getEmailPrimaryObjectAttribute();

        return ($email->verified === "1") ?? false;
    }

    public function getEmailStringAttribute() : string
    {
        return str_replace('<br />', ', ', $this->emailBlock);
    }

    public function getFullNameAttribute() : string
    {
        $middle = (strlen($this->middle))
                ? $this->middle.' '
                : '';

        return $this->first.' '
                . $middle
                . $this->last;
    }

    public function getFullNameAlphaAttribute() : string
    {
        return $this->last.', '.$this->first.' '.$this->middle;
    }

    /**
     * Provide pronoun descr with parenthetical (male/female/non-cis) suffix
     */
    public function getGenderDescrAttribute()
    {
        $p = Pronoun::find($this->pronoun_id);

        return $p->genderProxy;
    }

    /*private function IsEmailFamily($type)
    {
        $id = Email::where([
            ['user_id', $this->user_id],
            ['type', $type]])->first()->id ?? '';

        return DB::table('email_families')
                ->select('email_id')
                ->where('email_id',$id)
                ->value('email_id') ?? false;

    }

    public function getIsEmailFamilyAlternateAttribute()
    {
        return self::IsEmailFamily('alternate');
    }

    public function getIsEmailFamilyPrimaryAttribute()
    {
        return self::IsEmailFamily('primary');
    }
    */

    /**
     * Return missives by: status (alert/check) and then date descending
     * @return collection
     *
     */
    public function getMissivesLifoAttribute()
    {
        return Missive::where('sent_to_user_id', $this->user_id)
                ->orderBy('statustype_id', 'asc')
                ->orderBy('created_at', 'desc')
                ->get();
    }

    public function getPhoneBlockAttribute() : string
    {
        $phones = [];

        if(strlen(self::getPhoneHomeAttribute())){
            $phones[] = self::getPhoneHomeAttribute().' (h)';
        }

        if(strlen(self::getPhoneMobileAttribute())){
            $phones[] = self::getPhoneMobileAttribute().' (c)';
        }

        if(strlen(self::getPhoneWorkAttribute())){
            $phones[] = self::getPhoneWorkAttribute().' (w)';
        }

        return implode('<br />', $phones);
    }

    public function getPhoneHomeAttribute() : string
    {
        return self::formattedPhone('home');

    }

    public function getPhoneMobileAttribute() : string
    {
        return self::formattedPhone('mobile');
    }

    public function getPhoneStringAttribute() : string
    {
        return str_replace('<br />', ',  ', $this->phoneBlock);
    }

    public function getPhoneWorkAttribute() : string
    {
        return self::formattedPhone('work');
    }

    public function missives()
    {
        return $this->hasMany(Missive::class, 'sent_to_user_id', 'user_id');
    }

    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'organization_person', 'user_id', 'organization_id')
                ->withPivot('authorized')
                ->withTimestamps();
    }

    public function pronoun()
    {
        return $this->hasOne(Pronoun::class, 'id', 'pronoun_id');
    }

    public function parentguardian()
    {
        return $this->hasOne(ParentGuardian::class, 'user_id');
    }

    public function phones()
    {
        return $this->belongsToMany(Phone::class, 'person_phone',
                'user_id', 'phone_id')
                ->withTimestamps()
                ->withPivot('type');
    }

    public function getPronounDescrAttribute()
    {
        return Pronoun::where('id', $this->pronoun_id)
                ->value('descr');
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'user_id');
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

/** END OF PUBLIC FUNCTIONS ***************************************************/

    /**
     *
     * @param string $type = alternate/primary
     * @return Email
     */
    private function email_Object($type) : Email
    {
        $email = new Email;

        return Email::find(
                DB::table('email_person')
                ->select('email_id')
                ->where([
                    ['user_id', $this->user_id],
                    ['type', $type]
                ])
                ->value('email_id')
                ) ?? $email->blank_Email();
    }

    private function formattedPhone($type) : string
    {
        $a = [];
        foreach($this->phones AS $phone){

            if($phone->pivot->type === $type){

                return self::FormatPhone($phone->phone) ?? '';
            }
        }

        return $this->phones[0]->phone ?? ''; //'';

    }


}
