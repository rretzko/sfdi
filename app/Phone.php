<?php

namespace App;

use App\Person;
use App\Traits\BlindIndex;
use App\Traits\Encryptable;
use App\Traits\FormatPhone;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Phone extends Model
{
    use Encryptable;
    use FormatPhone;
    use SoftDeletes;
    use BlindIndex;

    protected $encryptable = [ //encryptable fields
        'phone'
        ];

    protected $fillable = [
        'user_id',
        'phone',
        'phonetype_id',
        ];

    public function add($phone, Person $person, $type)
    {
        self::find_Or_Create($phone, $person, $type);
    }

    /**
     * Delete all links to $person phone
     *
     * @return bool
     */
    public function clearAllLinks(Person $person)
    {
        return DB::table('person_phone')
                ->where('user_id', '=', $person->user_id)
                ->delete();
    }

    //return formatted phone (###) ###-#### [x####]
    public function formatPhoneNumber()
    {
        $phone = $this->phone;

        if((strpos($phone, '(') === 0) &&
           (strpos($phone, ')') === 4) &&
           (strpos($phone, ' ') === 5) &&
           (strpos($phone, '-') === 9)){

            return $phone;
        }

        $stripped = self::stripPhone($phone);

        switch(strlen($stripped)){

            case (strlen($stripped) < 7):
            case '0';
                return '';

            case '7':
                return substr($stripped, 0, 3).'-'.substr($stripped, 3); //###-####

            case '10':
                return '('.substr($stripped, 0, 3).') '
                    .substr($stripped, 3, 3).'-'
                    .substr($stripped, 6); //(###) ###-####

            default:

                return '('.substr($stripped, 0, 3).') '
                    .substr($stripped, 3, 3).'-'
                    .substr($stripped, 6, 4)
                    .' x'.substr($stripped, 10); //(###) ###-#### x###
        }

        return $stripped;
    }

    public function people()
    {
        return $this->belongsToMany(Person::class, 'person_phone',
                'phone_id', 'user_id')
                ->withTimestamps()
                ->withPivot('type');
    }

/** END OF PUBLIC FUNCTIONS ***************************************************/

    private function add_New_Phone($phone, $blind_index=null){

        if(! $this->id){
            $this->phone = $phone;
            $this->blind_index = (($blind_index) ?: self::BlindIndex($phone));
            $this->save();
        }
    }

    private function add_New_Phone_Link(Person $person, $type)
    {
        DB::table('person_phone')->insert([
            'phone_id' => $this->id,
            'user_id' => $person->user_id,
            'type' => $type,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    private function find_Or_Create($phone, Person $person, $type)
    {
        $blind_index = self::BlindIndex($phone);

        //search for existing email
        $this->id = DB::table('phones')
                ->select('id')
                ->where('blind_index', '=', $blind_index)
                ->value('id');

        //create a new email if none found or $test_id passes teacher challenge
        if(! $this->id){

            self::add_New_Phone($phone, $blind_index);
        }

        self::add_New_Phone_Link($person, $type);
    }

}
